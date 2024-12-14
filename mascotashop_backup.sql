/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.9-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: mascotashop
-- ------------------------------------------------------
-- Server version	10.11.9-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES
(1,'Perros','Productos y servicios para perros'),
(2,'Gatos','Productos y servicios para gatos'),
(3,'Accesorios','Accesorios diversos para mascotas'),
(4,'Alimentos','Alimentos para mascotas');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalles_pago`
--

DROP TABLE IF EXISTS `detalles_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalles_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pago_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pago_id` (`pago_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `detalles_pago_ibfk_1` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`),
  CONSTRAINT `detalles_pago_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalles_pago`
--

LOCK TABLES `detalles_pago` WRITE;
/*!40000 ALTER TABLE `detalles_pago` DISABLE KEYS */;
INSERT INTO `detalles_pago` VALUES
(1,1,1,1,899.99,899.99),
(2,1,2,1,1050.50,1050.50),
(3,1,3,1,520.99,520.99),
(4,1,8,1,1200.00,1200.00),
(5,2,1,1,899.99,899.99),
(6,3,2,1,1050.50,1050.50),
(7,3,3,1,520.99,520.99),
(8,4,2,2,1050.50,2101.00);
/*!40000 ALTER TABLE `detalles_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas`
--

LOCK TABLES `ofertas` WRITE;
/*!40000 ALTER TABLE `ofertas` DISABLE KEYS */;
INSERT INTO `ofertas` VALUES
(1,'Descuento en comida para perros','Aprovecha el 20% de descuento en alimentos premium',20.00,'2024-12-01','2024-12-31'),
(2,'2x1 en juguetes para gatos','Compra un juguete y llévate otro gratis',50.00,'2024-12-01','2024-12-15'),
(3,'Servicio de vacunación','Vacunas al 10% de descuento',10.00,'2024-12-05','2024-12-20');
/*!40000 ALTER TABLE `ofertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp(),
  `metodo_pago` enum('tarjeta','efectivo','transferencia') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES
