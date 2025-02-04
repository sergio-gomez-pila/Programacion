<?php
session_start(); // Iniciamos la sesión para poder trabajar con datos del usuario

require_once '../controlador/UsuarioController.php'; // Importamos el controlador de usuario

// Verificamos si el usuario está logueado, si no, lo mandamos a la página de inicio de sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciosesion.php");
    exit(); // Detenemos la ejecución del script para que no siga cargando
}

// Creamos una instancia del controlador de usuario y obtenemos la lista de usuarios registrados
$controller = new UsuarioController();
$ad = $controller->obtenerUsuario();

// Si se envió un formulario por POST, capturamos los datos ingresados por el usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];

    // Intentamos agregar el usuario con los datos ingresados
    $usuario = $controller->agregarUsuario($nombre, $apellidos, $correo, $edad);

    // Si la inserción falla, mostramos un mensaje de error
    if (!$usuario) {
        $error_message = "Error al agregar usuario. Por favor, verifica los datos.";
    } else {
        // Si se agregó correctamente, mostramos un mensaje de éxito y redirigimos a la página principal
        $success_message = "Usuario agregado con éxito.";
        header("Location: ../index.php");
        exit(); // Terminamos la ejecución para evitar que el código siga corriendo
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>

    <!-- Cargamos Bootstrap para darle estilo a la página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h1 class="text-center mb-4">Usuarios Registrados</h1>

        <!-- Mostrar mensaje de éxito o error si existe -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?= $success_message ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <!-- Tabla para mostrar los usuarios registrados -->
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Edad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Recorremos el array de usuarios y mostramos los datos en la tabla -->
                <?php foreach ($ad as $ad): ?>
                    <tr>
                        <td><?= $ad['id_usuario'] ?></td>
                        <td><?= $ad['nombre'] ?></td>
                        <td><?= $ad['apellidos'] ?></td>
                        <td><?= $ad['correo'] ?></td>
                        <td><?= $ad['edad'] ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?= $ad['id_usuario'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="alta_plan.php?id=<?= $ad['id_usuario'] ?>" class="btn btn-success btn-sm">Añadir Plan</a>
                            <a href="alta_paquete.php?id=<?= $ad['id_usuario'] ?>" class="btn btn-info btn-sm">Añadir Paquete</a>
                            <a href="eliminar_usuario.php?id=<?= $ad['id_usuario'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Botón para agregar un nuevo usuario -->
        <div class="text-center mt-4">
            <a href="alta_usuario.php" class="btn btn-primary">Agregar un nuevo Usuario</a>
        </div>

        <!-- Botón para volver al perfil -->
        <div class="text-center mt-2">
            <a href="../perfil_index.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</body>

</html>