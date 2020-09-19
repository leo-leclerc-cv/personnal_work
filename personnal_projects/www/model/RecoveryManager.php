<?php

namespace Projet\Model;

require_once("model/Manager.php");

class RecoveryManager extends Manager {

	public function verifyAuthenticationPasswordAdmin($POST) {

        $isAuthenticationPasswordAdmin=0;

        if ($POST) {
            if (isset($_POST["authentication"])&&isset($_POST["pseudo"])&&isset($_POST["password"])&&$_POST["authentication"]!=null&&$_POST["pseudo"]!=null&&$_POST["password"]!=null) {
                $notEmpty=true;
            }
            else {
                $notEmpty=false;
                return 0;
            }
        }
        else {
            if (isset($_SESSION["authentication"])&&isset($_SESSION["pseudo"])&&isset($_SESSION["password"])&&$_SESSION["authentication"]!=null&&$_SESSION["pseudo"]!=null&&$_SESSION["password"]!=null) {
                $notEmpty=true;
            }
            else {
                $notEmpty=false;
                return 0;
            }
        }

        if ($notEmpty) {

            $db = $this->dbConnect();


            $request=null;
            $request=$db->query("SELECT `password` FROM `authentication_table`")->fetchAll();
            $request=$request[0][0];
            if ($POST) {
                $request = password_verify($_POST["authentication"], $request);
            }
            else {
                $request = password_verify($_SESSION["authentication"], $request);
            }

            if ($request) {
                $isAuthenticationPasswordAdmin++;
            }


            $request=null;
            $request = $db->prepare('SELECT password FROM users WHERE pseudo=?');
            if ($POST) {
                $request->execute(array($_POST["pseudo"]));
                $request=fetchOnce($request);
                $request=password_verify($_POST["password"], $request);
            }
            else {
                $request->execute(array($_SESSION["pseudo"]));
                $request=fetchOnce($request);
                $request=password_verify($_SESSION["password"], $request);
            }

            if ($request) {
                $isAuthenticationPasswordAdmin++;
            }


            $request=null;
            $request = $db->prepare('SELECT admin FROM users WHERE pseudo=?');
            if ($POST) {
                $request->execute(array($_POST["pseudo"]));
            }
            else {
                $request->execute(array($_SESSION["pseudo"]));
            }
            $request=fetchOnce($request);
            
            if ($request=="true") {
                $isAuthenticationPasswordAdmin++;
            }
            elseif ($request=="false"&&$isAuthenticationPasswordAdmin>=2) {
                $isAuthenticationPasswordAdmin="notAdmin";
            }
            elseif ($request=="false") {
            }
            else {
                $isAuthenticationPasswordAdmin="corrupt";
            }
        }
        return $isAuthenticationPasswordAdmin;
    }
}