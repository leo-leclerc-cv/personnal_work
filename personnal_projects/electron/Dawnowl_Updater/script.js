let cancel=null;
const { shell, ipcRenderer }=require("electron"),
fs = require("fs");

const { API, homedir, platform, dataDir, programDir, contenuChiffreDansNombre, errorNotification } = require("./libraries.js");
var howManyErrorNotif=0;

ipcRenderer.on("saved-file", (event, result, file, base64String) => {
    document.querySelector("div#"+file+" img.cancel").style.display="none";
    document.querySelector("div#"+file+" img.clear").style.display="block";
    document.querySelector("div#"+file+" div.afterLoad").style.display="flex";

    if (!result.canceled) {

        let withSlashPath="";
        if (platform=="win32") {
            for (let i = 0; i < result.filePath.length; i++) {
                if (result.filePath[i]=="\\") {
                    withSlashPath+="\\\\";
                }
                else {
                    withSlashPath+=result.filePath[i];
                }
            }
        }
        else withSlashPath=result.filePath;

        fs.writeFileSync(result.filePath, base64String, "base64");

        document.querySelector("div#"+file+" div.afterLoad img.folder").setAttribute("onclick", "shell.showItemInFolder('"+withSlashPath+"');");
        document.querySelector("div#"+file+" div.afterLoad img.execute").setAttribute("onclick", "shell.openItem('"+withSlashPath+"');");
        //withSlashPath required
    }
    else document.querySelector("div#"+file+" img.clear").click();

    document.getElementById("background").style.display="none";
    document.querySelector("body").style.overflowY="auto";
    document.getElementById("decrypt").style.display="none";
    //hide loading screen
});

window.onbeforeunload=function(){
    ipcRenderer.send("closing-mainGraphicInterface");
}

function antiSpamErrorNotif(msg, http) {
    if (howManyErrorNotif==0) {
        howManyErrorNotif++;
        errorNotification(msg, http);
    }
    else {
        ipcRenderer.send("warn-log", "Dawnowl_Updater : Erreur "+http+"\n"+msg);
    }
}

function updateAvaible (request) {
    document.querySelector("div#"+request.name+" div.changeLogs div.antiTranslation span.changeLogsPresentation").textContent="Détails de la dernière version : ";
    document.querySelector("div#"+request.name+" div.changeLogs div.antiTranslation span.changeLogsReceive").textContent=request.changeLogs;
    document.querySelector("div#"+request.name+" div.changeLogs").style.backgroundColor="#00ccff";
    
    setTimeout(function(){ document.querySelector("div#"+request.name+" img.update").style.display="block"; },3050);
    setTimeout(function(){ document.querySelector("div#"+request.name+" img.reload").style.display="none"; },3050);
}


