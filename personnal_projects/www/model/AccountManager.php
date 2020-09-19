<?php

namespace Projet\Model;

require_once("model/Manager.php");

class AccountManager extends Manager {

    public function deleteUser()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM users WHERE pseudo=:pseudo');
        $req->execute(array(
            'pseudo' => htmlspecialchars($_SESSION['pseudo'])
        ));
        if ($req==false) {
            throw new Exception("Le compte ".$_SESSION['pseudo']." n'a pas été correctement supprimé !");
        }
        else {
            $msg = "Le compte ".$_SESSION['pseudo']." a été supprimé.";
        }
        return $msg;
    }

    public function changeMail()
    {
        if ($_POST["mail"]==NULL) {
            $_POST["mail"]="N/A";
        }
        elseif (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST["mail"])!=true) {
            $_POST["mail"] = "! MAIL NON VALIDE !";
            logWarning("MAIL NON VALIDE");
        }
        else {
            # code...
        }
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET email=:mail WHERE pseudo=:pseudo');
        $req->execute(array(
            'mail' => htmlspecialchars($_POST["mail"]),
            'pseudo' => htmlspecialchars($_SESSION['pseudo'])
        ));
        if ($req==false) {
            $msg = "Il y a eu une erreur, votre mail n'a pas été changé...";
            logWarning("Il y a eu une erreur, votre mail n'a pas été changé...");
        }
        else {
            $msg = "Mail changé pour ".$_POST["mail"].".";
        }

        return $msg;
    }

    public function changeAvatar()
    {
        if (isset($_FILES["image"])&&preg_match("#\.jpg$|\.png$#i", $_FILES["image"]["name"])&&$_FILES['image']['size']<=1000000*2&&$_FILES['image']['size']!=0) {
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
            $msg = "L'image n'a pas pu être traitée. Vérifier le format (PNG ou JPG), que la taille soit en dessous de 2Mo ou la constitution de l'image.";
        }

        if (isset($_POST["color"])) {
            $colorString=$_POST["color"];
        }
        else {
            $colorString="#000000";
        }

        $c1="0x".$colorString[1].$colorString[2];
        $c2="0x".$colorString[3].$colorString[4];
        $c3="0x".$colorString[5].$colorString[6];
        $c1=intval($c1, 16);
        $c2=intval($c2, 16);
        $c3=intval($c3, 16);

        $color = imagecolorallocate($image, $c1, $c2, $c3);
        imagestring($image, 5, 10, 130, $_SESSION["pseudo"], $color);
        $avatar = imagepng($image, "public/img/users/".mb_strtoupper($_SESSION["pseudo"], 'UTF-8').".png");

        if (isset($msg)==false) {
            if ($avatar==false) {
                $msg = "Il y a eu une erreur, votre avatar est corrompue...";
                logWarning("Il y a eu une erreur, votre avatar est corrompue...");
            }
            else {
                $msg = "Votre avatar a été changé.";
            }
        }
        return $msg;
    }

	public function resetUsersImg() {
		$db = $this->dbConnect();
        $req = $db->query('SELECT pseudo FROM users');

        while ($pseudo = $req->fetch() ) {
            $source = imagecreatefrompng("public/img/default.png");
            $noir = imagecolorallocate($source, 0x00, 0x00, 0x00);
            imagestring($source, 5, 10, 130, $pseudo["pseudo"], $noir);
            imagepng($source, "public/img/users/".mb_strtoupper($pseudo["pseudo"], 'UTF-8').".png");
        }
        $req->closeCursor();
    }

    public function mail() {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT email FROM users WHERE pseudo=?');
        $req->execute(array($_SESSION["pseudo"]));
        $mail = $req->fetch();
        $req->closeCursor();
        $mail = $mail[0];

        return $mail;
    }
}