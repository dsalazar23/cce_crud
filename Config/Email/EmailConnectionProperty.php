<?php

/**
 * Propiedades de conexión al servidor de correo electrónico.
 *
 * @package     Config.Email
 * @author      JpBaena13
 * @since       PHP 5
 */
class EmailConnectionProperty {

    private static $host = '';
    private static $user = '465';
    private static $password = '';
    private static $from = 'noreply@skeleton.com';
    

    public static function getEmailHost() {
        return EmailConnectionProperty::$host;
    }

    public static function getEmailPort() {
        return EmailConnectionProperty::$port;
    }
    
    public static function getEmailUser() {
        return EmailConnectionProperty::$user;
    }

    public static function getEmailPassword() {
        return EmailConnectionProperty::$password;
    }
    
    public static function getEmailFrom() {
        return EmailConnectionProperty::$from;
    }

}

?>
