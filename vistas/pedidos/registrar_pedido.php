<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/PedidoControl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/PlatoControl.php';

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
    <style>
        /* Estilos generales */
        body {
            background-image: url('../../images/registrar_pedido.jpg');
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
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        label {
            font-size: 1.2rem;
            color: #264653;
            font-weight: bold;
        }

        input[type="number"] {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #264653;
            border-radius: 8px;
            width: 100%;
            max-width: 300px;
        }

        button {
            background-color: #e76f51;
            color: #ffffff;
            font-size: 1rem;
            font-weight: bold;
            padding: 10px 15px;
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
