<?php

/**
 * @generated
 * - Clase Generada Automaticamente - NO MODIFICAR MANUALMENTE
 * Esta clase opera sobre la tabla 'participante'. - Database MySql. -
 *
 * @package     DataAccess.dao
 * @subpackage  mysql.gen
 * @author      JpBaena13
 * @since       PHP 5
 */
 
 require_once(LIB . 'AbstractDAO.class.php');
 
class genParticipanteMgDAO implements ParticipanteDAOInterface {

    /**
     * Inserta un registro a la tabla 'participante'.
     *
     * @param Participante $participanteDTO
     *        Objeto a insertar en la base de datos.
     */
    public function insert($participanteDTO) {

        $db = Connection::getDatabase();
        
        $collection = $db->participante;

        $participanteDTO->_id = new MongoID();
        unset($participanteDTO->id);

        $collection->insert($participanteDTO);

        return $participanteDTO->_id;
    }

    /**
     * Retorna el objeto de dominio que corresponde a la clave primaria
     * compuesta especificada.
     *
     * @param string $idParticipante Composición de la clave primaria.
     *
     * @return Participante Objeto que tiene como clave primaria $id
     */
    public function load($idParticipante) {
        $db = Connection::getDatabase();

        $collection = $db->participante;

        $keys = array();
		$keys["idParticipante"] = (gettype($idParticipante) == 'string') ? new MongoID($idParticipante) : $idParticipante;

        $result = $collection->findOne( $keys );

        return $this->readRow($result);
    }
    
    /**
     * Actualiza el registro especificado en la tabla 'participante'
     *
     * @param Participante $participanteDTO
     *        Objeto con los datos a actualizar en la tabla 'participante'
     * @see executeUpdate()
     */
    public function update($participanteDTO) {
        $db = Connection::getDatabase();

        $collection = $db->participante;

        unset($participanteDTO->id);

        $collection->save($participanteDTO);

        $participanteDTO->id = $participanteDTO->_id;
    }
    
    /**
     * Elimina el registro que tiene clave primariaespecificada desde la 
     * base de datos.
     *
     * @param <type> $idParticipante Clave primaria compuesta del registro a eliminar.
     * @see executeUpdate()
     */
    public function delete($idParticipante) {
        $db = Connection::getDatabase();

        $collection = $db->participante;

        $keys = array();
		$keys["idParticipante"] = (gettype($idParticipante) == 'string') ? new MongoID($idParticipante) : $idParticipante;

        $collection->remove( $keys );
    }

