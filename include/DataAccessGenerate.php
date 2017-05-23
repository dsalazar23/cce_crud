<?php

/**
 * Permite generar automáticamente las clases DAO y los DTO de acuerdo al estado
 * de la base de datos.
 *
 * @package     include
 * @author      JpBaena13
 * @since       PHP 5
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)) . DS);
define('DATA_SOURCE', ROOT . 'Config' . DS . 'DataSource' . DS);
define('DATA_ACCESS', ROOT . 'DataAccess' . DS);
define('MODEL_CLASS_PATH', ROOT . 'Model' . DS);
define('LIB', ROOT . 'Lib' . DS);
define('TEMPLATES', LIB . 'Templates' . DS);
define('INCLD', ROOT . 'include' . DS);


require_once(DATA_SOURCE . 'Connection.class.php');
require_once(DATA_SOURCE . 'ConnectionFactory.class.php');
require_once(DATA_SOURCE . 'ConnectionProperty.class.php');
require_once(DATA_SOURCE . 'QueryExecutor.class.php');
require_once(DATA_SOURCE . 'SqlQuery.class.php');
require_once(DATA_SOURCE . 'Transaction.class.php');

require_once(LIB .'Template.class.php');

/**
 * Función principal del Archivo, ejecuta todas las funciones de auto-generated.
 */
    function generate($flag = false) {
        
        //Obteniendo todas las tablas de la base de datos configurada
        $tables = QueryExecutor::execute(new SqlQuery('show TABLES'));
        
        if (!$flag) {
            createFolders();
            generateDTOObjects($tables);
            generateInterfaceDAOObjects($tables);
            generateGenDAOObjects($tables);
            generateGenDAOObjectsMg($tables);
            generateDAOObjects($tables);
            generateModelObjects($tables);
        }
        createFactoryDAO($tables);
        createIncludeFile($tables);
        
        echo "<h3>Creación de Acceso a Datos Terminada Exitosamente</h3>";
    }

/**
 * Crea las carpetas sobre el servidor
 */
    function createFolders() {
        @mkdir(DATA_ACCESS . 'DTO');
        @mkdir(DATA_ACCESS . 'DAO');
        @mkdir(DATA_ACCESS . 'DAO' . DS . 'interfaces');
        @mkdir(MODEL_CLASS_PATH . 'genModel');
        @mkdir(DATA_ACCESS . 'DAO' . DS . 'mysql');
        @mkdir(DATA_ACCESS . 'DAO' . DS . 'mysql' . DS .'gen');
        @mkdir(DATA_ACCESS . 'DAO' . DS . 'mongodb');
        @mkdir(DATA_ACCESS . 'DAO' . DS . 'mongodb' . DS .'gen');
    }

/**
 * Genera las DTO para cada tabla de la base de datos.
 *
 * @param array $tables
 *        Conjunto de tablas de la base de datos a las que se le crearán el DTO.
 */
    function generateDTOObjects($tables) {
        for ($i = 0; $i < count($tables); $i++) {

            if (!doesTableContainPK($tables[$i])) {
                continue;
            }

            $tableName = $tables[$i][0];
            $className = getClassName($tableName);
            
            $template = new Template(TEMPLATES . 'DTO.tpl');
            $template->set('domain_class_name', $className);
            $template->set('table_name', $tableName);
            $tab = getFields($tableName);
            $fields = "\r\n";
            $dates = '';
            
            
            //Seleccionando Comentarios de tabla
            $sql = 'select COLUMN_COMMENT from INFORMATION_SCHEMA.COLUMNS  where 
                TABLE_SCHEMA = "' . ConnectionProperty::getDatabase() . '" and TABLE_NAME = "' . $tables[$i][0] . '"';

            $comments = QueryExecutor::execute(new SqlQuery($sql));

            for ($j = 0; $j < count($tab); $j++) {
                if ($comments) {
                    $comment = str_replace("\n", "\n\t", $comments[$j][0]);
                    $fields .= "\t/** " . $comment . " */\n";
                }
                if ($tab[$j][4] == ''){
                    $fields .= "\tvar $" . getVarNameWithS($tab[$j][0]) . ";\n\r\n\r";
                    if ($tab[$j]['Type'] == 'datetime') {
                        $dates .= '$this->' . getVarNameWithS($tab[$j][0]) . " = date('Y-m-d H:i:s');\n\t";
                    }                    
                } else {
                    if (is_numeric($tab[$j][4]))
                        $fields .= "\tvar $" . getVarNameWithS($tab[$j][0]) . 
                            " = " . $tab[$j][4] . ";\n\r\n\r";
                    else
                        $fields .= "\tvar $" . getVarNameWithS($tab[$j][0]) . 
                            " = '" . $tab[$j][4] . "';\n\r\n\r";
                }
            }

            $template->set('variables', $fields);
            $template->set('dates', $dates);
            $template->write(DATA_ACCESS . 'DTO' . DS . $className . 'DTO.class.php');
        }
    }

