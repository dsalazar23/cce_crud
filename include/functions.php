<?php
/**
 * Conjunto de funciones comunes a cualquier página.
 *
 * @package     include
 * @author      JpBaena13
 * @since       PHP 05
 */

require_once LIB . 'AES.class.php';

/**
 * Inicializando la internationalization
 */
$i18n = i18n::init();

/**
 * Realiza un <code>echo</code> del valor internacionalizado correspondiente
 * a la clave pasada como parámetro.
 *
 * @param string $label
 *        Clave a internacionalizar.
 */
    function __($label) {
        global $i18n;
        return $i18n->__($label);
    }

/**
 * Retorna valor internacionalizado correspondiente
 * a la clave pasada como parámetro.
 *
 * @param string $label
 *        Clave a internacionalizar.
 */
    function label($label) {
        global $i18n;
        return $i18n->get($label);
    }

    

/**
 * Imprime el mensaje espécificado en el archivo de server.log en el directorio tmp
 * Tiene 3 modos de uso:
 * <ul>
 *      <li>Modo 0: Limpia el todo el archivo y escibe el nuevo mensaje</li>
 *      <li>Modo 1: Concatena el nuevo mensaje con lo que hay en archivo sin separación</li>
 *      <li>Modo 2: Concatena el nuevo mensaje con lo que hay en archivo separados por asteriscos ***</li>
 * </ul>
 *
 * @param string $log
 *        Mensaje a imprimir sobre el archivo server.log.
 *
 * @param int $flag
 *        Determina el modo en que desea imprimir el mensaje sobre archivo
 *
 */
    function printLog($log, $flag = 1, $file = 'server.log') {

        if ($flag == 0) {
            $fw = fopen(ROOT . 'tmp' . DS . $file, "w");
            fwrite($fw, $log);
            fclose($fw);
            return;
        }

        $fr = fopen(ROOT . 'tmp' . DS . $file , "r");
        $ret = '';
        while (!feof($fr)) {
            $buffer = fgets($fr, 4096);
            $ret .= $buffer;
        }

        fclose($fr);

        if ($flag == 2) {
            $ret .= "\n" . $log;
        } else {
            if (empty ($ret))
                $ret .= $log;
            else
                $ret .= "\n" . $log;
        }

        $fw = fopen(ROOT . 'tmp' . DS . $file, "w");
        fwrite($fw, $ret);
        fclose($fw);
    }

/**
 * Genera un string aleatorio.
 *
 * @param int $length
 *        Tamaño del string que retornara la función.
 *
 * @param string $keychars
 *        Caracteres que se incluiran dentro de la cadena de retorno.
 *
 */
    function randomKey($length = 10, $keychars = '') {
        if ($keychars == '') {
            $keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }

        $randkey = "";
        $max = strlen($keychars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $randkey .= substr($keychars, rand(0, $max), 1);
        }
        return $randkey;
    }

/**
 * Encripta una cadena dada.
 *
 * @param string $key
 *        clave con la que se encriptara la cadena Ej.
  * <ul>
 *      <li>"abcdefgh01234567" // 128-bit key</li>
 *      <li>"abcdefghijkl012345678901" // 192-bit key</li>
 *      <li>"abcdefghijuklmno0123456789012345" // 256-bit key</li>
 * </ul>
 * @param string $strToEncrypt
 *        Cadena de texto a encriptar.
 *
 */
    function aesEncrypt($strToEncrypt, $key = 'skeleton2014') {
        $initialization_vector = 'Sk3l3t0n*e2s306';
        $removeStr = array("@", "/", "-", "_", ".", " ");

        $z = str_replace($removeStr, "", $key);

        if (strlen($z) != 24){
            if (strlen($z) < 24){
                $z = str_pad($z, 24, '*', STR_PAD_RIGHT);
            }
            if (strlen($z) > 24){
                $z = substr($z, 0, 24);
            }
        }

        $aes = new AES($z, "CBC", $initialization_vector);

        return base64_encode($aes->encrypt($strToEncrypt));
    }

