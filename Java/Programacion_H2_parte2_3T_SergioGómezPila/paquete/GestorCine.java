package paquete;

import java.util.Scanner;

public class GestorCine {
	 // Creamos una instancia de la clase GestionPelicula
    private final GestionPelicula dao = new GestionPelicula();
    private final Scanner scanner = new Scanner(System.in);
 // Método para mostrar el menú
    public void menu() {
        int opcion;
        do {
            System.out.println("\nMENU CINE:");
            System.out.println("1 - VER PELICULAS");
            System.out.println("2 - AÑADIR PELICULA");
            System.out.println("3 - ELIMINAR PELICULA");
            System.out.println("4 - MODIFICAR PELICULA");
            System.out.println("5 - SALIR");
            System.out.print("SELECCIONA OPCION: ");
            opcion = Integer.parseInt(scanner.nextLine());
         // Dependiendo de la opción seleccionada, llamamos al método correspondiente
            switch (opcion) {
                case 1 -> dao.verPeliculas();
                case 2 -> dao.anadirPelicula(scanner);
                case 3 -> dao.eliminarPelicula(scanner);
                case 4 -> dao.modificarPelicula(scanner);
                case 5 -> System.out.println("Adiosssssssssssssssssssssss");
                default -> System.out.println("Opcion no valida");
            }

        } while (opcion != 5);
        scanner.close();
    }
}
