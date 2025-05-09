package paquete;
// Importamos lo que necesitamos para conectarnos a la base de datos
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
public class ConexionBasica {
public static void main(String[] args) {
// Dirección para conectar con mi base de datos en MySQL
String url = "jdbc:mysql://localhost:3306/cine_sergiogomezpila";
// Aquí van el usuario y la contraseña de MySQL
String usuario = "root";
String contraseña = "root";
try {
// Probamos a conectar con la base
Connection conexion = DriverManager.getConnection(url, usuario, contraseña);
// Si todo va bien, avisamos por consola
System.out.println("¡Conexión exitosa!");
conexion.close();
} catch (SQLException e) {
// Si algo falla, lo contamos por consola
System.out.println("Error de conexión: " + e.getMessage());
}
}
}