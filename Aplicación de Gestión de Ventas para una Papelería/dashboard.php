<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}





?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Control</title>
    <link rel="stylesheet" href="css/cetis.css">
</head>

<style>/* Estilos generales */
body {
    font-family: 'Comic Sans MS', cursive, sans-serif; /* Fuente más amigable */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    color: #d800d8; /* Color morado pastel */
}

/* Estilos del contenedor principal */
.dashboard-container {
    width: 80%;
    max-width: 1000px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    justify-items: center;
    position: relative; /* Para el efecto de chispa */
    overflow: hidden; /* Para que los efectos no salgan del contenedor */
}



/* Animación de pulso */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Estilos de las fichas */
.card {
    width: 100%;
    background: linear-gradient(135deg, rgba(255, 105, 180, 0.9), rgba(0, 191, 255, 0.9)); /* Degradado vibrante */
    border-radius: 16px; /* Bordes más redondeados */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); /* Sombra más fuerte */
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative; /* Para el efecto de energía */
    overflow: hidden; /* Para que el efecto de energía no sobresalga */
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
}

.card h3 {
    margin: 20px 0;
    color: #00bfff; /* Color del título en azul brillante */
    text-shadow: 1px 1px 0 rgba(0, 191, 255, 0.5); /* Sombra de texto brillante */
}

.card p {
    color: #333; /* Texto más oscuro para contraste */
}

/* Botón en cada ficha */
.card a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #ff6f91; /* Color del botón en rosa vibrante */
    color: white;
    text-decoration: none;
    border-radius: 20px; /* Bordes redondeados para un look más suave */
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.card a:hover {
    background-color: #ff4d6d; /* Color del botón al pasar el mouse */
    transform: scale(1.05); /* Efecto de zoom al pasar el mouse */
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
    .dashboard-container {
        grid-template-columns: 1fr; /* Una columna en dispositivos pequeños */
    }
}
</style>


<body>
    <div class="dashboard-container">
        <h2>Bienvenido al Panel de Control</h2>
            <div class="card">
                <h3>Acceso Limitado</h3>
                <p>Acceso solo a catálogo de productos.</p>
                <a href="catalogo.php">Ver Catálogo</a>
            </div>
        <!-- Enlace para cerrar sesión -->
        <a class="logout" href="logout.php">Cerrar sesión</a>
    </div>
</body>
</html>
