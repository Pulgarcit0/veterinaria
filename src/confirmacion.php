<?php
session_start();

if (!isset($_GET['pago_id'])) {
    header("Location: productos.php");
    exit();
}

require_once '../config.php';
$pago_id = intval($_GET['pago_id']);

$conn = conectarDB();

// Obtener los detalles del pago
$stmt = $conn->prepare("SELECT p.id, p.total, p.fecha, p.metodo_pago, u.nombre AS usuario_nombre 
                        FROM pagos p 
                        JOIN usuarios u ON p.usuario_id = u.id 
                        WHERE p.id = ?");
$stmt->bind_param("i", $pago_id);
$stmt->execute();
$result = $stmt->get_result();
$pago = $result->fetch_assoc();
$stmt->close();

// Obtener los detalles de los productos comprados
$stmt = $conn->prepare("SELECT dp.cantidad, dp.precio_unitario, dp.subtotal, pr.nombre 
                        FROM detalles_pago dp 
                        JOIN productos pr ON dp.producto_id = pr.id 
                        WHERE dp.pago_id = ?");
$stmt->bind_param("i", $pago_id);
$stmt->execute();
$detalles = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2>Confirmación de Compra</h2>
    <p>Gracias por tu compra, <?php echo htmlspecialchars($pago['usuario_nombre']); ?>.</p>
    <p><strong>Total Pagado:</strong> $<?php echo number_format($pago['total'], 2); ?></p>
    <p><strong>Método de Pago:</strong> <?php echo htmlspecialchars($pago['metodo_pago']); ?></p>
    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($pago['fecha']); ?></p>

    <h3>Detalles de la Compra</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($detalle = $detalles->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($detalle['nombre']); ?></td>
                <td><?php echo htmlspecialchars($detalle['cantidad']); ?></td>
                <td>$<?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                <td>$<?php echo number_format($detalle['subtotal'], 2); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between">
        <a href="productos.php" class="btn btn-primary">Volver a Productos</a>
        <a href="generar_pdf.php?pago_id=<?php echo $pago_id; ?>" class="btn btn-secondary">Descargar PDF</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
