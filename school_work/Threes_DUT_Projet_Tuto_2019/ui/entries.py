import sys
sys.path.append("../")
import life_cycle.cycle_game as cycle_game
import game.play as play

def get_user_move():
	choix=""
	while choix=="":
		print("m: menu; h: haut; b: bas; d: droite; g: gauche")
		choix=input("Waiting input: ")

		if choix=="m" or choix=="M":
			choix="m"
		elif choix=="h" or choix=="H":
			choix="h"
		elif choix=="b" or choix=="B":
			choix="b"
		elif choix=="d" or choix=="D":
			choix="d"
		elif choix=="g" or choix=="G":
			choix="g"
		else:
			choix=""

	return choix

def get_user_menu(partie):
	choix=""
	while choix=="":
		print("\nN: Commencer une nouvelle partie; L: Charger une partie;")
		print("S: Sauvegarder la partie; C: reprendre la partie; Q: Terminer le jeu")
		choix=input("Waiting input: ")

		if choix=="N" or choix=="n":
			cycle_game.cycle_play(play.create_new_play())
			choix="N"
		elif choix=="L" or choix=="l":
			isPartie=play.restore_game()
			if not(isPartie):
				choix=""
			else:
				choix="L"
		elif choix=="S" or choix=="s":
			if partie is not(None):
				play.save_game(partie)
				choix="S"
			else:
				print("Aucune partie en cours !")
				choix=""
		elif choix=="C" or choix=="c":
			if partie is not(None):
				cycle_game.cycle_play(partie)
				choix="C"
			else:
				print("Aucune partie en cours !")
				choix=""
		elif choix=="Q" or choix=="q":
			return False
			choix="Q"
		else:
			choix=""

	return choix