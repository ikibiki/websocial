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


        <title><?php echo 'Register to ' . WEBSITE_TITLE; ?></title>
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
                max-width: 420px;
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
                <a class="btn btn-primary btn-block" href="<?php echo site_url('login'); ?>">Login</a>
                <hr/>
                <h1 class="text-center" style="color: #6190D4">Register</h1>
                <?php
                if ($msg) {
                    ?>
                    <div class="alert alert-<?php echo $msg['type']; ?>">
                        <span class="pficon pficon-<?php echo $msg['type']; ?>"></span>
                        <strong><?php echo $msg['title']; ?></strong> <?php echo $msg['text']; ?>
                    </div>
                    <?php
                }
                echo form_open('register/process', array('id' => 'frmregister'));

                if (isset($profile)) {
                    echo form_hidden('socialcode', $profile->SocialCode);
                }
                echo form_hidden('redir', $redir);
                ?>
                <div class="form-group">
                    <label class="control-label">Name </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user fa-fw fa-lg"></i></div>
                        <input type="text" class="form-control input-lg" name="name" placeholder="Name" tabindex="1" required <?php echo isset($profile) && $profile->Name ? 'value="' . $profile->Name . '" readonly' : '' ?>>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-at fa-fw fa-lg"></i></div>
                        <input type="email" class="form-control input-lg" name="email" placeholder="Email" tabindex="2" required <?php echo isset($profile) && $profile->Email ? 'value="' . $profile->Email . '" readonly' : '' ?>>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Password </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-asterisk fa-fw fa-lg"></i></div>
                        <input type="password" class="form-control input-lg" name="password" placeholder="Password" tabindex="3" required>
                    </div>
                </div>
                <h3 class="text-center">Terms and conditions</h3>
                <p>
                    Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern <?php echo WEBSITE_TITLE; ?>'s relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.
                <p>
                    The term '<?php echo WEBSITE_TITLE; ?>' or 'us' or 'we' refers to the owner of the website whose registered office is in Washington DC. The term 'you' refers to the user or viewer of our website.
                <p>
                    The use of this website is subject to the following terms of use:
                <p>
                    The content of the pages of this website is for your general information and use only. It is subject to change without notice.
                <p>
                    This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, the following personal information may be stored by us for use by third parties: Google
                <p>
                    Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.
                <p>
                    Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.
                <p>
                    This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.
                <p>
                    All trade marks reproduced in this website which are not the property of, or licensed to, the operator are acknowledged on the website.
                <p>
                    Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offense.
                <p>
                    From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).
                <p>
                    Your use of this website and any dispute arising out of such use of the website is subject to the laws of England, Northern Ireland, Scotland and Wales.

                <div class="well well-lg">
                    <div class="checkbox text-center input-lg">
                        <label>
                            <input id='agreeable' type="checkbox" value="1"> Yes, I agree.
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div align="center" class="g-recaptcha" data-sitekey="<?php echo GRECAPTCHA_SITE; ?>" data-theme="light" data-size="normal"></div>
                </div>
                <div class="form-group">
                    <button id="btnreg" style="display: none;" type="submit" class="btn btn-default btn-block btn-lg" tabindex="5">Continue</button>
                    <span class="help-block"></span>
                </div>
<?php echo form_close(); ?>
                <!--                <hr/>
                                <div class="form-group">
                                    <a class="btn btn-block btn-social btn-lg btn-adn">
                                        <span class="fa fa-adn"></span> Sign in with App.net
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-bitbucket">
                                        <span class="fa fa-bitbucket"></span> Sign in with Bitbucket
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-dropbox">
                                        <span class="fa fa-dropbox"></span> Sign in with Dropbox
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-facebook" href="#">
                                        <span class="fa fa-facebook"></span> Sign in with Facebook
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-flickr">
                                        <span class="fa fa-flickr"></span> Sign in with Flickr
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-foursquare">
                                        <span class="fa fa-foursquare"></span> Sign in with Foursquare
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-github">
                                        <span class="fa fa-github"></span> Sign in with GitHub
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-google">
                                        <span class="fa fa-google"></span> Sign in with Google
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-instagram">
                                        <span class="fa fa-instagram"></span> Sign in with Instagram
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-linkedin">
                                        <span class="fa fa-linkedin"></span> Sign in with LinkedIn
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-microsoft">
                                        <span class="fa fa-windows"></span> Sign in with Microsoft
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-odnoklassniki">
                                        <span class="fa fa-odnoklassniki"></span> Sign in with Odnoklassniki
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-openid">
                                        <span class="fa fa-openid"></span> Sign in with OpenID
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-pinterest">
                                        <span class="fa fa-pinterest"></span> Sign in with Pinterest
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-reddit">
                                        <span class="fa fa-reddit"></span> Sign in with Reddit
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-soundcloud">
                                        <span class="fa fa-soundcloud"></span> Sign in with SoundCloud
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-tumblr">
                                        <span class="fa fa-tumblr"></span> Sign in with Tumblr
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-twitter">
                                        <span class="fa fa-twitter"></span> Sign in with Twitter
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-vimeo">
                                        <span class="fa fa-vimeo-square"></span> Sign in with Vimeo
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-vk">
                                        <span class="fa fa-vk"></span> Sign in with VK
                                    </a>
                                    <a class="btn btn-block btn-social btn-lg btn-yahoo">
                                        <span class="fa fa-yahoo"></span> Sign in with Yahoo!
                                    </a>-->
            </div>
        </div>

        <hr/>

    </div>

    <script>
        $.ripple(".btn", {
            debug: false, // Turn Ripple.js logging on/off
            on: 'mousedown', // The event to trigger a ripple effect

            color: "auto", // Set the background color. If set to "auto", it will use the text color
            multi: true, // Allow multiple ripples per element

            easing: 'easing' // The CSS3 easing function of the ripple
        });

        $('#agreeable').click(function () {
            $("#btnreg").toggle(this.checked);
        });
    </script>
</body>
</html>
