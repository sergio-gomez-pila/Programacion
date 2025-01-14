<?php
function leerClientes($archivo) {
    $clientes = [];
    if (($handle = fopen($archivo, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $clientes[] = $data;
        }
        fclose($handle);
    }
    return $clientes;
}

function escribirClientes($archivo, $clientes) {
    if (($handle = fopen($archivo, "w")) !== false) {
        foreach ($clientes as $cliente) {
            fputcsv($handle, $cliente);
        }
        fclose($handle);
    }
}
?>
