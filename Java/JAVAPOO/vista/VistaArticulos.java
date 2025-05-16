package vista;

import java.util.Scanner;

public class VistaArticulos {
    private Scanner scanner;

    public VistaArticulos() {
        this.scanner = new Scanner(System.in);
    }

    public Object[] obtenerDatosArticulo() {
        System.out.print("Introduce el nombre del articulo: ");
        String nombre = scanner.nextLine();
        System.out.print("Introduce el precio unitario del articulo: ");
        double precioUnitario = Double.parseDouble(scanner.nextLine());
        System.out.print("Introduce el stock del articulo: ");
        int stock = Integer.parseInt(scanner.nextLine());
        return new Object[]{nombre, precioUnitario, stock};
    }

    public String obtenerNombreArticulo() {
        System.out.print("Introduce el nombre del articulo: ");
        return scanner.nextLine();
    }
}
