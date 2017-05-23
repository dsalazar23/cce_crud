<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="<?php echo WEBROOT_URL ?>img/default/favicon.ico" type="image/x-icon"/>
        <title><?php echo __('invalid_token') ?></title>
        <style>
            html {
                padding: 30px 10px;
                font-size: 20px;
                line-height: 1.4;
                color: #737373;
                background: #f0f0f0;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }

            html,
            input {
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            }

            body {
                max-width: 500px;
                _width: 500px;
                padding: 30px 20px 50px;
                border: 1px solid #b3b3b3;
                border-radius: 4px;
                margin: 0 auto;
                box-shadow: 0 1px 10px #a7a7a7, inset 0 1px 0 #fff;
                background: #fcfcfc;
                text-align: center;
            }

            h1 {
                margin: 0 10px;
                font-size: 50px;
                text-align: center;
            }

            h1 span {
                color: #bbb;
            }

            p {
                margin: 1em 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src=" <?php echo WEBROOT_URL ?>img/default/logo_inline.png" alt="Lantia" width="300px">
            <br><br>
            <h1><?php echo __('invalid_token') ?> :(</span></h1>
            <p>
            	<?php echo __('invalid_token_description') ?>
        	</p>
        </div>
    </body>
</html>