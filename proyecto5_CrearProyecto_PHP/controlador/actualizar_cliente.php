<?php
require_once 'funciones.php';

$archivo = "../datos/clientes.csv";

$id = $_POST["id"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$correo = $_POST["correo"] ?? null;
$telefono = $_POST["telefono"] ?? null;

if ($id !== null && $nombre !== null && $correo !== null && $telefono !== null) {
    $clientes = leerClientes($archivo);

    foreach ($clientes as $index => $cliente) {
        if ($index > 0 && $cliente[0] == $id) {
            $clientes[$index] = [$id, $nombre, $correo, $telefono];
            break;
        }
    }

    escribirClientes($archivo, $clientes);

    echo "<h1>Cliente actualizado con éxito</h1>";
    echo "<a href='modificar_cliente.php'>Volver al listado</a>";
} else {
    echo "<h1>Error: Datos incompletos</h1>";
    echo "<a href='modificar_cliente.php'>Volver al formulario</a>";
}