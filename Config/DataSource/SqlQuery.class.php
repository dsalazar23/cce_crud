<?php

/**
 * Objeto que representa una consulta query con parámetros.
 *
 * @package     Config.DataSource
 * @author      JpBaena13
 * @since       PHP 5
 */
class SqlQuery {

    private $txt;
    private $params = array();
    private $idx = 0;
    private $connection;

    /**
     * Constructor
     *
     * @param string $txt
     *        Consulta SQL.
     */
    function SqlQuery($txt) {
        $transaction = Transaction::getCurrentTransaction();

        if (!$transaction)
            $transaction = new Transaction();
        
        $this->connection = $transaction->getConnection();
        $this->txt = $txt;
    }

    /**
     * Añade el string especificado al arreglo de parametros de la consulta SQL.
     *
     * @param string $value
     *        Valor a ser añadido.
     */
    public function setString($value) {
       $this->set( $value );
    }

    /**
     * @see setString($value)
     */
    public function set($value) {
        if ($value === null) {
            $this->params[$this->idx++] = "null";
            return;
        }
        
        $value = mysqli_real_escape_string($this->connection->connection, $value);
        $this->params[$this->idx++] = "'" . $value . "'";
    }
    
    /**
     * El mismo efecto del set pero sin las comillas.
     *
     * @see setString($value)
     */
    public function setValue($value) {
        $value = mysqli_real_escape_string($this->connection->connection, $value);
        $this->params[$this->idx++] = $value;
    }

    /**
     * Configura el último elemento del arreglo de parámetros de acuerdo al
     * valor especificado. SI el valor es null, la ultima posición del arreglo
     * params almanacena el string "null", si es númerico, almacena el número
     * si no es número lanza una excepción.
     *
     * @param String $value
     *        Valor a configurar en la ultima posición del arreglo params.
     */
    public function setNumber($value) {
        if ($value === null) {
            $this->params[$this->idx++] = "null";
            return;
        }
        if (!is_numeric($value)) {
            throw new Exception($value . ' is not a number');
        }
        $this->params[$this->idx++] = "'" . $value . "'";
    }

    /**
     * Obtiene la última consulta SQl.
     *
     * @return string Consulta SQL
     */
    public function getQuery() {

        if ($this->idx == 0) {
            return $this->txt;
        }

        $p = explode("?", $this->txt);
        $sql = '';

        for ($i = 0; $i <= $this->idx; $i++) {
            if ($i >= count($this->params)) {
                $sql .= $p[$i];
            } else {
                $sql .= $p[$i] . $this->params[$i];
            }
        }

        return $sql;
    }

}

?>