<?php

namespace Projet\Model;

require_once("model/Manager.php");

class ErrorManager extends Manager {
    public function resetErrors()
    {
        $db = $this->dbConnect();
        $errors = $db->query('DELETE FROM errorlogs');
        if ($errors==false) {
            $msg = "Les erreurs n'ont pas été correctement supprimées !";
        }
        else {
            $msg = "Les erreurs ont été supprimées.";
        }
        return $msg;
    }

    public function errors()
    {
        $db = $this->dbConnect();
        $errors = $db->query('SELECT pseudo, error, url FROM errorlogs');
        return $errors;
    }

    public function post($pseudo, $errorMessage, $url) {
    	$db = $this->dbConnect();
        $errorLogs = $db->prepare('INSERT INTO errorlogs(pseudo, error, url) VALUES(?, ?, ?)');
        
        if (isset($pseudo)) {
            $errorLogs->execute(array(htmlspecialchars($pseudo), htmlspecialchars($errorMessage), htmlspecialchars($url) ));
        }
        else {
            $errorLogs->execute(array("N/A", htmlspecialchars($errorMessage), htmlspecialchars($url) ));
        }
    }

    public function count() {
    	$db = $this->dbConnect();
        $reponse = $db->query('SELECT MIN(id) AS min FROM errorlogs');
        $donnees = $reponse->fetch();
        $min = $donnees[0];

        $reponse = $db->query('SELECT MAX(id) AS max FROM errorlogs');
        $donnees = $reponse->fetch();
        $max = $donnees[0];

		$reponse->closeCursor();

        if ($max-$min>=10) {
        	return true;
        }
        else {
        	return false;
        }
    }
}