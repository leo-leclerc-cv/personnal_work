function boardBattleEngine (characterPlaying, key) {

    let block=false;
    //Le personnage n'est pas bloqué (rien n'empêche son déplacement)

    let matriceLength=matrice.length;
	for (var i = matriceLength - 1; i >= 0; i--) {
	    for (var j = matriceLength - 1; j >= 0; j--) {
	    	if (matrice[i][j][3]==String(characterPlaying)) {
	    		var line=i, collone=j;
	    		var characterID=matrice[line][collone];
	    	}
	    }
	}
	let characterCSS="X"+characterID[1]+characterID[2]+characterID[3];

	matrice[line][collone]=matrice[line][collone][0]+"000";
	//Cherche l'emplacement du character et le vide

	if (key=="Up" && line!=0) {
		if (Number(matrice[line-1][collone][1])==0 && Number(matrice[line-1][collone][0])!=5) {
			line--;
		}
		else {
	        block=true;
		}
	}
    else if (key=="Down" && line!=12) {
    	if (Number(matrice[line+1][collone][1])==0 && Number(matrice[line+1][collone][0])!=5) {
    		line++;
    	}
    	else {
	        block=true;
    	}
    }
    else if (key=="Left" && collone!=0) {
    	if (Number(matrice[line][collone-1][1])==0 && Number(matrice[line][collone-1][0])!=5) {
    		collone--;
    	}
    	else {
	        block=true;
    	}
    }
    else if (key=="Right" && collone!=12) {
    	if (Number(matrice[line][collone+1][1])==0 && Number(matrice[line][collone+1][0])!=5) {
    		collone++;
    	}
    	else {
	        block=true;
    	}
    }
    else if (key==" ") {
    }
    else {
        block=true;
    }
    //Ajuste l'emplacement du character en fonction de la touche appuyée


	matrice[line][collone]=matrice[line][collone][0]+characterID[1]+characterID[2]+characterID[3];
    //Écrit la position du character déplacé dans la matrice
    document.getElementById(characterCSS).style.left=pas*collone+"px";
    document.getElementById(characterCSS).style.top=pas*line+"px";
    //Translate la position du character déplacé dans la partie graphique


    if (block==false) {
    //Si n'est pas bloqué -->

        let charactersKilled= {
            ID: [],
            collone: [],
            line: []
        };

        for (var i = matriceLength - 1; i >= 0; i--) {
            for (var j = matriceLength - 1; j >= 0; j--) {
                let charactersAround=0;
                if (matrice[i][j][1]!="0") {

                    if (matrice[i][j][1]=="1") {
                        var oppositePlayer="2";
                    }
                    else {
                        var oppositePlayer="1";
                    }

                    if (i!=12) {
                        if (matrice[i+1][j][1]==oppositePlayer) {
                            charactersAround++;
                        }
                    }
                    if (i!=0) {
                        if (matrice[i-1][j][1]==oppositePlayer) {
                            charactersAround++;
                        }
                    }
                    if (j!=12) {
                        if (matrice[i][j+1][1]==oppositePlayer) {
                            charactersAround++;
                        }
                    }
                    if (j!=0) {
                        if (matrice[i][j-1][1]==oppositePlayer) {
                            charactersAround++;
                        }
                    }

                    if (charactersAround>=2) {
                        charactersKilled.ID.push(matrice[i][j]);
                        charactersKilled.line.push(i);
                        charactersKilled.collone.push(j);
                    }
                }
            }
        }
        //Cherche si un pion du joueur doit revenir au départ et le remet au départ si besoin est


        if (charactersKilled.ID.length!=0) {
            for (var i = charactersKilled.ID.length - 1; i >= 0; i--) {
                let characterKilled="X"+charactersKilled.ID[i][1]+charactersKilled.ID[i][2]+charactersKilled.ID[i][3];
                switch (charactersKilled.ID[i][3]) {
                    case "1":
                        document.getElementById(characterKilled).style.top=pas*7+"px";
                        document.getElementById(characterKilled).style.left=pas*12+"px";
                        matrice[7][12]="5"+characterKilled[1]+characterKilled[2]+characterKilled[3];
                    break;

                    case "2":
                        document.getElementById(characterKilled).style.top=pas*7+"px";
                        document.getElementById(characterKilled).style.left=pas*0+"px";
                        matrice[7][0]="5"+characterKilled[1]+characterKilled[2]+characterKilled[3];
                    break;

                    case "3":
                        document.getElementById(characterKilled).style.top=pas*3+"px";
                        document.getElementById(characterKilled).style.left=pas*12+"px";
                        matrice[3][12]="5"+characterKilled[1]+characterKilled[2]+characterKilled[3];
                    break;

                    case "4":
                        document.getElementById(characterKilled).style.top=pas*3+"px";
                        document.getElementById(characterKilled).style.left=pas*0+"px";
                        matrice[3][0]="5"+characterKilled[1]+characterKilled[2]+characterKilled[3];
                    break;

                    case "5":
                        document.getElementById(characterKilled).style.top=pas*5+"px";
                        document.getElementById(characterKilled).style.left=pas*12+"px";
                        matrice[5][12]="5"+characterKilled[1]+characterKilled[2]+characterKilled[3];
                    break;

                    case "6":
                        document.getElementById(characterKilled).style.top=pas*5+"px";
                        document.getElementById(characterKilled).style.left=pas*0+"px";
                        matrice[5][0]="5"+characterKilled[1]+characterKilled[2]+characterKilled[3];
                    break;

                    case "7":
                        document.getElementById(characterKilled).style.top=pas*9+"px";
                        document.getElementById(characterKilled).style.left=pas*12+"px";
                        matrice[9][12]="5"+characterKilled[1]+characterKilled[2]+characterKilled[3];
                    break;

                    case "8":
                        document.getElementById(characterKilled).style.top=pas*9+"px";
                        document.getElementById(characterKilled).style.left=pas*0+"px";
                        matrice[9][0]="5"+characterKilled[1]+characterKilled[2]+characterKilled[3];
                    break;

                    default:
                        console.warn(characterKilled+" is not part of the Respawn Area !");
                    break;
                }
                matrice[charactersKilled.line[i]][charactersKilled.collone[i]]=matrice[charactersKilled.line[i]][charactersKilled.collone[i]][0]+"000";
            }
        }
        //Ajuste la partie graphique, écrit la position du character sur sa case de respawn dans la matrice, vide sa case précédemment occupée


        movingPointsCharacterPlaying--;
        document.getElementById("moving_points").textContent=movingPointsCharacterPlaying;
        if (movingPointsCharacterPlaying==0) {
            let player=Number(document.getElementById("player_tour").textContent);
            if (player==1) {
                player++;
            }
            else {
                player=1;
            }
            document.getElementById("player_tour").textContent=player;
            //Actualise qui doit jouer
        }

        if (movingPointsCharacterPlaying==0) {
            if (Number(characterID[3])<8) {
                characterToPlayNextTour=Number(characterID[3])+1;
            }
            else {
                characterToPlayNextTour=1;
            }
            //Cherche le prochain character qui va jouer car le character précédent n'a plus de points de mouvements
        }
        else {
            characterToPlayNextTour=Number(characterID[3]);
        }
        //Vérifie le nombres de points de jeu restant



        for (var i = matriceLength - 1; i >= 0; i--) {
            for (var j = matriceLength - 1; j >= 0; j--) {
                if (Number(matrice[i][j][3])==characterToPlayNextTour) {
                    var lineNext=i, colloneNext=j, lineNextCharacter=pas*i, colloneNextCharacter=pas*j, nextCharacter=matrice[i][j];
                }
            }
        }
        //Cherche l'emplacement du character qui jouera et tour suivant

        document.getElementById("rectMoveTop").style.left=colloneNextCharacter+"px";
        document.getElementById("rectMoveTop").style.top=lineNextCharacter-pas+"px";
        document.getElementById("rectMoveBottom").style.left=colloneNextCharacter+"px";
        document.getElementById("rectMoveBottom").style.top=lineNextCharacter+pas+"px";
        document.getElementById("rectMoveRight").style.left=colloneNextCharacter+pas+"px";
        document.getElementById("rectMoveRight").style.top=lineNextCharacter+"px";
        document.getElementById("rectMoveLeft").style.left=colloneNextCharacter-pas+"px";
        document.getElementById("rectMoveLeft").style.top=lineNextCharacter+"px";
        //Les indicateurs de déplacements sont translatés autour du character qui jouera au tour suivant

        document.getElementById("rectMoveTop").style.display="block";
        document.getElementById("rectMoveBottom").style.display="block";
        document.getElementById("rectMoveRight").style.display="block";
        document.getElementById("rectMoveLeft").style.display="block";
        //Réinitialisation des couleurs des indicateurs de déplacements


        if (lineNext==0 || Number(matrice[lineNext-1][colloneNext][1])!=0 || Number(matrice[lineNext-1][colloneNext][0])==5) {
            document.getElementById("rectMoveTop").style.display="none";
        }

        if (lineNext==12 || Number(matrice[lineNext+1][colloneNext][1])!=0 || Number(matrice[lineNext+1][colloneNext][0])==5) {
            document.getElementById("rectMoveBottom").style.display="none";
        }

        if (colloneNext==12 || Number(matrice[lineNext][colloneNext+1][1])!=0 || Number(matrice[lineNext][colloneNext+1][0])==5) {
            document.getElementById("rectMoveRight").style.display="none";
        }

        if (colloneNext==0 || Number(matrice[lineNext][colloneNext-1][1])!=0 || Number(matrice[lineNext][colloneNext-1][0])==5) {
            document.getElementById("rectMoveLeft").style.display="none";
        }
        //Désaffiche un/des indicateur•s de déplacements si il y a obstacle


        if (Number(matrice[lineMagie][colloneMagie][0])==9&&Number(matrice[lineMagie][colloneMagie][1])==1&&Number(characterID[1])==1) {
            let ptsP1=Number(document.getElementById("points_P1").textContent);
            ptsP1++;
            document.getElementById("points_P1").textContent=ptsP1;
        }
        else if (Number(matrice[lineMagie][colloneMagie][0])==9&&Number(matrice[lineMagie][colloneMagie][1])==2&&Number(characterID[1])==2) {
            let ptsP2=Number(document.getElementById("points_P2").textContent);
            ptsP2++;
            document.getElementById("points_P2").textContent=ptsP2;
        }
        //Actualise le nombre de points
        //+1point pendant que l'équipe joue


        if (characterPlaying>=numberCharactersOnTheBoard&&movingPointsCharacterPlaying==0) {
            let tour=Number(document.getElementById("tour").textContent);
            tour++;
            document.getElementById("tour").textContent=tour;
        }
        //Actualise le nombre de tours


        if (movingPointsCharacterPlaying==0) {
            movingPointsCharacterPlaying=Number(nextCharacter[2]);
            if (characterPlaying<8) {
                characterPlaying++;
            }
            else {
                characterPlaying=1;
            }
            //Actualise quel character doit jouer au nouveau tour
            document.getElementById("moving_points").textContent=movingPointsCharacterPlaying;
        }
    }
    else {
    	bump++;
    	document.getElementById("info_container").insertAdjacentHTML("beforeEnd", '<audio autoplay id="bump_n°'+bump+'"><source src="public/sound/Bump.ogg" type="audio/ogg">Your browser does not support the audio tag.</audio>');
    	setTimeout(function(){ document.getElementById("info_container").removeChild(document.getElementById("bump_n°"+bump)); bump--; }, 1000);
    }
    return characterPlaying;
}

