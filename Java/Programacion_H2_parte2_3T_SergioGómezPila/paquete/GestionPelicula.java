package paquete;

import java.sql.*;
import java.util.Scanner;

public class GestionPelicula {
// Definimos las variables para la conexión a la base de datos
	private static final String url = "jdbc:mysql://localhost:3306/cine_sergiogomezpila";
    private static final String usuario = "root";
    private static final String contraseña = "root";

// Método para ver todas las películas
    public void verPeliculas() {
// Consulta SQL para obtener los detalles de las películas con su género
        String consulta = "SELECT p.id_pelicula, p.titulo, p.director, p.ano, p.duracion, g.nombre " +
                          "FROM pelicula p JOIN genero g ON p.id_genero = g.id_genero";
// Conexión a la base de datos y ejecución de la consulta
        try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña);
             PreparedStatement ps = conexion.prepareStatement(consulta);
             ResultSet rs = ps.executeQuery()) {

            System.out.printf("%-10s %-25s %-20s %-6s %-9s %-10s\n",
                    "ID", "TITULO", "DIRECTOR", "AÑO", "DURACION", "GENERO");

            while (rs.next()) {
                System.out.printf("%-10s %-25s %-20s %-6d %-9d %-10s\n",
                        rs.getString("id_pelicula"),
                        rs.getString("titulo"),
                        rs.getString("director"),
                        rs.getInt("ano"),
                        rs.getInt("duracion"),
                        rs.getString("nombre"));
            }

        } catch (SQLException e) {
            System.out.println("Error al mostrar peliculas: " + e.getMessage());
        }
    }
// Método para añadir una nueva película a la base de datos
public void anadirPelicula(Scanner scanner) {
        try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña)) {
            System.out.print("Id de la Pelicula: ");
            String id = scanner.nextLine();

            String comprobar = "SELECT COUNT(*) FROM pelicula WHERE id_pelicula = ?";
            PreparedStatement psCheck = conexion.prepareStatement(comprobar);
            psCheck.setString(1, id);
            ResultSet rs = psCheck.executeQuery();
            rs.next();
            if (rs.getInt(1) > 0) {
                System.out.println("Ya existe esta pelicula con este id.");
                return;
            }
         // Pedimos al usuario los demás datos de la película
            System.out.print("Titulo: ");
            String titulo = scanner.nextLine();
            System.out.print("Director: ");
            String director = scanner.nextLine();
            System.out.print("Año: ");
            int ano = scanner.nextInt();
            System.out.print("DURACION (min): ");
            int duracion = scanner.nextInt();
            scanner.nextLine();
            System.out.print("GENERO (Accion, Comedia, Drama):  ");
            String nombreGenero = scanner.nextLine();
            String buscarGenero = "SELECT id_genero FROM genero WHERE LOWER(nombre) = LOWER(?)";
            PreparedStatement psGenero = conexion.prepareStatement(buscarGenero);
            psGenero.setString(1, nombreGenero);
            ResultSet rsGenero = psGenero.executeQuery();

            if (!rsGenero.next()) {
                System.out.println("El genero '" + nombreGenero + "'no existe");
                return;
            }
            String idGenero = rsGenero.getString("id_genero");
         // Insertamos la nueva película en la base de datos
            String insertar = "INSERT INTO pelicula VALUES (?, ?, ?, ?, ?, ?)";
            PreparedStatement psInsertar = conexion.prepareStatement(insertar);
            psInsertar.setString(1, id);
            psInsertar.setString(2, titulo);
            psInsertar.setString(3, director);
            psInsertar.setInt(4, ano);
            psInsertar.setInt(5, duracion);
            psInsertar.setString(6, idGenero);

            psInsertar.executeUpdate();
            System.out.println("Pelicula añadida");

        } catch (SQLException e) {
            System.out.println("Error al añadir en la pelicula " + e.getMessage());
        }
    }
// Método para eliminar una película de la base de datos
    public void eliminarPelicula(Scanner scanner) {
        System.out.print("Id de la pelicula que quieres eliminar: ");
        String id = scanner.nextLine();

        try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña)) {
            String eliminar = "DELETE FROM pelicula WHERE id_pelicula = ?";
            PreparedStatement ps = conexion.prepareStatement(eliminar);
            ps.setString(1, id);
         // Ejecutamos la eliminación y mostramos si fue exitosa
            int filas = ps.executeUpdate();

            if (filas > 0) {
                System.out.println("Pelicula eliminada");
            } else {
                System.out.println("No existe una pelicula con ese id ");
            }

        } catch (SQLException e) {
            System.out.println("Error al eliminar" + e.getMessage());
        }
    }
 // Método para modificar una película en la base de datos
    public void modificarPelicula(Scanner scanner) {
        System.out.print("Id de la pelicula a modificar:  ");
        String id = scanner.nextLine();

        try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña)) {
            System.out.print("Nuevo titulo: ");
            String nuevoTitulo = scanner.nextLine();
            System.out.print("Nuevo Director ");
            String nuevoDirector = scanner.nextLine();
         // Consulta SQL para actualizar los datos de la película
            String actualizar = "UPDATE pelicula SET titulo = ?, director = ? WHERE id_pelicula = ?";
            PreparedStatement ps = conexion.prepareStatement(actualizar);
            ps.setString(1, nuevoTitulo);
            ps.setString(2, nuevoDirector);
            ps.setString(3, id);

            int filas = ps.executeUpdate();
            if (filas > 0) {
                System.out.println("Pelicula modificada");
            } else {
                System.out.println("No existe una pelicula con ese id");
            }

        } catch (SQLException e) {
            System.out.println("Erro al modificar " + e.getMessage());
        }
    }
}
