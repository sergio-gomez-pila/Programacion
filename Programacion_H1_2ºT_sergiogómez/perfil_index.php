<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios sin Planes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">

    <!-- Contenedor principal -->
    <div class="container mt-5">

        <!-- Encabezado -->
        <div class="text-center mb-4">
            <h1 class="display-4">Bienvenido</h1>
            <p class="lead">Selecciona una opción para continuar</p>
        </div>

        <!-- Card para los enlaces -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Opciones Disponibles</h5>

                <!-- Lista de enlaces -->
                <div class="list-group">
                    <a href="vista/lista_usuario.php" class="list-group-item list-group-item-action">Ver Usuarios Registrados</a>
                    <a href="vista/lista_detalles.php" class="list-group-item list-group-item-action">Ver Resumen Usuarios</a>
                    <a href="vista/cerrarsesion.php" class="list-group-item list-group-item-action">Cerrar Sesión</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-dZtvJg1db4zto5Eokf8S5n8lLUyg2dTz5y9r5B6sM9ObcdHKzSH0YAGFxh3hjPh0" crossorigin="anonymous"></script>
</body>

</html>