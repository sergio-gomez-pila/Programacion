package controlador;
import vista.*;

public class Controlador {

	 private Vista vista;
	 private ControladorCliente clienteC;
	 private ControladorProveedor proovedorC;
	 private ControladorArticulos articulosC;
	 private ControladorVenta ventasC;
	 private ControladorFacturaRecibida facturaC;
	 
	    public Controlador() {
	        vista = new Vista();                    // Inicializar vista
	        clienteC = new ControladorCliente();    // Inicializar cliente
	        proovedorC = new  ControladorProveedor(); // Inicializar proveedor
	        articulosC = new ControladorArticulos();
	        ventasC = new ControladorVenta();
	        facturaC = new ControladorFacturaRecibida();
	    }
    public void menuPrincipal() {
        int eleccion;
        do {
            eleccion = vista.menuPrincipal();  // Obtener opción del menú
            switch (eleccion) {
                case 1:
                	clienteC.menuClientes();
                    break;
                case 2:
                	proovedorC.menuProveedores();
                    break;
                case 3:
                   articulosC.menuArticulos();
                    break;
                case 4:
                  ventasC.menuVentas();
                    break;
                case 5:
                	facturaC.menuFacturas();
                    break;
                case 6:
                	eleccion = 6;
                    vista.mostrarMensaje("Adios");
                    break;
                default:
                    vista.mostrarMensaje("OPCIÓN INVÁLIDA.");
            }
        } while (eleccion != 6); // Repite hasta que elija salir
    }
}

   

