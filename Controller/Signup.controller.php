<?php
/**
 * Controlador para la página de creación de cuenga
 *
 * @package     Controller
 * @author      JpBaena13
 * @since       PHP 5
 */


require_once CONTROLLER . 'Controller.php';


/**
 * Controlador para Signup
 */
class SignupController extends Controller {

	/**
	 * @GET /Signup
	 */
	public function DefaultView() {
	}

	/**
	 * Permite determinar si parámetro GET coincide como nombre de usuario
	 * o email con alguno en la base de datos.
	 * 
	 * Imprime 'true' si no hay coincidencia, de lo contrario 'false'
	 *
	 * @GET /Signup/Validate
	 *
	 * @IGNORE
	 */
	public function Validate() {
		$keys = array_keys($_GET);
		$userdata = isset($_GET['username']) ? $_GET['username'] : (isset($_GET['email']) ? $_GET['email'] : null);

        //Expresión regular para validación de $userdata como correo electrónico.
        $regExpEmail = '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/';
        
        if (preg_match($regExpEmail, $userdata)) {
            $user = User::getUserByEmail($userdata);
        } else {
            $user = User::getUserByUsername($userdata);
        }

        echo ($user === null) ? 'true' : 'false';
	}

	/**
	 * Crea una nueva cuenta de acuerdo a los parámetros especificados
	 *
	 * @POST /Signup/CreateAccount
	 */
	public function CreateAccount() {
		$user = new User();
		$user->setFirstname( $_POST['firstname'] );
		$user->setLastname( $_POST['lastname'] );
		$user->setUsername( $_POST['username'] );
		$user->setEmail( $_POST['email'] );
		$user->setPassword( $_POST['password'] );

		$user->save();

        global $auth;
        $auth->login($user, ROOT_URL);
	}
}