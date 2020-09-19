const fs = require("fs");

function debugLog(log) {
  if (debug) console.log("\x1b[96m", "-- "+log+" --", "\x1b[0m");
}
//const debug = fs.existsSync(__dirname+"/package.json") ? /--debug/.test(process.argv[2]) : false;
const debug=false;
if (debug) {
  fs.mkdirSync(__dirname+"/public/json/", { recursive: true });
  let packageToLocalVersion = JSON.parse(fs.readFileSync(__dirname+"/package.json", "utf8"));
  delete packageToLocalVersion.build;
  delete packageToLocalVersion.scripts;
  delete packageToLocalVersion.devDependencies;
  delete packageToLocalVersion.main;
  fs.writeFileSync(__dirname+"/public/json/Wallpaper_Night_Changer.json", JSON.stringify(packageToLocalVersion) );
  debugLog("Wallpaper_Night_Changer.json updated");
}


const homedir = require("os").homedir(),
platform = require("os").platform(),
{ exec } = platform!="win32" ? require("child_process") : null;

const { Menu, app, Tray, BrowserWindow, ipcMain, dialog, shell } = require("electron");

const originalLocalConfig = require("./public/json/config.json"),
dataDir = homedir+"/.DawnowlApps/Wallpaper_Night_Changer/";

var tray=null,
state = {
  "whenToChangeTo": false
};


function errorLog(log) {
  console.log("\x1b[91m", "\x1b[47m", "!! "+log+" !!", "\x1b[0m");
  dialog.showErrorBox("Wallpaper_Night_Changer, Une importante erreur a été rencontrée : ", log);
}
function warningLog(log) {
  console.log("\x1b[93m", "## "+log+" ##", "\x1b[0m");
}
function infoLog(log) {
  console.log("\x1b[92m", "// "+log+" //", "\x1b[0m");
}
function infoBox(info) {
  dialog.showMessageBox({
    type: "info",
    title: "Dawnowl_Updater Information",
    message: info,
    buttons: ["Compris"]
  });
}
debugLog("debug mode enabled");

ipcMain.on("closing-whenToChangeTo", (event) => {
  state.whenToChangeTo=false;
});

ipcMain.on("error-dialog", (event, arg) => {
  errorLog(arg);
});

ipcMain.on("info-log", (event, arg) => {
  infoLog(arg);
});

ipcMain.on("open-file-dialog", (event, arg) => {
  dialog.showOpenDialog({
    title: "Changer le fond d'écran de "+arg+" à utiliser : ",
    defaultPath: homedir+"/Pictures/",
    filters: [
      { name : "Images compatibles", extensions: ["png", "jpg", "bmp", "PNG", "jpeg", "JPG", "JPEG", "BMP"] },
      { name : "Images non compatibles", extensions: ["gif", "tiff", "tif"] }
    ],
    properties: ["openFile", "dontAddToRecent"]
  })
  .then(result => {
    event.reply("selected-file", result.filePaths[0], arg);
  })
  .catch(err => {
    errorLog("Erreur d'enregistrement indéfini : \n"+err);
  });
});


function changingTime(isNight) {
  switch(platform) {
    case "win32":      
      if (isNight) {
        fs.copyFileSync(dataDir+"toNight", homedir+"/AppData/Roaming/Microsoft/Windows/Themes/TranscodedWallpaper");
        shell.openItem(homedir+"\\.DawnowlApps\\Wallpaper_Night_Changer\\toNight.cmd");
      }
      else {
        fs.copyFileSync(dataDir+"toDay", homedir+"/AppData/Roaming/Microsoft/Windows/Themes/TranscodedWallpaper");
        shell.openItem(homedir+"\\.DawnowlApps\\Wallpaper_Night_Changer\\toDay.cmd");
      }
    break;
    case "linux":
      let toTmp=isNight ? "toNight" : "toDay";
      exec("/bin/bash "+dataDir+"toDayNight.sh "+toTmp);
    break;
    default:
      errorLog(platform+" not supported in scripting process");
      return false;
    break;
  }
}
ipcMain.on("changingTime", (event, arg) => {
  changingTime(arg);
});

