<?php

/**
 * Permite leer el contenido de una plantilla para generar las clases
 * cambiar las palabras claves por valores particulares configurados por medio
 * del método set().
 *
 * @package     Lib
 * @author      JpBaena13
 * @since       PHP 5
 */
class Template {

    /** Nombre de la plantilla que será utilizada para crear una archivo php */
    private $template;

    /** Contenido de la plantilla especificada en <code>$template</code>*/
    private $content;

    /**
     * Inicializa las variables <code>$template</code> y <code>$content</code>
     * de acuerdo al contenido de la plantilla especificada.
     *
     * @param String $template
     *        Nombre de la plantilla
     */
    function Template($template) {
        $this->template = $template;
        $this->content = $this->getContent();
    }

    /**
     * Reempleza en el contenido obtenido de la plantilla las palabras claves
     * <code>$key</code> por el valor <code>$value</code> especificado.
     *
     * @param string $key
     *        Palabra clave a buscar en el contenido de la plantilla.
     *
     * @param string $value
     *        Valor a reemplazar por la palabra clave.
     */
    function set($key, $value) {
        $this->content = str_replace('${' . $key . '}', $value, $this->content);
    }

    /**
     * Retorna el contenido de la plantilla con el nombre especificado en la
     * variable <code>$template</code>.
     *
     * @return string Contenido de la plantilla especificada.
     */
    function getContent() {
        $ret = '';
        $uchwyt = fopen($this->template, "r");
        while (!feof($uchwyt)) {
            $buffer = fgets($uchwyt, 4096);
            $ret .= $buffer;
        }
        fclose($uchwyt);
        return $ret;
    }

    /**
     * Escribe en un archivo con nombre <code>$fileName</code> especificado
     * el contendio de la plantilla con las palabras claves configuradas a sus
     * valores reales.
     *
     * @param string $fileName
     *        Nombre del archivo.
     */
    function write($fileName) {
        echo $fileName . '<br/>';
        $fd = fopen($fileName, "w");
        fwrite($fd, $this->content);
        fclose($fd);
    }

}

?>
