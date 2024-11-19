<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PlatoControl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/PedidoControl.php';

$database = new Database();
$db = $database->getConnection();
$pedidoControl = new PedidoControl($db);
$platoControl = new PlatoControl($db);

// Obtén la mesa desde la URL
$mesa = isset($_GET['mesa']) ? $_GET['mesa'] : '';

// Crea un array para almacenar los platos seleccionados
$platos_seleccionados = [];
$subtotal = 0; // Inicializa el subtotal en 0

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Procesa el formulario
    foreach ($_POST['platos'] as $id_plato => $valor) {
        if (!empty($valor)) {
            $cantidad = isset($_POST['cantidad'][$id_plato]) ? $_POST['cantidad'][$id_plato] : 0;

            if ($cantidad > 0) {
                // Guarda el id del plato y la cantidad en el vector
                $platos_seleccionados[] = [
                    'id_plato' => $id_plato,
                    'cantidad' => $cantidad
                ];

                // Obtén el precio del plato y calcula el subtotal
                $query = "SELECT precio FROM platos WHERE id = :idPlato";
                $stmt = $db->prepare($query);
                $stmt->bindParam(":idPlato", $id_plato, PDO::PARAM_INT);
                $stmt->execute();
                $plato = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($plato) {
                    $subtotal += $plato['precio'] * $cantidad;
                }
            }
        }
    }

    // Define el estado y la fecha
    $estado = 'pendiente';
    $fecha = date('Y-m-d H:i:s');

    // Crea el pedido con el subtotal calculado
    $pedidoControl->create($_SESSION['nombre'], $mesa, $subtotal, $estado, $fecha);

    // Obtiene el ID del último pedido insertado
    $pedido_id = $db->lastInsertId();

    // Guarda la relación en la tabla Pedidos_Platos
    foreach ($platos_seleccionados as $plato) {
        $db->prepare("INSERT INTO Pedidos_Platos (idPedido, idPlato, cantidad) VALUES (:idPedido, :idPlato, :cantidad)")
            ->execute([':idPedido' => $pedido_id, ':idPlato' => $plato['id_plato'], ':cantidad' => $plato['cantidad']]);
    }

    // Redirige a la página de gestión de pedidos
    header("Location: manage.php");
    exit();
}

// Obtiene todos los platos disponibles
$platos = $platoControl->request(); // Asegúrate de que este método devuelva solo los platos disponibles
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">  
    <title>Agregar Platos a la Mesa <?php echo htmlspecialchars($mesa); ?></title>
</head>
<body>
    <header>
        <h1>Agregar Platos a la Mesa <?php echo htmlspecialchars($mesa); ?></h1>
    </header>
    
    <main>
        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Nombre del Plato</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($platos as $plato): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="platos[<?php echo $plato['id']; ?>]" value="1"> <!-- Almacena el id del plato -->
                            </td>
                            <td><?php echo htmlspecialchars($plato['nombre']); ?></td>
                            <td>
                                <input type="number" name="cantidad[<?php echo $plato['id']; ?>]" min="1" value="1">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">Guardar Pedido</button>
        </form>
    </main>
</body>
</html>
