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
    <title>Registrar Plato Nuevo</title>
    <style>
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

        nav ul {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        nav ul li a {
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            color: #ffffff;
            background-color: #e76f51;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        nav ul li a:hover {
            background-color: #d85740;
            transform: scale(1.1);
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

        input[type="text"], input[type="number"], select {
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

        p {
            font-size: 1.2rem;
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Registrar Plato Nuevo</h1>
        <nav>
            <ul>
                <li><a href="./../../menu.php">Menu</a></li>
                <li><a href="./manage.php">Gestionar Platos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
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