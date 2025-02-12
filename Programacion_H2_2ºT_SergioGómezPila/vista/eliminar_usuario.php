<?php
require_once '../controlador/UsuarioController.php';
$controller = new UsuarioController();
session_start();
// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}
$id_user = $_SESSION['usuario']['id_usuario'];
$usuario = $controller->obtenerUsuarioporID($id_user);
if (!$id_user) {
    echo "Usuario no encontrado";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $controller->eliminarUsuario($id_usuario);
    echo "Usuario eliminado con éxito.";
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
</head>

<body>
    <h1>Usuarios Registrados</h1>
    <table border="1">
        <tr>
            <th>ID </th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>

        </tr>
        <tr>
            <td><?= $usuario['id_usuario'] ?></td>
            <td><?= $usuario['nombre'] ?></td>
            <td><?= $usuario['apellidos'] ?></td>
            <td><?= $usuario['correo'] ?></td>

        </tr>

    </table>
    <h1>Eliminar Usuario</h1>
    <form method="POST" action="">
        <label for="id_usuario">ID del Usuario:</label>
        <input type="number" name="id_usuario" required>
        <button type="submit">Eliminar</button>
    </form>


    <br>

</body>

</html>