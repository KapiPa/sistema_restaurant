<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/ReporteControl.php';

$database = new Database();
$db = $database->getConnection();
$reporteControl = new ReporteControl($db);

$pedidos = $reporteControl->obtenerPedidos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/style.css">  
    <title>Informe de Pedidos</title>
</head>
<body>
    <h1>Informe de Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Mozo</th>
                <th>Mesa</th>
                <th>Subtotal</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                    <td><?php echo htmlspecialchars($pedido['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($pedido['mesa']); ?></td>
                    <td><?php echo htmlspecialchars($pedido['subtotal']); ?></td>
                    <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
                    <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
