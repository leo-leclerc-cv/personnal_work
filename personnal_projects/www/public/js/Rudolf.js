// transformer une chaine de charactère avec "px" en chaine de chiffres
function px (pxX) {
	var reponse="";
	for (var i = 0; i < pxX.length; i++) {
		if (pxX[i]==="p") {
			for (var ii = 0; ii < pxX.length; ii++) {
				if (pxX[ii]!=="p" && pxX[ii]!=="x") {
					reponse = reponse + String(pxX[ii]);
				}
			}
		}
	}
	reponse = Number(reponse)
	return (reponse);
}

// attribuer tailles
function Objet (objetX) {
	var tmp = {
	    y: px(document.getElementById(objetX).style.top),
	    x: px(document.getElementById(objetX).style.left),
	    larg: px(document.getElementById(objetX).style.width),
	    long: px(document.getElementById(objetX).style.height)
	};
	return tmp;
}

// détecter collisions/éléments ayant des points confondus
function hitBox (elmt1, elmt2, elmt2X, elmt2Y) {
	var moyenneLarg = (elmt1.larg+elmt2.larg)/2;
	var moyenneLong = (elmt1.long+elmt2.long)/2;
	if ((Math.abs(elmt1.x-elmt2X.x)<moyenneLarg)&&(Math.abs(elmt1.y-elmt2Y.y)<moyenneLong)) { var tmp=true; }
	else { var tmp=false; }
	return tmp;
}

// affiche une newsRudolf et stop toutes les intervalles
function erreur (msg) {
	document.getElementById("newsRudolf").insertAdjacentHTML("beforeEnd", '<h1 onclick="location.reload();" style="z-index: 5; text-align: center; background-color: black; color: red; border: 5px solid red; margin: 10px; padding: 25px;">'+msg+'</br>Cliquer pour recharger.</h1>');
	clearInterval(intervalInconnu);
	clearInterval(intervalDescente0);
	clearInterval(intervalDescente1);
	clearInterval(intervalDescente2);
	clearInterval(intervalDescente3);
	clearInterval(intervalDescente4);
	clearInterval(intervalRudolf);
	clearInterval(intervalEclair);
	clearInterval(intervalRudolf);
	clearInterval(intervalEclair);
	intervalRudolf=null;
	console.warn("All interval cleared");
	if (sound===0) {
		document.getElementById("aside_droite").removeChild(document.getElementById("sound_audio"));
		document.getElementById("sound").src = "sound_off.png";
		document.getElementById("sound").alt = "sound_off";
	}
}
function arret () { erreur("Arrêt"); }

// même fonction que erreur mais bleu + son
function gameOver () {
	document.getElementById("newsRudolf").insertAdjacentHTML("beforeEnd", '<h1 onclick="location.reload();" style="z-index: 5; text-align: center; background-color: black; color: blue; border: 5px solid blue; margin: 10px; padding: 25px;">Game Over !</h1>');
	document.getElementById("newsRudolf").insertAdjacentHTML("beforeEnd", '<audio autoplay ><source src="public/sound/GameOver.ogg" type="audio/ogg">Your browser does not support the audio tag.</audio>');
	clearInterval(intervalInconnu);
	clearInterval(intervalDescente0);
	clearInterval(intervalDescente1);
	clearInterval(intervalDescente2);
	clearInterval(intervalDescente3);
	clearInterval(intervalDescente4);
	clearInterval(intervalRudolf);
	clearInterval(intervalEclair);
	clearInterval(intervalRudolf);
	clearInterval(intervalEclair);
	intervalRudolf=null;
	console.log("gameOver : All intervals cleared");
	var tmpLength = spawn.length;
	for (var i = 0; i < tmpLength; i++) {
		if (document.getElementById("inconnu_"+i)!==null) {
			document.getElementById("spawn_"+i).removeChild(document.getElementById("inconnu_"+i));
		}
		document.getElementById("inconnus").removeChild(document.getElementById("spawn_"+i));
	}
	if (sound===0) {
		document.getElementById("aside_droite").removeChild(document.getElementById("sound_audio"));
		document.getElementById("sound").src = "sound_off.png";
		document.getElementById("sound").alt = "sound_off";
	}
	document.querySelector("article").removeChild(document.getElementById("rudolf"));
	console.log("gameOver : All childs removed");
}

// animation de Rudolf
var rudolfEtat=true;
function rudolfInterval () {
	if (rudolfEtat) { document.getElementById("rudolf").src = "public/img/Rudolf/Sprites/Rudolf/Rudolf_1.png"; rudolfEtat=false;}
	else { document.getElementById("rudolf").src = "public/img/Rudolf/Sprites/Rudolf/Rudolf_0.png"; rudolfEtat=true;}
}

