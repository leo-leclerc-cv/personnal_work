<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="public/img/recovery.png">
        <title>Error Handler</title>
        <link rel="stylesheet" type="text/css" href="public/css/recovery.css" />
    </head>
        
    <body>
        <div id="news"><p>Recovery hors ligne.</p></div>
        <div style="left: 15px; top: 15px;" class="adminLogo">
            <span class="top"></span>
            <span class="leftTop"></span>
            <span class="rightTop"></span>
            <span class="leftBottom"></span>
            <span class="rightBottom"></span>
            <span class="bottom"></span>
            <span class="text">RECOVERY</span>
        </div>
        <div style="right: 15px; top: 15px;" class="adminLogo">
            <span class="top"></span>
            <span class="leftTop"></span>
            <span class="rightTop"></span>
            <span class="leftBottom"></span>
            <span class="rightBottom"></span>
            <span class="bottom"></span>
            <span class="text">RECOVERY</span>
        </div>

        <p class="false" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 1em; font-size: 2.5em;"><?= $error ?></p>

        <?php
        if ($error=="Le Recovery n'est pas disponible si le site est en ligne.") {
            ?>
        <a href="index.php?action=disconnect" id="wrapper">
            <div id="cube">
                <b class="front"><p>Site Principal</p></b>
                <b class="back"><p>Site Principal</p></b>
            <?php
        }
        else {
            ?>
        <a href="recovery.php?action=disconnect" id="wrapper">
            <div id="cube">
                <b class="front"><p>Recovery Home</p></b>
                <b class="back"><p>Recovery Home</p></b>
            <?php
        }
        ?>
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
    </body>

    <script type="text/javascript" src="public/js/recovery.js"></script>

</html>