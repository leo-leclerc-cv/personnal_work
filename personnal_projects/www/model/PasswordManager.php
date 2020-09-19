<?php

namespace Projet\Model;

require_once("model/Manager.php");

class PasswordManager extends Manager {

    public function verifyAuthentication($POST) {
        
        $db = $this->dbConnect();
        #$db->query("SELECT wrongcolumn FROM wrongtable")->fetch();
        $req = $db->query('SELECT `password` FROM `authentication_table`');
        $password = $req->fetch();
        $req->closeCursor();
        $password = $password[0];


        if ($POST) {
            $isAuthenticationCorrect = password_verify($_POST["authentication"], $password);
        }
        else {
            $isAuthenticationCorrect = password_verify($_SESSION["authentication"], $password);
        }

        return $isAuthenticationCorrect;
    }

    public function verifyPassword($POST) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT password FROM users WHERE pseudo=?');

        if ($POST) {
            $req->execute(array($_POST["pseudo"]));
        }
        else {
            $req->execute(array($_SESSION["pseudo"]));

        }

        $result = $req->fetch();
        $req->closeCursor();

        if ($POST) {
            $isPasswordCorrect = password_verify($_POST['password'], $result['password']);
        }
        else {
            $isPasswordCorrect = password_verify($_SESSION["password"], $result['password']);
        }

        return $isPasswordCorrect;
    }
}