    /**
     * Retorna todos los registros de la tabla 'participante'.
     *
     * @return array Conjunto de registros de la tabla 'participante'.
     */
    public function queryAll() {
        $db = Connection::getDatabase();

        $collection = $db->participante;

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
            $sql = 'SELECT * FROM participante ORDER BY ' . $orderBy . ' ' . $type . ' LIMIT ' . $start . ',' . $pageSize;
        else
            $sql = 'SELECT * FROM participante LIMIT ' . $start . ',' . $pageSize;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Retorna todos los registros de la tabla 'participante' ordenado por
     * la columna especificada.
     *
     * @param string $orderColumn Nombre de la columna.
     *
     * @return array Conjunto de registros de la tabla 'participante' ordenados.
     */
    public function queryAllOrderBy($orderColumn) {
        $sql = 'SELECT * FROM participante ORDER BY '.$orderColumn;
        $sqlQuery = new SqlQuery($sql);

        return $this->getList($sqlQuery);
    }

    /**
     * Elimina todas las filas de la tabla 'participante'
     *
     * @see executeUpdate()
     */
    public function clean() {
        $sql = 'DELETE FROM participante';
        $sqlQuery = new SqlQuery($sql);

        return $this->executeUpdate($sqlQuery);
    }

    /*
     * Las siguientes son el conjunto de funciones que permiten obtener registros
     * desde la tabla 'participante' a partir del valor en un campo particular.
     */
    public function queryByNumeroDocumento($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('numero_documento' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByNombres($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('nombres' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByApellidos($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('apellidos' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByEmail($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('email' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByEmailContacto($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('email_contacto' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByNotificaciones($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('notificaciones' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByIdCohorte($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('id_cohorte' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByIdTipoDocumento($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('id_tipo_documento' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByIdOrganizacion($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('id_organizacion' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByIdEstadoParticipante($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('id_estado_participante' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByToken($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('token' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByCiudad($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('ciudad' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByDepartamento($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('departamento' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByFecha($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('fecha' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByTelefono($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('telefono' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByGenero($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('genero' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByTipoDocumento($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('tipo_documento' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByActivacion($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('activacion' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByUsername($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('username' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByPassword($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('password' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByCountry($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('country' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByMobile($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('mobile' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByAddress($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('address' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByInstitution($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('institution' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByValidation($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('validation' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByFechaNacimiento($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('fecha_nacimiento' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByRuta($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('ruta' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByNivel($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('nivel' => $value) );

        return $this->getList( $cursor );
    }

    public function queryByCursoActual($value) {
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $cursor = $collection->find( array('curso_actual' => $value) );

        return $this->getList( $cursor );
    }

    
    /*
     * Las siguiente son el conjunto de funciones que permiten eliminar registros
     * desde la tabla 'participante' a partir del valor en un campo particular
     */
    public function deleteByNumeroDocumento($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('numero_documento' => $value) );

        return;
    }

    public function deleteByNombres($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('nombres' => $value) );

        return;
    }

    public function deleteByApellidos($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('apellidos' => $value) );

        return;
    }

    public function deleteByEmail($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('email' => $value) );

        return;
    }

    public function deleteByEmailContacto($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('email_contacto' => $value) );

        return;
    }

    public function deleteByNotificaciones($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('notificaciones' => $value) );

        return;
    }

    public function deleteByIdCohorte($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('id_cohorte' => $value) );

        return;
    }

    public function deleteByIdTipoDocumento($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('id_tipo_documento' => $value) );

        return;
    }

    public function deleteByIdOrganizacion($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('id_organizacion' => $value) );

        return;
    }

    public function deleteByIdEstadoParticipante($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('id_estado_participante' => $value) );

        return;
    }

    public function deleteByToken($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('token' => $value) );

        return;
    }

    public function deleteByCiudad($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('ciudad' => $value) );

        return;
    }

    public function deleteByDepartamento($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('departamento' => $value) );

        return;
    }

    public function deleteByFecha($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('fecha' => $value) );

        return;
    }

    public function deleteByTelefono($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('telefono' => $value) );

        return;
    }

    public function deleteByGenero($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('genero' => $value) );

        return;
    }

    public function deleteByTipoDocumento($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('tipo_documento' => $value) );

        return;
    }

    public function deleteByActivacion($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('activacion' => $value) );

        return;
    }

    public function deleteByUsername($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('username' => $value) );

        return;
    }

    public function deleteByPassword($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('password' => $value) );

        return;
    }

    public function deleteByCountry($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('country' => $value) );

        return;
    }

    public function deleteByMobile($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('mobile' => $value) );

        return;
    }

    public function deleteByAddress($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('address' => $value) );

        return;
    }

    public function deleteByInstitution($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('institution' => $value) );

        return;
    }

    public function deleteByValidation($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('validation' => $value) );

        return;
    }

    public function deleteByFechaNacimiento($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('fecha_nacimiento' => $value) );

        return;
    }

    public function deleteByRuta($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('ruta' => $value) );

        return;
    }

    public function deleteByNivel($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('nivel' => $value) );

        return;
    }

    public function deleteByCursoActual($value){
        $db = Connection::getDatabase();
        $collection = $db->participante;
        $collection->remove( array('curso_actual' => $value) );

        return;
    }

    

    // Los siguiente funciones  son la ejecución de mas bajo nivel para cada
    // una de las consultas creadas anteriormente.
    
    /**
     * Retorna un arreglo de objetos Participante a partir
     * de los datos especificados en el cursor.
     * 
     * @param  MongoCursor $cursor Conjunto de registros obtenidos desde la base de datos
     * 
     * @return Array Arreglo de objetos Participante
     */
    protected function getList( $cursor ) {
        $result = array();

        foreach ($cursor as $key ) {
            array_push($result, $this->readRow($key) );
        }

        return $result;
    }
     
    /**
     * Convierte una fila dada desde la tabla 'participante' a un objeto de
     * tipo 'Participante'
     *
     * @return Participante
     *         Objeto que representa la tabla 'participante'
     */
    protected function readRow($row) {
        if (!$row)
            return null;

        $participanteDTO = new ParticipanteDTO();
        $participanteDTO->_id = $row['_id'];
        $participanteDTO->id = $row['_id'];
        
		$participanteDTO->idParticipante = $row['idParticipante'];
		$participanteDTO->numeroDocumento = $row['numeroDocumento'];
		$participanteDTO->nombres = $row['nombres'];
		$participanteDTO->apellidos = $row['apellidos'];
		$participanteDTO->email = $row['email'];
		$participanteDTO->emailContacto = $row['emailContacto'];
		$participanteDTO->notificaciones = $row['notificaciones'];
		$participanteDTO->idCohorte = $row['idCohorte'];
		$participanteDTO->idTipoDocumento = $row['idTipoDocumento'];
		$participanteDTO->idOrganizacion = $row['idOrganizacion'];
		$participanteDTO->idEstadoParticipante = $row['idEstadoParticipante'];
		$participanteDTO->token = $row['token'];
		$participanteDTO->ciudad = $row['ciudad'];
		$participanteDTO->departamento = $row['departamento'];
		$participanteDTO->fecha = $row['fecha'];
		$participanteDTO->telefono = $row['telefono'];
		$participanteDTO->genero = $row['genero'];
		$participanteDTO->tipoDocumento = $row['tipoDocumento'];
		$participanteDTO->activacion = $row['activacion'];
		$participanteDTO->username = $row['username'];
		$participanteDTO->password = $row['password'];
		$participanteDTO->country = $row['country'];
		$participanteDTO->mobile = $row['mobile'];
		$participanteDTO->address = $row['address'];
		$participanteDTO->institution = $row['institution'];
		$participanteDTO->validation = $row['validation'];
		$participanteDTO->fechaNacimiento = $row['fechaNacimiento'];
		$participanteDTO->ruta = $row['ruta'];
		$participanteDTO->nivel = $row['nivel'];
		$participanteDTO->cursoActual = $row['cursoActual'];

        return $participanteDTO;
    }
}
?>
