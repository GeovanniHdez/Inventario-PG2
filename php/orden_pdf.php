<?php
session_start(); // Asegúrate de que la sesión esté iniciada
require_once "../php/main.php";
require('../fpdf186/fpdf.php'); // Asegúrate de que la ruta sea correcta

// Conectar a la base de datos
$conexion = conexion();
$conexion->exec("set names utf8"); // Configurar para usar UTF-8

// Configurar la zona horaria
date_default_timezone_set('America/Guatemala');

// Obtener la categoría seleccionada
$categoria_id = isset($_POST['preparacion']) ? $_POST['preparacion'] : die("Error: No se ha seleccionado una categoría.");

// Obtener el cliente seleccionado
$cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : die("Error: No se ha seleccionado un cliente.");

// Insertar nueva orden en la base de datos
$stmt = $conexion->prepare("INSERT INTO ordenes (usuario_id, categoria_id, cliente_id) VALUES (:usuario_id, :categoria_id, :cliente_id)");
$stmt->bindParam(':usuario_id', $_SESSION['usuario_id']); // Asegúrate de que el usuario está en la sesión
$stmt->bindParam(':categoria_id', $categoria_id);
$stmt->bindParam(':cliente_id', $cliente_id);
$stmt->execute();
$orden_id = $conexion->lastInsertId(); // Obtener el ID de la orden recién creada

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

// Obtener el nombre del cliente
$stmt = $conexion->prepare("SELECT cliente_nombre FROM cliente WHERE cliente_id = :cliente_id");
$stmt->bindParam(':cliente_id', $cliente_id);
$stmt->execute();
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
$nombre_cliente = $cliente ? $cliente['cliente_nombre'] : 'Desconocido';

// Obtener el nombre de la categoría
$stmt = $conexion->prepare("SELECT categoria_nombre FROM categoria WHERE categoria_id = :categoria_id");
$stmt->bindParam(':categoria_id', $categoria_id);
$stmt->execute();
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);
$categoria_nombre = $categoria ? $categoria['categoria_nombre'] : 'Desconocido';

// Cambiar el tamaño de la fuente
$pdf->SetFont('Arial', 'B', 10);

// Crear una línea con todos los datos
$pdf->Cell(0, 10, 'Cliente: ' . $nombre_cliente . ' | Numero de Orden: ' . $orden_id . ' | Preparacion: ' . $categoria_nombre, 0, 1, 'L');

// Encabezados de columnas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'No. Recibo', 1, 0, 'C');
$pdf->Cell(100, 10, 'Productor', 1, 0, 'C');
$pdf->Cell(80, 10, 'Catacion', 1, 0, 'C');
$pdf->Cell(30, 10, 'Ubicacion', 1, 0, 'C');
$pdf->Cell(20, 10, 'Quintalaje', 1, 1, 'C'); // Nueva línea

// Agregar los productos al PDF y guardarlos en la base de datos
$pdf->SetFont('Arial', '', 10);
$productos_seleccionados = isset($_POST['productos']) ? $_POST['productos'] : [];
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
        
        // Guardar los productos en la tabla de orden_productos
        $stmt = $conexion->prepare("INSERT INTO orden_productos (orden_id, producto_codigo) VALUES (:orden_id, :producto_codigo)");
        $stmt->bindParam(':orden_id', $orden_id);
        $stmt->bindParam(':producto_codigo', $codigo_producto);
        $stmt->execute();
    }
}

// Número de página
$pdf->AliasNbPages();
$pdf->SetY(5); // Mueve el cursor a 5 mm del fondo
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo() . '/{nb}', 0, 0, 'C');

// Limpiar el búfer de salida
ob_clean(); 

// Cerrar el documento PDF y enviarlo al navegador
$pdf->Output('D', 'ordenes_productos.pdf');

// Cerrar la conexión
$conexion = null;
?>
