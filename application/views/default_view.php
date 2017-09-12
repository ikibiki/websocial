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

    <link rel="apple-touch-icon" href="assets/img/binancity.png">
    <title><?php echo WEBSITE_TITLE; ?></title>

    <?php
    echoStyles();
    echoScripts();
    ?>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto');

        body {
            background-color: #EDF6FF;
        }

        * {
            font-family: "Roboto";
        }
    </style>
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
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
                <p class="bg-warning">
                    Facebook does not allow multiple posting within 3 seconds.
                </p>
                <h3>Hi, <?php echo $user->UserName; ?>!</h3>
                <div class="well well-lg">
                    <?php
                    echo form_open('app/process');
                    echo form_hidden('mode', 'text');
                    ?>
                    <textarea name="msg" onkeyup="countChar(this)" maxlength="140" class="form-control"
                              placeholder="What is on your mind?" rows="3" required></textarea>
                    <span class="help-block">
                        Social Accounts:
                             <select name="socaccs[]" class="selectpicker" data-actions-box="true" multiple>
                                 <?php
                                 if (isset($socaccs)) {
                                     foreach ($socaccs as $item) {
                                         echo "<option value='" . $item->ID . "'>$item->info</option>";
                                     }
                                 }
                                 ?>
                             </select>
                    </span>

                    <button type="submit" class="btn btn-default">Post</button>

                    <?php
                    echo form_close();
                    ?>
                </div>
                <hr/>
                <?php
                echo form_open_multipart('app/process');
                echo form_hidden('mode', 'image');
                ?>
                <div class="well well-lg">
                    <div class="form-group text-center">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 320px; height: 240px;">
                                <img data-src="" alt="Select image">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"
                                 style="max-width: 480px; max-height: 320px;"></div>
                            <div>
                                        <span class="btn btn-default btn-file"><span
                                                    class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span><input type="file"
                                                                                               name="imagefile"
                                                                                               required></span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input name="msg" class="form-control" type="text" placeholder="Tell us about this photo/image"
                               required/>
                        <span class="help-block">
                                    Social Accounts:
                             <select name="socaccs[]" class="selectpicker" multiple>
                                 <?php
                                 if (isset($socaccs)) {
                                     foreach ($socaccs as $item) {
                                         echo "<option value='" . $item->ID . "'>$item->info</option>";
                                     }
                                 }
                                 ?>
                             </select>
                                </span>
                    </div>
                    <button type="submit" class="btn btn-default">Upload now</button>
                </div>
                <?php
                echo form_close();
            }
            if (isset($connect)) {
                ?>
                <h3>Connect with Social Combo</h3>
                <p class="bg-primary">
                    To add many accounts effectively, log out your social media accounts' current session then you can
                    add another account. Access them here.
                <ul>
                    <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
                    <li><a href="https://www.twitter.com" target="_blank">Twitter</a></li>
                    <li><a href="https://www.linkedin.com" target="_blank">Linkedin</a></li>
                </ul>

                </p>

                <a href="<?php echo $fbloginurl; ?>" class="btn btn-default btn-block">Add a Facebook account</a>
                <a href="<?php echo $twitterloginurl; ?>" class="btn btn-default btn-block">Add a Twitter account</a>
                <a href="<?php echo $linkedinloginurl; ?>" class="btn btn-default btn-block">Add a LinkedIn account</a>

                <table class="table">
                    <thead>
                    <tr>
                        <td>Options</td>
                        <td>Username</td>
                        <td>Social account</td>
                        <td>Date connected</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($socaccs)) {
                        foreach ($socaccs as $item) {
                            echo "<tr><td><a href='#'>Delete</a></td><td>$item->SocialID</td><td>$item->SocialCode</td><td>$item->DTCreated</td></tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>

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
