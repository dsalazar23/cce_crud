<?php
/**
 * Controlador para la página autenticación de usuario
 *
 * @package     Controller
 * @author      JpBaena13
 * @since       PHP 5
 */


require_once CONTROLLER . 'Controller.php';

/**
 * Controlador para Login
 */
class LoginController extends Controller {

	/**
	 * @GET /Login
	 */
	public function DefaultView() {
		include_once PAGE . 'Home.php';
	}

	/**
	 * Inicia la sesión de usuario de acuerdo a los parámetros POST
	 * envíados desde el formulario web.
	 *
	 * @POST /Login/Authenticate
	 */
	public function  Authenticate() {
		global $auth;

		$userdata = $_POST['email'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember']);
        $uri      = isset($_POST['uri']) ? $_POST['uri'] : ROOT_URL;

        if ($userdata == '' || $password == '') {
            header('Location: ' . ROOT_URL . '?error=1');
            exit();
        }

        $auth->login( User::getInstance($userdata, $password), $uri, $remember );
	}

	/**
	 * Limpia la sesión de usuario.
	 *
	 * @GET /Login/Clear
	 *
	 * @IGNORE
	 */
	public function Clear() {
		global $auth;
		$auth->logout();
	}
}