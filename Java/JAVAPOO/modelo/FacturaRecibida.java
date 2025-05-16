package modelo;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Date;

public class FacturaRecibida {

    // Método para buscar si la factura existe por id_factura
    public boolean buscarFactura(int idFactura) {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;
        
        try {
            if (conexion != null) {
                String query = "SELECT * FROM Facturas_Recibidas WHERE id_factura=?";
                psSelect = conexion.prepareStatement(query);
                psSelect.setInt(1, idFactura);
                rs = psSelect.executeQuery();
                
                if (rs.next()) {
                    return true;  // Factura encontrada
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
        return false; // Factura no encontrada
    }

    // Método para insertar factura recibida
    public boolean insertarFactura(int idProveedor, Date fecha, double total) {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psInsert = null;
        
        try {
            if (conexion != null) {
                String query = "INSERT INTO Facturas_Recibidas (id_proveedor, fecha, total) VALUES (?, ?, ?)";
                psInsert = conexion.prepareStatement(query);
                psInsert.setInt(1, idProveedor);
                psInsert.setDate(2, fecha);
                psInsert.setDouble(3, total);
                psInsert.executeUpdate();
                return true; // Factura insertada correctamente
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
        return false; // Error al insertar la factura
    }

    // Método para mostrar todas las facturas recibidas
    public void mostrarFacturas() {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;
        
        try {
            if (conexion != null) {
                String query = "SELECT * FROM Facturas_Recibidas";
                psSelect = conexion.prepareStatement(query);
                rs = psSelect.executeQuery();
                
                System.out.printf("%-10s %-12s %-12s %-10s\n", "ID", "ID_PROVEEDOR", "FECHA", "TOTAL");
                while (rs.next()) {
                    System.out.printf("%-10d %-12d %-12s %-10.2f\n",
                        rs.getInt("id_factura"),
                        rs.getInt("id_proveedor"),
                        rs.getDate("fecha").toString(),
                        rs.getDouble("total"));
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

    // Método para eliminar factura por id_factura
    public boolean eliminarFactura(int idFactura) {
        if (!buscarFactura(idFactura)) {
            return false;  // Factura no encontrada
        }
        
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psDelete = null;
        
        try {
            if (conexion != null) {
                String query = "DELETE FROM Facturas_Recibidas WHERE id_factura=?";
                psDelete = conexion.prepareStatement(query);
                psDelete.setInt(1, idFactura);
                psDelete.executeUpdate();
                return true; // Factura eliminada correctamente
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
        return false;  // Error al eliminar la factura
    }

    // Método para editar factura
    public boolean editarFactura(int idFactura, int idProveedor, Date fecha, double total) {
        if (!buscarFactura(idFactura)) {
            return false;  // Factura no encontrada
        }
        
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psUpdate = null;
        
        try {
            if (conexion != null) {
                String query = "UPDATE Facturas_Recibidas SET id_proveedor=?, fecha=?, total=? WHERE id_factura=?";
                psUpdate = conexion.prepareStatement(query);
                psUpdate.setInt(1, idProveedor);
                psUpdate.setDate(2, fecha);
                psUpdate.setDouble(3, total);
                psUpdate.setInt(4, idFactura);
                psUpdate.executeUpdate();
                return true; // Factura actualizada correctamente
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
        return false;  // Error al actualizar la factura
    }
}

