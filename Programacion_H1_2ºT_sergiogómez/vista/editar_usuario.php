<?php
// Iniciamos la sesión para manejar los datos del usuario entre páginas
require_once '../controlador/UsuarioController.php';
session_start();

// Verificamos si el usuario está logueado, si no lo está, lo redirigimos al login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");  // Redirige al inicio si no está logueado
    exit();  // Terminamos el script después de la redirección
}

// Creamos una instancia del controlador que maneja las operaciones de usuario
$controller = new UsuarioController();
$usuario = null;
$message = '';  // Variable para mostrar mensajes de éxito o error

// Verificamos si se ha recibido un ID de usuario en la URL (por ejemplo, desde un enlace de edición)
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];  // Obtenemos el ID del usuario desde la URL
    $usuario = $controller->obtenerUsuarioPorId($id_usuario);  // Obtenemos los datos del usuario por su ID
}

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($id_usuario)) {
        // Validación de datos recibidos
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
        $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
        $edad = filter_var($_POST['edad'], FILTER_VALIDATE_INT);

        if ($edad === false) {
            $message = 'Por favor ingresa una edad válida.';
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $message = 'Por favor ingresa un correo electrónico válido.';
        } else {
            // Si la validación pasa, actualizamos los datos con la información recibida del formulario
            $controller->actualizarUsuario(
                $id_usuario,
                $nombre,
                $apellidos,
                $correo,
                $edad
            );
            $message = 'Usuario actualizado con éxito.';  // Mensaje de éxito
            header("Location: lista_usuario.php");  // Redirige a la lista de usuarios después de actualizar
            exit();  // Terminamos el script después de la redirección
        }
    } else {
        $message = 'Error: ID de usuario no encontrado.';  // Mensaje de error si no se encuentra el ID
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <!-- Estilos de Bootstrap para mejorar la interfaz -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnymDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Usuario</h1>

        <!-- Mostramos el mensaje si existe -->
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Comprobamos si se han encontrado los datos del usuario -->
        <?php if ($usuario && count($usuario) > 0): ?>
            <!-- Formulario para editar los datos del usuario -->
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario[0]['nombre']); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellido:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario[0]['apellidos']); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Email:</label>
                    <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario[0]['correo']); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="edad" class="form-label">Edad:</label>
                    <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($usuario[0]['edad']); ?>" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            </form>
        <?php else: ?>
            <p>Usuario no encontrado.</p>
        <?php endif; ?>

        <br>
        <a href="lista_usuario.php" class="btn btn-secondary">Volver a la lista de usuarios</a>
    </div>
</body>

</html>
