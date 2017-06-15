<?php

/**
 * @generated
 * - Clase Generada Automaticamente - NO MODIFICAR MANUALMENTE
 * Esta clase opera sobre la tabla 'empresas'. - Database MySql. -
 *
 * @package     DataAccess.dao
 * @subpackage  mysql.gen
 * @author      JpBaena13
 * @since       PHP 5
 */
 
 require_once(LIB . 'AbstractDAO.class.php');
 
class genEmpresaMgDAO implements EmpresaDAOInterface {

    /**
     * Inserta un registro a la tabla 'empresas'.
     *
     * @param Empresa $empresaDTO
     *        Objeto a insertar en la base de datos.
     */
    public function insert($empresaDTO) {

        $db = Connection::getDatabase();
        
        $collection = $db->empresas;

        $empresaDTO->_id = new MongoID();
        unset($empresaDTO->id);

        $collection->insert($empresaDTO);

        return $empresaDTO->_id;
    }

    /**
     * Retorna el objeto de dominio que corresponde a la clave primaria
     * compuesta especificada.
     *
     * @param string $id Composición de la clave primaria.
     *
     * @return Empresa Objeto que tiene como clave primaria $id
     */
    public function load($id) {
        $db = Connection::getDatabase();

        $collection = $db->empresas;

        $keys = array();
		$keys["_id"] = (gettype($id) == 'string') ? new MongoID($id) : $id;

        $result = $collection->findOne( $keys );

        return $this->readRow($result);
    }
    
    /**
     * Actualiza el registro especificado en la tabla 'empresas'
     *
     * @param Empresa $empresaDTO
     *        Objeto con los datos a actualizar en la tabla 'empresas'
     * @see executeUpdate()
     */
    public function update($empresaDTO) {
        $db = Connection::getDatabase();

        $collection = $db->empresas;

        unset($empresaDTO->id);

        $collection->save($empresaDTO);

        $empresaDTO->id = $empresaDTO->_id;
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

        $collection = $db->empresas;

        $keys = array();
		$keys["_id"] = (gettype($id) == 'string') ? new MongoID($id) : $id;

        $collection->remove( $keys );
    }

    /**
     * Retorna todos los registros de la tabla 'empresas'.
     *
     * @return array Conjunto de registros de la tabla 'empresas'.
     */
    public function queryAll() {
        $db = Connection::getDatabase();

        $collection = $db->empresas;

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
            $sql = 'SELECT * FROM empresas ORDER BY ' . $orderBy . ' ' . $type . ' LIMIT ' . $start . ',' . $pageSize;
        else
            $sql = 'SELECT * FROM empresas LIMIT ' . $start . ',' . $pageSize;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Retorna todos los registros de la tabla 'empresas' ordenado por
     * la columna especificada.
     *
     * @param string $orderColumn Nombre de la columna.
     *
     * @return array Conjunto de registros de la tabla 'empresas' ordenados.
     */
    public function queryAllOrderBy($orderColumn) {
        $sql = 'SELECT * FROM empresas ORDER BY '.$orderColumn;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Elimina todas las filas de la tabla 'empresas'
     *
     * @see executeUpdate()
     */
    public function clean() {
        $sql = 'DELETE FROM empresas';
        $sqlQuery = new SqlQuery($sql);

        return $this->executeUpdate($sqlQuery);
    }

    /*
     * Las siguientes son el conjunto de funciones que permiten obtener registros
     * desde la tabla 'empresas' a partir del valor en un campo particular.
     */
    public function queryByNombreEmpresa($value) {
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $cursor = $collection->find( array('nombre_empresa' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByLogo($value) {
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $cursor = $collection->find( array('logo' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByDescripcion($value) {
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $cursor = $collection->find( array('descripcion' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByUrl($value) {
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $cursor = $collection->find( array('url' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByTelefono($value) {
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $cursor = $collection->find( array('telefono' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByEmail($value) {
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $cursor = $collection->find( array('email' => $value) );

        return $this->getList( $cursor );
    }

    
    /*
     * Las siguiente son el conjunto de funciones que permiten eliminar registros
     * desde la tabla 'empresas' a partir del valor en un campo particular
     */
    public function deleteByNombreEmpresa($value){
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $collection->remove( array('nombre_empresa' => $value) );

        return;
    }

    public function deleteByLogo($value){
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $collection->remove( array('logo' => $value) );

        return;
    }

    public function deleteByDescripcion($value){
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $collection->remove( array('descripcion' => $value) );

        return;
    }

    public function deleteByUrl($value){
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $collection->remove( array('url' => $value) );

        return;
    }

    public function deleteByTelefono($value){
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $collection->remove( array('telefono' => $value) );

        return;
    }

    public function deleteByEmail($value){
        $db = Connection::getDatabase();
        $collection = $db->empresas;
        $collection->remove( array('email' => $value) );

        return;
    }

    

    // Los siguiente funciones  son la ejecución de mas bajo nivel para cada
    // una de las consultas creadas anteriormente.
    
    /**
     * Retorna un arreglo de objetos Empresa a partir
     * de los datos especificados en el cursor.
     * 
     * @param  MongoCursor $cursor Conjunto de registros obtenidos desde la base de datos
     * 
     * @return Array Arreglo de objetos Empresa
     */
    protected function getList( $cursor ) {
        $result = array();

        foreach ($cursor as $key ) {
            array_push($result, $this->readRow($key) );
        }

        return $result;
    }
     
    /**
     * Convierte una fila dada desde la tabla 'empresas' a un objeto de
     * tipo 'Empresa'
     *
     * @return Empresa
     *         Objeto que representa la tabla 'empresas'
     */
    protected function readRow($row) {
        if (!$row)
            return null;

        $empresaDTO = new EmpresaDTO();
        $empresaDTO->_id = $row['_id'];
        $empresaDTO->id = $row['_id'];
        
		$empresaDTO->nombreEmpresa = $row['nombreEmpresa'];
		$empresaDTO->logo = $row['logo'];
		$empresaDTO->descripcion = $row['descripcion'];
		$empresaDTO->url = $row['url'];
		$empresaDTO->telefono = $row['telefono'];
		$empresaDTO->email = $row['email'];

        return $empresaDTO;
    }
}
?>