(1,6,3671.48,'2024-12-14 09:41:29','efectivo'),
(2,6,899.99,'2024-12-14 09:45:12','tarjeta'),
(3,6,1571.49,'2024-12-14 09:48:07','tarjeta'),
(4,6,2101.00,'2024-12-14 09:49:29','tarjeta');
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES
(1,'Pro Plan Puppy','Alimento para cachorros con ingredientes premium.',899.99,'proplan-puppy.png','perros'),
(2,'Royal Canin Adult','Alimento para perros adultos de raza mediana.',1050.50,'royal-canin.png','perrossssssss'),
(3,'Whiskas Adulto','Alimento seco para gatos adultos, sabor pescado.',520.99,'whiskas.png','perros'),
(4,'Vitalcan Premium','Alimento balanceado para perros de todas las razas.',750.75,'vitalcan-premium.png','perros'),
(5,'Kong Classic','Juguete interactivo para perros de todas las edades.',450.30,'kong.png','perros'),
(6,'Cama para Perro','Cama acolchonada para perros medianos.',650.00,'cama-perro.png','perros'),
(7,'Rascador para Gato','Rascador de sisal con base resistente.',720.20,'rascador.png','perros'),
(8,'Transportadora Mediana','Transportadora para mascotas medianas.',1200.00,'transportadora.png','perros'),
(9,'Shampoo para Mascotas','Shampoo antipulgas y piel sensible.',230.50,'shampoo.png','perros'),
(10,'Pelota para Perro','Pelota de goma resistente para juegos interactivos.',99.90,'pelota.png','perros'),
(11,'Collar de Nylon','Collar ajustable para perros medianos.',150.00,'collar.png','gatos'),
(12,'Correa para Perro','Correa resistente de nylon, 1.5 metros.',180.50,'correa.png','gatos'),
(13,'Plato Doble','Plato doble para comida y agua.',299.99,'plato-doble.png','gatos'),
(14,'Arena para Gatos','Arena aglomerante con control de olores.',150.75,'arenero.png','gatos'),
(15,'BioPet Cachorros','Alimento económico para cachorros.',399.50,'biopet.png','gatos'),
(16,'Royal Canin Kitten','Alimento para gatitos hasta los 12 meses.',999.00,'royal-canin.png','gatos'),
(17,'Cama para Gato','Cama suave y cómoda para gatos pequeños.',590.00,'cama-perro.png','gatos'),
(18,'Cepillo para Mascotas','Cepillo con cerdas suaves para pelo largo.',250.00,'placeholder.png','gatos'),
(19,'Snacks para Perros','Bocadillos ricos en proteína para perros.',199.50,'placeholder.png','gatos'),
(20,'Hueso Masticable','Hueso masticable de larga duración.',120.99,'placeholder.png','gatos'),
(21,'Pechera para Perro','Pechera ajustable con diseño ergonómico.',350.00,'placeholder.png','accesorios'),
(22,'Túnel para Gatos','Túnel de juego plegable para gatos.',890.00,'placeholder.png','accesorios'),
(23,'Dispensador de Agua','Dispensador automático de agua para mascotas.',760.50,'placeholder.png','accesorios'),
(24,'Bolsa de Premios','Premios para perros con sabor a pollo.',89.90,'placeholder.png','accesorios'),
(25,'Jaula Plegable','Jaula plegable para transporte de mascotas.',1890.00,'placeholder.png','accesorios'),
(26,'Cortaúñas para Mascotas','Cortaúñas de acero inoxidable.',110.00,'placeholder.png','accesorios'),
(27,'Guante Quitapelos','Guante para eliminar pelo muerto.',140.00,'placeholder.png','accesorios'),
(28,'Ratón de Juguete','Ratón de felpa para gatos.',75.00,'placeholder.png','accesorios'),
(29,'Casita para Gato','Casita compacta con rascador incluido.',950.00,'placeholder.png','accesorios'),
(30,'Juguete Sonajero','Juguete sonajero para cachorros.',150.00,'placeholder.png','accesorios'),
(31,'Cuerda para Perros','Juguete de cuerda resistente.',99.99,'placeholder.png','alimentos'),
(32,'Toalla Absorbente','Toalla super absorbente para secar mascotas.',220.00,'placeholder.png','alimentos'),
(33,'Bolsa de Arena','Arena económica para gatos.',99.50,'placeholder.png','alimentos'),
(34,'Funda Protectora','Funda para el asiento del coche.',560.00,'placeholder.png','alimentos'),
(35,'Collar Antipulgas','Collar antipulgas con duración de 6 meses.',310.00,'placeholder.png','alimentos'),
(36,'Alimento Húmedo','Alimento húmedo en sobre para perros.',80.50,'placeholder.png','alimentos'),
(37,'Kit de Entrenamiento','Kit para entrenar perros en casa.',350.00,'placeholder.png','alimentos'),
(38,'Pelota con Luz','Pelota con luz para jugar en la oscuridad.',150.00,'placeholder.png','alimentos'),
(39,'Ropa para Perro','Ropa impermeable para perros pequeños.',450.00,'placeholder.png','alimentos'),
(40,'Arnés para Gato','Arnés con correa ajustable.',299.50,'placeholder.png','alimentos'),
(41,'Caja de Arena','Caja higiénica para gatos.',480.00,'placeholder.png','alimentos'),
(42,'Reloj Dispensador','Comedero con temporizador programable.',1200.00,'placeholder.png','alimentos'),
(43,'Hueso de Nuez','Juguete masticable con sabor a nuez.',200.00,'placeholder.png','alimentos'),
(44,'Tijeras para Pelo','Tijeras profesionales para mascotas.',300.00,'placeholder.png','alimentos'),
(45,'Cama de Lujo','Cama de alta calidad con relleno extra.',1500.00,'placeholder.png','alimentos'),
(46,'Kit de Limpieza','Kit completo para limpieza de orejas.',250.00,'placeholder.png','alimentos');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES
(1,'Consulta veterinaria','Servicios médicos para mascotas'),
(2,'Vacunación','Aplicación de vacunas para mascotas'),
(3,'Peluquería','Corte y cuidado del pelo de tu mascota'),
(4,'Adiestramiento','Cursos para mejorar el comportamiento de tu mascota');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `rol` enum('admin','comprador') NOT NULL DEFAULT 'comprador',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(1,'Hugolino','Valentin','vale.metal520.69@gmail.com','9512435219','$2y$10$lCGmf2SrgAeJVtrrW4s6C.zuhpXSMmN.tHg1pLpnNf/zYsPNuJmvS','AVENIDA MONTEBELLO - 71233','admin'),
(2,'admin','admin','admin@gmail.com','9512435219','$2y$10$rmANJTKbQmaz5jryrolpTuKExfflH3wrApHQ/.MFnRk.CeWdigIUa','admin','admin'),
(3,'Hugolino','Valentin','123@gmail.com','9512435219','$2y$10$wHKeudQkpR07TrGbwP9/7uc2sU2hdH3W27hWvilQeXX.bFn.fKDly','AVENIDA MONTEBELLO - 71233','comprador'),
(4,'Admin1','Apellido1','admin1@mascotashop.com','1234567890','hashed_password1','Dirección 1','comprador'),
(5,'Admin2','Apellido2','admin2@mascotashop.com','0987654321','hashed_password2','Dirección 2','comprador'),
(6,'qw','qw','qw@gmail.com','12','$2y$10$6aZFhQtjMYBt.hk5UYNOYuQd6ytRlqe/5CagpOyzFUkrgfCc8/00G','AVENIDA MONTEBELLO - 71233','comprador');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-14  3:58:25
