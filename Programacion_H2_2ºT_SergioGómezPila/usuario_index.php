<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: #f8f9fa;
            /* Fondo suave */
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #495057;
        }

        .list-group-item {
            transition: all 0.3s ease-in-out;
        }

        .list-group-item:hover {
            background-color: #007bff;
            color: white;
            transform: translateY(-5px);
            /* Efecto de levitamiento */
        }

        .list-group-item:active {
            background-color: #0056b3;
            color: white;
        }

        .list-group-item {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Sombra ligera */
        }
    </style>
</head>

<body class="bg-light text-dark">

    <div class="container">
        <h1 class="text-center">Bienvenido</h1>
        <div class="list-group">
            <a href="vista/editar_usuario.php" class="list-group-item list-group-item-action rounded-3 shadow-sm">Editar Datos</a>
            <a href="vista/agregar_tarea.php" class="list-group-item list-group-item-action rounded-3 shadow-sm">Tareas</a>
            <a href="vista/ver_tarea.php" class="list-group-item list-group-item-action rounded-3 shadow-sm">Ver Tareas</a>
            <a href="vista/cierre_sesion.php" class="list-group-item list-group-item-action rounded-3 shadow-sm">Cerrar Sesión</a>
        </div>
    </div>

</body>

</html>