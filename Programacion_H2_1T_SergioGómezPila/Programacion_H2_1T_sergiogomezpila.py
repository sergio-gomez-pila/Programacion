import random

# Iniciamos las listas y los diccionarios
usuarios = {"12345678A": "Juan", "23456789B": "Ana", "34567890C": "Luis"}
productos = [
    {"nombre": "telefono", "precio": 650},
    {"nombre": "tablet", "precio": 450},
    {"nombre": "cascos", "precio": 350},
    {"nombre": "teclado", "precio": 200},
    {"nombre": "raton", "precio": 120},
    {"nombre": "monitor", "precio": 25},
    {"nombre": "camara", "precio": 300},
    {"nombre": "muñeco", "precio": 70}
]
carrito = []
pedidos = {}

# Registro o inicio de sesión
def registrar_usuario():
    dni = input("Introduce tu DNI: ")
    if dni in usuarios:
        print(f"Bienvenido {usuarios[dni]}!")
        return dni
    else:
        nombre = input("No estás registrado. Introduce tu nombre: ")
        usuarios[dni] = nombre
        print(f"Usuario registrado: {dni} - {nombre}")
        return dni

# Función para mostrar los productos disponibles en la tienda, los productos estan almacenados en diccionario_productos.
def mostrar_productos():
    for p in productos:
        print(f"{p['nombre']} - {p['precio']}€")

#Función para añadir productos al carrito de compras, muestra todos los productos disponibles y solicita al usuario que ingrese el nombre del producto que desea comprar, añade el producto al lista_carrito si coincide con alguno de los nombres de los productos en diccionario_productos, el usuario escribe fin para salir de la funcion y terminar de comprar.
def añadir_al_carrito():
    while True:
        mostrar_productos()
        producto = input("Escribe el nombre del producto o 'fin' para terminar: ").lower()
        if producto == "fin":
            break
        for p in productos:
            if p["nombre"] == producto:
                carrito.append(p)
                print(f"{producto} añadido al carrito.")
                break
        else:
            print("Producto no encontrado.")

#Función para mostrar el contenido del carrito
def ver_carrito():
    if not carrito:
        print("El carrito está vacío.")
    else:
        total = sum(p["precio"] for p in carrito)
        print("Carrito actual:")
        for p in carrito:
            print(f"{p['nombre']} - {p['precio']}€") # Muestra los productos del carrito
        print(f"Total: {total}€") # Muestra el total de la compra

#Función para realizar la compra y generar un número de pedido
def realizar_compra(dni):
    if not carrito: # Si el carrito está vacío, no se puede realizar la compra
        print("El carrito está vacío. No se puede realizar la compra.")
        return
    numero = random.randint(1000, 9999)
    total = sum(p["precio"] for p in carrito)
    pedidos[numero] = {"cliente": usuarios[dni], "productos": [p["nombre"] for p in carrito], "total": total}
    print(f"Compra realizada con éxito. Número de pedido: {numero}")
    carrito.clear()

# Función para hacer seguimiento de un pedido a través del número de pedido, si el pedido existe en numero_seguimiento, muestra el nombre del cliente, los productos comprados y el total de la compra.
def seguimiento_pedido():
    numero = int(input("Introduce el número de pedido: "))
    if numero in pedidos:
        pedido = pedidos[numero]
        print(f"Pedido #{numero} - Cliente: {pedido['cliente']}")
        print("Productos:")
        for producto in pedido["productos"]:
            print(f"- {producto}")
        print(f"Total: {pedido['total']}€")
    else:
        print("Pedido no encontrado.")

# Ver clientes registrados
def ver_clientes():
    if not usuarios:
        print("No hay clientes registrados.")
    else:
        print("Clientes registrados:")
        for dni, nombre in usuarios.items():
            print(f"DNI: {dni}, Nombre: {nombre}")

# Menú principal, dependiendo de la opción seleccionada, se ejecuta una función diferente
def menu():
    dni = registrar_usuario()
    while True:
        print("\n1. Ver productos\n2. Añadir al carrito\n3. Ver carrito\n4. Realizar compra\n5. Seguimiento de pedido\n6. Ver clientes\n7. Salir")
        opcion = input("Selecciona una opción: ")
        if opcion == "1":
            mostrar_productos()
        elif opcion == "2":
            añadir_al_carrito()
        elif opcion == "3":
            ver_carrito()
        elif opcion == "4":
            realizar_compra(dni)
        elif opcion == "5":
            seguimiento_pedido()
        elif opcion == "6":
            ver_clientes()
        elif opcion == "7":
            print("Gracias por usar la tienda. ¡Hasta luego!")
            break
        else:
            print("Opción no válida.")
# Ejecutar el menú principal
menu()