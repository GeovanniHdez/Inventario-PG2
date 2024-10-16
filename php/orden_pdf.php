<?php
require_once "../php/main.php";
require('../fpdf186/fpdf.php'); // Asegúrate de que la ruta sea correcta

// Conectar a la base de datos
$conexion = conexion();
$conexion->exec("set names utf8"); // Configurar para usar UTF-8

// Configurar la zona horaria
date_default_timezone_set('America/Guatemala');

// Obtener los productos seleccionados
$productos_seleccionados = isset($_POST['productos']) ? $_POST['productos'] : [];

// Crear una instancia de FPDF en orientación horizontal
$pdf = new FPDF('L', 'mm', 'A4'); // 'L' para paisaje

// Añadir una página
$pdf->AddPage();

// Añadir logo en la esquina superior izquierda
$pdf->Image('../img/icono.png', 10, 5, 20); // Ajusta la ruta y el tamaño de la imagen

// Agregar fecha y hora
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Fecha: ' . date('d-m-Y H:i:s'), 0, 1, 'R');

// Título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Ordenes de Productos', 0, 1, 'C');

// Encabezados de columnas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'No. Recibo', 1, 0, 'C');
$pdf->Cell(100, 10, 'Productor', 1, 0, 'C');
$pdf->Cell(80, 10, 'Catacion', 1, 0, 'C');
$pdf->Cell(30, 10, 'Ubicacion', 1, 0, 'C');
$pdf->Cell(20, 10, 'Quintalaje', 1, 1, 'C'); // Nueva línea

// Agregar los productos al PDF
$pdf->SetFont('Arial', '', 10);
foreach ($productos_seleccionados as $codigo_producto) {
    $consulta_producto = "SELECT * FROM producto WHERE producto_codigo = :codigo";
    $stmt = $conexion->prepare($consulta_producto);
    $stmt->bindParam(':codigo', $codigo_producto);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $pdf->Cell(40, 10, $row['producto_codigo'], 1, 0, 'C');
        $pdf->Cell(100, 10, $row['producto_nombre'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['producto_catacion'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['producto_ubicacion'], 1, 0, 'C');
        $pdf->Cell(20, 10, $row['producto_quintalaje'], 1, 1, 'C'); // Nueva línea
    }
}

// Número de página
$pdf->AliasNbPages();
$pdf->SetY(5); // Mueve el cursor a 15 mm del fondo
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo() . '/{nb}', 0, 0, 'C');

// Cerrar el documento PDF y enviarlo al navegador
$pdf->Output('D', 'ordenes_productos.pdf');

// Cerrar la conexión
$conexion = null;
?>
