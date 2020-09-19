<?php

require_once('model/RecoveryManager.php');
require_once('model/Functions.php');
require_once('model/ErrorManager.php');
require_once('model/WarningManager.php');
require_once('model/MaisonManager.php');
require_once('model/AccountManager.php');

function reopen() {
    $maintenanceFile = fopen('Maintenance.txt', 'r+');
    fputs($maintenanceFile, '1');
    fclose($maintenanceFile);
    $explanationFile = fopen('public/Explanations.txt', 'r+');
    ftruncate($explanationFile, 0);
    fputs($explanationFile, "Dummy : Explanation\n");
    fputs($explanationFile, "Dummy : Date\n");
    fputs($explanationFile, "Dummy : Hour");
    fclose($explanationFile);
    return("Le site est maintenant ré-ouvert");
}

function resetUsers() {
    $AccountManager = new \Projet\Model\AccountManager();
    $reset = $AccountManager->resetUsersImg();
    return "Les avatars ont été réinitialisés.";
}

function resetErrors() {    
    $ErrorManager = new \Projet\Model\ErrorManager();
    $resetErrors = $ErrorManager -> resetErrors();
    return $resetErrors;
}

function errors() {    
    $ErrorManager = new \Projet\Model\ErrorManager();
    $errors = $ErrorManager -> errors();
    return $errors;
}

function resetMaison() {
    $MaisonManager = new \Projet\Model\MaisonManager();
    $reset = $MaisonManager->resetMaison();
    return "Si toutes les barres sont vertes alors les Menu Maison ont été réinitialisés correctement.";
}

function createMaisonAll() {
    $MaisonManager = new \Projet\Model\MaisonManager();
    $create = $MaisonManager->createMaisonAll();
    return "Si toutes les barres sont vertes alors les Menu Maison ont été crées correctement.";
}

function warnings() {    
    $WarningManager = new \Projet\Model\WarningManager();
    $warnings = $WarningManager -> warnings();
    return $warnings;
}

function resetWarnings() {    
    $WarningManager = new \Projet\Model\WarningManager();
    $resetWarnings = $WarningManager -> resetWarnings();
    return $resetWarnings;
}

function connection($POST) {
    $RecoveryManager = new \Projet\Model\RecoveryManager();
    $isVerifyAuthenticationPasswordAdmin = $RecoveryManager -> verifyAuthenticationPasswordAdmin($POST);

    switch ($isVerifyAuthenticationPasswordAdmin) {
        case 3:
            if ($POST) {
                $_SESSION["authentication"]=$_POST["authentication"];
                $_SESSION["pseudo"]=$_POST["pseudo"];
                $_SESSION["password"]=$_POST["password"];
            }
            return [true,"Les données de connections sont valides."];
        break;

        case "notAdmin":
            return [false, "Vous n'êtes pas administrateur·rice."];
        break;

        case "corrupt":
            return [false, "La base de données est corrompue ! Veuillez immédiatement prévenir un·e administrateur·rice."];
        break;
        
        default:
            return [false, "Vos données de connection sont errronés."];
        break;
    }

    return [false, "Une erreur s'est produite veuillez réessayer ultérieurement."];
}

function admin() {
    $AdminManager = new \Projet\Model\AdminManager();
    $isAdmin = $AdminManager -> verifyAdmin();

    if ($isAdmin) {
        return true;
    }
    else {
        return false;
    }
}