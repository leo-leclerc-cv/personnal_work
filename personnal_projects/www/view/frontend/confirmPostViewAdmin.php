<?php $title = $msg;
    $css = "account"; 
    $icon = "wrenchBits.png";
    $verslaPage = "d'administration";
    $urlRedirection = "index.php?action=menu&menu=admin";
?>

<?php ob_start(); ?>
	<?php require("Manager/AdminManager.php"); ?>
    <h1><?= $msg ?></h1>
	<?php require('waitingView.php'); ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>