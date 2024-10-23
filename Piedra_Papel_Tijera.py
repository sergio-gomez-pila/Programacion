'''
CUESTIÓN 2: Juego de piedra papel o tijera (2,5 puntos). El usuario introduce un valor (1-
Piedra|2- Papel|3-Tijera), si no es correcto se volver a pedir de nuevo hasta que se correcta.
La “maquina” generará un valor aleatorio (de 1 a 3) para elegir piedra, papel o tijera. Al
finalizar, mostrará la opción del usuario y de la máquina e indicará si hemos ganado, perdido o empatado. 
Máxima puntuación (3 puntos): el juego finalizará cuando la máquina o el usuario gane 3
partidas
'''
#Importamos la libreria random que nos permite genera numeros aleatorios y declaramos las variables y constantes.
import random
piedra = 1
papel = 2
tijera = 3
contador_maquina = 0
contador_usuario = 0
#Usamos el bucle while para que el bucle siga funcionando hasta que uno de los dos llegue a 3 victorias. En cada tirada la maquina elige un numero aleatorio del 1 al 3 y luego pide al usuario que elija su opción
while contador_maquina < 3 and contador_usuario < 3:
    numero_secretro = random.randint(1,3)
    numero = int(input("Usa el numero adecuado para elegir: 1.Piedra  2.Papel  3.Tijera:  "))
#Usando un condicional comprobamos los resultados y determinamos quien ha ganado o si han empatado, cada vez que la maquina gana se suma 1 al contador de la maquina, si el usuario pierde se le suma uno al contador del usuario, el primero que llega a 3 gana y finaliza el bucle
    if numero_secretro == 1 and numero == 1:
        print(f"La maquina ha elegido Piedra")
        print(f"El usuario ha elegido Piedra")
        print(f"Habéis empatado")
    elif numero_secretro == 1 and numero ==2:
        print(f"La maquina ha elegido Piedra")
        print(f"El usuario ha elegido Papel")
        print(f"Felicidades has ganado ")
        contador_usuario = contador_usuario + 1
        contador_maquina = contador_maquina
    elif numero_secretro == 1 and numero == 3:
        print(f"La maquina ha elegido Piedra")
        print(f"El usuario ha elegido Tijera")
        print(f"Has perdido ")
        contador_maquina = contador_maquina + 1
        contador_usuario = contador_usuario
    elif numero_secretro == 2 and numero ==1:
        print(f"La maquina ha elegido Papel")
        print(f"El jugador ha elegido Piedra ")
        print(f"Has perdido ")
        contador_maquina = contador_maquina + 1
        contador_usuario = contador_usuario
    elif numero_secretro == 2 and numero == 2:
        print(f"La maquina ha elegido Papel")
        print(f"El jugador ha elegido Papel ")
        print(f"Habéis empatado ")
    elif numero_secretro == 2 and numero == 3:
        print(f"La maquina ha elegido Papel")
        print(f"El jugador ha elegido Tijera ")
        print(f"Felicidades has ganado ")
        contador_usuario = contador_usuario + 1
        contador_maquina = contador_maquina
    elif numero_secretro == 3 and numero ==1:
        print(f"La maquina ha elegido Tijera")
        print(f"El usuario ha elegido Piedra ")
        print(f"Felicidades has ganado ")
        contador_usuario = contador_usuario + 1
        contador_maquina = contador_maquina
    elif numero_secretro == 3 and numero ==2:
        print(f"La maquina ha elegido Tijera")
        print(f"El usuario ha elegido Papel ")
        print(f"Has perdido ")
        contador_maquina = contador_maquina + 1
        contador_usuario = contador_usuario
    elif numero_secretro == 3 and numero ==3:
        print(f"La maquina ha elegio Tijera")
        print(f"El usuario ha elegido Tijera ")
        print(f"Habéis empatado ")
    else:
        print(f"Introduce un numero correcto")
        continue
if contador_maquina == 3:
    print(f"El que ha ganado la partida es la maquina ")
else:
    contador_usuario == 3
    print(f"El que ha ganado la partida es el usuario ")


