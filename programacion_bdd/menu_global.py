import DAOempresa as empresa
import DAOempresa2 as empresa_2

def menu_global():
    while True:
        print("\n--- Menú: Tabla global ---")
        print("1. Para usar la tabla departemento")
        print("2. Para usar la tabla cliente")
        print("3. Salir")


        opcion = input("Escribe tu opción: ")
        if opcion == "1":
            empresa.menu()
        elif opcion == "2":
            empresa_2.menu2()
        elif opcion == "3":
            print("Hasta luego")
            break
        else:
            print("Opción no válida")

