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
    
                <div class="untLeftContent">
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

                            <input type="submit" class="untBtn" value="<?php __('login')?>"></input>
                            
                            <div class="opts">
                                <input id="session" name="session" type="checkbox" checked>
                                <label for="session"><?php __('remember')?></label>
                            </div>

                            <?php if (isset($_GET['uri'])) { ?>
                                <input type="hidden" name="uri" value="<?php echo $_GET['uri']?>">
                            <?php } ?>
                        </fieldset>
                    </form>
                </div>

                <div class="untRightContent">
                    <h2><?php __('create_account')?></h2>
                    <form id="frmSignup" action="<?php echo ROOT_URL?>Signup/CreateAccount" method="POST">
                        <fieldset>
                            <div>
                                <input type="text" id="firstname" name="firstname" placeholder="<?php __('firstname')?>"/>
                            </div>
                            <div>
                                <input type="text" id="lastname" name="lastname" placeholder="<?php __('lastname')?>"/>
                            </div>
                            <div>
                                <input type="text" id="username" name="username" placeholder="<?php __('username')?>"/>
                            </div>
                            <div>
                                <input type="text" id="email" name="email" placeholder="<?php __('email')?>"/>
                            </div>
                            <div>
                                <input type="password" id="password" name="password" placeholder="<?php __('password')?>"/>
                            </div>
                            
                            <input id="btnSignup" type="submit" value="<?php __('signup')?>" class="untBtn blue"/>
                        </fieldset>
                   </form>

                   <?php __('right_content')?>
                </div>
    
                <div style="text-align: center;margin-top:3em;">
                    <input id="btnSkeleton" type="button" value="Click Skeleton" class="untBtn yellow">
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