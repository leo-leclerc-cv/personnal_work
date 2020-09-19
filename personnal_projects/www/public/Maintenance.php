<?php
$explanationFile = fopen('public/Explanations.txt', 'r');
$reason = fgets($explanationFile);
$date = fgets($explanationFile);
$hour = fgets($explanationFile);
?>
<!DOCTYPE html>
<html>
    <head>      
        <link rel="stylesheet" href="public/css/maintenance.css" />
        <link rel="icon" href="public/img/wrench.png">
        <meta charset="utf-8" />
        <title>Maintenance</title>
    </head>

    <body>
        <h1>Le site est actuellement en maintenace.</br>Veuillez nous excuser pour la gêne occasionée.</h1>
        <h1>Raison(s) de la maintenance : <span class="php"><?= $reason ?></span></h1>
        <img src="public/img/wrenchBits.png" alt="wrench" height="250px">
        <h2>La maintenance devrait se finir le : <span class="php"><?= $date ?></span> vers <span class="php"><?= $hour ?></span></h2>
        <h1>Merci de votre compréhension.</h1>

        <a href="recovery.php?action=connection" id="wrapper">
            <div id="cube">
                <b class="front"><p>Menu Recovery</p></b>
                <b class="back"><p>Menu Recovery</p></b>
                <b class="top"></b>
                <b class="bottom"></b>
                <b class="left"></b>
                <b class="right"></b>
                <i class="front"></i>
                <i class="back"></i>
                <i class="top"></i>
                <i class="bottom"></i>
                <i class="left"></i>
                <i class="right"></i>
            </div>
        </a>

        <script type="text/javascript">
            document.getElementById("cube").addEventListener("mouseenter", function( event ) {
                for (var i = document.getElementsByTagName("i").length - 1; i >= 0; i--) {
                    document.getElementsByTagName("i")[i].style.backgroundColor="red";
                }
            }, false);

            document.getElementById("cube").addEventListener("mouseleave", function( event ) {
                for (var i = document.getElementsByTagName("i").length - 1; i >= 0; i--) {
                    document.getElementsByTagName("i")[i].style.backgroundColor="rgba(222, 222, 222, 0.5)";
                }
            }, false);
        </script>

    </body>
</html>