function resetPions(respawnPointOrNot) {
	if (respawnPointOrNot) {
		let pions=document.getElementsByClassName("pions");
		let respawnPoint=document.getElementsByClassName("respawnPoint");
		let ii=0;
		for (var i = 0; i < pions.length; i++) {
		    if (ii>pions.length/2-1) { ii=0; }

		    if (i<pions.length/2) {
		        pions[i].style.left=0+"px";
		        respawnPoint[i].style.left=0+"px";
		    }
		    else {
		        pions[i].style.left=(pas*12)+"px";
		        respawnPoint[i].style.left=(pas*12)+"px";
		    }

		    pions[i].style.top=pas*(ii*2)+pas*3+"px";
		    respawnPoint[i].style.top=pas*(ii*2)+pas*3+"px";

		    ii++;
		}
	}
	else {
		let pions=document.getElementsByClassName("pions");
		let ii=0;
		for (var i = 0; i < pions.length; i++) {
		    if (ii>pions.length/2-1) { ii=0; }

		    if (i<pions.length/2) {
		        pions[i].style.left=0+"px";
		    }
		    else {
		        pions[i].style.left=(pas*12)+"px";
		    }
		    pions[i].style.top=pas*(ii*2)+pas*3+"px";

		    ii++;
		}
	}
}




