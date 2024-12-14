<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

require_once '../config.php';

// Verifica si se ha pasado un ID válido en la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de producto no válido.");
}

$id = intval($_GET['id']); // Convierte el ID a un entero

$conn = conectarDB();

// Consulta para obtener los detalles del producto
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Producto no encontrado.");
}

$producto = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="../css/detalles.css">
    <link rel="stylesheet" href="../css/modal.css">

    <script>
        function mostrarFormularioEdicion() {
            document.getElementById('modal-edicion').style.display = 'flex';
        }

        function cerrarFormularioEdicion() {
            document.getElementById('modal-edicion').style.display = 'none';
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Detalles del Producto</h2>
    <div class="product-details">
        <img src="../imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
        <div class="product-info">
            <label>Nombre:</label>
            <p><?php echo htmlspecialchars($producto['nombre']); ?></p>

            <label>Descripción:</label>
            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>

            <label>Precio:</label>
            <p>$<?php echo htmlspecialchars($producto['precio_venta']); ?></p>

            <label>Categoría:</label>
            <p><?php echo htmlspecialchars($producto['categoria']); ?></p>
        </div>
    </div>

    <!-- Botones para acciones CRUD -->
    <div class="crud-actions">
        <button class="btn-editar" onclick="mostrarFormularioEdicion()">Modificar</button>
        <form action="eliminar_producto.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn-eliminar">Eliminar</button>
        </form>
        <a href="productos.php" class="btn-volver">Volver a Productos</a>
    </div>
</div>

<!-- Ventana flotante para editar -->
<div id="modal-edicion" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="cerrarFormularioEdicion()">&times;</span>
        <h3>Editar Producto</h3>
        <form action="guardar_producto.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>

            <label>Descripción:</label>
            <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio_venta" value="<?php echo htmlspecialchars($producto['precio_venta']); ?>" required>

            <label>Categoría:</label>
            <input type="text" name="categoria" value="<?php echo htmlspecialchars($producto['categoria']); ?>" required>

            <button type="submit" class="btn-guardar">Actualizar</button>
            <button type="button" class="btn-cancelar" onclick="cerrarFormularioEdicion()">Cancelar</button>
        </form>
    </div>
</div>
</body>
</html>
