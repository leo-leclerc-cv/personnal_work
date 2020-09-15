import sys
sys.path.append("../")
import game.play as play
import ui.entries as entries
import ui.play_display as play_display
import tiles.tiles_moves as tiles_moves

def cycle_play(partie):
	"""Permet de jouer à Threes
	partie: partie de jeu en cours ou None sinon

	return True si la partie est terminée, False si menu demandé"""

	#print("partie:", type(partie))

	print("")

	if partie is None:
		assert True, "Aucune partie en cours"

	play_display.medium_display(partie["plateau"])

	print("Prochaine tuile de valeur:",partie["next_tile"]["tiles"][0]["valeur"],"\n")

	choix=entries.get_user_move()

	if choix=="m":
		entries.get_user_menu(partie)
		return False
	else:
		partie["plateau"]=tiles_moves.put_next_tiles(partie["plateau"], partie["next_tile"])
		partie["plateau"]=tiles_moves.play_move(partie["plateau"], choix)
		partie["next_tile"]=tiles_moves.get_next_alea_tiles(partie["plateau"], "encours")
		partie["score"]=play.get_score(partie["plateau"])

	if play.is_game_over(partie["plateau"]):
		print("Game Over !")
		print("Votre score est de:",partie["score"])
		return True

	cycle_play(partie)

	