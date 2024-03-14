-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sivig_laravel
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `ajustes_de_inventarios`
--

DROP TABLE IF EXISTS `ajustes_de_inventarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ajustes_de_inventarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `monto_total` double NOT NULL,
  `entradas` int(11) NOT NULL,
  `salidas` int(11) NOT NULL,
  `tipo_movimiento_id` bigint(20) unsigned NOT NULL,
  `observaciones` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ajustes_de_inventarios_tipo_movimiento_id_foreign` (`tipo_movimiento_id`),
  KEY `ajustes_de_inventarios_user_id_foreign` (`user_id`),
  CONSTRAINT `ajustes_de_inventarios_tipo_movimiento_id_foreign` FOREIGN KEY (`tipo_movimiento_id`) REFERENCES `tipo_movimientos` (`id`),
  CONSTRAINT `ajustes_de_inventarios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ajustes_de_inventarios`
--

LOCK TABLES `ajustes_de_inventarios` WRITE;
/*!40000 ALTER TABLE `ajustes_de_inventarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `ajustes_de_inventarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apertura_cajas`
--

DROP TABLE IF EXISTS `apertura_cajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apertura_cajas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `saldo_inicial` double NOT NULL,
  `saldo_total` double DEFAULT NULL,
  `saldo_faltante` double DEFAULT NULL,
  `saldo_sobrante` double DEFAULT NULL,
  `arqueo_caja` double DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `estado` varchar(15) DEFAULT 'ABIERTO',
  `fecha_apertura` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `apertura_cajas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apertura_cajas`
--

LOCK TABLES `apertura_cajas` WRITE;
/*!40000 ALTER TABLE `apertura_cajas` DISABLE KEYS */;
INSERT INTO `apertura_cajas` VALUES (18,500,600,-100,NULL,500,17,'CERRADO','2024-03-13','2024-03-13 14:40:18','2024-03-13 15:31:26'),(19,2000,2000,-1740,NULL,260,26,'CERRADO','2024-03-13','2024-03-13 14:43:25','2024-03-14 21:46:00'),(20,780,4230,-2224,NULL,2006,27,'CERRADO','2024-03-13','2024-03-13 15:04:08','2024-03-13 15:28:49'),(21,100,600,NULL,0,600,27,'CERRADO','2024-03-13','2024-03-13 15:33:26','2024-03-13 15:36:43'),(22,100,29010,NULL,74440,103450,17,'CERRADO','2024-03-13','2024-03-13 16:13:04','2024-03-14 04:33:10'),(23,45,670,-284,NULL,386,17,'CERRADO','2024-03-13','2024-03-14 04:36:39','2024-03-14 04:45:33'),(24,100,NULL,NULL,NULL,NULL,17,'ABIERTO','2024-03-13','2024-03-14 04:45:44','2024-03-14 04:45:44');
/*!40000 ALTER TABLE `apertura_cajas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulos`
--

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cod_interno` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_barras` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_categoria` bigint(20) NOT NULL,
  `precio_venta` double NOT NULL,
  `precio_compra` double NOT NULL,
  `stock` int(11) NOT NULL,
  `url_imagen` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock_critico` int(11) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articulos_cod_interno_unique` (`cod_interno`),
  UNIQUE KEY `articulos_cod_barras_unique` (`cod_barras`),
  KEY `fk_categoria_articulos` (`id_categoria`),
  CONSTRAINT `fk_categoria_articulos` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_producto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos`
--

LOCK TABLES `articulos` WRITE;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` VALUES (1,'A00001','A00001','ARTICULO DE PRUEBA',1,150,50,838,NULL,2,1,'2023-12-11 21:35:15','2024-03-14 04:16:26'),(3,'A00002',NULL,'Segundo Articulo',1,150,100,156,NULL,NULL,1,'2024-01-29 23:28:30','2024-03-14 21:21:06'),(4,'A00003',NULL,'Articulo numero tres',1,10,5,0,NULL,NULL,1,'2024-01-30 04:30:27','2024-03-06 21:40:16'),(5,'A00004',NULL,'Articulo 4',1,50,2,257,NULL,NULL,1,'2024-01-30 04:31:34','2024-03-14 21:17:29');
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cajas`
--

DROP TABLE IF EXISTS `cajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cajas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `caja` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cajas`
--

LOCK TABLES `cajas` WRITE;
/*!40000 ALTER TABLE `cajas` DISABLE KEYS */;
INSERT INTO `cajas` VALUES (1,'CAJA FK',NULL,'2024-03-12 15:59:57'),(2,'CAJA VIVI',NULL,'2024-03-12 09:01:53'),(3,'CAJA03','2024-03-12 12:10:17','2024-03-12 12:10:50');
/*!40000 ALTER TABLE `cajas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria_producto`
--

DROP TABLE IF EXISTS `categoria_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_producto` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_producto`
--

LOCK TABLES `categoria_producto` WRITE;
/*!40000 ALTER TABLE `categoria_producto` DISABLE KEYS */;
INSERT INTO `categoria_producto` VALUES (1,'Ninguna','2023-12-11 21:34:21','2024-03-14 21:24:09');
/*!40000 ALTER TABLE `categoria_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rut` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientes_rut_unique` (`rut`)
) ENGINE=InnoDB AUTO_INCREMENT=666669 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'CF','CONSUMIDOR FINAL','SANARATE','cliente@gmail.com',38592837,'2023-12-11 21:39:00','2023-12-11 21:39:00'),(2,'10293829','SEGUNDO CLIENTE','NA','NA@na.com',48572039,'2024-03-13 16:04:05','2024-03-13 16:04:05'),(666668,'0990797','Prueba','SANARATE','correo@correo.com',89765787,'2024-03-14 21:27:11','2024-03-14 21:27:11');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentas_x_cobrar`
--

DROP TABLE IF EXISTS `cuentas_x_cobrar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuentas_x_cobrar` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venta_id` bigint(20) unsigned NOT NULL,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `dias_credito` int(11) NOT NULL,
  `fecha_pagar` varchar(15) NOT NULL,
  `monto_total` double(10,2) NOT NULL,
  `saldo_pendiente` double(10,2) NOT NULL,
  `estado` varchar(55) NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `venta_id` (`venta_id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `cuentas_x_cobrar_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`),
  CONSTRAINT `cuentas_x_cobrar_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentas_x_cobrar`
--

LOCK TABLES `cuentas_x_cobrar` WRITE;
/*!40000 ALTER TABLE `cuentas_x_cobrar` DISABLE KEYS */;
INSERT INTO `cuentas_x_cobrar` VALUES (1,15,1,31,'2024-04-02',5000.00,5000.00,'Pendiente','2024-03-02 23:51:36','2024-03-02 23:51:36'),(2,33,2,10,'2024-03-23',250.00,250.00,'Pendiente','2024-03-14 01:11:26','2024-03-14 01:11:26'),(3,66,2,60,'2024-05-13',535.00,535.00,'Pendiente','2024-03-14 21:17:29','2024-03-14 21:17:29');
/*!40000 ALTER TABLE `cuentas_x_cobrar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_ajustes_de_inventarios`
--

DROP TABLE IF EXISTS `detalle_ajustes_de_inventarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_ajustes_de_inventarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ajuste_de_inventario_id` bigint(20) unsigned NOT NULL,
  `articulo_id` bigint(20) unsigned NOT NULL,
  `precio_venta` double NOT NULL,
  `entradas` int(11) NOT NULL,
  `salidas` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_ajustes_de_inventarios_ajuste_de_inventario_id_foreign` (`ajuste_de_inventario_id`),
  KEY `detalle_ajustes_de_inventarios_articulo_id_foreign` (`articulo_id`),
  CONSTRAINT `detalle_ajustes_de_inventarios_ajuste_de_inventario_id_foreign` FOREIGN KEY (`ajuste_de_inventario_id`) REFERENCES `ajustes_de_inventarios` (`id`),
  CONSTRAINT `detalle_ajustes_de_inventarios_articulo_id_foreign` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ajustes_de_inventarios`
--

LOCK TABLES `detalle_ajustes_de_inventarios` WRITE;
/*!40000 ALTER TABLE `detalle_ajustes_de_inventarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_ajustes_de_inventarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_apertura_cajas`
--

DROP TABLE IF EXISTS `detalle_apertura_cajas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_apertura_cajas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) DEFAULT NULL,
  `ingreso` double DEFAULT NULL,
  `egreso` double DEFAULT NULL,
  `apertura_cajas_id` bigint(20) unsigned NOT NULL,
  `venta_id` bigint(20) unsigned DEFAULT NULL,
  `recepciones_id` bigint(20) unsigned DEFAULT NULL,
  `saldo_total` double DEFAULT NULL,
  `caja_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apertura_cajas_id` (`apertura_cajas_id`),
  KEY `venta_id` (`venta_id`),
  KEY `recepciones_id` (`recepciones_id`),
  KEY `detalle_apertura_cajas_ibfk_4` (`caja_id`),
  CONSTRAINT `detalle_apertura_cajas_ibfk_1` FOREIGN KEY (`apertura_cajas_id`) REFERENCES `apertura_cajas` (`id`),
  CONSTRAINT `detalle_apertura_cajas_ibfk_2` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`),
  CONSTRAINT `detalle_apertura_cajas_ibfk_3` FOREIGN KEY (`recepciones_id`) REFERENCES `recepciones` (`id`),
  CONSTRAINT `detalle_apertura_cajas_ibfk_4` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_apertura_cajas`
--

LOCK TABLES `detalle_apertura_cajas` WRITE;
/*!40000 ALTER TABLE `detalle_apertura_cajas` DISABLE KEYS */;
INSERT INTO `detalle_apertura_cajas` VALUES (50,'Saldo inicial',NULL,NULL,18,NULL,NULL,500,1,'2024-03-13 14:40:18','2024-03-13 14:40:18'),(51,'Saldo inicial',NULL,NULL,19,NULL,NULL,2000,2,'2024-03-13 14:43:26','2024-03-13 14:43:26'),(52,'Venta',NULL,NULL,18,23,NULL,600,1,'2024-03-13 14:47:15','2024-03-13 14:47:15'),(53,'Saldo inicial',NULL,NULL,20,NULL,NULL,780,3,'2024-03-13 15:04:08','2024-03-13 15:04:08'),(54,'Venta',NULL,NULL,20,24,NULL,4230,3,'2024-03-13 15:06:23','2024-03-13 15:06:23'),(55,'Saldo inicial',NULL,NULL,21,NULL,NULL,100,3,'2024-03-13 15:33:26','2024-03-13 15:33:26'),(56,'Venta',NULL,NULL,21,25,NULL,600,3,'2024-03-13 15:35:22','2024-03-13 15:35:22'),(57,'Saldo inicial',NULL,NULL,22,NULL,NULL,100,1,'2024-03-13 16:13:04','2024-03-13 16:13:04'),(58,'Venta',NULL,NULL,22,26,NULL,450,1,'2024-03-13 16:57:14','2024-03-13 16:57:14'),(59,'Venta',NULL,NULL,22,27,NULL,850,1,'2024-03-13 22:52:13','2024-03-13 22:52:13'),(60,'Venta',NULL,NULL,22,28,NULL,950,1,'2024-03-13 22:53:29','2024-03-13 22:53:29'),(61,'Venta',NULL,NULL,22,29,NULL,1950,1,'2024-03-13 22:54:24','2024-03-13 22:54:24'),(62,'Venta',NULL,NULL,22,30,NULL,2060,1,'2024-03-14 00:40:11','2024-03-14 00:40:11'),(63,'Venta',NULL,NULL,22,31,NULL,2210,1,'2024-03-14 00:56:43','2024-03-14 00:56:43'),(64,'Venta',NULL,NULL,22,32,NULL,2460,1,'2024-03-14 01:09:46','2024-03-14 01:09:46'),(65,'Venta',NULL,NULL,22,33,NULL,2710,1,'2024-03-14 01:11:26','2024-03-14 01:11:26'),(66,'Venta',NULL,NULL,22,34,NULL,2960,1,'2024-03-14 01:28:09','2024-03-14 01:28:09'),(67,'Venta',NULL,NULL,22,35,NULL,3260,1,'2024-03-14 02:34:50','2024-03-14 02:34:50'),(68,'Venta',NULL,NULL,22,36,NULL,3510,1,'2024-03-14 02:53:53','2024-03-14 02:53:53'),(69,'Venta',NULL,NULL,22,37,NULL,3560,1,'2024-03-14 02:57:03','2024-03-14 02:57:03'),(70,'Venta',NULL,NULL,22,38,NULL,3860,1,'2024-03-14 03:12:54','2024-03-14 03:12:54'),(71,'Venta',NULL,NULL,22,39,NULL,4610,1,'2024-03-14 03:14:59','2024-03-14 03:14:59'),(72,'Venta',NULL,NULL,22,40,NULL,4710,1,'2024-03-14 03:18:07','2024-03-14 03:18:07'),(73,'Venta',NULL,NULL,22,41,NULL,4860,1,'2024-03-14 03:19:55','2024-03-14 03:19:55'),(74,'Venta',NULL,NULL,22,42,NULL,5310,1,'2024-03-14 03:23:31','2024-03-14 03:23:31'),(75,'Venta',NULL,NULL,22,43,NULL,5460,1,'2024-03-14 03:24:07','2024-03-14 03:24:07'),(76,'Venta',NULL,NULL,22,44,NULL,5760,1,'2024-03-14 03:24:38','2024-03-14 03:24:38'),(77,'Venta',NULL,NULL,22,45,NULL,6060,1,'2024-03-14 03:25:30','2024-03-14 03:25:30'),(78,'Venta',NULL,NULL,22,46,NULL,6360,1,'2024-03-14 03:26:00','2024-03-14 03:26:00'),(79,'Venta',NULL,NULL,22,47,NULL,14460,1,'2024-03-14 03:28:32','2024-03-14 03:28:32'),(80,'Venta',NULL,NULL,22,48,NULL,14610,1,'2024-03-14 03:32:01','2024-03-14 03:32:01'),(81,'Venta',NULL,NULL,22,49,NULL,14760,1,'2024-03-14 03:41:18','2024-03-14 03:41:18'),(82,'Venta',NULL,NULL,22,50,NULL,14910,1,'2024-03-14 03:42:23','2024-03-14 03:42:23'),(83,'Venta',NULL,NULL,22,51,NULL,15060,1,'2024-03-14 03:43:30','2024-03-14 03:43:30'),(84,'Venta',NULL,NULL,22,52,NULL,15510,1,'2024-03-14 03:48:05','2024-03-14 03:48:05'),(85,'Venta',NULL,NULL,22,53,NULL,16110,1,'2024-03-14 03:49:26','2024-03-14 03:49:26'),(86,'Venta',NULL,NULL,22,54,NULL,16560,1,'2024-03-14 03:51:31','2024-03-14 03:51:31'),(87,'Venta',NULL,NULL,22,55,NULL,17010,1,'2024-03-14 03:57:48','2024-03-14 03:57:48'),(88,'Venta',NULL,NULL,22,56,NULL,17460,1,'2024-03-14 03:58:56','2024-03-14 03:58:56'),(89,'Venta',NULL,NULL,22,57,NULL,18510,1,'2024-03-14 04:01:09','2024-03-14 04:01:09'),(90,'Venta',NULL,NULL,22,58,NULL,23310,1,'2024-03-14 04:02:32','2024-03-14 04:02:32'),(91,'Venta',NULL,NULL,22,59,NULL,28410,1,'2024-03-14 04:04:49','2024-03-14 04:04:49'),(92,'Venta',NULL,NULL,22,60,NULL,28810,1,'2024-03-14 04:06:29','2024-03-14 04:06:29'),(93,'Venta',NULL,NULL,22,61,NULL,29410,1,'2024-03-14 04:16:26','2024-03-14 04:16:26'),(94,'Factura Anulada',NULL,400,22,NULL,NULL,29010,1,'2024-03-14 04:31:44','2024-03-14 04:31:44'),(95,'Saldo inicial',NULL,NULL,23,NULL,NULL,45,1,'2024-03-14 04:36:39','2024-03-14 04:36:39'),(96,'Venta',NULL,NULL,23,62,NULL,195,1,'2024-03-14 04:36:56','2024-03-14 04:36:56'),(97,'Venta',NULL,NULL,23,63,NULL,670,1,'2024-03-14 04:41:48','2024-03-14 04:41:48'),(98,'Saldo inicial',NULL,NULL,24,NULL,NULL,100,1,'2024-03-14 04:45:44','2024-03-14 04:45:44'),(99,'Venta',NULL,NULL,24,64,NULL,250,1,'2024-03-14 04:46:16','2024-03-14 04:46:16'),(100,'Factura Anulada',NULL,96,24,NULL,NULL,154,1,'2024-03-14 04:49:11','2024-03-14 04:49:11'),(101,'Venta',NULL,NULL,24,66,NULL,689,1,'2024-03-14 21:17:29','2024-03-14 21:17:29'),(102,'Venta',NULL,NULL,24,67,NULL,1139,1,'2024-03-14 21:21:06','2024-03-14 21:21:06');
/*!40000 ALTER TABLE `detalle_apertura_cajas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_movimientos_articulos`
--

DROP TABLE IF EXISTS `detalle_movimientos_articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_movimientos_articulos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `movimiento_id` bigint(20) unsigned NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `producto_id` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_movimientos_articulos_movimiento_id_foreign` (`movimiento_id`),
  KEY `detalle_movimientos_articulos_producto_id_foreign` (`producto_id`),
  KEY `detalle_movimientos_articulos_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `detalle_movimientos_articulos_movimiento_id_foreign` FOREIGN KEY (`movimiento_id`) REFERENCES `tipo_movimientos` (`id`),
  CONSTRAINT `detalle_movimientos_articulos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `articulos` (`id`),
  CONSTRAINT `detalle_movimientos_articulos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_movimientos_articulos`
--

LOCK TABLES `detalle_movimientos_articulos` WRITE;
/*!40000 ALTER TABLE `detalle_movimientos_articulos` DISABLE KEYS */;
INSERT INTO `detalle_movimientos_articulos` VALUES (1,1,1,1,1500,17,'2023-12-11 21:39:46','2023-12-11 21:39:46'),(2,2,1,1,500,17,'2023-12-11 21:43:16','2023-12-11 21:43:16'),(3,2,2,1,100,17,'2023-12-11 21:43:35','2023-12-11 21:43:35'),(4,2,3,1,45,17,'2024-01-30 21:15:54','2024-01-30 21:15:54'),(5,1,2,5,700,17,'2024-01-30 21:18:40','2024-01-30 21:18:40'),(6,2,4,5,699,17,'2024-02-13 10:57:31','2024-02-13 10:57:31'),(7,2,5,4,5,17,'2024-02-14 00:27:53','2024-02-14 00:27:53'),(8,2,6,1,99,17,'2024-02-14 00:31:56','2024-02-14 00:31:56'),(9,2,7,5,66,17,'2024-02-14 00:32:28','2024-02-14 00:32:28'),(10,2,8,3,10,17,'2024-03-01 21:49:09','2024-03-01 21:49:09'),(11,2,9,3,3,17,'2024-03-01 21:53:34','2024-03-01 21:53:34'),(12,2,10,3,2,17,'2024-03-01 21:57:03','2024-03-01 21:57:03'),(13,1,3,1,10,17,'2024-03-01 22:32:46','2024-03-01 22:32:46'),(14,1,4,1,10,17,'2024-03-01 22:39:08','2024-03-01 22:39:08'),(15,1,5,1,50,17,'2024-03-01 22:45:21','2024-03-01 22:45:21'),(16,1,6,3,150,17,'2024-03-01 23:22:10','2024-03-01 23:22:10'),(17,1,7,4,50,17,'2024-03-01 23:23:13','2024-03-01 23:23:13'),(18,2,11,3,2,17,'2024-03-02 20:50:03','2024-03-02 20:50:03'),(19,2,11,5,2,17,'2024-03-02 20:50:03','2024-03-02 20:50:03'),(20,2,12,5,32,17,'2024-03-02 23:46:44','2024-03-02 23:46:44'),(21,2,15,5,100,17,'2024-03-02 23:51:36','2024-03-02 23:51:36'),(22,2,16,5,250,17,'2024-03-02 23:53:25','2024-03-02 23:53:25'),(23,2,17,4,50,17,'2024-03-06 21:40:15','2024-03-06 21:40:15'),(24,2,18,1,50,17,'2024-03-13 00:50:47','2024-03-13 00:50:47'),(25,2,19,3,5,26,'2024-03-13 00:53:50','2024-03-13 00:53:50'),(26,2,20,1,12,17,'2024-03-13 14:23:21','2024-03-13 14:23:21'),(27,2,21,5,1,26,'2024-03-13 14:26:11','2024-03-13 14:26:11'),(28,2,22,5,1,26,'2024-03-13 14:30:46','2024-03-13 14:30:46'),(29,2,23,5,2,17,'2024-03-13 14:47:15','2024-03-13 14:47:15'),(30,2,24,1,23,27,'2024-03-13 15:06:23','2024-03-13 15:06:23'),(31,2,25,5,10,27,'2024-03-13 15:35:22','2024-03-13 15:35:22'),(32,1,8,3,2,17,'2024-03-13 16:22:01','2024-03-13 16:22:01'),(33,2,26,5,1,17,'2024-03-13 16:57:13','2024-03-13 16:57:13'),(34,2,26,3,2,17,'2024-03-13 16:57:13','2024-03-13 16:57:13'),(35,2,27,5,2,17,'2024-03-13 22:52:13','2024-03-13 22:52:13'),(36,2,27,3,2,17,'2024-03-13 22:52:13','2024-03-13 22:52:13'),(37,2,28,5,2,17,'2024-03-13 22:53:29','2024-03-13 22:53:29'),(38,2,29,5,2,17,'2024-03-13 22:54:23','2024-03-13 22:54:23'),(39,2,29,3,3,17,'2024-03-13 22:54:24','2024-03-13 22:54:24'),(40,2,29,1,3,17,'2024-03-13 22:54:24','2024-03-13 22:54:24'),(41,2,30,5,2,17,'2024-03-14 00:40:11','2024-03-14 00:40:11'),(42,2,31,5,3,17,'2024-03-14 00:56:43','2024-03-14 00:56:43'),(43,2,32,5,5,17,'2024-03-14 01:09:46','2024-03-14 01:09:46'),(44,2,33,5,5,17,'2024-03-14 01:11:26','2024-03-14 01:11:26'),(45,2,34,5,5,17,'2024-03-14 01:28:08','2024-03-14 01:28:08'),(46,2,35,3,2,17,'2024-03-14 02:34:50','2024-03-14 02:34:50'),(47,5,36,1,2,17,'2024-03-14 02:53:53','2024-03-14 02:53:53'),(48,5,37,5,1,17,'2024-03-14 02:57:03','2024-03-14 02:57:03'),(49,2,38,3,2,17,'2024-03-14 03:12:53','2024-03-14 03:12:53'),(50,5,39,1,5,17,'2024-03-14 03:14:59','2024-03-14 03:14:59'),(51,2,40,5,2,17,'2024-03-14 03:18:07','2024-03-14 03:18:07'),(52,5,41,1,1,17,'2024-03-14 03:19:55','2024-03-14 03:19:55'),(53,2,42,3,3,17,'2024-03-14 03:23:31','2024-03-14 03:23:31'),(54,2,43,5,3,17,'2024-03-14 03:24:07','2024-03-14 03:24:07'),(55,2,44,3,2,17,'2024-03-14 03:24:38','2024-03-14 03:24:38'),(56,2,45,3,2,17,'2024-03-14 03:25:30','2024-03-14 03:25:30'),(57,2,46,1,2,17,'2024-03-14 03:26:00','2024-03-14 03:26:00'),(58,2,47,3,54,17,'2024-03-14 03:28:32','2024-03-14 03:28:32'),(59,2,48,5,3,17,'2024-03-14 03:32:01','2024-03-14 03:32:01'),(60,5,49,5,3,17,'2024-03-14 03:41:17','2024-03-14 03:41:17'),(61,2,50,5,3,17,'2024-03-14 03:42:23','2024-03-14 03:42:23'),(62,2,51,5,3,17,'2024-03-14 03:43:30','2024-03-14 03:43:30'),(63,2,52,3,3,17,'2024-03-14 03:48:05','2024-03-14 03:48:05'),(64,5,53,3,4,17,'2024-03-14 03:49:26','2024-03-14 03:49:26'),(65,5,54,3,3,17,'2024-03-14 03:51:31','2024-03-14 03:51:31'),(66,2,55,3,3,17,'2024-03-14 03:57:48','2024-03-14 03:57:48'),(67,2,56,3,3,17,'2024-03-14 03:58:56','2024-03-14 03:58:56'),(68,2,57,1,7,17,'2024-03-14 04:01:09','2024-03-14 04:01:09'),(69,2,58,1,32,17,'2024-03-14 04:02:32','2024-03-14 04:02:32'),(70,5,59,3,34,17,'2024-03-14 04:04:49','2024-03-14 04:04:49'),(71,2,60,5,8,17,'2024-03-14 04:06:29','2024-03-14 04:06:29'),(72,2,61,5,3,17,'2024-03-14 04:16:26','2024-03-14 04:16:26'),(73,2,61,1,3,17,'2024-03-14 04:16:26','2024-03-14 04:16:26'),(74,2,62,5,3,17,'2024-03-14 04:36:56','2024-03-14 04:36:56'),(75,5,63,3,3,17,'2024-03-14 04:41:48','2024-03-14 04:41:48'),(76,5,63,5,2,17,'2024-03-14 04:41:48','2024-03-14 04:41:48'),(77,2,64,5,3,17,'2024-03-14 04:46:16','2024-03-14 04:46:16'),(78,5,65,5,2,17,'2024-03-14 04:47:02','2024-03-14 04:47:02'),(79,2,66,3,3,17,'2024-03-14 21:17:29','2024-03-14 21:17:29'),(80,2,66,5,2,17,'2024-03-14 21:17:29','2024-03-14 21:17:29'),(81,2,67,3,3,17,'2024-03-14 21:21:06','2024-03-14 21:21:06');
/*!40000 ALTER TABLE `detalle_movimientos_articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_recepcions`
--

DROP TABLE IF EXISTS `detalle_recepcions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_recepcions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `recepcion_id` bigint(20) unsigned NOT NULL,
  `producto_id` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_recepcions_recepcion_id_foreign` (`recepcion_id`),
  KEY `detalle_recepcions_producto_id_foreign` (`producto_id`),
  CONSTRAINT `detalle_recepcions_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `articulos` (`id`),
  CONSTRAINT `detalle_recepcions_recepcion_id_foreign` FOREIGN KEY (`recepcion_id`) REFERENCES `recepciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_recepcions`
--

LOCK TABLES `detalle_recepcions` WRITE;
/*!40000 ALTER TABLE `detalle_recepcions` DISABLE KEYS */;
INSERT INTO `detalle_recepcions` VALUES (1,1,1,1500,5,'2023-12-11 21:39:46','2023-12-11 21:39:46'),(2,2,5,700,2,'2024-01-30 21:18:40','2024-01-30 21:18:40'),(3,3,1,10,100,'2024-03-01 22:32:45','2024-03-01 22:32:45'),(4,4,1,10,50,'2024-03-01 22:39:08','2024-03-01 22:39:08'),(5,5,1,50,50,'2024-03-01 22:45:20','2024-03-01 22:45:20'),(6,6,3,150,100,'2024-03-01 23:22:09','2024-03-01 23:22:09'),(7,7,4,50,5,'2024-03-01 23:23:13','2024-03-01 23:23:13'),(8,8,3,2,100,'2024-03-13 16:22:01','2024-03-13 16:22:01');
/*!40000 ALTER TABLE `detalle_recepcions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venta_id` bigint(20) unsigned NOT NULL,
  `producto_id` bigint(20) unsigned NOT NULL,
  `descuento` double DEFAULT NULL,
  `precio_venta` double NOT NULL,
  `precio_compra` double NOT NULL,
  `cantidad` double NOT NULL,
  `observacion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalle_ventas_venta_id_foreign` (`venta_id`),
  KEY `detalle_ventas_producto_id_foreign` (`producto_id`),
  CONSTRAINT `detalle_ventas_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `articulos` (`id`),
  CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ventas`
--

LOCK TABLES `detalle_ventas` WRITE;
/*!40000 ALTER TABLE `detalle_ventas` DISABLE KEYS */;
INSERT INTO `detalle_ventas` VALUES (6,6,1,NULL,10,5,99,NULL,'2024-02-14 00:31:56','2024-02-14 00:31:56'),(7,7,5,NULL,50,2,66,NULL,'2024-02-14 00:32:28','2024-02-14 00:32:28'),(8,8,3,NULL,150,0,10,NULL,'2024-03-01 21:49:09','2024-03-01 21:49:09'),(9,9,3,NULL,150,0,3,NULL,'2024-03-01 21:53:34','2024-03-01 21:53:34'),(10,10,3,NULL,150,0,2,NULL,'2024-03-01 21:57:03','2024-03-01 21:57:03'),(11,11,3,NULL,100,100,2,NULL,'2024-03-02 20:50:03','2024-03-02 20:50:03'),(12,11,5,NULL,45,2,2,NULL,'2024-03-02 20:50:03','2024-03-02 20:50:03'),(13,12,5,NULL,50,2,32,NULL,'2024-03-02 23:46:43','2024-03-02 23:46:43'),(14,15,5,NULL,50,2,100,NULL,'2024-03-02 23:51:36','2024-03-02 23:51:36'),(15,16,5,NULL,50,2,250,NULL,'2024-03-02 23:53:25','2024-03-02 23:53:25'),(16,17,4,NULL,10,5,50,NULL,'2024-03-06 21:40:15','2024-03-06 21:40:15'),(17,18,1,NULL,150,50,50,NULL,'2024-03-13 00:50:47','2024-03-13 00:50:47'),(18,19,3,NULL,150,100,5,NULL,'2024-03-13 00:53:50','2024-03-13 00:53:50'),(19,20,1,NULL,150,50,12,NULL,'2024-03-13 14:23:21','2024-03-13 14:23:21'),(20,21,5,NULL,50,2,1,NULL,'2024-03-13 14:26:11','2024-03-13 14:26:11'),(21,22,5,NULL,50,2,1,NULL,'2024-03-13 14:30:45','2024-03-13 14:30:45'),(22,23,5,NULL,50,2,2,NULL,'2024-03-13 14:47:15','2024-03-13 14:47:15'),(23,24,1,NULL,150,50,23,NULL,'2024-03-13 15:06:23','2024-03-13 15:06:23'),(24,25,5,NULL,50,2,10,NULL,'2024-03-13 15:35:21','2024-03-13 15:35:21'),(25,26,5,NULL,50,2,1,'numeros 5 y 1','2024-03-13 16:57:13','2024-03-13 16:57:13'),(26,26,3,NULL,150,100,2,'10*5cms','2024-03-13 16:57:13','2024-03-13 16:57:13'),(27,27,5,NULL,50,2,2,'observación de prueba','2024-03-13 22:52:13','2024-03-13 22:52:13'),(28,27,3,NULL,150,100,2,NULL,'2024-03-13 22:52:13','2024-03-13 22:52:13'),(29,28,5,NULL,50,2,2,NULL,'2024-03-13 22:53:29','2024-03-13 22:53:29'),(30,29,5,NULL,50,2,2,NULL,'2024-03-13 22:54:23','2024-03-13 22:54:23'),(31,29,3,NULL,150,100,3,'SI TIENE COMENTARIO','2024-03-13 22:54:24','2024-03-13 22:54:24'),(32,29,1,NULL,150,50,3,NULL,'2024-03-13 22:54:24','2024-03-13 22:54:24'),(33,30,5,NULL,55,2,2,NULL,'2024-03-14 00:40:11','2024-03-14 00:40:11'),(34,31,5,NULL,50,2,3,NULL,'2024-03-14 00:56:43','2024-03-14 00:56:43'),(35,32,5,NULL,50,2,5,'290','2024-03-14 01:09:46','2024-03-14 01:09:46'),(36,33,5,NULL,50,2,5,'290','2024-03-14 01:11:26','2024-03-14 01:11:26'),(37,34,5,NULL,50,2,5,'TAZA 5 CM','2024-03-14 01:28:08','2024-03-14 01:28:08'),(38,35,3,NULL,150,100,2,NULL,'2024-03-14 02:34:50','2024-03-14 02:34:50'),(39,36,1,NULL,125,50,2,NULL,'2024-03-14 02:53:53','2024-03-14 02:53:53'),(40,37,5,NULL,50,2,1,'OFERTA DE VENTA','2024-03-14 02:57:03','2024-03-14 02:57:03'),(41,38,3,NULL,150,100,2,NULL,'2024-03-14 03:12:53','2024-03-14 03:12:53'),(42,39,1,NULL,150,50,5,NULL,'2024-03-14 03:14:59','2024-03-14 03:14:59'),(43,40,5,NULL,50,2,2,NULL,'2024-03-14 03:18:06','2024-03-14 03:18:06'),(44,41,1,NULL,150,50,1,NULL,'2024-03-14 03:19:55','2024-03-14 03:19:55'),(45,42,3,NULL,150,100,3,'PRUEBA DE ABRI TICKET DE VENTA AL FACTURAR','2024-03-14 03:23:31','2024-03-14 03:23:31'),(46,43,5,NULL,50,2,3,NULL,'2024-03-14 03:24:07','2024-03-14 03:24:07'),(47,44,3,NULL,150,100,2,NULL,'2024-03-14 03:24:37','2024-03-14 03:24:37'),(48,45,3,NULL,150,100,2,NULL,'2024-03-14 03:25:30','2024-03-14 03:25:30'),(49,46,1,NULL,150,50,2,NULL,'2024-03-14 03:26:00','2024-03-14 03:26:00'),(50,47,3,NULL,150,100,54,NULL,'2024-03-14 03:28:32','2024-03-14 03:28:32'),(51,48,5,NULL,50,2,3,NULL,'2024-03-14 03:32:01','2024-03-14 03:32:01'),(52,49,5,NULL,50,2,3,NULL,'2024-03-14 03:41:17','2024-03-14 03:41:17'),(53,50,5,NULL,50,2,3,NULL,'2024-03-14 03:42:23','2024-03-14 03:42:23'),(54,51,5,NULL,50,2,3,NULL,'2024-03-14 03:43:30','2024-03-14 03:43:30'),(55,52,3,NULL,150,100,3,NULL,'2024-03-14 03:48:05','2024-03-14 03:48:05'),(56,53,3,NULL,150,100,4,NULL,'2024-03-14 03:49:26','2024-03-14 03:49:26'),(57,54,3,NULL,150,100,3,NULL,'2024-03-14 03:51:31','2024-03-14 03:51:31'),(58,55,3,NULL,150,100,3,NULL,'2024-03-14 03:57:48','2024-03-14 03:57:48'),(59,56,3,NULL,150,100,3,NULL,'2024-03-14 03:58:55','2024-03-14 03:58:55'),(60,57,1,NULL,150,50,7,NULL,'2024-03-14 04:01:09','2024-03-14 04:01:09'),(61,58,1,NULL,150,50,32,'PRUEBAAA','2024-03-14 04:02:32','2024-03-14 04:02:32'),(62,59,3,NULL,150,100,34,'STOCK','2024-03-14 04:04:48','2024-03-14 04:04:48'),(63,60,5,NULL,50,2,8,NULL,'2024-03-14 04:06:29','2024-03-14 04:06:29'),(64,61,5,NULL,50,2,3,NULL,'2024-03-14 04:16:26','2024-03-14 04:16:26'),(65,61,1,NULL,150,50,3,'SIN OBS','2024-03-14 04:16:26','2024-03-14 04:16:26'),(66,62,5,NULL,50,2,3,NULL,'2024-03-14 04:36:55','2024-03-14 04:36:55'),(67,63,3,NULL,125,100,3,'TAZA CON LOGO DE TARZAN','2024-03-14 04:41:48','2024-03-14 04:41:48'),(68,63,5,NULL,50,2,2,'STICKERS DE BREAKING BAD','2024-03-14 04:41:48','2024-03-14 04:41:48'),(69,64,5,NULL,50,2,3,NULL,'2024-03-14 04:46:16','2024-03-14 04:46:16'),(70,65,5,NULL,48,2,2,NULL,'2024-03-14 04:47:02','2024-03-14 04:47:02'),(71,66,3,NULL,145,100,3,'Observacion de prueba','2024-03-14 21:17:29','2024-03-14 21:17:29'),(72,66,5,NULL,50,2,2,NULL,'2024-03-14 21:17:29','2024-03-14 21:17:29'),(73,67,3,NULL,150,100,3,NULL,'2024-03-14 21:21:06','2024-03-14 21:21:06');
/*!40000 ALTER TABLE `detalle_ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_pagos_cxc`
--

DROP TABLE IF EXISTS `historial_pagos_cxc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_pagos_cxc` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cxc_id` bigint(20) unsigned NOT NULL,
  `monto_abonado` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cxc_id` (`cxc_id`),
  CONSTRAINT `historial_pagos_cxc_ibfk_1` FOREIGN KEY (`cxc_id`) REFERENCES `cuentas_x_cobrar` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_pagos_cxc`
--

LOCK TABLES `historial_pagos_cxc` WRITE;
/*!40000 ALTER TABLE `historial_pagos_cxc` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_pagos_cxc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mediosdepagos`
--

DROP TABLE IF EXISTS `mediosdepagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mediosdepagos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medio_de_pago` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mediosdepagos_medio_de_pago_unique` (`medio_de_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mediosdepagos`
--

LOCK TABLES `mediosdepagos` WRITE;
/*!40000 ALTER TABLE `mediosdepagos` DISABLE KEYS */;
INSERT INTO `mediosdepagos` VALUES (1,'Efectivo','2023-12-04 07:46:46','2023-12-04 07:46:46'),(2,'Transferencia','2023-12-04 07:46:59','2023-12-04 10:40:23');
/*!40000 ALTER TABLE `mediosdepagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` varchar(20) NOT NULL,
  `compra_id` bigint(20) unsigned NOT NULL,
  `medio_pago_id` bigint(20) unsigned NOT NULL,
  `tipo_documentos_id` bigint(20) unsigned NOT NULL,
  `documento` varchar(190) NOT NULL,
  `observaciones` varchar(190) NOT NULL,
  `monto` double NOT NULL,
  `url_imagen` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pagos_compras` (`compra_id`),
  KEY `fk_pagos_medio_pago` (`medio_pago_id`),
  KEY `fk_pagos_tipo_doc` (`tipo_documentos_id`),
  KEY `fk_pagos_user` (`user_id`),
  CONSTRAINT `fk_pagos_compras` FOREIGN KEY (`compra_id`) REFERENCES `recepciones` (`id`),
  CONSTRAINT `fk_pagos_medio_pago` FOREIGN KEY (`medio_pago_id`) REFERENCES `mediosdepagos` (`id`),
  CONSTRAINT `fk_pagos_tipo_doc` FOREIGN KEY (`tipo_documentos_id`) REFERENCES `tipo_documentos` (`id`),
  CONSTRAINT `fk_pagos_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES (1,'2024-03-06 16:09:42',5,2,33,'0001299292','NA',500,'/img_pagos/XLLu8bO7eJ4vVts1kuPdQWG8fmz2qju2kXfaEQuR6YG2auWqeEMsl1P7nnty6WGhY.png',17);
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedors`
--

DROP TABLE IF EXISTS `proveedors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rut` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proveedors_rut_unique` (`rut`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedors`
--

LOCK TABLES `proveedors` WRITE;
/*!40000 ALTER TABLE `proveedors` DISABLE KEYS */;
INSERT INTO `proveedors` VALUES (1,'385928-K','PROVEEDOR DE PRUEBA','SANARATE','prueba@gmail.com',12345678,'2023-12-11 21:38:22','2023-12-11 21:38:22'),(2,'0990797','Proveedor02','SANARATE','PROV@GMAIL.COM',938488394,'2024-03-14 21:28:51','2024-03-14 21:28:51');
/*!40000 ALTER TABLE `proveedors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recepciones`
--

DROP TABLE IF EXISTS `recepciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recepciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_recepcion` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedor_id` bigint(20) unsigned NOT NULL,
  `documento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documentos_id` bigint(20) unsigned NOT NULL,
  `condicion` int(2) NOT NULL,
  `dias_credito` int(10) DEFAULT NULL,
  `fecha_a_pagar` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unidades` int(11) NOT NULL,
  `monto_total` double NOT NULL,
  `saldo_pendiente` double DEFAULT NULL,
  `observaciones` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_imagen` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recepciones_proveedor_id_foreign` (`proveedor_id`),
  KEY `recepciones_tipo_documentos_id_foreign` (`tipo_documentos_id`),
  KEY `recepciones_user_id_foreign` (`user_id`),
  CONSTRAINT `recepciones_proveedor_id_foreign` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedors` (`id`),
  CONSTRAINT `recepciones_tipo_documentos_id_foreign` FOREIGN KEY (`tipo_documentos_id`) REFERENCES `tipo_documentos` (`id`),
  CONSTRAINT `recepciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recepciones`
--

LOCK TABLES `recepciones` WRITE;
/*!40000 ALTER TABLE `recepciones` DISABLE KEYS */;
INSERT INTO `recepciones` VALUES (1,'2023-12-11',1,'385928383',39,1,30,'2024-01-10',1500,7500,7500,'N/A',NULL,17,NULL),(2,'2024-01-30',1,'97987987',33,1,30,'2024-02-29',700,1400,1400,'N/A',NULL,17,NULL),(3,'2024-03-01',1,'001992',33,0,NULL,NULL,10,1000,NULL,'NA',NULL,17,NULL),(4,'2024-03-01',1,'5001939933',33,0,NULL,NULL,10,500,NULL,'NO APLICA','/img_compras/swXEVQzUCMkAzkKwIc0dF0rg1H2iD3sVhKtCibIjz9YYb0LL3n0EKZ4IpPsraNCKe.jpeg',17,NULL),(5,'2024-03-01',1,'0001299292',33,1,50,'2024-04-20',50,2500,2000,'compra',NULL,17,'2024-03-06 22:09:42'),(6,'2024-03-01',1,'10209393',33,0,NULL,NULL,150,15000,NULL,'NA',NULL,17,NULL),(7,'2024-03-01',1,'00192992',39,0,NULL,NULL,50,250,NULL,'NA','/img_compras/qDXa0VkRHl4WuifoQVncU9t4i6iG6UUfEuNZzc2pT0GMWmTrBDPoNn4m8ZneqhRuK.jpeg',17,NULL),(8,'2024-03-13',1,'020939393',33,0,NULL,NULL,2,200,NULL,'NA',NULL,17,NULL);
/*!40000 ALTER TABLE `recepciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(75) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Administrador',NULL,NULL),(2,'Contabilidad',NULL,NULL),(3,'Vendedor',NULL,NULL);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_documentos`
--

DROP TABLE IF EXISTS `tipo_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_documentos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_documento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ultima_emision` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_documentos`
--

LOCK TABLES `tipo_documentos` WRITE;
/*!40000 ALTER TABLE `tipo_documentos` DISABLE KEYS */;
INSERT INTO `tipo_documentos` VALUES (33,'Factura electrónica',54,'2023-07-15 08:59:18','2024-03-14 21:21:06'),(34,'Nota de crédito',1,'2023-07-15 08:59:18','2024-02-14 00:32:29'),(39,'Nota de compra',0,'2023-07-15 08:59:18','2023-07-15 08:59:18'),(41,'Cotización ',14,'2023-07-15 08:59:18','2024-03-14 04:47:02'),(99,'Sin documento',0,'2023-07-15 08:59:18','2023-07-21 09:16:08'),(100,'Retención de IVA',0,NULL,NULL),(101,'Recibo de Caja',0,NULL,NULL);
/*!40000 ALTER TABLE `tipo_documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_movimientos`
--

DROP TABLE IF EXISTS `tipo_movimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_movimientos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_movimiento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_movimientos`
--

LOCK TABLES `tipo_movimientos` WRITE;
/*!40000 ALTER TABLE `tipo_movimientos` DISABLE KEYS */;
INSERT INTO `tipo_movimientos` VALUES (1,'Compra','2023-07-15 08:59:17','2023-07-15 08:59:17'),(2,'Venta','2023-07-15 08:59:17','2023-07-15 08:59:17'),(3,'Robo','2023-07-15 08:59:18','2023-07-15 08:59:18'),(4,'Ajuste de inventario','2023-07-15 08:59:18','2023-07-15 08:59:18'),(5,'Cotización','2023-07-15 08:59:18','2023-07-15 08:59:18'),(6,'Devolucion','2023-07-15 08:59:18','2023-07-15 08:59:18'),(7,'Regalo','2023-07-15 08:59:18','2023-07-15 08:59:18');
/*!40000 ALTER TABLE `tipo_movimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_rol` bigint(20) NOT NULL,
  `caja_id` bigint(20) unsigned NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_unique` (`user`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `fk_rol_users` (`id_rol`),
  KEY `caja_id` (`caja_id`),
  CONSTRAINT `fk_rol_users` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (17,'Oscar Castellanos','Admin',1,1,'admin@gmail.com','$2y$10$.cu3Id5jQfkTzjElIv5xzelpxNvppCIa585OmujHAt9KR0mA9Gzfq',1,'2023-07-15 20:01:26','2023-12-10 09:15:03'),(23,'Administrador','ADM',1,1,'admin@distmultiagro.com','$2y$12$TxRVQOL.1iOYFSsUDLeEU./Z.Alv8F7ueaPxEpJ6gu5lOuolcUS9a',1,'2023-12-10 09:16:31','2023-12-10 09:16:31'),(24,'Contabilidad','Contabilidad',2,1,'conta@distmultiagro.com','$2y$12$QHyWoaolWg.fSfbk8KzvZO70eBYcIEjhrSRau.qu5wH10nQ7JulXK',1,'2023-12-10 09:17:01','2023-12-10 09:17:44'),(25,'Ventas01','Ventas01',3,1,'ventas01@distmultiagro.com','$2y$12$xuoMJezT0AOoXkZCbhKpIu/ra6naGlsIwBEy/4tAXXJ6co80nIYGO',1,'2023-12-10 09:17:33','2023-12-10 09:17:53'),(26,'USUARIO NUEVO','USER',1,2,'prueba@gmail.com','$2y$12$OajyDmTgi3fTOD/Pi.mYUusloecW8jPW0sonc7RzL4UbXmpoBcLaa',1,'2024-03-12 21:53:50','2024-03-12 21:58:51'),(27,'Oscar','Oscar',3,3,'castellanos@gmail.com','$2y$12$OMN/PCsogK1BWrZCdeSYieF6I7F25vyME6ZjgYEf/7bqjX.J1WE6O',1,'2024-03-13 14:48:37','2024-03-13 14:48:37');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unidades` double NOT NULL,
  `monto_total` double NOT NULL,
  `tipo_documentos_id` bigint(20) unsigned NOT NULL,
  `documento` int(11) NOT NULL,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `medio_pago_id` bigint(20) unsigned NOT NULL,
  `condicion` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Contado, 1 = credito',
  `fecha_entrega` date DEFAULT NULL,
  `created_at` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `ventas_tipo_documentos_id_foreign` (`tipo_documentos_id`),
  KEY `ventas_cliente_id_foreign` (`cliente_id`),
  KEY `ventas_medio_pago_id_foreign` (`medio_pago_id`),
  KEY `ventas_user_id_foreign` (`user_id`),
  CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `ventas_medio_pago_id_foreign` FOREIGN KEY (`medio_pago_id`) REFERENCES `mediosdepagos` (`id`),
  CONSTRAINT `ventas_tipo_documentos_id_foreign` FOREIGN KEY (`tipo_documentos_id`) REFERENCES `tipo_documentos` (`id`),
  CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (6,99,990,33,9,1,1,0,NULL,'2024-02-13 18:31:56','2024-02-14 00:33:26',17,0),(7,66,3300,34,1,1,1,0,NULL,'2024-02-13 18:32:28','2024-03-06 05:10:03',17,0),(8,10,1500,33,10,1,2,0,NULL,'2024-03-01 15:49:09','2024-03-01 21:53:45',17,0),(9,3,450,33,11,1,1,0,NULL,'2024-03-01 15:53:34','2024-03-01 21:53:55',17,0),(10,2,300,33,12,1,1,0,NULL,'2024-03-01 15:57:03','2024-03-01 21:57:03',17,1),(11,4,290,33,13,1,1,0,NULL,'2024-03-02 14:50:03','2024-03-02 20:50:03',17,1),(12,32,1600,33,14,1,1,1,NULL,'2024-03-02 17:46:43','2024-03-02 23:46:43',17,1),(15,100,5000,33,15,1,1,1,NULL,'2024-03-02 17:51:36','2024-03-02 23:51:36',17,1),(16,250,12500,33,16,1,1,0,NULL,'2024-03-02 17:53:24','2024-03-02 23:53:24',17,1),(17,50,500,33,17,1,1,0,NULL,'2024-03-06 15:40:15','2024-03-06 21:40:15',17,1),(18,50,7500,33,18,1,1,0,NULL,'2024-03-12 18:50:47','2024-03-13 00:50:47',17,1),(19,5,750,33,19,1,1,0,NULL,'2024-03-12 18:53:50','2024-03-13 00:53:50',26,1),(20,12,1800,33,20,1,1,0,NULL,'2024-03-13 08:23:21','2024-03-13 14:23:21',17,1),(21,1,50,33,21,1,1,0,NULL,'2024-03-13 08:26:11','2024-03-13 14:26:11',26,1),(22,1,50,33,22,1,1,0,NULL,'2024-03-13 08:30:45','2024-03-13 14:30:45',26,1),(23,2,100,33,23,1,1,0,NULL,'2024-03-13 08:47:15','2024-03-13 14:47:15',17,1),(24,23,3450,33,24,1,1,0,NULL,'2024-03-13 09:06:23','2024-03-13 15:06:23',27,1),(25,10,500,33,25,1,1,0,NULL,'2024-03-13 09:35:21','2024-03-13 15:35:21',27,1),(26,3,350,33,26,1,1,0,NULL,'2024-03-13 10:57:13','2024-03-13 16:57:13',17,1),(27,4,400,33,27,2,1,0,NULL,'2024-03-13 16:52:13','2024-03-13 22:52:13',17,1),(28,2,100,33,28,2,1,0,NULL,'2024-03-13 16:53:28','2024-03-13 22:53:28',17,1),(29,8,1000,33,29,1,1,0,NULL,'2024-03-13 16:54:23','2024-03-13 22:54:23',17,1),(30,2,110,41,2,1,1,0,NULL,'2024-03-13 18:40:11','2024-03-14 00:40:11',17,1),(31,3,150,41,3,1,1,0,NULL,'2024-03-13 18:56:43','2024-03-14 00:56:43',17,1),(32,5,250,41,4,2,1,0,NULL,'2024-03-13 19:09:46','2024-03-14 01:09:46',17,1),(33,5,250,33,30,2,1,1,NULL,'2024-03-13 19:11:25','2024-03-14 01:11:25',17,1),(34,5,250,33,31,2,1,0,'2024-03-15','2024-03-13 19:28:08','2024-03-14 01:28:08',17,1),(35,2,300,33,32,1,1,0,NULL,'2024-03-13 20:34:50','2024-03-14 02:34:50',17,1),(36,2,250,41,5,1,1,0,NULL,'2024-03-13 20:53:53','2024-03-14 02:53:53',17,1),(37,1,50,41,6,1,1,0,NULL,'2024-03-13 20:57:03','2024-03-14 02:57:03',17,1),(38,2,300,33,33,1,1,0,NULL,'2024-03-13 21:12:53','2024-03-14 03:12:53',17,1),(39,5,750,41,7,1,1,0,NULL,'2024-03-13 21:14:59','2024-03-14 03:14:59',17,1),(40,2,100,33,34,1,1,0,NULL,'2024-03-13 21:18:06','2024-03-14 03:18:06',17,1),(41,1,150,41,8,2,1,0,NULL,'2024-03-13 21:19:55','2024-03-14 03:19:55',17,1),(42,3,450,33,35,1,1,0,NULL,'2024-03-13 21:23:31','2024-03-14 03:23:31',17,1),(43,3,150,33,36,2,1,0,NULL,'2024-03-13 21:24:07','2024-03-14 03:24:07',17,1),(44,2,300,33,37,1,1,0,NULL,'2024-03-13 21:24:37','2024-03-14 03:24:37',17,1),(45,2,300,33,38,1,1,0,NULL,'2024-03-13 21:25:30','2024-03-14 03:25:30',17,1),(46,2,300,33,39,1,1,0,NULL,'2024-03-13 21:26:00','2024-03-14 03:26:00',17,1),(47,54,8100,33,40,1,1,0,NULL,'2024-03-13 21:28:32','2024-03-14 03:28:32',17,1),(48,3,150,33,41,1,1,0,NULL,'2024-03-13 21:32:01','2024-03-14 03:32:01',17,1),(49,3,150,41,9,1,1,0,NULL,'2024-03-13 21:41:17','2024-03-14 03:41:17',17,1),(50,3,150,33,42,1,1,0,NULL,'2024-03-13 21:42:23','2024-03-14 03:42:23',17,1),(51,3,150,33,43,1,1,0,NULL,'2024-03-13 21:43:30','2024-03-14 03:43:30',17,1),(52,3,450,33,44,1,1,0,NULL,'2024-03-13 21:48:05','2024-03-14 03:48:05',17,1),(53,4,600,41,10,1,1,0,NULL,'2024-03-13 21:49:26','2024-03-14 03:49:26',17,1),(54,3,450,41,11,1,1,0,NULL,'2024-03-13 21:51:31','2024-03-14 03:51:31',17,1),(55,3,450,33,45,1,1,0,NULL,'2024-03-13 21:57:48','2024-03-14 03:57:48',17,1),(56,3,450,33,46,1,1,0,NULL,'2024-03-13 21:58:55','2024-03-14 03:58:55',17,1),(57,7,1050,33,47,1,1,0,NULL,'2024-03-13 22:01:09','2024-03-14 04:01:09',17,1),(58,32,4800,33,48,1,1,0,NULL,'2024-03-13 22:02:32','2024-03-14 04:02:32',17,1),(59,34,5100,41,12,2,1,0,NULL,'2024-03-13 22:04:48','2024-03-14 04:04:48',17,1),(60,8,400,33,49,2,1,0,NULL,'2024-03-13 22:06:29','2024-03-14 04:31:44',17,0),(61,6,600,33,50,2,1,0,'2024-03-13','2024-03-13 22:16:26','2024-03-14 04:16:26',17,1),(62,3,150,33,51,1,1,0,'2024-03-15','2024-03-13 22:36:55','2024-03-14 04:36:55',17,1),(63,5,475,41,13,1,1,0,NULL,'2024-03-13 22:41:47','2024-03-14 04:41:47',17,1),(64,3,150,33,52,1,1,0,NULL,'2024-03-13 22:46:16','2024-03-14 04:46:16',17,1),(65,2,96,41,14,1,1,0,NULL,'2024-03-13 22:47:02','2024-03-14 04:49:11',17,0),(66,5,535,33,53,2,1,1,'2024-03-18','2024-03-14 15:17:29','2024-03-14 21:17:29',17,1),(67,3,450,33,54,2,1,0,NULL,'2024-03-14 15:21:06','2024-03-14 21:21:06',17,1);
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-14 16:25:56
