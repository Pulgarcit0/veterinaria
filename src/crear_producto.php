<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] > 2) {
    header("Location: productos.php?error=No tienes permiso para acceder a esta página.");
    exit();
}

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio_venta = $_POST['precio_venta'];
    $categoria = $_POST['categoria'];

    // Subir imagen
    $imagen = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $destino = "../imagenes/" . $imagen;

    if (move_uploaded_file($imagen_tmp, $destino)) {
        $conn = conectarDB();
        $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio_venta, imagen, categoria) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $nombre, $descripcion, $precio_venta, $imagen, $categoria);
        if ($stmt->execute()) {
            header("Location: productos.php?success=Producto creado exitosamente.");
        } else {
            $error = "Error al crear el producto.";
        }
        $stmt->close();
        $conn->close();
    } else {
        $error = "Error al subir la imagen.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Crear Producto</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio de Venta</label>
            <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" class="form-control" id="categoria" name="categoria" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" required>
        </div>
        <button type="submit" class="btn btn-success">Crear Producto</button>
        <a href="productos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
