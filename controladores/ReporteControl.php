<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/modelos/Reporte.php';

class ReporteControl {
    private $reporte;

    public function __construct($db) {
        $this->reporte = new Reporte($db);
    }

    public function obtenerVentas() {
        return $this->reporte->getVentasReport();
    }

    public function obtenerPedidos() {
        return $this->reporte->getPedidosReport();
    }

    public function obtenerInventario() {
        return $this->reporte->getInventarioReport();
    }
}
?>
