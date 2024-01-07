-- Creating the database

CREATE DATABASE shop_db;


-- Using the database

USE shop_db;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2024 at 09:15 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--
-- --------------------------------------------------------
--
-- Table structure for table `cart`
--

CREATE TABLE
  `cart` (
    `id` int (100) NOT NULL,
    `user_id` int (100) NOT NULL,
    `pid` int (100) NOT NULL,
    `name` varchar(100) NOT NULL,
    `price` double (8, 2) NOT NULL DEFAULT 0.00,
    `quantity` int (10) NOT NULL,
    `image` text NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `messages`
--
CREATE TABLE
  `messages` (
    `id` int (100) NOT NULL,
    `user_id` int (100) NOT NULL,
    `name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `number` char(10) NOT NULL,
    `message` text NOT NULL,
    `isResolved` int (1) NOT NULL DEFAULT 0
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `orders`
--
CREATE TABLE
  `orders` (
    `id` int (100) NOT NULL,
    `user_id` int (100) NOT NULL,
    `name` varchar(20) NOT NULL,
    `number` varchar(10) NOT NULL,
    `email` varchar(50) NOT NULL,
    `method` varchar(50) NOT NULL,
    `address` text NOT NULL,
    `total_products` varchar(1000) NOT NULL,
    `total_price` double (8, 2) NOT NULL,
    `placed_on` date NOT NULL DEFAULT current_timestamp(),
    `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `products`
--
CREATE TABLE
  `products` (
    `id` int (100) NOT NULL,
    `name` varchar(100) NOT NULL,
    `details` varchar(255) DEFAULT NULL,
    `price` double (8, 2) DEFAULT NULL,
    `image_01` text NOT NULL,
    `image_02` text NOT NULL,
    `image_03` text NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `products`
--
INSERT INTO
  `products` (
    `id`,
    `name`,
    `details`,
    `price`,
    `image_01`,
    `image_02`,
    `image_03`
  )
VALUES
  (
    2,
    'Anime',
    'Anime avatars',
    420.00,
    'aichigo.jpg',
    'gojo colorfull.jpg',
    'dabi.png'
  );

-- --------------------------------------------------------
--
-- Table structure for table `users`
--
CREATE TABLE
  `users` (
    `id` int (100) NOT NULL,
    `name` varchar(20) NOT NULL,
    `email` varchar(50) NOT NULL,
    `password` varchar(50) NOT NULL,
    `isAdmin` int (1) NOT NULL DEFAULT 0
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `users`
--
INSERT INTO
  `users` (`id`, `name`, `email`, `password`, `isAdmin`)
VALUES
  (
    1,
    'user',
    'user@user.com',
    '12dea96fec20593566ab75692c9949596833adc9',
    0
  ),
  (
    2,
    'admin',
    'admin@admin.com',
    'd033e22ae348aeb5660fc2140aec35850c4da997',
    1
  ),
  (
    3,
    'jewel',
    'jewelshahi10@gmail.com',
    '16a9a54ddf4259952e3c118c763138e83693d7fd',
    0
  ),
  (
    4,
    'teacher',
    'teach@teach.com',
    '4a82cb6db537ef6c5b53d144854e146de79502e8',
    1
  ),
  (
    5,
    'ivak',
    'ivakdivak@gmail.com',
    '2ec651a46f1dba00db964e75dd11f13e23c14d33',
    0
  ),
  (
    6,
    'JewelAlt',
    'joeimportant1020@gmail.com',
    '60e33fbecb7eabe84629b1f4020662c3e3763112',
    0
  ),
  (
    7,
    'test',
    'joeimportant1020@gmail.com',
    '7c4a8d09ca3762af61e59520943dc26494f8941b',
    0
  );

-- --------------------------------------------------------
--
-- Table structure for table `wishlist`
--
CREATE TABLE
  `wishlist` (
    `id` int (100) NOT NULL,
    `user_id` int (100) NOT NULL,
    `pid` int (100) NOT NULL,
    `name` varchar(100) NOT NULL,
    `price` int (100) NOT NULL,
    `image` varchar(100) NOT NULL
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Indexes for dumped tables
--
--
-- Indexes for table `cart`
--
ALTER TABLE `cart` ADD PRIMARY KEY (`id`),
ADD KEY `fk_cart_user_id` (`user_id`),
ADD KEY `fk_cart_pid` (`pid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages` ADD PRIMARY KEY (`id`),
ADD KEY `fk_messages_user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders` ADD PRIMARY KEY (`id`),
ADD KEY `fk_orders_user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist` ADD PRIMARY KEY (`id`),
ADD KEY `fk_wishlist_user_id` (`user_id`),
ADD KEY `fk_wishlist_pid` (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart` MODIFY `id` int (100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages` MODIFY `id` int (100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders` MODIFY `id` int (100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products` MODIFY `id` int (100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users` MODIFY `id` int (100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist` MODIFY `id` int (100) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 2;

--
-- Constraints for dumped tables
--
--
-- Constraints for table `cart`
--
ALTER TABLE `cart` ADD CONSTRAINT `fk_cart_pid` FOREIGN KEY (`pid`) REFERENCES `products` (`id`),
ADD CONSTRAINT `fk_cart_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages` ADD CONSTRAINT `fk_messages_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders` ADD CONSTRAINT `fk_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist` ADD CONSTRAINT `fk_wishlist_pid` FOREIGN KEY (`pid`) REFERENCES `products` (`id`),
ADD CONSTRAINT `fk_wishlist_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
