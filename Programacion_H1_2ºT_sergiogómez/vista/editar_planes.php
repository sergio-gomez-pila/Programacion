<?php
// Incluimos los controladores necesarios para manejar los planes y usuarios
require_once '../controlador/PlanController.php';
require_once '../controlador/UsuarioController.php';
session_start();

// Verificamos si el usuario está logueado. Si no lo está, redirigimos a la página de inicio
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");  // Si no está logueado, redirige al inicio
    exit();  // Termina el script después de la redirección
}

// Creamos las instancias de los controladores de Planes y Usuarios
$controller = new PlanController();
$controller1 = new UsuarioController();

// Obtenemos el ID del usuario desde la URL, si no existe, será null
$id_usuario = $_GET['id'] ?? null;

// Filtramos al usuario y obtenemos detalles usando los controladores
$cliente = $controller1->filtrar_usuario($id_usuario);  // Filtra el usuario por ID
$clienteint = $controller1->obtenerUsuarioPorId2($id_usuario);  // Obtiene el usuario con un método diferente
$tabla = $controller1->obtenerUsuarioPorId($cliente["id_usuario"]);  // Obtiene los detalles del usuario por ID

$error_message = '';  // Mensaje de error vacío
$success_message = '';  // Mensaje de éxito vacío

// Si el formulario es enviado (método POST), se elimina el plan del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($clienteint[0]["id_usuario"])) {
        // Llamamos al controlador para eliminar el plan
        $controller->eliminarplan($clienteint[0]["id_usuario"]);
        $success_message = "Plan del usuario eliminado con éxito.";  // Mensaje de éxito
        header("Location: lista_usuario.php?success=" . urlencode($success_message));  // Redirige a la lista de usuarios
        exit();  // Termina el script después de la redirección
    } else {
        $error_message = 'Error: No se pudo eliminar el plan. Usuario no encontrado.';  // Mensaje de error
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Paquetes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Detalles del Usuario</h1>
        
        <!-- Mostrar mensaje de éxito o error -->
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Formulario para eliminar el plan del usuario -->
        <form method="post">
            <!-- Campo oculto para enviar el ID del usuario sin mostrarlo -->
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($cliente["id_usuario"]) ?>">

            <!-- Tabla con los detalles del usuario -->
            <table class="table table-bordered">
                <thead>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php if (!empty($tabla)): ?>
                            <td><?= htmlspecialchars($tabla[0]['id_usuario']) ?></td>
                            <td><?= htmlspecialchars($tabla[0]['nombre']) ?></td>
                            <td><?= htmlspecialchars($tabla[0]['apellidos']) ?></td>
                            <td><?= htmlspecialchars($tabla[0]['correo']) ?></td>
                            <td><?= htmlspecialchars($tabla[0]['edad']) ?></td>
                            <td><?= htmlspecialchars($tabla[0]['Plan_Obtenido']) ?></td>
                            <td><?= htmlspecialchars($tabla[0]['Paquetes_Obtenidos']) ?></td>
                            <td><?= htmlspecialchars($tabla[0]['dispositivos']) ?></td>
                            <td><?= htmlspecialchars($tabla[0]['Precio_Total']) ?></td>
                        <?php else: ?>
                            <td colspan="9">No se encontraron detalles del usuario.</td>
                        <?php endif; ?>
                    </tr>
                </tbody>
            </table>
            <!-- Botón para cambiar el plan (en este caso, eliminar el plan actual) -->
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar el plan del usuario?');">Eliminar Plan</button>
        </form>

        <br>
        <a href="lista_usuario.php" class="btn btn-secondary">Volver a la lista de usuarios</a>
    </div>
</body>

</html>
