package vista;

import java.util.Scanner;
import java.sql.Date;

public class VistaVenta {
    private Scanner scanner;

    public VistaVenta() {
        this.scanner = new Scanner(System.in);
    }

    public Object[] obtenerDatosVenta() {
        System.out.print("Introduce el ID del cliente: ");
        int idCliente = Integer.parseInt(scanner.nextLine());

        System.out.print("Introduce el ID del articulo: ");
        int idArticulo = Integer.parseInt(scanner.nextLine());

        System.out.print("Introduce la cantidad: ");
        int cantidad = Integer.parseInt(scanner.nextLine());

        System.out.print("Introduce la fecha de venta (YYYY-MM-DD): ");
        String fechaStr = scanner.nextLine();
        Date fechaVenta = Date.valueOf(fechaStr);  // convierte String a java.sql.Date

        return new Object[]{idCliente, idArticulo, cantidad, fechaVenta};
    }

    public int obtenerIdVenta() {
        System.out.print("Introduce el ID de la venta: ");
        return Integer.parseInt(scanner.nextLine());
    }
}
