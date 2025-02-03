<?php
require_once '../config/class_conexion.php';

class Usuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    // Agregar un nuevo usuario
    public function agregarUsuario($nombre, $apellidos, $correo, $edad, $nombre_plan, $duracion)
    {
        $query = "INSERT INTO usuarios (nombre, apellidos, correo, edad, nombre_plan, duracion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("ssssss", $nombre, $apellidos, $correo, $edad, $nombre_plan, $duracion);

        if ($stmt->execute()) {
            return true; // Éxito
        } else {
            return false; // Fallo
        }

        $stmt->close();
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios() {
        $query = "SELECT 
        u.id_usuario, 
        u.nombre, 
        u.apellidos, 
        u.correo, 
        u.edad, 
        u.nombre_plan, 
        u.duracion, 
        p.nombre_paquete, 
        CASE u.nombre_plan 
            WHEN 'Basico' THEN 9.99 
            WHEN 'Estandar' THEN 13.99 
            WHEN 'Premium' THEN 17.99 
        END AS precio_plan, 
        CASE p.nombre_paquete 
            WHEN 'Deporte' THEN 6.99 
            WHEN 'Cine' THEN 7.99 
            WHEN 'Infantil' THEN 4.99 
        END AS precio_paquete, 
        (CASE u.nombre_plan 
            WHEN 'Basico' THEN 9.99 
            WHEN 'Estandar' THEN 13.99 
            WHEN 'Premium' THEN 17.99 
        END + 
        CASE p.nombre_paquete 
            WHEN 'Deporte' THEN 6.99 
            WHEN 'Cine' THEN 7.99 
            WHEN 'Infantil' THEN 4.99 
        END) AS total_pago 
    FROM usuarios u 
    JOIN usuarios_paquetes up ON u.id_usuario = up.id_usuario 
    JOIN paquetes p ON up.id_paquete = p.id_paquete;";

        $resultado = $this->conexion->conexion->query($query);
        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }
        return $usuarios;
    }
    

    // Obtener un usuario por su ID
    public function obtenerUsuarioPorId($id_usuario)
    {
        $query = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    // Actualizar un usuario
    /*public function actualizarUsuario($id_usuario, $nombre, $apellidos, $correo, $edad, $nombre_plan, $duracion)
    {
        $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, edad = ?, nombre_plan = ?, duracion = ? WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("ssssssi", $nombre, $apellidos, $correo, $edad, $nombre_plan, $duracion, $id_usuario);
    
        $resultado = $stmt->execute();
        $stmt->close();
    
        return $resultado; // Devuelve true o false
    }
        */
    

    // Eliminar un usuario
    public function eliminarUsuario($id_usuario)
    {
        $query = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
            return true; // Éxito
        } else {
            return false; // Fallo
        }

        $stmt->close();
    }
// Obtener la lista de paquetes disponibles
public function obtenerPaquetes()
{
    $query = "SELECT nombre_paquete FROM paquetes";
    $resultado = $this->conexion->conexion->query($query);
    $paquetes = [];
    while ($fila = $resultado->fetch_assoc()) {
        $paquetes[] = $fila;
    }
    return $paquetes;
}

// Obtener el paquete adicional asignado a un usuario
public function obtenerPaquetePorUsuario($id_usuario)
{
    $query = "SELECT p.nombre_paquete 
              FROM usuarios_paquetes up 
              JOIN paquetes p ON up.id_paquete = p.id_paquete 
              WHERE up.id_usuario = ?";
    $stmt = $this->conexion->conexion->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

// Actualizar usuario incluyendo el paquete adicional
public function actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $edad, $nombre_plan, $duracion, $nombre_paquete)
{
    $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, edad = ?, nombre_plan = ?, duracion = ? WHERE id_usuario = ?";
    $stmt = $this->conexion->conexion->prepare($query);
    $stmt->bind_param("sssissi", $nombre, $apellidos, $email, $edad, $nombre_plan, $duracion, $id_usuario);
    $stmt->execute();

    // Actualizar paquete adicional
    $query_paquete = "UPDATE usuarios_paquetes 
                      SET id_paquete = (SELECT id_paquete FROM paquetes WHERE nombre_paquete = ?) 
                      WHERE id_usuario = ?";
    $stmt_paquete = $this->conexion->conexion->prepare($query_paquete);
    $stmt_paquete->bind_param("si", $nombre_paquete, $id_usuario);
    $stmt_paquete->execute();
    
    return true;
}
}