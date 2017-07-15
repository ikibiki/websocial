<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$redir = '';
?>
<!doctype html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title><?php echo 'Login to ' . WEBSITE_TITLE; ?></title>

        <style>
            * {
                font-family: "Roboto";
            }
            .login-form{
                max-width: 480px;
            }

        </style>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            <div class="login-form center-block">
                <br/>
                <h1 class="text-center logo"><?php echo WEBSITE_TITLE; ?></h1>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo form_open('#'); ?>
                        <input type="hidden" name="redir" value="<?php echo $redir; ?>">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-at fa-fw fa-lg"></i></div>
                                <input type="text" class="form-control" name="username" placeholder="Email" tabindex="1" required>
                                <span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-asterisk fa-fw fa-lg"></i></div>
                                <input type="password" class="form-control" name="password" placeholder="Password" tabindex="2" required>
                                <span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div align="center" class="g-recaptcha" style="transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;" data-sitekey="6LfO6CgUAAAAAMzWFzSVbuAVMVZ7qVsjEHzfcci-" data-theme="light" data-size="normal"></div>
                        </div>
                        <div class="form-group">
                            <button id="btnlogin" type="button" class="btn btn-default btn-block" data-loading-text="Logging in..." tabindex="3">Continue</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Social login</label>
                            <a href='<?php echo $fbloginurl; ?>' class="btn btn-default btn-block"><span class="fa fa-facebook fa-lg fa-fw"></span>Login with Facebook</a>
                            <a href='<?php echo $fbloginurl; ?>' class="btn btn-default btn-block"><span class="fa fa-twitter fa-lg fa-fw"></span>Login with Twitter</a>
                            <a href='<?php echo $fbloginurl; ?>' class="btn btn-default btn-block"><span class="fa fa-google fa-lg fa-fw"></span>Login with Google</a>
                            <a href='<?php echo $fbloginurl; ?>' class="btn btn-default btn-block"><span class="fa fa-instagram fa-lg fa-fw"></span>Login with Instagram</a>
                            <a href='<?php echo $fbloginurl; ?>' class="btn btn-default btn-block"><span class="fa fa-linkedin fa-lg fa-fw"></span>Login with LinkedIn</a>
                        </div>
                    </div>
                </div>

                <hr/>

            </div>
        </div>

        <script>
            $.ripple(".btn", {
                debug: false, // Turn Ripple.js logging on/off
                on: 'mousedown', // The event to trigger a ripple effect

                color: "auto", // Set the background color. If set to "auto", it will use the text color
                multi: true, // Allow multiple ripples per element

                easing: 'easing' // The CSS3 easing function of the ripple
            });
        </script>
    </body>
</html>
