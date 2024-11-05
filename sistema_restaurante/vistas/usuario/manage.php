<?php
    session_start();
    require_once '../../controladores/UsuControl.php';
    require_once '../../config/db.php';
    $database = new Database();
    $db = $database->getConnection();
    $UsuControl = new UsuControl($db);
    $usuario = $UsuControl->request();
    if(isset($_GET['eliminar'])){
        $UsuControl->delete($_GET['eliminar']);
        header("Location: manage.php");
        exit;
    }
    if(isset($_GET['actualizar'])){
        $UsuControl->update($_GET['id'], $_GET['nombre'], $_GET['correo'], $_GET['rol'], $_GET['contra']);
        header("Location: manage.php");
        exit;
    }
    $usuarioEditar = null;
    if (isset($_GET['editar'])) {
        $usuarioEditar = $UsuControl->requestById($_GET['editar']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuarios</title>
</head>
<body>
    <header>
        <h1>Panel de Usuarios</h1>
        <nav>
            <ul>
                <li><a href="./../../menu.php">Menu</a></li>
                <li><a href="./register.php">Registrar Usuario Nuevo</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuario as $usu): ?>
                    <tr>
                        <td><?php echo $usu['nombre']; ?></td>
                        <td><?php echo $usu['correo']; ?></td>
                        <td><?php echo $usu['contraseña']; ?></td>
                        <td><?php echo $usu['rol']; ?></td>
                        <td>
                            <button><a href="manage.php?editar=<?php echo $usu['id']; ?>">Editar</a></button>
                            <button><a href="manage.php?eliminar=<?php echo $usu['id']; ?>">Eliminar</a></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($usuarioEditar): ?>
            <h2>Editar Usuario</h2>
            <form action="manage.php" method="get">
                <input type="hidden" name="id" value="<?php echo $usuarioEditar['id']; ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $usuarioEditar['nombre']; ?>" required><br>
                <label for="correo">Correo:</label>
                <input type="email" name="correo" value="<?php echo $usuarioEditar['correo']; ?>" required><br>
                <label for="contra">Contraseña:</label>
                <input type="password" name="contra" value="<?php echo $usuarioEditar['contraseña']; ?>" id="contra"><br>
                <label for="rol">rol</label>
                <select name="rol"  id="rol">
                    <option value="1" <?php echo $usuarioEditar['rol'] == 1 ? 'selected' : ''; ?>>1 (Camarero)</option>
                    <option value="2" <?php echo $usuarioEditar['rol'] == 2 ? 'selected' : ''; ?>>2 (Cocinero)</option>
                    <option value="3" <?php echo $usuarioEditar['rol'] == 3 ? 'selected' : ''; ?>>3 (Administrador)</option>
                </select>
                <button type="submit" name="actualizar">Actualizar</button>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>