<?php ob_start(); ?>
    <div id="news"><p>Recovery hors ligne.</p></div>
    <style type="text/css">
        #connectionBlocPage {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }
        h1 {
            text-align: center;
            margin: 2em;
        }
        form{
            margin-bottom: 8em;
        }
        form * {
            margin: 5em;
        }
    </style>
    <div id="connectionBlocPage">
        <h1>Mode sans échec ; Administrateurs·rices uniquement</h1>
        <form action="recovery.php?action=post" method="post">
            <input required type="password" name="authentication" size="35" placeholder="Mot de passe d'authentication : " autofocus />
            <input required type="text" name="pseudo" size="35" placeholder="Pseudo de compte : " autofocus />
            <input required type="password" name="password" size="35" placeholder="Mot de passe de compte : " autofocus />
            <input type="submit" name="index" value="Authentication" />
        </form>
    </div>
    <?php
    if (isset($_GET["authentication"])) {
        echo "<p class='false'>Les données de connection sont erronées</p>";
    }
    elseif (isset($_GET["action"])&&$_GET["action"]=="disconnect") {
        echo "<p class='false'>Vous avez été déconnecté·e</p>";
    }
    elseif (isset($_GET["error"])) {
        session_destroy();
        echo "<p class='false'>Erreur : ".$_GET["error"]."</p>";
    }?>
<?php $content = ob_get_clean(); ?>

<?php require('templateRecovery.php'); ?>