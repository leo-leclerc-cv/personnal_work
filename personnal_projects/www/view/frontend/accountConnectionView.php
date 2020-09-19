<?php
    $title = "Se connecter";
    $css = "account";
?>

<?php ob_start(); ?>
        <?php require("Manager/AutenticationManager.php"); ?>
        <h1>Se connecter</h1>
        <form action="index.php?action=accountPost" method="post">
            <input required type="text" name="pseudo" placeholder="Pseudo :" autofocus />
            <input required type="password" name="password" placeholder="Mot de passe :" />
            <input type="submit" value="Se connecter" />
        </form>
        <?php if (isset($_GET["fail"])) {
            echo "<p class='false'>Les données de connection sont erronées</p>";
        } ?>
        <div style="height: 0.5em;" ></div>
        <span class="big_button"><a href="index.php?action=accountCreate">Créer un compte</a></span>
<?php $content = ob_get_clean(); ?>

<?php require('templateAuthentication.php'); ?>