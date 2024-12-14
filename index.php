<?php
require_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración Veterinaria</title>
    <link rel="stylesheet" href="css/header.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            /* Fondo cubriendo toda la pantalla */
            background: url("imagenes/fondo.png") no-repeat center center fixed;
            background-size: cover;
            overflow: hidden; /* Para que no aparezcan barras de scroll con la animación */
        }

        .container {
            text-align: center;
            color: #ae2626;
            margin-top: 50px;
        }

        /* Estilo para el perro caminando */
        .dog-walker {
            position: absolute;
            bottom: 0;
            left: -200px; /* Inicia fuera de la pantalla a la izquierda */
            width: 200px;
            height: auto;
            animation: walk-dog 10s linear infinite;
        }

        @keyframes walk-dog {
            0% {
                left: -200px;
            }
            100% {
                left: 100%; /* Se desplaza completamente hasta salir por la derecha */
            }
        }
    </style>
</head>
<body>
<!-- Imagen del perro caminando -->
<img src="imagenes/17539344-unscreen.gif" alt="Perro caminando" class="dog-walker">

<div class="container">
    <h1>Bienvenido a Veterinaria Knino</h1>
    <p>Administra tus productos y usuarios desde esta plataforma.</p>
</div>
</body>
</html>
