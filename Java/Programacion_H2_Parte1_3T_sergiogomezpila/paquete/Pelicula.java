package paquete;

// Importamos lo que necesitamos 
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.Scanner;

public class Pelicula {

    private static final String url = "jdbc:mysql://localhost:3306/cine_sergiogomezpila";
    private static final String usuario = "root";
    private static final String contraseña = "root123";

    // Este es el método principal que muestra un menú y hace lo que el usuario elija
    public void menu() {
        Scanner scanner = new Scanner(System.in); // Creamos el lector para leer lo que escribe el usuario
        int opcion;

        do {
            // Mostramos el menú por pantalla
            System.out.println("1 - Ver películas");
            System.out.println("2 - Salir");
            System.out.print("Elige una opción: ");
            opcion = scanner.nextInt(); 

            // Dependiendo de lo que elija, hacemos una cosa u otra
            switch (opcion) {
                case 1:
                    verPeliculas(); // Si pulsa 1, mostramos las pelis
                    break;
                case 2:
                    System.out.println("Hasta luego."); // Si pulsa 2, cerramos el programa
                    break;
                default:
                    System.out.println("Opción no válida."); 
            }
        } while (opcion != 2); // Seguimos en el menú hasta que quiera salir
        scanner.close(); // Cerramos el scanner
    }

    // Este método se conecta a la base de datos y muestra todas las pelis con su género
    public static void verPeliculas() {
        // Consulta para sacar info de pelis y su género
        String consulta = "SELECT p.id_pelicula, p.titulo, p.director, p.ano, p.duracion, g.nombre " +
                          "FROM pelicula p JOIN genero g ON p.id_genero = g.id_genero";

        // Nos conectamos y hacemos la consulta
        try (
            Connection conexion = DriverManager.getConnection(url, usuario, contraseña); // Conexión a la BD
            Statement stmt = conexion.createStatement(); // Creamos el objeto para ejecutar la consulta
            ResultSet rs = stmt.executeQuery(consulta) // Ejecutamos la consulta y guardamos el resultado
        ) {
            
            System.out.printf("%-10s %-25s %-20s %-6s %-9s %-10s\n", 
                              "ID", "Título", "Director", "Año", "Duración", "Género");

            // Recorremos los resultados uno por uno y los mostramos
            while (rs.next()) {
                System.out.printf("%-10s %-25s %-20s %-6d %-9d %-10s\n",
                                  rs.getString("id_pelicula"), 
                                  rs.getString("titulo"), 
                                  rs.getString("director"),
                                  rs.getInt("ano"), 
                                  rs.getInt("duracion"), 
                                  rs.getString("nombre")); 
            }

        } catch (Exception e) {
            // Si algo peta, mostramos el error
            System.out.println("Error al acceder a la base de datos: " + e.getMessage());
        }
    }
}
