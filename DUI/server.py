import socket

br_publique = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
br_publique.bind(('', 15555))  #ici on définit le port sur lequel le server va écouter: provoquera une erreur si le port n'est pas libre.

while True:
        br_publique.listen(5)

        br_client, address = br_publique.accept()
        print(address)

        response = br_client.recv(255) #j'accepte de lire jusqu'à 255 caractères
        if response != "":
                print(response.decode())

        print ("Close")
        br_client.close()
br_publique.close()
