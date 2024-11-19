import mysql.connector


def conectaBDD(base_datos):
    # Establecer conexión con la base de datos
    conexion = mysql.connector.connect(
        host="localhost",       # Dirección del servidor (localhost para base de datos local)
        user="root",         # Usuario de la base de datos
        password="root",  # Contraseña del usuario
        database= base_datos  # Nombre de la base de datos
    )
    return conexion
