<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="public/img/recovery.png">
        <title>Recovery</title>
        <link rel="stylesheet" type="text/css" href="public/css/recovery.css" />
    </head>
        
    <body>
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
        <div style="left: 15px; bottom: 15px;" class="adminLogo">
            <span class="top"></span>
            <span class="leftTop"></span>
            <span class="rightTop"></span>
            <span class="leftBottom"></span>
            <span class="rightBottom"></span>
            <span class="bottom"></span>
            <span class="text">RECOVERY</span>
        </div>
        <div style="right: 15px; bottom: 15px;" class="adminLogo">
            <span class="top"></span>
            <span class="leftTop"></span>
            <span class="rightTop"></span>
            <span class="leftBottom"></span>
            <span class="rightBottom"></span>
            <span class="bottom"></span>
            <span class="text">RECOVERY</span>
        </div>
        <div id="blocPage">
            <?= $content ?>
        </div>


        <?php
            if (connection(false)[0]) {
                ?>
        <a href="recovery.php?action=disconnect" id="wrapper">
            <div id="cube">
                <b class="front"><p>Déconnection</p></b>
                <b class="back"><p>Déconnection</p></b>
                <?php
            }
            else {
                ?>
        <a href="index.php?action=disconnect" id="wrapper">
            <div id="cube">
                <b class="front"><p>Menu Principal</p></b>
                <b class="back"><p>Menu Principal</p></b>
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