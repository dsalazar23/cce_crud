<?php
/**
 * Description of the ${name}.
 *
 * @package     unnotes.webroot
 * @subpackage  plugins.untInput
 * @author      JpBaena13
 */

/**
 * Use DS para separar los directorios en otras definiciones
 */
    if (!defined('DS')) {
        define('DS', DIRECTORY_SEPARATOR);
    }

/**
 * Ruta completa al directorio donde está hospedada la aplicación.
 */
    if (!defined('ROOT')) {
        define('ROOT', dirname(dirname(dirname(dirname(__FILE__)))) . DS);
    }

    if (!include ROOT . DS . 'include' . DS . 'bootstrap.php') {
        trigger_error('Error al cargar el Bootstrap', E_USER_ERROR);
        exit();
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <!-- Importando las cabeceras por defecto-->
        <?php require VIEW . 'Layouts' . DS . 'head.php'; ?>

    </head>

    <body>
        
        <div class="untHeaderContent"></div>

        <div class="untMainWrapper">
            
            <div class="untMainContent">
                
                <br/><br/>

                <button class="untBtn abrir">Abrir</button>
                <button class="untBtn two">Mostrar Mensaje</button>

                <br/><br/>

                <div id="me" class="plgUntMsg"></div>
                <div class="plgUntMsg particular"></div>
                <div class="plgUntMsg particular"></div>
                <div class="plgUntMsg particular"></div>
                <div class="plgUntMsg particular"></div>
                <div class="plgUntMsg pp"></div>
            </div> <!-- Fin main-content -->
        </div> <!-- Fin main-wrapper -->

        <div class="untFooterWrapper">
            <!-- Incluyendo footer -->
            <?php require VIEW . 'Layouts' . DS . 'footer.php'; ?>
        </div>
        
        <script type="text/javascript">
            $('.abrir').click(function(){
                $('.pp').show()
            })

            $('.two').click(function() {
                $.untInputWin({
                    title: 'Entrando',
                    content: 'Contenido'
                })
            })

            $('#me').untInputMsg({
                icon: 'images/engine.png',
                title: 'Saliendo a comer',
                content: 'Vamos campeón que esto esta quedando muy bacano',
                type: 'Err',
                width: '400'
            }).show()

            $('.particular').untInputMsg({
                title: 'Saliendo a comer',
                content: 'Vamos campeón que esto esta quedando muy bacano',
                type: 'Wrng'
            }).show()

            $('.pp').untInputMsg({
                icon: 'images/engine.png',
                title: 'Saliendo a comer',
                content: 'Vamos campeón que esto esta quedando muy bacano',
                type: 'Ok',
                height: '100'
            })
        </script>
        
        
    </body>
</html>