<?php
$maintenanceFile = fopen('../Maintenance.txt', 'r');
$maintenance = fgets($maintenanceFile);
fclose($maintenanceFile);

if ($maintenance==1) {
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST");


    $countFile = fopen("Vyrus/count.json", 'r');
    $count = fgets($countFile);
    fclose($countFile);

    $usersFile = fopen("Vyrus/users.json", 'r');
    $users = fgets($usersFile);
    fclose($usersFile);

    $count=json_decode($count, true);
    $users=json_decode($users, true);


	if (isset($_GET["send"])) {
        switch ($_GET["send"]) {
            case 'img':
                if ($_FILES["screenshot"]['size']<=1000000*4&&$_FILES["screenshot"]["size"]!=0) {
                    imagepng(imagecreatefrompng($_FILES["screenshot"]["tmp_name"]), "Vyrus/".mb_strtoupper($count["users"], "UTF-8").".png");
                    $count["users"]+=1;

                    $count=json_encode($count);
                    $countFile = fopen("Vyrus/count.json", 'r+');
                    fputs($countFile, $count);
                    fclose($countFile);

                    if (isset($_POST["user"])) {
                        array_push($users["users"], $_POST["user"]);
                    }
                    else {
                        array_push($users["users"], "N/A");
                    }

                    $users=json_encode($users);
                    $usersFile = fopen("Vyrus/users.json", 'r+');
                    fputs($usersFile, $users);
                    fclose($usersFile);

                    echo "<font color='green' size='7'>UPLOAD FINISHED</font>";
                }
                else{
                    http_response_code(417);
                    echo "<font color='red' size='7'>PNG size exceeded (4Mo) or NULL</font>";
                    //DEBUG
                    ob_start();
                        echo "<h1>_FILES: <h1/>";
                        var_dump($_FILES);
                        echo "<h1>_POST: <h1/>";
                        var_dump($_POST);
                    $debugStr = ob_get_clean();
                    $debugFile = fopen("debug.html", 'r+');
                    fputs($debugFile, $debugStr);
                    //imagepng(imagecreatefromstring(base64_decode($_POST["screenshot"])), "DEBUG.png");
                    fclose($debugFile);
                }
            break;

            default:
                http_response_code(400);
                echo "<font color='red' size='7'>Unlisted GET send</font>";
            break;
        }
    }
    else{
        ob_start(); ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <link rel="stylesheet" type="text/css" href="../public/css/style.css" />
                    <style type="text/css">
                        body {
                            background-color: rgb(45, 45, 45);
                             color: white;
                         }
                         div#mosaic {
                            display: flex;
                            flex-wrap: wrap;
                            justify-content: space-around;
                        }
                        div#mosaic figure figcaption{
                            text-align: center;
                        }
                        div#mosaic figure img {
                            max-height: 500px;
                            max-width: 500px;
                            cursor: pointer;
                        }
                        div#viewer {
                            height: 100%;
                            width: 100%;
                            cursor: pointer;
                            display: none;
                        }
                        div#viewer img#image_viewer {
                            position: absolute;
                            top: 50%; left: 50%;
                            transform: translate(-50%, -50%);
                        }
                    </style>
                    <meta charset="utf-8" />
                    <title>Vyrus API</title>
                </head>
                <body>
                    <div id="mosaic">
                        <?php
                            for ($i=0; $i < $count["users"] ; $i++) { 
                            ?><figure>
                                <img src="Vyrus/<?= $i ?>.png" alt="N°<?= $i ?>"onclick="
                                    document.getElementById('image_viewer').src='Vyrus/<?= $i ?>.png';
                                    document.getElementById('viewer').style.display='block';
                                " />
                                <figcaption><?= $users["users"][$i] ?></figcaption>
                            </figure><?php
                            }
                        ?>
                    </div>
                    <div id="viewer" onclick="this.style.display='none';">
                        <img id="image_viewer" src="" alt="image_viewer" />
                    </div>

                </body>
            </html>
        <?php
        $content = ob_get_clean();
        echo $content;
    }
}
else {
    http_response_code(503);
    echo "<font color='red' size='7'>HTTP ERROR 503</font><br/><font color='orange' size='6'>Le serveur est en maintenance. Merci de votre compréhension.</font></br><a href='../index.php'><font size='10'>Détails à propos de la maintenance</font></a>";
}