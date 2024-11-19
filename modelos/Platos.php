<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';

class Platos {
    private $conn;
    private $table_name = "platos";

    public $id;
    public $nombre;
    public $precio;
    public $cantidad;
    public $disponibilidad;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, precio=:precio, cantidad=:cantidad, disponibilidad=:disponibilidad";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":disponibilidad", $this->disponibilidad);
        return $stmt->execute();
    }

    public function request() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function requestById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, precio = :precio, cantidad = :cantidad, disponibilidad = :disponibilidad WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":cantidad", $this->cantidad);
        $stmt->bindParam(":disponibilidad", $this->disponibilidad);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        // Delete related rows in pedidos_platos table
        $query = "DELETE FROM pedidos_platos WHERE idPlato = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        // Delete row in platos table
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
