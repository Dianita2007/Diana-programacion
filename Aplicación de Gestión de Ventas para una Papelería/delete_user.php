<?php
// delete_user.php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != '1') {
    header("Location: dashboard.php");
    exit();
}

// Manejar la solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $conn->query("DELETE FROM users WHERE id='$delete_id'");
}

// Obtener la lista de usuarios
$users = $conn->query("SELECT id, email, role FROM users");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuarios</title>
    <link rel="stylesheet" href=""> <!-- Incluye tu hoja de estilos -->
    <style>
        /* Estilos generales */
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif; /* Fuente amigable */
            margin: 20px;
            color: #d800d8; /* Color morado pastel */
            background: linear-gradient(to bottom right, #f0f0f0, #e0e0e0); /* Fondo claro */
        }

        h2 {
            text-align: center; /* Centra el título */
        }

        .user-list {
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

        /* Estilo para el botón de registrar */
        .register-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50; /* Color del botón en verde */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px; /* Espacio inferior */
            transition: background-color 0.3s ease;
        }

        .register-button:hover {
            background-color: #45a049; /* Color al pasar el mouse */
        }
    </style>
</head>
<body>
    <h2>Eliminar Usuarios</h2>
    
    <!-- Botón para registrar un nuevo usuario -->
    <a href="register.php" class="register-button">Registrar Nuevo Usuario</a>

    <h3>Lista de Usuarios</h3>
    <div class="user-list">
        <?php while ($user = $users->fetch_assoc()): ?>
            <div class="card">
                <h3><?php echo $user['email']; ?></h3>
                <p>Rol: <?php echo ($user['role'] == '1') ? 'Administrador' : 'Usuario'; ?></p>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                    <button type="submit" class="delete-button">Eliminar</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
