<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';

class Ingrediente {
    private $conn;
    private $table_name = "ingredientes";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function create($nombre, $cantidad) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, stock) VALUES (:nombre, :stock)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":stock", $cantidad);
        return $stmt->execute();
    }

    public function update($id, $nombre, $cantidad) {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, stock = :stock WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":stock", $cantidad);
        return $stmt->execute();
    }
}
?>
