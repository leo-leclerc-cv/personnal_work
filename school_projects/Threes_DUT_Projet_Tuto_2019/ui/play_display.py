#from termcolor import colored

def simple_display(plateau):
	"""Affichage du plateau de façon simplifié"""
	output=""
	for l in range(0, plateau["n"]):
		for c in range(0, plateau["n"]):
			output+=str("{:3}".format(plateau["tiles"][l*plateau["n"]+c]))+" "
		print(output)
		output=""

def medium_display(plateau):
	"""Affichage du plateau avec délimitation textuelles des cases"""
	delimitation="*"
	output=""
	hautBas=delimitation*(plateau["n"]*4+1)
	for l in range(0, plateau["n"]):
		print(hautBas)
		output+=delimitation
		for c in range(0, plateau["n"]):
			output+=str("{:3}".format(plateau["tiles"][l*plateau["n"]+c]))+delimitation
		print(output)
		output=""
	print(hautBas)

def full_display(plateau):
	"""Affichage en couleur"""
	delimitation="*"
	#delimitation=colored("*","white", "on_white")
	output=""
	hautBas=delimitation*(plateau["n"]*4+1)
	for l in range(0, plateau["n"]):
		print(hautBas)
		output+=delimitation
		for c in range(0, plateau["n"]):
			if plateau["tiles"][l*plateau["n"]+c]==0:
				output+=colored(str("{:3}".format(plateau["tiles"][l*plateau["n"]+c])),"white", "on_white", ["dark", "reverse"])+delimitation
			elif plateau["tiles"][l*plateau["n"]+c]==1:
				output+=colored(str("{:3}".format(plateau["tiles"][l*plateau["n"]+c])),"white", "on_blue")+delimitation
			elif plateau["tiles"][l*plateau["n"]+c]==2:
				output+=colored(str("{:3}".format(plateau["tiles"][l*plateau["n"]+c])),"white", "on_red")+delimitation
			else:
				output+=colored(str("{:3}".format(plateau["tiles"][l*plateau["n"]+c])),"white", "on_magenta")+delimitation
		print(output)
		output=""
	print(hautBas)

#Fin partie 1