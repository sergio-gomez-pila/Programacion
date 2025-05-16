package vista;

import java.util.Scanner;
import java.sql.Date;

public class VistaFacturaRecibida {
    private Scanner scanner;

    public VistaFacturaRecibida() {
        this.scanner = new Scanner(System.in);
    }

    public Object[] obtenerDatosFactura() {
        System.out.print("Introduce el ID del proveedor: ");
        int idProveedor = Integer.parseInt(scanner.nextLine());
        System.out.print("Introduce la fecha (YYYY-MM-DD): ");
        String fechaStr = scanner.nextLine();
        Date fecha = Date.valueOf(fechaStr);  // convierte String a java.sql.Date
        System.out.print("Introduce el total de la factura: ");
        double total = Double.parseDouble(scanner.nextLine());

        return new Object[]{idProveedor, fecha, total};
    }

    public int obtenerIdFactura() {
        System.out.print("Introduce el ID de la factura: ");
        return Integer.parseInt(scanner.nextLine());
    }
}

