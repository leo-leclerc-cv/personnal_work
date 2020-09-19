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
  fs.writeFileSync(__dirname+"/public/json/Project_Board_Battle_Game.json", JSON.stringify(packageToLocalVersion) );
  debugLog("Project_Board_Battle_Game.json updated");
}

const { Menu, app, BrowserWindow, ipcMain, dialog } = require("electron");


function errorLog(log) {
  console.log("\x1b[91m", "\x1b[47m", "!! "+log+" !!", "\x1b[0m");
  dialog.showErrorBox("Project_Board_Battle_Game, Une importante erreur a été rencontrée : ", log);
}

function infoLog(log) {
  console.log("\x1b[92m", "// "+log+" //", "\x1b[0m");
}

ipcMain.on("error-dialog", (event, arg) => {
  errorLog(arg);
});

ipcMain.on("info-log", (event, arg) => {
  infoLog(arg);
});

console.log("\x1b[95m", "\n// Project_Board_Battle_Game //\n", "\x1b[0m");

function createWindow () {
  // Cree la fenetre du navigateur.
  let win = new BrowserWindow({
    title: "Project Board Battle Game : Présentation",
    icon: __dirname+"/public/img/icon.png",
    backgroundColor: "#2D2D2D",
    width: 966,
    height: 768,
    webPreferences: {
      nodeIntegration: true
    }
  });
  if (!debug) {
    let template = [
      {
        label: "Recharger",
        accelerator: "CmdOrCtrl+R",
        role: "reload"
      }, {
        type: "separator",
      }, {
        label: "Fermer la fenêtre",
        accelerator: "CmdOrCtrl+W",
        role: "close"
      }
    ];
    let menu = Menu.buildFromTemplate(template);
    Menu.setApplicationMenu(menu);
  }
  else {
    win.webContents.openDevTools();
    win.maximize();
  }

  // and load the index.html of the app.
  win.loadFile('index.html');
}

app.allowRendererProcessReuse=true;
app.on('ready', createWindow);