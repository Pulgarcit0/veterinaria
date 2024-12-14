<?php
// src/admin.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] > 2) {
    header("Location: productos.php?error=Acceso denegado.");
    exit();
}

require_once '../config.php';

// Aquí puedes agregar funcionalidades de administración, como gestionar productos y usuarios

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración - MascotaShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Panel de Administración</h2>
    <!-- Agrega aquí las opciones de administración -->
    <p>Opciones de administración disponibles.</p>
    <!-- Por ejemplo: -->
    <a href="agregar_producto.php" class="btn btn-primary">Agregar Producto</a>
    <a href="gestionar_productos.php" class="btn btn-secondary">Gestionar Productos</a>
    <a href="gestionar_usuarios.php" class="btn btn-secondary">Gestionar Usuarios</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
