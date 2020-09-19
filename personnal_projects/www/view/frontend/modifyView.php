<?php $title = "Modifier";
    $css = "account"; 
    $icon = "wrenchBits.png"; ?>

<?php
ob_start();
require("Manager/PasswordManager.php");
if (isset($_GET["modify"])) {
    switch ($_GET["modify"]) {
        case 'mail':
             ?>
            <h1>Email original : <?= $mail ?></h1>
            <form action="index.php?action=modifyPost&amp;modify=mail" method="post">
                <input type="email" name="mail" placeholder="Email (100 caractères max) :" size="28" >
                <input type="submit" value="Changer d'Email" />
            </form>
            <?php
        break;

        case 'avatar':
            ?>
            <figure>
                <img src="public/img/users/<?= mb_strtoupper($_SESSION['pseudo'], 'UTF-8') ?>.png" alt="Avatar">
                <figcaption><h3>Avatar original</h3></figcaption>
            </figure>
            <form action="index.php?action=modifyPost&amp;modify=avatar" method="post" enctype="multipart/form-data">
                <input type="file" name="image" class="hideInput" id="fileLabel" />
                <label for="fileLabel" class="clickable">Avatar/Image du compte</label>
                <input type="color" name="color" class="hideInput" id="colorLabel">
                <label for="colorLabel" class="clickable">Couleur Favorite</label>
                <input type="submit" value="Changer l'avatar" />
            </form>
            <h1>Attention l'image ne doit pas dépasser 2 Méga octets !</h1>
            <?php
        break;
        
        default:
            header("Location: index.php?action=menu&menu=none&error=modify_was_set_to_".$_GET["modify"]);
        break;
    }
}
else {
    header("Location: index.php?action=menu&menu=none&error=modify_was_not_set");
}
?>
        <script type="text/javascript" src="public/js/Nuit.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>