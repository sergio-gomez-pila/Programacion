package modelo;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class Proveedores {

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
	        return false; 
	    }

	    // Método para insertar un cliente
	    public boolean insertarProveedor(String nombre, String cif, String telefono) {
	        if (buscarProveedor(cif)) {
	            return false; // El cliente ya existe
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
	                    System.out.printf("%-10s %-25s %-20s %-15s\n",
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

	    // Método para eliminar un cliente por email
	    public boolean eliminarProveedor(String cif) {
	        if (!buscarProveedor(cif)) {
	            return false;  // Cliente no encontrado
	        }

	        Connection conexion = ConexionBasica.conectar();
	        PreparedStatement psDelete = null;

	        try {
	            if (conexion != null) {
	                String query = "DELETE FROM Proveedores WHERE cif=?";
	                psDelete = conexion.prepareStatement(query);
	                psDelete.setString(1, cif);
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
	    public boolean editarProveedor(String nombre, String cif, String telefono) {
	        if (!buscarProveedor(cif)) {
	            return false;  // Cliente no encontrado
	        }

	        Connection conexion = ConexionBasica.conectar();
	        PreparedStatement psUpdate = null;

	        try {
	            if (conexion != null) {
	                String query = "UPDATE Proveedores SET nombre=?, telefono=?, cif=? WHERE cif=?";
	                psUpdate = conexion.prepareStatement(query);
	                psUpdate.setString(1, nombre);
	                psUpdate.setString(2, telefono);
	                psUpdate.setString(3, cif);
	                psUpdate.setString(4, cif);
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
	        return false;  
	    }
	}
	
	
