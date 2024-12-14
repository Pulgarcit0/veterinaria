<?php
require_once '../config.php';

$conn = conectarDB();

// Consulta para recuperar las ofertas
$sql = "SELECT * FROM ofertas WHERE fecha_inicio <= CURDATE() AND fecha_fin >= CURDATE()";
$result = $conn->query($sql);

$ofertas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ofertas[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ofertas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container">
    <h2>Ofertas</h2>
    <ul>
        <?php foreach ($ofertas as $oferta): ?>
            <li>
                <h3><?php echo htmlspecialchars($oferta['titulo']); ?></h3>
                <p><?php echo htmlspecialchars($oferta['descripcion']); ?></p>
                <p>Descuento: <?php echo htmlspecialchars($oferta['descuento']); ?>%</p>
                <p>Válido desde <?php echo htmlspecialchars($oferta['fecha_inicio']); ?> hasta <?php echo htmlspecialchars($oferta['fecha_fin']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
