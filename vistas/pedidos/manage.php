<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/PedidoControl.php';

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
    <style>
        /* Estilos generales */
        body {
            background-image: url('../../images/pedidos.jpg');
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

        nav ul {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        nav ul li a {
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            color: #ffffff;
            background-color: #e76f51;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        nav ul li a:hover {
            background-color: #d85740;
            transform: scale(1.1);
        }

        main {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 1100px;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #264653;
            padding: 10px;
            text-align: left;
            font-size: 1rem;
            color: #264653;
        }

        table th {
            background-color: #e76f51;
            color: #ffffff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: rgba(230, 230, 230, 0.8);
        }

        table tr:hover {
            background-color: rgba(255, 213, 179, 0.9);
        }

        a {
            text-decoration: none;
            color: #e76f51;
            font-weight: bold;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            color: #d85740;
            transform: scale(1.1);
        }
    </style>
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
