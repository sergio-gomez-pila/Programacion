<?php
require_once 'funciones.php';

$archivo = "../datos/clientes.csv";
$clientes = leerClientes($archivo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
</head>
<body>
    <h1>Listado de Clientes</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
        </tr>
        <?php foreach ($clientes as $index => $cliente): ?>
            <?php if ($index > 0): ?>
                <tr>
                    <td><?= $cliente[0] ?></td>
                    <td><?= $cliente[1] ?></td>
                    <td><?= $cliente[2] ?></td>
                    <td><?= $cliente[3] ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    <h2>Eliminar Cliente</h2>
    <form action="eliminar_cliente.php" method="POST">
        <label for="id">ID del Cliente:</label>
        <input type="number" name="id" id="id" required>
        <button type="submit">Eliminar</button>
    </form>
</body>
</html>
