<?php $title = "Logs";
    $css = "logs";
    $icon = "Logs.png"; ?>

<?php ob_start(); ?>
        <?php require("Manager/PasswordManager.php"); ?>
		<header id="Boot">
			<h1>Journal de changements V0.1.0</h1>
			<img src="public/img/Logo.png" id="Haut" alt="Logo">
			<img src="public/img/Logs.png" id="Bas" alt="Logs">
		</header>
		<div id="bloc_page">
            <!-- <a href="index.php?action=download&amp;download=Projet_Site_a_faire.ods"><h1 class="button">Changement prévus et qui ont été prévus.</h1></a> -->
            <div id="flex">
                <ul type="disc">
                    <li><h1>Patch 1 (27/11/19) V.0.2.0.1 : </h1></li>
                    <ul type="square">
                        <li><h2>Amélioration de la gestion des erreurs (de la BDD).</h2></li>
                    </ul>
                </ul>
                <ul type="disc">
                    <li><h1>Bêta 2 (11/08/19) V.0.2.0 : </h1></li>
                    <ul type="square">
                        <li><h2>Menu Maison : </h2></li>
                        <ul type="circle">
                            <li><h3>Menu personnalisé.</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Recovery : </h2></li>
                        <ul type="circle">
                            <li><h3>Ré-ouvrir le site.</h3></li>
                            <li><h3>Maintenance basique.</h3></li>
                            <li><h3>Maintenance avancée.</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Project Board Battle Game : </h2></li>
                        <ul type="circle">
                            <li><h3>Version Python (RC2)</h3></li>
                            <li><h3>Version Windows (1.0.0)</h3></li>
                            <li><h3>Version en local (1.0.0)</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Rudolf : </h2></li>
                        <ul type="circle">
                            <li><h3>Version Windows (1.0.0)</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Caisse à outils : </h2></li>
                        <ul type="circle">
                            <li><h3>Chiffrage et déchiffrage de phrases.</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Page de confirmation pour les téléchargements : </h2></li>
                        <ul type="circle">
                            <li><h3>Adaptation en fonction de l'extension (14 extensions reconnus + si l'extension n'est pas reconnu).</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Admin : </h2></li>
                        <ul type="circle">
                            <li><h3>Alertes pour les erreurs minimales (+ leur effacement).</h3></li>
                            <li><h3>Réinitilisation des Menus Maison.</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Correction de bugs : </h2></li>
                        <ul type="circle">
                            <li><h3>Avatar maintenant limité à 2Mo.</h3></li>
                            <li><h3>Amélioration globale du code.</h3></li>
                        </ul>
                    </ul>
                </ul>
                <ul type="disc">
                    <li><h1>Alpha 1 (25/06/19) V.0.1.1</h1></li>
                    <ul type="square">
                        <li><h2>Barre de chargement dans les pages de redirection.</h2></li>
                        <li><h2>Correction de bugs :</h2></li>
                        <ul type="circle">
                            <li><h3>Affichage des icônes.</h3></li>
                            <li><h3>Affichage ou non des redirections "MasterMenu".</h3></li>
                        </ul>
                    </ul>
                </ul>
                <ul type="disc">
                    <li><h1>Bêta 1 (12/03/19) V.0.1.0</h1></li>
                    <ul type="square">
                        <li><h2>Menu Maison.</h2></li>
                        <ul type="circle">
                            <li><h3>Menu par défaut.</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Page de gestion du compte</h2></li>
                        <ul type="circle">
                            <li><h3>Mail et Avatar modifiable.</h3></li>
                            <li><h3>Possibilité de supprimer le compte.</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Page d'administration.</h2></li>
                    </ul>
                    <ul type="square">
                        <li><h2>Jeux Rudolf</h2></li>
                        <ul type="circle">
                            <li><h3>Moteur finalisé.</h3></li>
                            <li><h3>Pause fonctionnel.</h3></li>
                            <li><h3>Interface tactile.</h3></li>
                            <li><h3>Changement de saisons.</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Page d'erreurs</h2></li>
                        <ul type="circle">
                            <li><h3>Enregistrement automatique des erreurs.</h3></li>
                            <li><h3>Arrêt du site si il y plus de 10 erreurs recensées.</h3></li>
                        </ul>
                    </ul>
                    <ul type="square">
                        <li><h2>Adaptation du CSS/HTML pour SmartPhone</h2></li>
                        <ul type="circle">
                            <li><h3>CSS modifié pour le journal de changements.</h3></li>
                        </ul>
                    </ul>
                </ul>
                <ul type="disc">
                    <li><h1>Alpha 1 : Sortie initiale (28/10/18) V.0.0.1</h1></li>
                    <ul type="square">
                        <li><h2>Minichat.</h2></li>
                        <li><h3>Journal de changement.</h3></li>
                        <li><h3>Gestion du compte.</h3></li>
                    </ul>
                </ul>
            </div>
        </div>
        <script type="text/javascript" src="public/js/Nuit.js"></script>
        <script type="text/javascript" src="public/js/Translation.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>