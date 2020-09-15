#!/usr/bin/env python
# coding: utf-8

import tkinter as tk

def contenuChiffreCase (placement, case):
    """Renvoie le chiffre d'un nombre en fonction du placement donné"""
    division=10**placement
    entier=10**(placement-1)
    data = case%division
    data = data//entier

    return data  


def moveCharacter (characterNumber, characterLabel, key) :
    """Bouge un character donné d'une case dans la matrice en fonction de la touche appuyée et ajuste la partie graphique correspondante"""
    global matrice
    global pas
    global victory

    block=0
    #Le personnage n'est pas bloqué (rien n'empêche son déplacement)
    
    for xi in range(13) :
        for yi in range(13) :
            if matrice[yi][xi]==characterNumber :
                x=xi
                y=yi
    if victory==False :
        if contenuChiffreCase(4, matrice[y][x])==9 :
            matrice[y][x]=9000
        else :
            matrice[y][x]=1000
        #Cherche l'emplacement du character et le vide


    if (key=="Up" or key=="z") and y!=0 and contenuChiffreCase(3, matrice[y-1][x])==0 and contenuChiffreCase(1,matriceSpecial[y-1][x])!=5 :
        y-=1
    elif (key=="Down"or key=="s") and y!=12 and contenuChiffreCase(3, matrice[y+1][x])==0 and contenuChiffreCase(1,matriceSpecial[y+1][x])!=5 :
        y+=1
    elif (key=="Left"or key=="q") and x!=0 and contenuChiffreCase(3, matrice[y][x-1])==0 and contenuChiffreCase(1,matriceSpecial[y][x-1])!=5 :
        x-=1
    elif (key=="Right"or key=="d") and x!=12 and contenuChiffreCase(3, matrice[y][x+1])==0 and contenuChiffreCase(1,matriceSpecial[y][x+1])!=5 :
        x+=1
    elif key=="space" :
        x+=0
        y+=0
    else :
        block=1
        print("Le personnage est bloqué.")
    #Ajuste l'emplacement du character en fonction de la touche appuyée

    if victory==False :
        matrice[y][x]=characterNumber
        #Écrit la position du character déplacé dans la matrice
        characterLabel.place(x=10+(pas*x), y=10+(pas*y))
        #Translate la position du character déplacé dans la partie graphique
    
    return block

