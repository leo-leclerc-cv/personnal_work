<?php

namespace Projet\Model;

require_once("model/Manager.php");

class MaisonManager extends Manager {

    public function deleteMaison() {

        $db = $this->dbConnect();
        $request = $db->prepare('DELETE FROM `maisonusers` WHERE pseudo=?');
        $request->execute(array($_SESSION["pseudo"]));

        return $request;
    }

    public function changeMaison() {
        $db = $this->dbConnect();

        $debug=0;
        $regex="";

        if (preg_match("#^[\w\sÂÊÎÔÛÄËÏÖÜÀÇÉÈÙŒéèàêâùïüëœçôö]{1,150}$#", $_POST["title"])) {
            # REGEX correct
        }
        else {
            $regex=$regex."<h1 class='false'>Le titre n'était pas correct !</h1>";
            $_POST["title"]="Default Title";
        }

        if (preg_match("#^[0-8]$#", $_POST["maisonid"])) {
            # REGEX correct
        }
        else {
            $regex=$regex."<h1 class='false'>Le numéro n'était pas correct !</h1>";
            $_POST["maisonid"]=0;
        }

        if (preg_match("#((^https?:\/\/)(w{3})?\.?)(\w+[\-\.]?)+(\.[a-z]{2,4})[\S]+(\.[a-z]{2,4})#", $_POST["image"])) {
            # REGEX correct
        }
        else {
            $regex=$regex."<h1 class='false'>Le lien de l'image n'était pas correct !</h1>";
            $_POST["image"]="public/img/extension/unknown.png";
        }

        if (preg_match("#((^https?:\/\/)(w{3})?\.?)(\w+[\-\.]?)+(\.[a-z]{2,4})#", $_POST["url"])) {
            # REGEX correct
        }
        else {
            $regex=$regex."<h1 class='false'>L'url n'était pas correct !</h1>";
            $_POST["url"]="index.php?action=download&download=../img/extensions/unknown.png";
        }

        $req = $db->prepare('UPDATE maisonusers SET image=:image, url=:url, title=:title WHERE user=:user AND maisonid=:maisonid');
        $req->execute(array(
            'image' => htmlspecialchars($_POST["image"]),
            'url' => htmlspecialchars($_POST["url"]),
            'title' => htmlspecialchars($_POST["title"]),
            'user' => htmlspecialchars($_SESSION["pseudo"]),
            'maisonid' => htmlspecialchars($_POST["maisonid"])
        ));

        if ($regex!="") {
            $regex=$regex."<h2 class='null'>Des éléments par défaut on été utilisés pour remplacer des éléments incorrects.</h2>";
            $regex=$regex."<h1 class='false'>L'élément n°".$_POST["maisonid"]." a rencontré des erreurs durant sa modification !</h1>";
        }
        elseif ($req==false) {
            $regex=$regex."<h1 class='false'>L'élément n°".$_POST["maisonid"]." n'a pas correctement été enregistré !</h1>";
            logWarning("L'élément n°".$_POST["maisonid"]." n'a pas correctement été enregistré !");
        }
        else {
            $regex=$regex."<h1 class='true'>L'élément n°".$_POST["maisonid"]." a correctement été enregistré.</h1>";
        }

        return $regex;
    }

    public function maison() {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT maisonid, image, url, title FROM maisonusers WHERE user=:user ORDER BY maisonid ASC');
        $req->execute(array( 'user' => $_SESSION["pseudo"] ));
        return $req;
    }

