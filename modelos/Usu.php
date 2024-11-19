<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
    class Usu{
        private $conn;
        private $table_name = "usuarios";

        public $id;
        public $nombre;
        public $correo;
        public $contra;
        public $rol;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function create() {
            $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, contraseña=:contra, correo=:correo, rol=:rol";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":contra", $this->contra);
            $stmt->bindParam(":correo", $this->correo);
            $stmt->bindParam(":rol", $this->rol);
            return $stmt->execute();
        }

        public function request(){
            $query = "SELECT * FROM " . $this->table_name;
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
        public function update($id, $nombre, $correo, $rol, $contra){
            if ($contra !== null) {
                $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, correo = :correo, rol = :rol, contraseña = :contra WHERE id = :id";
            } else {
                $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, correo = :correo, rol = :rol WHERE id = :id";
            }
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":rol", $rol);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($contra !== null) {
                $stmt->bindParam(":contra", $contra);
            }
            return $stmt->execute();
        }

        public function delete($id){
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        public function login($correo){
            $query = "SELECT * FROM " . $this->table_name . " WHERE correo = :correo";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":correo", $correo);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }        
    }
?>