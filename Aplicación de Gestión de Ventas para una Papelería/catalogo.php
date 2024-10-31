<?php
session_start();
include('db.php'); // Incluye el archivo de conexión a la base de datos

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener productos de la base de datos
$query = "SELECT * FROM products"; // Asegúrate de que la tabla se llame 'products'
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cetis.css"> <!-- Archivo CSS externo -->
    <title>Catálogo de Productos</title>
</head>

<style>/* Estilos generales */
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
</style>




<body>
    <div class="dashboard-container">
        <h2>Catálogo de Productos</h2>
        <a href="dashboard.php">Volver al Panel de Control</a>
        <div class="product-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p>Precio: $<?php echo htmlspecialchars($product['price']); ?></p>
                        <p><?php echo htmlspecialchars($product['descripcion']); ?></p>
                        <a href="detalles_productos.php?id=<?php echo $product['id']; ?>">Ver Detalles</a>
                        <br>
                        <a href="comprar.php?id=<?php echo $product['id']; ?>" class="buy-button">Comprar</a> <!-- Botón de comprar -->
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
