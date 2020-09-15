import sys
sys.path.append("../")
import ui.play_display as play_display

def check_indice(plateau, indice):
	"""Retourne True si indice correspond à un indice de valide de case pour le plateau (entre 0 et n-1)"""
	if (indice<=plateau["n"]-1 and indice>=0):
		return True
	else:
		return False

def check_room(plateau, ligne, colonne):
	"""Retourne True si (ligne, collonne) est une case du plateau (ligne et colonnes sont de indices valides)"""

	if (check_indice(plateau, ligne) and check_indice(plateau, colonne)):
		return True
	else:
		return False

def get_value(plateau, ligne, colonne):
	"""Retourne la valeur de la case (ligne, colonne)
	Erreur si (ligne,colonne) n'est pas valide"""

	if not(check_room(plateau, ligne, colonne)):
		print("memory dump:")
		print(ligne)
		print(colonne)
		print(plateau)
		play_display.simple_display(plateau)
		assert False, "out of ligne ou colonne"

	ligneConvertitEnColonne=ligne*plateau["n"]

	return plateau["tiles"][ligneConvertitEnColonne+colonne]

def set_value(plateau, ligne, colonne, valeur):
	"""Affecte la valeur valeur dans la case (ligne, colonne) du plateau
	Erreur si (ligne, colonne) n'est pas une case valide
	ou si valeur n'est pas sup égal à 0
	Met à jour plateau.nbCaseLibres"""

	if not(check_room(plateau, ligne, colonne)):
		assert False, "(ligne, colonne) n'est pas une valide"

	if get_value(plateau, ligne, colonne)==0:
		plateau["nbCaseLibres"]-=1

	plateau["tiles"][ligne*plateau["n"]+colonne]=valeur

	return plateau

def is_room_empty(plateau, ligne, colonne):
	"""Teste si une case du plateau est libre ou pas
	return True si la case est libre sinon False"""

	if get_value(plateau, ligne, colonne)==0:
		return True
	else:
		return False

def get_nb_empty_rooms(plateau):
	"""Met à jour le dictionnaire plateau avec le nombre de case libre.s de plateau
	et renvoie le nb de case.s libre.s"""

	nbEmptyRooms=0
	
	for case in plateau["tiles"]:
		if case==0:
			nbEmptyRooms+=1

	return nbEmptyRooms

#Fin partie 1