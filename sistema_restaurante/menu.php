<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <h2>Plato</h2>
            <p>Descripcion</p>
            <p>Precio</p>
            <button>Agregar a la orden</button>
        <?php endforeach; ?>
    </main>
</body>
</html>
