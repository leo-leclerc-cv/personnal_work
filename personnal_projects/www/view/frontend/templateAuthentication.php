<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="public/img/Logo.png">
        <title><?= $title ?></title>
        <link rel="stylesheet" type="text/css" href="public/css/style.css" />
        <link rel="stylesheet" type="text/css" href="public/css/<?= $css ?>.css" />
        <?php if (isset($Waitingcontent)) {
            ?>
                <link rel="stylesheet" type="text/css" href="public/css/waitingView.css" />
            <?php
        }?>
    </head>
        
    <body>
        <?= $content ?>
        <?php
            if (isset($Waitingcontent)) {
                echo($Waitingcontent);
            }
            if (isset($noMasterMenu)) {
                if ($noMasterMenu) {
                    # OK
                }
                else {
                    ?>
                        <h2 class="false">Something's wrong...<br>Please screenshot and report !</h2>
                        <a href="index.php?action=disconnect"><img src="public/img/Exit.png" alt="Déconnexion" class="Exit" style="background-color: purple;"></a>
                    <?php logWarning("templateAuthentication - Something's wrong....");
                }
            }
            elseif (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'connection':
                        ?><a href="index.php?action=disconnect"><img src="public/img/Exit.png" alt="Déconnexion" class="Exit"></a><?php
                    break;
                    
                    case 'accountPost':
                    case 'menu':
                        ?><a href="index.php?action=connection"><img src="public/img/Exit.png" alt="Déconnexion" class="Exit"></a><?php
                    break;

                    case 'accountCreate':
                        ?><a href="index.php?action=connection"><img src="public/img/Return.png" alt="Retourner en arrière" class="Exit"></a><?php
                    break;

                    case 'disconnect':
                            ?><h2 class="false">Something went very wrong...<br>Please screenshot and report !</h2><?php logWarning("templateAuthentication - Something went very wrong....");
                    break;

                    default:
                        ?>
                            <h2 class="false">$_GET['action'] not define.<br>Please screenshot and report !</h2>
                            <a href="index.php?action=disconnect"><img src="public/img/Exit.png" alt="Déconnexion" class="Exit" style="background-color: orange;"></a>
                        <?php
                    break;
                }
            }
            else {
                ?>
                    <h2 class="false">Fatal error.<br>Please screenshot and report !</h2>
                    <a href="index.php?action=disconnect"><img src="public/img/Exit.png" alt="Déconnexion" class="Exit" style="background-color: red;"></a>
                <?php logWarning("templateAuthentication - Fatal error....");
            }
            ?>
        <!--<a href="index.php?action=disconnect"><input id="deconnexion" type="button" value="Déconnexion" /></a>-->
        <script type="text/javascript" src="public/js/Nuit.js"></script>
        <script type="text/javascript" src="public/js/News.js"></script>
    </body>
</html>