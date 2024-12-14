<?php
// src/add_to_cart.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] < 3) {
    header("Location: productos.php?error=No tienes permiso para agregar al carrito.");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config.php';

    if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
        header("Location: productos.php?error=ID de producto inválido.");
        exit();
    }

    $product_id = intval($_POST['product_id']);

    // Conectar a la base de datos y obtener detalles del producto
    $conn = conectarDB();
    $stmt = $conn->prepare("SELECT id, nombre, precio_venta, imagen FROM productos WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        header("Location: productos.php?error=Producto no encontrado.");
        exit();
    }

    $producto = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['cantidad'] += 1;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio_venta'],
            'imagen' => $producto['imagen'],
            'cantidad' => 1
        ];
    }

    header("Location: productos.php?success=Producto agregado al carrito.");
    exit();
} else {
    header("Location: productos.php");
    exit();
}
?>
