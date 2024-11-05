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
    <title>Log-In</title>
</head>
<body>
    <?php
        if($_GET['coso'] === "no"){
    ?>
        <h1>Inicie sesion para poder acceder al sistema</h1>
    <?php
        }
    ?>
    <form action="login.php" method="post">
        <label for="">Correo:</label>
        <input type="text" name="correo">
        <label for="">Contraseña:</label>
        <input type="text" name="contra">
        <input type="submit">
    </form>
</body>
</html>