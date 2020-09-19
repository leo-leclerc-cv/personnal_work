var messageWarning = {
	id: document.getElementById("text").textContent,
	text: "Notre site web à rencontré une erreur. Nous sommes désolés pour la gêne occasionnée et nous vous suggérons fortement de signaler l'erreur.",
},
messageError = {
	id: document.getElementById("text").textContent,
	text: "Ce message d'erreur pourra peut être vous aider : "
};

function display(messageHolder, messageId) {
	var i=-1;
	var intervalI = setInterval(function(){ i++; }, 35);
	var intervalDisplay = setInterval(function(){
		if (String(messageHolder[i])!="undefined") {
		document.getElementById(messageId).textContent += messageHolder[i];
		}
		}, 35);
}

display(messageWarning.text, "text");
setTimeout(function(){ display(messageError.text, "error_text"); }, messageWarning.text.length*35);
setTimeout(function(){ document.getElementById("error_php").style.display="block"; }, (messageError.text.length+messageWarning.text.length)*35);
setTimeout(function(){ document.getElementById("text").innerHTML = '<a href="../index.php?action=disconnect">Retourner à l\'accueil du site</a><p>Si les erreurs persistent essayez de supprimer vos cookies.</p>'; }, (messageError.text.length+messageWarning.text.length)*50);

setTimeout(function(){ clearInterval(intervalDisplay); clearInterval(intervalI); }, (messageError.text.length+messageWarning.text.length)*90);