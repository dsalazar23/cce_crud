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
 * Controlador para Home
 */
class EmpresaController extends Controller {

	/**
	 * @GET /Home
	 *
	 * @AUTHORIZE
	 */
	public function DefaultView() {
		$empresaDTOs = FactoryDAO::getEmpresaDAO()->queryAll();
		
		include_once PAGE . 'Empresas.list.php';
	}

	/**
	 * @GET /Expert/NewExpert
	 *
	 * @AUTHORIZE
	 */
	public function NewEmpresa() {
		include_once PAGE . 'Empresa.new.php';
	}

	/**
	 * @POST /Expert/Save
	 *
	 * @AUTHORIZE
	 */
	public function Save() {
		// $id = isset($_GET['id']) ? $_GET['id'] : null;

		// $expert = new User($id);
		// $expert->setNombre($_POST['nombre']);
		// $expert->setProfesion($_POST['profesion']);
		// $expert->setOcupacion($_POST['ocupacion']);
		// $expert->setEmail($_POST['email']);
		// $expert->setEspecialidades($_POST['especialidades']);

		// $expert->save();

		// header('Location: ' . ROOT_URL );
	}

	/**
	 * @GET /Expert/Delete/id
	 *
	 * @AUTHORIZE
	 */
	public function Delete() {
		if (!isset($_GET['id']) || $_GET['id'] == '1') {
			header('Location: ' . ROOT_URL );
			exit;
		}

		User::delete($_GET['id']);

		header('Location: ' . ROOT_URL );
	}

	/**
	 * @GET /Expert/Edit/id
	 *
	 * @AUTHORIZE
	 */
	public function Edit() {
		if (!isset($_GET['id']) || $_GET['id'] == '1') {
			header('Location: ' . ROOT_URL );
			exit;
		}

		$expert = new User($_GET['id']);
		$expertDTO = $expert->getUserDTO();

		include_once PAGE . 'Expert.edit.php';
	}

	/**
	 * @GET /Expert/Cancel/
	 *
	 * @AUTHORIZE
	 */
	public function Cancel() {
		header('Location: ' . ROOT_URL );
	}
}