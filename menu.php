<?php
    session_start();
    require_once './controladores/PlatoControl.php';
    require_once './config/db.php';

    $database = new Database();
    $db = $database->getConnection();
    $platoControl = new PlatoControl($db);
    $platos = $platoControl->request();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <style>
        /* Estilos generales */
        body {
            background-image: url('./images/restaurant.jpg');
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
            max-width: 900px;
            margin: 20px auto;
        }

        main h2 {
            font-family: Georgia, serif;
            font-size: 1.8rem;
            color: #264653;
            margin-bottom: 10px;
        }

        main p {
            font-size: 1rem;
            color: #e76f51;
            margin: 5px 0;
        }

        footer {
            margin-top: auto;
            padding: 10px;
            text-align: center;
            font-size: 0.9rem;
            color: #ffffff;
            background: #264653;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Menú Principal</h1>
        <nav>
            <ul>
                <li><a href="./vistas/pedidos/manage.php">Pedidos</a></li>
                <?php if($_SESSION['rol'] >= 2): ?>
                    <li><a href="./vistas/platos/manage.php">Platos</a></li>
                    <li><a href="./vistas/ingredientes/manage_ingredientes.php">Ingredientes</a></li>
                <?php endif; ?>
                <?php if($_SESSION['rol'] == 3): ?>
                    <li><a href="./vistas/usuario/manage.php">Usuarios</a></li>
                    <li><a href="./vistas/reportes/reportes.php">Reportes</a></li>
                <?php endif; ?>
                <li><a href="./vistas/usuario/logout.php">Log-Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php foreach($platos as $p): ?>
            <h2>Plato: <?php echo htmlspecialchars($p['nombre']); ?></h2>
            <p>Precio: $<?php echo htmlspecialchars($p['precio']); ?></p>
            <p>Cantidad: <?php echo htmlspecialchars($p['cantidad']); ?></p>
            <p>Disponibilidad: <?php echo htmlspecialchars($p['disponibilidad']); ?></p>
        <?php endforeach; ?>
    </main>
    <footer>
        &copy; 2024 Restaurante Elegante. Todos los derechos reservados.
    </footer>
</body>
</html>
