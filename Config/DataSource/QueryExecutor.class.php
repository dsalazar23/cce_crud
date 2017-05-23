<?php

/**
 * Objeto que permite ejecutar una consulta sobre la base de datos, manejando
 * transacciones.
 *
 * @package     Config.DataSource
 * @author      JpBaena13
 * @since       PHP 5
 */
class QueryExecutor {

    /**
     * Ejecuta la consulta SQL que le pasan como parámetro.
     * 
     * @param SqlQuery $sqlQuery
     *        Consulta SQL a ejecutar.
     * 
     * @return array Arreglo que contiene el resultado de ejecutar la consulta.
     */
    public static function execute($sqlQuery) {
        $transaction = Transaction::getCurrentTransaction();

        if (!$transaction) {
            $connection = new Connection();
        } else {
            $connection = $transaction->getConnection();
        }

        $query = $sqlQuery->getQuery();
        $result = $connection->executeQuery($query);

        if (!$result) {
            throw new Exception(mysqli_error($connection->connection));
        }

        if (gettype($result) == 'boolean')
            return $result;

        $i = 0;
        $tab = array();

        while ($row = mysqli_fetch_array($result)) {
            $tab[$i++] = $row;
        }

        mysqli_free_result($result);

        if (!$transaction) {
            $connection->close();
        }

        return $tab;
    }

    /**
     * Ejecuta la consulta SQL que le pasan como parámetro con múltiples sentencias.
     * 
     * @param SqlQuery $sqlQuery
     *        Consulta SQL multiple a ejecutar.
     * 
     * @return array Arreglo que contiene el resultado de ejecutar la consulta.
     */
    public static function multi_execute($sqlQuery) {
        $transaction = Transaction::getCurrentTransaction();

        if (!$transaction) {
            $connection = new Connection();
        } else {
            $connection = $transaction->getConnection();
        }

        $query = $sqlQuery->getQuery();
        $result = $connection->executeMultiQuery($query);

        if (!$result) {
            throw new Exception(mysqli_error($connection->connection));
        }

        if (gettype($result) == 'boolean')
            return $result;

        $i = 0;
        $tab = array();

        while ($row = mysqli_fetch_array($result)) {
            $tab[$i++] = $row;
        }

        mysqli_free_result($result);

        if (!$transaction) {
            $connection->close();
        }

        return $tab;
    }

    /**
     * Ejecuta una consulta de tipo Actualización sobre la base de datos
     *
     * @param SqlQuery $sqlQuery
     *        Consulta SQL a ejecutar
     *
     * @return int número de fila afectadas exitosamente, -1 si la query falla.
     */
    public static function executeUpdate($sqlQuery, &$connection = null) {
        
        if ($connection === null) {
            $transaction = Transaction::getCurrentTransaction();        

            if (!$transaction) {
                $connection = new Connection();
            } else {
                $connection = $transaction->getConnection();
            }
        }

        $query = $sqlQuery->getQuery();
        $result = $connection->executeQuery($query);

        if (!$result) {
            throw new Exception(mysqli_error($connection->connection));
        }
        
        return mysqli_affected_rows($connection->connection);
    }

    /**
     *
     * @param SqlQuery $sqlQuery
     *        Query a ejecuta para la inserción.
     *
     * @return int El ID generado por una columna que se auto-incrementa
     * cuando la query es exitosa, 0 si la query no genera un valor auto-incremental
     * o falso si la conexión a las base de datos no fue establecida.
     *
     */
    public static function executeInsert($sqlQuery) {
        $transaction = Transaction::getCurrentTransaction();

        if (!$transaction) {
            $connection = new Connection();
        } else {
            $connection = $transaction->getConnection();
        }

        QueryExecutor::executeUpdate($sqlQuery, $connection);
        
        return mysqli_insert_id($connection->connection);
    }

    /**
     * Ejecuta la consulta SQL especificada y retorna la primera fila del
     * conjunto de filas obtenidas.
     *
     * @param SqlQuery Consulta SQL a ejecutar
     *
     * @return <type> Primer resultado del conjunto objtenido de ejecutar la query.
     */
    public static function queryForString($sqlQuery) {
        $transaction = Transaction::getCurrentTransaction();

        if (!$transaction) {
            $connection = new Connection();
        } else {
            $connection = $transaction->getConnection();
        }

        $result = $connection->executeQuery($sqlQuery->getQuery());

        if (!$result) {
            throw new Exception(mysqli_error($connection->connection));
        }

        $row = mysqli_fetch_array($result);

        return $row[0];
    }

}

?>