package vista;
import java.util.Scanner;
public class VistaCliente {
    private Scanner scanner;

    public VistaCliente() {
        this.scanner = new Scanner(System.in);
    }
    public String[] obtenerDatosCliente() {
        System.out.print("Introduce el nombre del cliente: ");
        String nombre = scanner.nextLine();
        System.out.print("Introduce el correo del cliente: ");
        String email = scanner.nextLine();
        System.out.print("Introduce el teléfono del cliente: ");
        String telefono = scanner.nextLine();
        return new String[]{nombre, email, telefono};
    }
    public String obtenerCorreo() {
        System.out.print("Introduce el correo del cliente: ");
        return scanner.nextLine();
    }
}


