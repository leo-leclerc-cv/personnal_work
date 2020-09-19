<?php $title = "Gestion du compte";
    $css = "accountView"; 
    $icon = "Account.png"; ?>

<?php ob_start(); ?>
        <?php require("Manager/PasswordManager.php"); ?>
        <header id="Boot">
            <h1>Gestion du compte V0.1.0</h1>
            <img src="public/img/Logo.png" id="Haut" alt="Logo">
            <img src="public/img/Account.png" id="Bas" alt="Account">
        </header>
        <div id="bloc_page">
            <div class="flex">
                <h1>Pseudo : <?= $pseudo ?></h1>
                <div class="option">
                    <img src="public/img/users/<?= mb_strtoupper($pseudo, 'UTF-8') ?>.png" alt="Avatar">
                    <a href="index.php?action=modify&amp;modify=avatar"><span class="button">Modifier l'avatar et la couleur</span></a>
                </div>
                <div class="option">
                    <h1>Email : <?= $mail ?></h1>
                    <a href="index.php?action=modify&amp;modify=mail"><span class="button">Modifier le mail</span></a>
                </div>
                <a href="index.php?action=confirm&amp;confirm=account"><span class="danger">Supprimer le compte</span></a>
            </div>
        </div>
        <script type="text/javascript" src="public/js/Nuit.js"></script>
        <script type="text/javascript" src="public/js/Translation.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>