def move (e):
    """Appelle moveCharacter puis actualise le nombre de tour/points de mouvements/le tour du joueur/les témoins de mouvements pour le chatacter puis appelle keyPress()"""
    global matrice
    global pas
    global tour
    global j
    global characterPlaying
    global numberCharactersOnTheBoard
    global numberCharactersPlaying
    global ptsJ1
    global ptsJ2
    global movingPointsCharacterPlaying
    key=e.keysym

    

    for xi in range(13) :
        for yi in range(13) :
            if contenuChiffreCase(1,matrice[yi][xi])==characterPlaying :
                x=xi
                y=yi
                character=matrice[yi][xi]
    #Cherche l'id complet du character qui doit jouer

    if character==1121 :            
        block=moveCharacter(1121, label1121, key)
    elif character==1222 :            
        block=moveCharacter(1222, label1222, key)
    elif character==1133 :            
        block=moveCharacter(1133, label1133, key)
    elif character==1234 :            
        block=moveCharacter(1234, label1234, key)
    elif character==1125 :            
        block=moveCharacter(1125, label1125, key)
    elif character==1226 :            
        block=moveCharacter(1226, label1226, key)
    elif character==1137 :            
        block=moveCharacter(1137, label1137, key)
    elif character==1238 :            
        block=moveCharacter(1238, label1238, key)
    else :
        print("Out of characters !\nChanging playable character...")
        block=1
        character=1121
        #Actualise quel character doit jouer au nouveau tour
    #Bouge le character grâce à moveCharacter()

    
    if block!=1 and victory==False:
    #Si n'est pas bloqué -->

        jPlayed=contenuChiffreCase(3, character)
        if contenuChiffreCase(3, character)==1 :
            jEnnemy=contenuChiffreCase(3, character)+1
        else :
            jEnnemy=1

        for xi in range(13) :
            for yi in range(13) :
                charactersAround=0
                if contenuChiffreCase(3,matrice[yi][xi])==jEnnemy :
                    if yi!=12 :
                        if contenuChiffreCase(3,matrice[yi+1][xi])==jPlayed :
                            charactersAround+=1
                    if yi!=0 :
                        if contenuChiffreCase(3,matrice[yi-1][xi])==jPlayed :
                            charactersAround+=1
                    if xi!=12 :
                        if contenuChiffreCase(3,matrice[yi][xi+1])==jPlayed :
                            charactersAround+=1
                    if xi!=0 :
                        if contenuChiffreCase(3,matrice[yi][xi-1])==jPlayed :
                            charactersAround+=1

                    if charactersAround>=2 :
                        for xii in range(13) :
                            for yii in range(13) :
                                if contenuChiffreCase(2,matriceSpecial[yii][xii])==contenuChiffreCase(1,matrice[yi][xi]) :
                                    respawnAreaX=xii
                                    respawnAreaY=yii

                        if matrice[yi][xi]==1121 :            
                            label1121.place(x=10+(pas*respawnAreaX), y=10+(pas*respawnAreaY))
                        elif matrice[yi][xi]==1222 :            
                            label1222.place(x=10+(pas*respawnAreaX), y=10+(pas*respawnAreaY))
                        elif matrice[yi][xi]==1133 :            
                            label1133.place(x=10+(pas*respawnAreaX), y=10+(pas*respawnAreaY))
                        elif matrice[yi][xi]==1234 :            
                            label1234.place(x=10+(pas*respawnAreaX), y=10+(pas*respawnAreaY))
                        elif matrice[yi][xi]==1125 :            
                            label1125.place(x=10+(pas*respawnAreaX), y=10+(pas*respawnAreaY))
                        elif matrice[yi][xi]==1226 :            
                            label1226.place(x=10+(pas*respawnAreaX), y=10+(pas*respawnAreaY))
                        elif matrice[yi][xi]==1137 :            
                            label1137.place(x=10+(pas*respawnAreaX), y=10+(pas*respawnAreaY))
                        elif matrice[yi][xi]==1238 :            
                            label1238.place(x=10+(pas*respawnAreaX), y=10+(pas*respawnAreaY))
                        else :
                            print("Out of characters in the Respawn Area !")

                        matrice[respawnAreaY][respawnAreaX]=matrice[yi][xi]
                        matrice[yi][xi]=1000

                        #Écrit la position du character sur sa case de respawn dans la matrice, vide sa case précédemment occupée, ajuste la partie graphique
        #Cherche si un pion du joueur doit revenir au départ et le remet au départ si besoin est
        


        movingPointsCharacterPlaying-=1
        if movingPointsCharacterPlaying==0 :
            if j==1 :
                j+=1
            else :
                j=1
            can.itemconfigure(jStr, text="Tour de joueur•euse n°"+str(j))
            #Actualise qui doit jouer

        if movingPointsCharacterPlaying==0 :
            if contenuChiffreCase(1,character)<8 :
                characterTourNumberNext=contenuChiffreCase(1,character)+1
            else :
                characterTourNumberNext=1
            #Cherche le prochain character qui va jouer car le character précédent n'a plus de points de mouvements
        else :
            characterTourNumberNext=contenuChiffreCase(1,character)
        #Vérifie le nombres de points de jeu restant

        for xi in range(13) :
            for yi in range(13) :
                if contenuChiffreCase(1,matrice[yi][xi])==characterTourNumberNext :
                    xNext=xi
                    yNext=yi
                    xNextCharacter0=10+(pas*xi)
                    yNextCharacter0=10+(pas*yi)
                    xNextCharacter1=10+(pas*xi)+pas
                    yNextCharacter1=10+(pas*yi)+pas
                    nextCharacter=matrice[yi][xi]
        #Cherche l'emplacement du character qui jouera et tour suivant

        can.coords(graphicRectMoveTop, xNextCharacter0, yNextCharacter0-pas, xNextCharacter1, yNextCharacter1-pas)
        can.coords(graphicRectMoveBottom, xNextCharacter0, yNextCharacter0+pas, xNextCharacter1, yNextCharacter1+pas)
        can.coords(graphicRectMoveRight, xNextCharacter0+pas, yNextCharacter0, xNextCharacter1+pas, yNextCharacter1)
        can.coords(graphicRectMoveLeft, xNextCharacter0-pas, yNextCharacter0, xNextCharacter1-pas, yNextCharacter1)
        #Les indicateurs de déplacements sont translatés autour du character qui jouera au tour suivant

        can.itemconfigure(graphicRectMoveTop, fill="#2E8B57", outline="white")
        can.itemconfigure(graphicRectMoveBottom, fill="#2E8B57", outline="white")
        can.itemconfigure(graphicRectMoveRight, fill="#2E8B57", outline="white")
        can.itemconfigure(graphicRectMoveLeft, fill="#2E8B57", outline="white")
        #Réinitialisation des couleurs des indicateurs de déplacements


        if yNext==0 or contenuChiffreCase(3, matrice[yNext-1][xNext])!=0 or contenuChiffreCase(1,matriceSpecial[yNext-1][xNext])==5 :
            can.itemconfigure(graphicRectMoveTop, fill="", outline="")

        if yNext==12 or contenuChiffreCase(3, matrice[yNext+1][xNext])!=0 or contenuChiffreCase(1,matriceSpecial[yNext+1][xNext])==5 :
            can.itemconfigure(graphicRectMoveBottom, fill="", outline="")

        if xNext==12 or contenuChiffreCase(3, matrice[yNext][xNext+1])!=0 or contenuChiffreCase(1,matriceSpecial[yNext][xNext+1])==5 :
            can.itemconfigure(graphicRectMoveRight, fill="", outline="")

        if xNext==0 or contenuChiffreCase(3, matrice[yNext][xNext-1])!=0 or contenuChiffreCase(1,matriceSpecial[yNext][xNext-1])==5 :
            can.itemconfigure(graphicRectMoveLeft, fill="", outline="")
        #Désaffiche un/des indicateur.s de déplacements si il y a obstacle


        if contenuChiffreCase(3,matrice[6][6])==1 :
            ptsJ1+=1
            can.itemconfigure(j1Str, text="Joueur•euse n°1 : "+str(ptsJ1)+" pts")
        elif contenuChiffreCase(3,matrice[6][6])==2 :
            ptsJ2+=1
            can.itemconfigure(j2Str, text="Joueur•euse n°2 : "+str(ptsJ2)+" pts")
        #Actualise le nombre de points


        if numberCharactersPlaying<numberCharactersOnTheBoard :
            numberCharactersPlaying+=1
        else :
            numberCharactersPlaying=1
            tour+=1
            can.itemconfigure(tourStr, text="Tour n°"+str(tour))
        #Actualise le nombre de tours

        if movingPointsCharacterPlaying==0 :
            movingPointsCharacterPlaying=contenuChiffreCase(2,nextCharacter)
            if characterPlaying<8 :
                characterPlaying+=1
            else :
                characterPlaying=1
            #Actualise quel character doit jouer au nouveau tour
        can.itemconfigure(movingPointsCharacterPlayingStr, text=str(movingPointsCharacterPlaying)+" : point(s) de mouvement restant")
        
        #sleep()
        
        
    keyPress()


