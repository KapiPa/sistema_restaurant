<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/IngredienteControl.php';

$database = new Database();
$db = $database->getConnection();
$ingredienteControl = new IngredienteControl($db);

// Manejar la eliminación de un ingrediente
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $ingredienteControl->delete($_GET['delete']);
    $_SESSION['mensaje'] = "Ingrediente eliminado exitosamente.";
}

// Obtener todos los ingredientes
$ingredientes = $ingredienteControl->request(); // Asegúrate de que este método exista

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ingredientes</title>
    <style>
        /* Estilos generales */
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

        a {
            text-decoration: none;
            color: #e76f51;
            font-weight: bold;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            color: #d85740;
            transform: scale(1.1);
        }

        p {
            font-size: 1.2rem;
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Ingredientes</h1>
        <nav>
            <ul>
                <li><a href="../../menu.php">Menu</a></li>
                <li><a href="registrar_ingrediente.php">Registrar Ingrediente Nuevo</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if (isset($_SESSION['mensaje'])): ?>
            <p><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ingredientes as $ingrediente): ?>
                    <tr>
                        <td><?php echo $ingrediente['id']; ?></td>
                        <td><?php echo $ingrediente['nombre']; ?></td>
                        <td><?php echo $ingrediente['stock']; ?></td>
                        <td>
                            <a href="editar_ingrediente.php?id=<?php echo $ingrediente['id']; ?>">Editar</a>
                            <a href="?delete=<?php echo $ingrediente['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este ingrediente?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>