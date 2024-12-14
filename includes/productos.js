$(document).ready(function () {
    // Cargar productos al iniciar
    cargarProductos();

    function cargarProductos(busqueda = '', categoria = '', historial = false) {
        $.ajax({
            type: "GET",
            url: "../src/productos_handler.php",
            data: { busqueda: busqueda, categoria: categoria, historial: historial },
            dataType: "json",
            success: function (productos) {
                renderizarProductos(productos);
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar los productos:", error);
            }
        });

    }

    function renderizarProductos(productos) {
        const container = document.getElementById('productsContainer');
        container.innerHTML = '';

        productos.forEach(producto => {
            container.innerHTML += `
    <div class="product-card">
        <img src="../imagenes/${producto.imagen}" alt="${producto.nombre}">
        <h3>${producto.nombre}</h3>
        <p>${producto.descripcion}</p>
        <p>Precio: $${producto.precio_venta}</p>
        <a href="ver_detalle.php?id=${producto.id}" class="btn-ver-detalles">Ver Detalles</a>
    </div>
`;

        });
    }



    // Búsqueda
    $('#searchInput').on('input', function () {
        const terminoBusqueda = $(this).val();
        cargarProductos(terminoBusqueda);
    });

    // Botón "Buscar"
    $('.btn-buscar').click(function () {
        const terminoBusqueda = $('#searchInput').val();
        cargarProductos(terminoBusqueda);
    });

    // Botón "Borrar"
    $('.btn-borrar').click(function () {
        $('#searchInput').val('');
        cargarProductos();
    });

    // Botón "Filtros"
    $('.btn-filtros').click(function () {
        const categoria = prompt("Introduce una categoría para filtrar (ejemplo: perros, gatos):");
        if (categoria) {
            cargarProductos('', categoria);
        }
    });

    // Botón "Historial"
    $('.btn-historial').click(function () {
        cargarProductos('', '', true); // Historial
    });
});
