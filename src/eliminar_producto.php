<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        die("ID de producto no válido.");
    }

    $id = intval($_POST['id']); // Convierte el ID a un entero

    $conn = conectarDB();

    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Producto eliminado exitosamente.'); window.location.href = 'productos.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Método no permitido.'); window.history.back();</script>";
}
