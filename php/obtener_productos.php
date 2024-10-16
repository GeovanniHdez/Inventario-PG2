<?php
require_once "../php/main.php"; // Asegúrate de que la ruta sea correcta
$conexion = conexion();

$categoria_id = isset($_GET['categoria_id']) ? (int)$_GET['categoria_id'] : 0;

if ($categoria_id > 0) {
    $consulta_productos = "SELECT * FROM producto WHERE categoria_id = :categoria_id";
    $stmt = $conexion->prepare($consulta_productos);
    $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($productos); // Devuelve los productos como JSON
} else {
    echo json_encode([]); // Devuelve un array vacío si no hay categoría
}
?>
