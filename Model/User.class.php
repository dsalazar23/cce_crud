<?php

/**
 * Esta clase representa el modelo de la tabla 'users'
 *
 * @package     Model
 * @author      JpBaena13
 * @since       PHP 5
 */
class User extends genUser {

    /**
     * Permite retornar el nombre completo del usuario. Este está constituido
     * por el firtsname + lastname 
     * 
     * @return Retornar el nombre completo del usuario
     */
    public function getFullname() {
        if ($this->getFirstname() == '' && $this->getLastname() == '')
            return $this->getUsername();

        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * Configura la constraseña del usuario con una encriptación AES además de
     * agregarle al final de la cadena el correo del usuario.
     * Esto permite que dos contraseña de usuario iguales queden encriptadas
     * de dos formas diferente.
     *
     * @param string $password Contraseña sin encriptar del usuario.
     */
    public function setPassword($password) {
        $this->userDTO->password = aesEncrypt($password . $this->getUsername());
    }

    /**
     * Realiza el checkeo de autenticación de acuerdo a los valores
     * de $userdata y $password especificados por el usuario.
     *
     * @param string $userdata Nombre de usuario o correo electrónico del usuario
     * @param string $password Contraseña de validación encriptada.
     *
     * @return $user Instancia del usuario si este existe y coincide con la contraseña
     *         de lo contrario retorna un número de acuerdo a lo siguiente:
     *          
     *          <ul>
     *              <li> 1 => Cuando el email o nombre de usuario no existe</li>
     *              <li> X => Cuando el password no coincide con el username o email retorne el número 
     *              		  de intentos fallidos consecutivos que se han hecho para ese usuario.
     *              </li>
     *          </ul>
     */
    public static function getInstance($userdata, $password) {
        
        //Expresión regular para validación de $userdata como correo electrónico.
        $regExpEmail = '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/';
        
        //Determina el modo autenticación. Puede ser usando el username o al email
        if (preg_match($regExpEmail, $userdata)) {
            $userDTO = FactoryDAO::getUserDAO()->queryByEmail($userdata);
            
        } else {
            $userDTO = FactoryDAO::getUserDAO()->queryByUsername($userdata);
        }
        
        if (!$userDTO)
                return 0;	// El correo o nombre de usuario no existe
        
        $user = new User();
        $user->userDTO = $userDTO;
        
        // Verificando que usuario y contraseña conincidan
        if ($user->getPassword() != aesEncrypt($password . $user->getUsername())) {            
            return 0;
        }
            
        return $user;
    }

    /**
     * Retorna una instancia de User asociado al email especificado o null
     * en caso contrario.
     * 
     * @param  string $email Correo electrónico del usuario a retornar
     * 
     * @return User Usuario asociado al correo eléctrónico
     */
    public static function getUserByEmail($email) {

        $userDTO = FactoryDAO::getUserDAO()->queryByEmail($email);

        if (!$userDTO)
            return null;

        $user = new User();
        $user->setUserDTO( $userDTO );

        return $user;
    }

    /**
     * Retorna una instancia de User asociado al username especificado o null
     * en caso contrario.
     * 
     * @param  string $username Nombre de usuario asociado al <User> a retornar.
     * 
     * @return User Usuario asociado al username
     */
    public static function getUserByUsername($email) {

        $userDTO = FactoryDAO::getUserDAO()->queryByUsername($email);

        if (!$userDTO)
            return null;

        $user = new User();
        $user->setUserDTO( $userDTO );

        return $user;
    }
}
?>