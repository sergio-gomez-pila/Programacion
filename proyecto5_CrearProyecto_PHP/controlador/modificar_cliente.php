<?php
require_once 'funciones.php'; // Importar las funciones

$archivo = "../datos/clientes.csv";
$clientes = leerClientes($archivo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cliente</title>
</head>
<body>
    <h1>Listado de Clientes</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Telefono</th>
        </tr>
        <?php foreach ($clientes as $index => $cliente): ?>
            <?php if ($index > 0): ?> <!-- Saltar la cabecera -->
                <tr>
                    <td><?= $cliente[0] ?></td>
                    <td><?= $cliente[1] ?></td>
                    <td><?= $cliente[2] ?></td>
                    <td><?= $cliente[3] ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    <h2>Modificar Cliente</h2>
    <form action="editar_cliente.php" method="POST">
        <label for="id">ID del Cliente a Modificar:</label>
        <input type="number" name="id" id="id" required>
        <button type="submit">Seleccionar</button>
    </form>
</body>
</html>


