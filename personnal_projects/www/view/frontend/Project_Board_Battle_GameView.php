<?php
    $title = "Project Board Battle Game (still a working title)";
    $css = "Project_Board_Battle_Game"; 
    $icon = "Project_Board_Battle_Game.png";
?>

<?php ob_start(); ?>
        <?php require("Manager/PasswordManager.php"); ?>
        <div id="win_container">Joueur•euse n°<span id="winner">X</span> a gagné au bout de <span id="tour_win">X</span> tours !</div>
        <aside id="info_container">
            <p id="tour_container">Tour n°<span id="tour">1</span></p>
            <p id="player_tour_container">Tour de joueur•euse n°<span id="player_tour">1</span></p>
            <p id="points_P1_container">Joueur•euse n°1 : <span id="points_P1">0</span> points</p>
            <p id="points_P2_container">Joueur•euse n°2 : <span id="points_P2">0</span> points</p>
            <p id="moving_points_container"><span id="moving_points">2</span> point•s de mouvement</p>
        </aside>
        <div id="center">
            <div id="board">
                <table>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>

                <img class="pions" id="X234" alt="X234" src="public/img/Project_Board_Battle_Game/Characters/Archer2.png">
                <img class="pions" id="X226" alt="X226" src="public/img/Project_Board_Battle_Game/Characters/Goblin2.png">
                <img class="pions" id="X222" alt="X222" src="public/img/Project_Board_Battle_Game/Characters/Wizard2.png">
                <img class="pions" id="X238" alt="X238" src="public/img/Project_Board_Battle_Game/Characters/Shovel_Knight2.png"> 
                <img class="pions" id="X133" alt="X133" src="public/img/Project_Board_Battle_Game/Characters/Archer1.png">
                <img class="pions" id="X125" alt="X125" src="public/img/Project_Board_Battle_Game/Characters/Goblin1.png">
                <img class="pions" id="X121" alt="X121" src="public/img/Project_Board_Battle_Game/Characters/Wizard1.png">
                <img class="pions" id="X137" alt="X137" src="public/img/Project_Board_Battle_Game/Characters/Shovel_Knight1.png">

                <div class="mark" id="rectMoveTop" ></div>
                <div class="mark" id="rectMoveBottom" ></div>
                <div class="mark" id="rectMoveRight" ></div>
                <div class="mark" id="rectMoveLeft" ></div>

                <div id="magie" ></div>

                <div class="respawnPoint"></div>
                <div class="respawnPoint"></div>
                <div class="respawnPoint"></div>
                <div class="respawnPoint"></div>
                <div class="respawnPoint"></div>
                <div class="respawnPoint"></div>
                <div class="respawnPoint"></div>
                <div class="respawnPoint"></div>

            </div>
        </div>


        <script type="text/javascript" src="public/js/Project_Board_Battle_Game_Remake.js"></script>
        <script type="text/javascript" src="public/js/Nuit.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('templateMenu.php'); ?>