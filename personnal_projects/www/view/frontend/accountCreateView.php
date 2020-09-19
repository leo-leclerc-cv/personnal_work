<?php $title = "Créer un compte";
    $css = "account"; ?>

<?php ob_start(); ?>
        <?php require("Manager/AutenticationManager.php"); ?>
        <h1>Créer un compte</h1>
        <h3>L'avatar du compte ne gère pas la couche Alpha (la transparence). Le fichier doit être en PNG ou JPG et ne pas peser plus de 2 Méga octets.</h3>
        <h3>Le pseudo sera de la couleur favorite et affiché sur l'avatar.</h3>
        <h3>(Mail utilisé en cas de problèmes administratifs)</h3>
        <form action="index.php?action=accountCreatePost" method="post" enctype="multipart/form-data">
            <input type="text" name="pseudo" placeholder="Pseudo (100 caractères max) :" size="29" autofocus required />
            <input type="file" name="image" class="hideInput" id="fileLabel" />
            <label for="fileLabel" class="clickable">Avatar/Image du compte</label>
            <input type="color" name="color" class="hideInput" id="colorLabel">
            <label for="colorLabel" class="clickable">Couleur Favorite</label>
            <input type="email" name="mail" placeholder="Email (100 caractères max) :" size="28" />
            <input type="password" name="password" placeholder="Mot de passe (100 caractères max) :" size="35" required />
            <input type="submit" value="Créer un compte" />
        </form>
        <?php if (isset($_GET["authentication"])) {
            echo "<p class='false'>Les données de connection sont erronées</p>";
        } ?>
<?php $content = ob_get_clean(); ?>

<?php require('templateAuthentication.php'); ?>