function launchAtStartUp(del) {
  if (del) {
    switch(platform) {
      case "win32":
        fs.unlink(homedir+"/AppData/Roaming/Microsoft/Windows/Start Menu/Programs/Startup/Wallpaper_Night_Changer.cmd", (err) => {
          if (err) {
            dialog.showMessageBox({
              type: "warning",
              title: "Wallpaper_Night_Changer override warning",
              message: "Le fichier de démarrage n'a pu être supprimé ou n'existe pas (→ Override)",
              buttons: ["OK"]
            });
            warningLog("StartUp.cmd override warning");
          }
          else infoLog("win32 → Startup deleted");
        });
      break;

      case "linux":
        fs.unlink(homedir+"/.config/autostart/Wallpaper_Night_Changer.desktop", (err) => {
          if (err) {
            dialog.showMessageBox({
              type: "warning",
              title: "Wallpaper_Night_Changer override warning",
              message: "Le fichier de démarrage n'a pu être supprimé ou n'existe pas (→ Override)",
              buttons: ["OK"]
            });
            warningLog("StartUp.desktop override warning");
          }
          else infoLog("linux → Startup deleted");
        });
      break;

      default:
        warningLog(platform+" not recognized in Startup Configuration → del");
        return false;
      break;
    }
  }
  else {
    switch(platform) {
      case "win32":
        fs.readFile(homedir+"/AppData/Roaming/Microsoft/Windows/Start Menu/Programs/Startup/Wallpaper_Night_Changer.cmd", "utf8", (err, jsonString) => {
            if (err) {
            fs.copyFile(__dirname+"/public/startUp/Wallpaper_Night_Changer.cmd", homedir+"/AppData/Roaming/Microsoft/Windows/Start Menu/Programs/Startup/Wallpaper_Night_Changer.cmd", (err) => {
              if (err) {
                errorLog("copyFile startUp.cmd error : \n"+err);
                return false;
              }
              else infoLog("win32 → Startup written");
            });
            }
            else {
              infoLog("Startup already written");
            }
        });
      break;

      case "linux":
        fs.readFile(homedir+"/.config/autostart/Wallpaper_Night_Changer.desktop", "utf8", (err, jsonString) => {
            if (err) {
            fs.copyFile(__dirname+"/public/startUp/Wallpaper_Night_Changer.desktop", homedir+"/.config/autostart/Wallpaper_Night_Changer.desktop", (err) => {
              if (err) {
                errorLog("copyFile startUp.desktop error : \n"+err);
                return false;
              }
              else infoLog("linux → Startup written");
            });
            }
            else {
              infoLog("Startup already written");
            }
        });
      break;

      default:
        warningLog(platform+" not recognized in Startup Configuration → create");
        return false;
      break;
    }   
  }
  return true;
}


console.log("\x1b[95m", "\n// Wallpaper_Night_Changer //\n", "\x1b[0m");

if (!app.requestSingleInstanceLock()) {
  warningLog("Failed to obtain single instance lock");
  app.exit(0);
}
else {
  app.on("second-instance", (event, commandLine, workingDirectory) => {
    infoBox("L'application est déjà ouverte dans la barre des tâches/programmes/notifications.");
  });
}

