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

USE DATABASE shop_db;

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
  ) ENGINE = InnoDB AUTO_INCREMENT = 7 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--
LOCK TABLES `cart` WRITE;

/*!40000 ALTER TABLE `cart` DISABLE KEYS */;

/*!40000 ALTER TABLE `cart` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `messages`
--
DROP TABLE IF EXISTS `messages`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8 */;

CREATE TABLE
  `messages` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) NOT NULL,
    `name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `number` char(10) NOT NULL,
    `message` text NOT NULL,
    `isResolved` int (1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--
LOCK TABLES `messages` WRITE;

/*!40000 ALTER TABLE `messages` DISABLE KEYS */;

/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

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
    `order_status` varchar(20) NOT NULL DEFAULT 'pending',
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

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
    1,
    1,
    'dvsv',
    '455',
    'dfbdf@d.com',
    'cash on delivery',
    'flat no. dfbvdfb, dfbsdb, dfbds, ffdb, dvdfv - 1254',
    'Samsung Galaxy S21 Ultra (1199.99 x 4) - ',
    4799.96,
    '2024-01-14',
    'completed',
    'shipped'
  ),
  (
    2,
    1,
    'aaaa',
    '4555',
    'jdjfvdfj@ff.com',
    'paytm',
    'flat no. fbdfb, sdvsf, fbdsf, dvsbf, sdvsreb - 785',
    'iPhone 13 Pro Max (2349.99 x 1) - ',
    2349.99,
    '2024-01-14',
    'completed',
    'shipped'
  ),
  (
    3,
    1,
    'Icak',
    '1223',
    'ddd@dd.com',
    'credit card',
    'flat no. ddd, ddd, ddd, dddd, ddd - 132',
    'wefr (123 x 5) - ',
    615.00,
    '2024-01-15',
    '',
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
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

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
  );

/*!40000 ALTER TABLE `products` ENABLE KEYS */;

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
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 17 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

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
    3,
    'jewel',
    'jewelshahi10@gmail.com',
    '16a9a54ddf4259952e3c118c763138e83693d7fd',
    0,
    'logedin.png'
  ),
  (
    4,
    'kalata',
    'kalata@kd.com',
    'fbe0c7a10f88830329b843444e239faff412172d',
    1,
    'default.png'
  ),
  (
    5,
    'ivak',
    'ivakdivak@gmail.com',
    '2ec651a46f1dba00db964e75dd11f13e23c14d33',
    0,
    'logedin.png'
  ),
  (
    6,
    'JewelAlt',
    'joeimportant1020@gmail.com',
    '60e33fbecb7eabe84629b1f4020662c3e3763112',
    0,
    'logedin.png'
  ),
  (
    7,
    'Stamat',
    'stamat@bitex.com',
    '7110eda4d09e062aa5e4a390b0a572ac0d2c0220',
    0,
    'default.png'
  ),
  (
    15,
    'gsdhv',
    's@s.com',
    '7110eda4d09e062aa5e4a390b0a572ac0d2c0220',
    1,
    'default.png'
  ),
  (
    16,
    'icak',
    'icak@icak.com',
    '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684',
    1,
    'default.png'
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

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-15 19:27:55