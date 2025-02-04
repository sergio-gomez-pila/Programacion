<?php
// Incluimos el controlador de usuarios
require_once '../controlador/UsuarioController.php';

session_start();
// Verificamos si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    // Si no está logueado, redirigimos a la página de inicio
    header("Location: ../index.php");
    exit();
}

$error_message = '';  // Variable para almacenar mensajes de error
$success_message = '';  // Variable para almacenar mensajes de éxito
$controller = new UsuarioController();  // Creamos una instancia del controlador de usuarios

// Comprobamos si se envió el formulario (si es un POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];

    // Llamamos al controlador para agregar un nuevo usuario
    $usuario = $controller->agregarUsuario(
        $nombre,
        $apellidos,
        $correo,
        $edad
    );
    
    // Si no se pudo agregar el usuario, mostramos un mensaje de error
    if (!$usuario) {
        $error_message = "Error al agregar usuario. Por favor, verifica los datos.";
    } else {
        // Si el usuario se agregó con éxito, mostramos un mensaje de éxito y redirigimos
        $success_message = "Usuario agregado con éxito.";
        header("Location: lista_usuario.php"); // Redirige a la lista de usuarios
        exit(); // Terminamos el script para evitar que el código posterior se ejecute
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<!-- Enlace a Bootstrap para el diseño de la página -->
<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnY mDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Agregar Usuario</h1>

        <!-- Mostrar el mensaje de error si existe -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Mostrar el mensaje de éxito si existe -->
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- Formulario para agregar un nuevo usuario -->
        <form method="POST" action="" class="mt-4">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="apellidos">Apellido:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>

            <div class="form-group">
                <label for="correo">Email:</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" class="form-control" id="edad" name="edad" required min="0">
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn btn-primary">Agregar Usuario</button>
            
            <!-- Enlace para regresar a la lista de usuarios -->
            <a href="lista_usuario.php" class="btn btn-secondary mt-3">Volver</a>
        </form>
    </div>
</body>

</html>
