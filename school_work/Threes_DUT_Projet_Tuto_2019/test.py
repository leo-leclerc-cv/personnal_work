import game.play as play
import tiles.tiles_access as tiles_access
import tiles.tiles_moves as tiles_moves
import ui.play_display as play_display

p=play.init_play()

assert tiles_access.check_indice(p, 0), "Erreur lors d'un test de fonction"
assert not(tiles_access.check_indice(p, 10)), "Erreur lors d'un test de fonction"
assert tiles_access.check_indice(p, 3), "Erreur lors d'un test de fonction"
assert not(tiles_access.check_indice(p, 4)), "Erreur lors d'un test de fonction"
assert not(tiles_access.check_indice(p, -1)), "Erreur lors d'un test de fonction"

assert tiles_access.check_room(p, 2, 1), "Erreur lors d'un test de fonction"
assert not(tiles_access.check_room(p, 10, 2)), "Erreur lors d'un test de fonction"
assert not(tiles_access.check_room(p, -1, 3)), "Erreur lors d'un test de fonction"
assert tiles_access.check_room(p, 3, 3), "Erreur lors d'un test de fonction"

p["tiles"]=[
	6,2,3,2,
	0,2,6,2,
	0,2,2,0,
	1,0,0,0
]
assert tiles_access.get_value(p, 0, 0)==6, "Erreur lors d'un test de fonction"
assert tiles_access.get_value(p, 2, 3)==0, "Erreur lors d'un test de fonction"
assert tiles_access.get_value(p, 1, 3)==2, "Erreur lors d'un test de fonction"
assert tiles_access.get_value(p, 3, 0)==1, "Erreur lors d'un test de fonction"
#assert tiles_access.get_value(p, 18, 3), "Génère une erreur"

p=play.init_play()

assert tiles_access.set_value(p,0,0,1)["tiles"][0]==1, "Erreur lors d'un test de fonction"
assert tiles_access.set_value(p,1,2,0)["tiles"][1*p["n"]+2]==0, "Erreur lors d'un test de fonction"
#assert tiles_access.set_value(p,18,3,1), "Génère une erreur"
assert tiles_access.set_value(p,2,3,6)["tiles"][2*p["n"]+3]==6, "Erreur lors d'un test de fonction"

p["tiles"]=[
	0,2,0,0,
	0,1,0,0,
	0,0,0,0,
	0,0,0,0
]
assert tiles_access.is_room_empty(p, 0, 1)==False, "Erreur lors d'un test de fonction"
assert tiles_access.is_room_empty(p, 3, 2)==True, "Erreur lors d'un test de fonction"
#assert tiles_access.is_room_empty(p, 15, 2), "Génère une erreur"

assert tiles_access.get_nb_empty_rooms(p)==14, "Erreur lors d'un test de fonction"

p["tiles"]=[
	1,2,1,1,
	1,2,1,1,
	1,2,1,1,
	1,4,100,10
]
assert play.is_game_over(p)==True, "Erreur lors d'un test de fonction"
assert play.get_score(p)==130, "Erreur lors d'un test de fonction"
play_display.simple_display(p)
play_display.medium_display(p)
play_display.full_display(p)
print("Aucune erreur: Partie 1","\n")

#Fin partie 1

p["tiles"]=[
	0,2,0,0,
	0,2,3,3,
	0,2,2,2,
	0,0,0,1
]

play_display.simple_display(p)
print("")
tiles_moves.line_pack(p,1,0,1)
play_display.simple_display(p)
print("")
tiles_moves.line_pack(p,1,0,1)
play_display.simple_display(p)
print("line_pack fini\n")

play_display.simple_display(p)
print("")
tiles_moves.column_pack(p,3,0,1)
play_display.simple_display(p)
print("")
tiles_moves.column_pack(p,3,0,1)
play_display.simple_display(p)
print("column_pack fini\n")

p["tiles"]=[
	0,2,0,0,
	0,2,3,3,
	0,2,2,0,
	0,0,0,0
]
play_display.simple_display(p)
print("")
tiles_moves.line_move(p,1,1)
play_display.simple_display(p)
print("")
tiles_moves.line_move(p,1,0)
play_display.simple_display(p)
print("line_move fini\n")

play_display.simple_display(p)
print("")
tiles_moves.column_move(p,1,0)
play_display.simple_display(p)
print("")
tiles_moves.column_move(p,1,1)
play_display.simple_display(p)
print("column_move fini\n")

print("Aucune erreur: Partie 2","\n")

#Fin partie 2

print("Aucune erreur.","\n")