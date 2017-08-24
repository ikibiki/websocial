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
        <title><?php echo WEBSITE_TITLE; ?></title>

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
        </style>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container-fluid">
            <p>&nbsp;</p>
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
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation"><a href="<?php echo site_url('app'); ?>">Home</a></li>
                        <li role="presentation"><a href="<?php echo site_url('app/connect'); ?>">Connect</a></li>
                        <li role="presentation"><a href="<?php echo site_url('app/logout'); ?>">Log out</a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <!--MAIN BODY-->

                    <?php
                    if (isset($default)) {
                        ?>

                        <h3>Hi, <?php echo $user->UserName; ?>!</h3>
                        <div class="well well-lg">
                            <?php
                            echo form_open('app/process');
                            ?>
                            <textarea name="msg" onkeyup="countChar(this)" maxlength="140" class="form-control" placeholder="What is on your mind?" rows="3" required></textarea>
                            <span class="help-block">
                                <?php if ($safb) { ?>
                                    <div class="pretty plain toggle">
                                        <input name="FB" type="checkbox"/> 
                                        <label class="text-danger"><i class="fa fa-facebook-official"></i> Facebook</label>
                                        <label class="text-info"><i class="fa fa-facebook-official"></i> <strong>Facebook</strong></label>
                                    </div>
                                    <?php
                                }
                                if ($satw) {
                                    ?>
                                    <div class="pretty plain toggle">
                                        <input name="TW" type="checkbox"/> 
                                        <label class="text-danger"><i class="fa fa-twitter-square"></i> Twitter</label>
                                        <label class="text-info"><i class="fa fa-twitter-square"></i> <strong>Twitter</strong></label>
                                    </div>
                                    <?php
                                }
                                if ($salin) {
                                    ?>
                                    <div class="pretty plain toggle">
                                        <input name="LIN"  type="checkbox"/> 
                                        <label class="text-danger"><i class="fa fa-linkedin-square"></i> Linked In</label>
                                        <label class="text-info"><i class="fa fa-linkedin-square"></i> <strong>Linked In</strong></label>
                                    </div>
                                <?php } ?>
                            </span>

                            <button type="submit" class="btn btn-default">Post</button>

                            <?php
                            echo form_close();
                            ?>
                        </div>
                        <?php
                    }
                    if (isset($connect)) {
                        ?>
                        <h3>Connect with Social Combo</h3>
                        <div class="list-group">
                            <?php
                            if (!empty($safb)) {
                                ?>
                                <a href="<?php echo site_url('social/unbind/FB/' . $user->ID); ?>" class="list-group-item">
                                    <span class="fa fa-check-square-o fa-lg fa-fw"></span><span class="fa fa-facebook-official fa-lg fa-fw"></span> Disconnect from Facebook
                                </a>
                                <?php
                            } else {
                                ?>
                                <a href="<?php echo $fbloginurl; ?>" class="list-group-item">
                                    <span class="fa fa-square-o fa-lg fa-fw"></span><span class="fa fa-facebook-official fa-lg fa-fw"></span> Connect to Facebook
                                </a>
                                <?php
                            }
                            if (!empty($satw)) {
                                ?>
                                <a href="<?php echo site_url('social/unbind/TW/' . $user->ID); ?>" class="list-group-item">
                                    <span class="fa fa-check-square-o fa-lg fa-fw"></span><span class="fa fa-twitter-square fa-lg fa-fw"></span> Disconnect from Twitter
                                </a>
                                <?php
                            } else {
                                ?>
                                <a href="<?php echo $twitterloginurl; ?>" class="list-group-item">
                                    <span class="fa fa-square-o fa-lg fa-fw"></span><span class="fa fa-twitter-square fa-lg fa-fw"></span> Connect to Twitter
                                </a>
                                <?php
                            }
                            if (!empty($salin)) {
                                ?>
                                <a href="<?php echo site_url('social/unbind/LIN/' . $user->ID); ?>" class="list-group-item">
                                    <span class="fa fa-check-square-o fa-lg fa-fw"></span><span class="fa fa-linkedin-square fa-lg fa-fw"></span> Disconnect from LinkedIn
                                </a>
                                <?php
                            } else {
                                ?>
                                <a href="<?php echo $linkedinloginurl; ?>" class="list-group-item">
                                    <span class="fa fa-square-o fa-lg fa-fw"></span><span class="fa fa-linkedin-square fa-lg fa-fw"></span> Connect to LinkedIn
                                </a>
                            <?php } ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">


                                <br/>


                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <script>
            function countChar(val) {
                var len = val.value.length;
                if (len >= 140) {
                    val.value = val.value.substring(0, 140);
                } else {
                    $('#hlp').text(140 - len);
                }
            }

        </script>

    </body>
</html>
