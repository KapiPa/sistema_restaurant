<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PedidoControl.php';

    $database = new Database();
    $db = $database->getConnection();
    $pedidoControl = new PedidoControl($db);

    $pedidos = $pedidoControl->request(); // Solicita todos los pedidos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Pedidos</title>
    <link rel="stylesheet" href="style.css"> <!-- Asegúrate de tener un archivo CSS para estilos -->
</head>
<body>
    <header>
        <h1>Panel de Pedidos</h1>
        <nav>
            <ul>
                <li><a href="../../menu.php">Menu</a></li>
                <li><a href="registrar_pedido.php">Registrar Pedido Nuevo</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Mozo</th>
                    <th>Mesa</th>
                    <th>Subtotal</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo $pedido['nombre']; ?></td>
                        <td><?php echo $pedido['mesa']; ?></td>
                        <td><?php echo $pedido['subtotal']; ?></td>
                        <td><?php echo $pedido['estado']; ?></td>
                        <td><?php echo $pedido['fecha']; ?></td>
                        <td>
                            <a href="ver_pedido.php?id=<?php echo $pedido['id']; ?>">Ver</a>
                            <a href="editar_pedido.php?id=<?php echo $pedido['id']; ?>">Editar</a>
                            <a href="eliminar_pedido.php?id=<?php echo $pedido['id']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
