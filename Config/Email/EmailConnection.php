<?php

/**
 * Objeto que representa la conexión al servidor smtp
 *
 * @package     Config.Email
 * @author      JpBaena13
 * @since       PHP 5
 */
class EmailConnection {

    private $connection;

    /**
     * Se conecta al servidor smtp
     */
    public function EmailConnection() {
        $this->connection = EmailConnectionFactory::getEmailConnection();
    }

     /**
     * Envia un correo a los usuarios especificados
     *
     * @param string $recipients
     *        listado de correos de destino.
     *
     * @return <type> Valor obtenido si se ejecuta correctamente el envio del correo
     */
    public function sendMail($recipients, $subject, $message) {
        $headers["from"]         = EmailConnectionProperty::getEmailFrom();
        $headers["to"]           = $recipients;
        $headers["subject"]      = $subject;
        $headers['content-type'] = 'text/html';
        $headers['charset']      = 'UTF-8';

        $ret = $this->connection->send($recipients, $headers, $message);
        if (PEAR::isError($ret)) {
            throw new Exception($ret->getMessage());
        }

        return $ret;        
    }
}

?>
