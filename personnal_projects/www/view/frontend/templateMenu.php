<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="public/img/<?= $icon ?>">
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
                        <h2 class="false">Something's wrong....<br>Please screenshot and report !</h2>
                        <a href="index.php?action=menu&amp;menu=none"><img src="public/img/Menu.png" alt="Menu" class="Exit" style="background-color: purple;"></a>
                    <?php logWarning("templateMenu - Something's wrong....");
                }
            }
            elseif (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'menu':
                    case 'modify':
                    case 'download':
                        ?><a href="index.php?action=menu&amp;menu=none"><img src="public/img/Menu.png" alt="Menu" class="Exit"></a><?php
                    break;

                    default:
                        ?>
                            <h2 class="false">$_GET['action'] not define.<br>Please screenshot and report !</h2>
                            <a href="index.php?action=menu&amp;menu=none"><img src="public/img/Menu.png" alt="Menu" class="Exit" style="background-color: orange;"></a>
                        <?php
                    break;
                }
            }
            else {
                ?>
                    <h2 class="false">Fatal error.<br>Please screenshot and report !</h2>
                    <a href="index.php?action=menu&amp;menu=none"><img src="public/img/Menu.png" alt="Menu" class="Exit" style="background-color: red;"></a>
                <?php logWarning("templateMenu - Fatal error....");
            }
            ?>
        <!--<a href="index.php?action=menu&amp;menu=none"><input id="deconnexion" type="button" value="Menu" /></a>-->
        <script type="text/javascript" src="public/js/News.js"></script>        
    </body>
</html>