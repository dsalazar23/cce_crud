<?php

/**
 * Footer para todas las páginas del sitio.
 *
 * @package     View
 * @subpackage  Layouts
 * @author      JpBaena13
 * @since       PHP 5
 */
?>

<div class="untFooterContent">
    <div class="untFooterTitle"><?php __('footer') ?></div>
</div>

<!-- Importando librerías javascript -->   
    <!--Librería JS que incluye: [jquery, jquery-ui, jquery.qtip, jquery.cookie, jquery.jscrollpane, jquery.mousewheel, jquery.validation, modernizr]-->
    <script type="text/javascript" src="<?php echo WEBROOT_URL ?>js/lib/vendors.min.js"></script>

    <!--Librería JS que incluye: [bootstrap.js, permissionsKeyPress.js, placeholder.js, untInput.js]-->
    <script type="text/javascript" src="<?php echo WEBROOT_URL ?>js/main.min.js"></script>    