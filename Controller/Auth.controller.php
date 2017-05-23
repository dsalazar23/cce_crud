<?php
/**
 * Controlador para la autenticación de usuarios de UnNotes
 *
 * @package     Controller
 * @author      JpBaena13
 * @since       PHP 5
 */

class AuthController {
    
    /** Instancia de usuario desea autenticarse*/
    private $user;

    /**
     * Constructor 
     */
    function __construct() {
        session_start();

        $this->user = new User();
    }

    /**
     * Permite determinar si hay sesión de usuario activa o no.
     *
     * @param boolean $json Determina si la petición requiere retornar un objeto JSON o no.
     * 
     * @return boolean <true> si hay una sesión de usuario activa, <false> de lo contrario
     */
    public function hasSession($json = null) {
        if (!isset($_SESSION['userId'])) {
            return $this->refreshSession($json);
        }

        return true;
    }

    /**
     * Permite reactivar una sesión ya vencida si se encuentra en cookies, de
     * lo contrario lo envía al formulario de autenticación y guarda la URI
     * solicitada, a la cual será redireccionado en caso de una autenticación
     * correcta.
     * 
     * @param boolean $json Determina si la petición ajax requiere de retorno un objeto JSON o no.
     */
    private function refreshSession($json) {
        
        if (isset($_COOKIE['token'])) {

            try {
                $token = explode('-', aesDecrypt($_COOKIE['token']));
                $userId = $token[0];
                $user = new User($userId);

            } catch (Exception $exc) {
                setcookie('token', null, 0, '/');

                //TODO: Corregir $user=-1 para ajax
                $user = -1;
            }
            
            return $this->login($user, null);
            
        } else {
            if ($json === null) {
                return false;

            } else {
                throw new AuthenticationRequiredException();
            }
        }
    }

    /**
     * Proceso de autenticación de usuario
     *
     * @param User $user Si es diferente de null, significa que se está realizando
     *             una autenticación con usuario previamente creado.
     * 
     * @param string $uri Se configura con la uri a redireccionar cuando la sesión
     *               de usuario es reactivada. Si $uri es igual
     *               a null, se permite la continuación del llamado.
     *
     * @param boolean $remember Determina si el usuario decide quedar recordado
     *                          en el navegador. Si es <true> se crea una cookie
     *                          por duración de un mes.
     */
    public function login($user, $uri, $remember = false) {

        $this->user = $user;

        if (is_numeric($this->user)) {
            $error = ($this->user == -1) ? '' : 'error=' . $this->user;
            $uri = ($uri == ROOT_URL) ? '' : '&uri=' . urlencode($uri);

            header('Location: ' . ROOT_URL . '?' . $error . $uri);
            exit();
        }
        
        //Creando Variables de sesión
        $_SESSION['user']         = $this->user;
        $_SESSION['userId']       = $this->user->getId();
        $_SESSION['username']     = $this->user->getUsername();
        $_SESSION['fullname']     = $this->user->getFullname();

        // Cuando el usuario marco la casilla de 'recordarme'
        if ($remember) {
            $token = aesEncrypt($this->user->getId() . '-' .$this->user->getUsername());
            setcookie('token', $token, time() + 60*60*24*30, '/');
        }

        //Si $uri es <true> no redirecciona
        if ($uri === null) {
            return true;
        }
        
        header('Location: ' . $uri);
        exit();
    }

    /**
     * Actualiza las varibales de sesión cuando algún dato de perfil a cambiado
     *
     * @param User $user Instancia de usuario con los datos modificado.
     */
    public function refreshSessionVars($user) {
        $_SESSION['user']       = $user;
        $_SESSION['userId']     = $user->getId();
        $_SESSION['username']   = $user->getUsername();
        $_SESSION['fullname']   = $user->getFullname();
    }
    
    
    /**
     * Borra todas las variables de sesión y las cookies de usuario y permite
     * cerrar sesión de forma segura 
     */
    public function logout() {

        //Destruyendo variables de sesion
        unset($_SESSION['user']);
        unset($_SESSION['userId']);
        unset($_SESSION['username']);
        unset($_SESSION['fullname']);

        setcookie('token', null, 0, '/');
        session_destroy();

        header('Location: ' . ROOT_URL);
        exit();
    }
}
?>