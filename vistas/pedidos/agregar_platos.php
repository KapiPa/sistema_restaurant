<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/PlatoControl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/PedidoControl.php';

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
    <title>Agregar Platos a la Mesa <?php echo htmlspecialchars($mesa); ?></title>
    <style>
        /* Estilos generales */
        body {
            background-image: url('../../images/agregar_platos.jpg');
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

        main {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 900px;
            margin: 20px auto;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #264653;
        }

        th {
            background-color: #2a9d8f;
            color: #ffffff;
        }

        td {
    background-color: #f4f4f9;
    color: #264653; /* Aquí se cambia el color de texto a un tono oscuro */
}


        input[type="checkbox"] {
            width: 20px;
            height: 20px;
        }

        input[type="number"] {
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #264653;
            border-radius: 8px;
            width: 60px;
        }

        button {
            background-color: #e76f51;
            color: #ffffff;
            font-size: 1rem;
            font-weight: bold;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #d85740;
            transform: scale(1.05);
        }
    </style>
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
                                <input type="checkbox" name="platos[<?php echo $plato['id']; ?>]" value="1">
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