/**
 * Permite generar las interfaces *DAOInterface para cada tabla de la base de datos.
 *
 * @param array $tables
 *        Conjunto de tablas de la base de datos a las que se le crearán el
 *        *DAOInterface.
 */
    function generateInterfaceDAOObjects($table) {

        for ($i = 0; $i < count($table); $i++) {

            if (!doesTableContainPK($table[$i])) {
                continue;
            }

            $tableName = $table[$i][0];
            $className = getClassName($tableName);
            $tab = getFields($tableName);
            $parameterSetter = "\n";
            $insertFields = "";
            $updateFields = "";
            $questionMarks = "";
            $readRow = "\n";
            $pk = array();
            $queryByField = '';
            $deleteByField = '';

            for ($j = 0; $j < count($tab); $j++) {

                if ($tab[$j][3] == 'PRI') {
                    $c = count($pk);
                    $pk[$c] = $tab[$j][0];

                } else {
                    $insertFields .= $tab[$j][0] . ", ";
                    $updateFields .= $tab[$j][0] . " = ?, ";
                    $questionMarks .= "?, ";

                    if (isColumnTypeNumber($tab[$j][1])) {
                        $parameterSetter .= "\t\t\$sqlQuery->setNumber($" . 
                                getVarName($tableName) . "->" . 
                                getVarNameWithS($tab[$j][0]) . ");\n";
                    } else {
                        $parameterSetter .= "\t\t" . '$sqlQuery->set($' . 
                                getVarName($tab[$j][0]) . ');' . "\n";
                    }

                    $queryByField .= "public function queryBy" . 
                            getMethodName($tab[$j][0]) . "(\$value);\n\n    ";
                    
                    $deleteByField .= "public function deleteBy" . 
                            getMethodName($tab[$j][0]) . "(\$value);\n\n    ";
                }

                $readRow .= "\t\t\$" . getVarName($tableName) . "->" . 
                        getVarNameWithS($tab[$j][0]) . " = \$row['" . $tab[$j][0] . "'];\n";
            }

            if (sizeof($pk) == 0) {
                continue;
            }

            $template = new Template(TEMPLATES . 'IDAO.tpl');

            $template->set('dao_class_name', $className);
            $template->set('table_name', $tableName);
            $template->set('var_name', getVarName($tableName));

            $s = '';
            $s2 = '';
            $s3 = '';
            $s4 = '';
            $insertFields2 = $insertFields;
            $questionMarks2 = $questionMarks;

            for ($z = 0; $z < count($pk); $z++) {
                $questionMarks2.=', ?';
                if ($z > 0) {
                    $s.=', ';
                    $s2.=' AND ';
                    $s3.= "\t\t";
                }
                $insertFields2.=', ' . getVarNameWithS($pk[$z]);
                $s .= '$' . getVarNameWithS($pk[$z]);
                $s2 .= getVarNameWithS($pk[$z]) . ' = ? ';
                $s3 .= '$sqlQuery->setNumber(' . getVarName($pk[$z]) . ');';
                $s3 .= "\n";
                $s4 .= "\n\t\t";
                $s4 .= '$sqlQuery->setNumber($' . getVarName($tableName) . '->' . 
                        getVarNameWithS($pk[$z]) . ');';
                $s4 .= "\n";
            }

            $template->set('question_marks2', $questionMarks2);
            $template->set('insert_fields2', $insertFields2);
            $template->set('pk_set_update', $s4);
            $template->set('pk_set', $s3);
            $template->set('pk_where', $s2);
            $template->set('pk', $s);

            $insertFields = substr($insertFields, 0, strlen($insertFields) - 2);
            $updateFields = substr($updateFields, 0, strlen($updateFields) - 2);
            $questionMarks = substr($questionMarks, 0, strlen($questionMarks) - 2);

            $template->set('insert_fields', $insertFields);
            $template->set('read_row', $readRow);
            $template->set('update_fields', $updateFields);
            $template->set('question_marks', $questionMarks);
            $template->set('parameter_setter', $parameterSetter);
            $template->set('read_row', $readRow);
            $template->set('queryByFieldFunctions', $queryByField);
            $template->set('deleteByFieldFunctions', $deleteByField);
            $template->write(DATA_ACCESS . 'DAO' .DS . 'interfaces' . DS . 
                    $className . 'DAO.interface.php');
        }
    }

