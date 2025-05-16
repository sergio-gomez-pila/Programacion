package controlador;

import vista.*;
import modelo.FacturaRecibida;
import java.sql.Date;

public class ControladorFacturaRecibida {
    private Vista vista;
    private VistaFacturaRecibida vFactura;
    private FacturaRecibida factura;

    public ControladorFacturaRecibida() {
        vista = new Vista();               // Vista general (menú y mensajes)
        factura = new FacturaRecibida();  // Modelo FacturaRecibida
        vFactura = new VistaFacturaRecibida(); // Vista específica para facturas
    }

    public void menuFacturas() {
        int eleccion;
        do {
            eleccion = vista.menuOperaciones();
            switch (eleccion) {
                case 1:
                    agregarFactura();
                    break;
                case 2:
                    factura.mostrarFacturas();
                    break;
                case 3:
                    modificarFactura();
                    break;
                case 4:
                    eliminarFactura();
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

    public void agregarFactura() {
        Object[] datos = vFactura.obtenerDatosFactura();
        int idProveedor = (int) datos[0];
        Date fecha = (Date) datos[1];
        double total = (double) datos[2];

        if (factura.insertarFactura(idProveedor, fecha, total)) {
            vista.mostrarMensaje("Factura añadida correctamente.");
        } else {
            vista.mostrarMensaje("Error al añadir factura.");
        }
    }

    public void modificarFactura() {
        int idFactura = vFactura.obtenerIdFactura();
        Object[] nuevosDatos = vFactura.obtenerDatosFactura();
        int idProveedor = (int) nuevosDatos[0];
        Date fecha = (Date) nuevosDatos[1];
        double total = (double) nuevosDatos[2];

        if (factura.editarFactura(idFactura, idProveedor, fecha, total)) {
            vista.mostrarMensaje("Factura actualizada.");
        } else {
            vista.mostrarMensaje("Error al editar factura.");
        }
    }

    public void eliminarFactura() {
        int idFactura = vFactura.obtenerIdFactura();
        if (factura.eliminarFactura(idFactura)) {
            vista.mostrarMensaje("Factura eliminada.");
        } else {
            vista.mostrarMensaje("Error al eliminar factura.");
        }
    }
}