def keyPress () :
    """Attend un input sur les flèches du clavier et zqsd et appelle move()"""
    global pas
    global tour
    global ptsJ1
    global ptsJ2
    global victory

    if ptsJ1>=50 or ptsJ2>=50 :
        can.create_rectangle(l_can/2-100, h_can/2-50, l_can/2+100, h_can/2+50, fill="grey", outline="black")
        can.create_text(l_can/2, h_can/2, text="Joueur•euse n°"+str(j)+" a gagné•e !!!\nAu bout de "+str(tour)+" tours !", fill="white")
        label1121.place(x=10+(pas*12), y=10+(pas*7))
        label1222.place(x=10+(pas*0), y=10+(pas*7))
        label1133.place(x=10+(pas*12), y=10+(pas*3))
        label1234.place(x=10+(pas*0), y=10+(pas*3))
        label1125.place(x=10+(pas*12), y=10+(pas*5))
        label1226.place(x=10+(pas*0), y=10+(pas*5))
        label1137.place(x=10+(pas*12), y=10+(pas*9))
        label1238.place(x=10+(pas*0), y=10+(pas*9))
        can.itemconfigure(graphicRectMoveTop, fill="", outline="")
        can.itemconfigure(graphicRectMoveBottom, fill="", outline="")
        can.itemconfigure(graphicRectMoveRight, fill="", outline="")
        can.itemconfigure(graphicRectMoveLeft, fill="", outline="")
        victory=True
    else :
        fenet_graph.bind('<Up>', move)
        fenet_graph.bind('<Down>', move)
        fenet_graph.bind('<Left>', move)
        fenet_graph.bind('<Right>', move)
        fenet_graph.bind('<space>', move)
        fenet_graph.bind('<z>', move)
        fenet_graph.bind('<s>', move)
        fenet_graph.bind('<q>', move)
        fenet_graph.bind('<d>', move)
                                                
    #print(matrice)       
    #print("\n")                    
    #print(matriceSpecial)
    #print("\n")