/**
 * Permite generar las clases *MsDAO para cada tabla de la base de datos.
 *
 * @param array $tables
 *        Conjunto de tablas de la base de datos a las que se le crearán el MsDAO.
 */
    function generateGenDAOObjects($tables) {

        for ($i = 0; $i < count($tables); $i++) {

            if (!doesTableContainPK($tables[$i])) {
                continue;
            }

            // Definiendo variables para todas las acciones a realizar.
            $tableName = $tables[$i][0];
            $className = getClassName($tableName);
            $tab = getFields($tableName);
            $parameterSetter = "\n\t";
            $insertFields = "";
            $updateFields = "";
            $questionMarks = "";
            $readRow = "\n";
            $pk = array();
            $queryByField = '';
            $deleteByField = '';
            $pk_type = array();

            for ($j = 0; $j < count($tab); $j++) {
                if ($tab[$j][3] == 'PRI') {
                    $c = count($pk);
                    $pk[$c] = $tab[$j][0];
                    $pk_type[$c] = $tab[$j][1];
                } else {
                    $insertFields .= '`' . $tab[$j][0] . '`' . ", ";
                    $updateFields .= '`' . $tab[$j][0] . '`' . " = ?, ";
                    $questionMarks .= "?, ";            
                    $parameterSetter2 = '';

                    if (isColumnTypeNumber($tab[$j][1])) {
                        $parameterSetter .= "\t\$sqlQuery->setNumber($" . 
                                getVarName($tableName) . "DTO->" . 
                                getVarNameWithS($tab[$j][0]) . ");\n\t";
                        
                        $parameterSetter2 .= "Number";
                    } else {
                        $parameterSetter .= "\t\$sqlQuery->set($" . 
                                getVarName($tableName) . "DTO->" . 
                                getVarNameWithS($tab[$j][0]) . ");\n\t";
                    }

                    if ($tab[$j][3] == 'UNI')
                        $return = 'return $this->getRow($sqlQuery);';
                    else
                        $return = 'return $this->getList($sqlQuery);';

                    $queryByField .= "public function queryBy" . 
                            getMethodName($tab[$j][0]) . "(\$value) {
        \$sql = 'SELECT * FROM " . $tableName . " WHERE " . $tab[$j][0] . " = ?';
        \$sqlQuery = new SqlQuery(\$sql);
        \$sqlQuery->set" . $parameterSetter2 . "(\$value);\n
        " . $return . "
    }\n\n    ";

                    $deleteByField .= "public function deleteBy" . 
                            getMethodName($tab[$j][0]) . "(\$value){
        \$sql = 'DELETE FROM " . $tableName . " WHERE " . $tab[$j][0] . " = ?';
        \$sqlQuery = new SqlQuery(\$sql);
        \$sqlQuery->set" . $parameterSetter2 . "(\$value);\n
        return \$this->executeUpdate(\$sqlQuery);
    }\n\n    ";

                }

                $readRow .= "\t\t\$" . getVarName($tableName) . "DTO->" . 
                        getVarNameWithS($tab[$j][0]) . " = \$row['" . $tab[$j][0] . "'];\n";
            }

            if (count($pk) == 0) {
                continue;
            }

            $template = new Template(TEMPLATES . 'DAOGen.tpl');

            $template->set('dao_class_name', 'gen' . $className . 'Ms');
            $template->set('domain_class_name', getClassName($tableName));
            $template->set('idao_class_name', getClassName($tableName));
            $template->set('table_name', $tableName);
            $template->set('var_name', getVarName($tableName));

            $insertFields = substr($insertFields, 0, strlen($insertFields) - 2);
            $updateFields = substr($updateFields, 0, strlen($updateFields) - 2);
            $questionMarks = substr($questionMarks, 0, strlen($questionMarks) - 2);

            $s = '';
            $s2 = '';
            $s3 = '';
            $s4 = '';
            $insertFields2 = $insertFields;
            $questionMarks2 = $questionMarks;

            for ($z = 0; $z < count($pk); $z++) {
                $questionMarks2.=', ?';

                if ($z > 0) {
                    $s.=', ';
                    $s2.=' AND ';
                    $s3.= "\t";
                }

                $insertFields2.=', ' . $pk[$z];
                $s .= '$' . getVarNameWithS($pk[$z]);
                $s2 .= $pk[$z] . ' = ? ';
                
                if (isColumnTypeNumber($pk_type[$z])) {
                    $s3 .= '$sqlQuery->setNumber($' . getVarNameWithS($pk[$z]) . ');';
                    $s3 .= "\n\t";
                    $s4 .= '$sqlQuery->setNumber($' . getVarName($tableName) . 
                            'DTO->' . getVarNameWithS($pk[$z]) . ');';
                    $s4 .= "\n\t";
                } else {
                    $s3 .= '$sqlQuery->set($' . getVarNameWithS($pk[$z]) . ');';
                    $s3 .= "\n\t";
                    $s4 .= '$sqlQuery->set($' . getVarName($tableName) . 
                            'DTO->' . getVarNameWithS($pk[$z]) . ');';
                    $s4 .= "\n\t";
                }
            }

            if ($s[0] == ',')
                $s = substr($s, 1);

            if ($questionMarks2[0] == ',')
                $questionMarks2 = substr($questionMarks2, 1);

            if ($insertFields2[0] == ',')
                $insertFields2 = substr($insertFields2, 1);

            $template->set('question_marks2', $questionMarks2);
            $template->set('insert_fields2', $insertFields2);
            $template->set('pk_set_update', $s4);
            $template->set('pk_set', $s3);
            $template->set('pk_where', $s2);
            $template->set('pk', $s);
            $template->set('insert_fields', $insertFields);
            $template->set('read_row', $readRow);
            $template->set('update_fields', $updateFields);
            $template->set('question_marks', $questionMarks);
            $template->set('parameter_setter', $parameterSetter);
            $template->set('read_row', $readRow);
            $template->set('queryByFieldFunctions', $queryByField);
            $template->set('deleteByFieldFunctions', $deleteByField);
            $template->write(DATA_ACCESS . 'DAO' . DS . 'mysql' . DS . 
                    'gen' . DS . 'gen' . $className . 'MsDAO.class.php');
        }
    }

