<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
class Reporte {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getVentasReport() {
        $query = "SELECT fecha, SUM(subtotal) as total_ventas 
                  FROM pedidos 
                  WHERE estado = 'Listo'
                  GROUP BY fecha 
                  ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPedidosReport() {
        $query = "SELECT id, nombre, mesa, subtotal, estado, fecha 
                  FROM pedidos 
                  ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInventarioReport() {
        $query = "SELECT nombre, stock 
                  FROM ingredientes 
                  ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
