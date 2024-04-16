-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 11:03 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `pid`, `name`, `price`, `quantity`) VALUES
(1, 15, 'Samsung Galaxy S24 Ultra Titanium Violet', 2999.99, 1),
(1, 36, 'Realme GT NEO 3T Dragon Ball Z Blue', 1002.03, 1),
(8, 5, 'Samsung Galaxy S21 Ultra Phantom Black', 1199.99, 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `delivery` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `delivery_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `price` double(8,2) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `order_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'processing',
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `pid`, `user_id`, `name`, `number`, `email`, `method`, `delivery`, `delivery_cost`, `address`, `price`, `placed_on`, `payment_status`, `order_status`, `qty`) VALUES
(1, 6, 1, 'Jewel', '087654321', 'jewel@gmail.com', 'credit card', 'no', 0.00, '-', 2349.99, '2024-01-20 22:21:51', 'completed', 'delivered', 1),
(1, 8, 1, 'Jewel', '0876902143', 'joe@joe.com', 'credit card', 'no', 0.00, '-', 456.00, '2024-01-20 22:21:51', 'completed', 'delivered', 1),
(1, 9, 1, 'Joe', '0887462351', 'jewel@gmail.com', 'credit card', 'no', 0.00, '-', 789.20, '2024-01-20 22:21:51', 'completed', 'delivered', 4),
(2, 5, 1, 'Jewel', '0873251694', 'jewel@gmail.com', 'cash on delivery', 'no', 0.00, '-', 1199.99, '2024-01-20 22:32:13', 'completed', 'processing', 3),
(3, 5, 1, 'Jewel', '0898127346', 'joeimportant1020@gmail.com', 'credit card', 'no', 0.00, '-', 1199.99, '2024-01-23 20:12:27', 'pending', 'processing', 1),
(3, 9, 1, 'Jewel', '0895743261', 'joe@joe.com', 'credit card', 'no', 0.00, '-', 789.20, '2024-01-23 20:12:27', 'pending', 'processing', 1),
(4, 5, 1, 'Jewel', '0884519732', 'joeimportant1020@gmail.com', 'cash on delivery', 'no', 0.00, '-', 1199.99, '2024-01-24 22:00:05', 'pending', 'processing', 3),
(5, 18, 1, 'Jewel', '0877888888', 'joeimportant1020@gmail.com', 'credit card', 'no', 0.00, '-', 157.99, '2024-02-12 00:39:17', 'pending', 'processing', 1),
(6, 17, 1, 'Joe', '0877526354', 'joe@joe.com', 'cash on delivery', 'yes', 9.99, 'Flat №: 75, Street: Wall, City: Junio, State: Selio, Country: Korea, Post code: 47856', 190.62, '2024-04-05 00:20:32', 'pending', 'processing', 1),
(7, 18, 1, 'Joe', '0877353750', 'theprogamer1020@gmail.com', 'credit card', 'yes', 9.99, 'Flat №: 56, Street: Yellow, City: Minato, State: Kon Ban, Country: Japan, Post code: 75623', 158.00, '2024-04-10 09:19:38', 'pending', 'processing', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `brand` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `released` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `qty` int(2) NOT NULL DEFAULT 0,
  `cpu` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `storage` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `ram` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `camera_count` int(2) NOT NULL DEFAULT 0,
  `camera_resolution` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `size` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0 in',
  `battery` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0 mAh',
  `color` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `price` double(8,2) NOT NULL DEFAULT 0.00,
  `image_01` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image_02` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image_03` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `brand`, `released`, `qty`, `cpu`, `storage`, `ram`, `camera_count`, `camera_resolution`, `size`, `battery`, `color`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(5, 'Samsung Galaxy S21 Ultra Phantom Black', 'The Samsung Galaxy S21 Ultra is a premium flagship smartphone with cutting-edge features, a top-of-the-line camera system, and powerful hardware.', 'Samsung', '2021-01-29', 2, 'Exynos 2100', '512GB', '16GB', 4, '108MP (wide), 12MP (ultrawide), 10MP (periscope telephoto), 10MP (telephoto)', '6.8 in', '5000 mAh', 'Phantom Black', 1199.99, 'Samsung Galaxy S21 Ultra 1.png', 'Samsung Galaxy S21 Ultra 2.png', 'Samsung Galaxy S21 Ultra 3.png'),
(6, 'iPhone 13 Pro Max Graphite', 'The iPhone 13 Pro Max is the latest flagship smartphone from Apple, featuring a powerful A15 Bionic chip, exceptional camera capabilities, and a stunning Super Retina XDR display.', 'Apple', '2021-09-14', 11, 'A15 Bionic', '1TB', '8GB', 3, '12MP (wide), 12MP (ultrawide), 12MP (telephoto)', '6.7 in', '4352 mAh', 'Graphite', 2349.99, 'iphone 13 pro max graphyte 1.png', 'iphone 13 pro max graphyte 2.png', 'iphone 13 pro max graphyte 3.png'),
(8, 'Google Pixel 5 Just Black', 'Experience the cutting-edge technology of the Google Pixel 5, a flagship smartphone that combines sleek design with powerful features. The device is equipped with an advanced processor ensuring smooth and efficient performance for all your tasks and applications. Capture stunning moments with the triple camera setup. The 6.0-inch display provides an immersive viewing experience. The Google Pixel 5 delivers a premium smartphone experience.', 'Google', '2022-10-01', 7, 'Qualcomm Snapdragon 765G', '128GB', '8GB', 3, '12.2 MP (main), 16 MP (ultrawide)', '6.0 in', '4080 mAh', 'Just Black', 667.63, 'Google Pixel 5 Just Black 1.png', 'Google Pixel 5 Just Black 2.png', 'Google Pixel 5 Just Black 3.png'),
(9, 'OnePlus 9 Pro Morning Mist', 'Experience the power and elegance of the OnePlus 9 Pro. This flagship smartphone features a sleek design and cutting-edge technology. With a powerful Qualcomm Snapdragon 888 processor, 256GB of storage, and 12GB of RAM, the OnePlus 9 Pro delivers exceptional performance. The triple camera system includes a 48MP wide lens, a 50MP ultrawide lens, and an 8MP telephoto lens, providing versatility in capturing stunning moments. The 6.7-inch Fluid AMOLED display offers a vibrant and immersive viewing experience. A robust 4500mAh battery ensures long-lasting usage, and the device is available in the stylish &#039;Morning Mist&#039; color.', 'OnePlus', '2023-04-01', 7, 'Qualcomm Snapdragon 888', '256GB', '12GB', 3, '48MP (wide), 50MP (ultrawide), 8MP (telephoto)', '6.7 in', '4500 mAh', 'Morning Mist', 899.99, 'OnePlus 9 Pro Morning Mist 1.png', 'OnePlus 9 Pro Morning Mist 2.png', 'OnePlus 9 Pro Morning Mist 3.png'),
(11, 'Samsung Galaxy S23 Phantom Black', 'Discover the future of mobile technology with the Samsung Galaxy S23. This cutting-edge smartphone seamlessly combines futuristic design with advanced features. Powered by the latest Exynos 9000 (or Snapdragon 9XXX, depending on the region) processor, the Galaxy S23 delivers unparalleled performance. With a spacious 256GB of storage and a massive 12GB of RAM, this device ensures seamless multitasking and storage for all your needs. The innovative quad-camera system features a 108MP main lens, a 48MP ultrawide lens, a 8MP periscope telephoto lens, and a 5MP depth sensor, offering unparalleled photography capabilities. Immerse yourself in a stunning 6.5-inch Dynamic AMOLED display that brings colors to life. The robust 5000mAh battery ensures extended usage, and the phone is available in the sophisticated &#039;Celestial Blue&#039; color.', 'Samsung', '2023-03-15', 6, 'Snapdragon 8 Gen 2', '256GB', '8GB', 3, '12 MP (ultrawide), 50 MP (wide), 10 MP (telephoto)', '6.1 in', '3900 mAh', 'Phantom Black', 1440.00, 's galaxy s23 pblack 1.png', 's galaxy s23 pblack 2.png', 's galaxy s23 pblack 3.png'),
(15, 'Samsung Galaxy S24 Ultra Titanium Violet', 'The Samsung Galaxy S24 Ultra Titanium Violet is a cutting-edge flagship smartphone that seamlessly blends stunning design with powerful features. Encased in a sleek titanium violet finish, the device exudes sophistication and style. Its vibrant and expansive display offers a mesmerizing visual experience, while the advanced camera system ensures exceptional photo and video capabilities. Packed with high-performance hardware and innovative technologies, the Galaxy S24 Ultra Titanium Violet is a symbol of Samsung&#039;s commitment to delivering a premium mobile experience.', 'Samsung', '2024-01-31', 2, 'Qualcomm Snapdragon 8 Gen 3', '1TB', '12GB', 4, '12 MP (ultra-wide), 10 MP (telephoto), 200 MP (wide), 50 MP (periscope telephoto)', '6.8 in', '5000 mAh', 'Titanium Violet', 2999.99, 'sgalaxy s24 ultra titanium violet 1.png', 'sgalaxy s24 ultra titanium violet 2.png', 'sgalaxy s24 ultra titanium violet 3.png'),
(16, 'Xiaomi 11T Celestial Blue', 'The Xiaomi 11T Celestial Blue, now available at a 20% discount, continues to captivate with its elegant design and celestial-inspired color palette. The deep blues of its finish create a sophisticated appearance, now more accessible in price. This flagship device boasts a high-performance camera system and cutting-edge technology, delivering an immersive user experience. With its celestial blue hue and advanced features, the Xiaomi 11T Celestial Blue stands out as a symbol of style and innovation, offering affordability without compromising on quality.', 'Xiaomi', '2021-10-05', 4, 'Media Tek Dimensity 1200-Ultra', '128GB', '8GB', 3, '8 MP (ultrawide), 108 MP (wide), 5 MP (telephoto)', '6.67 in', '5000 mAh', 'Celestial Blue', 644.99, 'xiaomi 11t celestial blue 1.png', 'xiaomi 11t celestial blue 2.png', 'xiaomi 11t celestial blue 3.png'),
(17, 'Realme C31 Dark Green', 'The Realme C31, a budget-friendly smartphone, features a 6.5-inch HD+ display for an immersive visual experience. Its robust processor and ample RAM ensure smooth multitasking, complemented by a long-lasting battery. The versatile camera setup, guided by AI-driven intelligence, captures moments with precision. Ample internal storage and expandable options cater to growing digital needs, and Realme UI enhances user experience. With comprehensive connectivity and advanced security features, the Realme C31 offers affordability without compromise.', 'Realme', '2022-01-31', 9, 'Unisoc Tiger T612', '64GB', '4GB', 3, '2 MP (macro), 13 MP (wide), 0.3 MP (depth)', '6.5 in', '5000 mAh', 'Dark Green', 190.62, 'realmeC31 dark green 1.png', 'realmeC31 dark green 2.png', 'realmeC31 dark green 3.png'),
(18, 'Motorola Moto e13 Autora Green', 'The Motorola Moto e13 Autora Green is a budget-friendly smartphone with a sleek design and vibrant green color. Featuring a responsive processor, reliable camera system, and optimized battery life, it offers a practical and user-friendly experience. Balancing affordability and functionality, the Moto e13 is a compelling option for those seeking a reliable and stylish smartphone.', 'Motorola', '2023-02-13', 1, 'Unisoc T606', '64GB', '2GB', 1, '13 MP Wide', '6.5 in', '5000 mAh', 'Autora Green', 157.99, 'motorola moto e13 autora green 1.png', 'motorola moto e13 autora green 2.png', 'motorola moto e13 autora green 3.png'),
(19, 'Oppo A12 Blue', 'The Oppo A12 Blue is a sleek and affordable smartphone that combines style with practical features. Its eye-catching blue design adds a touch of elegance to the device. With a vibrant display, dual-camera system, and a reliable processor, the Oppo A12 Blue is equipped to capture and enjoy moments seamlessly. This budget-friendly smartphone strikes a balance between aesthetics and functionality, making it an appealing choice for users seeking an affordable and stylish mobile experience.', 'Oppo', '2020-04-20', 0, 'MediaTek Helio P35 MT6765', '32GB', '2GB', 2, '13 MP (standard), 2 MP (depth)', '6.7 in', '4230 mAh', 'blue', 279.99, 'oppo a12 1.png', 'oppo a12 2.png', 'oppo a12 3.png'),
(24, 'OnePlus Nord 3 Misty Green', 'Introducing the OnePlus Nord 3: a seamless fusion of power, style, and affordability, setting a new standard in smartphone excellence. With its standout features, including a mighty 16GB RAM and MediaTek Dimensity 9000 chipset, it effortlessly handles every task while providing ample storage with its generous 256GB capacity. Experience lightning-fast 5G connectivity for instant downloads and seamless streaming on its immersive 6.74-inch Super Fluid AMOLED display with a silky-smooth 120Hz refresh rate. Dual SIM support simplifies your digital life, while its sleek Misty Green design and slim profile make a bold statement. The OnePlus Nord 3 redefines smartphone excellence, delivering unmatched performance, style, and affordability in one exceptional package.', 'OnePlus', '2023-07-11', 7, 'MediaTek Dimensity 9000', '256GB', '16GB', 3, '2 MP (macro), 8 MP (ultrawide), 50 MP (wide)', '6.74 in', '5000 mAh', 'Misty Green', 813.37, 'oneplus_nord_3_misty_green_01.png', 'oneplus_nord_3_misty_green_02.png', 'oneplus_nord_3_misty_green_03.png'),
(25, 'OnePlus 12 Silky Black', 'Earning praise as a flagship killer again, the OnePlus 12 packs a powerful punch with the latest Snapdragon processor for seamless multitasking and gaming.  Camera lovers will rejoice at the improved low-light performance and new telephoto lens, while a large battery ensures you won&#039;t be caught dead on a low charge thanks to the phone&#039;s incredibly fast wired and wireless charging.  OnePlus stays true to its clean software roots with OxygenOS 14 on top of Android 14, offering a smooth user experience.  The unique frosted glass back adds a touch of personality and resists fingerprints, but some reviewers find the overall design a bit familiar and dislike the curved display. Despite these minor drawbacks, the OnePlus 12 remains a compelling choice with its powerful specs, long battery life, and competitive price tag.', 'OnePlus', '2024-01-23', 2, 'Qualcomm Snapdragon 8 Gen 3', '512GB', '16GB', 3, '50 MP (wide)', '6.82 in', '5400 mAh', 'Silky Black', 1920.00, 'oneplus_12_silky_black_01.png', 'oneplus_12_silky_black_02.png', 'oneplus_12_silky_black_03.png'),
(26, 'iPhone 14 Pro Max', 'The iPhone 14 Pro Max stands out as the best iPhone for those who crave a large screen experience.  It boasts a gorgeous, bright display with super smooth refresh rates and an innovative always-on feature. The camera system is king with a powerful 48-megapixel main sensor and video stabilization that makes action shots a breeze.  Powering this phone is the top-of-the-line A16 Bionic chip, ensuring everything runs smoothly.  However, this powerhouse comes at a premium price and the phone&#039;s large size might not be for everyone.', 'Apple', '2022-09-16', 3, 'A16 Bionic', '256GB', '6GB', 3, '48 MP (main), 12 MP (ultrawide), 12 MP (telephoto)', '6.7 in', '4323 mAh', 'White', 5106.37, 'iphone_14_pro_max_01.png', 'iphone_14_pro_max_02.png', 'iphone_14_pro_max_03.png'),
(27, 'Xiaomi 13T Pro Black', 'The Xiaomi 13T Pro emerges as a strong contender with a powerful MediaTek Dimensity 9200+ processor for smooth performance and excellent battery life.  It boasts a gorgeous display with a high refresh rate for a super responsive feel. Camera lovers will appreciate the high-resolution triple-lens system, although some reviewers note slightly inaccurate skin tones in photos. While the software offers some customization, it isn&#039;t the cleanest user experience. The lack of an official release date for the 16GB/1TB version means you might have to wait to get your hands on this feature-packed phone.', 'Xiaomi', '2023-09-26', 3, 'MediaTek Dimensity 9200+ CPU', '1TB', '16GB', 3, '12 MP (ultrawide), 50 MP (wide), 50 MP (telephoto)', '6.67 in', '5000 mAh', 'Black', 1678.99, 'xiaomi_13t_pro_black_01.png', 'xiaomi_13t_pro_black_02.png', 'xiaomi_13t_pro_black_03.png'),
(28, 'Google Pixel 8 Obsidian', 'The Google Pixel 8 (128GB, 8GB RAM, 5G) in Obsidian might be smaller than its Pro sibling, but it&#039;s a powerhouse in its own right. Google&#039;s Tensor G3 chip tackles daily tasks and even light gaming with ease. Despite only having one rear camera, the Pixel 8 takes incredible pictures and videos thanks to Google&#039;s software magic, offering creative freedom with features like Magic Editor. The 4,575mAh battery ensures a full day&#039;s charge, with some users even reaching two days on moderate use. The phone&#039;s compact size makes it comfortable to use one-handed, and Google guarantees software updates for 7 years, keeping your phone secure and updated. While the base storage might fill up fast for heavy users and the display refresh rate isn&#039;t the highest on the market, the Pixel 8 offers a fantastic camera, long battery life, and future-proof software at a competitive price.', 'Google', '2023-10-04', 4, 'Google Tensor G3', '128GB', '8GB', 2, '12 MP (ultrawide), 50 MP (wide)', '6.2 in', '4575 mAh', 'Obsidian', 1176.51, 'google_pixel_8_obsidian_01.png', 'google_pixel_8_obsidian_02.png', 'google_pixel_8_obsidian_03.png'),
(29, 'Motorola Edge 40 Pro Interstellar Black', 'The Motorola Edge 40 Pro is a powerful contender in the high-end market with a Snapdragon 8 Gen 2 chip, a versatile triple-camera system, and a stunning 120Hz OLED display. It boasts fast charging and long battery life, but keep in mind the lack of expandable storage and headphone jack. With 256GB of storage and 12GB of RAM, this Interstellar Black option is a solid choice for users who prioritize performance and a beautiful display.', 'Motorola', '2023-04-04', 2, 'Snapdragon 8 Gen 2', '256GB', '12GB', 3, '12 MP (telephoto), 50 MP (wide), 50 MP (ultrawide)', '6.67 in', '4600 mAh', 'Interstellar Black', 1663.93, 'motorola_edge_40_pro_interstellar_black_01.png', 'motorola_edge_40_pro_interstellar_black_02.png', 'motorola_edge_40_pro_interstellar_black_03.png'),
(30, 'Motorola razr 40 Ultra Infinite Black', 'Motorola&#039;s Razr 40 Ultra in Infinite Black combines a stylish foldable design with a large, functional cover display. The hinge feels improved, and the powerful Snapdragon 8 Gen 1 handles everyday tasks and games well. While the camera system is decent, it isn&#039;t class-leading. Battery life is impressive for a foldable, but the lack of the latest Snapdragon chip might sting at the high price point. Overall, it&#039;s a compelling option for those prioritizing a unique foldable experience with a big cover display.', 'Motorola', '2023-06-01', 4, 'Qualcomm Snapdragon 8 Plus Gen 1', '256GB', '8GB', 2, '12 MP (wide), 13 MP (ultrawide)', '6.9 in', '3800 mAh', 'Infinite Black', 1451.62, 'motorola_razr_40_ultra_infinite_black_01.png', 'motorola_razr_40_ultra_infinite_black_02.png', 'motorola_razr_40_ultra_infinite_black_03.png'),
(31, 'Oppo Find X5 Pro Glaze Black', 'The Oppo Find X5 Pro in Glaze Black is a high-end phone with a powerful Snapdragon 8 Gen 1 processor, a large 5000mAh battery with incredibly fast 80W charging, and a gorgeous 6.7 inch display.  It also boasts a top-of-the-line camera system co-developed by Hasselblad,  making it a great choice for mobile photography enthusiasts.  However, some reviewers note that the phone can be a bit heavy and  slightly slippery due to its ceramic build.  Overall, the Oppo Find X5 Pro is a feature-packed phone with a sleek design that should appeal to  Android users looking for a premium device.', 'Oppo', '2022-02-24', 11, 'Qualcomm Snapdragon 8 Gen 1', '256GB', '12GB', 3, '50 MP (wide), 32 Mpx', '6.7 in', '5000 mAh', 'Glaze Black', 2167.15, 'oppo_find_x5_pro_glaze_black_01.png', 'oppo_find_x5_pro_glaze_black_02.png', 'oppo_find_x5_pro_glaze_black_03.png'),
(32, 'Oppo A78 Mist Black', 'The Oppo A78 in Mist Black is a budget-friendly phone with a big selling point: a smooth 90Hz AMOLED display. While the cameras aren&#039;t outstanding, it packs a surprisingly powerful processor for the price tag, making it capable of handling daily tasks and some light gaming. Battery life is impressive thanks to the 5000mAh battery, but charging speeds are a bit slow. Overall, the Oppo A78 is a solid option for users looking for a large display and good performance at an affordable price, but be aware of the so-so camera and slow charging.', 'Oppo', '2023-07-10', 3, 'Qualcomm Snapdragon 680', '128GB', '8GB', 2, '2 MP (depth), 50 MP (wide), 8Mpx', '6.43 in', '5000 mAh', 'Mist Black', 360.45, 'oppo_a78_mist_black_01.png', 'oppo_a78_mist_black_02.png', 'oppo_a78_mist_black_03.png'),
(33, 'Motorola Edge 30 Meteor Gray', 'The Motorola Edge 30 in Meteor Gray is a strong mid-ranger with a beautiful 144Hz OLED display for super smooth visuals. 5G connectivity ensures fast downloads, and the powerful processor tackles most everyday tasks and even some light gaming. It boasts a capable triple-camera system, but low-light photography could be better. Battery life is decent, but charging speeds are a bit on the slow side. Overall, the Motorola Edge 30 is a good choice for users looking for a stylish phone with a great display and good performance at a competitive price.', 'Oppo', '2022-04-27', 5, 'Qualcomm Snapdragon 778G+', '256GB', '8GB', 3, '2 MP (depth), 50 MP (wide), 50 MP (macro), 32 Mpx', '6.55 in', '4020 mAh', 'Meteor Gray', 398.36, 'motorola_edge_30_meteor_gray_01.png', 'motorola_edge_30_meteor_gray_02.png', 'motorola_edge_30_meteor_gray_03.png'),
(34, 'Google Pixel 8 Pro Porcelain', 'Google&#039;s Pixel 8 Pro in Porcelain is a stellar flagship phone with a lot to offer. The 6.7-inch LTPO OLED display boasts a super smooth 120Hz refresh rate and exceptional brightness.  The Tensor G3 chip paired with 12GB of RAM delivers top-notch performance, making multitasking and gaming a breeze. The camera system is unrivaled, capturing stunning photos and videos with Google&#039;s impressive AI processing. Battery life is reliable thanks to the 5,050mAh capacity, but charging speeds could be faster. Overall, the Pixel 8 Pro is a fantastic choice for users who prioritize an amazing camera, a beautiful display, and a clean software experience.', 'Google', '2023-10-12', 4, 'Google Tensor G3', '128GB', '12GB', 3, '50 MP (wide), 48 MP (telephoto), 48 MP (ultrawide), 10.5 Mpx', '6.7 in', '5050 mAh', 'Porcelain', 1843.09, 'google_pixel_8_pro_porcelain_01.png', 'google_pixel_8_pro_porcelain_02.png', 'google_pixel_8_pro_porcelain_03.png'),
(35, 'Realme GT NEO 3 Asphalt Black', 'The Realme GT Neo 3 in Asphalt Black is a speed demon for gamers, packing the powerful MediaTek Dimensity 8100 processor with 12GB of RAM for buttery smooth performance. The 120Hz refresh rate display ensures silky-smooth visuals, while the 5G connectivity keeps you hooked up at warp speed.  Although the 50MP triple-camera system takes decent photos, low-light performance isn&#039;t stellar. The 5,000mAh battery offers good stamina, but some might wish for even faster charging. Overall, the Realme GT Neo 3 is a compelling option for gamers seeking a phone with top-notch performance, a fast display, and a long-lasting battery.', 'Realme', '2022-04-29', 2, 'MediaTek Dimensity 8100', '256GB', '12GB', 3, '2 MP (macro), 8 MP (ultrawide), 50 MP (wide), 16 Mpx', '6.7 in', '4500 mAh', 'Asphalt Black', 989.99, 'realme_gt_neo_3_asphalt_black_01.png', 'realme_gt_neo_3_asphalt_black_02.png', 'realme_gt_neo_3_asphalt_black_03.png'),
(36, 'Realme GT NEO 3T Dragon Ball Z Blue', 'The Realme GT Neo 3T Dragon Ball Z edition in Blue is a fun option for fans with a powerful side. While it boasts a slightly less hefty 8GB of RAM compared to the standard Neo 3, the Snapdragon 870 processor ensures smooth performance for everyday use and even some gaming. The 120Hz AMOLED display is a treat for watching or playing, and the 5G connectivity keeps you future-proofed.  The 64MP main camera captures decent photos, but the camera system isn&#039;t the main focus here.  This phone prioritizes performance and style for Dragon Ball Z fans, with a unique design and custom software touches.', 'Realme', '2022-06-15', 0, 'Qualcomm Snapdragon 870', '256GB', '8GB', 3, '2 MP (macro), 8 MP (ultrawide), 64 MP (ide), 16 Mpx', '6.62 in', '5000 mAh', 'Blue', 1002.03, 'realme_gt_neo_3t_dragon_ball_z_blue_01.png', 'realme_gt_neo_3t_dragon_ball_z_blue_02.png', 'realme_gt_neo_3t_dragon_ball_z_blue_03.png'),
(37, 'Samsung Galaxy S24+ Onyx Black', 'The Samsung Galaxy S24+ Onyx Black is a strong contender in the flagship phone market, offering a gorgeous 6.7-inch display, a powerful Exynos 2400 chip, and exceptional battery life thanks to its 4900 mAh cell. While the camera system is good, it doesn&#039;t quite match the best in low-light situations. Overall, the S24+ delivers a fantastic user experience with a price tag that&#039;s slightly lower than its Ultra sibling.', 'Samsung', '2024-01-31', 3, 'Exynos 2400', '512GB', '12GB', 3, '12 MP (ultrawide), 50 MP (wide), 10 MP (telephoto), 12 Mpx', '6.7 in', '4900 mAh', 'Onyx Black', 2177.12, 'samsung_galaxy_s24+_onyx_black_01.png', 'samsung_galaxy_s24+_onyx_black_02.png', 'samsung_galaxy_s24+_onyx_black_03.png');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_resolved` int(1) NOT NULL DEFAULT 0,
  `payment_method` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `delivery` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'no',
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `user_id`, `placed_on`, `name`, `email`, `number`, `brand`, `description`, `is_resolved`, `payment_method`, `payment_status`, `delivery`, `price`, `address`) VALUES
(1, 1, '2024-01-21 08:42:15', 'Jewel', 'joeimportant1020@gmail.com', '0878146923', 'Samsung', 'Dept', 0, NULL, 'pending', 'no', 43.53, '-'),
(2, 1, '2024-01-27 09:03:48', 'Joe', 'jewel@gmail.com', '0879456200', 'Samsung', 'The primary concern is that the phone screen appears to be cracked, and there is a noticeable lack of responsiveness. I first noticed the problem on [mention the date or approximate time]. There wasn\'t any specific incident that I can recall, but the screen\'s behavior changed suddenly. Upon closer inspection, I observed several cracks on the screen\'s surface. It\'s worth noting that these cracks seem to be affecting the overall functionality of the touchscreen. There haven\'t been any recent software updates or changes in settings that I am aware of. The phone has been operating normally until the issue with the screen emerged.', 1, 'cash on delivery', 'completed', 'no', 28.00, '- '),
(3, 1, '2024-02-12 13:21:26', 'Jewel Shahi', 'jewel@jewel.com', '0877323151', 'Apple', 'Not good', 0, 'cash on delivery', 'pending', 'yes', 22.35, 'Flat №: 23, Street: Amber Street, City: Sofia, State: Sofia City, Country: Bulgaria, Post code: 12336\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.png',
  `reg_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `isAdmin`, `avatar`, `reg_date`) VALUES
