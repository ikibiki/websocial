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

    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container-fluid">
            <p></p>
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active"><a href="#">Home</a></li>
                        <li role="presentation"><a href="#">Profile</a></li>
                        <li role="presentation"><a href="#">Messages</a></li>
                        <li role="presentation"><a href="#">Log out</a></li>
                    </ul>
                </div>
                <div class="col-md-9">

                    <div class="well well-lg">
                        <form method="post">
                            <textarea onkeyup="countChar(this)" maxlength="140" class="form-control" placeholder="What is on your mind?" rows="3" required></textarea>
                            <span class="help-block">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"><i class="fa fa-facebook-official fa-fw fa-lg"></i>
                                    </label>&nbsp;
                                    <label>
                                        <input type="checkbox"><i class="fa fa-twitter-square fa-fw fa-lg"></i>
                                    </label>&nbsp;
                                    <label>
                                        <input type="checkbox"><i class="fa fa-google-plus fa-fw fa-lg"></i>
                                    </label>&nbsp;
                                    <label>
                                        <input type="checkbox"><i class="fa fa-instagram fa-fw fa-lg"></i>
                                    </label>&nbsp;
                                    <label>
                                        <input type="checkbox"><i class="fa fa-foursquare fa-fw fa-lg"></i>
                                    </label>&nbsp;
                                    <label>
                                        <input type="checkbox"><i class="fa fa-linkedin-square fa-fw fa-lg"></i>
                                    </label>
                                    <span id="hlp" class="help-block pull-right">140</span>
                                </div>

                            </span>
                            <button type="submit" class="btn btn-default">Post</button>
                        </form>
                    </div>

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
