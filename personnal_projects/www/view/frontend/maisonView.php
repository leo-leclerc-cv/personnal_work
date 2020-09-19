<?php $title = "Menu Maison";
    $css = "maison";
    $icon = "Home.png"; ?>

<?php ob_start(); ?>
        <?php require("Manager/PasswordManager.php"); ?>
        <header id="Boot">
            <h1>Menu Maison V0.1.0</h1>
            <img src="public/img/Logo.png" id="Haut" alt="Logo">
            <img src="public/img/Home.png" id="Bas" alt="Home">
        </header>
        <div id="form">
            <div id="crossBorder"> 
                <div id="cross1"></div>
                <div id="cross2"></div>
            </div>
            <p>Ancien titre : <span id="oldTitle">old title</span></p>
            <form action="index.php?action=menu&amp;menu=maison&amp;maison=change" method="post">
                <span class="labelAndInput"><label for="maisonid">Élément n°</label><input id="maisonid" type="text" name="maisonid" size="1" value="X" readonly /></span>
                <span class="labelAndInput"><label for="title">Nouveau titre de l'élement (pas de caractères spéciaux ni d'apostrophes mais les caractères accentués sont autorisés) : </label><input required type="textarea" name="title" placeholder="Nouveau titre" maxlength="150" /></span>
                <span class="labelAndInput"><label for="image">Nouvel URL de l'icône de l'élement : </label><input required type="url" name="image" placeholder="Nouvel URL de l'icône" size="25" /></span>
                <span class="labelAndInput"><label for="url">Nouvel URL du lien de l'élement : </label><input required type="url" name="url" placeholder="Nouvel URL" size="25" /></span>
                <input type="submit" value="Modifier" />
            </form>  
        </div>

        <div id="bloc_page">
            <div id="flex">
                <?php
                while ($data = $maison->fetch()) { ?>
                <span class="maison"><figure>
                    <img id="<?= $data['maisonid'] ?>" title="<?= $data['title'] ?>" src="public/img/Tools.png" alt="Modifier" class="modifier">
                    <a href="<?= $data['url'] ?>"><img src="<?= $data['image'] ?>" alt="<?= $data['title'] ?>_Logo" class="logo">
                    <figcaption class="title"><?= $data['title'] ?></figcaption></a>
                </figure></span>
                <?php }
                $maison->closeCursor(); ?>
            </div>
            <footer>
                <a href="index.php?action=confirm&amp;confirm=resetMaisonUser"><img src="public/img/reset.png" alt="Reset" id="reset"></a>
                <img src="public/img/horizontalWrench.png" alt="Activer_modification" id="wrench">
            </footer>
        </div>
        <script type="text/javascript" src="public/js/Maison.js"></script>
        <script type="text/javascript" src="public/js/Nuit.js"></script>
        <script type="text/javascript" src="public/js/Translation.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>