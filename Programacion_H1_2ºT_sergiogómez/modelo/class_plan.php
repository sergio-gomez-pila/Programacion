<?php
// Se incluyen los archivos necesarios para la conexión a la base de datos y para el controlador de Usuario
require_once '../config/class_conexion.php';
require_once '../controlador/UsuarioController.php';

// Se define la clase Plan que maneja las operaciones relacionadas con los planes de usuario
class Plan
{
    private $conexion; // Se declara la variable para almacenar la conexión a la base de datos

    // Constructor de la clase Plan que establece la conexión a la base de datos
    public function __construct()
    {
        $this->conexion = new Conexion(); // Se instancia la clase Conexion para crear la conexión
    }

    // Método para agregar un plan a un usuario específico
    public function agregarPlan($id_usuario, $id_plan, $id_paquete1, $id_paquete2, $id_paquete3)
    {
        // Consulta SQL para insertar un nuevo plan en la tabla detalles
        $query = "INSERT INTO detalles (id_usuario, id_plan, id_paquete1, id_paquete2, id_paquete3) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta SQL
        $stmt->bind_param("iiiii", $id_usuario, $id_plan, $id_paquete1, $id_paquete2, $id_paquete3); // Asocia los parámetros con la consulta

        // Ejecuta la consulta y verifica si fue exitosa
        if ($stmt->execute()) {
            $stmt->close(); // Cierra la consulta
            return true; // Si la inserción fue exitosa, retorna true
        } else {
            error_log("Error al agregar Plan: " . $stmt->error); // Si hubo un error, lo registra en el log
            $stmt->close(); // Cierra la consulta
            return false; // Retorna false si hubo un error
        }
    }

    // Método para obtener todos los planes disponibles en la base de datos
    public function ObtenerPlan()
    {
        // Consulta SQL para seleccionar todos los planes
        $query = "SELECT * FROM plan";
        $resultado = $this->conexion->conexion->query($query); // Ejecuta la consulta
        $plan = []; // Crea un array vacío para almacenar los resultados

        // Recorre los resultados y los agrega al array
        while ($fila = $resultado->fetch_assoc()) {
            $plan[] = $fila; // Agrega cada fila de resultados al array
        }
        return $plan; // Retorna el array con todos los planes
    }

    // Método para contar cuántos planes tiene un usuario
    public function cantidadPlanes($usuario)
    {
        // Consulta SQL para contar la cantidad de planes asociados a un usuario
        $query = "SELECT COUNT(id_plan) as cantidad FROM detalles WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta SQL
        $stmt->bind_param("i", $usuario); // Asocia el parámetro con el ID del usuario
        $stmt->execute(); // Ejecuta la consulta
        $result = $stmt->get_result(); // Obtiene los resultados
        $row = $result->fetch_assoc(); // Obtiene la cantidad de planes asociados

        // Permite agregar un plan si la cantidad de planes es menor que 1
        if ($row['cantidad'] < 1) {
            $stmt->close(); // Cierra la consulta
            return true; // Retorna true si el usuario puede agregar un plan
        } else {
            $stmt->close(); // Cierra la consulta
            return false; // Retorna false si el usuario ya tiene un plan
        }
    }

    // Método para obtener todos los paquetes disponibles
    public function ObtenerPaquete()
    {
        // Consulta SQL para obtener todos los paquetes
        $query = "SELECT * FROM paquetes";
        $resultado = $this->conexion->conexion->query($query); // Ejecuta la consulta
        $plan = []; // Crea un array vacío para almacenar los resultados

        // Recorre los resultados y los agrega al array
        while ($fila = $resultado->fetch_assoc()) {
            $plan[] = $fila; // Agrega cada fila al array
        }
        return $plan; // Retorna el array con todos los paquetes
    }

