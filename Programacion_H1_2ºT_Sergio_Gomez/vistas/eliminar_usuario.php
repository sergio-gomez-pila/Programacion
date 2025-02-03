<?php
// Incluimos el archivo que contiene el controlador de usuarios,
// para poder utilizar la función de eliminarUsuario.
require_once '../controlador/UsuariosController.php';

// Verificamos si se envió el formulario usando el método POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Creamos una instancia del controlador de usuarios.
    $controller = new UsuariosController();
    // Llamamos al método eliminarUsuario y le pasamos el ID del usuario a eliminar,
    // que obtenemos del input 'id_usuario' del formulario.
    $controller->eliminarUsuario($_POST['id_usuario']);
    // Después de eliminar el usuario, redireccionamos a la página que muestra la lista de usuarios.
    header("Location: lista_usuarios.php");
    // Salimos para que no se ejecute ningún código adicional.
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Usuario</title>
</head>
<body>
    <h1>Eliminar Usuario</h1>
    <!-- Este formulario permite ingresar el ID del usuario que se desea eliminar. -->
    <form method="POST" action="">
        <!-- Etiqueta para el campo de entrada del ID del usuario -->
        <label for="id_usuario" class="form-label">ID del Usuario:</label>
        <!-- Campo de texto para que el usuario escriba el ID -->
        <input type="text" class="form-control" id="id_usuario" name="id_usuario" required><br>
        <!-- Botón para enviar el formulario y proceder con la eliminación -->
        <input type="submit" value="Eliminar Usuario">
    </form>
    <br>
    <!-- Enlace para volver a la lista de usuarios -->
    <a href="lista_usuarios.php">Volver al listado de usuarios</a>
</body>
</html>

