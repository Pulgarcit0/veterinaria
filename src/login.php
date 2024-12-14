<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MascotaShop - Acceso</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <header>
        <div class="logo-container">
            <a href="productos.php">
                <img src="../imagenes/logo.png" alt="Veterinaria Knino" class="logo">
                <h1>MascotaShop</h1>
            </a>
        </div>
        <nav>
            <a href="#">Categorías</a>
            <a href="#">Servicios</a>
            <a href="#">Ofertas</a>
            <a href="login.php">Cuenta</a>
        </nav>
    </header>

    <div class="login-form">
        <h2>Formulario de Acceso</h2>
        <form id="accessForm" action="login.php" method="POST">
            <input type="email" name="email" placeholder="Ingresa tu E-mail" required>
            <input type="password" name="password" placeholder="Ingresa tu contraseña" required>
            <button type="submit">Acceder</button>
        </form>
        <p>¿No tienes cuenta? <a href="register.html">Crea una</a></p>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>

<?php
require_once '../config.php';

// Activa la depuración (para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = conectarDB(); // Conexión a la base de datos

    // Recibe las credenciales del formulario
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verifica que no estén vacíos
    if (empty($email) || empty($password)) {
        die("<script>alert('Por favor, completa todos los campos.'); window.history.back();</script>");
    }

    // Prepara la consulta para buscar al usuario por correo
    $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Si el usuario existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verifica la contraseña
        if (password_verify($password, $hashed_password)) {
            session_start(); // Inicia la sesión
            $_SESSION['user_id'] = $id; // Almacena el ID del usuario en la sesión
            echo "<script>alert('Inicio de sesión exitoso.'); window.location.href = 'productos.php';</script>";
        } else {
            echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('El correo electrónico no está registrado.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Método no permitido.'); window.history.back();</script>";
}
?>
