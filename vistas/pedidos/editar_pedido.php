<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/PedidoControl.php';

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
    <style>
        /* Estilos generales */
        body {
            background-image: url('../../images/editar_pedido.jpg');
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
            margin-bottom: 20px;
        }

        label {
            font-size: 1.2rem;
            color: #333;
            margin-right: 10px;
        }

        select {
            padding: 8px;
            font-size: 1rem;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #264653;
        }

        button {
            padding: 10px 20px;
            background-color: #2a9d8f;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #264653;
            transform: scale(1.05);
        }

        a {
            display: inline-block;
            background-color: #e76f51;
            color: #ffffff;
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            background-color: #d85740;
            transform: scale(1.05);
        }
    </style>
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
