<?php

/**
 * Vista para [...]
 *
 * @package     View
 * @subpackage  App
 * @author      JpBaena13
 */
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title><?php __('')?> :: <?php __('unnotes') ?></title>

        <meta name="description" content="<?php __('home_description')?>">

        <!-- Importando las cabeceras por defecto-->
        <?php require VIEW . 'Layouts' . DS . 'head.php'; ?>

        <!--Stylesheet para index-->
        <link rel="stylesheet" type="text/css" href="<?php echo WEBROOT_URL ?>css/home.css" media="screen" />
    </head>

    <body>
        <!--[if lt IE 9]>
            <p class="chromeframe">Estas usando un <strong> navegador desactualizado</strong>. 
            Por favor <a href="http://browsehappy.com/">actualiza tu navegador</a> or 
            <a href="http://www.google.com/chromeframe/?redirect=true">activa Google Chrome Frame</a> 
            para mejorar tu experiencia.</p>
        <![endif]-->

        <header class="untHeaderWrapper">
            <!-- Incluyendo header -->
            <?php require VIEW . 'Layouts' . DS . 'header.php'; ?>
        </header>

        <div class="untMainWrapper">
            <div class="untMainContent">
                <form action="<?php echo ROOT_URL ?>Empresa/Save" method="POST" id="formNuevo">
                    <fieldset>
                        <div><span>Nombre:</span> <input type="text" name="nombre" placeholder="Nombre"></div>
                        <div><span>logo:</span> <input type="text" name="logo" placeholder="introduce el nombre del archivo de imagen del logo"></div>
                        <div><span>Descripción:</span> <textarea rows="5" cols="50" type="text" name="descripcion" placeholder="Descripción"></textarea></div>
                        <div><span>Web:</span> <input type="text" name="url" placeholder="Página web de la empresa"></div>
                        <div><span>Intereses:</span></div>
                        <div>
                            <?php foreach ($interesesDTOs as $interesesDTO) { ?>
                            <label><input type="checkbox" name="intereses[]" value="<?php echo $interesesDTO->id; ?>"><?php echo $interesesDTO->nombre; ?></label>
                            <?php } ?>
                        </div>
                        <div class="btnsAction">
                            <input type="submit" value="Guardar Empresa" class="btnAction">
                            <a class="btnAction" href="<?php echo  ROOT_URL . 'Empresa/Cancel/' ?>">Cancelar</a>
                        </div>
                    </fieldset>
                </form>
            </div> <!-- Fin untMainContent -->
        </div> <!-- Fin untMainWrapper -->

        <footer class="untFooterWrapper">
            <!-- Incluyendo footer -->
            <?php require VIEW . 'Layouts' . DS . 'footer.php'; ?>
        </footer>

        <!--Script para esta página-->
        <!-- <script type="text/javascript" src="<?php echo WEBROOT_URL ?>js/home.js"></script> -->
        <script type="text/javascript" src="<?php echo WEBROOT_URL ?>js/formsEmpresas.js"></script>
    </body>
</html>