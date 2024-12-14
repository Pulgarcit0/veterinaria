<?php
require_once '../config.php';

$conn = conectarDB();

// Consulta para recuperar los servicios
$sql = "SELECT * FROM servicios";
$result = $conn->query($sql);

$servicios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $servicios[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container">
    <h2>Servicios</h2>
    <ul>
        <?php foreach ($servicios as $servicio): ?>
            <li>
                <h3><?php echo htmlspecialchars($servicio['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($servicio['descripcion']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
