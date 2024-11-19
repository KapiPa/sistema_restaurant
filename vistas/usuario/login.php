<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        require_once '../../controladores/UsuControl.php';
        require_once '../../config/db.php';
        $database = new Database();
        $db = $database->getConnection();
        $UsuControl = new UsuControl($db);
        if($UsuControl->login($_POST['correo'], $_POST['contra'])){
            echo "<script>alert('inicio de sesion exitoso')</script>";
            header("Location: ../../index.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: url('../../images/food.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            text-align: left;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
    </style>
    <title>Log-In</title>
</head>
<body>
    <div class="container">
        <?php
            if($_GET['coso'] === "no"){
        ?>
            <h1>Inicie sesion para poder acceder al sistema</h1>
        <?php
            }
        ?>
        <form action="login.php" method="post">
            <label for="correo">Correo:</label>
            <input type="text" name="correo" id="correo">
            <label for="contra">Contraseña:</label>
            <input type="password" name="contra" id="contra">
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>