var pas=45;

resetPions(true);
//Interface graphique : placement des pions et des indicateurs de respawn


var matrice = [];
let matriceLength=13;
for(var i = matriceLength - 1; i >= 0; i--) {
   matrice[i] = [];
}
for (var i = matriceLength - 1; i >= 0; i--) {
    for (var j = matriceLength - 1; j >= 0; j--) {
        matrice[i][j]="1000";
    }
}
//Matrice créée avec le nombre de collones et lignes correspondant au plateau

/*
matrice[6][7]="1121";
matrice[7][7]="1133";
matrice[5][5]="1125";
matrice[7][6]="1222";
matrice[5][6]="1234";

matrice[7][12]="5020";
matrice[7][0]="5000";
matrice[3][12]="5000";
matrice[3][0]="5000";
matrice[5][12]="5000";
*/
// debug : élimination à plusieurs --> aller à gauche



matrice[7][12]="5121";
matrice[7][0]="5222";

matrice[3][12]="5133";
matrice[3][0]="5234";

matrice[5][12]="5125";
matrice[5][0]="5226";

matrice[9][12]="5137";
matrice[9][0]="5238";

matrice[6][6]="9000";
var lineMagie=6, colloneMagie=6;
document.getElementById("magie").style.left=6*pas+"px";
document.getElementById("magie").style.top=6*pas+"px";

