<?php
require_once "../php/main.php";
require('../fpdf186/fpdf.php'); // Asegúrate de que la ruta sea correcta

// Conectar a la base de datos
$conexion = conexion();

// Capturar los parámetros de la URL
$categoria_id = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : '';
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

// Definir la consulta de productos
$registros = 10; // Ajusta esto según tus necesidades
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

$consulta_datos = "SELECT * FROM producto 
                   INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id 
                   INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id 
                   ORDER BY producto.producto_nombre ASC 
                   LIMIT $inicio, $registros";

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll(PDO::FETCH_ASSOC);

// Crear una instancia de FPDF en orientación horizontal
$pdf = new FPDF('L', 'mm', 'A4'); // 'L' para paisaje
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Listado de Productos', 0, 1, 'C');

// Encabezados de columnas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'No. Recibo', 1, 0, 'C');
$pdf->Cell(100, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(80, 10, 'Catacion', 1, 0, 'C');
$pdf->Cell(30, 10, 'Ubicacion', 1, 0, 'C');
$pdf->Cell(20, 10, 'Quintalaje', 1, 1, 'C'); // Nueva línea

// Agregar los datos de los productos al PDF
$pdf->SetFont('Arial', '', 10);
foreach ($datos as $row) {
    $pdf->Cell(40, 10, $row['producto_codigo'], 1, 0, 'C');
    $pdf->Cell(100, 10, $row['producto_nombre'], 1, 0, 'C');
    $pdf->Cell(80, 10, $row['producto_catacion'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['producto_ubicacion'], 1, 0, 'C');
    $pdf->Cell(20, 10, $row['producto_quintalaje'], 1, 1, 'C'); // Nueva línea
}

// Cerrar el documento PDF y enviarlo al navegador
$pdf->Output('D', 'productos.pdf');

// Cerrar la conexión
$conexion = null;
?>
