<?php

/**
 * Esta clase representa el DAO para la tabla 'intereses_empresa'
 *
 * @package     DataAccess.dao
 * @subpackage  mysql
 * @author      JpBaena13
 * @since       PHP 5
 */
class InteresesEmpresaMsDAO extends genInteresesEmpresaMsDAO {

	/*
		Función para actualizar intereses de una empresa cuando se edita.
	*/

	public function queryUpdateInteresesByEmpresas($idEmp, $intr){

		$sql = "DELETE FROM intereses_empresa WHERE empresa = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idEmp);
		$del = QueryExecutor::execute($sqlQuery);

		if (!$del){
			echo "No se hizo el borrado de intereses";
			exit;
		}

		foreach ($intr as $it) {
			$interesesEmpresa = new InteresesEmpresa(null);
			$interesesEmpresa->setInteresEmpresa($it);
			$interesesEmpresa->setEmpresa($idEmp);
			$interesesEmpresa->save();
		}


	}

	
}
?>