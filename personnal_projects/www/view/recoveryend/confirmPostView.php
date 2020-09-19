<?php
if (isset($msg)==false) {
	$msg="N/A";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="public/img/recovery.png">
        <title>Finished maintenance</title>
        <link rel="stylesheet" type="text/css" href="public/css/recovery.css" />
    </head>
        
    <body>
        <?php require("Manager/RecoveryManager.php"); ?>
        <style type="text/css">
        	.true:hover{
        		border-color: purple;
        	}

        	#flex {
        		display: flex;
        		padding-top: 3em;
        		flex-direction: column;
        		justify-content: space-around;
        	}
        	#flex * {
        		margin: auto;
        		margin-top: 1em;
        		padding: 1.5em;
        	}
        	p { text-align: center; }

        	div#news { opacity: 0.75; }
        </style>

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

        <div id="flex">
	        <h1 class="null" style="font-size: 2em;"><?= $msg ?></h1>
	        <a href="recovery.php?action=view"><h2 class="true">Retourner au Recovery</h2></a>
	        <a href="index.php?action=disconnect"><h2 class="true">Retourner au Site Principal</h2></a>
	    </div>

        <a href="index.php?action=disconnect" id="wrapper" style="display: none;">
            <div id="cube">
                <b class="front"><p>Menu Principal</p></b>
                <b class="back"><p>Menu Principal</p></b>
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

    <script type="text/javascript" src="public/js/recovery.js"></script>

</html>