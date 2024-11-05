<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PedidoControl.php';

$database = new Database();
$db = $database->getConnection();
$pedidoControl = new PedidoControl($db);

// Verifica si se ha pasado un ID de pedido en la URL
$id_pedido = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_pedido && is_numeric($id_pedido)) {
    // Eliminar relaciones en Pedidos_Platos
    $query = "DELETE FROM Pedidos_Platos WHERE idPedido = :idPedido";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':idPedido', $id_pedido, PDO::PARAM_INT);
    
    // Ejecuta la eliminación de las relaciones
    $stmt->execute();

    // Intenta eliminar el pedido
    $resultado = $pedidoControl->delete($id_pedido); // Asegúrate de que este método exista en tu PedidoControl

    if ($resultado) {
        // Pedido eliminado exitosamente
        $_SESSION['mensaje'] = "Pedido eliminado exitosamente.";
    } else {
        // Error al eliminar el pedido
        $_SESSION['mensaje'] = "Error al eliminar el pedido. Puede que no exista.";
    }
} else {
    $_SESSION['mensaje'] = "Error: ID de pedido no válido.";
}

// Redirige a la página de gestión de pedidos
header("Location: manage.php");
exit();
?>
