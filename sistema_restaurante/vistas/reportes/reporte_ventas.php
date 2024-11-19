<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/ReporteControl.php';

$database = new Database();
$db = $database->getConnection();
$reporteControl = new ReporteControl($db);

$ventas = $reporteControl->obtenerVentas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Ventas</title>
</head>
<body>
    <h1>Informe de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Total Ventas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($venta['total_ventas']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
