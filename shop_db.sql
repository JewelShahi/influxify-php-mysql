-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2024 at 12:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

CREATE DATABASE shop_db;

USE shop_db;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `pid`, `name`, `price`, `quantity`) VALUES
(1, 8, 'Google Pixel 5 Just Black', 667.63, 2),
(1, 17, 'Realme C31 Dark Green', 190.62, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `delivery` varchar(5) NOT NULL DEFAULT 'no',
  `delivery_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `address` text NOT NULL,
  `price` double(8,2) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `order_status` varchar(20) NOT NULL DEFAULT 'processing',
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `pid`, `user_id`, `name`, `number`, `email`, `method`, `delivery`, `delivery_cost`, `address`, `price`, `placed_on`, `payment_status`, `order_status`, `qty`) VALUES
(1, 6, 1, 'Joe', '78455', 'Joe@Joe.com', 'credit card', '', 0.00, 'flat no. Joe, Joe, Joe, Joe, Joe - 1235', 2349.99, '2024-01-20 22:21:51', 'completed', 'delivered', 1),
(1, 8, 1, 'Joe', '78455', 'Joe@Joe.com', 'credit card', '', 0.00, 'flat no. Joe, Joe, Joe, Joe, Joe - 1235', 456.00, '2024-01-20 22:21:51', 'completed', 'delivered', 1),
(1, 9, 1, 'Joe', '78455', 'Joe@Joe.com', 'credit card', '', 0.00, 'flat no. Joe, Joe, Joe, Joe, Joe - 1235', 789.20, '2024-01-20 22:21:51', 'completed', 'delivered', 4),
(2, 5, 1, 'Joeje@je.com', '1245', 'joe@joe.com', 'cash on delivery', '', 0.00, 'flat no. joe, joe, joe, joe, joe - 78', 1199.99, '2024-01-20 22:32:13', 'completed', 'processing', 3),
(3, 5, 1, 'Ja', '1455', 'Ja@ja.com', 'credit card', '', 0.00, 'flat no. Ja, Ja, Ja, Ja, Ja - 55', 1199.99, '2024-01-23 20:12:27', 'pending', 'processing', 1),
(3, 9, 1, 'Ja', '1455', 'Ja@ja.com', 'credit card', '', 0.00, 'flat no. Ja, Ja, Ja, Ja, Ja - 55', 789.20, '2024-01-23 20:12:27', 'pending', 'processing', 1),
(4, 5, 1, 'je', '78845', 'je@je.com', 'cash on delivery', '', 0.00, 'Flat no. je, je, je, je, je - 1233', 1199.99, '2024-01-24 22:00:05', 'pending', 'processing', 3),
(5, 18, 1, 'mkl', '0877888888', 'mk@mk.com', 'credit card', 'no', 0.00, '', 157.99, '2024-02-12 00:39:17', 'pending', 'processing', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL DEFAULT '\'N/A\'',
  `brand` varchar(50) NOT NULL DEFAULT 'N/A',
  `released` varchar(10) NOT NULL DEFAULT 'N/A',
  `qty` int(2) NOT NULL DEFAULT 0,
  `cpu` varchar(255) NOT NULL DEFAULT 'N/A',
  `storage` varchar(10) NOT NULL DEFAULT 'N/A',
  `ram` varchar(10) NOT NULL DEFAULT 'N/A',
  `camera_count` int(2) NOT NULL DEFAULT 0,
  `camera_resolution` varchar(255) NOT NULL DEFAULT 'N/A',
  `size` varchar(15) NOT NULL DEFAULT '0.0 in',
  `battery` varchar(15) NOT NULL DEFAULT '0 mAh',
  `color` varchar(50) NOT NULL DEFAULT 'N/A',
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `image_01` text NOT NULL,
  `image_02` text NOT NULL,
  `image_03` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `brand`, `released`, `qty`, `cpu`, `storage`, `ram`, `camera_count`, `camera_resolution`, `size`, `battery`, `color`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(5, 'Samsung Galaxy S21 Ultra Phantom Black', 'The Samsung Galaxy S21 Ultra is a premium flagship smartphone with cutting-edge features, a top-of-the-line camera system, and powerful hardware.', 'Samsung', '2021-01-29', 5, 'Exynos 2100', '512GB', '16GB', 4, '108MP (wide), 12MP (ultrawide), 10MP (periscope telephoto), 10MP (telephoto)', '6.8 in', '5000 mAh', 'Phantom Black', 1199.99, 'Samsung Galaxy S21 Ultra 1.png', 'Samsung Galaxy S21 Ultra 2.png', 'Samsung Galaxy S21 Ultra 3.png'),
(6, 'iPhone 13 Pro Max Graphite', 'The iPhone 13 Pro Max is the latest flagship smartphone from Apple, featuring a powerful A15 Bionic chip, exceptional camera capabilities, and a stunning Super Retina XDR display.', 'Apple', '2021-09-14', 11, 'A15 Bionic', '1TB', '8GB', 3, '12MP (wide), 12MP (ultrawide), 12MP (telephoto)', '6.7 in', '4352 mAh', 'Graphite', 2349.99, 'iphone 13 pro max graphyte 1.png', 'iphone 13 pro max graphyte 2.png', 'iphone 13 pro max graphyte 3.png'),
(8, 'Google Pixel 5 Just Black', 'Experience the cutting-edge technology of the Google Pixel 5, a flagship smartphone that combines sleek design with powerful features. The device is equipped with an advanced processor ensuring smooth and efficient performance for all your tasks and applications. Capture stunning moments with the triple camera setup. The 6.0-inch display provides an immersive viewing experience. The Google Pixel 5 delivers a premium smartphone experience.', 'Google', '2022-10-01', 5, 'Qualcomm Snapdragon 765G', '128GB', '8GB', 3, '12.2 MP (main), 16 MP (ultrawide)', '6.0 in', '4080 mAh', 'Just Black', 667.63, 'Google Pixel 5 Just Black 1.png', 'Google Pixel 5 Just Black 2.png', 'Google Pixel 5 Just Black 3.png'),
(9, 'OnePlus 9 Pro Morning Mist', 'Experience the power and elegance of the OnePlus 9 Pro. This flagship smartphone features a sleek design and cutting-edge technology. With a powerful Qualcomm Snapdragon 888 processor, 256GB of storage, and 12GB of RAM, the OnePlus 9 Pro delivers exceptional performance. The triple camera system includes a 48MP wide lens, a 50MP ultrawide lens, and an 8MP telephoto lens, providing versatility in capturing stunning moments. The 6.7-inch Fluid AMOLED display offers a vibrant and immersive viewing experience. A robust 4500mAh battery ensures long-lasting usage, and the device is available in the stylish &#039;Morning Mist&#039; color.', 'OnePlus', '2023-04-01', 7, 'Qualcomm Snapdragon 888', '256GB', '12GB', 3, '48MP (wide), 50MP (ultrawide), 8MP (telephoto)', '6.7 in', '4500 mAh', 'Morning Mist', 899.99, 'OnePlus 9 Pro Morning Mist 1.png', 'OnePlus 9 Pro Morning Mist 2.png', 'OnePlus 9 Pro Morning Mist 3.png'),
(11, 'Samsung Galaxy S23 Phantom Black', 'Discover the future of mobile technology with the Samsung Galaxy S23. This cutting-edge smartphone seamlessly combines futuristic design with advanced features. Powered by the latest Exynos 9000 (or Snapdragon 9XXX, depending on the region) processor, the Galaxy S23 delivers unparalleled performance. With a spacious 256GB of storage and a massive 12GB of RAM, this device ensures seamless multitasking and storage for all your needs. The innovative quad-camera system features a 108MP main lens, a 48MP ultrawide lens, a 8MP periscope telephoto lens, and a 5MP depth sensor, offering unparalleled photography capabilities. Immerse yourself in a stunning 6.5-inch Dynamic AMOLED display that brings colors to life. The robust 5000mAh battery ensures extended usage, and the phone is available in the sophisticated &#039;Celestial Blue&#039; color.', 'Samsung', '2023-03-15', 6, 'Snapdragon 8 Gen 2', '256GB', '8GB', 3, '12 MP (ultrawide), 50 MP (wide), 10 MP (telephoto)', '6.1 in', '3900 mAh', 'Phantom Black', 1440.00, 's galaxy s23 pblack 1.png', 's galaxy s23 pblack 2.png', 's galaxy s23 pblack 3.png'),
(15, 'Samsung Galaxy S24 Ultra Titanium Violet', 'The Samsung Galaxy S24 Ultra Titanium Violet is a cutting-edge flagship smartphone that seamlessly blends stunning design with powerful features. Encased in a sleek titanium violet finish, the device exudes sophistication and style. Its vibrant and expansive display offers a mesmerizing visual experience, while the advanced camera system ensures exceptional photo and video capabilities. Packed with high-performance hardware and innovative technologies, the Galaxy S24 Ultra Titanium Violet is a symbol of Samsung&#039;s commitment to delivering a premium mobile experience.', 'Samsung', '2024-01-31', 3, 'Qualcomm Snapdragon 8 Gen 3', '1TB', '12GB', 4, '12 MP (ultra-wide), 10 MP (telephoto), 200 MP (wide), 50 MP (periscope telephoto)', '6.8 in', '5000 mAh', 'Titanium Violet', 2999.99, 'sgalaxy s24 ultra titanium violet 1.png', 'sgalaxy s24 ultra titanium violet 2.png', 'sgalaxy s24 ultra titanium violet 3.png'),
(16, 'Xiaomi 11T Celestial Blue', 'The Xiaomi 11T Celestial Blue, now available at a 20% discount, continues to captivate with its elegant design and celestial-inspired color palette. The deep blues of its finish create a sophisticated appearance, now more accessible in price. This flagship device boasts a high-performance camera system and cutting-edge technology, delivering an immersive user experience. With its celestial blue hue and advanced features, the Xiaomi 11T Celestial Blue stands out as a symbol of style and innovation, offering affordability without compromising on quality.', 'Xiaomi', '2021-10-05', 4, 'Media Tek Dimensity 1200-Ultra', '128GB', '8GB', 3, '8 MP (ultrawide), 108 MP (wide), 5 MP (telephoto)', '6.67 in', '5000 mAh', 'Celestial Blue', 644.99, 'xiaomi 11t celestial blue 1.png', 'xiaomi 11t celestial blue 2.png', 'xiaomi 11t celestial blue 3.png'),
(17, 'Realme C31 Dark Green', 'The Realme C31, a budget-friendly smartphone, features a 6.5-inch HD+ display for an immersive visual experience. Its robust processor and ample RAM ensure smooth multitasking, complemented by a long-lasting battery. The versatile camera setup, guided by AI-driven intelligence, captures moments with precision. Ample internal storage and expandable options cater to growing digital needs, and Realme UI enhances user experience. With comprehensive connectivity and advanced security features, the Realme C31 offers affordability without compromise.', 'Realme', '2022-01-31', 9, 'Unisoc Tiger T612', '64GB', '4GB', 3, '2 MP (macro), 13 MP (wide), 0.3 MP (depth)', '6.5 in', '5000 mAh', 'Dark Green', 190.62, 'realmeC31 dark green 1.png', 'realmeC31 dark green 2.png', 'realmeC31 dark green 3.png'),
(18, 'Motorola Moto e13 Autora Green', 'The Motorola Moto e13 Autora Green is a budget-friendly smartphone with a sleek design and vibrant green color. Featuring a responsive processor, reliable camera system, and optimized battery life, it offers a practical and user-friendly experience. Balancing affordability and functionality, the Moto e13 is a compelling option for those seeking a reliable and stylish smartphone.', 'Motorola', '2023-02-13', 2, 'Unisoc T606', '64GB', '2GB', 1, '13 MP Wide', '6.5 in', '5000 mAh', 'Autora Green', 157.99, 'motorola moto e13 autora green 1.png', 'motorola moto e13 autora green 2.png', 'motorola moto e13 autora green 3.png'),
(19, 'Oppo A12 Blue', 'The Oppo A12 Blue is a sleek and affordable smartphone that combines style with practical features. Its eye-catching blue design adds a touch of elegance to the device. With a vibrant display, dual-camera system, and a reliable processor, the Oppo A12 Blue is equipped to capture and enjoy moments seamlessly. This budget-friendly smartphone strikes a balance between aesthetics and functionality, making it an appealing choice for users seeking an affordable and stylish mobile experience.', 'Oppo', '2020-04-20', 0, 'MediaTek Helio P35 MT6765', '32GB', '2GB', 2, '13 MP (standard), 2 MP (depth)', '6.7 in', '4230 mAh', 'blue', 279.99, 'oppo a12 1.png', 'oppo a12 2.png', 'oppo a12 3.png');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(15) NOT NULL,
  `brand` varchar(50) NOT NULL DEFAULT 'N/A',
  `description` text NOT NULL,
  `is_resolved` int(1) NOT NULL DEFAULT 0,
  `payment_method` varchar(20) DEFAULT NULL,
  `payment_status` varchar(15) NOT NULL DEFAULT 'pending',
  `delivery` varchar(5) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `address` text NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `user_id`, `placed_on`, `name`, `email`, `number`, `brand`, `description`, `is_resolved`, `payment_method`, `payment_status`, `delivery`, `price`, `address`) VALUES
(1, 1, '2024-01-21 08:42:15', 'Joe', 'Joe@joe.com', '78556632', 'Samsung', 'Dept', 0, NULL, 'pending', NULL, 43.53, '-'),
(2, 1, '2024-01-27 09:03:48', 'Jewel Shahi', 'jewel@gmail.com', '0879456200', 'Samsung', 'The primary concern is that the phone screen appears to be cracked, and there is a noticeable lack of responsiveness. I first noticed the problem on [mention the date or approximate time]. There wasnt any specific incident that I can recall, but the screens behavior changed suddenly. Upon closer inspection, I observed several cracks on the screens surface. Its worth noting that these cracks seem to be affecting the overall functionality of the touchscreen. There havent been any recent software updates or changes in settings that I am aware of. The phone has been operating normally until the issue with the screen emerged.', 1, 'cash on delivery', 'completed', 'no', 28.00, '- '),
(3, 1, '2024-02-12 13:21:26', 'Jewel Shahi', 'jewel@jewel.com', '0877323151', 'Apple', 'Not good', 0, 'cash on delivery', 'pending', 'yes', 22.35, 'Flat no. amber, amber, amber, amber, Bulgaria - 12336');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` text NOT NULL DEFAULT 'default.png',
  `reg_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `isAdmin`, `avatar`, `reg_date`) VALUES
(1, 'User', 'user@user.com', '12dea96fec20593566ab75692c9949596833adc9', 0, 'ulquiorra-cifer.png', '2023-12-15'),
(2, 'Admin', 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'mob.png', '2023-12-15'),
(3, 'TesterAdmin', 'testadmin@test.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 1, 'logedin.png', '2024-01-05'),
(4, 'work', 'work@work.com', '4224b2ba1666666bae8616d1bb961c0e81f31666', 1, 'logedin.png', '2024-01-10'),
(5, 'Jinwoo', 'jinwoo@jinwoo.com', 'b22e8a079a000cca38de961a1e5316f0494f7356', 1, 'sung-jin-woo.png', '2024-03-03'),
(6, 'UserTest+10', 'usertest@gmail.com', '31f10d65cae2c4d8e9dd6e5f842c40ef10263f27', 0, 'logedin.png', '2024-03-03'),
(7, 'New User', 'newser@new.com', 'b406f877e90994474d3a2d3e275dbf92467eefd7', 1, 'logedin.png', '2024-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`user_id`, `pid`, `name`, `price`) VALUES
(1, 19, 'Oppo A12 Blue', 280);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`pid`),
  ADD KEY `fk_cart_product` (`pid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`,`user_id`,`pid`),
  ADD KEY `fk_orders_product` (`pid`),
  ADD KEY `fk_orders_user` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_product_name` (`name`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`user_id`,`pid`),
  ADD KEY `fk_wishlist_product` (`pid`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_product` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
