<?php
session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol adecuado
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "1") {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión
    exit();
}

// Conectar a la base de datos
include 'db.php'; // Asegúrate de tener un archivo para la conexión a la base de datos

// Obtener la lista de usuarios
$query = $conn->prepare("SELECT id, name, email, role FROM users"); // Cambia según tu estructura de tabla
$query->execute();
$result = $query->get_result();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Administración</title>
    <link rel="stylesheet" href=""> <!-- Incluye tu hoja de estilos -->
</head>
<style>
 body {
    font-family: 'Comic Sans MS', cursive, sans-serif; /* Fuente amigable */
    background-color: #f0f0f0; /* Color de fondo suave */
    margin: 0;
    color: #d800d8; /* Color morado pastel */
    display: flex; /* Usar flexbox para centrar el contenido */
    flex-direction: column; /* Colocar elementos en columna */
    align-items: center; /* Centrar horizontalmente */
    height: 100vh; /* Altura de la ventana */
}

/* Estilo del encabezado */
header {
    width: 100%; /* Ancho completo */
    background-color: #ff6f91; /* Color de fondo del encabezado */
    padding: 15px; /* Espaciado interno */
    text-align: center; /* Centrar texto */
    border-bottom: 2px solid #d800d8; /* Borde inferior */
}

h1 {
    margin: 0; /* Sin margen */
    color: white; /* Color del texto */
}

/* Estilo del menú de navegación */
nav ul {
    list-style: none; /* Sin viñetas */
    padding: 0; /* Sin espaciado */
}

nav ul li {
    display: inline; /* Mostrar elementos en línea */
    margin: 0 15px; /* Espaciado entre enlaces */
}

nav a {
    color: white; /* Color de los enlaces */
    text-decoration: none; /* Sin subrayado */
    transition: color 0.3s; /* Transición para efectos de hover */
}

nav a:hover {
    color: #d800d8; /* Color de los enlaces al pasar el mouse */
}

/* Contenedor principal */
.admin-container {
    width: 90%; /* Ancho del contenedor */
    max-width: 1200px; /* Ancho máximo */
    background: white; /* Fondo blanco para el cuadro */
    border: 2px solid #d800d8; /* Borde morado */
    border-radius: 16px; /* Bordes redondeados */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Sombra sutil */
    padding: 20px; /* Espaciado interno */
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Cuadrícula responsiva */
    gap: 20px; /* Espaciado entre los elementos */
    justify-items: center; /* Centrar elementos en la cuadrícula */
}

/* Estilo de cada opción en la cuadrícula */
.card {
    width: 100%; /* Ancho completo del cuadro */
    background: linear-gradient(135deg, rgba(255, 105, 180, 0.9), rgba(0, 191, 255, 0.9)); /* Degradado vibrante */
    border-radius: 16px; /* Bordes más redondeados */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Sombra más fuerte */
    padding: 20px;
    text-align: center; /* Centrar texto */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px); /* Efecto de elevación al pasar el mouse */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4); /* Sombra más pronunciada al pasar el mouse */
}

.card h3 {
    margin: 20px 0; /* Margen en la parte superior e inferior */
    color: #00bfff; /* Color del título en azul brillante */
    text-shadow: 1px 1px 0 rgba(0, 191, 255, 0.5); /* Sombra de texto brillante */
}

.card p {
    color: #333; /* Texto más oscuro para contraste */
}

/* Estilos para el enlace de cerrar sesión */
.logout {
    display: inline-block; /* Asegúrate de que se muestre como un bloque */
    margin-top: 20px; /* Espacio superior para separarlo de otros elementos */
    padding: 10px 20px; /* Espacio interior para hacerlo más grande */
    background-color: #ff4d6d; /* Color del botón */
    color: white; /* Color del texto */
    text-decoration: none; /* Sin subrayado */
    border-radius: 5px; /* Bordes redondeados */
    transition: background-color 0.3s ease; /* Transición para un efecto suave */
}

.logout:hover {
    background-color: #d800d8; /* Color al pasar el mouse */
}

/* Ajustes para dispositivos pequeños */
@media (max-width: 600px) {
    .admin-container {
        grid-template-columns: 1fr; /* Una columna en dispositivos pequeños */
    }
}

</style>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Inicio</a></li>
                <li><a href="dashboardAdmin.php">Gestionar panel de control</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Bienvenido, Administrador</h2>
        <p>Aquí puedes gestionar la configuración del sistema y los usuarios.</p>

        <!-- Aquí puedes agregar formularios, tablas o cualquier contenido relevante para la administración -->
        
        <section>
            <h3>Estadísticas</h3>
            <p>Aquí puedes mostrar estadísticas sobre los usuarios, actividades, etc.</p>
        </section>

        <section>
        <h3>Acciones Rápidas</h3>
        <ul>
            <li><a href="register.php">Añadir Usuario</a></li>
        </ul>
        </section>

        <section>
            <h3>Lista de Usuarios</h3>
            <ul>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <li>
                        <?= htmlspecialchars($user['name']) ?> - 
                        <a href="editar_usuarios.php?id=<?= $user['id'] ?>">Editar Usuario</a> -
                        <a href="delete_user.php">Eliminar Usuario</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
    </main>
</body>
</html>
