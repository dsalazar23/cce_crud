<?php

/**
 * Objeto que representa la conexión a la base de datos
 *
 * @package     Config.DataSource
 * @author      JpBaena13
 * @since       PHP 5
 */
class Connection {

    public $connection;

    /**
     * Abre conexión con base de datos
     */
    public function __construct() {
        $this->connection = ConnectionFactory::getConnection();
    }

    /**
     * Retorna la conexión a ser usada
     * 
     * @return MongoClient Conexión a la base de datos.
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Retorna conexión a la base de datos especificada en el archivo "ConnectionProperty"
     * 
     * @return MongoDatabase Conexión a base de datos específica
     */
    public static function getDatabase() {
        $conn = new Connection();
        $database = ConnectionProperty::getDatabase();
        
        return $conn->getConnection()->$database;
    }

    /**
     * Retorna referencia a la colección especificada
     * 
     * @param  string $collection nombre de la colección a retornar
     * 
     * @return MongoCollection Referencia a la colección especificada.
     */
    public static function getCollection( $collection ) {
        $conn = new Connection();
        $database = ConnectionProperty::getDatabase();

        $database = $conn->getConnection()->$database;

        return $database->$collection();
    }

    /**
     * Cierra la conexión con la base de datos
     */
    public function close() {
        ConnectionFactory::close($this->connection);
    }

    /**
     * Ejecuta una consulta a la base de datos.
     *
     * @param string $sql
     *        Consulta SQL a executar.
     *
     * @return <type> Valor obtenido de ejecutar la consulta sobre la base de datos
     */
    public function executeQuery($sql) {
        mysqli_query($this->connection, "SET NAMES UTF8");
        return mysqli_query($this->connection, $sql);
    }

    /**
     * Ejecuta una consulta con múltiples sentencias a la base de datos.
     *
     * @param string $sql
     *        Consulta SQL múltiple a executar.
     *
     * @return <type> Valor obtenido de ejecutar la consulta sobre la base de datos
     */
    public function executeMultiQuery($sql) {
        mysqli_query($this->connection, "SET NAMES UTF8");
        $result = mysqli_multi_query($this->connection, $sql);
        $last = $this->mysqli_last_result($this->connection);
        
        return ($last) ? $last : $result;     
    }

    /**
     * Retorna el resultado de la última consulta realizada en un ejecución múltiple
     * 
     * @param  Connection $link Objeto de conexión a la base de datos
     * 
     * @return ResultSet Resultado de la última consulta realizada en la ejecución múltiple
     */
    private function mysqli_last_result($link) {
        while (mysqli_more_results($link)) {
            mysqli_use_result($link); 
            mysqli_next_result($link);
        }

        return mysqli_store_result($link);
    }
}

?>