<?php

/**
 * @generated
 * - Clase Generada Automaticamente - NO MODIFICAR MANUALMENTE
 * Esta clase opera sobre la tabla 'intereses_participante'. - Database MySql. -
 *
 * @package     DataAccess.dao
 * @subpackage  mysql.gen
 * @author      JpBaena13
 * @since       PHP 5
 */
 
 require_once(LIB . 'AbstractDAO.class.php');
 
class genInteresesParticipanteMgDAO implements InteresesParticipanteDAOInterface {

    /**
     * Inserta un registro a la tabla 'intereses_participante'.
     *
     * @param InteresesParticipante $interesesParticipanteDTO
     *        Objeto a insertar en la base de datos.
     */
    public function insert($interesesParticipanteDTO) {

        $db = Connection::getDatabase();
        
        $collection = $db->intereses_participante;

        $interesesParticipanteDTO->_id = new MongoID();
        unset($interesesParticipanteDTO->id);

        $collection->insert($interesesParticipanteDTO);

        return $interesesParticipanteDTO->_id;
    }

    /**
     * Retorna el objeto de dominio que corresponde a la clave primaria
     * compuesta especificada.
     *
     * @param string $interesesId, $idParticipante Composición de la clave primaria.
     *
     * @return InteresesParticipante Objeto que tiene como clave primaria $id
     */
    public function load($interesesId, $idParticipante) {
        $db = Connection::getDatabase();

        $collection = $db->intereses_participante;

        $keys = array();
		$keys["interesesId"] = (gettype($interesesId) == 'string') ? new MongoID($interesesId) : $interesesId;
		$keys["idParticipante"] = (gettype($idParticipante) == 'string') ? new MongoID($idParticipante) : $idParticipante;

        $result = $collection->findOne( $keys );

        return $this->readRow($result);
    }
    
    /**
     * Actualiza el registro especificado en la tabla 'intereses_participante'
     *
     * @param InteresesParticipante $interesesParticipanteDTO
     *        Objeto con los datos a actualizar en la tabla 'intereses_participante'
     * @see executeUpdate()
     */
    public function update($interesesParticipanteDTO) {
        $db = Connection::getDatabase();

        $collection = $db->intereses_participante;

        unset($interesesParticipanteDTO->id);

        $collection->save($interesesParticipanteDTO);

        $interesesParticipanteDTO->id = $interesesParticipanteDTO->_id;
    }
    
    /**
     * Elimina el registro que tiene clave primariaespecificada desde la 
     * base de datos.
     *
     * @param <type> $interesesId, $idParticipante Clave primaria compuesta del registro a eliminar.
     * @see executeUpdate()
     */
    public function delete($interesesId, $idParticipante) {
        $db = Connection::getDatabase();

        $collection = $db->intereses_participante;

        $keys = array();
		$keys["interesesId"] = (gettype($interesesId) == 'string') ? new MongoID($interesesId) : $interesesId;
		$keys["idParticipante"] = (gettype($idParticipante) == 'string') ? new MongoID($idParticipante) : $idParticipante;

        $collection->remove( $keys );
    }

    /**
     * Retorna todos los registros de la tabla 'intereses_participante'.
     *
     * @return array Conjunto de registros de la tabla 'intereses_participante'.
     */
    public function queryAll() {
        $db = Connection::getDatabase();

        $collection = $db->intereses_participante;

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
            $sql = 'SELECT * FROM intereses_participante ORDER BY ' . $orderBy . ' ' . $type . ' LIMIT ' . $start . ',' . $pageSize;
        else
            $sql = 'SELECT * FROM intereses_participante LIMIT ' . $start . ',' . $pageSize;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Retorna todos los registros de la tabla 'intereses_participante' ordenado por
     * la columna especificada.
     *
     * @param string $orderColumn Nombre de la columna.
     *
     * @return array Conjunto de registros de la tabla 'intereses_participante' ordenados.
     */
    public function queryAllOrderBy($orderColumn) {
        $sql = 'SELECT * FROM intereses_participante ORDER BY '.$orderColumn;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Elimina todas las filas de la tabla 'intereses_participante'
     *
     * @see executeUpdate()
     */
    public function clean() {
        $sql = 'DELETE FROM intereses_participante';
        $sqlQuery = new SqlQuery($sql);

        return $this->executeUpdate($sqlQuery);
    }

    /*
     * Las siguientes son el conjunto de funciones que permiten obtener registros
     * desde la tabla 'intereses_participante' a partir del valor en un campo particular.
     */
    
    /*
     * Las siguiente son el conjunto de funciones que permiten eliminar registros
     * desde la tabla 'intereses_participante' a partir del valor en un campo particular
     */
    

    // Los siguiente funciones  son la ejecución de mas bajo nivel para cada
    // una de las consultas creadas anteriormente.
    
    /**
     * Retorna un arreglo de objetos InteresesParticipante a partir
     * de los datos especificados en el cursor.
     * 
     * @param  MongoCursor $cursor Conjunto de registros obtenidos desde la base de datos
     * 
     * @return Array Arreglo de objetos InteresesParticipante
     */
    protected function getList( $cursor ) {
        $result = array();

        foreach ($cursor as $key ) {
            array_push($result, $this->readRow($key) );
        }

        return $result;
    }
     
    /**
     * Convierte una fila dada desde la tabla 'intereses_participante' a un objeto de
     * tipo 'InteresesParticipante'
     *
     * @return InteresesParticipante
     *         Objeto que representa la tabla 'intereses_participante'
     */
    protected function readRow($row) {
        if (!$row)
            return null;

        $interesesParticipanteDTO = new InteresesParticipanteDTO();
        $interesesParticipanteDTO->_id = $row['_id'];
        $interesesParticipanteDTO->id = $row['_id'];
        
		$interesesParticipanteDTO->interesesId = $row['interesesId'];
		$interesesParticipanteDTO->idParticipante = $row['idParticipante'];

        return $interesesParticipanteDTO;
    }
}
?>
