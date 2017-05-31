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
		$sql = "SELECT empresas.id, empresas.nombre_empresa, intereses.nombre
				FROM empresas 
				INNER JOIN intereses_empresa 
				ON empresas.id = intereses_empresa.empresa
				INNER JOIN intereses
				ON intereses_empresa.interes_empresa = intereses.id";

		$sqlQuery = new SqlQuery($sql);

		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();  //arreglo de EmpresaDTO


		if(count($tab) != 0)
		{
			$row = $tab[0];
			$empresaActual = $row['id'];
		} else{
			return $ret;

		}
		
		$i = 0;
		$row;

		while ($i < count($tab)) {
			
			
				$row = $tab[$i];
				$guardarIntereses = true;
				$interesesEmpresa = array();
			
				if($guardarIntereses == true)
				{
					$empresaDTO = new EmpresaDTO();
					$empresaDTO->id = $row['id'];
					$empresaDTO->nombreEmpresa = $row['nombre_empresa'];
					for($e = $i; $e < count($tab); $e++)
					{	
						//se controla el final de la consulta para guardar la última empresaDAO
						if($e == (count($tab) - 1))
						{
							$row = $tab[$e];
							array_push($interesesEmpresa, $row['nombre']);
							$empresaDTO->intereses = $interesesEmpresa; //se asigna el arreglo de intereses
							array_push($ret, $empresaDTO);				//se encola el último DTO
							$e++;
							$i = $e;
							$guardarIntereses = false;

						} else{						//si todavía no he llegado a la última fila de la consulta
							$row = $tab[$e];
							if($row['id'] == $empresaActual)
							{
								array_push($interesesEmpresa, $row['nombre']);
								
							} else{
								$empresaDTO->intereses = $interesesEmpresa; //se asigna el arreglo de intereses ya que se cambio de empresa y no hay mas intereses de la empresa actual que ingresar. 											
								$empresaActual = $row['id'];
								$i = $e;
								array_push($ret, $empresaDTO); //se encola la siguiente empresaDTO al arreglo de empresasDTO 
								$guardarIntereses = false;
								$e = count($tab) + 1;
							}	
						}			
						
					}				
				}
			
		}

		return $ret;
			
	}
}

?>