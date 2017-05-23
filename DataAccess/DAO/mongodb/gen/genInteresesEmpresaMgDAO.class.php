<?php

/**
 * @generated
 * - Clase Generada Automaticamente - NO MODIFICAR MANUALMENTE
 * Esta clase opera sobre la tabla 'intereses_empresa'. - Database MySql. -
 *
 * @package     DataAccess.dao
 * @subpackage  mysql.gen
 * @author      JpBaena13
 * @since       PHP 5
 */
 
 require_once(LIB . 'AbstractDAO.class.php');
 
class genInteresesEmpresaMgDAO implements InteresesEmpresaDAOInterface {

    /**
     * Inserta un registro a la tabla 'intereses_empresa'.
     *
     * @param InteresesEmpresa $interesesEmpresaDTO
     *        Objeto a insertar en la base de datos.
     */
    public function insert($interesesEmpresaDTO) {

        $db = Connection::getDatabase();
        
        $collection = $db->intereses_empresa;

        $interesesEmpresaDTO->_id = new MongoID();
        unset($interesesEmpresaDTO->id);

        $collection->insert($interesesEmpresaDTO);

        return $interesesEmpresaDTO->_id;
    }

    /**
     * Retorna el objeto de dominio que corresponde a la clave primaria
     * compuesta especificada.
     *
     * @param string $id Composición de la clave primaria.
     *
     * @return InteresesEmpresa Objeto que tiene como clave primaria $id
     */
    public function load($id) {
        $db = Connection::getDatabase();

        $collection = $db->intereses_empresa;

        $keys = array();
		$keys["_id"] = (gettype($id) == 'string') ? new MongoID($id) : $id;

        $result = $collection->findOne( $keys );

        return $this->readRow($result);
    }
    
    /**
     * Actualiza el registro especificado en la tabla 'intereses_empresa'
     *
     * @param InteresesEmpresa $interesesEmpresaDTO
     *        Objeto con los datos a actualizar en la tabla 'intereses_empresa'
     * @see executeUpdate()
     */
    public function update($interesesEmpresaDTO) {
        $db = Connection::getDatabase();

        $collection = $db->intereses_empresa;

        unset($interesesEmpresaDTO->id);

        $collection->save($interesesEmpresaDTO);

        $interesesEmpresaDTO->id = $interesesEmpresaDTO->_id;
    }
    
    /**
     * Elimina el registro que tiene clave primariaespecificada desde la 
     * base de datos.
     *
     * @param <type> $id Clave primaria compuesta del registro a eliminar.
     * @see executeUpdate()
     */
    public function delete($id) {
        $db = Connection::getDatabase();

        $collection = $db->intereses_empresa;

        $keys = array();
		$keys["_id"] = (gettype($id) == 'string') ? new MongoID($id) : $id;

        $collection->remove( $keys );
    }

    /**
     * Retorna todos los registros de la tabla 'intereses_empresa'.
     *
     * @return array Conjunto de registros de la tabla 'intereses_empresa'.
     */
    public function queryAll() {
        $db = Connection::getDatabase();

        $collection = $db->intereses_empresa;

        $cursor = $collection->find();

        return $this->getList( $cursor );
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
            $sql = 'SELECT * FROM intereses_empresa ORDER BY ' . $orderBy . ' ' . $type . ' LIMIT ' . $start . ',' . $pageSize;
        else
            $sql = 'SELECT * FROM intereses_empresa LIMIT ' . $start . ',' . $pageSize;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Retorna todos los registros de la tabla 'intereses_empresa' ordenado por
     * la columna especificada.
     *
     * @param string $orderColumn Nombre de la columna.
     *
     * @return array Conjunto de registros de la tabla 'intereses_empresa' ordenados.
     */
    public function queryAllOrderBy($orderColumn) {
        $sql = 'SELECT * FROM intereses_empresa ORDER BY '.$orderColumn;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Elimina todas las filas de la tabla 'intereses_empresa'
     *
     * @see executeUpdate()
     */
    public function clean() {
        $sql = 'DELETE FROM intereses_empresa';
        $sqlQuery = new SqlQuery($sql);

        return $this->executeUpdate($sqlQuery);
    }

    /*
     * Las siguientes son el conjunto de funciones que permiten obtener registros
     * desde la tabla 'intereses_empresa' a partir del valor en un campo particular.
     */
    public function queryByInteresEmpresa($value) {
        $db = Connection::getDatabase();
        $collection = $db->intereses_empresa;
        $cursor = $collection->find( array('interes_empresa' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByEmpresa($value) {
        $db = Connection::getDatabase();
        $collection = $db->intereses_empresa;
        $cursor = $collection->find( array('empresa' => $value) );

        return $this->getList( $cursor );
    }

    
    /*
     * Las siguiente son el conjunto de funciones que permiten eliminar registros
     * desde la tabla 'intereses_empresa' a partir del valor en un campo particular
     */
    public function deleteByInteresEmpresa($value){
        $db = Connection::getDatabase();
        $collection = $db->intereses_empresa;
        $collection->remove( array('interes_empresa' => $value) );

        return;
    }

    public function deleteByEmpresa($value){
        $db = Connection::getDatabase();
        $collection = $db->intereses_empresa;
        $collection->remove( array('empresa' => $value) );

        return;
    }

    

    // Los siguiente funciones  son la ejecución de mas bajo nivel para cada
    // una de las consultas creadas anteriormente.
    
    /**
     * Retorna un arreglo de objetos InteresesEmpresa a partir
     * de los datos especificados en el cursor.
     * 
     * @param  MongoCursor $cursor Conjunto de registros obtenidos desde la base de datos
     * 
     * @return Array Arreglo de objetos InteresesEmpresa
     */
    protected function getList( $cursor ) {
        $result = array();

        foreach ($cursor as $key ) {
            array_push($result, $this->readRow($key) );
        }

        return $result;
    }
     
    /**
     * Convierte una fila dada desde la tabla 'intereses_empresa' a un objeto de
     * tipo 'InteresesEmpresa'
     *
     * @return InteresesEmpresa
     *         Objeto que representa la tabla 'intereses_empresa'
     */
    protected function readRow($row) {
        if (!$row)
            return null;

        $interesesEmpresaDTO = new InteresesEmpresaDTO();
        $interesesEmpresaDTO->_id = $row['_id'];
        $interesesEmpresaDTO->id = $row['_id'];
        
		$interesesEmpresaDTO->interesEmpresa = $row['interesEmpresa'];
		$interesesEmpresaDTO->empresa = $row['empresa'];

        return $interesesEmpresaDTO;
    }
}
?>