// Animation de Rudolf+eclair, stuned, arrêt de rudolfInterval /!\bugué/!\
var eclairEtat=true, intervalEclair=null;
function eclairAnimation () {
	if (eclairEtat) {
		switch (saisons) {
		  case 1:
			document.getElementById("rudolf").src = "public/img/Rudolf/Sprites/Rudolf/Rudolf_electrique.png";
			eclairEtat=false;
		  break;
		  case 2:
		  case 4:
			document.getElementById("rudolf").src = "public/img/Rudolf/Sprites/Rudolf/Rudolf_gele.png";
			eclairEtat=false;
		  break;
		  case 3:
			document.getElementById("rudolf").src = "public/img/Rudolf/Sprites/Rudolf/Rudolf_flame.png";
			eclairEtat=false;
		  break;
		  default:
		    erreur("Out of seasons !")
		  break;
		}
	}
	else { document.getElementById("rudolf").src = "public/img/Rudolf/Sprites/Rudolf/Rudolf_0.png"; eclairEtat=true; }	
}
var eclair = false;
function eclairInterval () {
	stuned++;
	clearInterval(intervalEclair);
	intervalEclair=null;
	clearInterval(intervalRudolf);
	intervalRudolf=null;
	eclair=true;
	intervalEclair = setInterval(eclairAnimation, 150);
	setTimeout(function(){ clearInterval(intervalEclair); }, 3000);
	setTimeout(function(){ intervalEclair=null; }, 3000);
	setTimeout(function(){ document.getElementById("rudolf").src = "public/img/Rudolf/Sprites/Rudolf/Rudolf_0.png"; }, 3000);
	setTimeout(function(){ if (eclairPause!==true){ intervalRudolf = setInterval(rudolfInterval, 500); } }, 3000);
	setTimeout(function(){ stuned-- ; }, 3000);
	setTimeout(function(){ eclair = false; }, 3000);
}

