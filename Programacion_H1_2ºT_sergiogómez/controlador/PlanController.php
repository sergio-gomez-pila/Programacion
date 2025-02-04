<?php
// Se incluye la clase 'Plan' que maneja la lógica de negocios relacionada con los planes
require_once '../modelo/class_plan.php';

class PlanController
{
    private $modelo; // Se declara una variable privada para almacenar la instancia de la clase Plan

    // Constructor que inicializa la instancia de la clase Plan
    public function __construct()
    {
        $this->modelo = new Plan(); // Crea una nueva instancia de Plan
    }

    // Método para agregar un plan para un usuario específico
    public function agregarPlan($id_usuario, $id_plan, $id_paquete1, $id_paquete2, $id_paquete3)
    {
        // Llama al método agregarPlan de la clase Plan para registrar el plan en la base de datos
        return $this->modelo->agregarPlan($id_usuario, $id_plan, $id_paquete1, $id_paquete2, $id_paquete3);
    }

    // Método para obtener todos los planes disponibles
    public function ObtenerPlan()
    {
        // Llama al método ObtenerPlan de la clase Plan para obtener los planes
        return $this->modelo->ObtenerPlan();
    }

    // Método para verificar la cantidad de planes asociados a un usuario
    public function cantidadPlanes($usuario)
    {
        // Llama al método cantidadPlanes de la clase Plan para obtener la cantidad de planes de un usuario
        return $this->modelo->cantidadPlanes($usuario);
    }

    // Método para obtener todos los paquetes disponibles
    public function ObtenerPaquete()
    {
        // Llama al método ObtenerPaquete de la clase Plan para obtener los paquetes
        return $this->modelo->ObtenerPaquete();
    }

    // Método para insertar un paquete adicional a un plan de un usuario
    public function insertarPaquete($id_usuario, $id_plan, $id_paquete1, $id_paquete2, $id_paquete3)
    {
        // Llama al método insertarPaquete de la clase Plan para añadir paquetes a un plan
        return $this->modelo->insertarPaquete($id_usuario, $id_plan, $id_paquete1, $id_paquete2, $id_paquete3);
    }

    // Método para obtener los detalles del plan de un usuario por su ID
    public function obtenerid($id_usuario)
    {
        // Llama al método obtenerid de la clase Plan para obtener el plan de un usuario
        return $this->modelo->obtenerid($id_usuario);
    }

    // Método para eliminar el plan de un usuario
    public function eliminarplan($id_usuario)
    {
        // Llama al método eliminarplan de la clase Plan para eliminar un plan de un usuario
        return $this->modelo->eliminarplan($id_usuario);
    }
}
?>
