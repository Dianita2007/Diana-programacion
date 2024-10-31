<?php
include 'db.php'; // Importar información de un archivo externo

$error = ''; // Inicializar la variable de error

if (isset($_POST['register'])) { // Si se da clic al botón "Registrarse"
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Puedes asignar un valor por defecto, o recogerlo del formulario si es necesario
    
    // Comprobamos si el email ya existe
    $checkEmail = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $checkEmail->execute(['email' => $email]);

    if ($checkEmail->rowCount() > 0) {
        $error = "El correo ya está registrado.";
    } else {
        // Insertamos el nuevo usuario incluyendo el rol
        $query = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
        $query->execute(['name' => $name, 'email' => $email, 'password' => $password, 'role' => $role]);

        // Redirigir a la página de inicio
        header('Location: login.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cetis.css">
    <title>Registro - papeleria</title>
</head>
<body>
    <div class="register-container">
        <h2>Registrarse</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="register">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
