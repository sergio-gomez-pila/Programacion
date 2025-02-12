<?php
session_start();
require_once '../controlador/UsuarioController.php'; 
$controller = new UsuarioController();
$error_message = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $usuario = $controller->iniciarSesion($correo, $contraseña);
    if (!$usuario) {
        $error_message = "Datos equivocados, prueba de nuevo.";
    } else {
        $_SESSION['usuario'] = $usuario; 
        $_SESSION['success_message'] = "Usuario reconocido con éxito."; 
        header('Location: ../usuario_index.php'); 
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnymDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(45deg, #f06, #f79c42); /* Fondo degradado elegante */
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .login-container h1 {
            font-size: 1.8em;
            font-weight: 600;
            text-align: center;
            color: #333;
        }
        .alert {
            margin-bottom: 20px;
            font-size: 1em;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <h1>Iniciar Sesión</h1>

            <!-- Mensaje de error -->
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Mensaje de éxito -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success text-center" role="alert">
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de inicio de sesión -->
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" required placeholder="Ingrese su correo">
                </div>

                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contraseña" name="contraseña" required placeholder="Ingrese su contraseña">
                </div>

                <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>

</html>


