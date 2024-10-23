'''
CUESTION 3: Simular el funcionamiento de una cuenta bancaria (2.5 puntos): al iniciar el
programa, pediremos el saldo inicial de la cuenta (puede ser un número decimal), si el saldo es menor que 0 se volverá a pedir hasta que sea correcto. 
Posteriormente mostraremos un menú con las opciones, 1-ingresar dinero, 2-retirar dinero y
3- mostrar saldo y 4-salir, si la opción no es correcta se volver a pedir de nuevo hasta que seacorrecta. No se pueden ingresar cantidades negativas y no podemos retirar dinero si nos
quedamos en números rojos. 
Máxima puntuación (3 puntos): incluir una opción más en el menú, estadísticas, que nos
muestre cuantos ingresos y retiradas se han efectuado
'''
#Declaramos las variables saldo, opcion, contador_ingresos y contador_retiradas.
saldo = -10
opcion = 0
contador_ingresos = 0
contador_retiradas = 0
#Hacemos un bucle while que obliga al usuario a ingresar un saldo positivo, si el salda ingresado es negativo, seguira solicitando hasta que sea positivo.
while saldo < 0:
    saldo = float(input("Ingrese su saldo inicial: "))
#Luego hago otro bucle while para que me muestre las opciones, si el numero es distinto de 5 nos muestra otra vez el menu.
while opcion != 5:
    opcion = int(input("Elige una opción:\n1-ingresar dinero\n2-retirar dinero \n3-mostrar saldo\n4-estadísticas\n5-salir "))
#Hacemos un condicional para que el numero de las opciones este entre 0 y 5.
    if opcion > 0 and opcion <= 5:
#Despues usamos otro condicional para decirque que si opcion es igual a 1, hacemos un while donde pide al usuario que ingrese una cantidad de dinero, si la cantidad es valia, se suma a la variable saldo, si no es valida, muestra un mensaje de error.
        if opcion == 1:
            while True:
                ingresar_dinero = float(input("Introduce la cantidad de dinero que deseas ingresar: "))
                if ingresar_dinero < 0:
                    print(f"No puedes ingresar una cantidad negativa")
                else:
                    saldo = saldo + ingresar_dinero
                    print(f"Su saldo es de: {saldo} €")
                    contador_ingresos = contador_ingresos + 1
                    break
#En el siguiente condicional decimos que si opcion es igual a 2, hacemos un while si el valor es valido el programa resta la cantidad del saldo y aumenta el contador de retiradas. Si el saldo es incorrecto se le muestra un mensaje de error.
        elif opcion == 2:
            while True:
                retirar_dinero = float(input("Cuanto dinero deseas retirar: "))
                if retirar_dinero >= 0:
                    if retirar_dinero <= saldo:
                        print(f"Has retirado {retirar_dinero} €")
                        saldo= saldo - retirar_dinero
                        print(f"Su saldo actual es de {saldo} €")
                        contador_retiradas = contador_retiradas + 1
                        break
                    else:
                        print("No tienes suficiente saldo, ingrese mas dinero")
                else:
                    print("Cantidad de dinero no valida") 
#Aqui mostramos el saldo actual que tenemos en la cuenta.
        elif opcion == 3:
            print(f"Su saldo actual es de {saldo} €")
#Aqui muesta la cantidad de ingresos y retiradas que ha realizado el usuario, despues vuelve a mostrar el menu.
        elif opcion == 4:
            while True:
                print (f"Se han efectuado {contador_ingresos} ingresos ")
                print (f"Se han efectuado {contador_retiradas} retiradas ")
                opcion = int(input("Elige una opción:\n1-ingresar dinero\n2-retirar dinero \n3-mostrar saldo\n4-estadísticas\n5-salir "))
                break
#Si el usuario introduce el 5 sale del programa y se muestra un mensaje de hasta pronto.
        elif opcion == 5:
            print("Hasta pronto")
            break