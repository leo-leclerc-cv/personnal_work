<?php $title = "Non administrateur·rice";
    $css = "account"; 
    $icon = "Admin.png";
    $verslaPage = "de gestion de Menu";
    $urlRedirection = "index.php?action=menu&menu=none";
?>

<?php ob_start(); ?>
	<?php require("Manager/PasswordManager.php"); ?>
    <h1>Vous n'êtes pas administrateur·rice.</h1>
	<?php require('waitingView.php'); ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>