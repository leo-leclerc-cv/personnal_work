//Ce script est vieux et ne sera sans doute pas retapé ou optimisé

var date = new Date();
var hours = date.getHours();
var body = document.body; // Safari
var html = document.documentElement; // Chrome, Firefox, IE and Opera places the overflow at the <html> level, unless else is specified. Therefore, we use the documentElement property for these browsers

var mode = "", verbose=true;

function idComplexeNom (id) {
	var nom="";
	for (var i = 0; i !== id.length; i++) {
		if (String(Number(id[i]))==="NaN") {
			nom=nom+id[i];
		}
	}
	return nom;
}

function idComplexeNombre (id) {
	var nombre="";
	for (var i = 0; i !== id.length; i++) {
		if (String(Number(id[i]))!=="NaN") {
			nombre=nombre+id[i];
		}
	}
	var dossier="";
	for (var i = nombre - 1; i >= 0; i--) {
		dossier=dossier+"../";
	}
	return dossier;
}

// Sauvegarde des attributs initiaux
var bodyBackgroundImage = body.style.backgroundImage;
var htmlBackgroundImage = html.style.backgroundImage;
var bodyBackgroundColor = body.style.backgroundColor;
var htmlBackgroundColor = html.style.backgroundColor;
var bodyColor = body.style.color;
var htmlColor = html.style.color;
var aElmt = document.getElementsByTagName("a");

function changement (etat) {
	if (etat==="night") {
		body.style.backgroundImage = "none";
		html.style.backgroundImage = "none";
		body.style.backgroundColor = "rgb(45, 45, 45)";
		html.style.backgroundColor = "rgb(45, 45, 45)";
		body.style.color = "grey";
		html.style.color = "grey";
		for (var i = aElmt.length - 1; i >= 0; i--) {
			aElmt[i].style.color = "grey";
		}
		// --> Modifications avancés NUIT
		switch (idComplexeNom(html.id)) {			
			case "Rudolf":
				body.style.backgroundImage = bodyBackgroundImage;
				html.style.backgroundImage = htmlBackgroundImage;
				body.style.backgroundColor = bodyBackgroundColor;
				html.style.backgroundColor = htmlBackgroundColor;
			break;
			default:break;
		}
		if (verbose) { console.log("%cMode nuit/jour : " + "%cNuit !", "color:grey;", "color:blue;"); }
	}
	else if (etat==="day") {
		body.style.backgroundImage = bodyBackgroundImage;
		html.style.backgroundImage = htmlBackgroundImage;
		body.style.backgroundColor = bodyBackgroundColor;
		html.style.backgroundColor = htmlBackgroundColor;
		body.style.color = bodyColor;
		html.style.color = htmlColor;
		for (var i = aElmt.length - 1; i >= 0; i--) {
			aElmt[i].style.color = bodyColor;
		}
		// --> Modifications avancés JOUR
		switch (idComplexeNom(html.id)) {
			case "N/A":
				
			break;
			default:break;
		}
		if (verbose) { console.log("%cMode nuit/jour : " + "%cJour !", "color:grey;", "color:yellow;"); }
	}
}

// Entre 18h-6h --> jour
if (hours >= 18 || hours <=6) {
	mode="night";
	changement(mode);
	body.insertAdjacentHTML("afterBegin", '<img style="height:50px; width:50px; position:absolute; top:10px; left:10px; z-index:1;" id="mode_nuit" class="night" alt="mode_nuit" src="'+idComplexeNombre(html.id)+'public/img/night.png"/>');
	console.log("%cMode nuit/jour : " + "%cNuit !", "color:grey;", "color:blue;");
}
else {
	body.insertAdjacentHTML("afterBegin", '<img style="height:50px; width:50px; position:absolute; top:10px; left:10px; z-index:1;" id="mode_nuit" class="day" alt="mode_nuit" src="'+idComplexeNombre(html.id)+'public/img/day.png"/>');
	console.log("%cMode nuit/jour : " + "%cJour !", "color:grey;", "color:yellow;");
}

// Modifications placement de l'icône
switch (idComplexeNom(html.id)) {
	case "Rudolf":
		document.getElementById("mode_nuit").style.left = "";
		document.getElementById("mode_nuit").style.top = "15px";
		document.getElementById("mode_nuit").style.right = "100px";
		if (verbose) { console.log("%cMode nuit/jour : " + "%cRudolf", "color:grey;", "color:green;"); }
	break;
	case "":
		if (verbose) { console.log("%cMode nuit/jour : " + "%cDéfaut", "color:grey;", "color:green;"); }
	break;
	default:
		if (verbose) { console.log("%cMode nuit/jour : " + "%cNom de l'ID complexe erroné !", "color:grey;", "color:red;"); }
	break;
}

// Interface
document.getElementById("mode_nuit").addEventListener("mouseover", function (e) {
	if (e.target.className==="night") {e.target.src=idComplexeNombre(html.id)+"public/img/day.png";}
	else {e.target.src=idComplexeNombre(html.id)+"public/img/night.png";}
});

document.getElementById("mode_nuit").addEventListener("mouseout", function (e) {
	if (e.target.className==="night") { e.target.src=idComplexeNombre(html.id)+"public/img/night.png"; }
	else { e.target.src=idComplexeNombre(html.id)+"public/img/day.png"; }
});

document.getElementById("mode_nuit").addEventListener("click", function (e) {
	if (e.target.className==="night") {
		mode="day";
		e.target.classList.remove("night");
		e.target.classList.add("day");
		e.target.src=idComplexeNombre(html.id)+"public/img/day.png";
		changement(mode);
	}
	else {
		mode="night";
		e.target.classList.remove("day");
		e.target.classList.add("night");
		e.target.src=idComplexeNombre(html.id)+"public/img/night.png";
		changement(mode);
	}
});