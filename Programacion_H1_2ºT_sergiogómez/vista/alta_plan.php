<?php
require_once '../controlador/PlanController.php';
require_once '../controlador/UsuarioController.php';

session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

$controller = new Plan();
$plan = $controller->ObtenerPlan();
$c = new UsuarioController();
$usuario = $_SESSION['usuario'];

// Verificar si se pasa un ID de usuario
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];
    $perfil = $c->obtenerUsuarioPorId2($id_usuario);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_plan = $_POST['id_plan'];

    // Verificar si el usuario tiene suficiente cantidad de planes
    if ($controller->cantidadPlanes($perfil[0]['id_usuario'])) {
        // Agregar el plan
        if ($controller->agregarPlan($perfil[0]['id_usuario'], $id_plan, NULL, NULL, NULL)) {
            $success_message = "Plan agregado con éxito.";
            header("Location: lista_usuario.php");
            exit();
        } else {
            $error_message = "Error al agregar el plan.";
        }
    } else {
        $error_message = "No tienes planes disponibles para agregar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planes</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Planes Disponibles</h1>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dispositivos</th>
                    <th>Precio</th>
                    <th>Duración Suscripción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plan as $plan_item): ?>
                    <tr>
                        <td><?= htmlspecialchars($plan_item['id_plan']) ?></td>
                        <td><?= htmlspecialchars($plan_item['nombre']) ?></td>
                        <td><?= htmlspecialchars($plan_item['dispositivos']) ?></td>
                        <td><?= htmlspecialchars($plan_item['precio']) ?></td>
                        <td><?= htmlspecialchars($plan_item['duracion_suscripcion']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Formulario para agregar un plan -->
        <h2 class="mt-4">Contrata un Plan</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_plan">Número del Plan:</label>
                <input type="number" class="form-control" id="id_plan" name="id_plan" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Aceptar</button>
        </form>

        <br>
        <a href="../perfil_index.php" class="btn btn-secondary mt-3">Volver</a>
    </div>
</body>

</html>
