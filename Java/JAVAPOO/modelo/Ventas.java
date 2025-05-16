package modelo;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Date;

public class Ventas {

    // Método para buscar si una venta existe por id_venta
    public boolean buscarVenta(int idVenta) {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;

        try {
            if (conexion != null) {
                String query = "SELECT * FROM Ventas WHERE id_venta=?";
                psSelect = conexion.prepareStatement(query);
                psSelect.setInt(1, idVenta);
                rs = psSelect.executeQuery();

                if (rs.next()) {
                    return true;  // Venta encontrada
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
        return false;  // Venta no encontrada
    }

    // Método para insertar una venta
    public boolean insertarVenta(int idCliente, int idArticulo, int cantidad, Date fechaVenta) {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psInsert = null;

        try {
            if (conexion != null) {
                String query = "INSERT INTO Ventas (id_cliente, id_articulo, cantidad, fecha_venta) VALUES (?, ?, ?, ?)";
                psInsert = conexion.prepareStatement(query);
                psInsert.setInt(1, idCliente);
                psInsert.setInt(2, idArticulo);
                psInsert.setInt(3, cantidad);
                psInsert.setDate(4, fechaVenta);
                psInsert.executeUpdate();
                return true; // Venta insertada correctamente
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
        return false;  // Error al insertar la venta
    }

    // Método para mostrar todas las ventas
    public void mostrarVentas() {
        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psSelect = null;
        ResultSet rs = null;

        try {
            if (conexion != null) {
                String query = "SELECT * FROM Ventas";
                psSelect = conexion.prepareStatement(query);
                rs = psSelect.executeQuery();

                System.out.printf("%-10s %-12s %-12s %-10s %-12s\n", "ID", "ID_CLIENTE", "ID_ARTICULO", "CANTIDAD", "FECHA_VENTA");
                while (rs.next()) {
                    System.out.printf("%-10d %-12d %-12d %-10d %-12s\n",
                            rs.getInt("id_venta"),
                            rs.getInt("id_cliente"),
                            rs.getInt("id_articulo"),
                            rs.getInt("cantidad"),
                            rs.getDate("fecha_venta").toString());
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

    // Método para eliminar una venta por id_venta
    public boolean eliminarVenta(int idVenta) {
        if (!buscarVenta(idVenta)) {
            return false;  // Venta no encontrada
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psDelete = null;

        try {
            if (conexion != null) {
                String query = "DELETE FROM Ventas WHERE id_venta=?";
                psDelete = conexion.prepareStatement(query);
                psDelete.setInt(1, idVenta);
                psDelete.executeUpdate();
                return true; // Venta eliminada correctamente
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
        return false;  // Error al eliminar la venta
    }

    // Método para editar una venta
    public boolean editarVenta(int idVenta, int idCliente, int idArticulo, int cantidad, Date fechaVenta) {
        if (!buscarVenta(idVenta)) {
            return false;  // Venta no encontrada
        }

        Connection conexion = ConexionBasica.conectar();
        PreparedStatement psUpdate = null;

        try {
            if (conexion != null) {
                String query = "UPDATE Ventas SET id_cliente=?, id_articulo=?, cantidad=?, fecha_venta=? WHERE id_venta=?";
                psUpdate = conexion.prepareStatement(query);
                psUpdate.setInt(1, idCliente);
                psUpdate.setInt(2, idArticulo);
                psUpdate.setInt(3, cantidad);
                psUpdate.setDate(4, fechaVenta);
                psUpdate.setInt(5, idVenta);
                psUpdate.executeUpdate();
                return true; // Venta actualizada correctamente
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
        return false;  // Error al actualizar la venta
    }
}

