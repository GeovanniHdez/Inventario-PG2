document.getElementById('preparacion').addEventListener('change', function() {
    var categoriaId = this.value; // Obtener el ID de la categoría seleccionada
    var productosDiv = document.getElementById('productos');

    // Limpiar productos anteriores
    productosDiv.innerHTML = '';

    if (categoriaId) {
        fetch('./php/obtener_productos.php?categoria_id=' + categoriaId) // Asegúrate de que la ruta sea correcta
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(producto => {
                        // Crear un ID único para cada checkbox
                        var checkboxId = 'producto_' + producto.producto_codigo;

                        var checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'productos[]'; // Array para los productos seleccionados
                        checkbox.value = producto.producto_codigo; // O el ID que prefieras
                        checkbox.id = checkboxId; // Asignar el ID al checkbox
                        
                        var label = document.createElement('label');
                        label.innerText = `${producto.producto_nombre} - Catación: ${producto.producto_catacion}, Ubicación: ${producto.producto_ubicacion}, Quintalaje: ${producto.producto_quintalaje}`;
                        label.setAttribute('for', checkboxId); // Vincular el label al checkbox
                    
                        // Agregar checkbox y label al div de productos
                        productosDiv.appendChild(checkbox);
                        productosDiv.appendChild(label);
                        productosDiv.appendChild(document.createElement('br')); // Añadir salto de línea
                    });
                } else {
                    productosDiv.innerHTML = '<p>No hay productos disponibles para esta preparación.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                productosDiv.innerHTML = '<p>Error al cargar productos.</p>';
            });
    }
});
