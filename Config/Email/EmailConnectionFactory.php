<?php

/**
 * Realiza una conexión al servidor smtp de acuerdo a las propiedades
 * de conexión configuradas en el archivo <code>ConnectionProperty</code>, o en
 *
 * @package     Config.Email
 * @author      JpBaena13
 * @since       PHP 5
 */

if (class_exists('Mail'))
    include_once("Mail.php");

class EmailConnectionFactory {

    /**
     * Retorna una conexión al servidor smtp de acuerdo a las propiedades
     * de conexión configuradas en el archivo <code>ConnectionProperty</code>.
     *
     * @return <type> Conexión al servidor smtp
     */
    static public function getEmailConnection() {
        $params["host"] = EmailConnectionProperty::getEmailHost(); 
        $params["port"] = EmailConnectionProperty::getEmailPort(); 
        $params["auth"] = true; 
        $params["username"] = EmailConnectionProperty::getEmailUser();
        $params["password"] = EmailConnectionProperty::getEmailPassword();

        error_reporting(E_ALL ^ (E_NOTICE | E_STRICT)); 

        // Create the mail object using the Mail::factory method 
        $conn =& Mail::factory("smtp", $params); 
  
        if(PEAR::isError($conn)){
            throw new Exception('could not connect to smtp server');
        }
 
        return $conn;
    }

}

?>
