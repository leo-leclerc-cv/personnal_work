<?php

namespace Projet\Model;

require_once("model/Manager.php");

class AdminManager extends Manager {

    public function verifyAdmin() {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT admin FROM users WHERE pseudo=?');
        $req->execute(array($_SESSION["pseudo"]));
        $result = $req->fetch();
        $req->closeCursor();

        if ($result["admin"]=="false") {
            $isAdmin=false;
        }
        elseif ($result["admin"]=="true") {
            $isAdmin=true;
        }
        else {
            throw new Exception("Admin value is not correctly set with ".$_SESSION["pseudo"]);
        }

        return $isAdmin;
    }
}