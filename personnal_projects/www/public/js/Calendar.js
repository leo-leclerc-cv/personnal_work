var date = new Date();
var day = date.getDate();
var month = date.getMonth()+1; //January is 0!

/*month = 10;
day = 31;*/


if ((day>20 && month===12) || (day<=28 && month===12)) {
	document.getElementById("Bas").src = "public/img/Calendar/Xmas.png";
	document.getElementById("Bas").height = "282";
	document.getElementById("Bas").width = "200";
}
else if ((day>28 && month===12) || (day<5 && month===1)) {
	document.getElementById("Bas").src = "public/img/Calendar/New_Year.png";
	document.getElementById("Bas").height = "200";
	document.getElementById("Bas").width = "200";
}
else if ((day>28 && month===3) || (day<5 && month===4)) {
	document.getElementById("Bas").src = "public/img/Calendar/Fish.png";
	document.getElementById("Bas").height = "100";
	document.getElementById("Bas").width = "200";
}
else if ((day>25 && month===10) || (day<3 && month===11)) {
	document.getElementById("Bas").src = "public/img/Calendar/Pumpkin.png";
	document.getElementById("Bas").height = "200";
	document.getElementById("Bas").width = "190";
}
else {
}