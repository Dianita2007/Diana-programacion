<?php
ob_start(); // Inicia almacenamiento en búfer

require('fpdf/fpdf.php');

// Datos estáticos de los productos
$productos = [
    ['id' => 1, 'nombre' => 'Lápiz HB', 'categoria' => 'Escritura', 'precio' => 5.50, 'stock' => 100],
    ['id' => 2, 'nombre' => 'Cuaderno Profesional', 'categoria' => 'Papelería', 'precio' => 35.00, 'stock' => 50],
    ['id' => 3, 'nombre' => 'Borrador', 'categoria' => 'Escritura', 'precio' => 8.00, 'stock' => 200],
    ['id' => 4, 'nombre' => 'Regla 30cm', 'categoria' => 'Instrumentos', 'precio' => 12.00, 'stock' => 75],
    ['id' => 5, 'nombre' => 'Marcador Permanente', 'categoria' => 'Escritura', 'precio' => 20.00, 'stock' => 40],
    ['id' => 6, 'nombre' => 'Tijeras Escolares', 'categoria' => 'Instrumentos', 'precio' => 15.50, 'stock' => 30],
    ['id' => 7, 'nombre' => 'Pegamento en Barra', 'categoria' => 'Adhesivos', 'precio' => 10.00, 'stock' => 150],
    ['id' => 8, 'nombre' => 'Corrector Líquido', 'categoria' => 'Escritura', 'precio' => 18.00, 'stock' => 60],
    ['id' => 9, 'nombre' => 'Pluma Negra', 'categoria' => 'Escritura', 'precio' => 7.00, 'stock' => 90],
    ['id' => 10, 'nombre' => 'Pluma Azul', 'categoria' => 'Escritura', 'precio' => 7.00, 'stock' => 85],
    ['id' => 11, 'nombre' => 'Engrapadora', 'categoria' => 'Oficina', 'precio' => 50.00, 'stock' => 20],
    ['id' => 12, 'nombre' => 'Caja de Clips', 'categoria' => 'Oficina', 'precio' => 25.00, 'stock' => 100],
    ['id' => 13, 'nombre' => 'Cartulina Blanca', 'categoria' => 'Papelería', 'precio' => 10.00, 'stock' => 200],
    ['id' => 14, 'nombre' => 'Cartulina de Color', 'categoria' => 'Papelería', 'precio' => 12.00, 'stock' => 180],
    ['id' => 15, 'nombre' => 'Marcadores de Colores (12 piezas)', 'categoria' => 'Arte', 'precio' => 95.00, 'stock' => 25],
    ['id' => 16, 'nombre' => 'Cinta Adhesiva Transparente', 'categoria' => 'Adhesivos', 'precio' => 15.00, 'stock' => 70],
    ['id' => 17, 'nombre' => 'Bloc de Notas Adhesivas', 'categoria' => 'Oficina', 'precio' => 30.00, 'stock' => 60],
    ['id' => 18, 'nombre' => 'Hojas Blancas A4 (500 hojas)', 'categoria' => 'Papelería', 'precio' => 120.00, 'stock' => 35],
    ['id' => 19, 'nombre' => 'Caja de Acuarelas', 'categoria' => 'Arte', 'precio' => 85.00, 'stock' => 20],
    ['id' => 20, 'nombre' => 'Set de Geometría', 'categoria' => 'Instrumentos', 'precio' => 50.00, 'stock' => 50]
];

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

// Agregar datos estáticos a la tabla
$pdf->SetFont('Arial', '', 12);

if (count($productos) > 0) {
    foreach ($productos as $producto) {
        $pdf->Cell(10, 10, $producto['id'], 1);
        $pdf->Cell(60, 10, $producto['nombre'], 1);
        $pdf->Cell(40, 10, $producto['categoria'], 1);
        $pdf->Cell(30, 10, '$' . number_format($producto['precio'], 2), 1);
        $pdf->Cell(30, 10, $producto['stock'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(170, 10, 'No hay datos disponibles', 1, 0, 'C');
}

ob_end_clean(); // Limpia el búfer antes de generar el PDF
$pdf->Output();
?>
