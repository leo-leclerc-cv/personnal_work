from random import randint
import sys
sys.path.append("../")
import tiles.tiles_access as tiles_access
import game.play as play
baseTile=3

def get_next_alea_tiles(plateau, mode):
	"""Retourne une ou des tuile.s dont la position (ligne, colonne) est tirée au hasart
	et correspond à un emplacement libre du plateau """

	#print("alea:",plateau)
	
	check=not(play.is_game_over(plateau))

	if not(check):
		return {
			"mode": mode,
			"check": check
		}
	elif mode=="init":
		tiles=[
			{
				"valeur": 1,
				"ligne": randint(0, plateau["n"]-1),
				"colonne": randint(0, plateau["n"]-1)
			}
		]
		ligne=randint(0, plateau["n"]-1)
		colonne=randint(0, plateau["n"]-1)

		while not(ligne!=tiles[0]["ligne"] or colonne!=tiles[0]["colonne"]):
			ligne=randint(0, plateau["n"]-1)
			colonne=randint(0, plateau["n"]-1)

		tiles.append({"valeur": 2, "ligne": ligne, "colonne": colonne})

		return {
			"mode": mode,
			"tiles": tiles,
			"check": check
		}
	else: #encours
		ligne=randint(0, plateau["n"]-1)
		colonne=randint(0, plateau["n"]-1)
		empty=tiles_access.is_room_empty(plateau, ligne, colonne)

		while not(empty):
			ligne=randint(0, plateau["n"]-1)
			colonne=randint(0, plateau["n"]-1)
			empty=tiles_access.is_room_empty(plateau, ligne, colonne)

		return {
			"mode": mode,
			"tiles": [
				{"valeur": randint(1,3), "ligne": ligne, "colonne": colonne}
			],
			"check": check
		}

def put_next_tiles(plateau, tiles):
	"""Permet de placer une ou deux tuiles dans le plateau
	plateau: plateau de jeu
	tiles: renvoie de get_next_alea_tiles"""

	if tiles["check"]:
		for newTiles in tiles["tiles"]:
			plateau=tiles_access.set_value(plateau, newTiles["ligne"], newTiles["colonne"], newTiles["valeur"])
	else:
		assert True, "check: false"

	return plateau

def line_pack(plateau, num_lign, debut, sens):
	"""Tasse les tuiles d'une ligne dans un sens donné
	plateau: plateau de jeu
	num_lign: indice de la ligne à tasser
	debut: indice à partir duquel se fait le tassement
	sens: du tassement, 1 vers la gauche, 0 vers la droite"""

	if sens:
		i=debut
		while i<plateau["n"]-1:
			total=tiles_access.get_value(plateau, num_lign, i)+tiles_access.get_value(plateau, num_lign, i+1)
			if tiles_access.is_room_empty(plateau, num_lign, i):
				plateau=tiles_access.set_value(plateau, num_lign, i, tiles_access.get_value(plateau, num_lign, i+1))
				plateau=tiles_access.set_value(plateau, num_lign, i+1, 0)
			elif total%baseTile==0 and (total==baseTile or tiles_access.get_value(plateau, num_lign, i)==tiles_access.get_value(plateau, num_lign, i+1)):
				plateau=tiles_access.set_value(plateau, num_lign, i, total)
				plateau=tiles_access.set_value(plateau, num_lign, i+1, 0)
			i+=1
	else:
		i=debut
		while i>0:
			total=tiles_access.get_value(plateau, num_lign, i)+tiles_access.get_value(plateau, num_lign, i-1)
			if tiles_access.is_room_empty(plateau, num_lign, i):
				plateau=tiles_access.set_value(plateau, num_lign, i, tiles_access.get_value(plateau, num_lign, i-1))
				plateau=tiles_access.set_value(plateau, num_lign, i-1, 0)
			elif total%baseTile==0 and (total==baseTile or tiles_access.get_value(plateau, num_lign, i)==tiles_access.get_value(plateau, num_lign, i-1)):
				plateau=tiles_access.set_value(plateau, num_lign, i, total)
				plateau=tiles_access.set_value(plateau, num_lign, i-1, 0)
			i-=1

	plateau["nbCaseLibres"]=tiles_access.get_nb_empty_rooms(plateau)

	return plateau

