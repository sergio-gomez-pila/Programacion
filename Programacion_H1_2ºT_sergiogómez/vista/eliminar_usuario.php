<?php
// Iniciamos la sesión para manejar los datos del usuario entre páginas
require_once '../controlador/UsuarioController.php';
session_start();

// Verificamos si el usuario está logueado, si no lo está, redirigimos al login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");  // Redirige al inicio si no está logueado
    exit();  // Terminamos el script después de la redirección
}

// Creamos una instancia del controlador para manejar las operaciones de usuario
$controller = new UsuarioController();

// Obtenemos la lista de usuarios registrados
$ad = $controller->obtenerUsuario();

// Si se envió el formulario para eliminar un usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos el ID del usuario a eliminar desde el formulario
    $id_usuario = $_POST['id_usuario'];
    
    // Llamamos al método para eliminar el usuario con el ID proporcionado
    $controller->eliminarUsuario($id_usuario);
    
    // Mostramos un mensaje de éxito y redirigimos a la lista de usuarios
    echo "Usuario eliminado con éxito.";
    header("Location: lista_usuario.php");  // Redirige a la lista de usuarios después de eliminar
    exit();  // Terminamos el script después de la redirección
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
</head>

<body>
    <h1>Usuarios Registrados</h1>
    
    <!-- Tabla que muestra todos los usuarios registrados -->
    <table border="1">
        <tr>
            <!-- Encabezados de la tabla -->
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Edad</th>
        </tr>
        <!-- Iteramos sobre cada usuario y mostramos sus datos en una fila de la tabla -->
        <?php foreach ($ad as $ad): ?>
            <tr>
                <td><?= $ad['id_usuario'] ?></td>
                <td><?= $ad['nombre'] ?></td>
                <td><?= $ad['apellidos'] ?></td>
                <td><?= $ad['correo'] ?></td>
                <td><?= $ad['edad'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Formulario para eliminar un usuario por su ID -->
    <h1>Eliminar Usuario</h1>
    <form method="POST" action="">
        <label for="id_usuario">ID del Usuario:</label>
        <input type="number" name="id_usuario" required>  <!-- Campo para ingresar el ID del usuario a eliminar -->
        <button type="submit">Eliminar</button>  <!-- Botón para enviar el formulario -->
    </form>

    <br>

</body>

</html>
