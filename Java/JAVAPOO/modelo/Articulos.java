package modelo;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class Articulos {

    // Constructor vacío (puedes añadirlo si quieres con parámetros)

    // Método para buscar si el artículo ya existe por nombre
    public boolean buscarArticulo(String nombre) {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;

        try {
            if (conexion != null) {
                String query = "SELECT * FROM Articulos WHERE nombre=?";
                psSelect = conexion.prepareStatement(query);
                psSelect.setString(1, nombre);
                rs = psSelect.executeQuery();

                if (rs.next()) {
                    return true;  // Artículo encontrado
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } finally {
            try {
                if (rs != null) rs.close();
                if (psSelect != null) psSelect.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return false;  // Artículo no encontrado
    }

    // Método para insertar un artículo
    public boolean insertarArticulo(String nombre, double precioUnitario, int stock) {
        if (buscarArticulo(nombre)) {
            return false; // El artículo ya existe
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psInsert = null;

        try {
            if (conexion != null) {
                String query = "INSERT INTO Articulos (nombre, precio_unitario, stock) VALUES (?, ?, ?)";
                psInsert = conexion.prepareStatement(query);
                psInsert.setString(1, nombre);
                psInsert.setDouble(2, precioUnitario);
                psInsert.setInt(3, stock);
                psInsert.executeUpdate();
                return true; // Artículo insertado correctamente
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } finally {
            try {
                if (psInsert != null) psInsert.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return false;  // Error al insertar el artículo
    }

    // Método para mostrar todos los artículos
    public void mostrarArticulos() {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;

        try {
            if (conexion != null) {
                String query = "SELECT * FROM Articulos";
                psSelect = conexion.prepareStatement(query);
                rs = psSelect.executeQuery();

                System.out.printf("%-10s %-30s %-15s %-10s\n", "ID", "NOMBRE", "PRECIO UNITARIO", "STOCK");
                while (rs.next()) {
                    System.out.printf("%-10d %-30s %-15.2f %-10d\n",
                            rs.getInt("id_articulo"),
                            rs.getString("nombre"),
                            rs.getDouble("precio_unitario"),
                            rs.getInt("stock"));
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } finally {
            try {
                if (rs != null) rs.close();
                if (psSelect != null) psSelect.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    // Método para eliminar un artículo por nombre
    public boolean eliminarArticulo(String nombre) {
        if (!buscarArticulo(nombre)) {
            return false;  // Artículo no encontrado
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psDelete = null;

        try {
            if (conexion != null) {
                String query = "DELETE FROM Articulos WHERE nombre=?";
                psDelete = conexion.prepareStatement(query);
                psDelete.setString(1, nombre);
                psDelete.executeUpdate();
                return true; // Artículo eliminado correctamente
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } finally {
            try {
                if (psDelete != null) psDelete.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return false;  // Error al eliminar el artículo
    }

    // Método para editar un artículo
    public boolean editarArticulo(String nombre, double precioUnitario, int stock) {
        if (!buscarArticulo(nombre)) {
            return false;  // Artículo no encontrado
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psUpdate = null;

        try {
            if (conexion != null) {
                String query = "UPDATE Articulos SET precio_unitario=?, stock=? WHERE nombre=?";
                psUpdate = conexion.prepareStatement(query);
                psUpdate.setDouble(1, precioUnitario);
                psUpdate.setInt(2, stock);
                psUpdate.setString(3, nombre);
                psUpdate.executeUpdate();
                return true; // Artículo actualizado correctamente
            }
        } catch (SQLException e) {
            e.printStackTrace();
        } finally {
            try {
                if (psUpdate != null) psUpdate.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return false;  // Error al actualizar el artículo
    }
}


