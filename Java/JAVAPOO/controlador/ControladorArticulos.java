package controlador;

import vista.*;
import modelo.Articulos;

public class ControladorArticulos {
    private Vista vista;
    private VistaArticulos vArticulo;
    private Articulos articulo;

    public ControladorArticulos() {
        vista = new Vista();         // Inicializar vista general
        articulo = new Articulos();   // Inicializar modelo Articulo
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
                    modificarArticulo();
                    break;
                case 4:
                    eliminarArticulo();
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
        Object[] datosArticulo = vArticulo.obtenerDatosArticulo();
        String nombre = (String) datosArticulo[0];
        double precioUnitario = (double) datosArticulo[1];
        int stock = (int) datosArticulo[2];

        if (articulo.insertarArticulo(nombre, precioUnitario, stock)) {
            vista.mostrarMensaje("Articulo añadido correctamente.");
        } else {
            vista.mostrarMensaje("Error al añadir articulo.");
        }
    }

    public void modificarArticulo() {
        Object[] nuevosDatos = vArticulo.obtenerDatosArticulo();
        String nombre = (String) nuevosDatos[0];
        double precioUnitario = (double) nuevosDatos[1];
        int stock = (int) nuevosDatos[2];

        if (articulo.editarArticulo(nombre, precioUnitario, stock)) {
            vista.mostrarMensaje("Articulo actualizado.");
        } else {
            vista.mostrarMensaje("Error al editar articulo.");
        }
    }

    public void eliminarArticulo() {
        String nombreEliminar = vArticulo.obtenerNombreArticulo();
        if (articulo.eliminarArticulo(nombreEliminar)) {
            vista.mostrarMensaje("Articulo eliminado.");
        } else {
            vista.mostrarMensaje("Error al eliminar articulo.");
        }
    }
}

