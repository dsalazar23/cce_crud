<?php

/**
 * Vista para página principal de usuarios autenticados.
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
        
                <div class="CajaListaExpertos">
                    <table id="listaExpertos">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Intereses</th>
                                <th>Teléfono</th>
                                <th>Sitio Web</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 0;
                                foreach ($empresaDTOs as $empresaDTO) { 
                            ?>
                                <tr>
                                    <td class="ocupacion">
                                        <?php echo $empresaDTO->nombreEmpresa ?>
                                    </td>
                                    <td class="skills">
                                        <?php 
                                            $tempIntereses = $empresaDTO->intereses;
                                            for ($j = 0; $j < count($tempIntereses); $j++){
                                                echo $tempIntereses[$j] .", ";
                                            }
                                        ?>
                                    </td>
                                    <td class="telefono">
                                        <?php echo $empresaDTO->telefono ?>
                                    </td>
                                    <td class="url">
                                        <?php echo $empresaDTO->url ?>
                                    </td>
                                    <td class="email">
                                        <?php echo $empresaDTO->email ?>
                                    </td>
                                    <td class="options">
                                        <a onclick="return confirm('¿Desea borrar el registro?')" class="btnAction" href="<?php echo ROOT_URL . 'Empresa/Delete/' . $empresaDTO->id ?>">Borrar</a>
                                        <a class="btnAction" href="<?php echo ROOT_URL . 'Empresa/Edit/' . $empresaDTO->id ?>">Editar</a>
                                    </td>
                                </tr>
                                
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                    <a href="<?php echo ROOT_URL ?>Empresa/NewEmpresa" class="btnAction">Nuevo</a>
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