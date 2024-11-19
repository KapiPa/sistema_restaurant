<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: vistas/usuario/login.php?coso=no");
    }
    else{
        header("Location: menu.php");
        exit();
    }
?>
