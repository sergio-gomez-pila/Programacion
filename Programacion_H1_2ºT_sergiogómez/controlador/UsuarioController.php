<?php
// Se incluye la clase 'Usuario' que maneja la lógica de negocios relacionada con los usuarios
require_once '../modelo/class_usuario.php';

class UsuarioController
{
    private $usuario; // Se declara una variable privada para almacenar la instancia de la clase Usuario

    // Constructor que inicializa la instancia de la clase Usuario
    public function __construct()
    {
        $this->usuario = new Usuario(); // Crea una nueva instancia de Usuario
    }

    // Método para agregar un nuevo usuario
    public function agregarUsuario($nombre, $apellidos, $correo, $edad)
    {
        // Llama al método agregarUsuario de la clase Usuario para registrar el usuario en la base de datos
        return $this->usuario->agregarUsuario($nombre, $apellidos, $correo, $edad);
    }

    // Método para obtener todos los usuarios
    public function obtenerUsuario()
    {
        // Llama al método obtenerUsuario de la clase Usuario para obtener todos los usuarios
        return $this->usuario->obtenerUsuario();
    }

    // Método para obtener un usuario por su ID
    public function obtenerUsuarioPorId($id_usuario)
    {
        // Llama al método obtenerUsuarioPorId de la clase Usuario para obtener un usuario específico
        return $this->usuario->obtenerUsuarioPorId($id_usuario);
    }

    // Método para actualizar los datos de un usuario
    public function actualizarUsuario($id_usuario, $nombre, $apellidos, $correo, $edad)
    {
        // Llama al método actualizarUsuario de la clase Usuario para actualizar la información del usuario
        $this->usuario->actualizarUsuario($id_usuario, $nombre, $apellidos, $correo, $edad);
    }

    // Método para eliminar un usuario por su ID
    public function eliminarUsuario($id_usuario)
    {
        // Llama al método eliminarUsuario de la clase Usuario para eliminar un usuario de la base de datos
        $this->usuario->eliminarUsuario($id_usuario);
    }

    // Método para iniciar sesión, verificando las credenciales del usuario
    public function iniciarSesion($correo, $contraseña)
    {
        // Llama al método iniciarSesion de la clase Usuario para autenticar al usuario
        return $this->usuario->iniciarSesion($correo, $contraseña);
    }

    // Método para filtrar usuarios según algún criterio
    public function filtrar_usuario($usuario)
    {
        // Llama al método filtrar_usuario de la clase Usuario para obtener usuarios filtrados
        return $this->usuario->filtrar_usuario($usuario);
    }

    // Método para obtener los detalles de un usuario
    public function obtenerdetalles()
    {
        // Llama al método obtenerdetalles de la clase Usuario para obtener los detalles de un usuario
        return $this->usuario->obtenerdetalles();
    }

    // Otro método para obtener un usuario por su ID (parece redundante con obtenerUsuarioPorId)
    public function obtenerUsuarioPorId2($id_usuario)
    {
        // Llama al método obtenerUsuarioPorId2 de la clase Usuario
        return $this->usuario->obtenerUsuarioPorId2($id_usuario);
    }
}
?>
