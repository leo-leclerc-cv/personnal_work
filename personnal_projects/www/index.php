<?php
$maintenanceFile = fopen('Maintenance.txt', 'r');
$maintenance = fgets($maintenanceFile);
fclose($maintenanceFile);

if ($maintenance==1) {
	session_start();

	require('controller/frontend.php');
	ErrorCount();

	try {

		if (isset($_GET['action'])) {
			#Authentication management
	        if ($_GET['action'] == 'authenticationPost') {
	            authentication(true);
	        }
	        elseif ($_GET['action'] == 'disconnect') {
	        	require("view/frontend/authenticationView.php");
	        	session_destroy();
	        }
	        elseif (isset($_SESSION["authentication"])) {
	        	#Account management
	        	if (authentication(false)) {
		        	if ($_GET['action'] == 'connection') {
		        		require("view/frontend/accountConnectionView.php");
			        }
			        elseif ($_GET['action'] == 'accountCreate') {
			        	require("view/frontend/accountCreateView.php");
			        }
			        elseif ($_GET['action'] == 'accountCreatePost') {
			        	createAccount();
			        }
			        elseif ($_GET['action'] == 'accountPost') {
			        	connection(true);
			        }
			        elseif (isset($_SESSION["pseudo"])&&isset($_SESSION["password"])) {
			        	#Menu management
			        	if (connection(false)) {
			        		if (isset($_GET["menu"])) {
			        		#Menu strict management
				        		switch ($_GET["menu"]) {
				        			case 'chat':
				        				if (isset($_GET["page"])) {	chat($_GET["chat"], $_GET["page"]);	}
				        				else { chat($_GET["chat"], 0); }
				        			break;

				        			case 'account':
				        				account();
				        			break;
				        			
				        			case 'logs':
				        				require("view/frontend/logsView.php");
				        			break;
				        			
				        			case 'admin':
				        				if (admin()) {
				        					$errors=errors();
				        					$warnings=warnings();
				        					require("view/frontend/adminView.php");
				        				}
				        				else {
				        					require("view/frontend/notAdmin.php");
				        				}
				        			break;

				        			case 'rudolf':
				        				require("view/frontend/rudolfView.php");
				        			break;

				        			case 'maison':
				        				if (isset($_GET["maison"])) {
					        				switch ($_GET["maison"]) {
					        					case 'view':

					        					break;

					        					case 'change':
				        							$change=changeMaison();
				        							echo $change;
					        					break;
					        					
					        					default:
				        							header("Location: index.php?action=menu&menu=maison&maison=view");
					        					break;
					        				}
		        							$maison=maison();
		        							require("view/frontend/maisonView.php");
				        				}
				        				else {
				        					header("Location: index.php");
				        				}
				        			break;

				        			case 'Project_Board_Battle_Game':
				        				if (isset($_GET["Project_Board_Battle_Game"])) {
					        				switch ($_GET["Project_Board_Battle_Game"]) {
					        					case 'choice':
				        							require("view/frontend/Project_Board_Battle_Choice.php");
					        					break;

					        					case 'local':
				        							require("view/frontend/Project_Board_Battle_GameView.php");
					        					break;
					        					
					        					default:
				        							header("Location: index.php");
					        					break;
					        				}
				        				}
				        				else {
				        					header("Location: index.php");
				        				}
				        			break;

				        			case 'toolBox':
				        				require("view/frontend/toolBox.php");
				        			break;

				        			default:
				        				require "view/frontend/menuView.php";
				        			break;
				        		}
				        	}
				        	elseif (isset($_GET["action"])) {
			        		#Menu/action management
				        		switch ($_GET["action"]) {

				        			case 'modify':
					        		#Modify notAdmin
				        				if ($_GET["modify"]=="mail") {
				        					$AccountManager = new \Projet\Model\AccountManager();
				        					$mail = $AccountManager -> mail();
				        				}
				        				require "view/frontend/modifyView.php";
				        			break;

				        			case 'modifyPost':
				        			#ModifyPost notAdmin
				        				switch ($_GET["modify"]) {
				        					case 'mail':
				        						$msg=changeMail();
				        					break;
				        					
				        					case 'avatar':
				        						$msg=changeAvatar();
				        					break;

				        					default:
				        						header("Location: index.php?action=menu&menu=none&error=modify_was_set_to_".$_GET["modify"]."_in_modifyPost");
				        					break;
				        				}
				        				require("view/frontend/modifyPostView.php");
				        			break;

				        			case 'confirm':
				        			#Confirm management
					        			if (isset($_GET["admin"])&&$_GET["admin"]=="true"&&admin()) {
					        			#Confirm Admin
					        				switch ($_GET["confirm"]) {
						        				case 'resetAvatar':
						        					$msg="Vous allez réinitialiser les avatars de tout les comptes.";
						        				break;

						        				case 'closeSite':
						        					$msg="Vous allez fermer le site.";
											        $explanationFile = fopen('public/Explanations.txt', 'r+');
        											ftruncate($explanationFile, 0);
											        fputs($explanationFile, htmlspecialchars($_POST["reason"])."\n");
											        fputs($explanationFile, htmlspecialchars($_POST["date"])."\n");
											        fputs($explanationFile, htmlspecialchars($_POST["hour"]));
											        fclose($explanationFile);
						        				break;
						        				
						        				case 'resetErrors':
						        					$msg="Vous allez réinitialiser les erreurs.";
						        				break;

						        				case 'resetWarnings':
						        					$msg="Vous allez réinitialiser les alertes.";
						        				break;

						        				case 'resetMaison':
						        					$msg="Vous allez réinitialiser les Menus Maison de tout les utilisateurs•rices.";
						        				break;

					        					default:
				        							header("Location: index.php?action=menu&menu=none&error=confirm_was_set_to_".$_GET["confirm"]."_in_confirm_Admin");
					        					break;
					        				}
					        			}
					        			else {
					        			#Confirm notAdmin
						        			switch ($_GET["confirm"]) {
						        				case 'account':
						        					$msg="Vous allez supprimer votre compte.";
						        				break;

						        				case 'resetMaisonUser':
						        					$msg="Vous allez réinitialiser votre Menu Maison.<br>(Les titre, url et images des éléments retrouveront leurs valeurs par défaut)";
						        				break;
						        				
						        				default:
					        						header("Location: index.php?action=menu&menu=none&error=confirm_was_set_to_".$_GET["confirm"]."_in_confirm_notAdmin");
						        				break;
						        			}
						        		}
				        				require "view/frontend/confirmView.php";
				        			break;

				        			case 'confirmPost':
					        		#ConfirmPost
					        			if (isset($_GET["admin"])&&$_GET["admin"]=="true"&&admin()) {
					        			#ConfirmPost Admin
					        				switch ($_GET["confirm"]) {
						        				case 'resetAvatar':
						        					$msg=resetUsers();
						        				break;

						        				case 'closeSite':
											        $maintenanceFile = fopen('Maintenance.txt', 'r+');
											        fputs($maintenanceFile, '0');
											        fclose($maintenanceFile);
						        					$msg="<h1>Site fermé !</h1><h2>Vous allez être redirigé·e vers l'index de maintenance !</h2>";
						        				break;

						        				case 'resetErrors':
						        					$msg=resetErrors();
						        				break;

						        				case 'resetWarnings':
						        					$msg=resetWarnings();
						        				break;

							        			case 'resetMaison':
							        				$msg=resetMaison();
							        			break;

					        					default:
					        						header("Location: index.php?action=menu&menu=none&error=confirm_was_set_to_".$_GET["confirm"]."_in_confirmPost_admin");
					        					break;
					        				}
					        				require("view/frontend/confirmPostViewAdmin.php");
					        			}
						        		else {
					        			#ConfirmPost notAdmin
						        			switch ($_GET["confirm"]) {
						        				case 'account':
						        					$msg=deleteUser();
						        					session_destroy();
						        					$redirection="index.php";
						        					require("public/minimumRedirection.php");
						        				break;
						        				
							        			case 'resetMaisonUser':
							        				$msg=resetMaisonUser();
							        				$verslaPage = "Menu Maison";
							        				$urlRedirection = "index.php?action=menu&menu=maison&maison=view";
						        					require("view/frontend/confirmPostView.php");
							        			break;

						        				default:
						        					header("Location: index.php?action=menu&menu=none&error=confirm_was_set_to_".$_GET["confirm"]."_in_confirmPost_notAdmin");
						        				break;
						        			}
					        			}
				        			break;

			        				case 'download':
				        				require("view/frontend/downloadView.php");
				        			break;
				        			
				        			default:
				        				header("Location: index.php?action=menu&menu=none&error=action_was_set_to_".$_GET["action"]);
				        			break;
				        		}
				        	}
				        	else { header("Location: index.php?action=menu&menu=none&error=action_was_not_set"); }
			        	}
				    	else {
				    		throw new Exception("Connection erronée !!!");	    		
				    	}
			        }
			        else {
			        	require("view/frontend/accountConnectionView.php");
			        }
		    	}
		    	else {
		    		throw new Exception("Authentication erronée !!!");	    		
		    	}
	        }
		    else {
				if (isset($_SESSION["password"])&&connection(false)) {
				    header("Location: index.php?action=connection");
				}
				else {
			    	header("Location: index.php");
				}
		    }
	    }
	    else {
			if (isset($_SESSION["authentication"])&&authentication(false)) {
			    header("Location: index.php?action=menu&menu=menu");
			}
			else {
				require("view/frontend/authenticationView.php");
			}
	    }
	}
	catch(Exception $e) {
	    $errorMessage = $e->getMessage();
	    if (isset($_SESSION["pseudo"])) { $pseudo=$_SESSION["pseudo"]; }
	    else { $pseudo="Anonyme"; }
	    $url=$_SERVER["HTTP_REFERER"];
	    if (!isset($url)||$url=="") {
	    	$url="N/A";
	    }
	    logError($pseudo, $errorMessage, $url);
	    header('Location: public/ExceptionMessage.php?errorMessage='.$errorMessage);
	}
}
else {
	http_response_code(503);
	require("public/Maintenance.php");
}