def column_pack(plateau, num_col, debut, sens):
	"""Tasse les tuiles d'une colonne dans un sens donné
	plateau: plateau de jeu
	num_lign: indice de la colonne à tasser
	debut: indice à partir duquel se fait le tassement
	sens: du tassement, 1 vers le haut, 0 vers le bas"""

	#print("colonne n°:",num_col)

	if sens:
		i=debut
		while i<plateau["n"]-1:
			total=tiles_access.get_value(plateau, i, num_col)+tiles_access.get_value(plateau, i+1, num_col)
			if tiles_access.is_room_empty(plateau, i, num_col):
				#print("actuel:",tiles_access.get_value(plateau, i, num_col))
				#print("remplacer:",tiles_access.get_value(plateau, i+1, num_col))
				plateau=tiles_access.set_value(plateau, i, num_col, tiles_access.get_value(plateau, i+1, num_col))
				plateau=tiles_access.set_value(plateau, i+1, num_col, 0)
			elif total%baseTile==0 and (total==baseTile or tiles_access.get_value(plateau, i, num_col)==tiles_access.get_value(plateau, i+1, num_col)):
				plateau=tiles_access.set_value(plateau, i, num_col, total)
				plateau=tiles_access.set_value(plateau, i+1, num_col, 0)
			i+=1
	else:
		i=debut
		while i>0:
			total=tiles_access.get_value(plateau, i, num_col)+tiles_access.get_value(plateau, i-1, num_col)
			if tiles_access.is_room_empty(plateau, i, num_col):
				plateau=tiles_access.set_value(plateau, i, num_col, tiles_access.get_value(plateau, i-1, num_col))
				plateau=tiles_access.set_value(plateau, i-1, num_col, 0)
			elif total%baseTile==0 and (total==baseTile or tiles_access.get_value(plateau, i, num_col)==tiles_access.get_value(plateau, i-1, num_col)):
				plateau=tiles_access.set_value(plateau, i, num_col, total)
				plateau=tiles_access.set_value(plateau, i-1, num_col, 0)
			i-=1

	plateau["nbCaseLibres"]=tiles_access.get_nb_empty_rooms(plateau)

	return plateau

def line_move(plateau, num_lign, sens):
	"""Déplacement des tuiles d'une ligne donnée dans un sens donnée
	en appliquant les règles du jeu threes
	plateau: plateau de jeu
	num_lign: indice de la ligne pour laquelle il faut déplacer les tuiles
	sens: sens de déplacment des tuiles, 1 vers gauche, 0 vers droite"""

	if sens:
		for i in range(0, plateau["n"]):
			plateau=line_pack(plateau, num_lign, 0, sens)
	else:
		for i in range(0, plateau["n"]):
			plateau=line_pack(plateau, num_lign, plateau["n"]-1, sens)

	return plateau

def column_move(plateau, num_col, sens):
	"""Déplacement des tuiles d'une colonne donnée dans un sens donnée
	en appliquant les règles du jeu threes
	plateau: plateau de jeu
	num_col: indice de la colonne pour laquelle il faut déplacer les tuiles
	sens: sens de déplacment des tuiles, 1 vers haut, 0 vers bas"""

	if sens:
		for i in range(0, plateau["n"]):
			plateau=column_pack(plateau, num_col, 0, sens)
	else:
		for i in range(0, plateau["n"]):
			plateau=column_pack(plateau, num_col, plateau["n"]-1, sens)

	return plateau

def lines_move(plateau, sens):
	"""Deplace les tuiles de toutes les lignes du plateau
	dans un sens donné en aplliquant les règles du jeu Threes
	plateau: plateau de jeu
	sens: 1 gauche, 0 droite"""

	for i in range(0,plateau["n"]):
		plateau=line_move(plateau, i, sens)

	return plateau

def columns_move(plateau, sens):
	"""Deplace les tuiles de toutes les colonnes du plateau
	dans un sens donné en aplliquant les règles du jeu Threes
	plateau: plateau de jeu
	sens: 1 haut, 0 bas"""

	for i in range(0,plateau["n"]):
		plateau=column_move(plateau, i, sens)

	return plateau

def play_move(plateau, sens):
	"""Deplace les tuiles du plateau dans un sens donné en 
	appliquant les règles du jeu Threes
	plateau: plateau de jeu
	sens: sens de déplacement
		b: bas
		h: haut
		d: droite
		g: gauche"""

	if sens=="g":
		plateau=lines_move(plateau, 1)
	elif sens=="d":
		plateau=lines_move(plateau, 0)
	elif sens=="h":
		plateau=columns_move(plateau, 1)
	else:
		plateau=columns_move(plateau, 0)

	return plateau

#Fin partie 2