<?php

/**
 * Cabecera para todas las páginas del sitio
 *
 * @package     View
 * @subpackage  Elements
 * @author      JpBaena13
 */
?>

<!--[if lt IE 9]>
    <p class="chromeframe">Estas usando un <strong> navegador desactualizado</strong>. 
    Por favor <a href="http://browsehappy.com/">actualiza tu navegador</a> or 
    <a href="http://www.google.com/chromeframe/?redirect=true">activa Google Chrome Frame</a> 
    para mejorar tu experiencia.</p>
<![endif]-->

<div class="untHeaderContent">
    <!-- <img src="<?php echo WEBROOT_URL ?>img/default/header.png" alt="Header - Skeleton" width="980px" height="120px"/> -->
    <div class="cabeceraExpertos">
    	<div class="logoExpertos">
    		
    	</div>
    	<div class="tituloExpertos">
    		<h1>Conexión con el ecosistema</h1>
    	</div>
    </div>
    <?php if($auth->hasSession()) { ?>
        <a href="<?php echo ROOT_URL?>Login/Clear" class="closeSection"><?php __('logout')?></a>
    <?php } ?>
</div>