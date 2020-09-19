<?php
    $title = "Authentification";
    $css = "account";
    $noMasterMenu=true;
?>

<?php ob_start(); ?>
        <h1>Ce site est privé, si vous êtes arrivé·e ici par mégarde veuillez partir.</h1>
        <form action="index.php?action=authenticationPost" method="post">
            <input required type="password" name="authentication" size="35" placeholder="Mot de passe d'authentication : " autofocus />
            <input type="submit" name="index" value="Authentication" />
        </form>
        <?php
        if (isset($_GET["authentication"])) {
            echo "<p class='false'>Le mot de passe est erroné</p>";
        }
        elseif (isset($_GET["action"])&&$_GET["action"]=="disconnect") {
            echo "<p class='false'>Vous avez été déconnecté·e</p>";
        }
        elseif (isset($_GET["error"])) {
            session_destroy();
            echo "<p class='false'>Erreur fatale : ".$_GET["error"]."</p>";
        }?>
<?php $content = ob_get_clean(); ?>

<?php require('templateAuthentication.php'); ?>