const fs = require("fs"),
homedir = require("os").homedir(),
{ ipcRenderer, shell } = require("electron");

function perAppAction(appName) {
  switch (appName) {

    default:
      ipcRenderer.send("info-log", "No perAppAction declared for "+appName);
      return false;
    break;
  }
  ipcRenderer.send("info-log", "Specific action for "+appName+" executed");
  return true;
}

for ( const element of fs.readdirSync(__dirname+"/public/json/")) {
  if(JSON.parse(fs.readFileSync(__dirname+"/public/json/"+element), "utf8").spaceName!=undefined) {
    var appName=JSON.parse(fs.readFileSync(__dirname+"/public/json/"+element)).name;
  }
}

const dataDir = homedir+"/.DawnowlApps/"+appName+"/",
URL = "https://dawnowl444.000webhostapp.com/API/AJAX.php",
//URL = "http://localhost/Projet_Site/API/AJAX.php",
API = URL+"?API=1&request=",
localVersion = require(__dirname+"/public/json/"+appName+".json");
//const { perAppAction } = require("./perAppAction.js");

function updateAvaible(version, changeLogs) {
  let updateNotification = new Notification("Nouvelle version de "+version+" disponible", {
    body: "Détails : "+changeLogs,
    icon: __dirname+"/public/img/update.png"
  });
  updateNotification.onclick = () => {
    shell.openExternal(URL+"?manualDownload=true");
  };
}

fs.mkdirSync(dataDir, { recursive: true });

fs.readFile(dataDir+appName+".json", "utf8", (err, jsonString) => {
  if (err) {
    fs.copyFile(__dirname+"/public/json/"+appName+".json", dataDir+appName+".json", (err) => {
      if (err) ipcRenderer.send("error-dialog", "copyFile config.json error n°1 in self updater : \n"+err);
      else ipcRenderer.send("info-log", "First use → "+appName+".json written");
      //perAppAction(appName);
    });
  }
  else {
    let installed=JSON.parse(jsonString), isUpgrade=null;
    isUpgrade = localVersion.version>installed.version ? true : false;

    if (isUpgrade) {
      fs.copyFile(__dirname+"/public/json/"+appName+".json", dataDir+appName+".json", (err) => {
        if (err) ipcRenderer.send("error-dialog", "copyFile config.json error n°2 in self updater : \n"+err);
        else ipcRenderer.send("info-log", "First use → "+appName+".json written");
        //perAppAction(appName);
      });
      ipcRenderer.send("info-log", localVersion.name+" fully upgraded to "+localVersion.version);
    }
    else ipcRenderer.send("info-log", "Vous possedez "+installed.name+" version "+installed.version);
  }
});

let xhr = new XMLHttpRequest();
xhr.timeout = 5000;
xhr.open("GET", API+appName);
xhr.addEventListener("readystatechange", function() {
    if (xhr.readyState === XMLHttpRequest.DONE && (xhr.status === 200)) {
      let request = JSON.parse(xhr.responseText);
      if (request.version>localVersion.version) updateAvaible(request.name, request.changeLogs);
      else ipcRenderer.send("info-log", "Vous possédez la dernière version de "+request.name+".");
    }
    else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200) {
      let errorNotification = new Notification("Erreur : "+xhr.status, {
        body: "Recherche de mise à jours impossible : "+xhr.statusText,
        icon: __dirname+"/public/img/errorServer.png"
      });
    }
});
xhr.send(null);