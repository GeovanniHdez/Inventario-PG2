<div class="container is-fluid mb-6">
    <h1 class="title">Órdenes</h1>
    <h2 class="subtitle">Nueva orden</h2>
</div>

<div class="container pb-6 pt-6 ordenes-container">
    <?php
    require_once "./php/main.php"; // Asegúrate de que la ruta sea correcta
    $conexion = conexion();
    
    // Consulta para obtener todas las preparaciones (categorías)
    $consulta_preparaciones = "SELECT * FROM categoria";
    $preparaciones = $conexion->query($consulta_preparaciones)->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para obtener todos los clientes
    $consulta_clientes = "SELECT * FROM cliente";
    $clientes = $conexion->query($consulta_clientes)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <form method="POST" action="./php/orden_pdf.php"> <!-- Asegúrate de que la ruta sea correcta -->
        <label for="cliente">Selecciona Cliente:</label>
        <select name="cliente_id" id="cliente" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente['cliente_id']; ?>">
                    <?php echo $cliente['cliente_nombre']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="preparacion">Selecciona Preparación:</label>
        <select name="preparacion" id="preparacion" required onchange="mostrarProductos()">
            <option value="">Seleccionar...</option>
            <?php foreach ($preparaciones as $preparacion): ?>
                <option value="<?php echo $preparacion['categoria_id']; ?>">
                    <?php echo $preparacion['categoria_nombre']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <div id="productos"></div> <!-- Aquí se cargarán los productos relacionados -->
        <button type="submit">Generar PDF</button>
    </form>
    <script src="./js/orden.js"></script> <!-- Ajustar la ruta si es necesario -->
</div>
