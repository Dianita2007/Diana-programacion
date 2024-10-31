<?php
session_start();
include('db.php');

// Verifica que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica si se pasó un ID de producto
if (isset($_GET['id'])) {
    $product_id = (int) $_GET['id']; // Asegúrate de que sea un entero

    // Obtén el producto de la base de datos
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if ($product) {
        // Lógica para comprar
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Suponiendo que se decremente la cantidad
            $current_quantity = (int) $product['quantity']; // Asegúrate de que sea un entero
            $new_quantity = $current_quantity - 1; // Decrementa la cantidad

            if ($new_quantity >= 0) {
                $update_stmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
                $update_stmt->bind_param("ii", $new_quantity, $product_id);
                $update_stmt->execute();
                $update_stmt->close();
                
                echo "<h2>Compra realizada exitosamente: " . htmlspecialchars($product['name']) . "</h2>";
            } else {
                echo "<h2>No hay suficiente stock para realizar la compra.</h2>";
            }
        }
    } else {
        echo "<h2>Producto no encontrado.</h2>";
    }

    $stmt->close();
} else {
    echo "<h2>No se especificó ningún producto.</h2>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cetis.css">
    <title>Comprar Producto</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif; /* Fuente más amigable */
            background: linear-gradient(to bottom right, #f0f0f0, #e0e0e0); /* Fondo claro */
            color: #d800d8; /* Color morado pastel */
            text-align: center; /* Centra el texto */
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px; /* Espaciado inferior */
        }

        /* Contenedor para la compra */
        .purchase-container {
            max-width: 600px;
            margin: 0 auto; /* Centra el contenedor */
            padding: 20px;
            background: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
            border-radius: 16px; /* Bordes redondeados */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Sombra más fuerte */
        }

        /* Botón de compra */
        .buy-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50; /* Color del botón en verde vibrante */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .buy-button:hover {
            background-color: #45a049; /* Color del botón al pasar el mouse */
        }

        /* Enlace de volver */
        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #00bfff; /* Color del enlace */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="purchase-container">
        <h1>Comprar <?php echo htmlspecialchars($product['name']); ?></h1>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST">
            <button type="submit" class="buy-button">Confirmar Compra</button>
        </form>
        <a href="productos.php" class="back-link">Volver a la lista de productos</a>
    </div>
</body>
</html>
