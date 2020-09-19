<?php ob_start(); ?>
        <?php require("Manager/RecoveryManager.php"); ?>
        <style type="text/css">
            .flex {
                margin: 50px;
                display: flex;
                justify-content: space-around;
                flex-wrap: wrap;
            }


            .Y span, .N span {
                color: black;
            }

            .Y, .N {
                margin: 100px;
                padding: 25px;
                border-radius: 0.2em;
                font-size: 2em;
            }
            .Y {
                border-top: 2px solid LightCoral;
                border-left: 2px solid LightCoral;
                border-bottom: 2px solid Firebrick;
                border-right: 2px solid Firebrick;
                background-color: Crimson;
            }
            .Y:hover {  background-color: Red; }

            .N {
                border-top: 2px solid Lime;
                border-left: 2px solid Lime;
                border-bottom: 2px solid LimeGreen;
                border-right: 2px solid LimeGreen;
                background-color: LawnGreen;
            }
            .N:hover { background-color: SpringGreen; }

        </style>
        <h1 style="text-align: center;"><?= $msg ?></h1>
        <h1 style="text-align: center;">Êtes vous sûr·e ?</h1>
        <div class="flex">
            <a href="recovery.php?action=confirmPost&amp;confirmPost=<?= $_GET['confirm'] ?>"
            class="Y"><span>Oui</span></a>
            <a href="recovery.php?action=view" class="N"><span>Non</span></a>
        </div>
<?php $content = ob_get_clean(); ?>

<?php require('templateRecovery.php'); ?>