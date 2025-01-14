<?php
require_once("modelo/tablas.php");

// Leer encabezado y pie
$encabezado = file_get_contents("vistas/encabezado.html");
$pie = file_get_contents("vistas/pie.html");


// Determinar la opción seleccionada
$opcion = $_GET['opcion'] ?? 'clientes';
$subopcion = $_GET['subopcion'] ?? null;

// Generar contenido según la opción
if ($opcion === 'clientes') {
    if ($subopcion === 'ver') {
        $contenido = file_get_contents("datos/clientes.csv", "cliente");
    }
    if ($subopcion === 'añadir') {
        $contenido = file_get_contents("vistas/formulario_cliente.html");
    } elseif ($subopcion === 'editar') {
        $contenido = file_get_contents("controlador/modificar_cliente.php");
    } elseif ($subopcion === 'borrar') {
        $contenido = '
        <h1>Eliminar Cliente</h1>
        <form action="controlador/eliminar_cliente.php" method="POST">
            <label for="id">ID del Cliente a Eliminar:</label>
            <input type="number" id="id" name="id" required>
            <button type="submit">Eliminar Cliente</button>
        </form>';
    } else {
        $contenido = generarTabla("datos/clientes.csv", "cliente");
    }
} elseif ($opcion === 'articulos') {
    $contenido = generarTabla("datos/articulos.csv", "articulo");
} elseif ($opcion === 'proveedores') {
    $contenido = generarTabla("datos/proveedores.csv", "proveedores");
} else {
    $contenido = "<p>Opción no válida</p>";
}


// Renderizar la página
echo $encabezado . $contenido . $pie;
