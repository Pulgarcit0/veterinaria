<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] < 3) {
    header("Location: productos.php?error=No tienes permiso para ver el carrito.");
    exit();
}

require_once '../config.php';
require_once '../fpdf/fpdf.php'; // Incluye la librería FPDF

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

// Calcular el total del carrito
foreach ($cart as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

// Procesar el pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['procesar_pago'])) {
    $metodo_pago = $_POST['metodo_pago']; // Tarjeta, efectivo, transferencia
    $usuario_id = $_SESSION['user_id'];

    $conn = conectarDB();

    // Insertar registro en la tabla pagos
    $stmt = $conn->prepare("INSERT INTO pagos (usuario_id, total, metodo_pago) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $usuario_id, $total, $metodo_pago);
    $stmt->execute();
    $pago_id = $stmt->insert_id; // Obtener el ID del pago
    $stmt->close();

    // Insertar detalles del pago
    foreach ($cart as $item) {
        $producto_id = $item['id'];
        $cantidad = $item['cantidad'];
        $precio_unitario = $item['precio'];
        $subtotal = $precio_unitario * $cantidad;

        $stmt = $conn->prepare("INSERT INTO detalles_pago (pago_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidd", $pago_id, $producto_id, $cantidad, $precio_unitario, $subtotal);
        $stmt->execute();
        $stmt->close();
    }

    // Generar el PDF
    $stmt = $conn->prepare("SELECT p.id, p.total, p.fecha, p.metodo_pago, u.nombre AS usuario_nombre 
                            FROM pagos p 
                            JOIN usuarios u ON p.usuario_id = u.id 
                            WHERE p.id = ?");
    $stmt->bind_param("i", $pago_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pago = $result->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("SELECT dp.cantidad, dp.precio_unitario, dp.subtotal, pr.nombre 
                            FROM detalles_pago dp 
                            JOIN productos pr ON dp.producto_id = pr.id 
                            WHERE dp.pago_id = ?");
    $stmt->bind_param("i", $pago_id);
    $stmt->execute();
    $detalles = $stmt->get_result();

    // Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Encabezado
    $pdf->Cell(190, 10, 'MascotaShop - Confirmacion de Compra', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(10);

    // Información del Usuario
    $pdf->Cell(50, 10, 'Cliente:', 0, 0);
    $pdf->Cell(140, 10, utf8_decode($pago['usuario_nombre']), 0, 1);
    $pdf->Cell(50, 10, 'Fecha:', 0, 0);
    $pdf->Cell(140, 10, $pago['fecha'], 0, 1);
    $pdf->Cell(50, 10, 'Metodo de Pago:', 0, 0);
    $pdf->Cell(140, 10, utf8_decode($pago['metodo_pago']), 0, 1);
    $pdf->Ln(10);

    // Tabla de Productos
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(90, 10, 'Producto', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(30, 10, 'Precio', 1);
    $pdf->Cell(40, 10, 'Subtotal', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    while ($detalle = $detalles->fetch_assoc()) {
        $pdf->Cell(90, 10, utf8_decode($detalle['nombre']), 1);
        $pdf->Cell(30, 10, $detalle['cantidad'], 1, 0, 'C');
        $pdf->Cell(30, 10, '$' . number_format($detalle['precio_unitario'], 2), 1, 0, 'R');
        $pdf->Cell(40, 10, '$' . number_format($detalle['subtotal'], 2), 1, 0, 'R');
        $pdf->Ln();
    }

    // Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total:', 1, 0, 'R');
    $pdf->Cell(40, 10, '$' . number_format($pago['total'], 2), 1, 0, 'R');

    // Limpiar el carrito
    unset($_SESSION['cart']);

    // Salida del PDF
    $pdf->Output('I', 'confirmacion_pago_' . $pago_id . '.pdf');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Carrito de Compras</h2>
    <?php if (count($cart) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cart as $item):
                    $subtotal = $item['precio'] * $item['cantidad'];
                    ?>
                    <tr>
                        <td><img src="../imagenes/<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" width="50"></td>
                        <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                        <td>$<?php echo number_format($item['precio'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end">
                <h4>Total: $<?php echo number_format($total, 2); ?></h4>
            </div>
        </div>
        <form method="post">
            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago:</label>
                <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>
            <button type="submit" name="procesar_pago" class="btn btn-success">Proceder al Pago</button>
        </form>
    <?php else: ?>
        <div class="alert alert-info">Tu carrito está vacío.</div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
