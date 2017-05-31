<?php
/**
 * Controlador para Empresas
 *
 * @package     Controller
 * @author      JpBaena13
 * @since       PHP 5
 */


require_once CONTROLLER . 'Controller.php';

/**
 * Controlador para Empresas
 */
class EmpresaController extends Controller {

	/**
	 * @GET /Home
	 *
	 * @AUTHORIZE
	 */
	public function DefaultView() {
		$empresaDTOs = FactoryDAO::getEmpresaDAO()->queryEmpresasWithIntereses();
		
		include_once PAGE . 'Empresas.list.php';
	}

	/**
	 * @GET /Empresa/NewEmpresa
	 *
	 * @AUTHORIZE
	 */
	public function NewEmpresa() {

		$interesesDTOs = FactoryDAO::getIntereseDAO()->queryAll();

		include_once PAGE . 'Empresa.new.php';
	}

	/**
	 * @POST /Empresa/Save
	 *
	 * @AUTHORIZE
	 */
	public function Save() {
		$idEmpresa = isset($_GET['id']) ? $_GET['id'] : null;

		$empresa = new Empresa($idEmpresa);
		$empresa->setNombreEmpresa($_POST['nombre']);
		$empresa->setLogo($_POST['logo']);
		$empresa->setDescripcion($_POST['descripcion']);
		$empresa->setUrl($_POST['url']);
		$empresa->save();

		$idEmpresa = $empresa->getId();

		$inter = $_POST['intereses'];
		foreach ($inter as $it) {
			$interesesEmpresa = new InteresesEmpresa(null);
			$interesesEmpresa->setInteresEmpresa($it);
			$interesesEmpresa->setEmpresa($idEmpresa);
			$interesesEmpresa->save();
		}

		header('Location: ' . ROOT_URL );	
		
	}

	/**
	 * @GET /Empresa/Delete/id
	 *
	 * @AUTHORIZE
	 */
	public function Delete() {
		
		$interesesByEmpresasDeleted = FactoryDAO::getIntereseDAO()->queryDeleteInteresesByEmpresa($_GET['id']);

		if ($interesesByEmpresasDeleted) {
			Empresa::delete($_GET['id']);
			header('Location: ' . ROOT_URL );
		}
		else
		{
			header('Location: ' . ROOT_URL );			
		}




	}

	/**
	 * @GET /Empresa/Edit/id
	 *
	 * @AUTHORIZE
	 */
	public function Edit() {
		
		$empresa = new Empresa($_GET['id']);
		$empresaDTO = $empresa->getEmpresaDTO();
		$interesesToEdit = FactoryDAO::getIntereseDAO()->queryGetByEmpresa($empresaDTO->id);
		$interesesDTOs = FactoryDAO::getIntereseDAO()->queryAll();

		// echo "<pre>";
		// print_r($interesesToEdit);
		// echo "</pre>";
		// exit;

		include_once PAGE . "Empresa.edit.php";
	}

	/**
	 * @GET /Empresa/Cancel/
	 *
	 * @AUTHORIZE
	 */
	public function Cancel() {
		header('Location: ' . ROOT_URL );
	}
}