function verifyVersion(file ,id) {
    if (document.getElementById("reload"+id).style.animationName!="turnAround") {

        let online=API+file;
        document.getElementById("reload"+id).style.animationName="turnAround";
        var xhr = new XMLHttpRequest();
        xhr.timeout = 3000;
        xhr.open("GET", online);
        xhr.addEventListener("readystatechange", function() {
            if (xhr.readyState === XMLHttpRequest.DONE && (xhr.status === 200)) {
                var request = JSON.parse(xhr.responseText);
                document.querySelector("div#"+request.name+" div.versionComparaison span.onlineVersion span.onlineVersionPrecise").textContent=request.version;
                document.querySelector("div#"+request.name+" img.icon").title=request.description;
                document.querySelector("div#"+request.name+" span.title").title=request.description;
                //document.querySelector("div.container#"+request.name).title=request.description;

                try {
                    let local=JSON.parse(fs.readFileSync(programDir+request.name+"/"+request.name+".json", "utf8"));
                    document.querySelector("div#"+file+" div.versionComparaison span.userVersion span.userVersionPrecise").textContent=local.version;

                    if (request.version>local.version) {
                        updateAvaible(request);
                        document.querySelector("div#"+file+" div.versionComparaison").style.backgroundColor="#ff3300";
                    }
                    else{
                        document.querySelector("div#"+request.name+" div.changeLogs div.antiTranslation span.changeLogsPresentation").textContent="Vous possédez la dernière version disponible.";
                        document.querySelector("div#"+request.name+" div.changeLogs div.antiTranslation span.changeLogsReceive").textContent="";
                        document.querySelector("div#"+file+" div.versionComparaison").style.backgroundColor="#33cc33";
                    }
                }
                catch (error) {
                    document.querySelector("div#"+file+" div.versionComparaison span.userVersion").textContent="Aucune version installée.";
                    document.querySelector("div#"+file+" div.versionComparaison").style.backgroundColor="#ff9933";
                    updateAvaible(request);
                    return console.log("%cFile read failed:", "color:#FF9933;", error);
                }
            }
            else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200) {
                try {
                    document.querySelector("div#"+file+" div.versionComparaison span.userVersion span.userVersionPrecise").textContent=JSON.parse(
                        fs.readFileSync(programDir+file+"/"+file+".json", "utf8")
                    ).version;
                } catch (error) {
                    document.querySelector("div#"+file+" div.versionComparaison span.userVersion").textContent="Aucune version installée.";
                    document.querySelector("div#"+file+" div.versionComparaison").style.backgroundColor="#ff9933";
                }

                document.querySelector("div#"+file+" div.versionComparaison").style.backgroundColor="#FFCB60";
                document.querySelector("div#"+file+" div.changeLogs").style.backgroundColor="#FFCB60";
                antiSpamErrorNotif("Recherche de mise à jours pour "+file+" impossible : "+xhr.statusText, xhr.status);
            }
        });
        xhr.send(null);
        setTimeout(function(){ document.getElementById("reload"+id).style.animationName=""; },3000);
    }
}

function downloadNewVersion(file ,id) {

    document.querySelector("div#"+file+" img.update").style.display="none";
    document.querySelector("div#"+file+" div.versionComparaison span.userVersion").style.display="none";
    document.querySelector("div#"+file+" div.versionComparaison div.exterior").style.display="block";
    document.querySelector("div#"+file+" img.cancel").style.display="block";

    /*let rgb1=245, rgb2=196, rgb3=184;
    let max=255, min=0;
    let rgb1Next=Math.floor(Math.random() * (max - min) + min);
    let rgb2Next=Math.floor(Math.random() * (max - min) + min);
    let rgb3Next=Math.floor(Math.random() * (max - min) + min);
    let coloringInterval=setInterval(function(){
        let scale=5;

        if (rgb1+scale<rgb1Next) {rgb1+=scale;}
        else if (rgb1-scale>rgb1Next) {rgb1-=scale;}
        else {rgb1=rgb1Next;}

        if (rgb2+scale<rgb2Next) {rgb2+=scale;}
        else if (rgb2-scale>rgb2Next) {rgb2-=scale;}
        else {rgb2=rgb2Next;}

        if (rgb3+scale<rgb3Next) {rgb3+=scale;}
        else if (rgb3-scale>rgb3Next) {rgb3-=scale;}
        else {rgb3=rgb3Next;}

        document.querySelector("div#"+file+" div.versionComparaison div.exterior div.interior").style.backgroundColor="rgb("+rgb1+","+rgb2+","+rgb3+")";

        if (rgb1==rgb1Next&&rgb2==rgb2Next&&rgb3==rgb3Next) {
            rgb1Next=Math.floor(Math.random() * (max - min) + min);
            rgb2Next=Math.floor(Math.random() * (max - min) + min);
            rgb3Next=Math.floor(Math.random() * (max - min) + min);
        }
    }, 60);*/

    let max=255, min=50;
    let coloringInterval=setInterval(function(){
        document.querySelector("div#"+file+" div.versionComparaison div.exterior div.interior").style.backgroundColor="#"+
        Math.floor(Math.random()*(max-min)+min).toString(16)+
        Math.floor(Math.random()*(max-min)+min).toString(16)+
        Math.floor(Math.random()*(max-min)+min).toString(16);
    }, 1000);

    let progression = document.querySelector("div#"+file+" div.versionComparaison div.interior").style,
    xhr = new XMLHttpRequest();
    progression.width = 0;

    xhr.open("GET", API+file+"&download="+platform);
    xhr.responseType = "arraybuffer";
    xhr.addEventListener("readystatechange", function() {
        xhr.onprogress = function(e) {
            progression.width = e.loaded * 100 / e.total + "%";
        };

        if (cancel[id]==true) {
            xhr.abort();
            clearInterval(coloringInterval);
            document.querySelector("div#"+file+" div.versionComparaison div.exterior div.interior").style.backgroundColor="#ff5429";

            document.querySelector("div#"+file+" img.cancel").style.display="none";
            document.querySelector("div#"+file+" div.afterLoad").style.display="flex";
            document.querySelector("div#"+file+" img.clear").style.display="block";

            cancel[id]=false;
        }
        else if (xhr.readyState === XMLHttpRequest.DONE && (xhr.status === 200)) {
            progression.width = "100%";
            clearInterval(coloringInterval);
            document.querySelector("div#"+file+" div.versionComparaison div.exterior div.interior").style.backgroundColor="#33CC33";

            document.getElementById("background").style.display="block";
            document.querySelector("body").style.overflowY="hidden";
            document.getElementById("decrypt").style.display="block";
            //loading screen

            let base64String=Buffer.from(xhr.response).toString("base64");

            ipcRenderer.send("save-dialog", file, base64String);
        }
        else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200) {
            progression.width = "0%";
            clearInterval(coloringInterval);
            document.querySelector("div#"+file+" div.versionComparaison div.exterior div.interior").style.backgroundColor="#ff5429";

            errorNotification("Téléchargement de "+file+" impossible : "+xhr.statusText, xhr.status);

            document.querySelector("div#"+file+" img.cancel").style.display="none";
            document.querySelector("div#"+file+" div.afterLoad").style.display="flex";
            document.querySelector("div#"+file+" img.clear").style.display="block";

        }
    });
    xhr.send(null);
}

