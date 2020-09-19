const homedir = require("os").homedir(),
platform = require("os").platform();

const API = "https://dawnowl444.000webhostapp.com/API/AJAX.php?API=1&request=",
//const API = "http://localhost/Projet_Site/API/AJAX.php?API=1&request=",
originalLocalConfig = require("./public/json/config.json"),
programDir = homedir+"/.DawnowlApps/",
dataDir = homedir+"/.DawnowlApps/Dawnowl_Updater/",
localVersion = require("./public/json/Dawnowl_Updater.json");


function toBase64 (xhrResponse) {
    //nécessite : xhr.responseType = "arraybuffer";
    let arrayBuffer = xhrResponse;
    let binaryString = "";
    let byteArray = new Uint8Array(arrayBuffer);
    for (let i = 0; i < byteArray.byteLength; i++) {
        binaryString += String.fromCharCode( byteArray[i] ); //extracting the bytes
    }
    return window.btoa(binaryString); //creating base64 string
}

function contenuChiffreDansNombre (where, number) {
    let division=10**where;
    let entier=10**(where-1);
    let data = number%division;
    data = data/entier;

    return Math.trunc(data);
}

function isOnline() {
    const alertOnlineStatus = () => {
        window.alert(navigator.onLine ? 'online' : 'offline');
    };

    window.addEventListener('online',  alertOnlineStatus);
    window.addEventListener('offline',  alertOnlineStatus);

    alertOnlineStatus();
}


function errorNotification (msg, http) {
    let errorIcon="";
    if (http==503) {
        errorIcon="public/img/maintenanceServer.png";
        msg+="\nLe serveur distant est en maintenance."
    }
    else {
    	switch(contenuChiffreDansNombre(3, http)) {
    		case 0:
    			errorIcon="public/img/warnInternet.png"; 
                msg+="L'accès stable à Internet est compromis."
    		break;
            case 4:
                errorIcon="public/img/errorApp.png";
                msg+="\nVotre version n'arrive pas à communiquer avec le serveur."
            break;
    		case 5:
    			errorIcon="public/img/errorServer.png";
                msg+="\nLe serveur distant rencontre des problèmes internes."
    		break;
    		default:
    			errorIcon="public/img/errorServer.png";
    		break;
    	}
    }

	let notification = {
    	title: "Dawnowl_Updater : Erreur "+http,
    	body: msg,
    	icon: errorIcon
    };
    new window.Notification(notification.title, notification);
    //alert('Une erreur est survenue durant un téléchargement !\n\nErreur : ' + xhr.status + '\nDescription : ' + xhr.statusText);
}


module.exports = { homedir, platform, API, originalLocalConfig, localVersion, programDir, dataDir, errorNotification };