<div class="container is-fluid mb-6">
    <h1 class="title">Home</h1>
    <h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
</div>

<?php
require_once "./php/main.php"; // Asegúrate de que la ruta sea correcta
$conexion = conexion();

// Consulta para obtener la cantidad de órdenes
$query_ordenes = "SELECT COUNT(*) AS cantidad_ordenes FROM ordenes";
$cantidad_ordenes = $conexion->query($query_ordenes)->fetch(PDO::FETCH_ASSOC)['cantidad_ordenes'];

// Consulta para obtener la cantidad de productos
$query_productos = "SELECT COUNT(*) AS cantidad_productos FROM producto";
$cantidad_productos = $conexion->query($query_productos)->fetch(PDO::FETCH_ASSOC)['cantidad_productos'];

// Consulta para obtener la cantidad de clientes
$query_clientes = "SELECT COUNT(*) AS cantidad_clientes FROM cliente";
$cantidad_clientes = $conexion->query($query_clientes)->fetch(PDO::FETCH_ASSOC)['cantidad_clientes'];

// Consulta para obtener la cantidad de órdenes por día en el mes actual
$query_ordenes_diarias = "
    SELECT 
        DATE(fecha_creacion) AS dia,
        COUNT(*) AS cantidad
    FROM 
        ordenes
    WHERE 
        MONTH(fecha_creacion) = MONTH(CURRENT_DATE())
        AND YEAR(fecha_creacion) = YEAR(CURRENT_DATE())
    GROUP BY 
        dia
    ORDER BY 
        dia
";
$ordenes_diarias = $conexion->query($query_ordenes_diarias)->fetchAll(PDO::FETCH_ASSOC);

// Preparar datos para el gráfico
$dias = [];
$cantidades_diarias = [];

foreach ($ordenes_diarias as $row) {
    $dias[] = $row['dia'];
    $cantidades_diarias[] = $row['cantidad'];
}
?>

<div class="container is-fluid mb-6">
    <h1 class="title">Dashboard</h1>
    <div class="columns">
        <div class="column is-one-third">
            <div class="box has-background-light">
                <h2 class="title is-4">Órdenes</h2>
                <p class="subtitle is-5"><?php echo $cantidad_ordenes; ?></p>
            </div>
        </div>
        <div class="column is-one-third">
            <div class="box has-background-light">
                <h2 class="title is-4">Productos Registrados</h2>
                <p class="subtitle is-5"><?php echo $cantidad_productos; ?></p>
            </div>
        </div>
        <div class="column is-one-third">
            <div class="box has-background-light">
                <h2 class="title is-4">Clientes Creados</h2>
                <p class="subtitle is-5"><?php echo $cantidad_clientes; ?></p>
            </div>
        </div>
    </div>

    <h2 class="subtitle">Historial de Órdenes</h2>
    <canvas id="ordenesChart" width="400" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('ordenesChart').getContext('2d');
    var ordenesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dias); ?>,
            datasets: [{
                label: 'Órdenes por Día',
                data: <?php echo json_encode($cantidades_diarias); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Cambiar el paso a 1
                    }
                }
            }
        }
    });
</script>
