<?php
// Incluimos el controlador para poder usar sus métodos (como obtener y actualizar usuarios)
require_once '../controlador/UsuariosController.php';

// Creamos una instancia del controlador de usuarios
$controller = new UsuariosController();
// Inicializamos la variable $usuario en null
$usuario = null;
// Obtenemos todos los paquetes disponibles (esto se usa para los checkboxes de paquetes adicionales)
$paquetes = $controller->obtenerPaquetes();
// Variables para almacenar mensajes de error o éxito
$error_message = "";
$success_message = "";

// Si se recibe el id del usuario por GET, se quiere editar un usuario existente
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    // Obtenemos los datos del usuario a partir del id
    $usuario = $controller->obtenerUsuarioPorId($id_usuario);
    // También obtenemos los paquetes que ya tiene contratados ese usuario
    $paquetes_usuario = $controller->obtenerPaquetePorUsuario($id_usuario);
}

// Si el formulario se envía (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos los datos enviados desde el formulario
    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];
    $nombre_plan = $_POST['nombre_plan'];
    $duracion = $_POST['duracion'];
    // Si se seleccionaron paquetes, los recogemos, sino dejamos un arreglo vacío
    $paquetes_adicionales = isset($_POST['paquetes']) ? $_POST['paquetes'] : [];

    // Validaciones según las restricciones del sistema:
    // Si la edad es menor a 18 y se intenta contratar algún paquete de Deporte o Infantil
    if ($edad < 18 && (in_array('Deporte', $paquetes_adicionales) || in_array('Infantil', $paquetes_adicionales))) {
        $error_message = "Los usuarios menores de 18 años no pueden contratar los paquetes Deporte e Infantil.";
        // Si el plan es Básico y se seleccionaron más de un paquete adicional
    } elseif ($nombre_plan == 'Basico' && count($paquetes_adicionales) > 1) {
        $error_message = "El plan Básico solo permite un paquete adicional.";
        // Si se eligió el paquete Deporte y la duración no es Anual
    } elseif (in_array('Deporte', $paquetes_adicionales) && $duracion != 'Anual') {
        $error_message = "El paquete Deporte solo puede contratarse con una suscripción anual.";
    } else {
        // Si todo está correcto, se llama al método actualizarUsuario para guardar los cambios
        $resultado = $controller->actualizarUsuario($id_usuario, $nombre, $apellidos, $correo, $edad, $nombre_plan, $duracion, $paquetes_adicionales);

        // Si la actualización falla, se muestra un mensaje de error
        if (!$resultado) {
            $error_message = "Error al actualizar el usuario. Por favor, verifica los datos.";
        } else {
            // Si se actualiza correctamente, se muestra un mensaje de éxito y se redirige a la lista de usuarios
            $success_message = "Usuario actualizado con éxito.";
            header("Location: lista_usuarios.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - StreamWeb</title>
    <!-- Se incluye el CSS de Bootstrap para estilos modernos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Color de fondo claro para la página */
        body {
            background-color: #f8f9fa;
        }

        /* Sombra sutil para las cards, dándoles un efecto de elevación */
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    </style>
</head>

<body>
    <!-- Navbar Profesional: barra de navegación en la parte superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <!-- Enlace que lleva a la página principal -->
            <a class="navbar-brand" href="../index.php">StreamWeb</a>
            <!-- Botón para colapsar el menú en pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Contenedor principal donde se muestra el formulario de edición -->
    <div class="container my-5">
        <div class="card">
            <!-- Encabezado de la card con título -->
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-0">Editar Usuario</h3>
            </div>
            <div class="card-body">
                <!-- Si hay un mensaje de error, se muestra en una alerta roja -->
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Si hay un mensaje de éxito, se muestra en una alerta verde -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario para editar los datos del usuario -->
                <form method="POST" action="">
                    <!-- Campo oculto que guarda el id del usuario -->
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

                    <!-- Campo para el nombre del usuario -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
                    </div>

                    <!-- Campo para los apellidos del usuario -->
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo $usuario['apellidos']; ?>" required>
                    </div>

                    <!-- Campo para el correo del usuario -->
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo:</label>
                        <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $usuario['correo']; ?>" required>
                    </div>

                    <!-- Campo para la edad del usuario -->
                    <div class="mb-3">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="number" id="edad" name="edad" class="form-control" value="<?php echo $usuario['edad']; ?>" required>
                    </div>

                    <!-- Menú desplegable para seleccionar el plan del usuario -->
                    <div class="mb-3">
                        <label for="nombre_plan" class="form-label">Plan:</label>
                        <select id="nombre_plan" name="nombre_plan" class="form-select" required>
                            <option value="Basico" <?php echo ($usuario['nombre_plan'] == 'Basico') ? 'selected' : ''; ?>>Básico</option>
                            <option value="Estandar" <?php echo ($usuario['nombre_plan'] == 'Estandar') ? 'selected' : ''; ?>>Estándar</option>
                            <option value="Premium" <?php echo ($usuario['nombre_plan'] == 'Premium') ? 'selected' : ''; ?>>Premium</option>
                        </select>
                    </div>

                    <!-- Menú desplegable para seleccionar la duración de la suscripción -->
                    <div class="mb-3">
                        <label for="duracion" class="form-label">Duración:</label>
                        <select id="duracion" name="duracion" class="form-select" required>
                            <option value="Mensual" <?php echo ($usuario['duracion'] == 'Mensual') ? 'selected' : ''; ?>>Mensual</option>
                            <option value="Anual" <?php echo ($usuario['duracion'] == 'Anual') ? 'selected' : ''; ?>>Anual</option>
                        </select>
                    </div>

                    <!-- Sección de checkboxes para seleccionar los paquetes adicionales -->
                    <div class="mb-3">
                        <label class="form-label">Paquetes Adicionales:</label>
                        <?php foreach ($paquetes as $paquete) : ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="paquetes[]" value="<?php echo $paquete['nombre_paquete']; ?>"
                                    <?php echo in_array($paquete['nombre_paquete'], $paquetes_usuario) ? 'checked' : ''; ?>>
                                <label class="form-check-label"><?php echo ucfirst($paquete['nombre_paquete']); ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Botón para guardar los cambios y enlace para volver a la lista -->
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="lista_usuarios.php" class="btn btn-secondary">Volver al listado</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Se incluyen los scripts de Bootstrap para el correcto funcionamiento de los componentes -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>