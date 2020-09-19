function translation() {
	var longueurFenetre = window.innerHeight; var largeurFenetre = window.innerWidth;
	document.querySelector("header#Boot img#Haut").style.right = largeurFenetre/2 - largueurHaut/2 + "px";
	document.querySelector("header#Boot img#Bas").style.right = largeurFenetre/2 - largueurBas/2 + "px";

	var heightHaut = longueurFenetre/2 - longueurHaut/2;
	var heightBas = longueurFenetre/2 - longueurBas/2;

	var moyenne = heightHaut + heightBas;
	moyenne = moyenne/2;

	if (positionHaut <= heightHaut || positionBas <= heightBas) {
		if (positionHaut <= heightHaut) {
			positionHaut = positionHaut + i;
			document.querySelector("header#Boot img#Haut").style.top = positionHaut + "px";
			if (positionHaut >= moyenne) {i = 1;}
		}
		if (positionBas <= heightBas) {
			positionBas = positionBas + i;
			document.querySelector("header#Boot img#Bas").style.bottom = positionBas + "px";
			if (positionBas >= moyenne) {i = 1;}
		}
	}
	else {
		clearInterval(intervalId);
		setTimeout(function(){
			document.querySelector("body").style.overflow = "auto";
			document.querySelector("header#Boot").style.display = "none";
			document.querySelector("div#bloc_page").style.display = "block";
		}, 250);
	}
}

var i = 10;
var positionHaut = 0 - document.querySelector("header#Boot img#Haut").height;
var positionBas = 0 - document.querySelector("header#Boot img#Bas").height;

var longueurHaut = document.querySelector("header#Boot img#Haut").height;
var largueurHaut = document.querySelector("header#Boot img#Haut").width;

var longueurBas = document.querySelector("header#Boot img#Bas").height;
var largueurBas = document.querySelector("header#Boot img#Bas").width;

document.querySelector("body").style.overflow = "hidden";
var intervalId = setInterval(translation, 1);