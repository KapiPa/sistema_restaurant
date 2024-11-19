<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/IngredienteControl.php';

$database = new Database();
$db = $database->getConnection();
$ingredienteControl = new IngredienteControl($db);

// Verifica si se ha pasado un ID de ingrediente
$id_ingrediente = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_ingrediente || !is_numeric($id_ingrediente)) {
    die("Error: ID de ingrediente no válido.");
}

// Obtiene el ingrediente actual
$query = "SELECT * FROM ingredientes WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(":id", $id_ingrediente, PDO::PARAM_INT);
$stmt->execute();
$ingrediente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ingrediente) {
    die("Error: Ingrediente no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    

    // Actualiza el ingrediente en la base de datos
    $ingredienteControl->update($id_ingrediente, $nombre, $cantidad);
    $_SESSION['mensaje'] = "Ingrediente editado exitosamente.";
    header("Location: manage_ingredientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">  
    <title>Editar Ingrediente</title>
</head>
<body>
    <header>
        <h1>Editar Ingrediente</h1>
    </header>

    <main>
        <?php if (isset($_SESSION['mensaje'])): ?>
            <p><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($ingrediente['nombre']); ?>" required>
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" value="<?php echo htmlspecialchars($ingrediente['cantidad']); ?>" required min="1">
            <button type="submit">Actualizar Ingrediente</button>
        </form>
        <a href="manage_ingredientes.php">Volver</a>
    </main>
</body>
</html>