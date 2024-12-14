<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio_venta']);
    $categoria = $_POST['categoria'];

    $conn = conectarDB();

    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio_venta = ?, categoria = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $categoria, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Producto actualizado exitosamente.'); window.location.href = 'productos.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el producto.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Método no permitido.'); window.history.back();</script>";
}
