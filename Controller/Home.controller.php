<?php
/**
 * Controlador para el contenido inicial, que no requiere auntenticación
 *
 * @package     Controller
 * @author      JpBaena13
 * @since       PHP 5
 */


require_once CONTROLLER . 'Controller.php';

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
			$userDTO = $this->user->getUserDTO();
			include_once PAGE . 'Index.php';

		} else {
			include_once PAGE . 'Home.php';
		}
	}
}