<?php $title = "Menu";
    $css = "menu"; ?>

<?php ob_start(); ?>
        <?php require("Manager/PasswordManager.php"); ?>
		<header id="Boot">
			<h1>Menu View V0.1.0</h1>
			<img src="public/img/Logo.png" id="Haut" alt="Logo">
			<img src="public/img/Menu.png" id="Bas" alt="Menu">
		</header>
		<div id="bloc_page">
        	<h1>Bienvenue en ces lieux reculés.</h1>
        	<div id="menu">
        		<a href="index.php?action=menu&amp;menu=chat&amp;chat=view&amp;page=0"><figure>
        			<img src="public/img/MiniChat.png" alt="Chat_logo">
        			<figcaption>MiniChat</figcaption>
        		</figure></a>
                <a href="index.php?action=menu&amp;menu=account"><figure>
                    <img src="public/img/Account.png" alt="Account_logo">
                    <figcaption>Gestion du compte</figcaption>
                </figure></a>
                <a href="index.php?action=menu&amp;menu=logs"><figure>
                    <img src="public/img/Logs.png" alt="Logs_logo">
                    <figcaption>Journal de changements</figcaption>
                </figure></a>
                <a href="index.php?action=menu&amp;menu=admin"><figure>
                    <img src="public/img/Admin.png" alt="Admin_logo">
                    <figcaption>Administration</figcaption>
                </figure></a>
                <a href="index.php?action=menu&amp;menu=rudolf"><figure>
                    <img src="public/img/Rudolf.png" alt="Rudolf">
                    <figcaption>Rudolf</figcaption>
                </figure></a>
                <a href="index.php?action=menu&amp;menu=maison&amp;maison=view"><figure>
                    <img src="public/img/Home.png" alt="Home">
                    <figcaption>Menu Maison</figcaption>
                </figure></a>
                <a href="index.php?action=menu&amp;menu=Project_Board_Battle_Game&amp;Project_Board_Battle_Game=choice"><figure>
                    <img src="public/img/Project_Board_Battle_Game.png" alt="Home">
                    <figcaption>Project Board Battle Game</figcaption>
                </figure></a>
                <a href="index.php?action=menu&amp;menu=toolBox"><figure>
                    <img src="public/img/toolBox.png" alt="Tool_box">
                    <figcaption>Boite à outils</figcaption>
                </figure></a>
        	</div>        	
        </div>
        <?php
        if (isset($_GET["error"])) {
            echo "<p class='false'>Erreur fatale : ".$_GET["error"]."</p>";
        }?>
        <script type="text/javascript" src="public/js/Calendar.js"></script>
        <script type="text/javascript" src="public/js/Translation.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateAuthentication.php'); ?>