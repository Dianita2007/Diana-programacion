<?php
session_start();
include('db.php'); // Incluye el archivo de conexión a la base de datos

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: catalogo.php");
    exit();
}

$productId = intval($_GET['id']); // Asegúrate de sanitizar la entrada
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $productId);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header("Location: catalogo.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cetis.css">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
</head>
<body>
    <div class="dashboard-container">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p>Precio: $<?php echo htmlspecialchars($product['price']); ?></p>
        <p><?php echo htmlspecialchars($product['descripcion']); ?></p>
        <a href="catalogo.php">Volver al Catálogo</a>
    </div>
</body>
</html>
