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
  `caja_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `estado` varchar(15) DEFAULT 'ABIERTO',
  `fecha_apertura` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `apertura_cajas_ibfk_2` (`caja_id`),
  CONSTRAINT `apertura_cajas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `apertura_cajas_ibfk_2` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articulos`
--

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `serie_id` bigint(20) unsigned NOT NULL,
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
  KEY `serie_id` (`serie_id`),
  CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `serie` (`id`),
  CONSTRAINT `fk_categoria_articulos` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_producto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `mail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientes_rut_unique` (`rut`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `mail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proveedors_rut_unique` (`rut`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `serie`
--

DROP TABLE IF EXISTS `serie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serie` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `serie` varchar(15) NOT NULL,
  `secuencia` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `serie` (`serie`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

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
INSERT INTO `tipo_documentos` VALUES (33,'Recibo',0,'2023-07-15 08:59:18','2024-03-16 21:09:39'),(34,'Nota de crédito',0,'2023-07-15 08:59:18','2024-02-14 00:32:29'),(39,'Nota de compra',0,'2023-07-15 08:59:18','2023-07-15 08:59:18'),(41,'Cotización ',18,'2023-07-15 08:59:18','2024-03-16 19:50:39'),(99,'Sin documento',0,'2023-07-15 08:59:18','2024-03-15 14:04:16'),(100,'Retención de IVA',0,NULL,NULL),(101,'Recibo de Caja',0,NULL,NULL);
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
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_unique` (`user`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `fk_rol_users` (`id_rol`),
  CONSTRAINT `fk_rol_users` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Hector Rivas','Admin',1,'admin@gmail.com','$2y$10$.cu3Id5jQfkTzjElIv5xzelpxNvppCIa585OmujHAt9KR0mA9Gzfq',1,'2023-07-15 20:01:26','2023-12-10 09:15:03');
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-16 20:05:36
