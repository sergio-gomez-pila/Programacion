<?php
require_once '../config/class_conexion.php';

class Usuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function agregarUsuario($nombre, $apellidos, $correo, $contraseña)
    {
        $contraseñaCifrada = password_hash($contraseña, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuarios (nombre, apellidos, correo, contraseña) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("ssss", $nombre, $apellidos, $correo, $contraseñaCifrada);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            error_log("Error al agregar Usuarios: " . $stmt->error);
            $stmt->close();
            return false;
        }

    } 
    public function iniciarSesion($correo, $password)
    {
        $query = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        // Verifica la contraseña
        if ($usuario && password_verify($password,$usuario['contraseña'])) {
            // Inicia la sesión
            session_start();
            // Guarda los datos del usuario en la sesión
            $_SESSION['id_usuario'] = $usuario["usuario"];
            $stmt->close();
            return $usuario; // Inicio de sesión exitoso
        } else {
            return false; // Contraseña o correo incorrectos
        }
    }
    public function actualizarUsuario($id_usuario, $nombre, $apellidos, $correo, $contraseña)
    {
        if (!empty($contraseña)){
            $contraseñaCifrada = password_hash($contraseña, PASSWORD_DEFAULT);
            $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, contraseña = ? WHERE id_usuario = ?";
            $stmt = $this->conexion->conexion->prepare($query);
            $stmt->bind_param("ssssi", $nombre, $apellidos, $correo, $contraseñaCifrada, $id_usuario);
            $stmt->execute();
        }else{
            $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ? WHERE id_usuario = ?";
            $stmt = $this->conexion->conexion->prepare($query);
             $stmt->bind_param("sssi", $nombre, $apellidos, $correo,  $id_usuario);
             $stmt->execute();
        }

}
public function obtenerUsuarioporID($id_usuario)
    {
        $query = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i",$id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt ->close();
        return $resultado->fetch_assoc();
    }
    public function eliminarUsuario($id_usuario)
    {
        $query = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
            echo "Usuario eliminado con éxito.";
        } else {
            echo "Error al eliminar usuario: " . $stmt->error;
        }
        $stmt->close();
    }
    public function AgregarTarea($id_usuario,$descripcion)
    {
        $query = "INSERT INTO tarea (id_usuario, descripcion) VALUES (?, ?)";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("is", $id_usuario, $descripcion);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            error_log("Error al agregar Tarea: " . $stmt->error);
            $stmt->close();
            return false;
        }
    } 
    public function obtenerTarea($id_usuario)
    {
        $query = "SELECT id_tarea, descripcion, estado  FROM tarea WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i",$id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $resultado2 = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt ->close();
        return $resultado2;

    }
    public function eliminarTarea($id_tarea)
    {
        $query = "DELETE FROM tarea WHERE id_tarea = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id_tarea);
        if ($stmt->execute()) {
            echo "tarea eliminado con éxito.";
        } else {
            echo "Error al eliminar tarea: " . $stmt->error;
        }
        $stmt->close();
        return TRUE;
    }
    public function actualizarTarea($id_tarea, $estado)
    {
            $query = "UPDATE tarea SET estado= ? WHERE id_tarea = ?";
            $stmt = $this->conexion->conexion->prepare($query);
            $stmt->bind_param("si", $estado, $id_tarea);
            $stmt->execute();
            return true;

}
}