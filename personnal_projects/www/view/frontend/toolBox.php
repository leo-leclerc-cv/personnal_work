<?php $title = "Boite à outils";
    $css = "toolBox";
    $icon = "toolBox.png"; ?>

<?php ob_start(); ?>
        <?php require("Manager/PasswordManager.php"); ?>
		<header id="Boot">
			<h1>Boite à outils V0.1.0</h1>
			<img src="public/img/Logo.png" id="Haut" alt="Logo">
			<img src="public/img/toolBox.png" id="Bas" alt="Logs">
		</header>
		<div id="bloc_page">
            <form action="index.php?action=menu&menu=toolBox" method="post">
                <textarea name="encryption" placeholder="Phrase à chiffrer"><?php if (isset($_POST["encryption"])) { echo $_POST["encryption"]; } ?></textarea>
                <p class="right">→</p>
                <p class="down">↓</p>
                <input type="submit" value="Chiffrer" />
                <p class="right">→</p>
                <p class="down">↓</p>
                <textarea placeholder="Clé de chiffrement"><?php
                    if (isset($_POST["encryption"])) {
                        echo password_hash($_POST["encryption"], PASSWORD_DEFAULT);
                    }
                ?></textarea>
            </form>

            <form action="index.php?action=menu&menu=toolBox" method="post">
                <textarea name="password" placeholder="Phrase à déchiffrer"><?php if (isset($_POST["password"])) { echo $_POST["password"]; } ?></textarea>
                <p>+</p>
                <textarea name="hash" placeholder="Clé de chiffrement"><?php if (isset($_POST["hash"])) { echo $_POST["hash"]; } ?></textarea>
                <p class="right">→</p>
                <p class="down">↓</p>
                <input type="submit" value="Déchiffrer" />
                <p class="right">→</p>
                <p class="down">↓</p>
                <p>La phrase chiffré l'a été avec la clé de chiffrement : </p><input type="text" size="5" value="<?php
                    if (isset($_POST["hash"])&&isset($_POST["password"])) {
                        switch (password_verify($_POST["password"], $_POST["hash"])) {
                            case 1:
                                echo "true";
                            break;

                            case 0:
                                echo "false";
                            break;
                            
                            default:
                                echo "corrupt";
                            break;
                        }
                    }
                    else {
                        echo "null";
                    }
                ?>"readonly></input>
            </form>
        </div>
        <script type="text/javascript" src="public/js/Nuit.js"></script>
        <script type="text/javascript" src="public/js/Translation.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>