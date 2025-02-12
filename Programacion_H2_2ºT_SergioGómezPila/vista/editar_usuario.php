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

if (!$usuario) {
    echo "Usuario no encontrado";
    exit();
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Validar campos obligatorios
    if (empty($nombre) || empty($apellidos) || empty($correo)) {
        $_SESSION['error_message'] = "Todos los campos son obligatorios, excepto la contraseña.";
        header("Location: editar_usuario.php");
        exit();
    }

    // Si la contraseña no está vacía, se actualiza
    if (!empty($contraseña)) {
        $actualizar = $controller->actualizarUsuario($id_user, $nombre, $apellidos, $correo, $contraseña);
    } else {
        $actualizar = $controller->actualizarUsuario($id_user, $nombre, $apellidos, $correo, null);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Editar Usuario</h1>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message'];
                unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message'];
                unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <form method="POST" action="" class="mt-4">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="apellidos">Apellido:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="correo">Email:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Actualizar Perfil</button>
        </form>

        <br>
        <a href="../usuario_index.php" class="btn btn-secondary">Volver</a>
        <a href="eliminar_usuario.php" class="btn btn-danger">Eliminar Cuenta</a>
    </div>
</body>

</html>