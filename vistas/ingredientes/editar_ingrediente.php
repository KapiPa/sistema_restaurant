<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restaurante/sistema_restaurante/controladores/IngredienteControl.php';

$database = new Database();
$db = $database->getConnection();
$ingredienteControl = new IngredienteControl($db);

// Verifica si se ha pasado un ID de ingrediente
$id_ingrediente = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_ingrediente || !is_numeric($id_ingrediente)) {
    die("Error: ID de ingrediente no válido.");
}

// Obtiene el ingrediente actual
$query = "SELECT * FROM ingredientes WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(":id", $id_ingrediente, PDO::PARAM_INT);
$stmt->execute();
$ingrediente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ingrediente) {
    die("Error: Ingrediente no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    

    // Actualiza el ingrediente en la base de datos
    $ingredienteControl->update($id_ingrediente, $nombre, $cantidad);
    $_SESSION['mensaje'] = "Ingrediente editado exitosamente.";
    header("Location: manage_ingredientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ingrediente</title>
    <style>
        /* Estilos generales */
        body {
            background-image: url('../../images/editar_ingrediente.jpg');
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

        main {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 900px;
            margin: 20px auto;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        label {
            font-size: 1.2rem;
            color: #264653;
            font-weight: bold;
        }

        input[type="text"], input[type="number"] {
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

        a {
            display: inline-block;
            background-color: #e76f51;
            color: #ffffff;
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            background-color: #d85740;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header>
        <h1>Editar Ingrediente</h1>
    </header>
    
    <main>
        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($ingrediente['nombre']); ?>" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($ingrediente['stock']); ?>" required>

            <button type="submit">Actualizar Ingrediente</button>
        </form>

        <a href="manage_ingredientes.php">Volver a la gestión de ingredientes</a>
    </main>
</body>
</html>