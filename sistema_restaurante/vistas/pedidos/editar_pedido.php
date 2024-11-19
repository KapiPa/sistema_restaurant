<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PedidoControl.php';

$database = new Database();
$db = $database->getConnection();
$pedidoControl = new PedidoControl($db);

// Verifica si se ha pasado un ID de pedido en la URL
$id_pedido = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_pedido || !is_numeric($id_pedido)) {
    die("Error: ID de pedido no válido.");
}

// Obtiene el pedido por ID
$pedido = $pedidoControl->requestById($id_pedido);
if (!$pedido) {
    die("Error: Pedido no encontrado.");
}

// Procesa el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_estado = isset($_POST['estado']) ? $_POST['estado'] : $pedido['estado'];

    // Actualiza solo el estado del pedido
    $resultado = $pedidoControl->updateEstado($id_pedido, $nuevo_estado); // Método que deberías implementar en PedidoControl

    if ($resultado) {
        $_SESSION['mensaje'] = "Estado del pedido actualizado exitosamente.";
        header("Location: manage.php");
        exit();
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el estado del pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
</head>
<body>
    <header>
        <h1>Editar Estado del Pedido ID: <?php echo htmlspecialchars($id_pedido); ?></h1>
    </header>
    
    <main>
        <form method="POST" action="">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado">
                <option value="Tomado" <?php echo ($pedido['estado'] == 'Tomado') ? 'selected' : ''; ?>>Tomado</option>
                <option value="En Preparacion" <?php echo ($pedido['estado'] == 'en preparacion') ? 'selected' : ''; ?>>En Preparacion</option>
                <option value="Listo" <?php echo ($pedido['estado'] == 'Listo') ? 'selected' : ''; ?>>Listo</option>
            </select>
            <button type="submit">Actualizar Estado</button>
        </form>

        <a href="manage.php">Volver a la gestión de pedidos</a>
    </main>
</body>
</html>