/**
 * Permite generar las clases *MsDAO para cada tabla de la base de datos.
 *
 * @param array $tables
 *        Conjunto de tablas de la base de datos a las que se le crearán el MsDAO.
 */
    function generateGenDAOObjectsMg($tables) {

        for ($i = 0; $i < count($tables); $i++) {

            if (!doesTableContainPK($tables[$i])) {
                continue;
            }

            // Definiendo variables para todas las acciones a realizar.
            $tableName = $tables[$i][0];
            $className = getClassName($tableName);
            $tab = getFields($tableName);
            $parameterSetter = "\n\t";
            $insertFields = "";
            $updateFields = "";
            $questionMarks = "";
            $readRow = "\n";
            $pk = array();
            $queryByField = '';
            $deleteByField = '';
            $pk_type = array();

            for ($j = 0; $j < count($tab); $j++) {
                if ($tab[$j][3] == 'PRI') {
                    $c = count($pk);
                    $pk[$c] = $tab[$j][0];
                    $pk_type[$c] = $tab[$j][1];
                } else {
                    $insertFields .= '`' . $tab[$j][0] . '`' . ", ";
                    $updateFields .= '`' . $tab[$j][0] . '`' . " = ?, ";
                    $questionMarks .= "?, ";            
                    $parameterSetter2 = '';

                    if (isColumnTypeNumber($tab[$j][1])) {
                        $parameterSetter .= "\t\$sqlQuery->setNumber($" . 
                                getVarName($tableName) . "DTO->" . 
                                getVarNameWithS($tab[$j][0]) . ");\n\t";
                        
                        $parameterSetter2 .= "Number";
                    } else {
                        $parameterSetter .= "\t\$sqlQuery->set($" . 
                                getVarName($tableName) . "DTO->" . 
                                getVarNameWithS($tab[$j][0]) . ");\n\t";
                    }

                    $find = 'find';

                    if ($tab[$j][3] == 'UNI') {
                        $return = 'return $this->readRow( $cursor );';
                        $find = 'findOne';
                    } else {
                        $return = 'return $this->getList( $cursor );';
                    }

                    $queryByField .= "public function queryBy" . 
                            getMethodName($tab[$j][0]) . "(\$value) {
        \$db = Connection::getDatabase();
        \$collection = \$db->" . $tableName . ";
        \$cursor = \$collection->" . $find . "( array('" . $tab[$j][0] . "' => \$value) );\n
        " . $return . "
    }\n\n    ";

                    $deleteByField .= "public function deleteBy" . 
                            getMethodName($tab[$j][0]) . "(\$value){
        \$db = Connection::getDatabase();
        \$collection = \$db->" . $tableName . ";
        \$collection->remove( array('" . $tab[$j][0] . "' => \$value) );\n
        return;
    }\n\n    ";

                }
                if (getVarNameWithS($tab[$j][0]) != 'id')
                    $readRow .= "\t\t\$" . getVarName($tableName) . "DTO->" . 
                            getVarNameWithS($tab[$j][0]) . " = \$row['" . getVarNameWithS($tab[$j][0]) . "'];\n";
            }

            if (count($pk) == 0) {
                continue;
            }

            $template = new Template(TEMPLATES . 'DAOGenMg.tpl');

            $template->set('dao_class_name', 'gen' . $className . 'Mg');
            $template->set('domain_class_name', getClassName($tableName));
            $template->set('idao_class_name', getClassName($tableName));
            $template->set('table_name', $tableName);
            $template->set('var_name', getVarName($tableName));

            $insertFields = substr($insertFields, 0, strlen($insertFields) - 2);
            $updateFields = substr($updateFields, 0, strlen($updateFields) - 2);
            $questionMarks = substr($questionMarks, 0, strlen($questionMarks) - 2);

            $s = '';
            $s2 = '';
            $s3 = '';
            $s4 = '';
            $keys = '$keys = array();';
            $insertFields2 = $insertFields;
            $questionMarks2 = $questionMarks;

            for ($z = 0; $z < count($pk); $z++) {
                $questionMarks2.=', ?';

                if ($z > 0) {
                    $s.=', ';
                    $s2.=' AND ';
                    $s3.= "\t";
                }

                $insertFields2.=', ' . $pk[$z];
                $s .= '$' . getVarNameWithS($pk[$z]);
                $prop = (getVarNameWithS($pk[$z]) == 'id') ? '_id' : getVarNameWithS($pk[$z]);
                $keys .= "\n\t\t" . '$keys["' . $prop . '"] = (gettype($' . getVarNameWithS($pk[$z]) .
                        ') == \'string\') ? new MongoID($' . getVarNameWithS($pk[$z]) . ') : $' . getVarNameWithS($pk[$z]). ';';
                $s2 .= $pk[$z] . ' = ? ';
                
                if (isColumnTypeNumber($pk_type[$z])) {
                    $s3 .= '$sqlQuery->setNumber($' . getVarNameWithS($pk[$z]) . ');';
                    $s3 .= "\n\t";
                    $s4 .= '$sqlQuery->setNumber($' . getVarName($tableName) . 
                            'DTO->' . getVarNameWithS($pk[$z]) . ');';
                    $s4 .= "\n\t";
                } else {
                    $s3 .= '$sqlQuery->set($' . getVarNameWithS($pk[$z]) . ');';
                    $s3 .= "\n\t";
                    $s4 .= '$sqlQuery->set($' . getVarName($tableName) . 
                            'DTO->' . getVarNameWithS($pk[$z]) . ');';
                    $s4 .= "\n\t";
                }
            }

            $keys = substr($keys, 0, count($keys) - 2);

            if ($s[0] == ',')
                $s = substr($s, 1);

            if ($questionMarks2[0] == ',')
                $questionMarks2 = substr($questionMarks2, 1);

            if ($insertFields2[0] == ',')
                $insertFields2 = substr($insertFields2, 1);

            $template->set('question_marks2', $questionMarks2);
            $template->set('insert_fields2', $insertFields2);
            $template->set('pk_set_update', $s4);
            $template->set('pk_set', $s3);
            $template->set('pk_where', $s2);
            $template->set('pk', $s);
            $template->set('array_keys', $keys);
            $template->set('insert_fields', $insertFields);
            $template->set('read_row', $readRow);
            $template->set('update_fields', $updateFields);
            $template->set('question_marks', $questionMarks);
            $template->set('parameter_setter', $parameterSetter);
            $template->set('read_row', $readRow);
            $template->set('queryByFieldFunctions', $queryByField);
            $template->set('deleteByFieldFunctions', $deleteByField);
            $template->write(DATA_ACCESS . 'DAO' . DS . 'mongodb' . DS . 
                    'gen' . DS . 'gen' . $className . 'MgDAO.class.php');
        }
    }    

