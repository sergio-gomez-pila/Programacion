<?php
require_once '../controlador/UsuarioController.php';

$controller = new UsuarioController();
session_start();

// Verificar si el usuario está logueado. Si no, destruir la sesión y redirigir.
if (!isset($_SESSION['usuario'])) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}

$id_user = $_SESSION['usuario']['id_usuario'];
$usuario = $controller->obtenerUsuarioporID($id_user);

// Procesar la solicitud POST para agregar tarea
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = trim($_POST['descripcion']); // Sanitizar la entrada

    // Validar que la descripción no esté vacía
    if (empty($descripcion)) {
        $error_message = "La descripción de la tarea es obligatoria.";
    } else {
        $resultado = $controller->AgregarTarea($usuario["id_usuario"], $descripcion);

        // Verificar si la tarea se agregó correctamente
        if (!$resultado) {
            $error_message = "Error al agregar la tarea. Intenta nuevamente.";
        } else {
            $_SESSION['success_message'] = "Tarea agregada correctamente."; // Establecer mensaje de éxito
            header("Location: agregar_tarea.php"); // Redirigir para mostrar el mensaje
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Agregar Tarea</h1>

        <!-- Mostrar el mensaje de error si existe -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Mostrar el mensaje de éxito si existe -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para agregar tarea -->
        <form method="POST" action="" class="mt-4">
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Agregar Tarea</button>
        </form>

        <!-- Botón de Volver -->
        <a href="../usuario_index.php" class="btn btn-secondary mt-3">Volver</a>
    </div>
</body>

</html>
