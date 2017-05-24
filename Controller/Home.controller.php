<?php
/**
 * Controlador para el contenido inicial, que no requiere auntenticación
 *
 * @package     Controller
 * @author      JpBaena13
 * @since       PHP 5
 */


require_once CONTROLLER . 'Controller.php';
require_once CONTROLLER . 'Empresa.controller.php';

/**
 * Controlador para Home
 */
class HomeController extends Controller {

	/**
	 * @GET /Home
	 *
	 * @IGNORE
	 */
	public function DefaultView() {
		global $auth;

		if ( $auth->hasSession() ) {
			new EmpresaController();

		} else {
			include_once PAGE . 'Home.php';
		}
	}
}