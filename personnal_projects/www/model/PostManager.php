<?php

namespace Projet\Model;

require_once("model/Manager.php");

class PostManager extends Manager {
    public function Create() {

        if (isset($_POST['pseudo'])&&isset($_POST['password'])&&$_POST['pseudo']!=""&&$_POST['password']!=""&&$_POST['pseudo']!=NULL&&$_POST['password']!=NULL) {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT pseudo FROM users WHERE pseudo = ? ');
            $req->execute(array($_POST['pseudo']));
            $req = $req->fetchAll();
            if ($req==[]) {
                $duplicate=false;
            }
            else{
                $duplicate=$req[0]["pseudo"];
            }

            if ($duplicate) {
                $msg = "Ce pseudo est déjà utilisé.";
            } 
            else {
                if ($_POST["mail"]==NULL) {
                    $_POST["mail"]="N/A";
                }
                elseif (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST["mail"])!=true) {
                    $_POST["mail"] = "! MAIL NON VALIDE !";
                }
                else {
                    #mail is ok
                }
                if (isset($_FILES["image"])&&preg_match("#\.jpg$|\.png$#i", $_FILES["image"]["name"])&&$_FILES['image']['size']<=1000000*15&&$_FILES['image']['size']!=0) {
                    if (preg_match("#\.png$#i", $_FILES["image"]["name"])) {
                        $source = imagecreatefrompng($_FILES["image"]["tmp_name"]);
                    }
                    else {
                        $source = imagecreatefromjpeg($_FILES["image"]["tmp_name"]);
                    }
                    $image = imagecreatetruecolor(150, 150);

                    $largeur_source = imagesx($source);
                    $hauteur_source = imagesy($source);
                    $largeur_destination = imagesx($image);
                    $hauteur_destination = imagesy($image);

                    imagecopyresampled($image, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
                }
                else {
                    $image = imagecreatefrompng("public/img/default.png");
                }

                if ($_POST["color"]==NULL||$_POST["color"]=="") {
                    $colorString="#000000";
                }
                else {
                    $colorString=$_POST["color"];
                }

                $c1="0x".$colorString[1].$colorString[2];
                $c2="0x".$colorString[3].$colorString[4];
                $c3="0x".$colorString[5].$colorString[6];
                $c1=intval($c1, 16);
                $c2=intval($c2, 16);
                $c3=intval($c3, 16);

                $color = imagecolorallocate($image, $c1, $c2, $c3);
                imagestring($image, 5, 10, 130, $_POST["pseudo"], $color);
                imagepng($image, "public/img/users/".mb_strtoupper($_POST["pseudo"], 'UTF-8').".png");
                

                $user = $db->prepare('INSERT INTO users(pseudo, password, email, registration_date) VALUES(:pseudo, :password, :email, NOW())');
                $user->execute(array(
                    'pseudo' => htmlspecialchars($_POST['pseudo']),
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'email' => htmlspecialchars($_POST["mail"])
                ));

                if ($user==false) {
                    $msg = "Il y a eu une erreur, votre compte n'a pas été enregistré...";
                    logWarning("Il y a eu une erreur, votre compte n'a pas été enregistré...");
                }
                else {
                    $msg = $_POST['pseudo'] . " a été enregistré·e !";
                }
            }
        }
        else {
            $msg = "Aucune donnée envoyée !";  
        }

        return $msg;
    }
}