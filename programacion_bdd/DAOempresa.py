import conectarBDD
import menu_global as filete

def insertar_cliente():
    conexion = conectarBDD.conectaBDD("empresa")
    cursor= conexion.cursor()
    nuevo_numdep= input("Escribe el numdep: ")
    nuevo_nombre= input("Escribe el nombre: ")


#COnsuta sql para insertar un nuevo cliente
    consulta="INSERT INTO departamento (numdep, nombredep) values (%s, %s)"
    cursor.execute(consulta,(nuevo_numdep, nuevo_nombre))
    conexion.commit()
    print("Nuevo cliente insertado")


    cursor.close()
    conexion.close()


def leer_datos():
    conexion = conectarBDD.conectaBDD("empresa")
    cursor = conexion.cursor()
    consulta = "SELECT * FROM departamento"


    # Ejecutar la consulta
    cursor.execute(consulta)




    # Obtener y mostrar los resultados
    resultados = cursor.fetchall()  # Obtiene todos los resultados de la consulta
    print("\nLista de departamentos:")
    for numdep,nombredep in resultados:
        print(f"Departamento: {numdep}  {nombredep}")




    # Cerrar el cursor y la conexión
    cursor.close()
    conexion.close()


def modificar_cliente():
    conexion = conectarBDD.conectaBDD("empresa")
    cursor= conexion.cursor()
    # Definir los nuevos datos
    numdep_existente = int(input("Escribe el numdep que deseas modificar: "))
    nuevo_dato= input("Introduce el nombre del departamento nuevo: ")


    # Consulta SQL para actualizar la cantidad
    consulta = "UPDATE departamento SET nombredep = %s WHERE numdep = %s"
    cursor.execute(consulta, (nuevo_dato,numdep_existente,))


    # Confirmar los cambios en la base de datos
    conexion.commit()
    print("Dato actualizado")


    cursor.close()
    conexion.close()
def eliminar_registro():
    conexion = conectarBDD.conectaBDD("empresa")
    cursor= conexion.cursor()
    numdep_eliminar= input("Escribe el numdep que deseas eliminar: ")


    # Consulta SQL para eliminar el cliente
    consulta = "DELETE FROM departamento WHERE numdep = (%s)"
    cursor.execute(consulta, (numdep_eliminar,))


    # Confirmar los cambios en la base de datos
    conexion.commit()
    print("Cliente eliminado correctamente")
    cursor.close()
    conexion.close()


def menu():
    while True:
        print("\n--- Menú: Tabla Departamento ---")
        print("1. Crear departamento")
        print("2. Leer departamentos")
        print("3. Actualizar departamento")
        print("4. Eliminar departamento")
        print("5. Salir")


        opcion = input("Escribe tu opción: ")
        if opcion == "1":
            insertar_cliente()
        elif opcion == "2":
            leer_datos()
        elif opcion == "3":
            modificar_cliente()
        elif opcion == "4":
            eliminar_registro()
        elif opcion == "5":
            print("Hasta luego")
            break
        else:
            print("Opción no válida")
