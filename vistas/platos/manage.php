<?php
session_start();
require_once '../../controladores/PlatoControl.php';
require_once '../../config/db.php';

$database = new Database();
$db = $database->getConnection();
$platoControl = new PlatoControl($db);
$platos = $platoControl->request();

if (isset($_GET['eliminar'])) {
    $platoControl->delete($_GET['eliminar']);
    header("Location: manage.php");
    exit;
}

if (isset($_GET['actualizar'])) {
    $platoControl->update($_GET['id'], $_GET['nombre'], $_GET['precio'], $_GET['cantidad'], $_GET['disponibilidad']);
    header("Location: manage.php");
    exit;
}

$platoEditar = null;
if (isset($_GET['editar'])) {
    $platoEditar = $platoControl->requestById($_GET['editar']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Platos</title>
    <style>
        body {
            background-image: url('../../images/pedidos.jpg');
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
            max-width: 1100px;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #264653;
            padding: 10px;
            text-align: left;
            font-size: 1rem;
            color: #264653;
        }

        table th {
            background-color: #e76f51;
            color: #ffffff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: rgba(230, 230, 230, 0.8);
        }

        table tr:hover {
            background-color: rgba(255, 213, 179, 0.9);
        }

        button a {
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        button a:hover {
            color: #d85740;
            transform: scale(1.1);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
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
    </style>
</head>
<body>
    <header>
        <h1>Panel de Platos</h1>
        <nav>
            <ul>
                <li><a href="./../../menu.php">Menu</a></li>
                <li><a href="./register.php">Registrar Plato Nuevo</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Disponibilidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($platos as $plato): ?>
                    <tr>
                        <td><?php echo $plato['nombre']; ?></td>
                        <td><?php echo $plato['precio']; ?></td>
                        <td><?php echo $plato['cantidad']; ?></td>
                        <td><?php echo $plato['disponibilidad']; ?></td>
                        <td>
                            <button><a href="manage.php?editar=<?php echo $plato['id']; ?>">Editar</a></button>
                            <button><a href="manage.php?eliminar=<?php echo $plato['id']; ?>">Eliminar</a></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($platoEditar): ?>
            <h2>Editar Plato</h2>
            <form action="manage.php" method="get">
                <input type="hidden" name="id" value="<?php echo $platoEditar['id']; ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $platoEditar['nombre']; ?>" required><br>
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" name="precio" value="<?php echo $platoEditar['precio']; ?>" required><br>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" value="<?php echo $platoEditar['cantidad']; ?>" required><br>
                <label for="disponibilidad">Disponibilidad:</label>
                <select name="disponibilidad" id="disponibilidad">
                    <option value="disponible" <?php echo $platoEditar['disponibilidad'] === 'disponible' ? 'selected' : ''; ?>>Disponible</option>
                    <option value="no disponible" <?php echo $platoEditar['disponibilidad'] === 'no disponible' ? 'selected' : ''; ?>>No Disponible</option>
                </select>
                <button type="submit" name="actualizar">Actualizar</button>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>