/**
 * Encripta una cadena dada.
 *
 * @param string $key
 *        clave con la que se desencriptara la cadena (debe ser la misma con la que se encripto.) Ej.
  * <ul>
 *      <li>"abcdefgh01234567" // 128-bit key</li>
 *      <li>"abcdefghijkl012345678901" // 192-bit key</li>
 *      <li>"abcdefghijuklmno0123456789012345" // 256-bit key</li>
 * </ul>
 * @param string $strToDecrypt
 *        Cadena de texto a desencriptar.
 *
 */
    function aesDecrypt($strToDecrypt, $key = 'skeleton2014') {
        $initialization_vector = 'Sk3l3t0n*e2s306';
        $removeStr = array("@", "/", "-", "_", ".", " ");

        $z = str_replace($removeStr, "", $key);

        if (strlen($z) != 24){
            if (strlen($z) < 24){
                $z = str_pad($z, 24, '*', STR_PAD_RIGHT);
            }
            if (strlen($z) > 24){
                $z = substr($z, 0, 24);
            }
        }

        $aes = new AES($z, "CBC", $initialization_vector);

        $strToDecrypt = base64_decode($strToDecrypt);

        return stripslashes($aes->decrypt($strToDecrypt));
    }
    
    /**
     * Permite retornar la constante especificada. Se usa en los arhivos Emails
     * de View para permitir usar una constante dentro de una sentencia
     * <<<EOF ... EOF;
     * 
     * @param string $constante Constante a retornar
     * 
     * @return string Constante especificada 
     */
    function cst($constante) {
        return $constante;
    }
    
    /**
     * Permite convertir un arreglo asociativo  a un formato JSON. Este formato 
     * está constituido de la siguiente manera:
     *
     * [{"id":"valor_id", "label":"valor_label", "value":"valor", ..}, {..}, ..]
     *
     * @param array $array
     *              Arreglo que será convertido en formato JSON
     *
     * @return string Cadena con elementos del arreglo especificado en formato JSON.
     */
     function array_to_json($array) {

        if (!is_array($array)) {
            return false;
        }

        $associative = count(array_diff(array_keys($array), array_keys(array_keys($array))));
        if ($associative) {

            $construct = array();
            foreach ($array as $key => $value) {

                // We first copy each key/value pair into a staging array,
                // formatting each key and value properly as we go.
                // Format the key:
                if (is_numeric($key)) {
                    $key = "key_$key";
                }
                $key = "\"" . addslashes($key) . "\"";

                // Format the value:
                if (is_array($value)) {
                    $value = array_to_json($value);
                } else if (!is_numeric($value) || is_string($value)) {
                    $value = "\"" . addslashes($value) . "\"";
                }

                // Add to staging array:
                $construct[] = "$key: $value";
            }

            // Then we collapse the staging array into the JSON form:
            $result = "{ " . implode(", ", $construct) . " }";
        } else { // If the array is a vector (not associative):
            $construct = array();
            foreach ($array as $value) {

                // Format the value:
                if (is_array($value)) {
                    $value = array_to_json($value);
                } else if (!is_numeric($value) || is_string($value)) {
                    $value = "'" . addslashes($value) . "'";
                }

                // Add to staging array:
                $construct[] = $value;
            }

            // Then we collapse the staging array into the JSON form:
            $result = "[ " . implode(", ", $construct) . " ]";
        }

        return $result;
    }
    
    /**
     * Permite recortar el texto diviendole en una o dos partes de acuerdo al
     * parámetro $ext. Si $ext es false recorta el texto en la longitud especificada
     * siempre y cuando éste sea mayor. 
     * 
     * @param string $text
     *               Cadena de caractéres original
     * 
     * @param int $length
     *            Cantidad de caracteres a la que se recortará la cadena.
     * 
     * @param boolean $ext
     *                Determina si solo se recorta al principio o tambien al final.
     * 
     * @return string
     *         Cadena de caracteres resultante. 
     */
    function clipText($text, $length = 20, $ext = false) {
        
        if ($ext) {
            $ext = substr($text, count($text) - 8);
            return (strlen($text) <= $length) ? $text : substr($text, 0, $length) . '...' . $ext;
        
        }  else {
            return (strlen($text) <= $length + 2) ? $text : substr($text, 0, $length) . '...';
        }
    }


/**
 * Permite la lectura de un archivo remoto
 * 
 * @param  string $url URL del archivo a solicitar.
 * 
 * @return string Respuesta obtenida desde la URL especificada
 */
    function file_get($url) { 
        if (strpos($url,'http://') !== FALSE) {
            $fc = curl_init();  
            curl_setopt($fc, CURLOPT_URL,$url); 
            curl_setopt($fc, CURLOPT_RETURNTRANSFER,1); 
            curl_setopt($fc, CURLOPT_HEADER,0); 
            curl_setopt($fc, CURLOPT_VERBOSE,0);    
            curl_setopt($fc, CURLOPT_SSL_VERIFYPEER,FALSE); 
            curl_setopt($fc, CURLOPT_TIMEOUT,30);   
            $res = curl_exec($fc);
            curl_close($fc);
        } 
        else 
            $res = file_get_contents($url);  
        
        return $res;
    }    
?>