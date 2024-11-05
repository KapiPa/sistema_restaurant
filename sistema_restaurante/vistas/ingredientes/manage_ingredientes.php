<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_restaurante/controladores/IngredienteControl.php';

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
                    <th>Acciones</th>
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
