<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/modelos/Platos.php';

class PlatoControl {
    private $db;
    private $plato;

    public function __construct($db) {
        $this->db = $db;
        $this->plato = new Platos($this->db);
    }

    public function create($nombre, $precio, $cantidad, $disponibilidad) {
        $this->plato->nombre = $nombre;
        $this->plato->precio = $precio;
        $this->plato->cantidad = $cantidad;
        $this->plato->disponibilidad = $disponibilidad;
        return $this->plato->create();
    }

    public function request() {
        return $this->plato->request();
    }

    public function requestById($id) {
        return $this->plato->requestById($id);
    }

    public function update($id, $nombre, $precio, $cantidad, $disponibilidad) {
        $this->plato->id = $id;
        $this->plato->nombre = $nombre;
        $this->plato->precio = $precio;
        $this->plato->cantidad = $cantidad;
        $this->plato->disponibilidad = $disponibilidad;
        return $this->plato->update($id);
    }

    public function delete($id) {
        return $this->plato->delete($id);
    }
}
?>