// newsRudolf, message d'avancement dans le niveau --> augmente vitesse (scrolling+2px et spawn toutes les -75ms) + ajoutes vies + changement de saison
function avancementFunction (msg) {
	if (saisons<4) { saisons++; }
	else { saisons=1; }
	switch (saisons) {
	  case 1:
		document.getElementById("saisons_txt").textContent = "Hiver";
		body.style.backgroundImage = 'url("public/img/Rudolf/Backgrounds/Hiver.png")';
		body.style.backgroundColor = 'rgb(0, 15, 63)';
		document.getElementById("neige").style.backgroundImage = 'url("public/img/Rudolf/Backgrounds/Neige.png")';
		document.getElementById("saisons_nm").textContent = saisons+3;
	  break;
	  case 2:
		document.getElementById("saisons_txt").textContent = "Printemps";
		body.style.backgroundImage = 'url("public/img/Rudolf/Backgrounds/Printemps.jpg")';
		body.style.backgroundColor = 'rgb(211, 202, 19)';
		document.getElementById("neige").style.backgroundImage = "none";
		document.getElementById("saisons_nm").textContent = saisons-1;
	  break;
	  case 3:
		document.getElementById("saisons_txt").textContent = "Été";
		body.style.backgroundImage = 'url("public/img/Rudolf/Backgrounds/Ete.jpg")';
		body.style.backgroundColor = 'rgb(131, 141, 55)';
		document.getElementById("neige").style.backgroundImage = "none";
		document.getElementById("saisons_nm").textContent = saisons-1;
	  break;
	  case 4:
		document.getElementById("saisons_txt").textContent = "Automne";
		body.style.backgroundImage = 'url("public/img/Rudolf/Backgrounds/Automne.jpg")';
		body.style.backgroundColor = 'rgb(147, 56, 9)';
		document.getElementById("neige").style.backgroundImage = "none";
		document.getElementById("saisons_nm").textContent = saisons-1;
	  break;
	  default:
	    erreur("Out of seasons !")
	  break;
	}
	scoringLimit++;
	avancement = avancement + 2;
	document.getElementById("px").textContent = avancement;
	clearInterval(intervalInconnu);
	intervalInconnu = null;
	spawnTime = spawnTime - 75;
	intervalInconnu = setInterval(inconnuInterval, spawnTime);
	document.getElementById("ms").textContent = spawnTime;
	document.getElementById("newsRudolf").insertAdjacentHTML("beforeEnd", '<h1 id="avancement" style="z-index: 4; text-align: center; background-color: white; color: blue; border: 5px solid blue; margin: 10px; padding: 25px;" >Speed up '+msg+' !</h1>');
	setTimeout(function(){ document.getElementById("newsRudolf").removeChild(document.getElementById("avancement")); }, 1000);
	if (scoringLimit%2===0) {
		document.getElementById("vies").textContent = Number(document.getElementById("vies").textContent) + 1;
		coeurs++;
		document.getElementById("vies_img").insertAdjacentHTML("beforeEnd", '<img src="public/img/Rudolf/Sprites/heart.png" alt="heart" id="cœur(s)_n°'+coeurs+'">');
		document.getElementById("newsRudolf").insertAdjacentHTML("beforeEnd", '<h1 id="avancement2" style="z-index: 4; text-align: center; background-color: white; color: red; border: 5px solid red; margin: 10px; padding: 25px;" >Une vie en plus !</h1>');
		setTimeout(function(){ document.getElementById("newsRudolf").removeChild(document.getElementById("avancement2")); }, 1000);
	}
}
// Ajouts des points + son collision si activé
function pointSonResultat (pts) {
	document.getElementById("points").textContent = Number(document.getElementById("points").textContent) + pts;
	if (sound!==2) {
		document.getElementById("newsRudolf").insertAdjacentHTML("beforeEnd", '<audio id="collect_audio" autoplay ><source src="public/sound/Collect.ogg" type="audio/ogg">Your browser does not support the audio tag.</audio>');
		setTimeout(function(){ document.getElementById("newsRudolf").removeChild(document.getElementById("collect_audio")); }, 1000);
	}
}
// attribution des valeurs en fonction de la collision ou vérification gameOver + lancement avancementFunction 
function point (id) {
	var alt = document.getElementById("inconnu_"+id).alt; var continuer=true;
	if (alt==="Cadeau"||alt==="Feuille"||alt==="Orange"||alt==="Pomme"){ pointSonResultat(5); }
	else if (alt==="Sucredorge"||alt==="Fleur"||alt==="Citron"||alt==="Raisin"){ pointSonResultat(10); }
	if (alt==="Eclair"||alt==="Vent"||alt==="Soleil"||alt==="Pluie"){
		document.getElementById("vies").textContent = Number(document.getElementById("vies").textContent) - 1;
		document.getElementById("vies_img").removeChild(document.getElementById("cœur(s)_n°"+coeurs));
		coeurs--;
		if (Number(document.getElementById("vies").textContent)<=0) { document.getElementById("vies").textContent = "X"; fini=true; gameOver(); continuer=false;}
		else { eclairInterval(); }
	}
	else {
		if (Number(document.getElementById("points").textContent)>=50&&scoringLimit<1) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=100&&scoringLimit<2) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=150&&scoringLimit<3) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=200&&scoringLimit<4) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=250&&scoringLimit<5) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=300&&scoringLimit<6) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=350&&scoringLimit<7) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=400&&scoringLimit<8) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=450&&scoringLimit<9) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=500&&scoringLimit<10) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=550&&scoringLimit<11) { avancementFunction(""); }
		else if (Number(document.getElementById("points").textContent)>=600&&scoringLimit<12) { avancementFunction("max"); }
	}
	if (continuer) {
		spawn[id].removeChild(document.getElementById("inconnu_"+id));
		if (booleenDebug) { spawn[id].style.backgroundColor = "red"; }
		spawnNumber[id]=true;
		spawnTotal--;
		if (booleenDebug) { console.log("Récupéré inconnu : "+id); }
	}
}


