<?php
// Se incluye el archivo de configuración para la conexión a la base de datos
require_once '../config/class_conexion.php';

// Se define la clase Usuario para manejar las operaciones de los usuarios
class Usuario
{
    private $conexion; // Se declara la variable para almacenar la conexión a la base de datos

    // El constructor de la clase que crea una nueva conexión a la base de datos
    public function __construct()
    {
        $this->conexion = new Conexion(); // Se instancia la clase Conexion para establecer la conexión
    }

    // Método para agregar un nuevo usuario a la base de datos
    public function agregarUsuario($nombre, $apellidos, $correo, $edad)
    {
        // Consulta SQL para insertar un nuevo usuario
        $query = "INSERT INTO usuarios (nombre, apellidos, correo, edad) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta SQL
        $stmt->bind_param("sssi", $nombre, $apellidos, $correo, $edad); // Asocia los parámetros con la consulta

        // Ejecuta la consulta y revisa si fue exitosa
        if ($stmt->execute()) {
            $stmt->close(); // Cierra la consulta
            return true; // Retorna true si la inserción fue exitosa
        } else {
            error_log("Error al agregar Usuarios: " . $stmt->error); // Si hubo un error, lo guarda en el log
            $stmt->close(); // Cierra la consulta
            return false; // Retorna false si hubo un error
        }
    }

    // Método para obtener todos los usuarios de la base de datos
    public function obtenerUsuario()
    {
        $query = "SELECT * FROM usuarios"; // Consulta SQL para seleccionar todos los usuarios
        $resultado = $this->conexion->conexion->query($query); // Ejecuta la consulta
        $usuario = []; // Crea un array vacío para almacenar los resultados

        // Recorre los resultados y los agrega al array
        while ($fila = $resultado->fetch_assoc()) {
            $usuario[] = $fila; // Agrega cada fila al array
        }
        return $usuario; // Retorna el array con los usuarios
    }

    // Método para obtener los detalles de un usuario por su ID
    public function obtenerUsuarioPorId($id_usuario)
    {
        // Consulta SQL con JOINs para obtener detalles del usuario, incluyendo plan y paquetes
        $query = "SELECT u.*, 
       r.id_detalles, 
       r.id_plan, 
       r.id_paquete1, 
       r.id_paquete2, 
       r.id_paquete3,
       pl.nombre AS Plan_Obtenido,
       CONCAT_WS(', ', p1.nombre, p2.nombre, p3.nombre) AS Paquetes_Obtenidos,
       pl.dispositivos,
       (pl.precio + IFNULL(p1.precio, 0) + IFNULL(p2.precio, 0) + IFNULL(p3.precio, 0)) AS Precio_Total
FROM usuarios u
LEFT JOIN detalles r ON u.id_usuario = r.id_usuario
LEFT JOIN plan pl ON r.id_plan = pl.id_plan
LEFT JOIN paquetes p1 ON r.id_paquete1 = p1.id_paquete
LEFT JOIN paquetes p2 ON r.id_paquete2 = p2.id_paquete
LEFT JOIN paquetes p3 ON r.id_paquete3 = p3.id_paquete
WHERE u.id_usuario = ?;";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta SQL
        $stmt->bind_param("i", $id_usuario); // Asocia el parámetro con la consulta
        $stmt->execute(); // Ejecuta la consulta
        $resultado = $stmt->get_result(); // Obtiene los resultados

        $usuario = []; // Crea un array vacío para almacenar los resultados
        while ($fila = $resultado->fetch_assoc()) {
            $usuario[] = $fila; // Agrega cada fila al array
        }

        if (!$usuario) {
            error_log("No user found with ID: " . $id_usuario); // Registra un mensaje de error si no se encuentra el usuario
        }

        return $usuario; // Retorna el array con los detalles del usuario
    }

    // Método para actualizar los datos de un usuario
    public function actualizarUsuario($id_usuario, $nombre, $apellidos, $correo, $edad)
    {
        // Consulta SQL para actualizar los datos del usuario
        $query = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, edad = ? WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta
        $stmt->bind_param("sssii", $nombre, $apellidos, $correo, $edad, $id_usuario); // Asocia los parámetros con la consulta

        // Ejecuta la consulta y verifica si se ejecutó correctamente
        if ($stmt->execute()) {
            echo "Usuario actualizado con éxito."; // Si fue exitoso, muestra un mensaje
        } else {
            echo "Error al actualizar Usuario: " . $stmt->error; // Si hubo un error, muestra el mensaje de error
        }

        $stmt->close(); // Cierra la consulta
    }

