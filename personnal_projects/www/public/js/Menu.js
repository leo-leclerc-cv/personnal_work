var date = new Date();
var day = date.getDate();
var month = date.getMonth()+1; //January is 0!

month = 1;
day = 22; 

if (month===1 && day===22) {
	document.getElementById("start").style.display = "block";
	document.getElementById("Boot").style.display = "none";
	document.getElementById("bloc_page").style.display = "none";
	setTimeout(function(){document.getElementById("start").insertAdjacentHTML("beforeEnd", 'Loading');}, 250);
	setTimeout(function(){document.getElementById("start").insertAdjacentHTML("beforeEnd", ' .');}, 500);
	setTimeout(function(){document.getElementById("start").insertAdjacentHTML("beforeEnd", '.');}, 750);
	setTimeout(function(){document.getElementById("start").insertAdjacentHTML("beforeEnd", '.');}, 1000);

	setTimeout(function(){document.getElementById("start").insertAdjacentHTML("afterEnd", '<h1 id="right">Ben88250_Corp all right reserved !</h1>');}, 1250);
	setTimeout(function(){document.getElementById("right").insertAdjacentHTML("afterEnd", '<div id="div_logo"><img id="logo" src="../Images/Logo_pixel.bmp"></div>');}, 1500);

	setTimeout(function(){document.getElementById("div_logo").insertAdjacentHTML("afterEnd", '<p id="language">Check language :</p>');}, 1750);
	setTimeout(function(){document.getElementById("language").insertAdjacentHTML("beforeEnd", '<span class="test">HTML </span>');}, 2000);
	setTimeout(function(){document.getElementById("language").insertAdjacentHTML("beforeEnd", '<span class="test"> CSS</span>');}, 2250);
	setTimeout(function(){document.getElementById("language").insertAdjacentHTML("beforeEnd", '<span class="test"> JS</span>');}, 2500);
	setTimeout(function(){document.getElementById("language").insertAdjacentHTML("beforeEnd", ' : ');}, 2500);
	setTimeout(function(){document.getElementById("language").insertAdjacentHTML("beforeEnd", '<span class="ok">OK</span>');}, 2750);

	setTimeout(function(){document.getElementById("language").insertAdjacentHTML("afterEnd", '<p id="syntax">Check syntax :</p>');}, 3000);
	setTimeout(function(){document.getElementById("syntax").insertAdjacentHTML("beforeEnd", '<span class="test"> camelCase</span>');}, 3250);
	setTimeout(function(){document.getElementById("syntax").insertAdjacentHTML("beforeEnd", '<span class="test"> syntax_perso</span>');}, 3500);
	setTimeout(function(){document.getElementById("syntax").insertAdjacentHTML("beforeEnd", ' : ');}, 3500);
	setTimeout(function(){document.getElementById("syntax").insertAdjacentHTML("beforeEnd", '<span class="ok">OK</span>');}, 3750);

	setTimeout(function(){document.getElementById("syntax").insertAdjacentHTML("afterEnd", '<p id="files">Check files :</p>');}, 4000);
	setTimeout(function(){document.getElementById("files").insertAdjacentHTML("beforeEnd", '<span class="test"> images</span>');}, 4250);
	setTimeout(function(){document.getElementById("files").insertAdjacentHTML("beforeEnd", '<span class="test"> texts</span>');}, 4500);
	setTimeout(function(){document.getElementById("files").insertAdjacentHTML("beforeEnd", ' : ');}, 4500);
	setTimeout(function(){document.getElementById("files").insertAdjacentHTML("beforeEnd", '<span class="ok">OK</span>');}, 4750);

	setTimeout(function(){document.getElementById("files").insertAdjacentHTML("afterEnd", '<p id="version">Check version :</p>');}, 5000);
	setTimeout(function(){document.getElementById("version").insertAdjacentHTML("beforeEnd", '<span class="test"> none</span>');}, 5250);
	setTimeout(function(){document.getElementById("version").insertAdjacentHTML("beforeEnd", ' : ');}, 5250);
	setTimeout(function(){document.getElementById("version").insertAdjacentHTML("beforeEnd", '<span class="fail">FAIL</span>');}, 5500);

	setTimeout(function(){document.getElementById("version").insertAdjacentHTML("afterEnd", '<p id="encoding">Check encoding :</p>');}, 5750);
	setTimeout(function(){document.getElementById("encoding").insertAdjacentHTML("beforeEnd", '<span class="corrupt"> darker</span>');}, 6000);
	setTimeout(function(){document.getElementById("encoding").insertAdjacentHTML("beforeEnd", '<span class="corrupt"> yet darker</span>');}, 6250);
	setTimeout(function(){document.getElementById("encoding").insertAdjacentHTML("beforeEnd", ' : ');}, 6250);
	setTimeout(function(){document.getElementById("encoding").insertAdjacentHTML("beforeEnd", '<span class="fail">FAIL</span>');}, 6500);

	setTimeout(function(){document.getElementById("encoding").insertAdjacentHTML("afterEnd", '<p id="stability">Check stability :</p>');}, 6750);
	setTimeout(function(){document.getElementById("stability").insertAdjacentHTML("beforeEnd", '<span class="corrupt"> cake</span>');}, 7000);
	setTimeout(function(){document.getElementById("stability").insertAdjacentHTML("beforeEnd", '<span class="corrupt"> is</span>');}, 7250);
	setTimeout(function(){document.getElementById("stability").insertAdjacentHTML("beforeEnd", '<span class="corrupt"> lie</span>');}, 7500);
	setTimeout(function(){document.getElementById("stability").insertAdjacentHTML("beforeEnd", ' : ');}, 7500);
	setTimeout(function(){document.getElementById("stability").insertAdjacentHTML("beforeEnd", '<span class="fail">FAIL</span>');}, 7750);
	setTimeout(function(){document.getElementById("logo").src = "../Images/Logo_pixel_corrupt.bmp";}, 7750);

	setTimeout(function(){document.getElementById("stability").insertAdjacentHTML("afterEnd", '<p id="script">Check script :</p>');}, 8000);
	setTimeout(function(){document.getElementById("script").insertAdjacentHTML("beforeEnd", '<span class="corrupt"> here</span>');}, 8250);
	setTimeout(function(){document.getElementById("script").insertAdjacentHTML("beforeEnd", '<span class="corrupt"> we</span>');}, 8500);
	setTimeout(function(){document.getElementById("script").insertAdjacentHTML("beforeEnd", '<span class="corrupt"> are</span>');}, 8750);
	setTimeout(function(){document.getElementById("script").insertAdjacentHTML("beforeEnd", ' : ');}, 8750);
	setTimeout(function(){document.getElementById("script").insertAdjacentHTML("beforeEnd", '<span class="fail">FAIL</span>');}, 9000);

	setTimeout(function(){document.getElementById("script").insertAdjacentHTML("afterEnd", '<p id="check_recovery">Check recovery :</p>');}, 9250);
	setTimeout(function(){document.getElementById("check_recovery").insertAdjacentHTML("beforeEnd", '<span class="test"> READY</span>');}, 9500);
	setTimeout(function(){document.getElementById("check_recovery").insertAdjacentHTML("beforeEnd", ' : ');}, 9500);
	setTimeout(function(){document.getElementById("check_recovery").insertAdjacentHTML("beforeEnd", '<span class="ok">OK</span>');}, 9750);


	setTimeout(function(){document.getElementById("check_recovery").insertAdjacentHTML("afterEnd", '<h2 id="entering">Entering recovery</h2>');}, 10000);
	setTimeout(function(){document.getElementById("entering").insertAdjacentHTML("beforeEnd", ' .');}, 10250);
	setTimeout(function(){document.getElementById("entering").insertAdjacentHTML("beforeEnd", '.');}, 10500);
	setTimeout(function(){document.getElementById("entering").insertAdjacentHTML("beforeEnd", '.');}, 10750);
	setTimeout(function(){document.getElementById("entering").insertAdjacentHTML("beforeEnd", '</br><span class="ok">OK</span>');}, 11000);

	setTimeout(function(){
	document.getElementById("entering").insertAdjacentHTML("afterEnd", '<h1 id="recovery">Welcome in the recovery, press F to fix the errors.</h1>')
	document.addEventListener("keypress", function (e) {
			if (String.fromCharCode(e.charCode)==="F" || String.fromCharCode(e.charCode)==="f") {
				setTimeout(function(){document.getElementById("recovery").insertAdjacentHTML("beforeEnd", '<p id="fixing">Fixing</p>');}, 250);
				setTimeout(function(){document.getElementById("fixing").insertAdjacentHTML("beforeEnd", ' .');}, 500);
				setTimeout(function(){document.getElementById("fixing").insertAdjacentHTML("beforeEnd", '.');}, 750);
				setTimeout(function(){document.getElementById("fixing").insertAdjacentHTML("beforeEnd", '.');}, 1000);
				setTimeout(function(){document.getElementById("logo").src = "../Images/Logo_pixel.bmp";}, 1250);
				setTimeout(function(){document.getElementById("fixing").insertAdjacentHTML("beforeEnd", '</br><span class="ok">OK</span>');}, 1500);

				setTimeout(function(){document.getElementById("recovery").insertAdjacentHTML("beforeEnd", '<p id="exiting">Exiting</p>');}, 1750);
				setTimeout(function(){document.getElementById("exiting").insertAdjacentHTML("beforeEnd", ' .');}, 2000);
				setTimeout(function(){document.getElementById("exiting").insertAdjacentHTML("beforeEnd", '.');}, 2250);
				setTimeout(function(){document.getElementById("exiting").insertAdjacentHTML("beforeEnd", '.');}, 2500);

				setTimeout(function(){document.getElementById("recovery").insertAdjacentHTML("afterEnd", '<p id="fix">Check fixes :</p>');}, 2750);
				setTimeout(function(){document.getElementById("fix").insertAdjacentHTML("beforeEnd", '<span class="test"> WORKING</span>');}, 3000);
				setTimeout(function(){document.getElementById("fix").insertAdjacentHTML("beforeEnd", ' : ');}, 3000);
				setTimeout(function(){document.getElementById("fix").insertAdjacentHTML("beforeEnd", '<span class="ok">OK</span>');}, 3250);

				setTimeout(function(){document.getElementById("fix").insertAdjacentHTML("afterEnd", '<p id="resuming">Resuming boot </p>');}, 3500);
				setTimeout(function(){document.getElementById("resuming").insertAdjacentHTML("beforeEnd", ' .');}, 3750);
				setTimeout(function(){document.getElementById("resuming").insertAdjacentHTML("beforeEnd", '.');}, 4000);
				setTimeout(function(){document.getElementById("resuming").insertAdjacentHTML("beforeEnd", '.');}, 4250);

				setTimeout(function(){document.getElementById("resuming").insertAdjacentHTML("afterEnd", '<p id="launching">Launching kernel :</p>');}, 4500);
				setTimeout(function(){document.getElementById("launching").insertAdjacentHTML("beforeEnd", '<span class="test"> PASS</span>');}, 4750);
				setTimeout(function(){document.getElementById("launching").insertAdjacentHTML("beforeEnd", ' : ');}, 5000);
				setTimeout(function(){document.getElementById("launching").insertAdjacentHTML("beforeEnd", '<span class="ok">OK</span>');}, 5250);

				setTimeout(function(){document.getElementById("bloc_page").style.display = "block";}, 5500);
			}
			else {}
		});
	}, 11250);
}
else {
	if ((day>20 && month===12) || (day<=28 && month===12)) {
		document.getElementById("Haut").src = "../Images/Xmas.png";
		document.getElementById("Haut").height = "300";
		document.getElementById("Haut").width = "213";
	}
	else if ((day>28 && month===12) || (day<5 && month===1)) {
		document.getElementById("Haut").src = "../Images/New_Year.png";
		document.getElementById("Haut").height = "300";
		document.getElementById("Haut").width = "300";
	}
	else if ((day>28 && month===3) || (day<5 && month===4)) {
		document.getElementById("Haut").src = "../Images/Fish.png";
		document.getElementById("Haut").height = "150";
		document.getElementById("Haut").width = "300";
	}
	else if ((day=25 && month===10) || (day<3 && month===11)) {
		document.getElementById("Haut").src = "../Images/Pumpkin.png";
		document.getElementById("Haut").height = "278";
		document.getElementById("Haut").width = "264";
	}
	else {
		document.getElementById("Haut").height = "300";
		document.getElementById("Haut").width = "310";
	}
}