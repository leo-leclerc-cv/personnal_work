<?php
$maintenanceFile = fopen("../Maintenance.txt", "r");
$maintenance = fgets($maintenanceFile);
fclose($maintenanceFile);

if ($maintenance==1) {
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET");

	function isItOnTheServer($path){
		if (file_exists($path)) {
			return true;
		}
		else {
			http_response_code(410);
			//header($_SERVER["SERVER_PROTOCOL"]." ".(410)." Temporarily or permanently deleted from the server");
			echo "<font color='red' size='7'>HTTP ERROR 410</font><br/><font color='orange' size='6'>The server appear to not be able to find this file. Maybe it has been temporarily or permanently deleted from the server. Please refer to the latest documentation of the API.</font>";
			return false;
		}
	}

	$localAPI="./AJAX.php?API=1&";

	$JSONdir="./AJAX/JSON/";
	$FILEdir="./AJAX/FILE/";
	$PNGdir="./AJAX/IMG/";

	if (isset($_GET["API"])) {
		$APIversion=$_GET["API"];
	}
	else {
		$APIversion=0;
	}
	
	if (isset($_GET["request"])) {
		switch ($APIversion) {
			case 0:
				switch ($_GET["request"]) {

					case "Dawnowl_Updater":

						if (isset($_GET["img"])) {
							header("Content-Type: image/png");
							echo file_get_contents($PNGdir."Dawnowl_Updater.png");
						}
						else {
							header("Content-Type: application/json");
							echo '
							{
								"name": "Dawnowl_Updater",
								"version": {
									"stable": 2,
									"beta": 0,
									"alpha": 1
								},
								"changeLogs": "Support nouvelle API et stabilitée grandement accrue"
							}';
						}
					break;

					case "support":
						header("Content-Type: application/json");
						echo '
						{
							"request": [
								"Dawnowl_Updater",
								"Rudolf",
								"Project_Board_Battle_Game",
								"Vyrus"
							],
							"name": [
								"Updater for Dawnowl Apps",
							  	"Rudolf",
							  	"Project Board Battle Game",
							  	"Vyrus"
							]
						}';
					break;

					default:
						http_response_code(426);
						//header($_SERVER["SERVER_PROTOCOL"]." ".(426)." This API version is too old");
						echo "<font color='red' size='7'>HTTP ERROR 426</font><br/><font color='orange' size='6'>This API version is too old you'll have to upgrade. Please refer to the latest documentation of the API.</font>";
					break;
				}
			break;

			case 1:

				switch ($_GET["request"]) {

					case "Dawnowl_Updater":
					case "Project_Board_Battle_Game":
					case "Rudolf":
					case "Vyrus":
						if (isset($_GET["download"])) {
							switch ($_GET["download"]) {
								case "win32":
									if (isItOnTheServer($FILEdir."EXE/".$_GET["request"].".xex")) {
										header("Content-Type: application/vnd.microsoft.portable-executable");
							            header("Content-Transfer-Encoding: Binary");
							            header("Content-Length:".filesize($FILEdir."EXE/".$_GET["request"].".xex"));
							            header("Content-Disposition: attachment; filename=".$_GET["request"].".exe");
										readfile($FILEdir."EXE/".$_GET["request"].".xex");
									}
								break;

								case "linux":
									if (isItOnTheServer($FILEdir."DEB/".$_GET["request"].".deb")) {
										header("Content-Type: application/vnd.debian.binary-package");
							            header("Content-Transfer-Encoding: Binary");
							            header("Content-Length:".filesize($FILEdir."DEB/".$_GET["request"].".deb"));
							            header("Content-Disposition: attachment; filename=".$_GET["request"].".deb");
										readfile($FILEdir."DEB/".$_GET["request"].".deb");
									}
								break;
								
								default:
									http_response_code(417);
									//header($_SERVER["SERVER_PROTOCOL"]." ".(417)." Unsupported OS");
									echo "<font color='red' size='7'>HTTP ERROR 417</font><br/><font color='orange' size='6'>Unsupported/Unknown OS. Only win32 and linux (Debian/Ubuntu) are supported.</font>";
								break;
							}
						}
						elseif (isset($_GET["img"])) {
							if (isItOnTheServer($PNGdir.$_GET["request"].".png")) {
								header("Content-Type: image/png");
								echo file_get_contents($PNGdir.$_GET["request"].".png");
							}
						}
						else {
							if (isItOnTheServer($JSONdir.$_GET["request"].".json")) {
								header("Content-Type: application/json");
								echo file_get_contents($JSONdir.$_GET["request"].".json");
							}
						}
					break;

					case "support":
						try {
							$support=array(
								"name" => array(),
								"spaceName" => array(),
								"details" => array(
									"« ?request=support » : renvoye un condensé des logiciels supportés et de leurs informations",
									"« ?request= » : renvoye les dernières infos du logiciel",
									"?request= ",
									"« &API= » : La dernière version est la version «",
									"&API=1"
								),
							  	"otherDetails" => array(
								  	"« &download= » : télécharge le fichier si disponible",
								  	"&download= win32 / linux",
								    "« &img=true » : télécharge la miniature si disponible",
								    "« ?manualDownload=true » : page de téléchargement de la dernière version de Dawnowl_Updater"
								)
							);
							$ls=array_slice(scandir($JSONdir), 2);
							$support["details"][3].=$support["details"][4][5]."» (si n'est pas défini API=0)";

							foreach ($ls as $value) {
								if(!array_key_exists("spaceName", json_decode(file_get_contents($JSONdir.$value), true))) {
									throw new Exception("Error detected in ".$value, 1);							
								}
								array_push($support["name"], json_decode(file_get_contents($JSONdir.$value), true)["name"]);
								$support["details"][2].=json_decode(file_get_contents($JSONdir.$value), true)["name"]." / ";
								array_push($support["spaceName"], json_decode(file_get_contents($JSONdir.$value), true)["spaceName"]);
							}
							$support["details"][2]=substr_replace($support["details"][2], "", -3);
							
							header("Content-Type: application/json");
							echo json_encode($support);
						}
						catch (Exception $e) {
							http_response_code(501);
							echo "<font color='red' size='7'>HTTP ERROR 501</font><br/><font color='orange' size='6'>".$e->getMessage()."</font>";
						}
					break;

					default:
						http_response_code(400);
						//header($_SERVER["SERVER_PROTOCOL"]." ".(400)." Unlisted Application");
						echo "<font color='red' size='7'>HTTP ERROR 400</font><br/><font color='orange' size='6'>Unlisted GET request. Please refer to the latest documentation of the API.</font>";
					break;
				}
			break;
			
			default:
				http_response_code(406);
				//header($_SERVER["SERVER_PROTOCOL"]." ".(406)." API version not avaible");
				echo "<font color='red' size='7'>HTTP ERROR 406</font><br/><font color='orange' size='6'>API version not avaible. Please refer to the latest documentation of the API.</font>";
			break;
		}
	}
	elseif (isset($_GET["manualDownload"])) {
		ob_start(); ?>
			<!DOCTYPE html>
			<html>
			    <head>
			        <link rel="icon" type="image/png" href="<?= $localAPI ?>request=Dawnowl_Updater&amp;img=true">
			        <meta charset="utf-8" />
			        <title>Téléchargement manuel Dawnowl_Updater</title>
                    <link rel="stylesheet" type="text/css" href="../public/css/style.css" />
			        <style type="text/css">
			        	body {
			        		background-color: rgb(45, 45, 45);
			        		color: white;
			        		text-align: center;
			        	}

			        	div#blocPage {
			        		display: flex;
			        		flex-direction: row;
			        		justify-content: space-around;
			        		height: 55em;
			        	}

			        	div#blocPage h1, div#OS {
			        		margin: auto;
			        		max-width: 15em;
			        	}

			        	a#download {
			        		display: flex;
			        		flex-direction: column;
			        		justify-content: center;
			        	}

			        	a#download img {
			        		margin: 1.5em auto 1.5em auto;

							transition-property: margin, padding;
							transition-duration: 0.5s;
							transition-timing-function: ease-in-out;
			        	}

			        	a#download img#downloadTop, img#downloadBottom {
			        		max-height: 20em;
			        		max-width: 20em;
			        	}

			        	a#download img#logo {
			        		max-height: 15em;
			        		max-width: 15em;
			        	}

			        	a#download:hover img#downloadTop {
			        		margin: 2.5em auto 0.5em auto;
			        	}

			        	a#download:hover img#downloadBottom {
			        		margin: 0em auto 0em auto;
			        	}

			        	a#download:hover img#logo {
			        		margin: 0.5em auto 0em auto;
			        	}

			        	div#OS {
			        		display: flex;
			        		flex-direction: column;
			        		justify-content: space-around;
			        		margin: auto;
			        	}

			        	div#OS figure, h3 {
			        		margin: auto;
			        		padding: 1em;
			        	}

			        	div#OS figure {
			        		cursor: pointer;
			        	}

			        	div#OS figure img {
			        		max-height: 15em;
			        		max-width: 15em;
			        	}

			        	div#OS figure:active {
			        		background-color: orange;
			        		border-radius: 0.5em;
			        	}
			        </style>
			    </head>
			    <body>
			    	<div id="blocPage">
				    	<div id="OS">
				    		<h3>OS disponibles : </h3>
				    		<figure onclick="document.getElementById('download').href='<?= $localAPI ?>request=Dawnowl_Updater&amp;download=win32';">
				    			<img src="../public/img/extensions/windows.png" alt="exe_extension_file_logo">
				    			<figcaption><h3>Téléchargement pour Windows</h3></figcaption>
				    		</figure>
				    		<figure onclick="document.getElementById('download').href='<?= $localAPI ?>request=Dawnowl_Updater&amp;download=linux';">
				    			<img src="../public/img/extensions/debian.png" alt="deb_extension_file_logo">
				    			<figcaption><h3>Téléchargement pour Debian/Ubuntu</h3></figcaption>
				    		</figure>
				    	</div>
				    	<a id="download" onclick="if (document.getElementById('download').href=='') alert('Veuiller selectionner un OS.');">
				    		<img id="downloadTop" src="../public/img/downloadPart1.png" alt="download_top">
					    	<img id="logo" src="<?= $localAPI ?>request=Dawnowl_Updater&amp;img=true" alt="Dawnowl_Updater_Logo">
					    	<img id="downloadBottom" src="../public/img/downloadPart2.png" alt="download_bottom">
					    </a>
				    	<h1 id="version">Téléchargement manuel de Dawnowl_Updater (utilitaire de mise à jour des DawnowlApps) version </h1>
				    </div>
			    </body>
			    <script type="text/javascript">
			        let xhr = new XMLHttpRequest();
			        xhr.timeout = 3000;
			        xhr.open("GET", "<?= $localAPI ?>request=Dawnowl_Updater");
			        xhr.addEventListener("readystatechange", function() {
			        	if (xhr.readyState === XMLHttpRequest.DONE && (xhr.status === 200)) {
			        		document.getElementById("version").textContent+=JSON.parse(xhr.responseText).version;
			        	}
			        	else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200) {
			        		alert("Une erreur est survenue durant Le téléchargement des détails !\nErreur : " + xhr.status + "\nDescription : " + xhr.statusText);
			        	}
			        });
			        xhr.send(null);
			    </script>
			</html>
		<?php
		$content = ob_get_clean();
		echo $content;
	}
	else {
		ob_start(); ?>
			<!DOCTYPE html>
			<html>
			    <head>
                    <link rel="stylesheet" type="text/css" href="../public/css/style.css" />
			        <style type="text/css">
			          body {
			          	background-color: rgb(45, 45, 45);
			          	color: white;
			          }
			          div#background {
			            opacity: 0.5;
			            position: fixed;
			            top: 50%; left: 50%;
			            transform: translate(-50%, -50%);
			            display: flex;
			            flex-direction: row;
			            justify-content: space-around;
			            margin: 1em;
			          }
			          img.turn {
			            z-index: 1;
			            height: 25em;
			            border-radius: 100%;
			            transform: rotate(0deg);
			            animation-name: infiniteTurn;
			            animation-duration: 5s;
			            animation-iteration-count: infinite;
			            animation-timing-function: linear;
			          }
			          @keyframes infiniteTurn {
			          	from {
			          		transform: rotate(0deg);
			          	}
			          	to {
			          		transform: rotate(360deg);
			          	}
			          }
			          div#blocPage {
			          	position: relative;
			            z-index: 2;
			            width: 100%;
			            font-weight: bold;
			          }
			          div#blocPage h1 {
			            font-size: 3em;
			            text-align: center;
			          }
			          div#blocPage ul li {
			          	font-size: 2.5em;
			          }
			          div#blocPage ul#importantList li {
			          	list-style-type: square;
			          }
			          div#blocPage ul#secondaryList li {
			          	list-style-type: disc;
			          }
			        </style>
			        <link rel="icon" type="image/png" href="../public/img/Logo.png">
			        <meta charset="utf-8" />
			        <title>AJAX API Documentation</title>
			    </head>
			    <body>
			      <div id="background">
			        <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg" alt="Javascript" class="turn">
			        <img src="../public/img/Logo.png" alt="Logo" class="turn">
			        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c9/JSON_vector_logo.svg" alt="JSON" class="turn">
			      </div>
			      <div id="blocPage">
			        <h1>API pouvant être utilisée avec la méthode de requête HTTP de type GET retournant les informations suivantes en fonction des paramètres : </h1>
			        <ul id="importantList">
			        	
			        </ul>
			        <ul id="secondaryList">
			        	
			        </ul>
			      </div>
			    </body>
			    <script type="text/javascript">
			        let xhr = new XMLHttpRequest();
			        xhr.timeout = 3000;
			        xhr.open("GET", "<?= $localAPI ?>request=support");
			        xhr.addEventListener("readystatechange", function() {
			        	if (xhr.readyState === XMLHttpRequest.DONE && (xhr.status === 200)) {
			        		let request = JSON.parse(xhr.responseText);
			        		for (let i = 0; i < request.details.length; i++) {
			        			document.getElementById("importantList").insertAdjacentHTML("beforeEnd", "<li>"+request.details[i]+"</li>");
			        		}
			        		for (let i = 0; i < request.otherDetails.length; i++) {
			        			document.getElementById("secondaryList").insertAdjacentHTML("beforeEnd", "<li>"+request.otherDetails[i]+"</li>");
			        		}
			        	}
			        	else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status != 200) {
			        		alert("Une erreur est survenue durant Le téléchargement des détails !\nErreur : " + xhr.status + "\nDescription : " + xhr.statusText);
			        	}
			        });
			        xhr.send(null);
			    </script>
			</html>
		<?php
		$content = ob_get_clean();
		echo $content;
	}
}
else {
	http_response_code(503);
	//header($_SERVER["SERVER_PROTOCOL"]." ".(503)." Le serveur est en maintenance");
	echo "<font color='red' size='7'>HTTP ERROR 503</font><br/><font color='orange' size='6'>Le serveur est en maintenance. Merci de votre compréhension.</font></br><a href='../index.php'><font size='10'>Détails à propos de la maintenance</font></a>";
}