<?php

/**
 * Cabezera con la inclusión de Metas y Scripts por defecto para todas las 
 * páginas del sitio.
 *
 * @package     View
 * @subpackage  Layouts
 * @author      JpBaena13
 * @since       PHP 5
 */

global $auth;
global $i18n;

?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="author" content="JpBaena13">
<meta http-equiv="Expires" content="never">
<meta name="country" content="Colombia">

<!-- Permite colocar una imagen en la barra de direcciones.-->
<link rel="shortcut icon" href="<?php echo WEBROOT_URL ?>favicon.ico" type="image/x-icon"/>

<!--Stylesheet por Defecto, contiene: [normalize, jquery.jscrollpane, jquery.qtip, default]-->
<link rel="stylesheet" type="text/css" href="<?php echo WEBROOT_URL ?>css/main.css" media="all" />

<!-- Metadata -->
<meta name="keywords" content="<?php __('keywords')?>">