(1, 'User', 'user@user.com', '12dea96fec20593566ab75692c9949596833adc9', 0, 'ichigo-kurosaki.png', '2023-12-15'),
(2, 'Admin', 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'satoru-gojo-blue.png', '2023-12-15'),
(3, 'TesterAdmin', 'testadmin1050@test.com', '1dcb5a3bdfad6ac42dd8f778322ae5e60b586172', 1, 'ulquiorra-cifer.png', '2024-01-05'),
(4, 'work', 'worker1020@work.com', 'b7830571013e3220b480d3015812eeb0a92657ba', 0, 'ichigo-kurosaki-anime.png', '2024-01-10'),
(5, 'Jinwoo', 'jinwoo@jinwoo.com', '43badabd40651b7b4e4e097e80af33ad2dd807aa', 1, 'sung-jinwoo.png', '2024-03-03'),
(6, 'UserTest+10', 'usertest@gmail.com', '79dbd1fa6563c5ae0f5e6a7df6dcc1ee5c02e281', 0, 'shigeo-kageyama.png', '2024-03-03'),
(7, 'New User', 'newser@new.com', 'b406f877e90994474d3a2d3e275dbf92467eefd7', 0, 'katsuki-bakugo.png', '2024-03-04'),
(8, 'vladi', 'ok@gmail.com', '92c8b10157e05856af182a643de7dcea14472f74', 0, 'ryomen-sukuna.png', '2024-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
