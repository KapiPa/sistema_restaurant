<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';

class Pedido {
    private $conn;
    private $table_name = "pedidos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO ".$this->table_name." SET nombre = :nombre, mesa = :mesa, subtotal = :subtotal, estado = :estado, fecha = :fecha";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":mesa", $this->mesa);
        $stmt->bindParam(":subtotal", $this->subtotal);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha", $this->fecha);
        return $stmt->execute();
    }

    public function request(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function requestById($id){
        $query = "SELECT * FROM ". $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(){
        $query = "UPDATE ".$this->table_name." SET estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete($id){
        $query = "DELETE FROM ".$this->table_name." WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateEstado($id_pedido, $nuevo_estado) {
        $query = "UPDATE pedidos SET estado = :estado WHERE id = :idPedido";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estado', $nuevo_estado, PDO::PARAM_STR);
        $stmt->bindParam(':idPedido', $id_pedido, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>
