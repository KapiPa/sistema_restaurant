<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/IngredienteControl.php';

$database = new Database();
$db = $database->getConnection();
$ingredienteControl = new IngredienteControl($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];

    $ingredienteControl->create($nombre, $cantidad);
    $_SESSION['mensaje'] = "Ingrediente agregado exitosamente.";
    header("Location: manage_ingredientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Ingrediente</title>
</head>
<body>
    <header>
    <link rel="stylesheet" href="../../css/style.css">  
        <h1>Registrar Ingrediente</h1>
    </header>

    <main>
        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" required min="1">
            <button type="submit">Agregar Ingrediente</button>
        </form>
        <a href="manage_ingredientes.php">Volver</a>
    </main>
</body>
</html>
