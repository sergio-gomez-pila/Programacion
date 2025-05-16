package controlador;
import vista.*;
import modelo.Articulos;
public class ControladorArticulos {
    private Vista vista;
    private VistaArticulos vArticulo;
    private Articulos articulo;
    public ControladorArticulos() {
        vista = new Vista();         // Inicializar vista
        articulo = new Articulos();   // Inicializar articulo
        vArticulo = new VistaArticulos();
    }
    public void menuArticulos() {
        int eleccion;
        do {
            eleccion = vista.menuOperaciones();
            switch (eleccion) {
                case 1:
                    agregarArticulo();
                    break;
                case 2:
                    articulo.mostrarArticulos();
                    break;
                case 3:
                    datosArticulos();
                    break;
                case 4:
                    eliminarArticulos();
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
    public void agregarArticulo() {
        String[] datosArticulo = (String[]) vArticulo.obtenerDatosArticulo(); // suponiendo devuelve String[]
        String nombre = datosArticulo[0];
        double precioUnitario = Double.parseDouble(datosArticulo[1]);
        int stock = Integer.parseInt(datosArticulo[2]);

        if (articulo.insertarArticulo(nombre, precioUnitario, stock)) {
            vista.mostrarMensaje("Articulo añadido correctamente.");
        } else {
            vista.mostrarMensaje("Error al añadir articulo.");
        }
    }

    public void datosArticulos() {
        String nombreComprobar = vArticulo.obtenerNombreArticulo();  // nombre actual

        if (articulo.buscarArticulo(nombreComprobar)) {
            Object[] nuevosDatos = vArticulo.obtenerDatosArticulo(); // devuelve Object[]

            String nombreNuevo = (String) nuevosDatos[0];
            double precioUnitario = (double) nuevosDatos[1];
            int stock = (int) nuevosDatos[2];

            if (articulo.editarArticulo(nombreNuevo, stock, precioUnitario, nombreComprobar)) {
                vista.mostrarMensaje("Articulo actualizado.");
            } else {
                vista.mostrarMensaje("Error al editar articulo.");
            }
        } else {
            vista.mostrarMensaje("El nombre del articulo proporcionado no existe.");
        }
    }


    public void eliminarArticulos() {
        String nombreEliminar = vArticulo.obtenerNombreArticulo();
        if (articulo.eliminarArticulo(nombreEliminar)) {
            vista.mostrarMensaje("Articulo eliminado.");
        } else {
            vista.mostrarMensaje("Error al eliminar articulo.");
        }
    }
}



