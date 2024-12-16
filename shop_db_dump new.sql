-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: shop_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB
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

CREATE DATABASE shop_db;

USE shop_db;

--
-- Table structure for table `cart`
--
DROP TABLE IF EXISTS `cart`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `cart` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) NOT NULL,
    `pid` int (11) NOT NULL,
    `name` varchar(100) NOT NULL,
    `price` double (8, 2) NOT NULL DEFAULT 0.00,
    `quantity` int (10) NOT NULL,
    `image` text NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 13 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--
LOCK TABLES `cart` WRITE;

/*!40000 ALTER TABLE `cart` DISABLE KEYS */;

/*!40000 ALTER TABLE `cart` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `cart_item`
--
DROP TABLE IF EXISTS `cart_item`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `cart_item` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) NOT NULL,
    `pid` int (11) NOT NULL,
    `qty` int (2) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_item`
--
LOCK TABLES `cart_item` WRITE;

/*!40000 ALTER TABLE `cart_item` DISABLE KEYS */;

/*!40000 ALTER TABLE `cart_item` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `orders`
--
DROP TABLE IF EXISTS `orders`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `orders` (
    `id` int (100) NOT NULL AUTO_INCREMENT,
    `user_id` int (100) NOT NULL,
    `name` varchar(20) NOT NULL,
    `number` varchar(10) NOT NULL,
    `email` varchar(50) NOT NULL,
    `method` varchar(50) NOT NULL,
    `address` text NOT NULL,
    `total_products` varchar(1000) NOT NULL,
    `total_price` double (8, 2) NOT NULL,
    `placed_on` date NOT NULL DEFAULT current_timestamp(),
    `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
    `order_status` varchar(20) NOT NULL DEFAULT 'processing',
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--
LOCK TABLES `orders` WRITE;

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO
  `orders`
VALUES
  (
    4,
    1,
    'ss',
    '111222',
    'ss@ss.com',
    'credit card',
    'flat no. ddd, dddd, ddd, ddd, dddd - 145',
    'iPhone 13 Pro Max (2349.99 x 1) - Lenovo (789.2 x 3) - ',
    4717.59,
    '2024-01-16',
    'pending',
    'processing'
  );

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `products`
--
DROP TABLE IF EXISTS `products`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `products` (
    `id` int (100) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `details` text DEFAULT 'N/A',
    `brand` varchar(50) NOT NULL DEFAULT 'N/A',
    `released` varchar(10) NOT NULL DEFAULT 'N/A',
    `qty` int (2) NOT NULL DEFAULT 0,
    `cpu` varchar(255) NOT NULL DEFAULT 'N/A',
    `storage` varchar(10) DEFAULT 'N/A',
    `ram` varchar(10) NOT NULL DEFAULT 'N/A',
    `camera_count` int (2) NOT NULL DEFAULT 0,
    `camera_resolution` varchar(255) NOT NULL DEFAULT 'N/A',
    `size` varchar(15) NOT NULL DEFAULT '0.0 in',
    `battery` varchar(15) NOT NULL DEFAULT '0 mAh',
    `color` varchar(50) NOT NULL DEFAULT 'N/A',
    `price` double (8, 2) DEFAULT 0.00,
    `image_01` text NOT NULL,
    `image_02` text NOT NULL,
    `image_03` text NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_product_name` (`name`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--
LOCK TABLES `products` WRITE;

/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO
  `products`
VALUES
  (
    5,
    'Samsung Galaxy S21 Ultra',
    'The Samsung Galaxy S21 Ultra is a premium flagship smartphone with cutting-edge features, a top-of-the-line camera system, and powerful hardware.',
    'Samsung',
    '2021-01-29',
    5,
    'Exynos 2100',
    '512GB',
    '16GB',
    4,
    '108MP (wide), 12MP (ultrawide), 10MP (periscope telephoto), 10MP (telephoto)',
    '6.8 in',
    '5000 mAh',
    'Phantom Black',
    1199.99,
    'Samsung Galaxy S21 Ultra 1.png',
    'Samsung Galaxy S21 Ultra 2.png',
    'Samsung Galaxy S21 Ultra 3.png'
  ),
  (
    6,
    'iPhone 13 Pro Max',
    'The iPhone 13 Pro Max is the latest flagship smartphone from Apple, featuring a powerful A15 Bionic chip, exceptional camera capabilities, and a stunning Super Retina XDR display.',
    'Apple',
    '2021-09-14',
    10,
    'A15 Bionic',
    '1TB',
    '8GB',
    3,
    '12MP (wide), 12MP (ultrawide), 12MP (telephoto)',
    '6.7 in',
    '4352 mAh',
    'Graphite',
    2349.99,
    'iphone 13 pro max graphyte 1.png',
    'iphone 13 pro max graphyte 2.png',
    'iphone 13 pro max graphyte 3.png'
  ),
  (
    8,
    'wefr',
    'dcf',
    'N/A',
    'N/A',
    0,
    'N/A',
    'N/A',
    'N/A',
    0,
    'N/A',
    '0.0 in',
    '0 mAh',
    'N/A',
    456.00,
    'gojo blue.jpg',
    'ichigoblue.png',
    'jojocoolbluehue.png'
  ),
  (
    9,
    'Lenovo',
    'Th ebst prpb',
    'Lenovo',
    '01/05/2025',
    5,
    'Ryzen',
    '15GB',
    '4GB',
    2,
    '15MP',
    '6.7 in',
    '5000 mAh',
    'green',
    789.20,
    'gojo bg ph.jpg',
    'gojo-aizen.jpg',
    'gojo ph bg.jpg'
  );

/*!40000 ALTER TABLE `products` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `services`
--
DROP TABLE IF EXISTS `services`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `services` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) NOT NULL,
    `placed_on` date NOT NULL DEFAULT current_timestamp(),
    `name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `number` varchar(15) NOT NULL,
    `brand` varchar(50) NOT NULL DEFAULT 'N/A',
    `description` text NOT NULL,
    `isResolved` int (1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `fk_user_id` (`user_id`),
    CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--
LOCK TABLES `services` WRITE;

/*!40000 ALTER TABLE `services` DISABLE KEYS */;

