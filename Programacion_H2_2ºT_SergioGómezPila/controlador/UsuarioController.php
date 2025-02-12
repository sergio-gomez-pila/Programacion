<?php
require_once '../modelo/class_usuario.php';

class UsuarioController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function agregarUsuario($nombre, $apellidos, $correo, $contraseña)
    {
        return $this->usuario->agregarUsuario($nombre, $apellidos, $correo, $contraseña);
    }
    public function iniciarSesion($correo, $contraseña)
    {
        return $this->usuario->iniciarSesion($correo, $contraseña);
    }
    public function actualizarUsuario($id_usuario, $nombre, $apellidos, $correo, $contraseña)
    {
        return $this->usuario->actualizarUsuario($id_usuario, $nombre, $apellidos, $correo, $contraseña);
    }
    public function obtenerUsuarioporID($id_usuario)
    {
        return $this->usuario->obtenerUsuarioporID($id_usuario);
    }
    public function eliminarUsuario($id_usuario)
    {
        return $this->usuario->eliminarUsuario($id_usuario);
    }
    public function AgregarTarea($id_usuario,$descripcion){
        return $this->usuario->AgregarTarea($id_usuario,$descripcion);
    }
    public function ObtenerTarea($id_usuario){
        return $this->usuario->ObtenerTarea($id_usuario);
    }
    public function eliminarTarea($id_tarea){
        return $this->usuario->eliminarTarea($id_tarea);
    }
    public function actualizarTarea($id_tarea, $estado){
        return $this->usuario->actualizarTarea($id_tarea, $estado);
    }


}
