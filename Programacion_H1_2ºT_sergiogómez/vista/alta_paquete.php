<?php

// Se requiere la inclusión de los controladores que manejarán la lógica de la aplicación
require_once '../controlador/PlanController.php';
require_once '../controlador/UsuarioController.php';
session_start(); // Inicia una nueva sesión o reanuda la actual

// Verifica si el usuario está logueado. Si no está, redirige al login.
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit(); // Termina la ejecución si no está logueado
}

// Se crean las instancias de los controladores para manejar los paquetes y los usuarios
$controller = new PlanController();
$paquete = $controller->ObtenerPaquete(); // Obtiene todos los paquetes disponibles
$c = new UsuarioController();

// Se recupera el usuario logueado desde la sesión
$usuario = $_SESSION['usuario'];

// Obtiene el ID del usuario desde la URL o el formulario
$id_usuario = $_GET['id'] ?? $_POST['id_usuario'] ?? null;

// Obtiene los detalles del cliente y del usuario basado en su ID
$cliente = $controller->obtenerid($id_usuario);
$usuarioIDi = $c->obtenerUsuarioPorId2($id_usuario);

$error_message = ''; // Variable para almacenar el mensaje de error
$success_message = ''; // Variable para almacenar el mensaje de éxito

// Verifica si el formulario fue enviado por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Se recuperan los paquetes seleccionados en el formulario, asegurando que sean válidos
    $id_paquete1 = isset($_POST['id_paquete1']) && $_POST['id_paquete1'] !== '' ? (int) $_POST['id_paquete1'] : null;
    $id_paquete2 = isset($_POST['id_paquete2']) && $_POST['id_paquete2'] !== '' ? (int) $_POST['id_paquete2'] : null;
    $id_paquete3 = isset($_POST['id_paquete3']) && $_POST['id_paquete3'] !== '' ? (int) $_POST['id_paquete3'] : null;

    // Llama al método para insertar los paquetes seleccionados en la base de datos
    $resultado = $controller->insertarPaquete($usuarioIDi[0]["id_usuario"], $cliente["id_plan"], $id_paquete1, $id_paquete2, $id_paquete3);

    // Si el resultado es un mensaje de error (string), se muestra el mensaje
    if ($resultado !== true) {
        $error_message = $resultado; // Captura el mensaje de error
    } else {
        // Redirigir manteniendo el ID
        header("Location: lista_detalles.php");
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Paquetes</title>
    <!-- Agregado enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <h1>Paquetes</h1>

        <!-- Si hay un mensaje de error, se muestra en rojo -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <!-- Si hay un mensaje de éxito, se muestra en verde -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <!-- Tabla para mostrar los paquetes disponibles -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paquete as $paquete): ?>
                    <tr>
                        <td><?= htmlspecialchars($paquete['id_paquete']) ?></td>
                        <td><?= htmlspecialchars($paquete['nombre']) ?></td>
                        <td><?= htmlspecialchars($paquete['precio']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-4">Contrata un Paquete</h2>

        <!-- Formulario para contratar un paquete -->
        <form method="POST" action="alta_paquete.php">
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id_usuario) ?>"> <!-- Envia el ID del usuario de forma oculta -->

            <div class="mb-3">
                <label for="id_paquete1" class="form-label">Paquete 1</label>
                <input type="number" class="form-control" id="id_paquete1" name="id_paquete1" required> <!-- Paquete obligatorio -->
            </div>
            <div class="mb-3">
                <label for="id_paquete2" class="form-label">Paquete 2</label>
                <input type="number" class="form-control" id="id_paquete2" name="id_paquete2"> <!-- Paquete opcional -->
            </div>
            <div class="mb-3">
                <label for="id_paquete3" class="form-label">Paquete 3</label>
                <input type="number" class="form-control" id="id_paquete3" name="id_paquete3"> <!-- Paquete opcional -->
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Contratar</button>
                <a href="lista_detalles.php" class="btn btn-secondary">Volver</a>
                <a href="../perfil_index.php" class="btn btn-primary">Volver al Menú Principal</a>
            </div>


        </form>
    </div>
</body>

</html>