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
        <title><?php echo 'Soon | ' . WEBSITE_TITLE; ?></title>

        <?php
        echoStyles();
        echoScripts();
        ?>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Roboto');
            body, html {
                height: 100%
            }

            .bgimg {
                /* Background image */
                background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('assets/img/kevin-curtis-3308.jpg');
                /* Full-screen */
                height: 100%;
                /* Center the background image */
                background-position: center;
                /* Scale and zoom in the image */
                background-size: cover;
                /* Add position: relative to enable absolutely positioned elements inside the image (place text) */
                position: relative;
                /* Add a white text color to all elements inside the .bgimg container */
                color: white;
                /* Add a font */
                font-family: "Roboto", sans-serif;
                /* Set the font-size to 25 pixels */
                font-size: 25px;
            }

            /* Position text in the top-left corner */
            .topleft {
                position: absolute;
                top: 0;
                left: 16px;
            }

            /* Position text in the bottom-left corner */
            .bottomleft {
                position: absolute;
                bottom: 0;
                left: 16px;
            }

            /* Position text in the middle */
            .middle {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }

            /* Style the <hr> element */
            hr {
                margin: auto;
                width: 40%;
            }
        </style>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="bgimg">
            <div class="topleft">
                <p>theshiftleft/socialcombo</p>
            </div>
            <div class="middle">
                <h1>System under development</h1>
                <hr>
                <p id="demo">Soon</p>
            </div>
            <div class="bottomleft">
                <p><a href="http://shiftleft.com">theshiftleft.com</a></p>
            </div>
        </div>

        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("September 30, 2017 00:00:00").getTime();

// Update the count down every 1 second
            var x = setInterval(function () {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in an element with id="demo"
                document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                        + minutes + "m " + seconds + "s ";

                // If the count down is finished, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";
                }
            }, 1000);
        </script>
    </body>
</html>