def launchGame (event) :
    """Supprime le launcher, place les images des characters et lance keyPress()"""

    #can.delete(rectBgdLauncher)
    #can.delete(commands)
    labelLogo.place(x=0, y=-605)#label déplacé hors de vue
    #Launcher supprimé

    label1121.place(x=10+(pas*12), y=10+(pas*7))
    label1222.place(x=10+(pas*0), y=10+(pas*7))
    label1133.place(x=10+(pas*12), y=10+(pas*3))
    label1234.place(x=10+(pas*0), y=10+(pas*3))
    label1125.place(x=10+(pas*12), y=10+(pas*5))
    label1226.place(x=10+(pas*0), y=10+(pas*5))
    label1137.place(x=10+(pas*12), y=10+(pas*9))
    label1238.place(x=10+(pas*0), y=10+(pas*9))
    #Place les labels pour qu'il ne soient pas visibles pendant le launcher

    keyPress()



fenet_graph = tk.Tk()
fenet_graph.title("Project Board Battle Game (Working Title)")
fenet_graph.geometry()
can = tk.Canvas(fenet_graph, width = 600, height = 600, bg = '#483D8B')
can.pack()
#Création du Canvas


l_can = int(can['width'])
h_can = int(can['height'])
x1,y1 = 10,10
global pas
pas = (l_can-20)/13 # Espacement entre les lignes
#print(pas)

l1 = 13*pas # Longueur de la première ligne
x2 = x1+l1
y2 = y1
p1 = (x1,y1)
p2 = (x2,y1)
while y1<h_can:
    can.create_line(p1,p2, fill = '#ffffff',width = 1)
    y1 = y1+pas
    y2 = y1
    p1 = (x1,y1)
    p2 = (x2,y2)
#Lignes verticales tracées
x1,y1 = 10,10
y2 = y1+l1
x2 = x1
p1 = (x1,y1)
p2 = (x2,y2)
while x1<l_can:
    can.create_line(p1,p2, fill = '#ffffff',width = 1)
    x1 = x1+pas
    x2 = x1
    p1 = (x1,y1)
    p2 = (x2,y2)
#Lignes horizontales tracées
#Grille du plateau tracée


global tour  
tour=0
can.create_rectangle(l_can-80, 20, l_can, 0, fill="grey", outline="grey")
tourStr = can.create_text(l_can-40, 10, text="Tour n°"+str(tour) ,fill="white")
#Interface graphique : Témoin du nombre de tour, en haut à droite

global j
j=1
can.create_rectangle(0, 0, 140, 20, fill="grey", outline="grey")
jStr = can.create_text(70, 10, text="Tour de joueur•euse n°"+str(j) ,fill="white")
#Interface graphique : Témoin du tour du joueur, en haut à gauche

