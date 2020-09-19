<?php
$maintenanceFile = fopen('Maintenance.txt', 'r');
$maintenance = fgets($maintenanceFile);
fclose($maintenanceFile);

if ($maintenance==0) {

	session_start();
	try {

		require('controller/recoveryend.php');
		if (isset($_GET['action'])) {
			#Authentication management
			switch ($_GET['action']) {

				case 'connection':
					require("view/recoveryend/recoveryConnectionView.php");
				break;

				case 'post':
					$requestResult=connection(true);
					if ($requestResult[0]) {
						header("Location: recovery.php?action=view");
					}
					else {
						header("Location: recovery.php?action=connection&error=".$requestResult[1]);
					}
	        		
				break;

				case 'disconnect':
		        	session_destroy();
					require("view/recoveryend/recoveryConnectionView.php");
				break;
				
				default:
			        if (connection(false)[0]) {
			        	#Recovery management
			        	switch ($_GET['action']) {
			        		case 'view':
	        					$errors=errors();
	        					$warnings=warnings();
			        			require("view/recoveryend/recoveryModifyView.php");
			        		break;

			        		case 'confirm':
			        			if (isset($_GET['confirm'])) {
				        			switch ($_GET['confirm']) {
				        				case 'resetAvatar':
				        					$msg="Vous allez réinitialiser les avatars de tout les comptes.";
				        				break;

				        				case 'resetMaison':
				        					$msg="Vous allez réinitialiser les Menu Maisons de tout les comptes.";
				        				break;

				        				case 'createMaison':
				        					$msg="Vous allez créer les Menu Maisons de tout les comptes.";
				        				break;

				        				case 'reopen':
				        					$msg="Vous allez ré-ouvrir le site et mettre fin à la maintenance.";
				        				break;

				        				case 'resetErrors':
				        					$msg="Vous allez réinitialiser les erreurs du site.";
				        				break;

				        				case 'resetWarnings':
				        					$msg="Vous allez réinitialiser les alertes du site.";
				        				break;

				        				case 'closeSite':
									        $explanationFile = fopen('public/Explanations.txt', 'r+');
											ftruncate($explanationFile, 0);
									        fputs($explanationFile, htmlspecialchars($_POST["reason"])."\n");
									        fputs($explanationFile, htmlspecialchars($_POST["date"])."\n");
									        fputs($explanationFile, htmlspecialchars($_POST["hour"]));
									        fclose($explanationFile);
				        					$msg="Vous allez mettre à jour les données de fermeture du site.";
				        				break;
				        				
				        				default:
				        					throw new Exception("Error Processing Confirm Request");
				        				break;
				        			}
				        			require("view/recoveryend/confirmView.php");
				        		}
				        		else { throw new Exception("Error confirm not set"); }
			        		break;

			        		case 'confirmPost':
			        			if (isset($_GET['confirmPost'])) {
				        			switch ($_GET['confirmPost']) {
				        				case 'resetAvatar':
				        					$msg=resetUsers();
				        				break;

				        				case 'resetMaison':
				        					$msg=resetMaison();
				        				break;

				        				case 'createMaison':
				        					$msg=createMaisonAll();
				        				break;

				        				case 'reopen':
				        					$msg=reopen();
				        				break;

				        				case 'resetErrors':
				        					$msg=resetErrors();
				        				break;

				        				case 'resetWarnings':
				        					$msg=resetWarnings();
				        				break;

				        				case 'closeSite':
									        $maintenanceFile = fopen('Maintenance.txt', 'r+');
									        fputs($maintenanceFile, '0');
									        fclose($maintenanceFile);
				        					$msg="Informations mises à jour.";
				        				break;
				        				
				        				default:
				        					throw new Exception("Error Processing ConfirmPost Request");
				        				break;
				        			}
			        				require("view/recoveryend/confirmPostView.php");
			        			}
			        			else { throw new Exception("Error confirmPost not set"); }
			        		break;
			        		
			        		default:
			        			throw new Exception("Error Processing Action Request");
			        		break;
			        	}
			        }
				    else {
					    header("Location: recovery.php?action=connection&error=action_was_set_to_garbage");
				    }
			    break;
			}
		}
	    else {
	    	header("Location: recovery.php?action=connection");
	    }
	}
	catch(Exception $e) {
		session_destroy();
	    $error = $e->getMessage();
	    require("view/recoveryend/exceptionHandlerView.php");
	}
}
else {
	if ($maintenance==2) {
	    $error = "Le Recovery est en maintenance.<br>Merci de votre compréhension.";
	}
	else {
	    $error = "Le Recovery n'est pas disponible si le site est en ligne.";
	}
	require("view/recoveryend/exceptionHandlerView.php");
}