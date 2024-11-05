<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        require_once '../../controladores/UsuControl.php';
        require_once '../../config/db.php';
        $database = new Database();
        $db = $database->getConnection();
        $UsuControl = new UsuControl($db);

        if($UsuControl->create($_POST['nombre'], $_POST['contra'], $_POST['correo'], $_POST['rol'])){
            echo "<h1>Registro ingresado con exito</h1>";
            header("Location: manage.php");
            exit;
        }
        else{
            echo "<strogn>Error al crear el registro</strong>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <header>
        <h1>Registrar Nuevo Plato</h1>
        <nav>
            <ul>
                <li><a href="./../../menu.php">Menu</a></li>
                <li><a href="./manage.php">Gestionar Platos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="register.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre">
            <label for="contra">Contraseña:</label>
            <input type="password" name="contra" id="contra">
            <label for="correo">correo:</label>
            <input type="email" name="correo" id="correo">
            <label for="rol">Seleccione el rol:</label>
            <select name="rol" id="rol">
                <option value="1">1 (Camarero)</option>
                <option value="2">2 (Cocinero)</option>
                <option value="3">3 (Administrador)</option>
            </select>
            <button type="submit">Enviar</button>
        </form>
    </main>
</body>
</html>
