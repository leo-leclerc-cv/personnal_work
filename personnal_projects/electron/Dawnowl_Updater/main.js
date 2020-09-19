const fs = require("fs");

function debugLog(log) {
	if (debug) console.log("\x1b[96m", "-- "+log+" --", "\x1b[0m");
}
const debug = fs.existsSync(__dirname+"/package.json") ? /--debug/.test(process.argv[2]) : false;
//const debug=false;
if (debug) {
	let packageToLocalVersion = JSON.parse(fs.readFileSync(__dirname+"/package.json", "utf8"));
	delete packageToLocalVersion.build;
	delete packageToLocalVersion.scripts;
	delete packageToLocalVersion.devDependencies;
	delete packageToLocalVersion.main;
	fs.writeFileSync(__dirname+"/public/json/Dawnowl_Updater.json", JSON.stringify(packageToLocalVersion) );
	debugLog("Dawnowl_Updater.json updated");
}

const { app, Menu, Tray, BrowserWindow, ipcMain, dialog } = require("electron");
const { homedir, platform, API, originalLocalConfig, localVersion, dataDir } = require("./libraries.js");
//const XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;

const maintenance = /--maintenance/.test(process.argv[2]);
var tray = null,
state = {
	"rendererProcess": false,
	"mainGraphicInterface": false,
	"checkIntervall": false
};

