<?php
// includes/header.php
session_start(); // Inicia la sesión para acceder a las variables de sesión
?>
<header>
    <div class="logo-container">
        <!-- Enlace al índice de la página -->
        <a href="index.php">
            <!-- Logo de la tienda -->
            <img src="../imagenes/logo.png" alt="Veterinaria Knino" class="logo">
            <h1>MascotaShop</h1>
        </a>
    </div>
    <nav>
        <?php if(isset($_SESSION['user_id'])): ?>
            <!-- Enlace a la página de productos -->
            <a href="productos.php">Productos</a>
            <?php
            $user_id = $_SESSION['user_id'];
            if ($user_id <= 2 ) {
                // Administrador
                echo '<a href="src/admin.php">Administración</a>';
            } else {
                // Comprador
                echo '<a href="../src/cart.php">Carrito</a>';
            }
            ?>
            <!-- Enlace para cerrar sesión -->
            <a href="../index.php">Cerrar Sesión</a>
        <?php else: ?>
            <!-- Enlaces para usuarios no autenticados -->
            <a href="../d/src/login.html">Login</a>
            <a href="../d/src/categorias.php">Categorías</a>
            <a href="../d/src/servicios.php">Servicios</a>
            <a href="../d/src/ofertas.php">Ofertas</a>
        <?php endif; ?>
    </nav>
</header>