// scrolling/vérification collision/suppression (si en dehors des limites) pour chaque élément
function descenteInterval () {
	if (presence0) {
		if (hitBox(rudolf, inconnu[0], divInconnu[0], inconnu[0])) { point(0); presence0=false; clearInterval(intervalDescente0); intervalDescente0 = null; }
		else if (px(document.getElementById("inconnu_0").style.top)<fenetre.y+45) {
			if (fini!==true) {
				document.getElementById("inconnu_0").style.top = px(document.getElementById("inconnu_0").style.top) + avancement + "px";
				inconnu[0].y = inconnu[0].y + avancement;
			}
		}
		else {
			clearInterval(intervalDescente0);
			intervalDescente0 = null;
			spawn[0].removeChild(document.getElementById("inconnu_0"));
			if (booleenDebug) { console.log("Clear inconnu : 0"); spawn[0].style.backgroundColor = "red"; }
			spawnNumber[0]=true;
			presence0=false;
			spawnTotal--;
		}
	}
	if (presence1) {
		if (hitBox(rudolf, inconnu[1], divInconnu[1], inconnu[1])) { point(1); presence1=false; clearInterval(intervalDescente1); intervalDescente1 = null; }	
		else if (px(document.getElementById("inconnu_1").style.top)<fenetre.y+45) {
			if (fini!==true) {
				document.getElementById("inconnu_1").style.top = px(document.getElementById("inconnu_1").style.top) + avancement + "px";
				inconnu[1].y = inconnu[1].y + avancement;
			}
		}
		else {
			clearInterval(intervalDescente1);
			intervalDescente1 = null;
			spawn[1].removeChild(document.getElementById("inconnu_1"));
			if (booleenDebug) { console.log("Clear inconnu : 1"); spawn[1].style.backgroundColor = "red"; }
			spawnNumber[1]=true;
			presence1=false;
			spawnTotal--;
		}
	}
	if (presence2) {
		if (hitBox(rudolf, inconnu[2], divInconnu[2], inconnu[2])) { point(2); presence2=false; clearInterval(intervalDescente2); intervalDescente2 = null; }
		else if (px(document.getElementById("inconnu_2").style.top)<fenetre.y+45) {
			if (fini!==true) {
				document.getElementById("inconnu_2").style.top = px(document.getElementById("inconnu_2").style.top) + avancement + "px";
				inconnu[2].y = inconnu[2].y + avancement;
			}
		}
		else {
			clearInterval(intervalDescente2);
			intervalDescente2 = null;
			spawn[2].removeChild(document.getElementById("inconnu_2"));
			if (booleenDebug) { console.log("Clear inconnu : 2"); spawn[2].style.backgroundColor = "red"; }
			spawnNumber[2]=true;
			presence2=false;
			spawnTotal--;
		}
	}
	if (presence3) {
		if (hitBox(rudolf, inconnu[3], divInconnu[3], inconnu[3])) { point(3); presence3=false; clearInterval(intervalDescente3); intervalDescente3 = null; }
		else if (px(document.getElementById("inconnu_3").style.top)<fenetre.y+45) {
			if (fini!==true) {
				document.getElementById("inconnu_3").style.top = px(document.getElementById("inconnu_3").style.top) + avancement + "px";
				inconnu[3].y = inconnu[3].y + avancement;
			}
		}
		else {
			clearInterval(intervalDescente3);
			intervalDescente3 = null;
			spawn[3].removeChild(document.getElementById("inconnu_3"));
			if (booleenDebug) { console.log("Clear inconnu : 3"); spawn[3].style.backgroundColor = "red"; }
			spawnNumber[3]=true;
			presence3=false;
			spawnTotal--;
		}
	}
	if (presence4) {
		if (hitBox(rudolf, inconnu[4], divInconnu[4], inconnu[4])) { point(4); presence4=false; clearInterval(intervalDescente4); intervalDescente4 = null; }
		else if (px(document.getElementById("inconnu_4").style.top)<fenetre.y+45) {
			if (fini!==true) {
				document.getElementById("inconnu_4").style.top = px(document.getElementById("inconnu_4").style.top) + avancement + "px";
				inconnu[4].y = inconnu[4].y + avancement;
			}
		}
		else {
			clearInterval(intervalDescente4);
			intervalDescente4 = null;
			spawn[4].removeChild(document.getElementById("inconnu_4"));
			if (booleenDebug) { console.log("Clear inconnu : 4"); spawn[4].style.backgroundColor = "red"; }
			spawnNumber[4]=true;
			presence4=false;
			spawnTotal--;
		}
	}
	if (presence0!==true&&presence1!==true&&presence2!==true&&presence3!==true&&presence4!==true) {
		console.warn("Aucun inconnu !");
		console.warn(presence0+"\n"+presence1+"\n"+presence2+"\n"+presence3+"\n"+presence4);
		//erreur("Aucun inconnu !</br>ou</br>Chargment trop lent !</br>ou</br>Vitesse trop rapide !");	
	}
}

