<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/modelos/Pedido.php';

class PedidoControl {
    private $db;
    private $pedido;

    public function __construct($db) {
        $this->pedido = new Pedido($db);
    }
    public function create($nombre, $mesa, $subtotal, $estado, $fecha){
        $this->pedido->nombre = $nombre;
        $this->pedido->mesa = $mesa;
        $this->pedido->subtotal = $subtotal;
        $this->pedido->estado = $estado;
        $this->pedido->fecha = $fecha;
        return $this->pedido->create();
    }

    public function request(){
        return $this->pedido->request();
    }

    public function requestById($id){
        return $this->pedido->requestById($id);
    }

    public function update($id, $estado){
        $this->pedido->id = $id;
        $this->pedido->estado= $estado;
        return $this->pedido->update();
    }

    public function updateEstado($id_pedido, $nuevo_estado) {
        return $this->pedido->updateEstado($id_pedido, $nuevo_estado);
    }

    public function delete($id){
        return $this->pedido->delete($id);
    }
}
?>
