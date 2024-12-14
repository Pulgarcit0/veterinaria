<?php
require_once '../config.php';

$conn = conectarDB();

// Consulta para recuperar las categorías
$sql = "SELECT * FROM categorias";
$result = $conn->query($sql);

$categorias = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="container">
    <h2>Categorías</h2>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li>
                <h3><?php echo htmlspecialchars($categoria['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($categoria['descripcion']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
