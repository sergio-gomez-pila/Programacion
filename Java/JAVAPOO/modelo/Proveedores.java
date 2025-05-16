package modelo;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class Proveedores {

    // Método para buscar si el proveedor ya existe por CIF
    public boolean buscarProveedor(String cif) {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;

        try {
            if (conexion != null) {
                String query = "SELECT * FROM Proveedores WHERE cif=?";
                psSelect = conexion.prepareStatement(query);
                psSelect.setString(1, cif);
                rs = psSelect.executeQuery();

                if (rs.next()) {
                    return true;  // Proveedor encontrado
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
        return false;  // Proveedor no encontrado
    }

    // Método para insertar un proveedor
    public boolean insertarProveedor(String nombre, String cif, String telefono) {
        if (buscarProveedor(cif)) {
            return false; // El proveedor ya existe
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psInsert = null;

        try {
            if (conexion != null) {
                String query = "INSERT INTO Proveedores (nombre, cif, telefono) VALUES (?, ?, ?)";
                psInsert = conexion.prepareStatement(query);
                psInsert.setString(1, nombre);
                psInsert.setString(2, cif);
                psInsert.setString(3, telefono);
                psInsert.executeUpdate();
                return true; // Proveedor insertado correctamente
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
        return false;  // Error al insertar el proveedor
    }

    // Método para mostrar todos los proveedores
    public void mostrarProveedores() {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;

        try {
            if (conexion != null) {
                String query = "SELECT * FROM Proveedores";
                psSelect = conexion.prepareStatement(query);
                rs = psSelect.executeQuery();
                while (rs.next()) {
                    System.out.printf("%-10d %-30s %-20s %-15s\n",
                        rs.getInt("id_proveedor"),
                        rs.getString("nombre"),
                        rs.getString("cif"),
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

    // Método para eliminar un proveedor por CIF
    public boolean eliminarProveedor(String cif) {
        if (!buscarProveedor(cif)) {
            return false;  // Proveedor no encontrado
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psDelete = null;

        try {
            if (conexion != null) {
                String query = "DELETE FROM Proveedores WHERE cif=?";
                psDelete = conexion.prepareStatement(query);
                psDelete.setString(1, cif);
                psDelete.executeUpdate();
                return true; // Proveedor eliminado correctamente
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
        return false;  // Error al eliminar el proveedor
    }

    // Método para editar un proveedor
    // nombreNuevo, telefonoNuevo, cifNuevo, cifOriginal
    public boolean editarProveedor(String nombreNuevo, String telefonoNuevo, String cifNuevo, String cifOriginal) {
        if (!buscarProveedor(cifOriginal)) {
            return false;  // Proveedor no encontrado
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psUpdate = null;

        try {
            if (conexion != null) {
                String query = "UPDATE Proveedores SET nombre=?, telefono=?, cif=? WHERE cif=?";
                psUpdate = conexion.prepareStatement(query);
                psUpdate.setString(1, nombreNuevo);
                psUpdate.setString(2, telefonoNuevo);
                psUpdate.setString(3, cifNuevo);
                psUpdate.setString(4, cifOriginal);
                psUpdate.executeUpdate();
                return true; // Proveedor actualizado correctamente
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
        return false;  // Error al actualizar el proveedor
    }
}

	
