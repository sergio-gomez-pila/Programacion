package vista;
import java.util.Scanner;

public class Vista {

    private Scanner scanner;

    public Vista() {
        this.scanner = new Scanner(System.in);
    }

    public void mostrarMensaje(String mensaje) {
        System.out.println(mensaje);
    }
    public int menuPrincipal() {
        System.out.println("----- MENÚ GENERAL -----");
        System.out.println("1 - MENU CLIENTES");
        System.out.println("2 - MENU PROVEEDORES");
        System.out.println("3 - MENU ARTICULOS");
        System.out.println("4 - MENU VENTAS");
        System.out.println("5 - MENU FACTURAS");
        System.out.println("6 - SALIR");
        return obtenerOpcion();
    }
    public int menuOperaciones() {
        System.out.println("----- MENÚ -----");
        System.out.println("1 – AÑADIR");
        System.out.println("2 – LISTAR");
        System.out.println("3 – EDITAR");
        System.out.println("4 – ELIMINAR");
        System.out.println("5 – SALIR");
        return obtenerOpcion();
    } 
    public int obtenerOpcion() {
        int opcion;
        while (!scanner.hasNextInt()) {
            scanner.next(); 
            mostrarMensaje("Por favor, ingrese un número válido.");
        }
        opcion = scanner.nextInt();
        scanner.nextLine(); 
        return opcion;
    }
}