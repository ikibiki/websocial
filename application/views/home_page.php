<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel = "apple-touch-icon" href = "assets/img/binancity.png">
        <title>Web Social</title>

        <?php
        echoStyles();
        echoScripts();
        ?>

    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
            <ul>
                <li><a href="<?php echo site_url('welcome/facebook'); ?>">Facebook</a></li>
                <li><a href="<?php echo site_url('welcome/instagram'); ?>">Instagram</a></li>
                <li><a href="<?php echo site_url('welcome/googleplus'); ?>">Google+</a></li>
                <li><a href="<?php echo site_url('welcome/linkedin'); ?>">Linkedin</a></li>
            </ul>

            <?php
            $atts = array(
                'width' => 800,
                'height' => 600,
                'scrollbars' => 'yes',
                'status' => 'yes',
                'resizable' => 'yes',
                'screenx' => 0,
                'screeny' => 0,
                'window_name' => 'Facebook'
            );

            echo anchor_popup('hauth/window/Facebook', 'Login to Facebook', $atts);
            ?>

        </div>

    </body>
</html>
