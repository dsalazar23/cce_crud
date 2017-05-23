<?php
/**
 * Clase base de controlador.
 *
 * @package     Controller
 * @author      JpBaena13
 * @since       PHP 5
 */

abstract class Controller {

	// Instancia del usuario autenticado
	protected $user = null;

	/**
	 * Contructor de clase, se encarga de llamar al método especificado
	 * como parámetro GET.
	 *
	 * @param string $action Nombre del método de clase que se ejecutará por defecto.
	 * @param boolean $applyAnnotations Determina si se aplican o no las anotaciones del método.
	 * @param array $arguments Arreglo de argumentos que serán pasados al método $action.
	 */
	function __construct($action = null, $applyAnnotations = true, $arguments = array() ) {

		try {

			if ($action === null)
				$action = !empty( $_GET['action'] ) ? $_GET['action'] : null;

			$this->user = isset( $_SESSION['user'] ) ? $_SESSION['user'] : new User();
			
			if ($action === null || empty($action)) {
				if ($applyAnnotations)
					$this->ApplyAnnotations($this, 'DefaultView');

				$this->DefaultView();

			} else if (method_exists( $this, $action )) {
				
				if ($applyAnnotations)
					$this->ApplyAnnotations($this, $action);

				eval('$this->' . $action . '($arguments);');
				
			} else if ($action == 'API') {
				$action =  $_SERVER['REQUEST_METHOD'];

				if ($applyAnnotations)
					$this->ApplyAnnotations($this, $action);

				if ( $action == 'PUT' || $action == 'DELETE') {					
					$params = Array();
					parse_str(file_get_contents('php://input'), $params);

					eval('$this->' . $action . '($params);');

				} else {
					eval('$this->' . $action . '();');
				}

			} else {
				throw new MethodNotImplementedException();
			}

		} catch (Exception $exc) {
			throw $exc;
		}
	}

	/**
	 * Implementación de vista por defecto
	 */
	public abstract function DefaultView();


	/**
	 * Valida todas las 'Anotaciones' que contiene el método especificado. 
	 * Estas anotaciones permiten determinar cierto comportamiento
	 * específico para el método en particular. Dentro de las 'anotaciones' encontramos:
	 *
	 * @AUTHORIZE -> Determina si el método require de autenticación para poder proceder.
	 *
	 * @IGNORE -> Procede a mostrar la vista independiente de si el usuario está autenticado o no.
	 *
	 * @GET / @POST / @PUT / @DELETE -> Determina el tipo del método en la solicitud, si no lo cumple retorna error 404.
	 *
	 * @JSON -> Indica que el método debe de retornar un objeto JSON.
	 * 
	 * @param  object $class  Objeto que representa la clase controladora a la que pertenece el método.
	 * @param  string $action String que representa el nombre del método que ejerce la acción.
	 * 
	 */
	private function ApplyAnnotations($class, $action) {
		$foo = new ReflectionMethod($class, $action);

		$modifier = implode(
					    Reflection::getModifierNames(
					        $foo->getModifiers()
					    )
					);

		// Sólo métodos públicos pueden ser accedidos mediante una solicitud HTTP.
		if ($modifier !== 'public')
			throw new ControllerNotFoundException();

		preg_match_all('(@\w+\b)', $foo->getDocComment() ,$annotations);

		$annotations = $annotations[0];

		if (in_array('@GET', $annotations) && in_array('@POST', $annotations)) {
            if ( $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST' )
				throw new ControllerNotFoundException();

		} else if (in_array('@GET', $annotations)) {
            if ( $_SERVER['REQUEST_METHOD'] !== 'GET')
				throw new ControllerNotFoundException();

        } else if (in_array('@POST', $annotations)) {
            if ( $_SERVER['REQUEST_METHOD'] !== 'POST')
				throw new ControllerNotFoundException();

        } else if (in_array('@DELETE', $annotations)) {
            if ( $_SERVER['REQUEST_METHOD'] !== 'DELETE')
				throw new ControllerNotFoundException();

        } else if (in_array('@PUT', $annotations)) {
            if ( $_SERVER['REQUEST_METHOD'] !== 'PUT')
				throw new ControllerNotFoundException();
			
        } else {
        	throw new ControllerNotFoundException();
        }

		$json = null;
        if (in_array('@JSON', $annotations)) {
        	header('Content-Type: application/json');
        	$json = true;
        }

        if (in_array('@AJAX', $annotations)) {
        	if ( !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND 
        				strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ) {

        		throw new AJAXRequestException();
        	}

        	$json = false;
        }
        
        if (in_array('@IGNORE', $annotations)) {
            return;
        }

        global $auth;
        $hasSession = $auth->hasSession($json);

        if (in_array('@AUTHORIZE', $annotations)) {
            if (!$hasSession) {
            	header('Location: ' . ROOT_URL . 'Login?uri=' . urlencode($_SERVER['REQUEST_URI']));
                exit();
            }
        } else {
        	if ($hasSession) {
        		unset($_GET['controller']);
        		unset($_GET['action']);
        		unset($_GET['id']);

        		$get = '?';
        		foreach ($_GET as $key => $value) {
        			$get = $get . $key . '=' . $value . '&';
        		}        		

        		header('Location: ' . ROOT_URL . $get);
                exit();
        	}
        }
	}
}