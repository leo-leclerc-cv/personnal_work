<?php $title = "Confirmation";
    $css = "confirm"; 
    $icon = "wrenchBits.png";
    $noMasterMenu=true;
?>

<?php ob_start(); ?>
        <?php 
        if (isset($_GET["admin"])&&$_GET["admin"]=="true") {
            require("Manager/AdminManager.php");
        }
        else {
            require("Manager/PasswordManager.php");
        }?>
        <h1><?= $msg ?></h1>
        <h1>Êtes vous sûr·e ?</h1>
        <div class="flex">
            <a href="index.php?action=confirmPost&amp;confirm=<?= $_GET['confirm'] ?><?php if(isset($_GET['admin'])) { ?>&amp;admin=<?= $_GET['admin'] ?><?php } ?>"
            class="Y"><span>Oui</span></a>
            <a href="index.php?action=menu&amp;menu=none" class="N"><span>Non</span></a>
        </div>
        <script type="text/javascript" src="public/js/Nuit.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>