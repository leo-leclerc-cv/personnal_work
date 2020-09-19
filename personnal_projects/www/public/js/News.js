var news = document.getElementById("news");

if (news==null) {
	console.log("Authentification en attente...");
}
else {
	news.style.opacity = 1;
	var interval = setInterval(function(){ news.style.opacity = news.style.opacity - 0.05; }, 125);

	setTimeout(function(){ clearInterval(interval); news.style.display = "none";}, 21*125);
}