//rien/respawn/magie=1,5,9 ; joueur=0,1,2 ; spécificité_du_pion=0,1,2,3 ; tour_du_pion=1,...,max_pions
//				0					1						2							3


var movingPointsCharacterPlaying=Number(matrice[7][12][2]);
var characterPlaying=1;
var numberCharactersOnTheBoard=8;
var victory=false;
var bump=0;

document.getElementById("rectMoveTop").style.top=7*pas-pas+"px";
document.getElementById("rectMoveTop").style.left=12*pas+"px";
document.getElementById("rectMoveBottom").style.top=7*pas+pas+"px";
document.getElementById("rectMoveBottom").style.left=12*pas+"px";
document.getElementById("rectMoveRight").style.top=7*pas+"px";
document.getElementById("rectMoveRight").style.left=12*pas+pas+"px";
document.getElementById("rectMoveLeft").style.top=7*pas+"px";
document.getElementById("rectMoveLeft").style.left=12*pas-pas+"px";
document.getElementById("rectMoveRight").style.display="none";

document.addEventListener("keydown", function (e) {
	if (victory==false) {
		switch (e.key.toUpperCase()) {
			case "Z":
			case "ARROWUP":
				characterPlaying=boardBattleEngine(characterPlaying, "Up");
			break;

			case "S":
			case "ARROWDOWN":
				characterPlaying=boardBattleEngine(characterPlaying, "Down");
			break;

			case "D":
			case "ARROWRIGHT":
				characterPlaying=boardBattleEngine(characterPlaying, "Right");
			break;

			case "Q":
			case "ARROWLEFT":
				characterPlaying=boardBattleEngine(characterPlaying, "Left");
			break;

			case " ":
				characterPlaying=boardBattleEngine(characterPlaying, " ");
			break;

			default:
			break;
		}
		if (Number(document.getElementById("points_P1").textContent)<=50&&Number(document.getElementById("points_P2").textContent)<=50) {
			victory=false;
		}
		else {
			victory=true;

			document.getElementById("rectMoveTop").style.display="none";
			document.getElementById("rectMoveBottom").style.display="none";
			document.getElementById("rectMoveRight").style.display="none";
			document.getElementById("rectMoveLeft").style.display="none";

			resetPions(false);

			document.getElementById("win_container").style.display="block";
			if (Number(document.getElementById("points_P1").textContent)>=50) {
				document.getElementById("winner").textContent=1;
			}
			else if (Number(document.getElementById("points_P2").textContent)>=50) {
				document.getElementById("winner").textContent=2;
			}
			else {
				document.getElementById("winner").textContent="cheater";
			}
			document.getElementById("tour_win").textContent=document.getElementById("tour").textContent;
			document.getElementById("info_container").style.display="none";

			document.getElementById("info_container").insertAdjacentHTML("beforeEnd", '<audio autoplay><source src="public/sound/Woah!.ogg" type="audio/ogg">Your browser does not support the audio tag.</audio>');
		}
	}
	else {
		console.log("On arrête de taper sur le clavier le jeu est fini !");
	}
});
// Contrôles clavier

document.getElementById("rectMoveTop").addEventListener("click", function () {
    characterPlaying=boardBattleEngine(characterPlaying, "Up");
});
document.getElementById("rectMoveBottom").addEventListener("click", function () {
    characterPlaying=boardBattleEngine(characterPlaying, "Down");
});
document.getElementById("rectMoveRight").addEventListener("click", function () {
    characterPlaying=boardBattleEngine(characterPlaying, "Right");
});
document.getElementById("rectMoveLeft").addEventListener("click", function () {
    characterPlaying=boardBattleEngine(characterPlaying, "Left");
});
document.getElementById("moving_points_container").addEventListener("click", function () {
    characterPlaying=boardBattleEngine(characterPlaying, " ");
});
// Contrôles tactile