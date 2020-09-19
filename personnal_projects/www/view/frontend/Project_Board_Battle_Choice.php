<?php
    $title = "Project Board Battle";
    $css = "Project_Board_Battle_Choice"; 
    $icon = "Project_Board_Battle_Game.png";
?>

<?php ob_start(); ?>
        <?php require("Manager/PasswordManager.php"); ?>

        <div id="choice">
            <a href="index.php?action=menu&amp;menu=Project_Board_Battle_Game&amp;Project_Board_Battle_Game=local"><figure>
                <img src="public/img/Project_Board_Battle_Game/VS.png" alt="VS">
                <figcaption>1 versus 1 en local</figcaption>
            </figure></a>
            <!-- <a href="index.php?action=menu&amp;menu=Project_Board_Battle_Game&amp;Project_Board_Battle_Game=web"> --><figure onclick="alert('Le développemet a été mis en pause.\nMerci de votre patience et compréhension.')">
                <img src="public/img/Project_Board_Battle_Game/VS_Web.png" alt="Web">
                <figcaption>1 versus 1 en ligne</figcaption>
            </figure><!-- </a> -->
            <a href="https://dawnowl444.000webhostapp.com/API/AJAX.php?manualDownload=true"><figure>
                <img src="public/img/extensions/windows.png" alt="Windows">
                <figcaption>1 versus 1 sous Windows</figcaption>
            </figure></a>
            <!--<a href="index.php?action=download&amp;download=Project_Board_Battle_Game_Python_RC2.zip"><figure>
                <img src="public/img/extensions/python.png" alt="Python">
                <figcaption>1 versus 1 en Python</figcaption>
            </figure></a>-->
        </div>

        <h2>Commandes de Project Board Battle Game au clavier :</h2>
        <h3>Se déplacer : <img src="public/img/Project_Board_Battle_Game/Summary/Arrow.png" alt="keyboard_arrows"> et <img src="public/img/Project_Board_Battle_Game/Summary/ZQSD.png" alt="keyboard_ZQSD">.</h3>
        <h3>Passer son tour : <img src="public/img/Project_Board_Battle_Game/Summary/Space.png" alt="space_bar">.</h3>

        <h2>Commandes de Project Board Battle Game au tactile/souris :</h2>
        <h3>Se déplacer : cliquer sur <img src="public/img/Project_Board_Battle_Game/Summary/mark.png" alt="mark"> (indicateur de déplacement).</h3>
        <h3>Passer son tour : cliquer sur l'indicateur de point•s de mouvement.</h3>

        <h2>Mécaniques de jeu :</h2>
        <h3>Lorsque deux pions ou plus alliés encerclent un pion ennemi ce dernier est éliminé. Et vice versa. Il reviendra alors à sa case de départ <img src="public/img/Project_Board_Battle_Game/Summary/respawn.png" alt="respawn"> .</h3>
        <h3>Le but est d'aller sur la case magique <img src="public/img/Project_Board_Battle_Game/Summary/magie.png" alt="magie"> pour marquer jusqu'à 50 points.</h3>

        <script type="text/javascript" src="public/js/Nuit.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>