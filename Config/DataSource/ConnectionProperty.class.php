<?php

/**
 * Propiedades de conexión para la base de datos.
 *
 * @package     Config.DataSource
 * @author      JpBaena13
 * @since       PHP 5
 */
class ConnectionProperty {

    private static $host = 'localhost';
    private static $user = 'root';
    private static $password = '';
    private static $database = 'skeleton';

    public static function getHost() {
        if ($_SERVER['SERVER_NAME'] == 'localhost') return 'localhost';
        return ConnectionProperty::$host;
    }

    public static function getUser() {
        return ConnectionProperty::$user;
    }

    public static function getPassword() {
        return ConnectionProperty::$password;
    }

    public static function getDatabase() {
        return ConnectionProperty::$database;
    }

}

?>