// Spawn (aléatoire) + spawn + lancement du scrolling
function inconnuInterval () {
	while (iSpawn<=4&&place!==true) {
		if (spawnNumber[iSpawn]) { place=true; }
		iSpawn++;
	}
	iSpawn=0;

	if (place) {
		inconnuRandom = Math.floor(Math.random() * 101) + 0;
		if (inconnuRandom<=50) {
			switch (saisons) {
			  case 1:
			  	inconnuResultat="Cadeau";
			  break;
			  case 2:
			  	inconnuResultat="Feuille";
			  break;
			  case 3:
			  	inconnuResultat="Orange";
			  break;
			  case 4:
			  	inconnuResultat="Pomme";
			  break;
			  default:
			    erreur("Out of seasons !")
			  break;
			}
		}
		else if (inconnuRandom>50&&inconnuRandom<75) {
			switch (saisons) {
			  case 1:
				inconnuResultat="Sucredorge";
			  break;
			  case 2:
			  	inconnuResultat="Fleur";
			  break;
			  case 3:
			  	inconnuResultat="Citron";
			  break;
			  case 4:
			  	inconnuResultat="Raisin";
			  break;
			  default:
			    erreur("Out of seasons !")
			  break;
			}
		}
		else if (inconnuRandom>=75) {
			switch (saisons) {
			  case 1:
				inconnuResultat="Eclair";
			  break;
			  case 2:
			  	inconnuResultat="Vent";
			  break;
			  case 3:
			  	inconnuResultat="Soleil";
			  break;
			  case 4:
			  	inconnuResultat="Pluie";
			  break;
			  default:
			    erreur("Out of seasons !")
			  break;
			}
		}
		else { erreur("Out of numbers !") }

		spawnTotal++;
		spawnRandom = Math.floor(Math.random() * 5) + 0;
		while (spawnNumber[spawnRandom]===false&&full<100) {
			spawnRandom = Math.floor(Math.random() * 5) + 0;
			full++;
			if (booleenDebug) { console.log("Test spawn n°"+spawnRandom+" pour "+full+"eme valeur(s)."); }
		}

		if (full>0&&spawnNumber[spawnRandom]===false) { spawnTotal--; preventError=true; console.error(full+"\n"+spawnNumber[spawnRandom]+"\n"+spawnRandom); erreur("Sécurité outrepassée !</br>ou</br>Malchance > 100"); }
		else {
			if (booleenDebug) { console.log("Spawn box : " + spawnRandom); spawn[spawnRandom].style.backgroundColor = "green"; }
			if (booleenCollision) { spawn[spawnRandom].insertAdjacentHTML("beforeEnd", '<img src="public/img/Rudolf/Sprites/'+inconnuResultat+'.png" class="collectible_debug" id="inconnu_'+spawnRandom+'" alt="'+inconnuResultat+'" style="position: absolute; margin: auto; height: 50px; width: 50px; background-color: black;">'); }
			else { spawn[spawnRandom].insertAdjacentHTML("beforeEnd", '<img src="public/img/Rudolf/Sprites/'+inconnuResultat+'.png" id="inconnu_'+spawnRandom+'" alt="'+inconnuResultat+'" style="position: absolute; margin: auto; height: 50px; width: 50px;">'); }
			inconnu[spawnRandom] = new Objet("inconnu_"+spawnRandom);
		}
		full=0;
	}
	else { preventError=true; }
	place=false;

	if (preventError) { if (booleenDebug) { console.log("Aucun spawn possible"); } preventError=false; }
	else if (spawnRandom===0&&spawnNumber[0]) {
		spawnNumber[0]=false;
		presence0 = true;
		intervalDescente0 = setInterval(descenteInterval, 150);
	}
	else if (spawnRandom===1&&spawnNumber[1]) {
		spawnNumber[1]=false;
		presence1 = true;
		intervalDescente1 = setInterval(descenteInterval, 150);
	}
	else if (spawnRandom===2&&spawnNumber[2]) {
		spawnNumber[2]=false;
		presence2 = true;
		intervalDescente2 = setInterval(descenteInterval, 150);
	}
	else if (spawnRandom===3&&spawnNumber[3]) {
		spawnNumber[3]=false;
		presence3 = true;
		intervalDescente3 = setInterval(descenteInterval, 150);
	}
	else if (spawnRandom===4&&spawnNumber[4]) {
		spawnNumber[4]=false;
		presence4 = true;
		intervalDescente4 = setInterval(descenteInterval, 150);
	}
	else {
		console.error(spawnRandom+"\n"+spawnNumber[0]+"\n"+spawnNumber[1]+"\n"+spawnNumber[2]+"\n"+spawnNumber[3]+"\n"+spawnNumber[4]);
		erreur("Aucun spawn possible !");
	}


	if (spawnTotal>5) {
		erreur("Éléments présents supérieurs à maximum !</br>(>5elmts)");
	}
}

// Mise en place des spawn box en fonction de la longueur de la fenêtre après chargement originel
function resizeFenetre () {
	fenetre = { y: window.innerHeight, x: window.innerWidth };
	for (var i = 0; i < 5; i++) {
		tmp = fenetre.x/6+(i*(fenetre.x/6));
		document.getElementById("spawn_"+i).style.left = tmp+"px";
	}
	divInconnu = [];
	for (var i = 0; i <= 4; i++) {
		divInconnu[i] = new Objet("spawn_"+i);
	}
	rudolf = Objet("rudolf");
	rudolf.y = fenetre.y-(rudolf.long+15);
	document.body.style.height=window.innerHeight+"px";
	return 0;
}

