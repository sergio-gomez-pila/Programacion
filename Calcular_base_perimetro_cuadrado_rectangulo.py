'''CUESTIÓN 1: Mostrar figuras por pantalla (2,5 puntos): a través de un menú solicitaremos al
usuario que tipo de figura quiere mostrar (1-Cuadrado|2-Rectángulo), si la opción no es
correcta, se mostrará mensaje de error y se volverá a solicitar hasta que se correcta. 
▪ Si ha seleccionada un cuadrado, pediremos su lado y mostraremos la figura, su área y
perímetro
▪ Si ha seleccionada un rectángulo, pediremos base y altura y mostraremos la figura, su área y
perímetro.
'''


#Declaramos la variable opciones.
opciones= ''
#Usamos el bucle while que se ejecutara hasta que el usuario elija la opcion de salir, dentro de este bucle, se le pide al usuario que elija una opcion.
while True:
    opciones = int(input("Introduce un numero dentro de las opciones: 1.Cuadrado  2.Rectangulo  3.Salir:   "))
#Si el usuario elige la opcion 1, se le pide que nos diga el lado del cuadrado, despue usamos un bucle for para dibujar el cuadrado con asteriscos. Las variables base y altura del cuadrado son iguales al valor del lado, despues el programa calcula y muestra el area y el perimetro del cuadrado.
    if opciones == 1:
        lado = int(input("Dime el lado del cuadrado: "))
        for altura in range(lado):
            print(" * " * lado)
        base = lado
        altura = lado  
#Si el usuario elige la opcion 2, se le pide que nos diga  la base y la altura del rectangulo, usamos el bucle for para dibujar el rectangulo con asteriscos. Luego calcula y muestra el area y el perimetro del rectangulo.
    elif opciones == 2:
        base = int(input("Dime la base del rectángulo: "))
        altura = int(input("Dime la altura del rectángulo: "))
        for i in range(altura):
            print(" * " * base)
#Si el usuario elige la opcion 3, el bucle se rompe usando el break
    elif opciones == 3:
        break
#Si el usuario introduce un numero distinto de 1, 2, 3, se le informa que la opcion es incorrecta y el bucle continua pidiendo una opcion valida.
    else:
        print(f"Opción incorrecta")
        continue
    print(f"Su area es {base * altura}")
    print(f"Su perimetro es {(base * 2) + (altura * 2)}")
print (f"Hata pronto")
