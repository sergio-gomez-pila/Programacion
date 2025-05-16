package controlador;

import vista.*;
import modelo.Ventas;
import java.sql.Date;

public class ControladorVenta {
    private Vista vista;
    private VistaVenta vVenta;
    private Ventas venta;

    public ControladorVenta() {
        vista = new Vista();       // Vista general (menú y mensajes)
        venta = new Ventas();       // Modelo Venta
        vVenta = new VistaVenta(); // Vista específica para ventas
    }

    public void menuVentas() {
        int eleccion;
        do {
            eleccion = vista.menuOperaciones();
            switch (eleccion) {
                case 1:
                    agregarVenta();
                    break;
                case 2:
                    venta.mostrarVentas();
                    break;
                case 3:
                    modificarVenta();
                    break;
                case 4:
                    eliminarVenta();
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

    public void agregarVenta() {
        Object[] datosVenta = vVenta.obtenerDatosVenta();
        int idCliente = (int) datosVenta[0];
        int idArticulo = (int) datosVenta[1];
        int cantidad = (int) datosVenta[2];
        Date fechaVenta = (Date) datosVenta[3];

        if (venta.insertarVenta(idCliente, idArticulo, cantidad, fechaVenta)) {
            vista.mostrarMensaje("Venta añadida correctamente.");
        } else {
            vista.mostrarMensaje("Error al añadir venta.");
        }
    }

    public void modificarVenta() {
        int idVenta = vVenta.obtenerIdVenta();
        Object[] nuevosDatos = vVenta.obtenerDatosVenta();
        int idCliente = (int) nuevosDatos[0];
        int idArticulo = (int) nuevosDatos[1];
        int cantidad = (int) nuevosDatos[2];
        Date fechaVenta = (Date) nuevosDatos[3];

        if (venta.editarVenta(idVenta, idCliente, idArticulo, cantidad, fechaVenta)) {
            vista.mostrarMensaje("Venta actualizada.");
        } else {
            vista.mostrarMensaje("Error al editar venta.");
        }
    }

    public void eliminarVenta() {
        int idVenta = vVenta.obtenerIdVenta();
        if (venta.eliminarVenta(idVenta)) {
            vista.mostrarMensaje("Venta eliminada.");
        } else {
            vista.mostrarMensaje("Error al eliminar venta.");
        }
    }
}

