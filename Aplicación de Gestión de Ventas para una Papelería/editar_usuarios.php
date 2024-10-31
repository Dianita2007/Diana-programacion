<?php
session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol adecuado
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "1") {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión
    exit();
}

// Conectar a la base de datos
include 'db.php'; // Asegúrate de tener un archivo para la conexión a la base de datos

// Verificar si se ha enviado un ID de usuario
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Obtener el ID del usuario de la URL

    // Obtener la información del usuario
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $error = "Usuario no encontrado.";
    }

    // Manejar el envío del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Actualizar la información del usuario
        $updateStmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
        $updateStmt->bind_param("ssii", $username, $email, $role, $userId);

        if ($updateStmt->execute()) {
            header("Location: admin.php"); // Redirigir después de la actualización
            exit();
        } else {
            $error = "Error al actualizar el usuario.";
        }
    }
} else {
    $error = "ID de usuario no proporcionado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluye tu hoja de estilos -->
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Inicio</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="admin-container">
            <form method="POST" action="">
                <div class="card">
                    <h3>Editar Información del Usuario</h3>

                    <?php if (isset($error)): ?>
                        <p style="color: red;"><?= $error ?></p>
                    <?php endif; ?>

                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" name="username" id="username" value="<?= isset($user) ? htmlspecialchars($user['name']) : '' ?>" required>

                    <label for="email">Correo Electrónico:</label>
                    <input type="email" name="email" id="email" value="<?= isset($user) ? htmlspecialchars($user['email']) : '' ?>" required>

                    <label for="role">Rol:</label>
                    <select name="role" id="role">
                        <option value="1" <?= isset($user) && $user['role'] == 1 ? 'selected' : '' ?>>Administrador</option>
                        <option value="2" <?= isset($user) && $user['role'] == 2 ? 'selected' : '' ?>>Usuario</option>
                    </select>

                    <button type="submit">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
