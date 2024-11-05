<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/ReporteControl.php';

$database = new Database();
$db = $database->getConnection();
$reporteControl = new ReporteControl($db);

$inventario = $reporteControl->obtenerInventario();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Inventario</title>
</head>
<body>
    <h1>Informe de Inventario</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre del Ingrediente</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventario as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($item['stock']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