global ptsJ1
ptsJ1=0
can.create_rectangle(l_can-140, h_can-20, l_can, h_can, fill="grey", outline="grey")
j1Str = can.create_text(l_can-70, h_can-10, text="Joueur•euse n°1 : "+str(ptsJ1)+" pts" ,fill="white")
#Interface graphique : Témoin des pts de J1, en bas à gauche

global ptsJ2
ptsJ2=0
can.create_rectangle(0, h_can-20, 140, h_can, fill="grey", outline="grey")
j2Str = can.create_text(70, h_can-10, text="Joueur•euse n°2 : "+str(ptsJ2)+" pts" ,fill="white")
#Interface graphique : Témoin des pts de J2, en bas à droite


global matriceSpecial
matriceSpecial = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
for i in range(13) :
    matriceSpecial[i] = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]

for x in range(13):
    for y in range(13):
        matriceSpecial[y][x]=0
#Matrice pour les zones spécailes créée avec le nombre de collones et lignes correspondant au plateau

matriceSpecial[7][12]=15
matriceSpecial[7][0]=25
matriceSpecial[3][12]=35
matriceSpecial[3][0]=45
matriceSpecial[5][12]=55
matriceSpecial[5][0]=65
matriceSpecial[9][12]=75
matriceSpecial[9][0]=85
#où le character va réaparaitre lors de son élimination
#tour_du_pion=1,...,max_pions   magie=0(rien),5(respawn),9(magie)
#               2                           1

can.create_rectangle(10+(pas*12), 10+(pas*7), 10+(pas*13), 10+(pas*8), fill="#4169E1", outline="white")
can.create_rectangle(10+(pas*0), 10+(pas*7), 10+(pas*1), 10+(pas*8), fill="#4169E1", outline="white")
can.create_rectangle(10+(pas*12), 10+(pas*3), 10+(pas*13), 10+(pas*4), fill="#4169E1", outline="white")
can.create_rectangle(10+(pas*0), 10+(pas*3), 10+(pas*1), 10+(pas*4), fill="#4169E1", outline="white")
can.create_rectangle(10+(pas*12), 10+(pas*5), 10+(pas*13), 10+(pas*6), fill="#4169E1", outline="white")
can.create_rectangle(10+(pas*0), 10+(pas*5), 10+(pas*1), 10+(pas*6), fill="#4169E1", outline="white")
can.create_rectangle(10+(pas*12), 10+(pas*9), 10+(pas*13), 10+(pas*10), fill="#4169E1", outline="white")
can.create_rectangle(10+(pas*0), 10+(pas*9), 10+(pas*1), 10+(pas*10), fill="#4169E1", outline="white")
#Interface graphique : placement des indicateur pour savoir où le character va réaparaitre lors de son élimination



global matrice
matrice = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
for i in range(13) :
    matrice[i] = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    
for x in range(13):
    for y in range(13):
        matrice[y][x]=1000
#Matrice créée avec le nombre de collones et lignes correspondant au plateau

matrice[6][6]=9000
matriceSpecial[6][6]=9
graphicMagicCase = can.create_rectangle(10+(pas*6)+1, 10+(pas*6)+1, 10+(pas*7)-1, 10+(pas*7)-1, fill="red", outline="red")
#Case magique (fait gagner des pts)

#Différents pions/characters
matrice[7][12]=1121
matrice[7][0]=1222

matrice[3][12]=1133
matrice[3][0]=1234

matrice[5][12]=1125
matrice[5][0]=1226

matrice[9][12]=1137
matrice[9][0]=1238
#magie=1,9 joueur=0,1,2 spécificité_du_pion=0,1,2,3 tour_du_pion=1,...,max_pions
#4            3                2                      1

global movingPointsCharacterPlaying
movingPointsCharacterPlaying=contenuChiffreCase(2,matrice[7][12])
#points de mouvement de character 1121