// Mise en place des spawn box en fonction de la longueur de la fenêtre
var fenetre = { y: window.innerHeight, x: window.innerWidth };
for (var i = 0; i < 5; i++) {
	var tmp = fenetre.x/6+(i*(fenetre.x/6));
	document.getElementById("inconnus").insertAdjacentHTML("beforeEnd", '<div id="spawn_'+i+'" class="spawn" style="left: '+tmp+'px; height: 50px; width: 50px; top: 0px;"></div>');
}

// Ajouts des qualicatifs (taille) aux spawns box
var spawnNumber = [], inconnu = [], divInconnu = [];
for (var i = 0; i <= 4; i++) {
	spawnNumber[i] = true;
	inconnu[i] = null;
	divInconnu[i] = new Objet("spawn_"+i);
}

// Déclarations variables principales
var body = document.body; // Safari
var html = document.documentElement; // Chrome, Firefox, IE and Opera places the overflow at the <html> level, unless else is specified. Therefore, we use the documentElement property for these browsers
var saisons=1;
var coeurs=3; eclairPause=false;
var booleenDebug=false, booleenCollision=false;
var fini=false;
var spwanLess = false, iSpawn = 0, place=false;
var scoringLimit = 0;
var avancement=2, spawnTime=1000, stuned=0; document.getElementById("px").textContent = avancement; document.getElementById("ms").textContent = spawnTime;
var inconnuRandom=0, inconnuResultat="";
var full=0, preventError=false;
var spawn = document.getElementsByClassName("spawn"), spawnTotal = 0; spawnRandom = 0, boxId=0;
var presence0, presence1, presence2, presence3, presence4;
var intervalDescente0, intervalDescente1, intervalDescente2, intervalDescente3, intervalDescente4;
var rudolf = new Objet("rudolf"); rudolf.y = fenetre.y-(rudolf.long+15);

document.body.style.height=window.innerHeight+"px";

// Lancement des intervalles
var intervalRudolf = null; intervalRudolf = setInterval(rudolfInterval, 500);
var intervalInconnu = null; intervalInconnu = setInterval(inconnuInterval, spawnTime);

setTimeout(function(){ document.getElementById("affiche").classList.remove("trueRudolf"); document.getElementById("affiche").classList.add("falseRudolf"); }, 3000);


// Contrôles clavier
var pauseBooleen=false;
document.addEventListener("keydown", function (e) {
	if (((e.key!==" "&&e.key!=="ArrowDown"&&e.key!=="ArrowUp")||fini)&&stuned) { if (booleenDebug) { console.log("Stuck"); } }
	else {
		switch (e.key.toUpperCase()) {
			case "Q":
			case "ARROWLEFT":
				if (pauseBooleen===true) { break; }
				if (rudolf.x>rudolf.larg/3*(-1)) {
					rudolf.x = rudolf.x - 25;
					document.getElementById("rudolf").style.left = rudolf.x + "px";
				}
				else {
					rudolf.x = fenetre.x-rudolf.larg/3;
					document.getElementById("rudolf").style.left = rudolf.x + "px";
				}
			break;
			case "D":
			case "ARROWRIGHT":
				if (pauseBooleen===true) { break; }
				if (rudolf.x<(fenetre.x)) {
					rudolf.x = rudolf.x + 25;
					document.getElementById("rudolf").style.left = rudolf.x + "px";
				}
				else {
					rudolf.x = 0-rudolf.larg/3;
					document.getElementById("rudolf").style.left = rudolf.x + "px";
				}
			break;
			case " ":
			case "ARROWDOWN":
			case "ARROWUP":
				if ((document.getElementById("vies").textContent)<=0) { break; }
				if (pauseBooleen) {
					intervalInconnu = setInterval(inconnuInterval, spawnTime);
					if (presence0===true) {
						intervalDescente0 = setInterval(descenteInterval, 150);
					}
					if (presence1===true) {
						intervalDescente1 = setInterval(descenteInterval, 200);
					}
					if (presence2===true) {
						intervalDescente2 = setInterval(descenteInterval, 250);
					}
					if (presence3===true) {
						intervalDescente3 = setInterval(descenteInterval, 300);
					}
					if (presence4===true) {
						intervalDescente4 = setInterval(descenteInterval, 350);
					}
					intervalRudolf = setInterval(rudolfInterval, 500);
					pauseBooleen=false;
					stuned--;
					if (eclairPause) { eclairInterval(); eclairPause=false; }
					document.getElementById("newsRudolf").removeChild(document.getElementById("pause"));
					if (sound===0) { document.getElementById("sound_audio").play(); }
				}
				else {
					clearInterval(intervalInconnu);
					intervalInconnu=null;
					clearInterval(intervalDescente0);
					intervalDescente0=null;
					clearInterval(intervalDescente1);
					intervalDescente1=null;
					clearInterval(intervalDescente2);
					intervalDescente2=null;
					clearInterval(intervalDescente3);
					intervalDescente3=null;
					clearInterval(intervalDescente4);
					intervalDescente4=null;
					clearInterval(intervalRudolf);
					intervalRudolf=null;
					clearInterval(intervalEclair);
					intervalRudolf=null;
					pauseBooleen=true;
					stuned++;
					if (eclair) { eclair=false; eclairPause=true; }
					document.getElementById("newsRudolf").insertAdjacentHTML("beforeEnd", '<h1 id="pause" style="z-index: 4; text-align: center; background-color: white; color: green; border: 5px solid green; margin: 10px; padding: 25px;" >Pause</h1>');
					if (sound===0) { document.getElementById("sound_audio").pause(); }
				}
			break;
			default:
				alert("Aller à gauche : Flèche gauche ou Q\nAller à droite : Flèche droite ou D\nMettre en pause : Espace ou Flèche haut ou Flèche bas");
			break;
		}
	}
});

