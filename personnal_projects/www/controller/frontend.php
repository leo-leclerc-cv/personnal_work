<?php

// Chargement des classes
require_once('model/WarningManager.php');
require_once('model/MaisonManager.php');
require_once('model/AdminManager.php');
require_once('model/PasswordManager.php');
require_once('model/PostManager.php');
require_once('model/ChatManager.php');
require_once('model/AccountManager.php');
require_once('model/ErrorManager.php');

function warnings() {    
    $WarningManager = new \Projet\Model\WarningManager();
    $warnings = $WarningManager -> warnings();
    return $warnings;
}

function logWarning($warningMessage) {
    if (isset($_SESSION["pseudo"])) { $pseudo=$_SESSION["pseudo"]; }
    else { $pseudo="Anonyme"; }
    $WarningManager = new \Projet\Model\WarningManager();
    $post = $WarningManager->post($pseudo, $warningMessage, $_SERVER["HTTP_REFERER"], $_SERVER["HTTP_USER_AGENT"]);
}

function resetWarnings() {    
    $WarningManager = new \Projet\Model\WarningManager();
    $resetWarnings = $WarningManager -> resetWarnings();
    return $resetWarnings;
}

function changeMaison() {    
    $MaisonManager = new \Projet\Model\MaisonManager();
    $changeMaison = $MaisonManager -> changeMaison();
    return $changeMaison;
}

function maison() {    
    $MaisonManager = new \Projet\Model\MaisonManager();
    $maison = $MaisonManager -> maison();
    return $maison;
}

function resetMaisonUser() {
    $MaisonManager = new \Projet\Model\MaisonManager();
    $reset = $MaisonManager->resetMaisonUser();

    if ($reset) {
        switch ($reset) {
            case 1:
                return "Une erreur a été détectée durant la réinitialisation de votre Menu Maison !";
                logWarning("Une erreur a été détectée durant la réinitialisation de votre Menu Maison !");
            break;

            case 2:
                return "Votre Menu Maison a été réinitialisé dans le mauvais ordre !<br>(erreur sans conséquences graves en théorie)";
            break;
            
            default:
                throw new Exception("resetMaisonUser_returned_unknown_error", 1);
            break;
        }
    }
    else {
        return "Votre Menu Maison a été réinitialisé.";
    }
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

function defaultMaison() {    
    $MaisonManager = new \Projet\Model\MaisonManager();
    $defaultMaison = $MaisonManager -> defaultMaison();
    return $defaultMaison;
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

function deleteUser() {
    $MaisonManager = new \Projet\Model\MaisonManager();
    $maison = $MaisonManager->deleteMaison();
    $AccountManager = new \Projet\Model\AccountManager();
    $msg = $AccountManager->deleteUser();
    return $msg;
}

function changeAvatar() {
    $AccountManager = new \Projet\Model\AccountManager();
    $msg = $AccountManager->changeAvatar();
    return $msg;
}

function changeMail() {
    $AccountManager = new \Projet\Model\AccountManager();
    $msg = $AccountManager->changeMail();
    return $msg;
}

function resetUsers() {
    $AccountManager = new \Projet\Model\AccountManager();
    $reset = $AccountManager->resetUsersImg();
    return "Les avatars ont été réinitialisés.";
}

function ErrorCount() {
    $ErrorManager = new \Projet\Model\ErrorManager();
    $over10 = $ErrorManager->count();

    if ($over10) {
        $maintenanceFile = fopen('Maintenance.txt', 'r+');
        fputs($maintenanceFile, '0');
        fclose($maintenanceFile);
        $explanationFile = fopen('public/Explanations.txt', 'r+');
        ftruncate($explanationFile, 0);
        fputs($explanationFile, "Une série d'erreurs successives ont entrainées la fermeture automatique du site.\n");
        fputs($explanationFile, "Le site doit être remis en ligne manuellement\n");
        fputs($explanationFile, "Veuillez contacter un·e administrateur·rice pour plus de détails");
        fclose($explanationFile);

        header("Location: index.php");
    }
}

function logError($pseudo, $errorMessage, $url) {
    $ErrorManager = new \Projet\Model\ErrorManager();
    $post = $ErrorManager->post($pseudo, $errorMessage, $url);
}

function account() {
    $AccountManager = new \Projet\Model\AccountManager();
    $mail = $AccountManager -> mail();
    $pseudo = $_SESSION["pseudo"];
    require("view/frontend/accountView.php");
}

function chat($action, $page) {
    $ChatManager = new \Projet\Model\ChatManager();

    if ($action=="view") {
        if ($page>=0) {
            $page_actuelle = (int) $page;
        }
        else {
            $page_actuelle = 0;
        }
        $msg_debut = 0+$page_actuelle*10;
        $msg_fin = 10+$page_actuelle*10;

        $messages = $ChatManager -> Get($msg_debut, $msg_fin);
        require("view/frontend/minichatView.php");
    }
    elseif ($action=="post") {
        $isPostOk = $ChatManager -> Post();
        if ($isPostOk) {
            header("Location: index.php?action=menu&menu=chat&chat=view");
        }
        else {
            throw new Exception("Notre serveur n'a pas pu envoyer ce message");  
        }
    }
    else {
        throw new Exception("Billet invalide : ".$action);
    }
}

function authentication($POST) {
    $PasswordManager = new \Projet\Model\PasswordManager();
    $isAuthenticationCorrect = $PasswordManager -> verifyAuthentication($POST);

    if ($isAuthenticationCorrect) {
        if ($POST) {
            $_SESSION["authentication"]=$_POST["authentication"];
            header("Location: index.php?action=connection");
        }
        else {
            return true;
        }
    }
    else {
        header("Location: index.php?authentication=false");
    }

    return false;
}

function connection($POST) {
    $PasswordManager = new \Projet\Model\PasswordManager();
    $isPasswordCorrect = $PasswordManager -> verifyPassword($POST);

    if ($isPasswordCorrect) {
        if ($POST) {
            $_SESSION["pseudo"]=$_POST["pseudo"];
            $_SESSION["password"]=$_POST["password"];
            require("view/frontend/menuView.php");
        }
        else {
            return true;
        }
    }
    else {
        header("Location: index.php?action=connection&fail=true");
    }
}

function createAccount() {
    $PostManager = new \Projet\Model\PostManager();
    $msg = $PostManager->Create();
    if ($msg==$_POST['pseudo']." a été enregistré·e !") {
        $MaisonManager = new \Projet\Model\MaisonManager();
        $maison = $MaisonManager->createMaison();
        switch ($maison) {
            
            case 0:
                //all fine value
            break;

            case 1:
                echo "<h1 class='false'>Une erreur a été détectée durant la création de votre Menu Maison !</h1>";
                logWarning("Une erreur a été détectée durant la création de votre Menu Maison !");
            break;

            case 2:
                echo "<h1 class='false'>Votre Menu Maison a été créé dans le mauvais ordre !<br>(erreur sans conséquences graves en théorie)</h1>";
            break;
            
            default:
                throw new Exception("createMaison_returned_unknown_error", 1);
            break;
        }
    }
    require('view/frontend/accountCreatePostView.php');
}