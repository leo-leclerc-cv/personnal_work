<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="img/wrenchBits.png">
        <link rel="stylesheet" href="css/errorView.css" />
        <title>
        	<?php
	            if (isset($_GET["errorMessage"])) {
	                echo $_GET["errorMessage"];
	            }
	            else{
	                echo "Aucun message d'erreur n'a été récupéré.";
	            }
            ?>
            </title>
    </head>

    <body>
        <div id="flex">
            <span id="smiley">):</span>
            <span id="text"></span>
        </div>
        <h1 id="error"><span id="error_text"></span><span id="error_php">
            <?php
            if (isset($_GET["errorMessage"])) {
                echo $_GET["errorMessage"];
            }
            else{
                echo "Aucun message d'erreur n'a été récupéré.";
            }
            ?>
            </span></h1>
            <aside><a href="../index.php?action=disconnect"><h1>Accueil</h1></aside>
    </body>
    <script type="text/javascript" src="js/errorView.js"></script>
</html>