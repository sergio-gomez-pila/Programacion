<?php
// Incluimos el controlador de usuarios para poder usar sus métodos, como agregarUsuario.
require_once '../controlador/UsuariosController.php';

// Creamos una instancia del controlador
$controller = new UsuariosController();

// Inicializamos la variable para almacenar mensajes de error
$error_message = '';

// Si se envía el formulario (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos los datos enviados por el formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];
    $nombre_plan = $_POST['nombre_plan'];
    $duracion = $_POST['duracion'];
    // Si se han seleccionado paquetes adicionales, se guardan en el array, si no, queda vacío
    $paquetes_adicionales = isset($_POST['paquetes']) ? $_POST['paquetes'] : [];

    // Validaciones de acuerdo a las reglas del sistema:
    // 1. Si la edad es menor a 18 y se intenta contratar el paquete Deporte
    if ($edad < 18 && in_array('Deporte', $paquetes_adicionales)) {
        $error_message = "Los usuarios menores de 18 años no pueden contratar el paquete Deporte.";
    }
    // 2. Si la edad es menor a 18 y se intenta contratar el paquete Infantil
    elseif ($edad < 18 && in_array('Infantil', $paquetes_adicionales)) {
        $error_message = "Los usuarios menores de 18 años no pueden contratar el paquete Infantil.";
    }
    // 3. Si el plan es Básico y se seleccionaron más de un paquete adicional
    elseif ($nombre_plan == 'Basico' && count($paquetes_adicionales) > 1) {
        $error_message = "El plan Básico solo permite un paquete adicional.";
    }
    // 4. Si se eligió el paquete Deporte pero la suscripción no es anual
    elseif (in_array('Deporte', $paquetes_adicionales) && $duracion != 'Anual') {
        $error_message = "El paquete Deporte solo puede contratarse con una suscripción anual.";
    }
    // Si pasa todas las validaciones, se intenta agregar el usuario
    else {
        // Llamamos al método agregarUsuario del controlador pasándole los datos recogidos
        $usuario = $controller->agregarUsuario($nombre, $apellidos, $correo, $edad, $nombre_plan, $duracion, $paquetes_adicionales);

        // Si agregarUsuario devuelve false, hubo un error al agregar el usuario
        if (!$usuario) {
            $error_message = "Error al agregar usuario. Por favor, verifica los datos.";
        } else {
            // Si se agregó el usuario correctamente, se muestra un mensaje de éxito
            $success_message = "Usuario agregado con éxito.";
            // Se redirige a la página principal
            header("Location: ../index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario - StreamWeb</title>
    <!-- Se incluye el CSS de Bootstrap para darle un estilo moderno -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Se define un fondo claro para la página */
        body {
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <!-- Navbar Profesional: barra de navegación en la parte superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <!-- Enlace a la página principal -->
            <a class="navbar-brand" href="../index.php">StreamWeb</a>
            <!-- Botón para colapsar el menú en dispositivos pequeños -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Contenedor Principal con margen superior -->
    <div class="container mt-5">
        <!-- Card para dar un aspecto profesional al formulario -->
        <div class="card shadow">
            <!-- Encabezado de la Card -->
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-0">Agregar Usuario</h3>
            </div>
            <!-- Cuerpo de la Card -->
            <div class="card-body">
                <!-- Si existe algún mensaje de error, se muestra en una alerta roja -->
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <!-- Si existe un mensaje de éxito, se muestra en una alerta verde -->
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario para agregar un usuario -->
                <form method="POST" action="" class="mt-4">
                    <!-- Campo para el nombre -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <!-- Campo para los apellidos -->
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>

                    <!-- Campo para el correo electrónico -->
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>

                    <!-- Campo para la edad -->
                    <div class="mb-3">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="number" class="form-control" id="edad" name="edad" required>
                    </div>

                    <!-- Menú desplegable para seleccionar el plan base -->
                    <div class="mb-3">
                        <label for="nombre_plan" class="form-label">Plan Base:</label>
                        <select class="form-select" id="nombre_plan" name="nombre_plan" required>
                            <option value="Basico">Básico</option>
                            <option value="Estandar">Estándar</option>
                            <option value="Premium">Premium</option>
                        </select>
                    </div>

                    <!-- Menú desplegable para seleccionar la duración de la suscripción -->
                    <div class="mb-3">
                        <label for="duracion" class="form-label">Duración de la Suscripción:</label>
                        <select class="form-select" id="duracion" name="duracion" required>
                            <option value="Mensual">Mensual</option>
                            <option value="Anual">Anual</option>
                        </select>
                    </div>

                    <!-- Sección para seleccionar los paquetes adicionales -->
                    <div class="mb-3">
                        <label class="form-label">Paquetes Adicionales:</label>
                        <!-- Checkbox para el paquete Deporte -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="deporte" name="paquetes[]" value="Deporte">
                            <label class="form-check-label" for="deporte">Deporte</label>
                        </div>
                        <!-- Checkbox para el paquete Cine -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="cine" name="paquetes[]" value="Cine">
                            <label class="form-check-label" for="cine">Cine</label>
                        </div>
                        <!-- Checkbox para el paquete Infantil -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="infantil" name="paquetes[]" value="Infantil">
                            <label class="form-check-label" for="infantil">Infantil</label>
                        </div>
                    </div>

                    <!-- Botón para enviar el formulario y agregar el usuario -->
                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap para que funcionen los componentes interactivos (como el navbar colapsable) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>