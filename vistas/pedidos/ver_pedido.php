<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/PedidoControl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/PlatoControl.php';

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
    <title>Detalles del Pedido</title>
    <style>
        /* Estilos generales */
        body {
            background-image: url('../../images/detalles_pedido.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Verdana, Geneva, sans-serif;
            color: #ffffff;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        header {
            background: rgba(255, 255, 255, 0.85);
            width: 90%;
            max-width: 1200px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            text-align: center;
        }

        header h1 {
            font-family: Georgia, serif;
            font-size: 2.8rem;
            color: #264653;
            margin: 0;
        }

        main {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 900px;
            margin: 20px auto;
            text-align: center;
        }

        h2 {
            color: #264653;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            margin: 10px 0;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #264653;
        }

        th {
            background-color: #2a9d8f;
            color: #ffffff;
        }

        td {
            background-color: #f4f4f9;
            color: #264653;
        }

        a {
            display: inline-block;
            background-color: #e76f51;
            color: #ffffff;
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            background-color: #d85740;
            transform: scale(1.05);
        }
    </style>
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
