<?php $title = "Rudolf";
    $css = "rudolf";
    $icon = "Rudolf.png"; ?>

<?php ob_start(); ?>
	<?php require("Manager/PasswordManager.php"); ?>
		<header id="newsRudolf">
			<div id="affiche" class="trueRudolf">
				<ul>
					<li>Cadeaux/Feuilles/Oranges/Pommes : 5 points. (50%)</li>
					<li>Sucres d'orges/Fleurs/Citron/Raisins : 10 points. (25%)</li>
					<li>Éclairs/Vent/Soleils/Pluie : fait perdre une vie. (25%)</li>
				</ul>
			</div>
			<div id="version" class="falseRudolf" >
				<a target="_blank" href="https://developpeusedudimanche.itch.io/renne-cadeau-tuto">
					<figure>
						<img height="75px" src="https://pbs.twimg.com/profile_images/877992944002899972/qCF6gLIY_400x400.jpg" alt="itch.io">
						<figcaption>Projet Original</figcaption>
					</figure>
				</a>
				<a target="_blank" href="https://www.youtube.com/c/D%C3%A9veloppeuseDuDimanche">
					<figure>
						<img height="75px" src="https://lh3.googleusercontent.com/lMoItBgdPPVDJsNOVtP26EKHePkwBg-PkuY9NOrc-fumRtTFP4XhpUNk_22syN4Datc=s180-rw" alt="YouTube">
						<figcaption>Développeuse Du Dimanche : YouTube</figcaption>
					</figure>
				</a>
				<a target="_blank" href="https://twitter.com/dev_dimanche">
					<figure>
						<img height="75px" src="https://lh3.googleusercontent.com/32GbAQWrubLZX4mVPClpLN0fRbAd3ru5BefccDAj7nKD8vz-_NzJ1ph_4WMYNefp3A=s180-rw" alt="Twitter">
						<figcaption>Développeuse Du Dimanche : Twitter</figcaption>
					</figure>
				</a>
				<h2>Ce projet est libre de droit mais l'élaboration de certaines textures et idées (entre autres) sont de la Développeuse Du Dimanche.</h2>
			</div>
		</header>
		<header id="inconnus"><!-- <div id="spawn_i" class="spawn"></div> --></header>
		<aside id="aside_gauche">
			<div id="vies_img"><img src="public/img/Rudolf/Sprites/heart.png" alt="heart" id="cœur(s)_n°1"><img src="public/img/Rudolf/Sprites/heart.png" alt="heart" id="cœur(s)_n°2"><img src="public/img/Rudolf/Sprites/heart.png" alt="heart" id="cœur(s)_n°3"></div>
			<p>Points : <span id="points">0</span></p>
			<div id="show"><span id="show_txt">Détails</span><img alt="+" src="public/img/Rudolf/plus.png" id="show_img"><span> : </span></div>
			<span id="informationsComplementaires" style="display: none;">
				<div id="infos">
					<p>Vies : <span id="vies">3</span></p>
					<p>Saison : <span id="saisons_txt">Hiver</span> (<span id="saisons_nm">4</span>/4)</p>
					<p>Vitesse : <span id="px">X</span>px/250ms</p>
					<p>Apparition : toute les <span id="ms">X</span>ms</p>
				</div>
				<p id="resize" >Recadrer</p>
				<div id="booleens">
					<p>Debug : <span id="debug" style="color: red;">OFF</span></p>
					<p>Collison box : <span id="collision1" style="color: red;">OFF</span></p>
				</div>
			</span>
		</aside>
		<aside id="aside_droite">
			<img id="sound" src="public/img/Rudolf/sound_on.png" alt="sound_on"><br>
			<audio id="sound_audio" loop ><source src="public/sound/Free_Christmas_Music_8-Bit_Jingle_Bells.ogg" type="audio/ogg">Your browser does not support the audio tag.</audio><br>
			<img style="background-color: rgba(250, 250, 250, 0.5); border-radius: 10px;" id="plateforme" src="public/img/Rudolf/smartphone.png" alt="smartphone"><br>
		</aside>
		<aside id="contenu_plateforme">
			<img src="public/img/Rudolf/pause.png" alt="Pause" style="right: 50%; left: 50%; transform: translate(-50%, -50%); top: 72px; display: none;" id="plateforme_haut">
			<img src="public/img/Rudolf/gauche.png" alt="Gauche" style="top: 50%; bottom: 50%; transform: translate(-50%, -50%); left: 75px; display: none;" id="plateforme_gauche">
			<img src="public/img/Rudolf/droite.png" alt="Droite" style="top: 50%; bottom: 50%; transform: translate(-50%, -50%); right: -67px; display: none;" id="plateforme_droite">
		</aside>
		<section>
			<article id="neige">
				<img src="public/img/Rudolf/Sprites/Rudolf/Rudolf_0.png" id="rudolf" alt="rudolf" style="height: 75px; width: 75px; left: 0px;">
			</article>
		</section>
		<footer>
			<img id="version_img" src="https://yt3.ggpht.com/a-/AAuE7mBrvwU53FlH6crrgBNdrDnshmFp4e8M91Z6GQ=s288-mo-c-c0xffffffff-rj-k-no" alt="DéveloppeuseDuDimanche">
			<!--<a href="index.php?action=download&amp;download=Rudolf_Setup_1.0.0.exe.zip"><img src="public/img/extensions/windows.png" alt="Windows"></a>-->
		</footer>
		<script type="text/javascript" src="public/js/Rudolf.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>