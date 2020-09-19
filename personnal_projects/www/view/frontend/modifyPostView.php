<?php $title = $msg;
    $css = "account"; 
    $icon = "wrenchBits.png";
    $verslaPage = "de gestion du compte";
    $urlRedirection = "index.php?action=menu&menu=account";
    ?>

<?php ob_start(); ?>
	<?php require("Manager/PasswordManager.php"); ?>
    <h1><?= $msg ?></h1>
	<?php require('waitingView.php'); ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>