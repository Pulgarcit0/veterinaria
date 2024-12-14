<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config.php';

function obtenerProductos($busqueda = '', $categoria = '', $historial = false) {
    $conexion = conectarDB();
    $productos = array();

    $query = "SELECT * FROM productos";
    $condiciones = [];

    if (!empty($busqueda)) {
        $busqueda = $conexion->real_escape_string($busqueda);
        $condiciones[] = "nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
    }

    if (!empty($categoria)) {
        $categoria = $conexion->real_escape_string($categoria);
        $condiciones[] = "categoria = '$categoria'";
    }

    if ($historial) {
        $query .= " LIMIT 5"; // Simula historial con los primeros 5 productos
    }

    if (count($condiciones) > 0) {
        $query .= " WHERE " . implode(" AND ", $condiciones);
    }

    $resultado = $conexion->query($query);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = array(
                'id_producto' => $fila['id'],
                'nombre' => $fila['nombre'],
                'precio_venta' => $fila['precio_venta'],
                'imagen' => $fila['imagen'],
                'stock' => $fila['stock'],
                'descripcion' => $fila['descripcion'],
                'categoria' => $fila['categoria']
            );
        }
    }

    $conexion->close();
    return $productos;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $busqueda = $_GET['busqueda'] ?? '';
    $categoria = $_GET['categoria'] ?? '';
    $historial = isset($_GET['historial']);
    $productos = obtenerProductos($busqueda, $categoria, $historial);
    echo json_encode($productos);
}
?>
