package controlador;
import vista.*;
import modelo.Cliente;
public class ControladorCliente {
    private Vista vista;
    private VistaCliente vcliente;
    private Cliente cliente;
    public ControladorCliente() {
        vista = new Vista();        // Inicializar vista
        cliente= new Cliente();    // Inicializar cliente
        vcliente= new VistaCliente();
    }
	public void menuClientes() {
        int eleccion;
        do {
            eleccion = vista.menuOperaciones();
            switch (eleccion) {
                case 1:
                	agregarCliente();
                    break;
                case 2:
                    cliente.mostrarClientes();
                    break;
                case 3:
                    datosClientes();
                    break;
                case 4:
                	eliminarClientes();
                    break;
                case 5:
                	eleccion = 5;
                    vista.mostrarMensaje("Saliendo...");
                    break;
                default:
                    vista.mostrarMensaje("Opción inválida.");
            }
        } while (eleccion != 5);
    }	
	public void agregarCliente() {
		 String[] datosCliente = vcliente.obtenerDatosCliente();
         if (cliente.insertarCliente(datosCliente[0], datosCliente[1], datosCliente[2])) {
             vista.mostrarMensaje("Cliente añadido correctamente.");
         } else {
             vista.mostrarMensaje("Error al añadir cliente.");
         }
	}
	public void datosClientes() {
        String correoComprobar = vcliente.obtenerCorreo();  // correo actual

        if (cliente.buscarCliente(correoComprobar)) {
            String[] nuevosDatos = vcliente.obtenerDatosCliente(); // nombre, email nuevo, telefono

            if (cliente.editarCliente(nuevosDatos[0], nuevosDatos[2], nuevosDatos[1], correoComprobar)) {
                vista.mostrarMensaje("Cliente actualizado.");
            } else {
                vista.mostrarMensaje("Error al editar cliente.");
            }
        } else {
            vista.mostrarMensaje("El correo proporcionado no existe.");
        }
    }
	public void eliminarClientes() {
		 String emailEliminar = vcliente.obtenerCorreo();
         if (cliente.eliminarCliente(emailEliminar)) {
             vista.mostrarMensaje("Cliente eliminado.");
         } else {
             vista.mostrarMensaje("Error al eliminar cliente.");
         }
	}
}