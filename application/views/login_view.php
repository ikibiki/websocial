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
        <?php
        echoStyles();
        echoScripts();
        ?>

        <style>
            @import url('https://fonts.googleapis.com/css?family=Roboto');
            body{
                background-color: #EDF6FF;
            }
            * {
                font-family: "Roboto";
            }
            .login-form{
                max-width: 480px;
            }
            .g-recaptcha{
                transform:scale(0.98);-webkit-transform:scale(0.98);transform-origin:0 0;-webkit-transform-origin:0 0;
            }
        </style>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
            <div class="login-form center-block">
                <br/>
                <h1 class="text-center logo"><img src="assets/img/hdlogo.png" width="300px" alt="Logo"/></h1>
                <hr/>
                <?php
                if ($msg) {
                    ?>
                    <div class="alert alert-<?php echo $msg['type']; ?>">
                        <span class="pficon pficon-<?php echo $msg['type']; ?>"></span>
                        <strong><?php echo $msg['title']; ?></strong> <?php echo $msg['text']; ?>
                    </div>
                    <?php
                }
                ?>

                <div class="well well-lg">
                    <?php echo form_open('login/process'); ?>
                    <input type="hidden" name="redir" value="<?php echo $redir; ?>">
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-at fa-fw fa-lg"></i></div>
                            <input type="email" class="form-control" name="email" placeholder="Email" tabindex="1" required>
                            <span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk fa-fw fa-lg"></i></div>
                            <input type="password" class="form-control" name="password" placeholder="Password" tabindex="2" required>
                            <span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo site_url('register'); ?>">Register for an account</a> | <a href="#">Forgot your password?</a>
                    </div>
                    <div class="form-group">
                        <div align="center" class="g-recaptcha" data-sitekey="<?php echo GRECAPTCHA_SITE; ?>" data-theme="light" data-size="normal"></div>
                    </div>
                    <div class="form-group">
                        <button id="btnlogin" type="submit" class="btn btn-default btn-block" data-loading-text="Logging in..." tabindex="3">Continue</button>
                    </div>
                    <?php echo form_close(); ?>
                    <hr/>
                    <!--                            <a class="btn btn-block btn-social btn-adn">
                                                <span class="fa fa-adn"></span> Sign in with App.net
                                            </a>
                                            <a class="btn btn-block btn-social btn-bitbucket">
                                                <span class="fa fa-bitbucket"></span> Sign in with Bitbucket
                                            </a>
                                            <a class="btn btn-block btn-social btn-dropbox">
                                                <span class="fa fa-dropbox"></span> Sign in with Dropbox
                                            </a>-->
                    <a class="btn btn-block btn-social btn-facebook" href="<?php echo $fbloginurl; ?>">
                        <span class="fa fa-facebook"></span> Sign in with Facebook
                    </a>
                    <!--                            <a class="btn btn-block btn-social btn-flickr">
                                                    <span class="fa fa-flickr"></span> Sign in with Flickr
                                                </a>
                                                <a class="btn btn-block btn-social btn-foursquare">
                                                    <span class="fa fa-foursquare"></span> Sign in with Foursquare
                                                </a>
                                                <a class="btn btn-block btn-social btn-github">
                                                    <span class="fa fa-github"></span> Sign in with GitHub
                                                </a>
                                                <a class="btn btn-block btn-social btn-google">
                                                    <span class="fa fa-google"></span> Sign in with Google
                                                </a>
                                                <a class="btn btn-block btn-social btn-instagram">
                                                    <span class="fa fa-instagram"></span> Sign in with Instagram
                                                </a>-->
                    <a class="btn btn-block btn-social btn-linkedin" href="<?php echo $linkedinloginurl; ?>">
                        <span class="fa fa-linkedin"></span> Sign in with LinkedIn
                    </a>
                    <!--                            <a class="btn btn-block btn-social btn-microsoft">
                                                    <span class="fa fa-windows"></span> Sign in with Microsoft
                                                </a>
                                                <a class="btn btn-block btn-social btn-odnoklassniki">
                                                    <span class="fa fa-odnoklassniki"></span> Sign in with Odnoklassniki
                                                </a>
                                                <a class="btn btn-block btn-social btn-openid">
                                                    <span class="fa fa-openid"></span> Sign in with OpenID
                                                </a>
                                                <a class="btn btn-block btn-social btn-pinterest">
                                                    <span class="fa fa-pinterest"></span> Sign in with Pinterest
                                                </a>
                                                <a class="btn btn-block btn-social btn-reddit">
                                                    <span class="fa fa-reddit"></span> Sign in with Reddit
                                                </a>
                                                <a class="btn btn-block btn-social btn-soundcloud">
                                                    <span class="fa fa-soundcloud"></span> Sign in with SoundCloud
                                                </a>
                                                <a class="btn btn-block btn-social btn-tumblr">
                                                    <span class="fa fa-tumblr"></span> Sign in with Tumblr
                                                </a>-->
                    <a class="btn btn-block btn-social btn-twitter" href="<?php echo $twitterloginurl; ?>">
                        <span class="fa fa-twitter"></span> Sign in with Twitter
                    </a>
                    <!--                            <a class="btn btn-block btn-social btn-vimeo">
                                                    <span class="fa fa-vimeo-square"></span> Sign in with Vimeo
                                                </a>
                                                <a class="btn btn-block btn-social btn-vk">
                                                    <span class="fa fa-vk"></span> Sign in with VK
                                                </a>
                                                <a class="btn btn-block btn-social btn-yahoo">
                                                    <span class="fa fa-yahoo"></span> Sign in with Yahoo!
                                                </a>-->
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