    // Método para insertar los paquetes seleccionados por un usuario en el plan
    public function insertarPaquete($id_usuario, $id_plan, $id_paquete1, $id_paquete2, $id_paquete3)
    {
        // 1. Obtener información del usuario
        $query = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta SQL
        $stmt->bind_param("i", $id_usuario); // Asocia el parámetro con el ID del usuario

        error_log("Executing query: " . $query . " with ID: " . $id_usuario); // Registra la ejecución de la consulta

        if (!$stmt->execute()) { // Si ocurre un error al ejecutar la consulta
            error_log("Error executing query: " . $stmt->error); // Registra el error
            return null; // Retorna null si hay un error
        }

        $resultado = $stmt->get_result(); // Obtiene los resultados
        $usuario = $resultado->fetch_assoc(); // Obtiene la información del usuario
        if (!$usuario) { // Si no se encuentra el usuario
            return "Usuario no encontrado"; // Retorna un mensaje de error
        }

        $edad = $usuario['edad']; // Obtiene la edad del usuario

        // 2. Obtener información del plan
        $queryplan = "SELECT * FROM plan WHERE id_plan = ?";
        $stmt = $this->conexion->conexion->prepare($queryplan); // Prepara la consulta SQL
        $stmt->bind_param("i", $id_plan); // Asocia el parámetro con el ID del plan

        error_log("Executing query: " . $queryplan . " with ID: " . $id_plan); // Registra la ejecución de la consulta

        if (!$stmt->execute()) { // Si ocurre un error al ejecutar la consulta
            error_log("Error executing query: " . $stmt->error); // Registra el error
            return null; // Retorna null si hay un error
        }

        $resultado = $stmt->get_result(); // Obtiene los resultados
        $plan = $resultado->fetch_assoc(); // Obtiene la información del plan

        if (!$plan) { // Si no se encuentra el plan
            return "Plan no encontrado"; // Retorna un mensaje de error
        }

        $nombrePlan = $plan['nombre']; // Obtiene el nombre del plan
        $duracionPlan = $plan['duracion_suscripcion']; // Obtiene la duración del plan

        // 3. Obtener información de los paquetes seleccionados
        $paquetesSeleccionados = [$id_paquete1, $id_paquete2, $id_paquete3]; // Arreglo con los paquetes seleccionados
        $paquetesValidos = []; // Arreglo para almacenar los paquetes válidos

        foreach ($paquetesSeleccionados as $id_paquete) { // Recorre los paquetes seleccionados
            if ($id_paquete) { // Solo valida si el paquete no es NULL
                $sqlPaquete = "SELECT nombre FROM Paquetes WHERE id_paquete = ?";
                $stmtPaquete = $this->conexion->conexion->prepare($sqlPaquete); // Prepara la consulta para obtener el nombre del paquete
                $stmtPaquete->bind_param("i", $id_paquete); // Asocia el parámetro con el ID del paquete
                $stmtPaquete->execute(); // Ejecuta la consulta
                $resultadoPaquete = $stmtPaquete->get_result(); // Obtiene los resultados
                $paquete = $resultadoPaquete->fetch_assoc(); // Obtiene la información del paquete

                if ($paquete) { // Si se encuentra el paquete
                    $paquetesValidos[] = $paquete['nombre']; // Agrega el nombre del paquete a los paquetes válidos
                }
            }
        }

        // 4. Validaciones según las reglas establecidas
        if ($edad < 18) { // Si el usuario es menor de 18 años
            if (count($paquetesValidos) > 1 || !in_array("Infantil", $paquetesValidos)) { // Si no selecciona el paquete Infantil o selecciona más de uno
                return "Los menores de 18 años solo pueden contratar el Pack Infantil."; // Retorna un mensaje de error
            }
        }

        if ($nombrePlan === "Básico" && count($paquetesValidos) > 1) { // Si el plan es Básico y selecciona más de un paquete
            return "Los usuarios del Plan Básico solo pueden seleccionar un paquete adicional."; // Retorna un mensaje de error
        }

        if (in_array("Deporte", $paquetesValidos) && $duracionPlan !== "Anual") { // Si selecciona el paquete Deporte pero no es un plan anual
            return "El Pack Deporte solo puede ser contratado si la duración de la suscripción es de 1 año."; // Retorna un mensaje de error
        }

        // 5. Si todas las validaciones pasan, actualiza la tabla Resumen con los paquetes seleccionados
        $sqlUpdate = "UPDATE detalles SET 
    id_paquete1 = ?, 
    id_paquete2 = IFNULL(?, id_paquete2), 
    id_paquete3 = IFNULL(?, id_paquete3) 
WHERE id_usuario = ? AND id_plan = ?";

        $stmtUpdate = $this->conexion->conexion->prepare($sqlUpdate); // Prepara la consulta SQL para actualizar los paquetes
        $stmtUpdate->bind_param("iiiii", $id_paquete1, $id_paquete2, $id_paquete3, $id_usuario, $id_plan); // Asocia los parámetros con la consulta

        if ($stmtUpdate->execute()) {
            return "Paquete actualizado correctamente."; // Confirmamos que la actualización fue exitosa.
        } else {
            return "Error al actualizar el paquete."; // Si hubo un error en la ejecución, se informa.
        }
    }
    // Método para obtener los detalles de un plan de un usuario específico
    public function obtenerid($id_usuario)
    {
        $query = "SELECT * FROM detalles WHERE id_usuario = ?"; // Consulta SQL para obtener los detalles del usuario
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta SQL
        $stmt->bind_param("i", $id_usuario); // Asocia el parámetro con el ID del usuario
        $stmt->execute(); // Ejecuta la consulta
        $resultado = $stmt->get_result(); // Obtiene los resultados
        $stmt->close(); // Cierra la consulta
        return $resultado->fetch_assoc(); // Retorna los detalles del usuario
    }

    // Método para eliminar un plan de un usuario específico
    public function eliminarplan($id_usuario)
    {
        $query = "DELETE FROM detalles WHERE id_usuario = ?"; // Consulta SQL para eliminar el plan
        $stmt = $this->conexion->conexion->prepare($query); // Prepara la consulta SQL
        $stmt->bind_param("i", $id_usuario); // Asocia el parámetro con el ID del usuario

        // Ejecuta la consulta y verifica si fue exitosa
        if ($stmt->execute()) {
            echo "Usuario eliminado con éxito."; // Si es exitoso, muestra un mensaje
        } else {
            echo "Error al eliminar usuario: " . $stmt->error; // Si hay un error, lo muestra
        }
        $stmt->close(); // Cierra la consulta
    }
}
