<?php

/**
 * @generated
 * - Clase Generada Automaticamente - NO MODIFICAR MANUALMENTE
 * Interfaz DAO para la tabla '${table_name}'. - Database MySql. -
 *
 * @package     DataAccess.dao
 * @subpackage  interfaces
 * @author      JpBaena13
 * @since       PHP 5
 */
interface ${dao_class_name}DAOInterface {

    /**
     * Inserta un registro a la tabla '${table_name}'.
     *
     * @param ${dao_class_name} ${var_name}
     *        Objeto a insertar en la base de datos.
     *
     * @return <type> Clave primaria del registro insertado.
     */
    public function insert($${var_name});

    /**
     * Retorna el objeto de dominio que corresponde a la clave primaria especificada.
     *
     * @param string $id Clave primaria.
     *
     * @return ${dao_class_name} Objeto que tiene como clave primaria $id
     */
    public function load(${pk});
    
    /**
     * Actualiza el registro especificado en la tabla '${table_name}'
     *
     * @param ${dao_class_name} ${var_name}
     *        Objeto con los datos a actualizar en la tabla '${table_name}'
     * @see executeUpdate()
     */
    public function update($${var_name});

    /**
     * Elimina el registro especificado desde la base de datos.
     *
     * @param <type> ${pk} Clave primaria del registro a eliminar.
     */
    public function delete(${pk});

    /**
     * Retorna todos los registros de la tabla '${table_name}'.
     *
     * @return array Conjunto de registros de la tabla '${table_name}'.
     */
    public function queryAll();

    /**
     * Retorna todos los registros de la tabla '${table_name}' ordenado por
     * la columna especificada.
     *
     * @param string $orderColumn Nombre de la columna.
     *
     * @return array Conjunto de registros de la tabla '${table_name}' ordenados.
     */
    public function queryAllOrderBy($orderColumn);
    
    /**
     * Elimina todas las filas de la tabla '${table_name}'
     *
     * @see executeUpdate()
     */
    public function clean();

    /*
     * Las siguientes son el conjunto de funciones que permiten obtener registros
     * desde la tabla '${table_name}' a partir del valor en un campo particular.
     */
    ${queryByFieldFunctions}
    /*
     * Las siguiente son el conjunto de funciones que permiten eliminar registros
     * desde la tabla '${table_name}' a partir del valor en un campo particular
     */
    ${deleteByFieldFunctions}
}
?>