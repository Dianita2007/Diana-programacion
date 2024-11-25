<?php
require('fpdf/fpdf.php');

// Iniciar FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título del PDF
$pdf->Cell(190, 10, 'Centro de Estudios Tecnologicos Industrial y de Servicios No. 84', 0, 1, 'C');
$pdf->Ln(10); // Salto de línea

// Subtítulo con tu nombre
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(190, 10, 'DIana Monserrat Salazar Landin - Programacion', 0, 1, 'C');

// Salida del PDF
$pdf->Output();
?>
