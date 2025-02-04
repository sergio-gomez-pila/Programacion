<?php
// Se incluye el archivo del controlador de usuario para manejar las acciones relacionadas con los usuarios
require_once '../controlador/UsuarioController.php';

// Iniciamos la sesión para poder manejar las variables de sesión
session_start();

// Verificamos si el usuario está logueado, si no, lo redirigimos al inicio
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();  // Terminamos la ejecución si no está logueado
}

// Creamos una instancia del controlador de usuario
$controller = new UsuarioController();

// Obtenemos los detalles de los usuarios registrados desde el controlador
$ad = $controller->obtenerdetalles();

// Si el formulario es enviado por POST, procesamos los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];

    // Llamamos al método para agregar un nuevo usuario
    $usuario = $controller->agregarUsuario($nombre, $apellidos, $correo, $edad);

    // Verificamos si se pudo agregar el usuario
    if (!$usuario) {
        // Si hubo un error, mostramos un mensaje de error
        $error_message = "Error al agregar usuario. Por favor, verifica los datos.";
    } else {
        // Si todo salió bien, mostramos un mensaje de éxito y redirigimos a la página principal
        $success_message = "Usuario agregado con éxito.";
        header("Location: ../index.php");
        exit();  // Terminamos el script después de la redirección
    }
}
?>

<!-- HTML para la interfaz de usuario -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
    <!-- Cargamos el CSS de Bootstrap para darle un buen estilo a la página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                <th>Plan</th>
                <th>Paquetes</th>
                <th>Dispositivos</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Iteramos sobre cada usuario obtenido y mostramos sus detalles en la tabla -->
            <?php foreach ($ad as $ad): ?>
                <tr>
                    <td><?= $ad['id_usuario'] ?></td>
                    <td><?= $ad['nombre'] ?></td>
                    <td><?= $ad['apellidos'] ?></td>
                    <td><?= $ad['correo'] ?></td>
                    <td><?= $ad['edad'] ?></td>
                    <td><?= $ad['Plan_Obtenido'] ?></td>
                    <td><?= $ad['Paquetes_Obtenidos'] ?></td>
                    <td><?= $ad['dispositivos'] ?></td>
                    <td><?= $ad['Precio_Total'] ?></td>
                    <td>
                        <!-- Enlace para editar el plan del usuario -->
                        <a href="editar_planes.php?id=<?= $ad['id_usuario'] ?>" class="btn btn-warning btn-sm">Editar Plan</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Botón para regresar al perfil -->
    <div class="text-center mt-4">
        <a href="../perfil_index.php" class="btn btn-secondary">Volver</a>
    </div>

</div>

</body>
</html>
