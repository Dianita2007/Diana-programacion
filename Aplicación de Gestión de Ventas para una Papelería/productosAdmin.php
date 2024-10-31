<?php
// products.php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != '1') {
    header("Location: dashboard.php");
    exit();
}

// Manejar la solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $conn->query("DELETE FROM products WHERE id='$delete_id'");
}

// Manejar la solicitud de agregar un producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $conn->query("INSERT INTO products (name, price, quantity) VALUES ('$name', '$price', '$quantity')");
}

// Obtener la lista de productos
$products = $conn->query("SELECT * FROM products");
?>

<style>
/* Estilos generales */
body {
    font-family: 'Comic Sans MS', cursive, sans-serif; /* Fuente más amigable */
    margin: 20px;
    color: #d800d8; /* Color morado pastel */
    background: linear-gradient(to bottom right, #f0f0f0, #e0e0e0); /* Fondo claro */
}

/* Estilos del contenedor principal */
.dashboard-container {
    max-width: 1000px;
    margin: 0 auto; /* Centra el contenedor */
    padding: 20px;
}

h2 {
    text-align: center; /* Centra el título */
}

a {
    text-decoration: none;
    color: #00bfff; /* Color de los enlaces */
}

.product-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Ajusta la cantidad de columnas según el tamaño */
    gap: 20px; /* Espaciado entre las tarjetas */
}

/* Estilos de las tarjetas */
.card {
    background: linear-gradient(135deg, rgba(255, 105, 180, 0.9), rgba(0, 191, 255, 0.9)); /* Degradado vibrante */
    border-radius: 16px; /* Bordes más redondeados */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Sombra más fuerte */
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px); /* Efecto de elevación al pasar el mouse */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4); /* Sombra más fuerte al pasar el mouse */
}

.card h3 {
    color: #00bfff; /* Color del título en azul brillante */
}

.card p {
    color: #333; /* Texto más oscuro para contraste */
}

/* Botón de compra */
.buy-button {
    display: inline-block;
    padding: 10px 15px;
    margin-top: 10px;
    background-color: #4caf50; /* Color del botón en verde vibrante */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.buy-button:hover {
    background-color: #45a049; /* Color del botón al pasar el mouse */
}

/* Estilos del botón de eliminar */
.delete-button {
    display: inline-block;
    padding: 5px 10px;
    background-color: #ff4d6d; /* Color del botón de eliminar */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 10px;
    transition: background-color 0.3s ease;
}

.delete-button:hover {
    background-color: #d800d8; /* Color al pasar el mouse */
}
</style>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Productos</title>
    <a href="dashboardAdmin.php">Inicio</a>
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
            <li>
                <?php echo $product['name'] . " - $" . $product['price'] . " (Cantidad: " . $product['quantity'] . ")"; ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="delete-button">Eliminar</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
