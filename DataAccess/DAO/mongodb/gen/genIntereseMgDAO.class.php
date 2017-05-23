<?php

/**
 * @generated
 * - Clase Generada Automaticamente - NO MODIFICAR MANUALMENTE
 * Esta clase opera sobre la tabla 'intereses'. - Database MySql. -
 *
 * @package     DataAccess.dao
 * @subpackage  mysql.gen
 * @author      JpBaena13
 * @since       PHP 5
 */
 
 require_once(LIB . 'AbstractDAO.class.php');
 
class genIntereseMgDAO implements IntereseDAOInterface {

    /**
     * Inserta un registro a la tabla 'intereses'.
     *
     * @param Interese $intereseDTO
     *        Objeto a insertar en la base de datos.
     */
    public function insert($intereseDTO) {

        $db = Connection::getDatabase();
        
        $collection = $db->intereses;

        $intereseDTO->_id = new MongoID();
        unset($intereseDTO->id);

        $collection->insert($intereseDTO);

        return $intereseDTO->_id;
    }

    /**
     * Retorna el objeto de dominio que corresponde a la clave primaria
     * compuesta especificada.
     *
     * @param string $id Composición de la clave primaria.
     *
     * @return Interese Objeto que tiene como clave primaria $id
     */
    public function load($id) {
        $db = Connection::getDatabase();

        $collection = $db->intereses;

        $keys = array();
		$keys["_id"] = (gettype($id) == 'string') ? new MongoID($id) : $id;

        $result = $collection->findOne( $keys );

        return $this->readRow($result);
    }
    
    /**
     * Actualiza el registro especificado en la tabla 'intereses'
     *
     * @param Interese $intereseDTO
     *        Objeto con los datos a actualizar en la tabla 'intereses'
     * @see executeUpdate()
     */
    public function update($intereseDTO) {
        $db = Connection::getDatabase();

        $collection = $db->intereses;

        unset($intereseDTO->id);

        $collection->save($intereseDTO);

        $intereseDTO->id = $intereseDTO->_id;
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

        $collection = $db->intereses;

        $keys = array();
		$keys["_id"] = (gettype($id) == 'string') ? new MongoID($id) : $id;

        $collection->remove( $keys );
    }

    /**
     * Retorna todos los registros de la tabla 'intereses'.
     *
     * @return array Conjunto de registros de la tabla 'intereses'.
     */
    public function queryAll() {
        $db = Connection::getDatabase();

        $collection = $db->intereses;

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
            $sql = 'SELECT * FROM intereses ORDER BY ' . $orderBy . ' ' . $type . ' LIMIT ' . $start . ',' . $pageSize;
        else
            $sql = 'SELECT * FROM intereses LIMIT ' . $start . ',' . $pageSize;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Retorna todos los registros de la tabla 'intereses' ordenado por
     * la columna especificada.
     *
     * @param string $orderColumn Nombre de la columna.
     *
     * @return array Conjunto de registros de la tabla 'intereses' ordenados.
     */
    public function queryAllOrderBy($orderColumn) {
        $sql = 'SELECT * FROM intereses ORDER BY '.$orderColumn;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Elimina todas las filas de la tabla 'intereses'
     *
     * @see executeUpdate()
     */
    public function clean() {
        $sql = 'DELETE FROM intereses';
        $sqlQuery = new SqlQuery($sql);

        return $this->executeUpdate($sqlQuery);
    }

    /*
     * Las siguientes son el conjunto de funciones que permiten obtener registros
     * desde la tabla 'intereses' a partir del valor en un campo particular.
     */
    public function queryByNombre($value) {
        $db = Connection::getDatabase();
        $collection = $db->intereses;
        $cursor = $collection->find( array('nombre' => $value) );

        return $this->getList( $cursor );
    }

    
    /*
     * Las siguiente son el conjunto de funciones que permiten eliminar registros
     * desde la tabla 'intereses' a partir del valor en un campo particular
     */
    public function deleteByNombre($value){
        $db = Connection::getDatabase();
        $collection = $db->intereses;
        $collection->remove( array('nombre' => $value) );

        return;
    }

    

    // Los siguiente funciones  son la ejecución de mas bajo nivel para cada
    // una de las consultas creadas anteriormente.
    
    /**
     * Retorna un arreglo de objetos Interese a partir
     * de los datos especificados en el cursor.
     * 
     * @param  MongoCursor $cursor Conjunto de registros obtenidos desde la base de datos
     * 
     * @return Array Arreglo de objetos Interese
     */
    protected function getList( $cursor ) {
        $result = array();

        foreach ($cursor as $key ) {
            array_push($result, $this->readRow($key) );
        }

        return $result;
    }
     
    /**
     * Convierte una fila dada desde la tabla 'intereses' a un objeto de
     * tipo 'Interese'
     *
     * @return Interese
     *         Objeto que representa la tabla 'intereses'
     */
    protected function readRow($row) {
        if (!$row)
            return null;

        $intereseDTO = new IntereseDTO();
        $intereseDTO->_id = $row['_id'];
        $intereseDTO->id = $row['_id'];
        
		$intereseDTO->nombre = $row['nombre'];

        return $intereseDTO;
    }
}
?>
