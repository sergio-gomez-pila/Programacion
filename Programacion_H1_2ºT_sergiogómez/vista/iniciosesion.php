<?php
// Iniciamos la sesión para manejar datos del usuario entre páginas
session_start();

// Incluimos el modelo de usuario y el controlador para gestionar las operaciones relacionadas con los usuarios
require_once '../modelo/class_usuario.php';
require_once '../controlador/UsuarioController.php'; // Corregido: ahora se incluye el controlador de forma correcta

// Creamos una instancia del controlador de Usuario para manejar la lógica
$controller = new UsuarioController();

// Inicializamos una variable para manejar posibles errores
$error_message = null;

// Verificamos si el formulario ha sido enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario: correo y contraseña
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Llamamos al método de inicio de sesión para verificar los datos del usuario
    $usuario = $controller->iniciarSesion($correo, $contraseña);

    // Si los datos son incorrectos, mostramos un mensaje de error
    if (!$usuario) {
        $error_message = "Datos incorrectos. Por favor, intenta de nuevo.";
    } else {
        // Si el inicio de sesión es exitoso, guardamos la información del usuario en la sesión
        $_SESSION['usuario'] = $usuario;
        $success_message = "Inicio de sesión exitoso.";
        // Redirigimos al usuario a su perfil
        header("Location: ../perfil_index.php");
        exit(); // Terminamos el script después de la redirección
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Cargamos el CSS de Bootstrap para mejorar la apariencia -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnymDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Iniciar Sesión</h1>

        <!-- Si hay un mensaje de error, lo mostramos en rojo -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Si hay un mensaje de éxito, lo mostramos en verde -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para que el usuario ingrese sus credenciales -->
        <form method="POST" action="">
            <!-- Campo para el correo electrónico -->
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <!-- Campo para la contraseña -->
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
    </div>
</body>

</html>