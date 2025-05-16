package modelo;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class Cliente {

    // Constructor con parámetros
    // Método para buscar si el cliente ya existe por email
    public boolean buscarCliente(String email) {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;

        try {
            if (conexion != null) {
                String query = "SELECT * FROM Clientes WHERE email=?";
                psSelect = conexion.prepareStatement(query);
                psSelect.setString(1, email);
                rs = psSelect.executeQuery();

                if (rs.next()) {
                    return true;  // Cliente encontrado
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
        return false;  // Cliente no encontrado
    }
    // Método para insertar un cliente
    public boolean insertarCliente(String nombre, String email, String telefono) {
        if (buscarCliente(email)) {
            return false; // El cliente ya existe
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psInsert = null;

        try {
            if (conexion != null) {
                String query = "INSERT INTO Clientes (nombre, email, telefono) VALUES (?, ?, ?)";
                psInsert = conexion.prepareStatement(query);
                psInsert.setString(1, nombre);
                psInsert.setString(2, email);
                psInsert.setString(3, telefono);
                psInsert.executeUpdate();
                return true; // Cliente insertado correctamente
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
        return false;  // Error al insertar el cliente
    }
    // Método para mostrar todos los clientes
    public void mostrarClientes() {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;

        try {
            if (conexion != null) {
                String query = "SELECT * FROM Clientes";
                psSelect = conexion.prepareStatement(query);
                rs = psSelect.executeQuery();

                while (rs.next()) {
                    System.out.printf("%-10s %-25s %-20s %-15s\n",
                            rs.getInt("id_cliente"),
                            rs.getString("nombre"),
                            rs.getString("email"),
                            rs.getString("telefono"));
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
    // Método para eliminar un cliente por email
    public boolean eliminarCliente(String email) {
        if (!buscarCliente(email)) {
            return false;  // Cliente no encontrado
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psDelete = null;

        try {
            if (conexion != null) {
                String query = "DELETE FROM Clientes WHERE email=?";
                psDelete = conexion.prepareStatement(query);
                psDelete.setString(1, email);
                psDelete.executeUpdate();
                return true; // Cliente eliminado correctamente
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
        return false;  // Error al eliminar el cliente
    }
    // Método para editar un cliente
    public boolean editarCliente(String nombre,String telefono, String email, String correo) {
        if (!buscarCliente(correo)) {
            return false;  // Cliente no encontrado
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psUpdate = null;

        try {
            if (conexion != null) {
                String query = "UPDATE Clientes SET nombre=?, telefono=?, email=? WHERE email=?";
                psUpdate = conexion.prepareStatement(query);
                psUpdate.setString(1, nombre);
                psUpdate.setString(2, telefono);
                psUpdate.setString(3, email);
                psUpdate.setString(4, correo);
                
                psUpdate.executeUpdate();
                return true; // Cliente actualizado correctamente
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
        return false;  // Error al actualizar el cliente
    }
}