function errorLog(log) {
	console.log("\x1b[91m", "\x1b[47m", "!! "+log+" !!", "\x1b[0m");
	dialog.showErrorBox("Dawnowl_Updater, Une importante erreur a été rencontrée : ", log);
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


ipcMain.on("error-dialog", (event, arg) => {
	errorLog(arg);
});

ipcMain.on("warn-log", (event, arg) => {
	warningLog(arg);
});

ipcMain.on("info-dialog", (event, arg) => {
	infoBox(arg);
});

ipcMain.on("tray-offline", (event) => {
	tray.setImage(__dirname+"/public/img/offlineTray.png");
});

ipcMain.on("tray-online", (event) => {
	tray.setImage(__dirname+"/public/img/tray.png");
});

ipcMain.on("closing-mainGraphicInterface", (event) => {
	state.mainGraphicInterface=false;
});

ipcMain.on("closing-checkIntervall", (event) => {
	state.checkIntervall=false;
});

ipcMain.on("launch-mainGraphicInterface", (event) => {
	state.mainGraphicInterface ? infoBox("L'interface graphique principale est déjà lancée veuiller la fermer pour en ouvrir une nouvelle.") : mainGraphicInterface();
});

ipcMain.on("save-dialog", (event, file, base64String) => {
		dialog.showSaveDialog(subMainwin, function() {
			switch(platform) {
				case "win32":
					return {
						title: "Enregistrer la mise à jour : ",
						filters: [
							{ name: "Application", extensions: ["exe"] }
						],
						defaultPath: file+"-MAJ.exe"
					}
				break;

				case "linux":
					return {
						title: "Enregistrer la mise à jour : ",
						filters: [
							{ name: "Application", extensions: ["deb"] }
						],
						defaultPath: file+"-MAJ.deb"
					}
				break;

				default:
					warningLog(platform+" not recognized in mainGraphicInterface save-dialog → options");
					return false;
				break;
			}
		}())
		.then(result => {
			debugLog("canceled? "+result.canceled);
			debugLog("filePath : "+ result.filePath);
			event.reply("saved-file", result, file, base64String);
		})
		.catch(err => {
			errorLog("Erreur d'enregistrement indéfini : \n"+err);
		});
	});


function mainGraphicInterface() {
	if (state.mainGraphicInterface) {
		warningLog("mainGraphicInterface was launch but an over instance is running");
		return false;
	}

	subMainwin = new BrowserWindow({
		title: "Dawnowl Updater",
		icon: __dirname+"/public/img/tray.png",
		backgroundColor: "#2D2D2D",
		width: 1000,
		height: 600,
		webPreferences: {
			nodeIntegration: true
		}
	});

	if (!debug) {
		let template = [
			{
				label: "Recharger/Chercher à nouveau toutes les mises à jours",
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
		subMainwin.webContents.openDevTools();
		subMainwin.maximize();
	}

	state.mainGraphicInterface=true;
	subMainwin.loadFile("index.html");
}

function launchAtStartUp(del) {
	if (del) {
		switch(platform) {
			case "win32":
				fs.unlink(homedir+"/AppData/Roaming/Microsoft/Windows/Start Menu/Programs/Startup/Dawnowl_Updater.cmd", (err) => {
					if (err) {
						dialog.showMessageBox({
							type: "warning",
							title: "Dawnowl_Updater override warning",
							message: "Le fichier de démarrage n'a pu être supprimé ou n'existe pas (→ Override)",
							buttons: ["OK"]
						});
						warningLog("StartUp.cmd override warning");
					}
					else infoLog("win32 → Startup deleted");
				});
			break;

			case "linux":
				fs.unlink(homedir+"/.config/autostart/Dawnowl_Updater.desktop", (err) => {
					if (err) {
						dialog.showMessageBox({
							type: "warning",
							title: "Dawnowl_Updater override warning",
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
				fs.readFile(homedir+"/AppData/Roaming/Microsoft/Windows/Start Menu/Programs/Startup/Dawnowl_Updater.cmd", "utf8", (err, jsonString) => {
				    if (err) {
						fs.copyFile(__dirname+"/public/startUp/Dawnowl_Updater.cmd", homedir+"/AppData/Roaming/Microsoft/Windows/Start Menu/Programs/Startup/Dawnowl_Updater.cmd", (err) => {
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
				fs.readFile(homedir+"/.config/autostart/Dawnowl_Updater.desktop", "utf8", (err, jsonString) => {
				    if (err) {
						fs.copyFile(__dirname+"/public/startUp/Dawnowl_Updater.desktop", homedir+"/.config/autostart/Dawnowl_Updater.desktop", (err) => {
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

if (!maintenance) {
	console.log("\x1b[95m", "\n// Dawnowl_Updater //\n", "\x1b[0m");

	if (!app.requestSingleInstanceLock()) {
		warningLog("Failed to obtain single instance lock");
		app.exit(0);
	}
	else {
		app.on("second-instance", (event, commandLine, workingDirectory) => {
			if (state.mainGraphicInterface) {
				infoBox("L'application est déjà ouverte dans la barre des tâches/programmes/notifications.\n"+
				"De plus l'interface graphique principale est déjà lancée.");
			}
			else {
				infoBox("L'application est déjà ouverte dans la barre des tâches/programmes/notifications.\n"+
				"Une instance de l'interface graphique va être lancé dans 5sec.");
				setTimeout(function(){ mainGraphicInterface(); }, 5000);
			}
		});
	}

	fs.mkdirSync(dataDir+"cache/json/", { recursive: true });

	fs.readFile(dataDir+"Dawnowl_Updater.json", "utf8", (err, jsonString) => {
	    if (err) {
	    	fs.copyFile(__dirname+"/public/json/Dawnowl_Updater.json", dataDir+"Dawnowl_Updater.json", (err) => {
	    		if (err) errorLog("writeFile Dawnowl_Updater.json error n°1 : \n"+err);
	    		else infoLog("First use → Dawnowl_Updater.json written");
	    	});
	    	fs.copyFile(__dirname+"/public/json/support.json", dataDir+"cache/json/support.json", (err) => {
	    		if (err) errorLog("writeFile support.json cache error n°1 : \n"+err);
	    		else infoLog("First use → support.json cache written");
	    	});
	    }
	    else {
		    let installed=JSON.parse(jsonString), isUpgrade=null;
		    isUpgrade = localVersion.version>installed.version ? true : false;

		    if (isUpgrade) {
		    	fs.copyFile(__dirname+"/public/json/Dawnowl_Updater.json", dataDir+"Dawnowl_Updater.json", (err) => {
		    		if (err) errorLog("writeFile Dawnowl_Updater.json error n°2 : \n"+err);
		    		else infoLog(localVersion.name+" fully upgraded to "+localVersion.version);
		    	});
		    	fs.copyFile(__dirname+"/public/json/support.json", dataDir+"cache/json/support.json", (err) => {
		    		if (err) errorLog("writeFile support.json cache error n°2 : \n"+err);
		    		else infoLog("Upgrade → support.json cache written");
		    	});
		    }
		    else {
		      infoLog("Vous possedez "+installed.name+" version "+installed.version);
		    }
		}
	});

	app.allowRendererProcessReuse=true;
	app.on("ready", () => {

		tray = new Tray(__dirname+"/public/img/tray.png");

		let rendererWin = new BrowserWindow ({
			title: "Dawnowl_Updater : Renderer Process",
			icon: __dirname+"/public/img/offlineTray.png",
			backgroundColor: "#2D2D2D",
			width: 800,
			height: 600,
			show: debug ? true : false,
			webPreferences: {
				nodeIntegration: true
			}
		});
		rendererWin.loadFile("rendererProcess.html");
		if (debug) rendererWin.webContents.openDevTools();
		debugLog("Directory = "+__dirname);
		debugLog("dataDir = "+dataDir);

		tray.setToolTip("Dawnowl Apps Updater");
		if (platform=="win32") {
			tray.on("click", () => {
				state.mainGraphicInterface ? infoBox("L'interface graphique principale est déjà lancée veuiller la fermer pour en ouvrir une nouvelle.") : mainGraphicInterface();
			});
		}

	  	fs.readFile(dataDir+"config.json", "utf8", (err, jsonString) => {
	  		if (err) {
	  			fs.writeFile(dataDir+"config.json", JSON.stringify(originalLocalConfig), (err) => {
		  			if(err) { errorLog("writeFile config.json error n°1 : \n"+err); }
		  			else { infoLog("First use → config.json written"); }
		  		});
		  		var localConfigJSON=originalLocalConfig;
	  		}
	  		else {
	  			infoLog("Configuration already written");
		  		var localConfigJSON=JSON.parse(jsonString);
	  		}
	  		//debugLog(localConfigJSON);

		  	let menuListe=[
				{ label: "Mise à jours manuelle", type: "radio" },
			    //{ label: "Mise à jours automatiques", type: "radio" },
			    { type: "separator" },
			    { label: "Lancer au démarrage", type: "checkbox" },
				{ label: "Redémarrer l'app en mode maintenance" },
			    { type: "separator" },
				{ label: "Changer l'intervalle de vérification" },
			    { label: "Lancer l'interface graphique" },
			    { type: "separator" },
			    { label: "Quitter" }
		  	];
		  	const contextMenu = Menu.buildFromTemplate(menuListe);
		  	let menuPlaces={
		  		manualUpdate: 0,
		  		startUp: 2,
		  		maintenanceRelaunch: 3,
		  		autoCheckIntervalMenu: 5,
		  		launchGraphicalInterface: 6
		  	};

	  		contextMenu.items[menuPlaces.manualUpdate].checked=localConfigJSON.manualUpdate;
	  		contextMenu.items[menuPlaces.startUp].checked=localConfigJSON.startUp;
	  		tray.setContextMenu(contextMenu);

	  		contextMenu.items[menuPlaces.autoCheckIntervalMenu].click = () => {
	  			if (!state.checkIntervall) {
					let intervalWin = new BrowserWindow({
						title: "Dawnowl Updater : Configuration des intervalles de vérification",
						icon: __dirname+"/public/img/tray.png",
						backgroundColor: "#2D2D2D",
						width: 600,
						height: 400,
						frame: false,
						webPreferences: {
							nodeIntegration: true
						}
					});
					state.checkIntervall=true;
					intervalWin.loadFile("autoCheckInterval.html");
					intervalWin.setProgressBar(0.5);
					if (debug) {
						intervalWin.webContents.openDevTools();
						intervalWin.maximize();
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
				else infoBox("L'interface graphique de modification de l'intervalle de vérification est déjà lancée veuiller la fermer pour en ouvrir une nouvelle.\n"+
					"Ou bien terminer le changement de configuration précédemment entamé en appuyant sur «Valider».");
			};

			contextMenu.items[menuPlaces.startUp].click = () => {
				if (localConfigJSON.startUp) {
					localConfigJSON.startUp=!launchAtStartUp(true);
					contextMenu.items[menuPlaces.startUp].checked = localConfigJSON.startUp;
				}
				else {
					localConfigJSON.startUp=launchAtStartUp(false);
					contextMenu.items[menuPlaces.startUp].checked = localConfigJSON.startUp;
				}
		  		fs.writeFileSync(dataDir+"config.json", JSON.stringify(localConfigJSON));
		  		infoLog("Configuration updated");
		  		tray.setContextMenu(contextMenu);
			};

			contextMenu.items[menuPlaces.launchGraphicalInterface].click = () => {
				state.mainGraphicInterface ? infoBox("L'interface graphique est déjà lancée veuillez la fermer pour en ouvrir une nouvelle.") : mainGraphicInterface();
			};

			contextMenu.items[menuPlaces.maintenanceRelaunch].click = () => {
				app.relaunch({ args: [".", "--maintenance"] });
				app.exit(0);
			};

			contextMenu.items[menuListe.length-1].click = () => {
				app.exit(0);
			};
		});
	});
}
else {
	console.log("\x1b[95m", "\n// Dawnowl_Updater : Maintenance mode //\n", "\x1b[0m");

	function msgBox(msg) {
		dialog.showMessageBoxSync({
			type: "info",
			title: "Dawnowl_Updater Maintenance",
			message: msg,
			buttons: ["OK"]
		});
	}

	ipcMain.on("msg", (event, arg) => {
		msgBox(arg);
	});

	ipcMain.on("restart", (event) => {
		app.relaunch({ args: ["."] });
		app.exit(0);
	});
	ipcMain.on("exit", function(){app.exit(0);});

	app.on("ready", () => {
		let win = new BrowserWindow({
			title: "Dawnowl Updater : Maintenance",
			icon: __dirname+"/public/img/offlineTray.png",
			backgroundColor: "#2D2D2D",
			width: 600,
			height: 800,
			frame: false,
			webPreferences: {
				nodeIntegration: true
			}
		});
		win.loadFile("maintenance.html");
	});
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