<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PedidoControl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PlatoControl.php';

$database = new Database();
$db = $database->getConnection();
$pedidoControl = new PedidoControl($db);
$platoControl = new PlatoControl($db);

// Verifica si se ha pasado un ID de pedido en la URL
$id_pedido = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_pedido) {
    die("Error: No se proporcionó un ID de pedido.");
}

// Obtiene el pedido por ID
$pedido = $pedidoControl->requestById($id_pedido);
if (!$pedido) {
    die("Error: Pedido no encontrado.");
}

// Obtiene los platos asociados al pedido
$query = "SELECT pp.cantidad, p.nombre 
          FROM Pedidos_Platos pp 
          JOIN Platos p ON pp.idPlato = p.id 
          WHERE pp.idPedido = :idPedido";
$stmt = $db->prepare($query);
$stmt->bindParam(":idPedido", $id_pedido, PDO::PARAM_INT);
$stmt->execute();
$platos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">  
    <title>Detalles del Pedido</title>
</head>
<body>
    <header>
        <h1>Detalles del Pedido ID: <?php echo htmlspecialchars($id_pedido); ?></h1>
    </header>
    
    <main>
        <h2>Información del Pedido</h2>
        <p><strong>Nombre del Mozo:</strong> <?php echo htmlspecialchars($pedido['nombre']); ?></p>
        <p><strong>Mesa:</strong> <?php echo htmlspecialchars($pedido['mesa']); ?></p>
        <p><strong>Subtotal:</strong> <?php echo htmlspecialchars($pedido['subtotal']); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($pedido['estado']); ?></p>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($pedido['fecha']); ?></p>

        <h2>Platos en el Pedido</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Plato</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($platos) > 0): ?>
                    <?php foreach ($platos as $plato): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($plato['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($plato['cantidad']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No hay platos en este pedido.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="manage.php">Volver a la gestión de pedidos</a>
    </main>
</body>
</html>