/**
 * Permite generar las clases *MsExtDAO para cada tabla de la base de datos.
 *
 * @param array $tables
 *        Conjunto de tablas de la base de datos a las que se le crearán el MsExtDAO.
 */
    function generateDAOObjects($tables) {

        for ($i = 0; $i < count($tables); $i++) {

            if (!doesTableContainPK($tables[$i])) {
                continue;
            }

            //Definiendo variables
            $tableName = $tables[$i][0];
            $className = getClassName($tableName) . 'Ms';
            $classNameSup = 'gen' . getClassName($tableName) . 'Ms';
            $template = new Template(TEMPLATES . 'DAO.tpl');
            $template->set('dao_class_sup_name', $classNameSup);
            $template->set('dao_class_name', $className);
            $template->set('table_name', $tableName);

            $file = DATA_ACCESS . 'DAO' . DS . 'mysql' . DS . $className . 'DAO.class.php';

            if (!file_exists($file)) {
                $template->write($file);
            }
        }
    }

/**
 * Permite generar las clases *MsExtDAO para cada tabla de la base de datos.
 *
 * @param array $tables
 *        Conjunto de tablas de la base de datos a las que se le crearán el MsExtDAO.
 */
    function generateDAOObjectsMg($tables) {

        for ($i = 0; $i < count($tables); $i++) {

            if (!doesTableContainPK($tables[$i])) {
                continue;
            }

            //Definiendo variables
            $tableName = $tables[$i][0];
            $className = getClassName($tableName) . 'Mg';
            $classNameSup = 'gen' . getClassName($tableName) . 'Mg';
            $template = new Template(TEMPLATES . 'DAO.tpl');
            $template->set('dao_class_sup_name', $classNameSup);
            $template->set('dao_class_name', $className);
            $template->set('table_name', $tableName);

            $file = DATA_ACCESS . 'DAO' . DS . 'mongodb' . DS . $className . 'DAO.class.php';

            if (!file_exists($file)) {
                $template->write($file);
            }
        }
    }

