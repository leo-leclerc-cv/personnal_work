<?php

namespace Projet\Model;

require_once("model/Manager.php");

class warningManager extends Manager {
    public function resetwarnings()
    {
        $db = $this->dbConnect();
        $warnings = $db->query('DELETE FROM warninglogs');
        if ($warnings==false) {
            $msg = "Les alertes n'ont pas été correctement supprimées !";
        }
        else {
            $msg = "Les alertes ont été supprimées.";
        }
        return $msg;
    }

    public function warnings()
    {
        $db = $this->dbConnect();
        $min = $db->query('SELECT MIN(id) FROM warninglogs')->fetchAll();
        $min=$min[0][0];
        $max=$min+10;
        $warnings = $db->query('SELECT warning, pseudo, url, navigator FROM warninglogs ORDER BY id LIMIT '.$max);
        return $warnings;
    }

    public function post($pseudo, $warningMessage, $URL, $Navigator) {
    	$db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO `warninglogs` (`warning`, `pseudo`, `url`, `navigator`) VALUES (:warning, :pseudo, :url, :navigator)');
        $req->execute(array(
            'pseudo' => htmlspecialchars("pseudo"),
            'warning' => htmlspecialchars("warning"),
            'url' => htmlspecialchars("url"),
            'navigator' => htmlspecialchars("navigator")
        ));
    }
}