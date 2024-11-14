import random
# Definición de la lista de usuarios y productos
# Diccionario de usuarios, con el DNI como clave y el nombre como valor.
lista_usuarios = {
    "12345678A": "Juan",
    "23456789B": "Ana",
    "34567890C": "Luis"
}
# Lista de productos disponibles en la tienda, cada uno con un nombre y un precio
diccionario_productos = [
{"nombre":"telefono","precio": 650},
{"nombre":"tablet","precio": 450},
{"nombre":"cascos","precio": 350},
{"nombre":"teclado","precio": 200},
{"nombre":"raton","precio": 120},
{"nombre":"monitor","precio": 25},
{"nombre":"camara","precio": 300},
{"nombre":"muñeco", "precio":70}
]
# Inicialización de las listas y diccionarios para el carrito y el seguimiento de pedidos
lista_carrito=[]  # Lista que almacena los productos añadidos al carrito.
numero_seguimiento={} # Diccionario que almacena los detalles de los pedidos (número, cliente, productos y total).

# Función para registrar e iniciar sesión a través del DNI, esta funcion permite a los usuarios registrarse o iniciar sesion, solicita el dni, si el usuario ya existe permite el acceso, si el dni no existe, solicita al usuario el DNI y su nombre y lo añade a lista_usuarios.
def registro():
    while True:
        usuario = input("Escribe tu DNI de usuario: ")
        if usuario in lista_usuarios:
            return True  # Si el usuario ya está registrado, permite el acceso
        else:
            print("No estas registrado, tienes que registrarte: ")
            registro_usuario = input("Introduce tu DNI para registrarte: ")
            nombre_usuario = input("Introduce tu nombre: ")
            lista_usuarios[registro_usuario]= nombre_usuario # Se añade al diccionario de usuarios
            print(f"Usuario registrado: {registro_usuario}: {nombre_usuario}") 
            return registro_usuario # Devuelve el DNI del usuario registrado para usarlo en el menú
# Función para imprimir la lista de clientes registrados, si no hay usuarios muestra un mensaje indicando que no hay clientes registrados.
def imprimir_clientes ():
    if lista_usuarios:
        print("Lista de clientes registrados:")
        for dni, nombre in lista_usuarios.items():
            print(f"DNI: {dni}, Nombre: {nombre}") # Muestra todos los usuarios registrados
    else:
        print("No hay clientes registrados.")  # Si no hay usuarios, muestra un mensaje.
# Función para mostrar los productos disponibles en la tienda, los productos estan almacenados en diccionario_productos.
def mostrar_productos():
    for item in diccionario_productos:
        print(f"{item['nombre']} - Precio: {item['precio']}€") # Muestra los productos y sus precios
# Función para añadir productos al carrito de compras, muestra todos los productos disponibles y solicita al usuario que ingrese el nombre del producto que desea comprar, añade el producto al lista_carrito si coincide con alguno de los nombres de los productos en diccionario_productos, el usuario escribe fin para salir de la funcion y terminar de comprar.
def añadir_carrito():
    print("Productos disponibles: ")
    mostrar_productos() # Muestra los productos disponibles
    while True:
        añadir=input("Añade los productos que quieres comprar o escribir fin: ")
        if añadir.lower() == "fin":
            print("Saliendo de la compra") # Si el usuario escribe "fin", termina el proceso
            break
        for item in diccionario_productos:
            if item['nombre'].lower() == añadir.lower():
                lista_carrito.append(item)  # Añadir el producto al carrito
                print(f"{item['nombre']} ha sido añadido al carrito.")
                break
        else:
            print(f"Producto '{añadir}' no encontrado. Inténtalo nuevamente.") #No encuentra productos.

#Función para mostrar el contenido del carrito
def mostrarcarrito():
    if not lista_carrito:
        print("El carrito está vacío.")
    else:
        print("\nContenido del carrito:")
        total = 0
        for item in lista_carrito:
            print(f"{item['nombre']} - Precio: {item['precio']}€") # Muestra los productos del carrito
            total += item['precio']  # Suma el precio de cada producto
        print(f"Total de la compra: {total}€") # Muestra el total de la compra
# Función para realizar la compra y generar un número de pedido
def realizar_compra(dni_cliente):
    if not lista_carrito: # Si el carrito está vacío, no se puede realizar la compra
        print("El carrito está vacío. No se puede realizar la compra.")
        return
    numero_pedido = random.randint(1000, 9999) # Genera un número de pedido aleatorio
    productos = [item['nombre'] for item in lista_carrito] # Obtiene los nombres de los productos del carrito
    total = sum(item['precio'] for item in lista_carrito) # Suma los precios de los productos del carrito
    numero_seguimiento[numero_pedido] = { # Almacena el número de pedido y detalles en el diccionario de seguimiento
        "cliente_dni": dni_cliente,
        "productos": productos,
        "total": total
    }
    print(f"Pedido realizado con éxito. Número de pedido: {numero_pedido}")
    lista_carrito.clear() # Vacia el carrito después de realizar la compra
# Función para hacer seguimiento de un pedido a través del número de pedido, si el pedido existe en numero_seguimiento, muestra el nombre del cliente, los productos comprados y el total de la compra.
def seguimiento_pedido():
    try:
        numero_pedido = int(input("Ingrese el número de pedido para realizar el seguimiento: "))
        if numero_pedido in numero_seguimiento: 
            pedido = numero_seguimiento[numero_pedido]
            dni_cliente = pedido["cliente_dni"]
            nombre_cliente = lista_usuarios[dni_cliente] # Obtiene el nombre del cliente usando el DNI
            print(f"\nDetalles del Pedido #{numero_pedido}:")
            print(f"Cliente: {nombre_cliente}, DNI: {dni_cliente}")
            print("Productos comprados:")
            for producto in pedido["productos"]:
                print(f"- {producto}")  # Muestra todos los productos comprados en el pedido
            print(f"Total: {pedido['total']}€") # Muestra el total de la compra
        else:
            print("Pedido no encontrado.")
    except ValueError:
        print("Número de pedido no válido.")
# Función principal que actúa como el menú de la tienda, solicita registro o inicio de sesion, muestra el menu de la tienda y permite al usuairo seleccionar opciones, cada opcion ejecuta una funcion.
def menu():
    dni_cliente_actual = None # Variable para almacenar el DNI del cliente que está usando el sistema

    # Requerir inicio de sesión o registro antes de acceder al menú
    while not dni_cliente_actual:
        dni_cliente_actual = registro()

    # Mostrar el menú solo si se ha registrado o iniciado sesión
    while True:
        print("\n--- Menú de la tienda ---")
        print("1. Visualizar clientes registrados")
        print("2. Buscar cliente por DNI")
        print("3. Ver productos disponibles")
        print("4. Añadir producto al carrito")
        print("5. Ver carrito de compras")
        print("6. Realizar compra")
        print("7. Seguimiento de pedido")
        print("8. Salir")

        opcion = input("Seleccione una opción: ")
# Dependiendo de la opción seleccionada, se ejecuta una función diferente
        if opcion == '1':
            imprimir_clientes()
        elif opcion == '2':
            imprimir_clientes()
        elif opcion == '3':
            mostrar_productos()
        elif opcion == '4':
            añadir_carrito()
        elif opcion == '5':
            mostrarcarrito()
        elif opcion == '6':
            realizar_compra(dni_cliente_actual)
        elif opcion == '7':
            seguimiento_pedido()
        elif opcion == '8':
            print("Saliendo de la aplicación.")
            break
        else:
            print("Opción no válida. Intente nuevamente.")
# Ejecutar el menú principal
menu()