// Interface (plusieurs morceaux) : |
//                                  |
//                                  V

//Interface, détails version
var version_img=false;
document.getElementById("version_img").addEventListener("click", function (e) {
	if (version_img) {
		document.getElementById("version").classList.remove("trueRudolf");
		document.getElementById("version").classList.add("falseRudolf");
		version_img=false;
	}
	else {
		document.getElementById("version").classList.remove("falseRudolf");
		document.getElementById("version").classList.add("trueRudolf");
		version_img=true;
	}
});

//Interface, son (3 états)
var sound=66;
document.getElementById("sound").addEventListener("click", function (e) {
	if (sound===66) {
		document.getElementById("sound_audio").play();
		sound=0;
	}
	else if (sound===0) {
		document.getElementById("aside_droite").removeChild(document.getElementById("sound_audio"));
		document.getElementById("sound").src = "public/img/Rudolf/sound_off.png";
		document.getElementById("sound").alt = "sound_off";
		sound++;
	}
	else if (sound===1) {
		document.getElementById("sound").src = "public/img/Rudolf/sound_off_off.png";
		document.getElementById("sound").alt = "sound_off_off";
		sound++;
	}
	else {
		document.getElementById("aside_droite").insertAdjacentHTML("beforeEnd", '<audio id="sound_audio" autoplay loop ><source src="public/sound/Free_Christmas_Music_8-Bit_Jingle_Bells.ogg" type="audio/ogg">Your browser does not support the audio tag.</audio>');
		document.getElementById("sound").src = "public/img/Rudolf/sound_on.png";
		document.getElementById("sound").alt = "sound_on";
		sound = 0;
		if (pauseBooleen===true) { document.getElementById("sound_audio").pause(); }
	}
});

//Interface, adaptation smartphone/PC
var plateforme=false; 
document.getElementById("plateforme").addEventListener("click", function (e) {
	resizeFenetre();
	if (plateforme!==true) {
		document.getElementById("plateforme").src = "public/img/Rudolf/computer.png";
		document.getElementById("plateforme").alt = "computer";
		document.getElementById("plateforme_haut").style.display="block";
		document.getElementById("plateforme_droite").style.display="block";
		document.getElementById("plateforme_gauche").style.display="block";
		plateforme=true;
	}
	else {
		document.getElementById("plateforme_haut").style.display="none";
		document.getElementById("plateforme_droite").style.display="none";
		document.getElementById("plateforme_gauche").style.display="none";
		document.getElementById("plateforme").src = "public/img/Rudolf/smartphone.png";
		document.getElementById("plateforme").alt = "smartphone";
		plateforme=false;
	}
});

document.getElementById("plateforme_haut").addEventListener("click", function (e) {
	if ((document.getElementById("vies").textContent)<=0) {  }
	else if (pauseBooleen) {
		intervalInconnu = setInterval(inconnuInterval, spawnTime);
		if (presence0===true) {
			intervalDescente0 = setInterval(descenteInterval, 150);
		}
		if (presence1===true) {
			intervalDescente1 = setInterval(descenteInterval, 200);
		}
		if (presence2===true) {
			intervalDescente2 = setInterval(descenteInterval, 250);
		}
		if (presence3===true) {
			intervalDescente3 = setInterval(descenteInterval, 300);
		}
		if (presence4===true) {
			intervalDescente4 = setInterval(descenteInterval, 350);
		}
		intervalRudolf = setInterval(rudolfInterval, 500);
		pauseBooleen=false;
		stuned--;
		document.getElementById("newsRudolf").removeChild(document.getElementById("pause"));
		document.getElementById("plateforme_haut").src="public/img/Rudolf/pause.png";
		if (sound===0) { document.getElementById("sound_audio").play(); }
	}
	else {
		clearInterval(intervalInconnu);
		intervalInconnu=null;
		clearInterval(intervalDescente0);
		intervalDescente0=null;
		clearInterval(intervalDescente1);
		intervalDescente1=null;
		clearInterval(intervalDescente2);
		intervalDescente2=null;
		clearInterval(intervalDescente3);
		intervalDescente3=null;
		clearInterval(intervalDescente4);
		intervalDescente4=null;
		clearInterval(intervalRudolf);
		intervalRudolf=null;
		clearInterval(intervalEclair);
		intervalRudolf=null;
		pauseBooleen=true;
		stuned++;
		document.getElementById("newsRudolf").insertAdjacentHTML("beforeEnd", '<h1 id="pause" style="z-index: 4; text-align: center; background-color: white; color: green; border: 5px solid green; margin: 10px; padding: 25px;" >Pause</h1>');
		document.getElementById("plateforme_haut").src="public/img/Rudolf/continue.png";
		if (sound===0) { document.getElementById("sound_audio").pause(); }
	}
});

