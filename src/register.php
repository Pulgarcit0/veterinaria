<?php
require_once '../config.php'; // Asegúrate de que la ruta al archivo es correcta

// Función para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = conectarDB(); // Conexión a la base de datos

    // Verifica si la conexión falló
    if (!$conn) {
        die("<script>alert('Error de conexión con la base de datos.');</script>");
    }

    // Recibe los datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $password = $_POST['password'] ?? '';
    $direccion = $_POST['direccion'] ?? '';

    // Valida que los campos no estén vacíos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($direccion)) {
        die("<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>");
    }

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validar si el email ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("<script>alert('El correo electrónico ya está registrado.'); window.history.back();</script>");
    }
    $stmt->close();

    // Inserta el nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, telefono, password, direccion) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $nombre, $apellido, $email, $telefono, $hashed_password, $direccion);

        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href = 'login.html';</script>";
        } else {
            echo "<script>alert('Error al registrar: " . $conn->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error al preparar la consulta.'); window.history.back();</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Método no permitido.'); window.history.back();</script>";
}
?>
