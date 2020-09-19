<?php $title = $msg;
    $css = "account";
    $verslaPage = "de connection";
    $urlRedirection = "index.php?action=connection";
?>

<?php ob_start(); ?>
	<?php require("Manager/AutenticationManager.php"); ?>
	<h1><?= $msg ?></h1>
	<?php require('waitingView.php'); ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateAuthentication.php'); ?>