    public function defaultMaison() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT maisonid, image, url, title FROM maisondefault');
        return $req;
    }

    public function resetMaisonUser() {
        $db = $this->dbConnect();

        $debug=false;
        $failSafe="";
        $reqMaisonDefault = $db->query('SELECT maisonid, image, url, title FROM maisondefault ORDER BY maisonid DESC');
        while ($dataMaisonDefault = $reqMaisonDefault->fetch()) {
            $failSafe=+$dataMaisonDefault["maisonid"];
            $req = $db->prepare('UPDATE `maisonusers` SET image=:image, url=:url, title=:title WHERE user=:user AND maisonid=:maisonid ');
            $req->execute(array(
                'image' => $dataMaisonDefault["image"],
                'url' => $dataMaisonDefault["url"],
                'title' => $dataMaisonDefault["title"],
                'user' => $_SESSION["pseudo"],
                'maisonid' => $dataMaisonDefault["maisonid"]
            ));
            if ($req==false) {
                $debug=true;
            }
            else {}
        }

        if ($debug) {
            return 2;
        }
        elseif ($failSafe=="876543210") {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function resetMaison() {
        $db = $this->dbConnect();

        $reqUsers = $db->query('SELECT pseudo FROM users');
        $dataUsers = $reqUsers->fetchAll();

        for ($i=0; $i < sizeof($dataUsers); $i++) { 
            $reqMaisonDefault = $db->query('SELECT maisonid, image, url, title FROM maisondefault ORDER BY maisonid DESC');
            echo "<p class='DESC'>";
            while ($dataMaisonDefault = $reqMaisonDefault->fetch()) {
                echo $dataMaisonDefault["maisonid"];
                $req = $db->prepare('UPDATE `maisonusers` SET image=:image, url=:url, title=:title WHERE user=:user AND maisonid=:maisonid ');
                $req->execute(array(
                    'image' => $dataMaisonDefault["image"],
                    'url' => $dataMaisonDefault["url"],
                    'title' => $dataMaisonDefault["title"],
                    'user' => $dataUsers[$i]["pseudo"],
                    'maisonid' => $dataMaisonDefault["maisonid"]
                ));
            }
            $reqMaisonDefault->closeCursor();
            echo "</p>";
        }

        echo "<script type='text/javascript'>
            for (var i = 0 ; i < document.getElementsByClassName('DESC').length ; i++) {
                if (document.getElementsByClassName('DESC')[i].textContent='876543210') {
                    document.getElementsByClassName('DESC')[i].style.backgroundColor='green';
                }
                else {
                    document.getElementsByClassName('DESC')[i].style.backgroundColor='red';
                }
            }
        </script>";
    }

    public function createMaison() {

		$db = $this->dbConnect();

        $debug=false;

        $reqMaisonDefault = $db->query('SELECT maisonid, image, url, title FROM maisondefault ORDER BY maisonid DESC');
        while ($dataMaisonDefault = $reqMaisonDefault->fetch()) {
            $failSafe=+$dataMaisonDefault["maisonid"];
    		$req = $db->prepare('INSERT INTO `maisonusers` (`maisonid`, `user`, `image`, `url`, `title`) VALUES (:maisonid, :user, :image, :url, :title)');
	        $req->execute(array(
	            'maisonid' => $dataMaisonDefault["maisonid"],
	            'user' => htmlspecialchars($_POST['pseudo']),
	            'image' => $dataMaisonDefault["image"],
	            'url' => $dataMaisonDefault["url"],
	            'title' => $dataMaisonDefault["title"]
	        ));
	    }
	    $reqMaisonDefault->closeCursor();

        if ($debug) {
            return 2;
        }
        elseif ($failSafe=="876543210") {
            return 1;
        }
        else {
            return 0;
        }
    }


    public function createMaisonAll() {

        $db = $this->dbConnect();

        $reqUsers = $db->query('SELECT pseudo FROM users');
        $dataUsers = $reqUsers->fetchAll();

        for ($i=0; $i < sizeof($dataUsers); $i++) { 
            $reqMaisonDefault = $db->query('SELECT maisonid, image, url, title FROM maisondefault ORDER BY maisonid DESC');
            echo "<p class='DESC'>";
            while ($dataMaisonDefault = $reqMaisonDefault->fetch()) {
                echo $dataMaisonDefault["maisonid"];
                $req = $db->prepare('INSERT INTO `maisonusers` (`maisonid`, `user`, `image`, `url`, `title`) VALUES (:maisonid, :user, :image, :url, :title)');
                $req->execute(array(
                    'maisonid' => $dataMaisonDefault["maisonid"],
                    'user' => $dataUsers[$i]["pseudo"],
                    'image' => $dataMaisonDefault["image"],
                    'url' => $dataMaisonDefault["url"],
                    'title' => $dataMaisonDefault["title"]
                ));
            }
            $reqMaisonDefault->closeCursor();
            echo "</p>";
        }

        echo "<script type='text/javascript'>
            for (var i = 0 ; i < document.getElementsByClassName('DESC').length ; i++) {
                if (document.getElementsByClassName('DESC')[i].textContent='876543210') {
                    document.getElementsByClassName('DESC')[i].style.backgroundColor='green';
                }
                else {
                    document.getElementsByClassName('DESC')[i].style.backgroundColor='red';
                }
            }
        </script>";
    }
}