/**
 * Genera las clases del Modelo, una para cada tabla de la base de datos.
 *
 * @param array $tables
 *        Conjunto de tablas de la base de datos a las que se le crearán el Modelo.
 */
    function generateModelObjects($tables) {

        for ($i = 0; $i < count($tables); $i++) {

            if (!doesTableContainPK($tables[$i])) {
                continue;
            }

            $tableName = $tables[$i][0];
            $className = getClassName($tableName);

            $template = new Template(TEMPLATES . 'ModelObjectsGen.tpl');
            $template->set('domain_class_name', $className);
            $template->set('table_name', $tableName);
            $tab = getFields($tableName);
            $fields = $gets = $sets = "";
            $fields .= "/**DTO por defecto para esta clase*/\n\t";
            $fields .= "protected \$" . getVarName($tableName) . "DTO;";
            $constructor= "if (!\$id) {
            \$this->" . getVarName($tableName) . 'DTO = new '
            . getClassName($tableName) . "DTO();
        } else {
            \$this->" . getVarName($tableName) . 'DTO = FactoryDAO::get'
            . $className . "DAO()->load(\$id);
        }";

            $sql = 'select COLUMN_COMMENT from INFORMATION_SCHEMA.COLUMNS  where
                TABLE_SCHEMA = "' . ConnectionProperty::getDatabase() . '" and TABLE_NAME = "' . $tables[$i][0] . '"';

            $comments = QueryExecutor::execute(new SqlQuery($sql));

            for ($j = 0; $j < count($tab); $j++) {
                $_dto = getVarName($tableName) . 'DTO';
                $gets .= "public function get" . getMethodName($tab[$j][0]) . "() {
        if (\$this->" . $_dto . ")
            return \$this->" . $_dto . '->' . getVarNameWithS($tab[$j][0]) . ";
        else
            return null;\n\t}\n\r\t";
                $sets .= "public function set" . getMethodName($tab[$j][0]) . 
                        "(\$" . getVarNameWithS($tab[$j][0]) . ") {
        \$this->" . $_dto . '->' . getVarNameWithS($tab[$j][0]) . " = $" . 
                        getVarNameWithS($tab[$j][0]) . ";\n\t}\n\r\t";
            }

            $template->set('variables', $fields);
            $template->set('DTO_name', getVarName($tableName) . 'DTO');
            $template->set('constructor', $constructor);
            $template->set('get_methods', $gets);
            $template->set('set_methods', $sets);
            $template->write(MODEL_CLASS_PATH . 'genModel' . DS . 'gen' . $className . '.class.php');

            $template = new Template(TEMPLATES . 'ModelObjects.tpl');
            $template->set('domain_class_name', $className);
            $template->set('table_name', $tableName);

            $file = MODEL_CLASS_PATH . $className . '.class.php';

            if (!file_exists($file)) {
                $template->write($file);
            }
        }
    }

