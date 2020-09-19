<?php

namespace Projet\Model;

require_once("model/Manager.php");

class ChatManager extends Manager {
    public function Post() {
        if (isset($_SESSION['pseudo'])&&isset($_POST['message'])) {
            if ($_SESSION['pseudo']!=null&&$_POST['message']!=null) {
                $db = $this->dbConnect();
                $req = $db->prepare('INSERT INTO minichat(pseudo, message, date_envoi) VALUES(:pseudo, :message, NOW())');
                $req->execute(array(
                    'pseudo' => htmlspecialchars($_SESSION['pseudo']),
                    'message' => htmlspecialchars($_POST['message']),
                ));
                return true;
            }
            else {
                return true;
            }
        }
        else {
            return false;
        }
    }

    public function Get($msg_debut, $msg_fin) {
        $db = $this->dbConnect();
        $contenu = $db->query('SELECT pseudo, message, DATE_FORMAT(date_envoi, "%d/%m/%Y %Hh%imin%ss") AS date_ordonne FROM minichat ORDER BY id DESC LIMIT '.$msg_debut.', '.$msg_fin.'');
        return $contenu;
    }
}