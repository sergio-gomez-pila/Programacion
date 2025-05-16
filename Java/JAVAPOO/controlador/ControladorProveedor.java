package controlador;
import modelo.*;
import vista.*;

public class ControladorProveedor {
    private Vista vista;
    private VistaProveedor vistaP;
    private Proveedores proveedor;
    public ControladorProveedor() {
        vista = new Vista();                    // Inicializar vista
        proveedor = new Proveedores(); 		// Inicializar proveedor   
        vistaP = new VistaProveedor();
    }
	public void menuProveedores() {
	
   	 int eleccion;
        do {
            eleccion = vista.menuOperaciones();
            switch (eleccion) {
                case 1:
                   agregarProveedor();
                    break;
                case 2:
               	 proveedor.mostrarProveedores();
                    break;
                case 3:
                	editarProveedor();
                    break;
                case 4:
                	eliminarProveedor();
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
	
public void agregarProveedor() {
	try {
	 String[] datosProveedor = vistaP.obtenerDatosProveedor();
     if (proveedor.insertarProveedor(datosProveedor[0], datosProveedor[1], datosProveedor[2])) {
         vista.mostrarMensaje("Proveedor añadido correctamente.");
     } else {
         vista.mostrarMensaje("Error al añadir Proveedor.");
     }}catch(Exception e) {System.out.println("ERROR: " + e.getMessage());}
}
public void editarProveedor() {
	String[] nuevosDatos = vistaP.obtenerDatosProveedor();
    if (proveedor.editarProveedor(nuevosDatos[0], nuevosDatos[1], nuevosDatos[2])) {
        vista.mostrarMensaje("Proveedor actualizado.");
    } else {
        vista.mostrarMensaje("Error al editar Proveedor.");
    }
}
public void eliminarProveedor() {
	String cifEliminar = vistaP.obtenerCif();
    if (proveedor.eliminarProveedor(cifEliminar)) {
        vista.mostrarMensaje("Proveedor eliminado.");
    } else {
        vista.mostrarMensaje("Error al eliminar Proveedor.");
    }
}
}