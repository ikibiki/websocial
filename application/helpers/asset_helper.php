<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function echoStyles() {
    $css = array(
        "//fonts.googleapis.com/css?family=Roboto:300,400,500,700",
        "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css",
        "//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css",
        "//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css",
        "//cdnjs.cloudflare.com/ajax/libs/Ripple.js/1.2.1/ripple.min.css",
        "//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css",
        "//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css",
    );
    foreach ($css as $elem) {
        echo "<link rel='stylesheet' href='$elem'/>";
    }
}

function echoScripts() {
    $js = array(
        "//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js",
        "//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/Ripple.js/1.2.1/ripple.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js",
    );

    foreach ($js as $elem) {
        echo "<script src='$elem'></script>";
    }
}

function echoSwal2() {
    echo "<script src='//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.js'></script>";
    echo "<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.css'/>";
}