document.getElementById("plateforme_droite").addEventListener("click", function (e) {
	if ((stuned&&String.fromCharCode(e.charCode)!==" ")||(fini)) { if (booleenDebug) { console.log("On bouge plus !"); } }
	else if (rudolf.x<(fenetre.x)) {
		rudolf.x = rudolf.x + 25;
		document.getElementById("rudolf").style.left = rudolf.x + "px";
	}
	else {
		rudolf.x = 0-rudolf.larg/3;
		document.getElementById("rudolf").style.left = rudolf.x + "px";
	}
});

document.getElementById("plateforme_gauche").addEventListener("click", function (e) {
	if ((stuned&&String.fromCharCode(e.charCode)!==" ")||(fini)) { if (booleenDebug) { console.log("On bouge plus !"); } }
	else if (rudolf.x>rudolf.larg/3*(-1)) {
		rudolf.x = rudolf.x - 25;
		document.getElementById("rudolf").style.left = rudolf.x + "px";
	}
	else {
		rudolf.x = fenetre.x-rudolf.larg/3;
		document.getElementById("rudolf").style.left = rudolf.x + "px";
	}
});

//Interface, recadrage indépandant
document.getElementById("resize").addEventListener("click", function (e) {
	resizeFenetre();
	document.getElementById("resize").textContent = "Largeur : "+fenetre.x+"px et Longueur : "+fenetre.y+"px";	
	document.getElementById("resize").style.color = "#77BC65";
	setTimeout(function(){
		document.getElementById("resize").textContent = "Recadrer";
		document.getElementById("resize").style.color = "orange";
	}, 3750);
});

//Interface, debug mode changment booleenDebug
document.getElementById("debug").addEventListener("click", function (e) {
	if (document.getElementById("debug").textContent==="OFF") {
		document.getElementById("debug").textContent = "ON";
		document.getElementById("debug").style.color = "green";
		booleenDebug = true;
	}
	else {
		document.getElementById("debug").textContent = "OFF";
		document.getElementById("debug").style.color = "red";
		for (var i = spawn.length - 1; i >= 0; i--) {
			spawn[i].style.backgroundColor = "rgba(0,0,0,0)";
		}
		booleenDebug = false;
	}
});
document.getElementById("collision1").addEventListener("click", function (e) {
	if (document.getElementById("collision1").textContent==="OFF") {
		document.getElementById("collision1").textContent = "ON";
		document.getElementById("collision1").style.color = "green";
		document.getElementById("rudolf").style.backgroundColor="white";
		booleenCollision = true;
	}
	else {
		document.getElementById("collision1").textContent = "OFF";
		document.getElementById("collision1").style.color = "red";
		for (var i = document.getElementsByClassName("collectible_debug").length - 1; i >= 0; i--) {
			document.getElementsByClassName("collectible_debug")[i].style.backgroundColor = "rgba(0,0,0,0)";
		}
		document.getElementById("rudolf").style.backgroundColor="rgba(0,0,0,0)";
		booleenCollision = false;
	}
});

//Interface, affichage informations complementaires
document.getElementById("show").addEventListener("click", function (e) {
	if (document.getElementById("show_img").alt==="+") {
		//document.getElementById("show_txt").textContent = "Moins";
		document.getElementById("show_img").alt = "-";
		document.getElementById("show_img").src = "public/img/Rudolf/moins.png";
		document.getElementById("informationsComplementaires").style.display = "block";
	}
	else {
		//document.getElementById("show_txt").textContent = "Plus";
		document.getElementById("show_img").alt = "+";
		document.getElementById("show_img").src = "public/img/Rudolf/plus.png";
		document.getElementById("informationsComplementaires").style.display = "none";
	}
});