app.allowRendererProcessReuse=true;
app.on("ready", () => {
  fs.readFile(dataDir+"config.json", "utf8", (err, jsonString) => {
    if (err) {
      fs.mkdirSync(dataDir, { recursive: true });
      fs.writeFile(dataDir+"config.json", JSON.stringify(originalLocalConfig), (err) => {
        if (err) { errorLog("writeFile config.json error : \n"+err); }
        else { infoLog("First use → config.json written"); }
      });
      fs.copyFile(__dirname+"/public/img/toDay.png", dataDir+"toDay", (err) => {
        if (err) errorLog("copyFile toDay error : \n"+err);
        else infoLog("First use → toDay written");
      });
      fs.copyFile(__dirname+"/public/img/toNight.png", dataDir+"toNight", (err) => {
        if (err) errorLog("copyFile toNight error : \n"+err);
        else infoLog("First use → toNight written");
      });
      switch(platform) {
        case "win32":
          fs.copyFile(__dirname+"/public/cmd/toNight.cmd", dataDir+"toNight.cmd", (err) => {
            if (err) errorLog("copyFile toNight.cmd error : \n"+err);
            else infoLog("First use → toNight.cmd written");
          });
          fs.copyFile(__dirname+"/public/cmd/toDay.cmd", dataDir+"toDay.cmd", (err) => {
            if (err) errorLog("copyFile toDay.cmd error : \n"+err);
            else infoLog("First use → toDay.cmd written");
          });
          fs.copyFile(__dirname+"/public/cmd/forceReload.cmd", dataDir+"forceReload.cmd", (err) => {
            if (err) errorLog("copyFile forceReload.cmd error : \n"+err);
            else infoLog("First use → forceReload.cmd written");
          });
        break;
        case "linux":
          fs.copyFile(__dirname+"/public/bash/toDayNight.sh", dataDir+"toDayNight.sh", (err) => {
            if (err) errorLog("copyFile toDayNight.sh error : \n"+err);
            else infoLog("First use → toDayNight.sh written");
          });
        break;
        default:
          errorLog(platform+" not supported in init process");
        break;
      }
      var localConfigJSON=originalLocalConfig;
    }
    else {
      infoLog("Configuration already written");
      var localConfigJSON=JSON.parse(jsonString);
    }

    let rendererWin = new BrowserWindow ({
      title: "Wallpaper_Night_Changer : Renderer Process",
      icon: __dirname+"/public/img/tray.png",
      backgroundColor: "#2D2D2D",
      width: 640,
      height: 480,
      show: debug ? true : false,
      webPreferences: {
        nodeIntegration: true
      }
    });
    rendererWin.loadFile("rendererProcess.html");
    if (debug) rendererWin.webContents.openDevTools();

    tray = new Tray(__dirname+"/public/img/tray.png");
    tray.setToolTip("Wallpaper Night Changer");
    tray.on("click", () => {
      tray.popUpContextMenu();
      console.log(tray);
    });

    let menuListe=[
      { label: "Lancer au démarrage", type: "checkbox" },
      { type: "separator" },
      { label: "Activer les notifications", type: "checkbox" },
      { label: "Modifier les paramètres" },
      { type: "separator" },
      { label: "Recharger le mode nuit" },
      { label: "Recharger le mode jour" },
      { label: "Forcer l'actualisation", visible: platform=="win32" ? true : false },
      { type: "separator" },
      { label: "Quitter", role: "quit" }
    ];

    const contextMenu = Menu.buildFromTemplate(menuListe);
    let menuPlaces={
      startUp: 0,
      notifications: 2,
      whenToChangeTo: 3,
      reloadNight: 5,
      windowsReload: 7, 
      reloadDay: 6
    };

    contextMenu.items[menuPlaces.notifications].checked=localConfigJSON.notifications;
    contextMenu.items[menuPlaces.startUp].checked=localConfigJSON.startUp;
    tray.setContextMenu(contextMenu);

    contextMenu.items[menuPlaces.startUp].click=() => {
      if (localConfigJSON.startUp) localConfigJSON.startUp=!launchAtStartUp(true);
      else localConfigJSON.startUp=launchAtStartUp(false);

      fs.writeFileSync(dataDir+"config.json", JSON.stringify(localConfigJSON));

      contextMenu.items[menuPlaces.startUp].checked=localConfigJSON.startUp;
      tray.setContextMenu(contextMenu);
      infoLog("Configuration updated");
    };

    contextMenu.items[menuPlaces.notifications].click=() => {
      if (localConfigJSON.notifications) localConfigJSON.notifications=false;
      else localConfigJSON.notifications=true;

      fs.writeFileSync(dataDir+"config.json", JSON.stringify(localConfigJSON));

      contextMenu.items[menuPlaces.notifications].checked=localConfigJSON.notifications;
      tray.setContextMenu(contextMenu);
      infoLog("Notifications updated");
    };

    contextMenu.items[menuPlaces.whenToChangeTo].click = () => {
      if (!state.whenToChangeTo) {
        let whenToChangeToWin = new BrowserWindow({
          title: "Wallpaper Night Changer : Configuration des horaires de transition de fond d'écran",
          icon: __dirname+"/public/img/tray.png",
          backgroundColor: "#2D2D2D",
          width: 1100,
          height: 700,
          frame: false,
          webPreferences: {
            nodeIntegration: true
          }
        });
        state.whenToChangeTo=true;
        whenToChangeToWin.loadFile("whenToChangeTo.html");
        whenToChangeToWin.setProgressBar(0.5);
        if (debug) {
          whenToChangeToWin.webContents.openDevTools();
          //whenToChangeToWin.maximize();
        }
        Menu.setApplicationMenu(
        Menu.buildFromTemplate(
            [{
              label: "Recharger",
              accelerator: "CmdOrCtrl+R",
              role: "reload"
            },{
              type: "separator",
            },{
              label: "Fermer la fenêtre",
              accelerator: "CmdOrCtrl+W",
              role: "close"
              }]
          )
        );
      }
      else infoBox("L'interface graphique de configuration des horaires de transition est déjà lancée veuiller la fermer pour en ouvrir une nouvelle.\n"+
        "Ou bien terminer le changement de configuration précédemment entamé en appuyant sur «Valider».");
    };

    contextMenu.items[menuPlaces.reloadNight].click = () => { changingTime(true); };
    contextMenu.items[menuPlaces.reloadDay].click = () => { changingTime(false); };
    contextMenu.items[menuPlaces.windowsReload].click = () => { shell.openItem(dataDir+"forceReload.cmd"); };

    contextMenu.items[menuListe.length-1].click = () => { app.exit(0); };
  });
});