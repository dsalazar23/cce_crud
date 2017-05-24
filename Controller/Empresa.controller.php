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
		$empresaDTOs = FactoryDAO::getEmpresaDAO()->queryEmpresasWithIntereses();
		
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
		
	}

	/**
	 * @GET /Expert/Delete/id
	 *
	 * @AUTHORIZE
	 */
	public function Delete() {
		
	}

	/**
	 * @GET /Expert/Edit/id
	 *
	 * @AUTHORIZE
	 */
	public function Edit() {
		
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