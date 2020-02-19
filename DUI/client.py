import socket

hote = "localhost" #machine hebergeant ip du server
port = 15555  #port du server

br_prive = socket.socket(socket.AF_INET, socket.SOCK_STREAM) #
br_prive.connect((hote, port))
print("Connection on {}".format(port))

msg = input("tapez votre message")
msg += "\n"
br_prive.send(msg.encode())

print("Close")
br_prive.close()

