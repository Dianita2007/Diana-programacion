<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cambiar 'root' a 'email' para coincidir con el formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta para evitar inyección SQL
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?"); // Cambiar 'username' a 'email'
    $query->bind_param("s", $email); // 's' para indicar que es un string
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verificar la contraseña
    if (password_verify($password, $user['password'])) {
        // Guardar en sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redireccionar según el rol
        if ($_SESSION['role'] == "1") {
            header("Location: admin.php"); // Página de administración
        } else {
            header("Location: dashboard.php"); // Página del dashboard
        }
        exit(); // Siempre es bueno usar exit después de un header
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
} else {
    $error = "Usuario o contraseña incorrectos";
}
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cetis.css">
    <title>Inicio de Sesión - Papelería</title>

</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
