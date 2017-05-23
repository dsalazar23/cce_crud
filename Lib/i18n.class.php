<?php

/**
 * Esta clase maneja la internacionalización del proyecto.
 * Una instancia es solicitada dentro de una página cuando esta requiere aplicar
 * cadenas internacionalizadas.
 *
 * @package     Lib
 * @author      JpBaena13
 * @since       PHP 5
 */

class i18n {

    private static $instance = null;

    private static $dicc = null;

    public static $lang = null;

    /**
     * Constructor privado de clase
     */
    private function __construct() {}    


    /**
     * Iniciador de clase de clase, aplicando el patrón singleton.
     *
     * @staticvar i18n $instance
     * @return i18n
     */
    private static function &_instance() {
        
        if (is_null(self::$instance)) {
            self::$instance = new i18n();
        }

        return self::$instance;
    }

    /**
     * Inicializa los valores de los métodos del <code>gettext</code> para
     * especificar la ubicación de los archivos .mo y la codificación a
     * utilizar.
     *
     * @return Instancia única de tipo <code>i18n</code>
     */
    static function init() {
        //Lenguaje por defecto
        self::$lang = 'es_ES';

        if ( isset($_GET['lang']) )
            switch ($_GET['lang']) {
                case 'es':
                    self::$lang = 'es_ES';
                    break;
                case 'en':
                    self::$lang = 'en_US';
                    break;
                case 'pt':
                    self::$lang = 'pt_PT';
                    break;
            }
        else if ( isset($_COOKIE[PRJCT_NAME . '_lang']) )
            self::$lang = $_COOKIE[PRJCT_NAME . '_lang'];
            
        /* código para gettext, pero no funciona en winx64
                // Define el idioma
                echo putenv("LC_ALL=self::$lang");
                echo setlocale(LC_ALL, self::$lang);

                // Define la ubicación de los ficheros de traducción
                $domain = 'messages';

                if (!function_exists("bindtextdomain")) {
                    trigger_error('bindtextdomain function do not exist');
                    return;
                }
                
                echo bindtextdomain($domain, "locale");
                echo bind_textdomain_codeset($domain, "UTF8");
                echo textdomain($domain);
        */
       
        require_once (LOCALE . self::$lang . '.php');
        self::$dicc = $dicc;

        $instance = &i18n::_instance();

        return $instance;
    }

    /**
     * Retorna las 2 primeras letras del lenguaje configurado
     * por el suario.
     * 
     * @return string Lenguaje configurado para la página
     */
    public static function getLang() {
        return substr(self::$lang, 0, 2);
    }

    /**
     * Realiza un <code>echo</code> del valor internacionalizado correspondiente
     * a la clave pasada como parámetro.
     *
     * @param string $label
     *        Clave a internacionalizar.
     */
    function __($label) {
        if (isset( self::$dicc[ $label ])) {
            echo self::$dicc[ $label ];
        } else {
            echo $label;
        }
        // echo gettext("$label");
    }

    /**
     * Retorna el valor internacionalizado correspondiente a la clave pasada
     * como parámetro.
     *
     * @param string $label
     *        Clave a internacionalizar.
     *
     * @return string
     *         Valor internacionalizado de la clave.
     */
    function get($label) {
        if (isset( self::$dicc[ $label ])) {
            return self::$dicc[ $label ];
        } else {
            return $label;
        }
        // return gettext("$label");
    }

}

?>
