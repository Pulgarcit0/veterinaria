<?php
// src/productos.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

require_once '../config.php';

$conn = conectarDB();

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

$sql = "SELECT id, nombre, descripcion, precio_venta, imagen, categoria FROM productos";
if (!empty($categoria)) {
    $sql .= " WHERE categoria = ?";
}

$stmt = $conn->prepare($sql);

if (!empty($categoria)) {
    $stmt->bind_param("s", $categoria);
}

$stmt->execute();
$result = $stmt->get_result();

$productos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}
$stmt->close();
$conn->close();

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MascotaShop - Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container">
    <div class="shop-container">
        <h2>Productos</h2>

        <div class="search-bar">
            <input type="text" placeholder="Búsqueda" id="searchInput">
            <button class="btn-buscar">Buscar</button>
            <button class="btn-borrar">Borrar</button>
            <button class="btn-filtros">Filtros</button>
            <button class="btn-historial">Historial</button>
        </div>

        <div class="products-grid" id="productsContainer">
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="product-card">
                        <img src="../imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="product-image">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p class="price">$<?php echo htmlspecialchars($producto['precio_venta']); ?></p>

                        <?php if ($user_id <= 2): ?>
                            <!-- Botón "Ver Detalles" solo para administradores -->
                            <a href="ver_detalle.php?id=<?php echo htmlspecialchars($producto['id']); ?>" class="btn-ver-detalles btn btn-info">Ver Detalles</a>
                        <?php endif; ?>

                        <?php if ($user_id >= 3): ?>
                            <!-- Botón "Agregar al Carrito" solo para compradores -->
                            <form method="post" action="add_to_cart.php" class="mt-2">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                                <button type="submit" class="btn-agregar-carrito btn btn-primary">Agregar al Carrito</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="../includes/productos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
