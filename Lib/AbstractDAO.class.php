<?php

/**
 * Clase Abstracta que es implementada por los DAO generados para la
 * ejecución de las consultas.
 * 
 * @package     Lib
 * @author      JpBaena13
 * @since       PHP 5
 */
abstract class AbstractDAO {
    
    /**
     * Retorna la lista de registro.
     *
     * @param SqlQuery $sqlQuery
     *        Consulta SQL a ejecutar.
     *
     * @return array Conjunto de registros obtenidos de ejecutar la consulta.
     */
    protected function getList($sqlQuery) {
        $tab = QueryExecutor::execute($sqlQuery);
        $ret = array();

        for($i = 0; $i < count($tab); $i++) {
            $ret[$i] = $this->readRow($tab[$i]);
        }

        return $ret;
    }

    /**
     * Retorna una fila de la tabla resultante de ejecutar la
     * consulta SQL especificada.
     *
     * @param SqlQuery
     * @return Dato
     */
    protected function getRow($sqlQuery) {
        $tab = QueryExecutor::execute($sqlQuery);
        if(count($tab)==0) {
            return null;
        }

        return $this->readRow($tab[0]);
    }

    /**
     * Ejecuta una sentencia SQL.
     *
     * @param SqlQuery $sqlQuery
     *        Sentencia SQl a ejecutar.
     */
    protected function execute($sqlQuery){
        return QueryExecutor::execute($sqlQuery);
    }

    /**
     * Ejecuta una sentencia SQL con múltiples consultas.
     *
     * @param SqlQuery $sqlQuery
     *        Sentencia SQl a ejecutar.
     */
    protected function multi_execute($sqlQuery){
        return QueryExecutor::multi_execute($sqlQuery);
    }

    /**
     * Ejecuta una sentencia SQL de tipo actualización.
     *
     * @param SqlQuery $sqlQuery
     *        Sentencia SQl a ejecutar.
     */
    protected function executeUpdate($sqlQuery){
        return QueryExecutor::executeUpdate($sqlQuery);
    }

    /**
     * Ejecuta una sentencia SQL que returna un único resultado como fila o columna.
     *
     * @param SqlQuery $sqlQuery
     *        Sentencia SQl a ejecutar.
     */
    protected function querySingleResult($sqlQuery){
        return QueryExecutor::queryForString($sqlQuery);
    }

    /**
     * Ejectura una sentencia SQL de tipo inserción.
     *
     * @param SqlQuery $sqlQuery
     *        Sentencia SQl a ejecutar
     */
    protected function executeInsert($sqlQuery){
        return QueryExecutor::executeInsert($sqlQuery);
    }
}

?>