function checkSupport () {
    document.getElementById("loading").style.animationName="turnAroundLoading";

    if (document.getElementById("background").style.display=="none") {}
    else {
        document.getElementById("background").style.display="block";
        document.querySelector("body").style.overflowY="hidden";
        document.getElementById("logo").style.display="block";
    }

    setTimeout(function(){
        document.getElementById("loading").style.animationName="none";
        document.getElementById("background").style.display="none";
        document.getElementById("loading").style.display="none";
        document.querySelector("body").style.overflowY="auto";
        document.getElementById("logo").style.display="none";
    },5000);

    function writeData (request) {
        var totalIcons=0, xhrImg=[];
        cancel=null; cancel=[];
        for (let i = 0; i < request.name.length; i++) {
            cancel.push(false);
            xhrImg.push(new XMLHttpRequest());
            xhrImg[i].responseType = "arraybuffer";
            xhrImg[i].timeout = 5000;
            xhrImg[i].open("GET", API+request.name[i]+"&img=true");
            xhrImg[i].addEventListener("readystatechange", function() {
                if (xhrImg[i].readyState === XMLHttpRequest.DONE && (xhrImg[i].status === 200)) {
                    let base64String=Buffer.from(xhrImg[i].response).toString("base64");

                    fs.mkdirSync(dataDir+"cache/img/", { recursive: true } );
                    fs.writeFileSync(dataDir+"cache/img/"+request.name[i]+".png", base64String, "base64");
                }
                else if (xhrImg[i].readyState === XMLHttpRequest.DONE && xhrImg[i].status != 200) {
                    antiSpamErrorNotif("Téléchargement de la miniature de "+request.name[i]+" impossible : "+xhrImg[i].statusText, xhrImg[i].status);
                }
            });

            xhrImg[i].send(null);

            let container=`
            <div class="container" id="${request.name[i]}">
                <img class="icon" src="${dataDir}cache/img/${request.name[i]}.png" 
                alt="${request.spaceName[i]}">
                <span class="title">${request.spaceName[i]}</span>
                <div class="versionComparaison">
                    <div class="exterior">
                        <div class="interior"></div>
                    </div>
                    <span class="userVersion">Votre version est la version <span class="userVersionPrecise">?</span></span>
                    <span class="onlineVersion">La dernière version est la <span class="onlineVersionPrecise">?</span></span>
                </div>
                <div class="changeLogs">
                    <div class="antiTranslation">
                        <span class="changeLogsPresentation">Aucune information disponible...</span>
                        <span class="changeLogsReceive"></span>
                    </div>
                </div>
                <img class="reload" src="public/img/reload.png" alt="Update" id="reload${i}" onclick="verifyVersion('${request.name[i]}', '${i}');">
                <img class="update" src="public/img/update.png" alt="Upgrade" id="update${i}" onclick="downloadNewVersion('${request.name[i]}', '${i}');">
                <img class="cancel" src="public/img/cancel.png" alt="Cancel" id="cancel${i}" onclick="cancel[${i}]=true;">
                <img class="clear" src="public/img/clear.png" alt="Clear" id="clear${i}" onclick="
                    document.querySelector('div#${request.name[i]} div.afterLoad').style.display='none';
                    document.querySelector('div#${request.name[i]} div.versionComparaison span.userVersion').style.display='block';
                    document.querySelector('div#${request.name[i]} div.versionComparaison div.exterior').style.display='none';
                    document.querySelector('div#${request.name[i]} div.changeLogs div.antiTranslation span.changeLogsPresentation').textContent='Aucune information disponible...';
                    document.querySelector('div#${request.name[i]} div.changeLogs div.antiTranslation span.changeLogsReceive').textContent='';
                    document.querySelector('div#${request.name[i]} div.versionComparaison span.userVersion').textContent='Votre version est la version ';
                    document.querySelector('div#${request.name[i]} div.versionComparaison span.onlineVersion').textContent='La dernière version est la ';
                    reconstructionAfterClear('${request.name[i]}');
                    document.querySelector('div#${request.name[i]} img.clear').style.display='none';
                    document.querySelector('div#${request.name[i]} img.reload').style.display='block';
                    verifyVersion('${request.name[i]}', '${i}');
                ">
                <div class="afterLoad">
                    <img class="folder" src="public/img/folder.png" alt="Folder" id="folder${i}" onclick=''>
                    <img class="execute" src="public/img/window.png" alt="Execute" id="execute${i}" onclick=''>
                </div>
            </div>`;
            document.getElementById("background").insertAdjacentHTML("beforeBegin", container);
            totalIcons++;
        }
        setTimeout(function(){
            let icons=document.getElementsByClassName("icon");
            for (let i = 0; i < totalIcons; i++) {
                icons[i].src+="?actualise=true";
                icons[i].setAttribute("onclick", "document.getElementById('audio').play();");
            }
        },4750);
    }

    let online=API+"support";
    var xhr = new XMLHttpRequest();
    xhr.timeout = 5000;
    xhr.open("GET", online);
    xhr.addEventListener("readystatechange", function() {
        if (xhr.readyState === XMLHttpRequest.DONE && (xhr.status === 200)) {
            fs.mkdir(dataDir+"cache/json/", { recursive: true }, (err) => {
                if(err) {
                    ipcRenderer.send("error-dialog", "Erreur mainGraphicInterface création dossier : \n"+err);
                }
                fs.writeFileSync(dataDir+"cache/json/support.json", xhr.responseText, "utf8");
            });
            writeData(JSON.parse(xhr.responseText));
        }
        else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200) {
            writeData(JSON.parse(fs.readFileSync(dataDir+"cache/json/support.json", "utf8")));
            antiSpamErrorNotif("Recherche de mise à jours globales impossible : "+xhr.statusText, xhr.status);
        }
    });
    xhr.send(null);
}

function reconstructionAfterClear(request) {
	document.querySelector("div#"+request+" div.versionComparaison span.userVersion").insertAdjacentHTML("beforeend", '<span class="userVersionPrecise">?</span>');
	document.querySelector("div#"+request+" div.versionComparaison span.onlineVersion").insertAdjacentHTML("beforeend", '<span class="onlineVersionPrecise">?</span>');
}

checkSupport();
setTimeout(function(){
    idContainer=document.getElementsByClassName("container");
    for (let i = 0; i < idContainer.length; i++) {
        verifyVersion(idContainer[i].getAttribute("id"), i);
    }
},5000);


/*ipcRenderer.on("ipcRenderer", (event, arg) => {
    console.log(arg);
    event.sender.send("ipcMain", "pong");
});*/