    // Método para eliminar un usuario de la base de datos
    public function eliminarUsuario($id_usuario)
    {
        // Consulta SQL para eliminar un usuario por su ID
        $query = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta
        $stmt->bind_param("i", $id_usuario); // Asocia el parámetro del ID del usuario

        // Ejecuta la consulta y verifica si se ejecutó correctamente
        if ($stmt->execute()) {
            echo "Usuario eliminado con éxito."; // Muestra un mensaje si fue exitoso
        } else {
            echo "Error al eliminar usuario: " . $stmt->error; // Muestra el error si hubo problemas
        }
        $stmt->close(); // Cierra la consulta
    }

    // Método para iniciar sesión como administrador
    public function iniciarSesion($correo, $password)
    {
        // Consulta SQL para obtener un administrador por su correo
        $query = "SELECT * FROM administrador WHERE correo = ?";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta
        $stmt->bind_param("s", $correo); // Asocia el parámetro del correo
        $stmt->execute(); // Ejecuta la consulta
        $resultado = $stmt->get_result(); // Obtiene los resultados
        $usuario = $resultado->fetch_assoc(); // Obtiene los datos del usuario

        // Verifica si el usuario existe y la contraseña es correcta
        if ($usuario && $password) {
            session_start(); // Inicia la sesión
            $_SESSION['id_admin'] = $usuario["usuario"]; // Almacena el ID del usuario en la sesión
            $stmt->close(); // Cierra la consulta
            return $usuario; // Retorna el usuario si el inicio de sesión es exitoso
        } else {
            return false; // Si el correo o la contraseña son incorrectos, retorna false
        }
    }

    // Método para obtener los detalles de un usuario específico
    public function filtrar_usuario($usuario)
    {
        // Consulta SQL para obtener detalles de un usuario específico
        $query = "SELECT * FROM detalles WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta
        $stmt->bind_param("i", $usuario); // Asocia el parámetro del ID de usuario
        $stmt->execute(); // Ejecuta la consulta
        $resultado = $stmt->get_result(); // Obtiene los resultados
        $res = $resultado->fetch_assoc(); // Obtiene una fila de resultados
        $stmt->close(); // Cierra la consulta
        return $res; // Retorna los detalles del usuario
    }

    // Método para obtener todos los detalles de los usuarios, incluyendo planes y paquetes
    public function obtenerdetalles()
    {
        // Consulta SQL para obtener detalles completos de los usuarios con JOINs
        $query = "SELECT 
    u.*, 
    pl.nombre AS Plan_Obtenido,
    CONCAT_WS(', ', p1.nombre, p2.nombre, p3.nombre) AS Paquetes_Obtenidos,
    pl.dispositivos,
    (pl.precio + IFNULL(p1.precio, 0) + IFNULL(p2.precio, 0) + IFNULL(p3.precio, 0)) AS Precio_Total
FROM usuarios u
JOIN detalles r ON u.id_usuario = r.id_usuario
JOIN plan pl ON r.id_plan = pl.id_plan
LEFT JOIN paquetes p1 ON r.id_paquete1 = p1.id_paquete
LEFT JOIN paquetes p2 ON r.id_paquete2 = p2.id_paquete
LEFT JOIN paquetes p3 ON r.id_paquete3 = p3.id_paquete;"; 
        $resultado = $this->conexion->conexion->query($query); // Ejecuta la consulta
        $usuario = []; // Crea un array vacío para almacenar los resultados

        // Recorre los resultados y los agrega al array
        while ($fila = $resultado->fetch_assoc()) {
            $usuario[] = $fila; // Agrega cada fila al array
        }
        return $usuario; // Retorna el array con todos los detalles
    }

    // Método para obtener un usuario específico por su ID
    public function obtenerUsuarioPorId2($id_usuario)
    {
        // Consulta SQL para obtener un usuario por su ID
        $query = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta
        $stmt->bind_param("i", $id_usuario); // Asocia el parámetro del ID
        $stmt->execute(); // Ejecuta la consulta
        $resultado = $stmt->get_result(); // Obtiene los resultados

        $usuario = []; // Crea un array vacío para almacenar los resultados
        while ($fila = $resultado->fetch_assoc()) {
            $usuario[] = $fila; // Agrega cada fila al array
        }

        if (!$usuario) {
            error_log("No user found with ID: " . $id_usuario); // Registra un mensaje de error si no se encuentra el usuario
        }


        return $usuario;
    }

}
