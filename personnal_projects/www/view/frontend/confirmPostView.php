<?php $title = $msg;
    $css = "account"; 
    $icon = "wrench.png";
    if (isset($verslaPage)&&isset($verslaPage)) {}
    else {
    	$verslaPage="Default : index ($verslaPage_was_not_set)";
    	$urlRedirection = "index.php";
    }
?>

<?php ob_start(); ?>
	<?php require("Manager/PasswordManager.php"); ?>
    <h1><?= $msg ?></h1>
	<?php require('waitingView.php'); ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>