can.create_rectangle(l_can/2-100, 0, l_can/2+100, 20, fill="grey", outline="grey")
movingPointsCharacterPlayingStr = can.create_text(l_can/2, 10, text=str(movingPointsCharacterPlaying)+" : point(s) de mouvement restant" ,fill="white")
#Interface graphique : Témoin des points de mouvement, en haut au milieu

  
img1121 = tk.PhotoImage(master=fenet_graph,file='IMG/Characters/Wizard1.png')
label1121 = tk.Label(fenet_graph, image=img1121)
label1121.pack
#Interface graphique : chargement du de l'image pour character 1121

img1222 = tk.PhotoImage(master=fenet_graph,file='IMG/Characters/Wizard2.png')
label1222 = tk.Label(fenet_graph, image=img1222)
label1222.pack
#Interface graphique : chargement du de l'image pour character 1222

img1133 = tk.PhotoImage(master=fenet_graph,file='IMG/Characters/Archer1.png')
label1133 = tk.Label(fenet_graph, image=img1133)
label1133.pack
#Interface graphique : chargement du de l'image pour character 1222

img1234 = tk.PhotoImage(master=fenet_graph,file='IMG/Characters/Archer2.png')
label1234 = tk.Label(fenet_graph, image=img1234)
label1234.pack
#Interface graphique : chargement du de l'image pour character 1234

img1125 = tk.PhotoImage(master=fenet_graph,file='IMG/Characters/Goblin1.png')
label1125 = tk.Label(fenet_graph, image=img1125)
label1125.pack
#Interface graphique : chargement du de l'image pour character 1125

img1226 = tk.PhotoImage(master=fenet_graph,file='IMG/Characters/Goblin2.png')
label1226 = tk.Label(fenet_graph, image=img1226)
label1226.pack
#Interface graphique : chargement du de l'image pour character 1226

img1137 = tk.PhotoImage(master=fenet_graph,file='IMG/Characters/Shovel_Knight1.png')
label1137 = tk.Label(fenet_graph, image=img1137)
label1137.pack
#Interface graphique : chargement du de l'image pour character 1137

img1238 = tk.PhotoImage(master=fenet_graph,file='IMG/Characters/Shovel_Knight2.png')
label1238 = tk.Label(fenet_graph, image=img1238)
label1238.pack
#Interface graphique : chargement du de l'image pour character 1238


graphicRectMoveRight = can.create_rectangle(10+(pas*13), 10+(pas*7), 10+(pas*14), 10+(pas*8), fill="", outline="")
graphicRectMoveLeft = can.create_rectangle(10+(pas*11), 10+(pas*7), 10+(pas*12), 10+(pas*8), fill="#2E8B57", outline="white")
graphicRectMoveTop = can.create_rectangle(10+(pas*12), 10+(pas*6), 10+(pas*13), 10+(pas*7), fill="#2E8B57", outline="white")
graphicRectMoveBottom = can.create_rectangle(10+(pas*12), 10+(pas*8), 10+(pas*13), 10+(pas*9), fill="#2E8B57", outline="white")
#Interface graphique : placement des indicateur pour savoir où le character va se déplacer

global characterPlaying
characterPlaying = 1
global numberCharactersOnTheBoard
global numberCharactersPlaying
numberCharactersOnTheBoard=8
numberCharactersPlaying=1
#Jeu chargé



#Launcher :

#rectBgdLauncher = can.create_rectangle(0, 0, l_can, h_can, fill="#483D8B", outline="#483D8B")
#commands = can.create_text(300, 350, text="Comment jouer :\n"
#    "- Rejoindre la zone rouge pour gagner des points\n"
#    "- Encercler un pion le fait disparaitre pendant 5 tours\n\n"
#    "Se déplacer : Flèches du clavier\n"
#    "Passer son tour : Espace\n\n"
#    "Commencer le jeu : Entrée"
#    ,fill="white")

imgLogo = tk.PhotoImage(master=fenet_graph,file='IMG/Logo_Full.png')
labelLogo = tk.Label(fenet_graph, image=imgLogo)
labelLogo.place(x=0, y=0)
labelLogo.pack

global victory
victory=False
fenet_graph.bind('<Return>', launchGame)
#Appuyer sur Entrée


fenet_graph.mainloop()