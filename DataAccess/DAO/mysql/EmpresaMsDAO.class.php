<?php

/**
 * Esta clase representa el DAO para la tabla 'empresas'
 *
 * @package     DataAccess.dao
 * @subpackage  mysql
 * @author      JpBaena13
 * @since       PHP 5
 */
class EmpresaMsDAO extends genEmpresaMsDAO {

	/*
	 *	Query que retorna todas las empresas con sus intereses asociados.
	*/

	public function queryEmpresasWithIntereses (){
		$sql = "SELECT empresas.id_empresa, empresas.nombre_empresa, intereses.nombre
				FROM empresas 
				INNER JOIN intereses_empresa 
				ON empresas.id_empresa = intereses_empresa.empresa
				INNER JOIN intereses
				ON intereses_empresa.interes_empresa = intereses.id";

		$sqlQuery = new SqlQuery($sql);

		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();


		if(count($tab) != 0)
		{
			$row = $tab[0];
			$empresaActual = $row['id_empresa'];
			$interesesEmpresa = array();
			$empresaDTOs = array();
		} else{

		}

		for ($i = 0; $i < count($tab); $i++) {
			$row = $tab[$i];
			$guardarIntereses = true;
			$interesesEmpresa = array();

			if($guardarIntereses == true)
			{
				$empresaDTO = new EmpresaDTO();
				$empresaDTO->idEmpresa = $row['id_empresa'];
				$empresaDTO->nombreEmpresa = $row['nombre_empresa'];
				for($e = 0; $e< count($tab); $e++)
				{
					$row = $tab[$e];
					if($row['id_empresa'] == $empresaActual)
					{
						array_push($interesesEmpresa, $row['nombre']);
					} else{
						$EmpresaDTO->intereses = $interesesEmpresa;
						$empresaActual = $row['id_empresa'];
						$e = $e - 1;
						$i = $e;
						$guardarIntereses = false;
						$e = count($tab);
					}
					
					
				}				
			}
		}
	
}
?>