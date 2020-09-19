<?php $title = "Mini Chat";
    $css = "minichat"; 
    $icon = "MiniChat.png"; ?>

<?php ob_start(); ?>
        <?php require("Manager/PasswordManager.php"); ?>
    	<header>
    		<form action="index.php?action=menu&amp;menu=chat&amp;chat=post" method="post">
                <a href="index.php?action=menu&amp;menu=chat&amp;chat=view"><input type="button" name="Reload" value="Actualiser"></a>
    			<p><?= $_SESSION["pseudo"] ?></p>
                <textarea type="text" name="message" placeholder="Message à envoyer"></textarea>
    			<input type="submit" name="Envoyer" value="Envoyer" />
    		</form>
    	</header>

    	<section>
    		<?php
            if ($messages!=null && isset($messages)) {
                while ($donnees = $messages->fetch()) {     ?>
                    <div class="msgBox">
                        <span class="msgDate">[<?= $donnees["date_ordonne"]; ?>]</span>
                        <span class="rowOnly">--</span>
                        <figure>
                            <img src="public/img/users/<?= mb_strtoupper($donnees["pseudo"], 'UTF-8') ?>.png" alt="Avatar de <?= $donnees["pseudo"] ?>" height="50px">
                            <span class="msgPseudo"><?= $donnees["pseudo"] ?></span>
                        </figure>
                        <span class="rowOnly">--</span>
                        <span class="msgMsg"><?= $donnees["message"]; ?></span>
                    </div>
                <?php   }
                $messages->closeCursor();
            }
            else {
                ?><h1 id="error">Cette page ne contient aucune données</h1><?php
            }
    		?>
    	</section>

        <footer>
            <a href="index.php?action=menu&amp;menu=chat&amp;chat=view&amp;page=0"><h2>Page n°0</h2></a>
            <a href="index.php?action=menu&amp;menu=chat&amp;chat=view&amp;page=<?= $page_actuelle-1 ?>"><h2>Page précédente</h2></a>
            <a href="index.php?action=menu&amp;menu=chat&amp;chat=view&amp;page=<?= $page_actuelle+1 ?>"><h2>Page suivante</h2></a>
        </footer>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>