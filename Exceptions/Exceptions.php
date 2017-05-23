<?php
/**
 * Excepción general
 *
 * @package     Exception
 * @author      JpBaena13
 * @since       PHP 5
 */

/**
 * Excepción lanzada cuando una petición HTTP contiene
 * un /Controller que no existe.
 */
	class ControllerNotFoundException extends Exception {

		/**
		 * Contructor de clase
		 */
		function __construct($message = 'Controller not found', $code = 30, Exception $previous = null) {
			header('HTTP/1.0 404 Not Found');
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @override
		 * Retorna un string formateado que será mostrado
		 */
	    public function __toString() {
	        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	    }

	}

/**
 * Excepción lanzada cuando una petición HTTP contiene
 * un /Controller/Method que no existe.
 */
	class MethodNotImplementedException extends Exception {

		/**
		 * Contructor de clase
		 */
		function __construct($message = 'Method not implemented', $code = 40, Exception $previous = null) {
			header('HTTP/1.0 501 Not Implemented');
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @override
		 * Retorna un string formateado que será mostrado
		 */
	    public function __toString() {
	        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	    }

	}

/**
 * Excepción lanzada cuando un método @AJAX no es solicitado mediante este mecanismo.
 */
	class AJAXRequestException extends Exception {

		/**
		 * Contructor de clase
		 */
		function __construct($message = "Bad AJAX Request", $code = 60, Exception $previous = null) {
			header('HTTP/1.0 400 Bad Request');
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @override
		 * Retorna un string formateado que será mostrado
		 */
	    public function __toString() {
	        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	    }
	}

/**
 * Excepción lanzada cuando un <request> no está bien especificado
 */
	class BadRequestException extends Exception {

		/**
		 * Contructor de clase
		 */
		function __construct($message = "Bad Request", $code = 400, Exception $previous = null) {
			header('HTTP/1.0 400 Bad Request');
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @override
		 * Retorna un string formateado que será mostrado
		 */
	    public function __toString() {
	        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	    }
	}

/**
 * Excepción lanzada un /Controller/Method requiere autenticación y ésta no exite.
 */
	class AuthenticationRequiredException extends Exception {

		/**
		 * Contructor de clase
		 */
		function __construct($message = "Authentication Required", $code = 401, Exception $previous = null) {
			header('HTTP/1.0 401 Unauthorized');
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @override
		 * Retorna un string formateado que será mostrado
		 */
	    public function __toString() {
	        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	    }
	}

/**
 * Excepción lanzada cuando no hay permisos sobre el usuario para ejecutar un /Controller/Method especifico.
 */
	class NotAuthorizedException extends Exception {

		/**
		 * Contructor de clase
		 */
		function __construct($message = "The user hasn't authorized the application to perform this action", $code = 403, Exception $previous = null) {
			header('HTTP/1.0 403 Forbidden');
			parent::__construct($message, $code, $previous);
		}

		/**
		 * @override
		 * Retorna un string formateado que será mostrado
		 */
	    public function __toString() {
	        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	    }
	}