/**
 * Permite crear el archivo FactoryDAO para la creación de objetos DAO.
 *
 * @param array $tables
 *        Conjunto de tablas de la base de datos.
 */
    function createFactoryDAO($tables) {
        $str ="\n";

        for($i=0;$i<count($tables);$i++){

            if(!doesTableContainPK($tables[$i])){
                continue;
            }

            $tableName = $tables[$i][0];
            $className = getClassName($tableName);
            $str .= "\t/**\n";
            $str .= "\t * @return ".$className."DAO\n";
            $str .= "\t */\n";
            $str .= "\tpublic static function get".$className."DAO() {\n";
            
            if (!isset($_GET['db']) || $_GET['db'] != 'mongodb') {
                $str .= "\t\treturn new ".$className."MsDAO();\n";    
            } else {
                $str .= "\t\treturn new ".$className."MgDAO();\n";
            }
            
            $str .= "\t}\n\n";
        }

        $template = new Template(TEMPLATES . 'FactoryDAO.tpl');
        $template->set('content', $str);

        $template->write(LIB . 'FactoryDAO.class.php');
    }

/**
 * Crea un archivo que importa todas las clases DAO y su dependencias.
 *
 * @param string $tables
 */
    function createIncludeFile($tables) {
        $str = '';

        for ($i = 0; $i < count($tables); $i++) {
            $tableName = $tables[$i][0];

            if (!doesTableContainPK($tables[$i])) {
                continue;
            }

            $className = getClassName($tableName);
            $str .= "\n\t// Tabla " . $className . "\n";
            $str .= "\trequire_once(MODEL . 'genModel' .DS . 'gen" . $className . ".class.php');\n";
            $str .= "\trequire_once(MODEL . '" . $className . ".class.php');\n";
            $str .= "\trequire_once(DATA_ACCESS . 'DTO' . DS . '" . $className . "DTO.class.php');\n";
            $str .= "\trequire_once(DATA_ACCESS . 'DAO' . DS . 'interfaces' . DS . '" . $className . "DAO.interface.php');\n";

            if (!isset($_GET['db']) || $_GET['db'] != 'mongodb') {
                $str .= "\trequire_once(DATA_ACCESS . 'DAO' . DS . 'mysql' . DS . 'gen' . DS . 'gen" . $className . "MsDAO.class.php');\n";
                $str .= "\trequire_once(DATA_ACCESS . 'DAO' . DS . 'mysql' . DS . '" . $className . "MsDAO.class.php');\n";
            } else {
                $str .= "\trequire_once(DATA_ACCESS . 'DAO' . DS . 'mongodb' . DS . 'gen' . DS . 'gen" . $className . "MgDAO.class.php');\n";
                $str .= "\trequire_once(DATA_ACCESS . 'DAO' . DS . 'mongodb' . DS . '" . $className . "MgDAO.class.php');\n";
            }           
        }

        $template = new Template(TEMPLATES . 'IncludeDAO.tpl');
        $template->set('include', $str);
        $template->write(INCLD . 'includeDAO.php');
    }

/**
 * Determina si la tabla especificada contiene o no clave primaria
 *
 * @param string $table
 *        Nombre de la tabla
 *
 * @return boolean <code>true</code> si la tabla contiene clave primaria, de lo
 *                 contrario <code>false</code>.
 */
    function doesTableContainPK($table) {
        $row = getFields($table[0]);
        for ($j = 0; $j < count($row); $j++) {
            if ($row[$j][3] == 'PRI') {
                return true;
            }
        }
        return false;
    }

/**
 * Retorna el conjunto de campos de la tabla especificada.
 *
 * @param string $table
 *        Nombre de la tabla.
 *
 * @return array Conjunto de campos que contiene la tabla especificada.
 */
    function getFields($table) {
        $sql = 'DESC ' . $table;
        return QueryExecutor::execute(new SqlQuery($sql));
    }

/**
 * Retorna el nombre de la clase con un formato correcto. Este formato esta
 * determinado por:
 * <ul>
 * <li>El nombre de la clase comienza por mayúscula</li>
 * <li>Si el nombre de la tabla esta compuesto y separado por "_" entonces
 * el nombre de la clase será unido por medio de palabras tipo oración, por
 * ejemplo: user_profile -> UserProfile</li>
 * </ul>
 *
 * @param string $tableName
 *        Nombre de la tabla.
 *
 * @return string Nombre de la clase que hará referencia a la tabla.
 */
    function getClassName($tableName) {
        $tableName = strtoupper($tableName[0]) . substr($tableName, 1);

        for ($i = 0; $i < strlen($tableName); $i++) {
            if ($tableName[$i] == '_') {
                $tableName = substr($tableName, 0, $i) . 
                        strtoupper($tableName[$i + 1]) . substr($tableName, $i + 2);
            }
        }

        $tableName = pluralToSingular($tableName);

        return $tableName;
    }

