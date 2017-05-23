<?php

/**
 * Transacción de base de datos. Permite manejar los estados de BEGIN, COMMIT
 * y ROLLBACK.
 *
 * @package     Config.DataSource
 * @author      JpBaena13
 * @since       PHP 5
 */
class Transaction {

    private static $transactions;
    private $connection;

    /**
     * Inicializa la transacción que se realizará sobre la base de datos.
     */
    public function Transaction() {
        $this->connection = new Connection();

        if (!Transaction::$transactions) {
            Transaction::$transactions = array();
        }

        array_push(Transaction::$transactions, $this);
        // $this->connection->executeQuery('BEGIN');
    }

    /**
     * Realizar un commit sobre la base de datos y cierra la conexión.
     */
    public function commit() {
        $this->connection->executeQuery('COMMIT');
        $this->connection->close();
        array_pop(Transaction::$transactions);
    }

    /**
     * Realiza un rollback y cierra conexión sobre la base de datos.
     */
    public function rollback() {
        $this->connection->executeQuery('ROLLBACK');
        $this->connection->close();
        array_pop(Transaction::$transactions);
    }

    /**
     * Retorna el objeto de conexión a la base e datos
     *
     * @return Connection Objeto de conexión.
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Retorna la transacción actual.
     *
     * @return Transaction Objeto de transacción actual.
     */
    public static function getCurrentTransaction() {
        if (Transaction::$transactions) {
            $tran = end(Transaction::$transactions);
            return $tran;
        }
        return;
    }

}

?>