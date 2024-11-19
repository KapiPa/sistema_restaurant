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
    <title>Document</title>
    <!-- In menu.php -->
<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Menu Principal</h1>
        <nav>
            <ul>
                <li><a href="./vistas/pedidos/manage.php">Pedidos</a></li>
                <?php
                    if($_SESSION['rol'] >= 2){
                ?>
                        <li><a href="./vistas/platos/manage.php">Platos</a></li>
                        <li><a href="./vistas/ingredientes/manage_ingredientes.php">Ingredientes</a></li>
                <?php
                    }
                    if($_SESSION['rol'] == 3){
                ?>
                        <li><a href="./vistas/usuario/manage.php">Usuarios</a></li>
                        <li><a href="./vistas/reportes/reportes.php">Reportes</a></li>
                <?php
                    }
                ?>
                <li><a href="./vistas/usuario/logout.php">Log-Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php foreach($platos as $p): ?>
            <h2>Plato: <?php echo $p['nombre']; ?></h2>
            <p>Precio: <?php echo $p['precio']; ?></p>
            <p>cantidad: <?php echo $p['cantidad']; ?></p>
            <p>disponibilidad: <?php echo $p['disponibilidad']; ?></p>
        <?php endforeach; ?>
    </main>
</body>
</html>
