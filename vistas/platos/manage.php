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
    <link rel="stylesheet" href="../../css/style.css">      <title>Panel de Platos</title>
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
