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

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) NOT NULL,
  PRIMARY KEY (`user_id`,`pid`),
  KEY `fk_cart_product` (`pid`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_cart_product` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (36,11,'Samsung Galaxy S23 Phantom Black',1440.00,1);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `price` double(8,2) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `order_status` varchar(20) NOT NULL DEFAULT 'processing',
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`,`pid`),
  KEY `fk_orders_product` (`pid`),
  KEY `fk_orders_user` (`user_id`),
  CONSTRAINT `fk_orders_product` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (3,6,1,'Joe','78455','Joe@Joe.com','credit card','flat no. Joe, Joe, Joe, Joe, Joe - 1235',2349.99,'2024-01-20 22:21:51','completed','delivered',1),(3,8,1,'Joe','78455','Joe@Joe.com','credit card','flat no. Joe, Joe, Joe, Joe, Joe - 1235',456.00,'2024-01-20 22:21:51','completed','delivered',1),(3,9,1,'Joe','78455','Joe@Joe.com','credit card','flat no. Joe, Joe, Joe, Joe, Joe - 1235',789.20,'2024-01-20 22:21:51','completed','delivered',4),(4,5,1,'Joeje@je.com','1245','joe@joe.com','cash on delivery','flat no. joe, joe, joe, joe, joe - 78',1199.99,'2024-01-20 22:32:13','completed','processing',3),(5,5,1,'Ja','1455','Ja@ja.com','credit card','flat no. Ja, Ja, Ja, Ja, Ja - 55',1199.99,'2024-01-23 20:12:27','pending','processing',1),(5,9,1,'Ja','1455','Ja@ja.com','credit card','flat no. Ja, Ja, Ja, Ja, Ja - 55',789.20,'2024-01-23 20:12:27','pending','processing',1),(6,5,1,'je','78845','je@je.com','cash on delivery','Flat no. je, je, je, je, je - 1233',1199.99,'2024-01-24 22:00:05','pending','processing',3);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `details` text DEFAULT 'N/A',
  `brand` varchar(50) NOT NULL DEFAULT 'N/A',
  `released` varchar(10) NOT NULL DEFAULT 'N/A',
  `qty` int(2) NOT NULL DEFAULT 0,
  `cpu` varchar(255) NOT NULL DEFAULT 'N/A',
  `storage` varchar(10) DEFAULT 'N/A',
  `ram` varchar(10) NOT NULL DEFAULT 'N/A',
  `camera_count` int(2) NOT NULL DEFAULT 0,
  `camera_resolution` varchar(255) NOT NULL DEFAULT 'N/A',
  `size` varchar(15) NOT NULL DEFAULT '0.0 in',
  `battery` varchar(15) NOT NULL DEFAULT '0 mAh',
  `color` varchar(50) NOT NULL DEFAULT 'N/A',
  `price` double(8,2) DEFAULT 0.00,
  `image_01` text NOT NULL,
  `image_02` text NOT NULL,
  `image_03` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_product_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (5,'Samsung Galaxy S21 Ultra Phantom Black','The Samsung Galaxy S21 Ultra is a premium flagship smartphone with cutting-edge features, a top-of-the-line camera system, and powerful hardware.','Samsung','01/29/2021',5,'Exynos 2100','512GB','16GB',4,'108MP (wide), 12MP (ultrawide), 10MP (periscope telephoto), 10MP (telephoto)','6.8 in','5000 mAh','Phantom Black',1199.99,'Samsung Galaxy S21 Ultra 1.png','Samsung Galaxy S21 Ultra 2.png','Samsung Galaxy S21 Ultra 3.png'),(6,'iPhone 13 Pro Max Graphite','The iPhone 13 Pro Max is the latest flagship smartphone from Apple, featuring a powerful A15 Bionic chip, exceptional camera capabilities, and a stunning Super Retina XDR display.','Apple','09/14/2021',10,'A15 Bionic','1TB','8GB',3,'12MP (wide), 12MP (ultrawide), 12MP (telephoto)','6.7 in','4352 mAh','Graphite',2349.99,'iphone 13 pro max graphyte 1.png','iphone 13 pro max graphyte 2.png','iphone 13 pro max graphyte 3.png'),(8,'Google Pixel 5 Just Black','Experience the cutting-edge technology of the Google Pixel 5, a flagship smartphone that combines sleek design with powerful features. The device is equipped with an advanced processor ensuring smooth and efficient performance for all your tasks and applications. Capture stunning moments with the triple camera setup. The 6.0-inch display provides an immersive viewing experience. The Google Pixel 5 delivers a premium smartphone experience.','Google','01/10/2022',10,'Qualcomm Snapdragon 765G','128GB','8GB',3,'12.2 MP (main), 16 MP (ultrawide)','6.0 in','4080 mAh','Just Black',667.63,'Google Pixel 5 Just Black 1.png','Google Pixel 5 Just Black 2.png','Google Pixel 5 Just Black 3.png'),(9,'OnePlus 9 Pro Morning Mist','Experience the power and elegance of the OnePlus 9 Pro. This flagship smartphone features a sleek design and cutting-edge technology. With a powerful Qualcomm Snapdragon 888 processor, 256GB of storage, and 12GB of RAM, the OnePlus 9 Pro delivers exceptional performance. The triple camera system includes a 48MP wide lens, a 50MP ultrawide lens, and an 8MP telephoto lens, providing versatility in capturing stunning moments. The 6.7-inch Fluid AMOLED display offers a vibrant and immersive viewing experience. A robust 4500mAh battery ensures long-lasting usage, and the device is available in the stylish &#039;Morning Mist&#039; color.','OnePlus','01/04/2023',7,'Qualcomm Snapdragon 888','256GB','12GB',3,'48MP (wide), 50MP (ultrawide), 8MP (telephoto)','6.7 in','4500 mAh','Morning Mist',899.99,'OnePlus 9 Pro Morning Mist 1.png','OnePlus 9 Pro Morning Mist 2.png','OnePlus 9 Pro Morning Mist 3.png'),(11,'Samsung Galaxy S23 Phantom Black','Discover the future of mobile technology with the Samsung Galaxy S23. This cutting-edge smartphone seamlessly combines futuristic design with advanced features. Powered by the latest Exynos 9000 (or Snapdragon 9XXX, depending on the region) processor, the Galaxy S23 delivers unparalleled performance. With a spacious 256GB of storage and a massive 12GB of RAM, this device ensures seamless multitasking and storage for all your needs. The innovative quad-camera system features a 108MP main lens, a 48MP ultrawide lens, a 8MP periscope telephoto lens, and a 5MP depth sensor, offering unparalleled photography capabilities. Immerse yourself in a stunning 6.5-inch Dynamic AMOLED display that brings colors to life. The robust 5000mAh battery ensures extended usage, and the phone is available in the sophisticated &#039;Celestial Blue&#039; color.','Samsung','15/03/2023',7,'Snapdragon 8 Gen 2','256GB','8GB',3,'12 MP (ultrawide), 50 MP (wide), 10 MP (telephoto)','6.1 in','3900 mAh','Phantom Black',1440.00,'s galaxy s23 pblack 1.png','s galaxy s23 pblack 2.png','s galaxy s23 pblack 3.png'),(15,'Samsung Galaxy S24 Ultra Titanium Violet','The Samsung Galaxy S24 Ultra Titanium Violet is a cutting-edge flagship smartphone that seamlessly blends stunning design with powerful features. Encased in a sleek titanium violet finish, the device exudes sophistication and style. Its vibrant and expansive display offers a mesmerizing visual experience, while the advanced camera system ensures exceptional photo and video capabilities. Packed with high-performance hardware and innovative technologies, the Galaxy S24 Ultra Titanium Violet is a symbol of Samsung&#039;s commitment to delivering a premium mobile experience.','Samsung','31/01/2024',3,'Qualcomm Snapdragon 8 Gen 3','1TB','12GB',4,'12 MP (ultra-wide), 10 MP (telephoto), 200 MP (wide), 50 MP (periscope telephoto)','6.8 in','5000 mAh','Titanium Violet',2999.99,'sgalaxy s24 ultra titanium violet 1.png','sgalaxy s24 ultra titanium violet 2.png','sgalaxy s24 ultra titanium violet 3.png'),(16,'Xiaomi 11T Celestial Blue','The Xiaomi 11T Celestial Blue, now available at a 20% discount, continues to captivate with its elegant design and celestial-inspired color palette. The deep blues of its finish create a sophisticated appearance, now more accessible in price. This flagship device boasts a high-performance camera system and cutting-edge technology, delivering an immersive user experience. With its celestial blue hue and advanced features, the Xiaomi 11T Celestial Blue stands out as a symbol of style and innovation, offering affordability without compromising on quality.','Xiaomi','05/10/2021',5,'Media Tek Dimensity 1200-Ultra','128GB','8GB',3,'8 MP (ultrawide), 108 MP (wide), 5 MP (telephoto)','6.67 in','5000 mAh','Celestial Blue',644.99,'xiaomi 11t celestial blue 1.png','xiaomi 11t celestial blue 2.png','xiaomi 11t celestial blue 3.png');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(15) NOT NULL,
  `brand` varchar(50) NOT NULL DEFAULT 'N/A',
  `description` text NOT NULL,
  `isResolved` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (4,1,'2024-01-21','Joe','Joe@joe.com','78556632','Samsung','Dept',0),(5,1,'2024-01-21','Ivan','mrfrozensmile@gmail.com','232577','Xiaomi','Tupa kompaniq',0);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `isAdmin` int(1) NOT NULL DEFAULT 0,
  `avatar` text NOT NULL DEFAULT 'default.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'user','user@user.com','12dea96fec20593566ab75692c9949596833adc9',0,'ichigo.png'),(2,'admin','admin@admin.com','d033e22ae348aeb5660fc2140aec35850c4da997',1,'logedin.png'),(22,'Owner','owner@owner.com','579233b2c479241523cba5e3af55d0f50f2d6414',1,'logedin.png'),(34,'Jewel Shahi','joe@gmail.com','16a9a54ddf4259952e3c118c763138e83693d7fd',0,'ichigo.png'),(36,'test','test@test.com','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',0,'logedin.png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlist` (
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  PRIMARY KEY (`user_id`,`pid`),
  KEY `fk_wishlist_product` (`pid`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
INSERT INTO `wishlist` VALUES (1,6,'iPhone 13 Pro Max',2350),(1,8,'Google Pixel 5',668),(36,9,'OnePlus 9 Pro Morning Mist',900);
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

-- Dump completed on 2024-01-25 20:52:03
