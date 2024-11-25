<?php
ob_start(); // Inicia almacenamiento en búfer

require('fpdf/fpdf.php');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "papeleria";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta de productos
$query = "SELECT * FROM productos";
$result = $conn->query($query);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Inicia FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Encabezados de la tabla
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(60, 10, 'Nombre', 1);
$pdf->Cell(40, 10, 'Categoría', 1);
$pdf->Cell(30, 10, 'Precio', 1);
$pdf->Cell(30, 10, 'Stock', 1);
$pdf->Ln();

// Agregar datos de la base de datos a la tabla
$pdf->SetFont('Arial', '', 12);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['id'], 1);
        $pdf->Cell(60, 10, $row['nombre'], 1);
        $pdf->Cell(40, 10, $row['categoria'], 1);
        $pdf->Cell(30, 10, '$' . number_format($row['precio'], 2), 1);
        $pdf->Cell(30, 10, $row['stock'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(170, 10, 'No hay datos disponibles', 1, 0, 'C');
}

// Cierra la conexión
$conn->close();

ob_end_clean(); // Limpia el búfer antes de generar el PDF
$pdf->Output();
?>