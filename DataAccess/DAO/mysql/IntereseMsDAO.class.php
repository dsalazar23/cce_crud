<?php

/**
 * Esta clase representa el DAO para la tabla 'intereses'
 *
 * @package     DataAccess.dao
 * @subpackage  mysql
 * @author      JpBaena13
 * @since       PHP 5
 */
class IntereseMsDAO extends genIntereseMsDAO {

	public function queryDeleteInteresesByEmpresa($id){

		$sql = 'DELETE FROM intereses_empresa 
				WHERE empresa =' . $id;

		$sqlQuery = new SqlQuery($sql);
		$resultQuery = QueryExecutor::execute($sqlQuery);

		return $resultQuery;
	}

	public function queryGetByEmpresa($idEmpresa){

		$sql = 'SELECT * FROM intereses_empresa 
				WHERE empresa =' . $idEmpresa;

		$sqlQuery = new SqlQuery($sql);
		$resultQuery = QueryExecutor::execute($sqlQuery);
		$result = [];
		
		foreach ($resultQuery as $row) {
			array_push($result, $row);
		}

		return $result;
	}
	
}
?>