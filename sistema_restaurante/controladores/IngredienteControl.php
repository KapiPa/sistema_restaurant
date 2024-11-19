<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/modelos/Ingrediente.php';

class IngredienteControl {
    private $db;
    private $ingrediente;

    public function __construct($db) {
        $this->ingrediente = new Ingrediente($db);
    }

    public function request() {
        return $this->ingrediente->getAll();
    }

    public function delete($id) {
        return $this->ingrediente->delete($id);
    }

    public function create($nombre, $cantidad) {
        return $this->ingrediente->create($nombre, $cantidad);
    }

    public function update($id, $nombre, $cantidad) {
        return $this->ingrediente->update($id, $nombre, $cantidad);
    }
}
?>