/**
 * Retorna el nombre de la variable que corresponde al campo especificado con un
 * formato correcto, excluyendo el plural de la variable.
 *
 * @see getVarNameWithS()
 * @param string $field
 *        Nombre del campo
 *
 * @return string Nombre de la variable que hará referencia al campo.
 */
    function getVarName($field) {
        $field = strtolower($field[0]) . substr($field, 1);

        for ($i = 0; $i < strlen($field); $i++) {
            if ($field[$i] == '_') {
                $field = substr($field, 0, $i) . 
                        strtoupper($field[$i + 1]) . substr($field, $i + 2);
            }
        }

        $field = pluralToSingular($field);
        return $field;
    }

/**
 * Retorna el nombre de la variable que corresponde al campo especificado con un
 * formato correcto, incluyendo la letra 's' al final si la tiene. Este formato
 * esta determinado por:
 * <ul>
 * <li>El nombre de la variable comienza por minuscula</li>
 * <li>Si el nombre del campo esta compuesto y separado por "_" entonces
 * el nombre de la variable será unido por medio de palabras tipo oración, por
 * ejemplo: user_profile -> userProfile</li>
 * </ul>
 *
 * @param string $field
 *        Nombre del campo
 *
 * @return string Nombre de la variable que hará referencia al campo.
 */
    function getVarNameWithS($field) {
        $field = strtolower($field[0]) . substr($field, 1);

        for ($i = 0; $i < strlen($field); $i++) {
            if ($field[$i] == '_') {
                $field = substr($field, 0, $i) . 
                        strtoupper($field[$i + 1]) . substr($field, $i + 2);
            }
        }

        return $field;
    }

/**
 * Retorna el nombre del que corresponde al campo especificado con un
 * formato correcto, incluyendo la letra 's' al final si la tiene. Este formato
 * esta determinado por:
 * <ul>
 * <li>El nombre del método comienza por mayúscula</li>
 * <li>Si el nombre del campo esta compuesto y separado por "_" entonces
 * el nombre del método será unido por medio de palabras tipo oración, por
 * ejemplo: user_profile -> UserProfile</li>
 * </ul>
 *
 * @param string $field
 *        Nombre del campo
 *
 * @return string Nombre de la variable que hará referencia al campo.
 */
    function getMethodName($field) {
        $field = strtoupper($field[0]) . substr($field, 1);

        for ($i = 0; $i < strlen($field); $i++) {
            if ($field[$i] == '_') {
                $field = substr($field, 0, $i) . 
                        strtoupper($field[$i + 1]) . substr($field, $i + 2);
            }
        }

        return $field;
    }

/**
 * Determina si el tipo de columna es un número o no.
 *
 * @param string $columnType
 *        Tipo de columna.
 *
 * @return boolean <code>true</code> si el tipo de columna es numérico, o
 *         <code>false</code> si no lo es.
 */
    function isColumnTypeNumber($columnType) {
        if (strtolower(substr($columnType, 0, 3)) == 'int' || 
                strtolower(substr($columnType, 0, 7)) == 'tinyint') {
            
            return true;
        }

        return false;
    }

/**
 * Permite cambiar de plural a singular la palabra especificada de acuerdo a las
 * reglas del inglés.
 *
 * @param string $word
 *        Palabra a cambiar del plural al singular.
 *
 * @return string Singular de la palabra especificada.
 */
    function pluralToSingular($word) {
        if (substr($word, strlen($word) - 3) == 'ies') {
            $word = substr($word, 0, strlen($word) - 3) . 'y';
        } else if ($word[strlen($word) - 1] == 's') {
            if (!(substr($word, strlen($word) - 2) == 'ss'))
                $word = substr($word, 0, strlen($word) - 1);
        }

        return $word;
    }

// --- Corriendo función generate
if (!isset($_GET['key']) || ($_GET['key'] != 'executeDAO' && $_GET['key'] != 'changeDB')) {
    echo '<b><font style:"font-size:15px">UnNotes</b><br/>Sorry.. You are not authorized to execute this file';
    return;
}

if ($_GET['key'] != 'changeDB')
    generate();
else {
    generate(true);
}


?>
