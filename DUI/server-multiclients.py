import socket
import os
import sys

br_publique = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
br_publique.bind(('', 15555))  #ici on définit le port sur lequel le server va écouter: provoquera une erreur si le port n'est pas libre.

while True:
        br_publique.listen(5)
        br_client, address = br_publique.accept()
        print(address)

        pid = os.fork()  #je me duplique
        if pid > 0:  # je suis le pere, et pid recoit le numéro de processus de mon fils.
                print("je suis le pere")
                br_client.close() #je ferme la boite privee
                # plus d'autre instructions, je vais remonter à accept() pour gerer un autre client
        else:  # pid == 0
                print("je suis le fils")
                br_publique.close() #je ferme la boite publique
                #je traite le client sur la boite privee
                response =""
                while response[:4] != "quit": #on ne garde que les 4 premiers caractères
                        response = br_client.recv(255) #j'accepte de lire jusqu'à 255 caractères
                        response = response.decode()
                        print(response.decode())
                #j'ai fini avec ce client, 
                print("close")
                br_client.close()
                #je m'auto tue
                sys.exit(0)  # j'ai fini de traiter mon client, je n'ai plus de raison de vivre, je quitte ce monde cruel
