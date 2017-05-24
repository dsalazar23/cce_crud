<?php

/**
 * Vista para el index principal del sitio.
 *
 * @package     View
 * @subpackage  App
 * @author      JpBaena13
 */
?>

<!DOCTYPE html>
<html lang="<?php echo i18n::getLang() ?>">
    <head>
        <title><?php __('home_title')?></title>

        <meta name="description" content="<?php __('home_description')?>">

        <!-- Importando las cabeceras por defecto-->
        <?php require VIEW . 'Layouts' . DS . 'head.php'; ?>

        <!--Stylesheet-->
        <link rel="stylesheet" type="text/css" href="<?php echo WEBROOT_URL ?>css/home.css" media="screen" />
    </head>

    <body>
        <header class="untHeaderWrapper">
            <!-- Incluyendo header -->
            <?php require VIEW . 'Layouts' . DS . 'header.php'; ?>
        </header>

        <div class="untMainWrapper">
            <div class="untMainContent">
    
                <div class="untLoginCenterContent">
                    <h2><?php __('login')?></h2>
                    <form action="<?php echo ROOT_URL ?>Login/Authenticate" method="POST">
                        <div class="untPlgMsg"></div>
                        
                        <fieldset>
                            <div>
                                <input id="email" name="email" type="text" placeholder="<?php __('email')?>">
                            </div>
                            <div>
                                <input id="password" name="password" type="password" placeholder="<?php __('password')?>">
                            </div>
 
                            <div class="opts">
                                <input id="session" name="session" type="checkbox" checked>
                                <label for="session"><?php __('remember')?></label>
                            </div>
                            
                            <input type="submit" class="btn btn-default" value="<?php __('login')?>"></input>

                            <?php if (isset($_GET['uri'])) { ?>
                                <input type="hidden" name="uri" value="<?php echo $_GET['uri']?>">
                            <?php } ?>
                        </fieldset>
                    </form>
                </div>
            </div> <!-- Fin untMainContent -->
        </div> <!-- Fin untMainWrapper -->

        <footer class="untFooterWrapper">
            <!-- Incluyendo footer -->
            <?php require VIEW . 'Layouts' . DS . 'footer.php'; ?>
        </footer>

        <!--Script para esta página-->
        <script type="text/javascript" src="<?php echo WEBROOT_URL ?>js/home.js"></script>
    </body>
</html>