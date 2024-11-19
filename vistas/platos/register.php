<?php
session_start();
require_once '../../controladores/PlatoControl.php';
require_once '../../config/db.php';

$database = new Database();
$db = $database->getConnection();
$platoControl = new PlatoControl($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $disponibilidad = $_POST['disponibilidad'];

    if ($platoControl->create($nombre, $precio, $cantidad, $disponibilidad)) {
        header("Location: manage.php");
        exit;
    } else {
        $error = "Error al registrar el plato. Inténtalo de nuevo.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">  
    <title>Registrar Plato</title>
</head>
<body>
    <header>
        <h1>Registrar Nuevo Plato</h1>
        <nav>
            <ul>
                <li><a href="./../../menu.php">Menu</a></li>
                <li><a href="./manage.php">Gestionar Platos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required><br>
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" required><br>
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" required><br>
            <label for="disponibilidad">Disponibilidad:</label>
            <select name="disponibilidad" id="disponibilidad" required>
                <option value="disponible">Disponible</option>
                <option value="no disponible">No Disponible</option>
            </select>
            <button type="submit">Registrar Plato</button>
        </form>
    </main>
</body>
</html>
