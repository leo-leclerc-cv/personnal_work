import sys
import json
import os.path
sys.path.append("../")
import tiles.tiles_access as tiles_access
import tiles.tiles_moves as tiles_moves
import life_cycle.cycle_game as cycle_game


def init_play():
	"""Retourne un plateau correspondant à une nouvelle partie
	Une nouvelle partie est un dictionnaire avec les clefs et valeurs suivantes:
	n=4 taille de la grille n*n
	nbCaseLibres=16 au départ
	tiles= tableau de 4*4 init à 0"""

	return {
		"n": 4,
		"nbCaseLibres": 16,
		"tiles": [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
		}

def is_game_over(plateau):
	"""Retourne True si la partie est terminée, False sinon"""
	if tiles_access.get_nb_empty_rooms(plateau)==0:
		return True
	else:
		return False

def get_score(plateau):
	"""Retourne le score du plateau"""
	total=0
	for case in plateau["tiles"]:
		total+=case
	return total

#Fin partie 1

def create_new_play():
	"""Créer et retourne une nouvelle partie"""
	plateau=init_play()
	firstTiles=tiles_moves.get_next_alea_tiles(plateau, "init")
	plateau=tiles_moves.put_next_tiles(plateau, firstTiles)

	return {
		"plateau": plateau,
		"next_tile": tiles_moves.get_next_alea_tiles(plateau, "encours"),
		"score": get_score(plateau)
	}

def save_game(partie):
	"""Sauvegarde une partie dans le fichier saved_game.json"""

	game_saved = open ("./game_saved.json","w")

	json.dump(partie, game_saved)

	game_saved.close()

	print("Votre partie a été sauvegardée !")

def restore_game():
	if not(os.path.isfile("./game_saved.json")) :
		print("Aucune partie trouvée !")
		return False
	else:
		game_saved = open ("./game_saved.json","r")
		strjson=game_saved.read()
		game_saved.close()
		partie = json.loads(strjson)
		#print(partie)
		print("Votre partie a été restorée !")
		cycle_game.cycle_play(partie)