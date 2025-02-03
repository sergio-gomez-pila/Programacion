<?php
require_once '../modelo/class_usuario.php';

class UsuariosController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Usuario();
    }

    // Agregar un nuevo usuario con paquete adicional
    public function agregarUsuario($nombre, $apellidos, $email, $edad, $nombre_plan, $duracion, $nombre_paquete)
    {
        return $this->modelo->agregarUsuario($nombre, $apellidos, $email, $edad, $nombre_plan, $duracion, $nombre_paquete);
    }

    // Obtener todos los usuarios
    public function obtenerTodosLosUsuarios()
    {
        return $this->modelo->obtenerUsuarios();
    }

    // Obtener un usuario por su ID
    public function obtenerUsuarioPorId($id_usuario)
    {
        return $this->modelo->obtenerUsuarioPorId($id_usuario);
    }

    // Obtener la lista de paquetes disponibles
    public function obtenerPaquetes()
    {
        return $this->modelo->obtenerPaquetes();
    }

    // Obtener el paquete adicional de un usuario
    public function obtenerPaquetePorUsuario($id_usuario)
    {
        return $this->modelo->obtenerPaquetePorUsuario($id_usuario);
    }

    // Actualizar la información de un usuario, incluyendo su paquete adicional
    public function actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $edad, $nombre_plan, $duracion, $nombre_paquete)
    {
        return $this->modelo->actualizarUsuario($id_usuario, $nombre, $apellidos, $email, $edad, $nombre_plan, $duracion, $nombre_paquete);
    }

    // Eliminar un usuario
    public function eliminarUsuario($id_usuario)
    {
        return $this->modelo->eliminarUsuario($id_usuario);
    }
}


