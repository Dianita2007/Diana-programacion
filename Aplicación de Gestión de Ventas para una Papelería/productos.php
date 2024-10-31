<?php
// products.php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $conn->query("INSERT INTO products (name, price, quantity) VALUES ('$name', '$price', '$quantity')");
}

$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Productos</title>
</head>
<body>
    <h2>Gestión de Productos</h2>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="name" required>
        <label>Precio:</label>
        <input type="number" step="0.01" name="price" required>
        <label>Cantidad:</label>
        <input type="number" name="quantity" required>
        <button type="submit">Agregar Producto</button>
        
    </form>
    <h3>Lista de Productos</h3>
    <ul>
        <?php while ($product = $products->fetch_assoc()): ?>
            <li><?php echo $product['name'] . " - $" . $product['price'] . " (Cantidad: " . $product['quantity'] . ")"; ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
