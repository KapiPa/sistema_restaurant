<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PedidoControl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PlatoControl.php';

$database = new Database();
$db = $database->getConnection();
$pedidoControl = new PedidoControl($db);
$platoControl = new PlatoControl($db);

$platos = $platoControl->request();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mesa = $_POST['mesa'];
    header("Location: agregar_platos.php?mesa=$mesa");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pedido Nuevo</title>
</head>
<body>
    <header>
        <h1>Registrar Pedido Nuevo</h1>
    </header>
    
    <main>
        <form method="POST" action="">
            <label for="mesa">Número de Mesa:</label>
            <input type="number" id="mesa" name="mesa" required>
            <button type="submit">Siguiente</button>
        </form>
    </main>
</body>
</html>
