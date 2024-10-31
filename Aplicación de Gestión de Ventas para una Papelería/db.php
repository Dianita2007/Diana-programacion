<?php
// db.php
$host = 'localhost';
$db = 'papeleria';
$user = 'root'; // Cambia esto si tienes un usuario distinto
$password = ''; // Cambia esto si tienes una contraseña

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}



try {
    $pdo = new PDO('mysql:host=localhost;dbname=papeleria', 'root', ''); // Cambia 'usuario' por 'root' y la contraseña por ''
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Conexión fallida: ' . $e->getMessage());
}
?>