INSERT INTO
  `services`
VALUES
  (
    1,
    1,
    '2024-01-16',
    'An',
    'ui@ui.com',
    '0455895444',
    'Smasung',
    'th nflvc;;db',
    0
  );

/*!40000 ALTER TABLE `services` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `users` (
    `id` int (100) NOT NULL AUTO_INCREMENT,
    `name` varchar(20) NOT NULL,
    `email` varchar(50) NOT NULL,
    `password` varchar(50) NOT NULL,
    `isAdmin` int (1) NOT NULL DEFAULT 0,
    `avatar` text NOT NULL DEFAULT 'default.png',
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_email` (`email`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 23 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--
LOCK TABLES `users` WRITE;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO
  `users`
VALUES
  (
    1,
    'user',
    'user@user.com',
    '12dea96fec20593566ab75692c9949596833adc9',
    0,
    'logedin.png'
  ),
  (
    2,
    'admin',
    'admin@admin.com',
    'd033e22ae348aeb5660fc2140aec35850c4da997',
    1,
    'logedin.png'
  ),
  (
    19,
    'Jewel Shahi',
    'jewel@gmail.com',
    'f7c3bc1d808e04732adf679965ccc34ca7ae3441',
    0,
    'logedin.png'
  ),
  (
    22,
    'Owner',
    'owner@owner.com',
    '579233b2c479241523cba5e3af55d0f50f2d6414',
    1,
    'logedin.png'
  );

/*!40000 ALTER TABLE `users` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--
DROP TABLE IF EXISTS `wishlist`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `wishlist` (
    `id` int (100) NOT NULL,
    `user_id` int (100) NOT NULL,
    `pid` int (100) NOT NULL,
    `name` varchar(100) NOT NULL,
    `price` int (100) NOT NULL,
    `image` varchar(100) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--
LOCK TABLES `wishlist` WRITE;

/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;

/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `wishlist_item`
--
DROP TABLE IF EXISTS `wishlist_item`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `wishlist_item` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) NOT NULL,
    `pid` int (11) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist_item`
--
LOCK TABLES `wishlist_item` WRITE;

/*!40000 ALTER TABLE `wishlist_item` DISABLE KEYS */;

/*!40000 ALTER TABLE `wishlist_item` ENABLE KEYS */;

UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-16 20:42:03