<?php
// Incluimos el controlador de usuarios para poder utilizar sus métodos.
require_once '../controlador/UsuariosController.php';

// Creamos una instancia del controlador de usuarios.
$controller = new UsuariosController();
// Obtenemos todos los usuarios desde la base de datos.
$usuarios = $controller->obtenerTodosLosUsuarios();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios - StreamWeb</title>
    <!-- Se incluye el CSS de Bootstrap para estilos modernos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Definimos un color de fondo claro para la página */
        body {
            background: #f0f2f5;
        }

        /* Aplicamos una sombra sutil a las cards para darles un efecto elevado */
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Estilizamos los encabezados de la tabla */
        .table thead th {
            vertical-align: middle;
            border-bottom: 2px solid #dee2e6;
        }
    </style>
</head>

<body>
    <!-- Navbar profesional con fondo azul (primary) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <!-- Enlace al inicio -->
            <a class="navbar-brand" href="../index.php">StreamWeb</a>
            <!-- Botón para colapsar el menú en dispositivos pequeños -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Contenedor principal donde se muestra la lista de usuarios -->
    <div class="container my-5">
        <!-- Utilizamos una card para organizar el contenido de forma profesional -->
        <div class="card">
            <!-- Encabezado de la card -->
            <div class="card-header bg-secondary text-white">
                <h2 class="mb-0">Lista de Usuarios</h2>
            </div>
            <!-- Cuerpo de la card -->
            <div class="card-body">
                <!-- Botón para agregar un nuevo usuario -->
                <div class="mb-4">
                    <a href="alta_usuario.php" class="btn btn-success">Agregar Nuevo Usuario</a>
                </div>

                <!-- Si no hay usuarios, se muestra un mensaje de alerta -->
                <?php if (empty($usuarios)): ?>
                    <div class="alert alert-warning" role="alert">
                        No hay usuarios registrados.
                    </div>
                    <!-- Si hay usuarios, se muestra la tabla -->
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <!-- Encabezados de la tabla -->
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Correo</th>
                                    <th>Edad</th>
                                    <th>Plan</th>
                                    <th>Duración</th>
                                    <th>Paquete</th>
                                    <th>Precio Plan</th>
                                    <th>Precio Paquete</th>
                                    <th>Total Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Recorremos el arreglo de usuarios y mostramos una fila por cada usuario -->
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?php echo $usuario['id_usuario']; ?></td>
                                        <td><?php echo $usuario['nombre']; ?></td>
                                        <td><?php echo $usuario['apellidos']; ?></td>
                                        <td><?php echo $usuario['correo']; ?></td>
                                        <td><?php echo $usuario['edad']; ?></td>
                                        <td><?php echo $usuario['nombre_plan']; ?></td>
                                        <td><?php echo $usuario['duracion']; ?></td>
                                        <td><?php echo $usuario['nombre_paquete']; ?></td>
                                        <td><?php echo $usuario['precio_plan']; ?></td>
                                        <td><?php echo $usuario['precio_paquete']; ?></td>
                                        <td><?php echo $usuario['total_pago']; ?></td>
                                        <td>
                                            <!-- Botón para editar el usuario -->
                                            <a href="editar_usuario.php?id_usuario=<?php echo $usuario['id_usuario']; ?>" class="btn btn-primary btn-sm mb-1">Editar</a>
                                            <!-- Formulario para eliminar el usuario -->
                                            <form action="eliminar_usuario.php" method="POST" style="display:inline-block;">
                                                <!-- Enviamos el id del usuario oculto -->
                                                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                                                <!-- Botón de eliminar con confirmación -->
                                                <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <!-- Enlace para volver a la página principal -->
                <div class="mt-4">
                    <a href="../index.php" class="btn btn-outline-secondary">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap para funcionalidades como el colapso del navbar -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>