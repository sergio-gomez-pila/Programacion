package paquete;
import java.util.ArrayList;
import java.util.Scanner;

public class Veterinario {
	 ArrayList<Animal> listaAnimales = new ArrayList<>(); // Aquí se guardan todos los animales registrados
	 Scanner scanner = new Scanner(System.in);// Para leer lo que escribe el usuario por consola
	public void añadirAnimal() {
		// Añadimos un perro y un gato como ejemplo o iniciales
		listaAnimales.add(new Perro("123", "Rex", 3, "Labrador", false, "grande"));
		listaAnimales.add(new Gato("456", "Misu", 2, "Egipcio", true, true));
		
		System.out.println("Introduce un nuevo animal( 1. perro / 2.Gato): ");
		int tipo = scanner.nextInt(); // Leemos si quiere añadir perro o gato
		scanner.nextLine();  // Limpiamos el buffer
		
		System.out.println("Introduce el numero del chip: ");
		String n_chip = scanner.nextLine();// Leemos el chip del animal
		// Comprobamos si ya existe ese chip
		 if (existeChip(n_chip)) {
		        System.out.println("Ya existe un animal con ese número de chip.");
		        return; // Salimos del método si ya existe
		    }
		// Pedimos los datos comunes a todos los animales
		 System.out.println("Introduce el nombre: ");
		    String nombre = scanner.nextLine();

		    System.out.println("Introduce la edad: ");
		    int edad = scanner.nextInt();
		    scanner.nextLine();

		    System.out.println("Introduce la raza: ");
		    String raza = scanner.nextLine();

		    System.out.println("Introduce si esta adoptado (True o False):  ");
		    boolean adoptado = scanner.nextBoolean();
		    scanner.nextLine();
		 // Según el tipo, pedimos el dato extra y creamos el objeto correspondiente
		    if (tipo == 1) { 
		        System.out.println("Introduce el tamaño (pequeño, mediano, grande): ");
		        String tamaño = scanner.nextLine();
		        listaAnimales.add(new Perro(n_chip, nombre, edad, raza, adoptado, tamaño));
		    } else if (tipo == 2) { 
		        System.out.println("Tiene lucemia, introduce True o False:  ");
		        boolean test_Leucemia = scanner.nextBoolean();
		        scanner.nextLine();
		        listaAnimales.add(new Gato(n_chip, nombre, edad, raza, adoptado, test_Leucemia));
		    } else {
		        System.out.println("Opción no válida");
		    }
		}
	
	public void buscarChip() {
		// Buscamos un animal por su chip
		System.out.println("Introduce el numero del chip: ");
		String numero_chip = scanner.nextLine();
		boolean buscar = false;
		for (Animal animal: listaAnimales) {
			if(animal.getNumero_chip().equals(numero_chip)) {
				animal.mostrar(); // Si lo encuentra, muestra sus datos
				buscar = true;
				
			}
		}
		if(!buscar) {
			System.out.println("No se ha encontrado ningun animal con ese chip");
		}
	}
	private boolean existeChip(String chip) {
		// Comprueba si ya hay un animal con ese número de chip
        for (Animal animal : listaAnimales) {
            if (animal.getNumero_chip().equals(chip)) {
                return true;
            }
        }
        return false;
}
	public void menu() {
		// Muestra el menú para que el usuario elija qué hacer
        int opcion;
        do {
            System.out.println(" MENÚ VETERINARIO ");
            System.out.println("1. Añadir animal: ");
            System.out.println("2. Buscar número de chip: ");
            System.out.println("3. Salir: ");
            System.out.print("Elige una opción: ");
            opcion = scanner.nextInt();
            scanner.nextLine();

            switch (opcion) {
                case 1:
                    añadirAnimal(); // Llama al método para añadir animal
                    break;
                case 2:
                    buscarChip(); // Llama al método para buscar animal por chip
                    break;
                case 3:
                    System.out.println("Adios");  // Mensaje de salida
                    break;
                default:
                    System.out.println("Opción no válida");
            }
        } while (opcion != 3); // El menú se repite hasta que elija salir
	}
    } 
	