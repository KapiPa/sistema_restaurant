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
    <!-- If applicable -->
    <title>Panel de Usuarios</title>
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
