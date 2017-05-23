<?php

/**
 * @generated
 * - Clase Generada Automaticamente - NO MODIFICAR MANUALMENTE
 * Esta clase opera sobre la tabla '${table_name}'. - Database MySql. -
 *
 * @package     DataAccess.dao
 * @subpackage  mysql.gen
 * @author      JpBaena13
 * @since       PHP 5
 */
 
 require_once(LIB . 'AbstractDAO.class.php');
 
class ${dao_class_name}DAO extends AbstractDAO implements ${idao_class_name}DAOInterface {

    /**
     * Inserta un registro a la tabla '${table_name}'.
     *
     * @param ${domain_class_name} $${var_name}DTO
     *        Objeto a insertar en la base de datos.
     */
    public function insert($${var_name}DTO) {
        $sql = 'INSERT INTO ${table_name} (${insert_fields2}) VALUES (${question_marks2})';
        $sqlQuery = new SqlQuery($sql);
        ${parameter_setter}
        ${pk_set_update}
        return $this->executeInsert($sqlQuery);
    }

    /**
     * Retorna el objeto de dominio que corresponde a la clave primaria
     * compuesta especificada.
     *
     * @param string ${pk} Composición de la clave primaria.
     *
     * @return ${domain_class_name} Objeto que tiene como clave primaria $id
     */
    public function load(${pk}) {
        $sql = 'SELECT * FROM ${table_name} WHERE ${pk_where}';
        $sqlQuery = new SqlQuery($sql);
        ${pk_set}
        return $this->getRow($sqlQuery);
    }
    
    /**
     * Actualiza el registro especificado en la tabla '${table_name}'
     *
     * @param ${domain_class_name} $${var_name}DTO
     *        Objeto con los datos a actualizar en la tabla '${table_name}'
     * @see executeUpdate()
     */
    public function update($${var_name}DTO) {
        $sql = 'UPDATE ${table_name} SET ${update_fields} WHERE ${pk_where}';
        $sqlQuery = new SqlQuery($sql);
        ${parameter_setter}
        ${pk_set_update}
        return $this->executeUpdate($sqlQuery);
    }
    
    /**
     * Elimina el registro que tiene clave primariaespecificada desde la 
     * base de datos.
     *
     * @param <type> ${pk} Clave primaria compuesta del registro a eliminar.
     * @see executeUpdate()
     */
    public function delete(${pk}) {
        $sql = 'DELETE FROM ${table_name} WHERE ${pk_where}';
        $sqlQuery = new SqlQuery($sql);
        ${pk_set}
        return $this->executeUpdate($sqlQuery);
    }

    /**
     * Retorna todos los registros de la tabla '${table_name}'.
     *
     * @return array Conjunto de registros de la tabla '${table_name}'.
     */
    public function queryAll() {
        $sql = 'SELECT * FROM ${table_name}';
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Retorna el número de registros limitado por $pageSize a partir del
     * registro $page además de organizar los registros por el campo $orderBy
     * aplicando el tipo de ordenamiento espeficiado en $type.
     *
     * @param int $start
     *        Registro a partir del cual comenzará la página a retornar.
     * @param int $pageSize
     *        Tamaño máximo de registros a retornar, esto es, el tamañan de página
     * @param string $orderBy
     *        Nombre del campo sobre el cual se aplicará un ordenamiento a los registros.
     * @param string $type
     *        Tipo de ordenamiento, esto es, Ascendente o Descendente.
     *
     * @return Arreglo de objetos de tipo 'notes'
     */
    public function queryLimit($start, $pageSize, $orderBy = null, $type='ASC') {
        if ($orderBy)
            $sql = 'SELECT * FROM ${table_name} ORDER BY ' . $orderBy . ' ' . $type . ' LIMIT ' . $start . ',' . $pageSize;
        else
            $sql = 'SELECT * FROM ${table_name} LIMIT ' . $start . ',' . $pageSize;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Retorna todos los registros de la tabla '${table_name}' ordenado por
     * la columna especificada.
     *
     * @param string $orderColumn Nombre de la columna.
     *
     * @return array Conjunto de registros de la tabla '${table_name}' ordenados.
     */
    public function queryAllOrderBy($orderColumn) {
        $sql = 'SELECT * FROM ${table_name} ORDER BY '.$orderColumn;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Elimina todas las filas de la tabla '${table_name}'
     *
     * @see executeUpdate()
     */
    public function clean() {
        $sql = 'DELETE FROM ${table_name}';
        $sqlQuery = new SqlQuery($sql);

        return $this->executeUpdate($sqlQuery);
    }

    /*
     * Las siguientes son el conjunto de funciones que permiten obtener registros
     * desde la tabla '${table_name}' a partir del valor en un campo particular.
     */
    ${queryByFieldFunctions}
    /*
     * Las siguiente son el conjunto de funciones que permiten eliminar registros
     * desde la tabla '${table_name}' a partir del valor en un campo particular
     */
    ${deleteByFieldFunctions}

    // Los siguiente funciones  son la ejecución de mas bajo nivel para cada
    // una de las consultas creadas anteriormente.
     
    /**
     * Convierte una fila dada desde la tabla '${table_name}' a un objeto de
     * tipo '${domain_class_name}'
     *
     * @return ${domain_class_name}
     *         Objeto que representa la tabla '${table_name}'
     */
    protected function readRow($row) {
        $${var_name}DTO = new ${domain_class_name}DTO();
        ${read_row}
        return $${var_name}DTO;
    }
}
?>
