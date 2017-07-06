<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function echoStyles() {
    $css = array(
        "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css",
        "//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css",
        "//cdnjs.cloudflare.com/ajax/libs/patternfly/3.25.1/css/patternfly.min.css",
        "//cdnjs.cloudflare.com/ajax/libs/patternfly/3.25.1/css/patternfly-additions.min.css",
        
        "//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css",
        "//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css",
        "//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css",
    );
    foreach ($css as $elem) {
        echo "<link rel='stylesheet' href='$elem'/>";
    }
}

function echoScripts() {
    $js = array(
        "//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.js",
        "//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js",
        "//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js",
        
        "//cdnjs.cloudflare.com/ajax/libs/patternfly/3.25.1/js/patternfly.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/patternfly/3.25.1/js/patternfly-functions.min.js",
        
        "//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js",
    );

    foreach ($js as $elem) {
        echo "<script src='$elem'></script>";
    }
}

function echoBsCalendar() {
    echo "<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-year-calendar/1.1.1/css/bootstrap-year-calendar.min.css'/>";
    echo "<script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-year-calendar/1.1.1/js/bootstrap-year-calendar.min.js'></script>";
}

function echoSwal2() {
    echo "<script src='//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.js'></script>";
    echo "<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.css'/>";
}

function echoPatternflyCSS(){
    $css = array(
        "//cdnjs.cloudflare.com/ajax/libs/patternfly/3.25.1/css/patternfly.min.css",
        "//cdnjs.cloudflare.com/ajax/libs/patternfly/3.25.1/css/patternfly-additions.min.css",
    );
    foreach ($css as $elem) {
        echo "<link rel='stylesheet' href='$elem'/>";
    }
}
function echoPatternflyJS(){
     $js = array(
        "//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/patternfly/3.25.1/js/patternfly.min.js",
    );

    foreach ($js as $elem) {
        echo "<script src='$elem'></script>";
    }
}

function echoPhpgrid() {
    $css = array(
        base_url() . "/assets/js/jqgrid/css/ui.jqgrid.bs.css",
        base_url() . "/assets/js/themes/redmond/jquery-ui.custom.css",
    );

    foreach ($css as $elem) {
        echo "<link rel='stylesheet' type='text/css' media='screen' href='$elem'/>";
    }
    $js = array(
        base_url() . "/assets/js/jqgrid/js/i18n/grid.locale-en.js",
        base_url() . "/assets/js/jqgrid/js/jquery.jqGrid.min.js",
    );

    foreach ($js as $elem) {
        echo "<script src='$elem'></script>";
    }
}
