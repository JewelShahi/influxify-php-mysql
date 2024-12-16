-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 11:07 PM
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
-- Database: `shop-bg`
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
(6, 17, 1, 'Joe', '0877526354', 'joe@joe.com', 'cash on delivery', 'yes', 9.99, 'Блок №: 75, Улица: Wall, Град: Junio, Квартал: Selio, Държава: Korea, Пощенски код: 47856', 190.62, '2024-04-05 00:20:32', 'pending', 'processing', 1),
(7, 18, 1, 'Joe', '0877353750', 'theprogamer1020@gmail.com', 'credit card', 'yes', 9.99, 'Блок №: 56, Улица: Жълта, Град: Минато, Квартал: Кон Бан, Държава: Япония, Пощенски код: 75623', 158.00, '2024-04-10 09:19:38', 'pending', 'processing', 1);

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
(5, 'Samsung Galaxy S21 Ultra Phantom Black', 'Samsung Galaxy S21 Ultra е първокласен флагмански смартфон с авангардни функции, система от камера от най-висок клас и мощен хардуер.', 'Samsung', '2021-01-29', 2, 'Exynos 2100', '512GB', '16GB', 4, '108MP (wide), 12MP (ultrawide), 10MP (periscope telephoto), 10MP (telephoto)', '6.8 in', '5000 mAh', 'Phantom Black', 1199.99, 'Samsung Galaxy S21 Ultra 1.png', 'Samsung Galaxy S21 Ultra 2.png', 'Samsung Galaxy S21 Ultra 3.png'),
(6, 'iPhone 13 Pro Max Graphite', 'iPhone 13 Pro Max е най-новият флагмански смартфон от Apple, включващ мощен A15 Bionic чип, изключителни възможности на камерата и зашеметяващ Super Retina XDR дисплей.', 'Apple', '2021-09-14', 11, 'A15 Bionic', '1TB', '8GB', 3, '12MP (wide), 12MP (ultrawide), 12MP (telephoto)', '6.7 in', '4352 mAh', 'Graphite', 2349.99, 'iphone 13 pro max graphyte 1.png', 'iphone 13 pro max graphyte 2.png', 'iphone 13 pro max graphyte 3.png'),
(8, 'Google Pixel 5 Just Black', 'Насладете се на авангардната технология на Google Pixel 5, водещ смартфон, който съчетава елегантен дизайн с мощни функции. Устройството е оборудвано с усъвършенстван процесор, осигуряващ плавна и ефективна работа за всички ваши задачи и приложения. Уловете зашеметяващи моменти с настройката на тройната камера. 6,0-инчовият дисплей осигурява завладяващо изживяване при гледане. Google Pixel 5 предоставя първокласно смартфон изживяване.', 'Google', '2022-10-01', 7, 'Qualcomm Snapdragon 765G', '128GB', '8GB', 3, '12.2 MP (main), 16 MP (ultrawide)', '6.0 in', '4080 mAh', 'Just Black', 667.63, 'Google Pixel 5 Just Black 1.png', 'Google Pixel 5 Just Black 2.png', 'Google Pixel 5 Just Black 3.png'),
(9, 'OnePlus 9 Pro Morning Mist', 'Изпитайте силата и елегантността на OnePlus 9 Pro. Този водещ смартфон се отличава с елегантен дизайн и авангардни технологии. С мощен процесор Qualcomm Snapdragon 888, 256 GB място за съхранение и 12 GB RAM, OnePlus 9 Pro осигурява изключителна производителност. Системата с тройна камера включва 48MP широк обектив, 50MP ултраширок обектив и 8MP телефото обектив, осигурявайки гъвкавост при заснемане на зашеметяващи моменти. 6,7-инчовият Fluid AMOLED дисплей предлага жизнено и завладяващо изживяване при гледане. Здравата батерия от 4500 mAh осигурява дълготрайна употреба, а устройството се предлага в стилен цвят &#039;Morning Mist&#039; цвят.', 'OnePlus', '2023-04-01', 7, 'Qualcomm Snapdragon 888', '256GB', '12GB', 3, '48MP (wide), 50MP (ultrawide), 8MP (telephoto)', '6.7 in', '4500 mAh', 'Morning Mist', 899.99, 'OnePlus 9 Pro Morning Mist 1.png', 'OnePlus 9 Pro Morning Mist 2.png', 'OnePlus 9 Pro Morning Mist 3.png'),
(11, 'Samsung Galaxy S23 Phantom Black', 'Открийте бъдещето на мобилните технологии със Samsung Galaxy S23. Този авангарден смартфон безпроблемно съчетава футуристичен дизайн с разширени функции. Захранван от най-новия процесор Exynos 9000 (или Snapdragon 9XXX, в зависимост от региона), Galaxy S23 осигурява несравнима производителност. С обширните 256 GB място за съхранение и огромните 12 GB RAM, това устройство гарантира безпроблемна многозадачност и съхранение за всички ваши нужди. Иновативната система с четири камери включва 108MP основен обектив, 48MP ултраширок обектив, 8MP перископен телефото обектив и 5MP сензор за дълбочина, предлагащи несравними фотографски възможности. Потопете се в зашеметяващия 6,5-инчов динамичен AMOLED дисплей, който вдъхва живот на цветовете. Здравата батерия от 5000 mAh осигурява продължителна употреба, а телефонът се предлага в изтънченото Celestial Blue цвят.', 'Samsung', '2023-03-15', 6, 'Snapdragon 8 Gen 2', '256GB', '8GB', 3, '12 MP (ultrawide), 50 MP (wide), 10 MP (telephoto)', '6.1 in', '3900 mAh', 'Phantom Black', 1440.00, 's galaxy s23 pblack 1.png', 's galaxy s23 pblack 2.png', 's galaxy s23 pblack 3.png'),
(15, 'Samsung Galaxy S24 Ultra Titanium Violet', 'Samsung Galaxy S24 Ultra Titanium Violet е авангарден флагмански смартфон, който безпроблемно съчетава зашеметяващ дизайн с мощни функции. Обвито в елегантно титаново виолетово покритие, устройството излъчва изтънченост и стил. Неговият жив и обширен дисплей предлага хипнотизиращо визуално изживяване, докато усъвършенстваната система на камерата осигурява изключителни възможности за снимки и видео. Снабден с високопроизводителен хардуер и иновативни технологии, Galaxy S24 Ultra Titanium Violet е символ на ангажимента на Samsung за предоставяне на първокласно мобилно изживяване.', 'Samsung', '2024-01-31', 2, 'Qualcomm Snapdragon 8 Gen 3', '1TB', '12GB', 4, '12 MP (ultra-wide), 10 MP (telephoto), 200 MP (wide), 50 MP (periscope telephoto)', '6.8 in', '5000 mAh', 'Titanium Violet', 2999.99, 'sgalaxy s24 ultra titanium violet 1.png', 'sgalaxy s24 ultra titanium violet 2.png', 'sgalaxy s24 ultra titanium violet 3.png'),
(16, 'Xiaomi 11T Celestial Blue', 'Xiaomi 11T Celestial Blue, който вече се предлага с 20% отстъпка, продължава да пленява с елегантния си дизайн и цветовата палитра, вдъхновена от небесата. Дълбокият блус на покритието му създава изискан външен вид, сега по-достъпен като цена. Това водещо устройство може да се похвали с високопроизводителна система от камери и авангардна технология, осигуряваща завладяващо потребителско изживяване. Със своя небесен син оттенък и усъвършенствани функции, Xiaomi 11T Celestial Blue се откроява като символ на стил и иновация, предлагайки достъпна цена без компромис с качеството.', 'Xiaomi', '2021-10-05', 4, 'Media Tek Dimensity 1200-Ultra', '128GB', '8GB', 3, '8 MP (ultrawide), 108 MP (wide), 5 MP (telephoto)', '6.67 in', '5000 mAh', 'Celestial Blue', 644.99, 'xiaomi 11t celestial blue 1.png', 'xiaomi 11t celestial blue 2.png', 'xiaomi 11t celestial blue 3.png'),
(17, 'Realme C31 Dark Green', 'Realme C31, бюджетен смартфон, разполага с 6,5-инчов HD+ дисплей за поглъщащо визуално изживяване. Неговият здрав процесор и достатъчно RAM осигуряват плавна многозадачност, допълнена от издръжлива батерия. Гъвкавата настройка на камерата, ръководена от управлявана от AI интелигентност, улавя моменти с прецизност. Достатъчно вътрешно хранилище и разширяеми опции отговарят на нарастващите цифрови нужди, а Realme UI подобрява потребителското изживяване. С цялостна свързаност и разширени функции за сигурност, Realme C31 предлага достъпност без компромис.', 'Realme', '2022-01-31', 9, 'Unisoc Tiger T612', '64GB', '4GB', 3, '2 MP (macro), 13 MP (wide), 0.3 MP (depth)', '6.5 in', '5000 mAh', 'Dark Green', 190.62, 'realmeC31 dark green 1.png', 'realmeC31 dark green 2.png', 'realmeC31 dark green 3.png'),
(18, 'Motorola Moto e13 Autora Green', 'Motorola Moto e13 Autora Green е бюджетен смартфон с елегантен дизайн и жив зелен цвят. Отличаващ се с отзивчив процесор, надеждна система от камери и оптимизиран живот на батерията, той предлага практично и удобно за потребителя изживяване. Балансирайки достъпност и функционалност, Moto e13 е завладяваща опция за тези, които търсят надежден и стилен смартфон.', 'Motorola', '2023-02-13', 1, 'Unisoc T606', '64GB', '2GB', 1, '13 MP Wide', '6.5 in', '5000 mAh', 'Autora Green', 157.99, 'motorola moto e13 autora green 1.png', 'motorola moto e13 autora green 2.png', 'motorola moto e13 autora green 3.png'),
(19, 'Oppo A12 Blue', 'Oppo A12 Blue е елегантен и достъпен смартфон, който съчетава стил с практични функции. Неговият привличащ вниманието син дизайн добавя нотка елегантност към устройството. С ярък дисплей, система с двойна камера и надежден процесор, Oppo A12 Blue е оборудван да улавя и да се наслаждава на моменти безпроблемно. Този бюджетен смартфон постига баланс между естетика и функционалност, което го прави привлекателен избор за потребители, търсещи достъпно и стилно мобилно изживяване.', 'Oppo', '2020-04-20', 0, 'MediaTek Helio P35 MT6765', '32GB', '2GB', 2, '13 MP (standard), 2 MP (depth)', '6.7 in', '4230 mAh', 'blue', 279.99, 'oppo a12 1.png', 'oppo a12 2.png', 'oppo a12 3.png'),
(24, 'OnePlus Nord 3 Misty Green', 'Представяме ви OnePlus Nord 3: безпроблемно сливане на мощност, стил и достъпност, поставяйки нов стандарт в съвършенството на смартфоните. Със своите забележителни характеристики, включително мощен 16GB RAM и чипсет MediaTek Dimensity 9000, той безпроблемно се справя с всяка задача, като същевременно осигурява достатъчно място за съхранение с щедрия си капацитет от 256GB. Насладете се на светкавично бърза 5G свързаност за незабавни изтегляния и безпроблемно поточно предаване на неговия завладяващ 6,74-инчов Super Fluid AMOLED дисплей с копринено гладка 120Hz честота на опресняване. Поддръжката на две SIM карти опростява вашия дигитален живот, докато неговият елегантен Мъгливозелен дизайн и тънък профил правят смело изявление. OnePlus Nord 3 предефинира съвършенството на смартфона, предоставяйки несравнима производителност, стил и достъпност в един изключителен пакет.', 'OnePlus', '2023-07-11', 7, 'MediaTek Dimensity 9000', '256GB', '16GB', 3, '2 MP (macro), 8 MP (ultrawide), 50 MP (wide)', '6.74 in', '5000 mAh', 'Misty Green', 813.37, 'oneplus_nord_3_misty_green_01.png', 'oneplus_nord_3_misty_green_02.png', 'oneplus_nord_3_misty_green_03.png'),
(25, 'OnePlus 12 Silky Black', 'Отново печелейки похвали като убиец на флагмани, OnePlus 12 предлага мощен удар с най-новия процесор Snapdragon за безпроблемна многозадачност и игри. Любителите на камерата ще се радват на подобрената производителност при слаба светлина и новия телефото обектив, докато голямата батерия гарантира, че няма да бъдете хванати мъртъв при ниско зареждане, благодарение на невероятно бързото кабелно и безжично зареждане на телефона. OnePlus остава верен на своите чисти софтуерни корени с OxygenOS 14 върху Android 14, предлагайки гладко потребителско изживяване. Уникалният гръб от матирано стъкло добавя нотка на индивидуалност и не оставя пръстови отпечатъци, но някои рецензенти намират цялостния дизайн за малко познат и не харесват извития дисплей. Въпреки тези незначителни недостатъци, OnePlus 12 остава завладяващ избор със своите мощни спецификации, дълъг живот на батерията и конкурентна цена.', 'OnePlus', '2024-01-23', 2, 'Qualcomm Snapdragon 8 Gen 3', '512GB', '16GB', 3, '50 MP (wide)', '6.82 in', '5400 mAh', 'Silky Black', 1920.00, 'oneplus_12_silky_black_01.png', 'oneplus_12_silky_black_02.png', 'oneplus_12_silky_black_03.png'),
(26, 'iPhone 14 Pro Max', 'iPhone 14 Pro Max се откроява като най-добрият iPhone за тези, които жадуват за изживяване с голям екран. Той може да се похвали с прекрасен, ярък дисплей със супер плавни честоти на опресняване и иновативна функция за постоянно включване. Системата на камерата е кралска с мощен 48-мегапикселов основен сензор и стабилизация на видеото, което прави екшън снимките лесно. Захранването на този телефон е най-добрият чип A16 Bionic, който гарантира, че всичко работи гладко. Тази мощна машина обаче се предлага на премиум цена и големият размер на телефона може да не е за всеки.', 'Apple', '2022-09-16', 3, 'A16 Bionic', '256GB', '6GB', 3, '48 MP (main), 12 MP (ultrawide), 12 MP (telephoto)', '6.7 in', '4323 mAh', 'White', 5106.37, 'iphone_14_pro_max_01.png', 'iphone_14_pro_max_02.png', 'iphone_14_pro_max_03.png'),
(27, 'Xiaomi 13T Pro Black', 'Xiaomi 13T Pro се очертава като силен конкурент с мощен процесор MediaTek Dimensity 9200+ за плавна работа и отличен живот на батерията. Той може да се похвали с прекрасен дисплей с висока честота на опресняване за супер отзивчиво усещане. Любителите на фотоапарата ще оценят системата с тройна леща с висока разделителна способност, въпреки че някои рецензенти отбелязват леко неточни тонове на кожата в снимките. Въпреки че софтуерът предлага известно персонализиране, това не е най-чистото потребителско изживяване. Липсата на официална дата на пускане на 16GB/1TB версия означава, че може да се наложи да изчакате, за да се сдобиете с този пълен с функции телефон.', 'Xiaomi', '2023-09-26', 3, 'MediaTek Dimensity 9200+ CPU', '1TB', '16GB', 3, '12 MP (ultrawide), 50 MP (wide), 50 MP (telephoto)', '6.67 in', '5000 mAh', 'Black', 1678.99, 'xiaomi_13t_pro_black_01.png', 'xiaomi_13t_pro_black_02.png', 'xiaomi_13t_pro_black_03.png'),
(28, 'Google Pixel 8 Obsidian', 'Google Pixel 8 (128GB, 8GB RAM, 5G) в Obsidian може да е по-малък от своя брат Pro, но сам по себе си е мощен. Чипът Tensor G3 на Google се справя с лекота с ежедневните задачи и дори с леките игри. Въпреки че има само една задна камера, Pixel 8 прави невероятни снимки и видеоклипове благодарение на софтуерната магия на Google, предлагаща творческа свобода с функции като Magic Editor. Батерията от 4575 mAh осигурява цял ден зареждане, като някои потребители дори достигат два дни при умерена употреба. Компактният размер на телефона го прави удобен за използване с една ръка, а Google гарантира софтуерни актуализации за 7 години, поддържайки телефона ви защитен и актуализиран. Въпреки че основното хранилище може да се запълни бързо за тежки потребители и честотата на опресняване на дисплея не е най-високата на пазара, Pixel 8 предлага фантастична камера, дълъг живот на батерията и софтуер, подходящ за бъдещето, на конкурентна цена.', 'Google', '2023-10-04', 4, 'Google Tensor G3', '128GB', '8GB', 2, '12 MP (ultrawide), 50 MP (wide)', '6.2 in', '4575 mAh', 'Obsidian', 1176.51, 'google_pixel_8_obsidian_01.png', 'google_pixel_8_obsidian_02.png', 'google_pixel_8_obsidian_03.png'),
(29, 'Motorola Edge 40 Pro Interstellar Black', 'Motorola Edge 40 Pro е мощен конкурент на пазара от висок клас с чип Snapdragon 8 Gen 2, гъвкава система с три камери и зашеметяващ 120Hz OLED дисплей. Той може да се похвали с бързо зареждане и дълъг живот на батерията, но имайте предвид липсата на разширяемо съхранение и жак за слушалки. С 256 GB място за съхранение и 12 GB RAM, тази опция Interstellar Black е солиден избор за потребители, които дават приоритет на производителността и красивия дисплей.', 'Motorola', '2023-04-04', 2, 'Snapdragon 8 Gen 2', '256GB', '12GB', 3, '12 MP (telephoto), 50 MP (wide), 50 MP (ultrawide)', '6.67 in', '4600 mAh', 'Interstellar Black', 1663.93, 'motorola_edge_40_pro_interstellar_black_01.png', 'motorola_edge_40_pro_interstellar_black_02.png', 'motorola_edge_40_pro_interstellar_black_03.png'),
(30, 'Motorola razr 40 Ultra Infinite Black', 'Razr 40 Ultra на Motorola в Infinite Black съчетава стилен сгъваем дизайн с голям функционален дисплей с капак. Пантата се чувства подобрена, а мощният Snapdragon 8 Gen 1 се справя добре с ежедневните задачи и игри. Въпреки че системата на камерата е прилична, тя не е водеща в класа. Животът на батерията е впечатляващ за сгъваем, но липсата на най-новия чип Snapdragon може да се отрази на високата цена. Като цяло, това е завладяваща опция за тези, които дават приоритет на уникалното сгъваемо изживяване с голям дисплей с капак.', 'Motorola', '2023-06-01', 4, 'Qualcomm Snapdragon 8 Plus Gen 1', '256GB', '8GB', 2, '12 MP (wide), 13 MP (ultrawide)', '6.9 in', '3800 mAh', 'Infinite Black', 1451.62, 'motorola_razr_40_ultra_infinite_black_01.png', 'motorola_razr_40_ultra_infinite_black_02.png', 'motorola_razr_40_ultra_infinite_black_03.png'),
(31, 'Oppo Find X5 Pro Glaze Black', 'Oppo Find X5 Pro в Glaze Black е телефон от висок клас с мощен процесор Snapdragon 8 Gen 1, голяма батерия от 5000 mAh с невероятно бързо зареждане от 80 W и прекрасен 6,7-инчов дисплей. Той също така може да се похвали с първокласна камера система, разработена съвместно от Hasselblad, което го прави чудесен избор за любителите на мобилната фотография. Някои рецензенти обаче отбелязват, че телефонът може да бъде малко тежък и леко хлъзгав поради керамичната си конструкция. Като цяло, Oppo Find X5 Pro е телефон с много функции и елегантен дизайн, който трябва да се хареса на потребителите на Android, които търсят премиум устройство.', 'Oppo', '2022-02-24', 11, 'Qualcomm Snapdragon 8 Gen 1', '256GB', '12GB', 3, '50 MP (wide), 32 Mpx', '6.7 in', '5000 mAh', 'Glaze Black', 2167.15, 'oppo_find_x5_pro_glaze_black_01.png', 'oppo_find_x5_pro_glaze_black_02.png', 'oppo_find_x5_pro_glaze_black_03.png'),
(32, 'Oppo A78 Mist Black', 'Oppo A78 в Mist Black е бюджетен телефон с голямо предимство: гладък 90Hz AMOLED дисплей. Въпреки че камерите не са забележителни, той разполага с изненадващо мощен процесор за цената, което го прави способен да се справя с ежедневни задачи и леки игри. Животът на батерията е впечатляващ благодарение на батерията от 5000mAh, но скоростите на зареждане са малко ниски. Като цяло, Oppo A78 е солидна опция за потребители, които търсят голям дисплей и добра производителност на достъпна цена, но имайте предвид толкова добрата камера и бавното зареждане.', 'Oppo', '2023-07-10', 3, 'Qualcomm Snapdragon 680', '128GB', '8GB', 2, '2 MP (depth), 50 MP (wide), 8Mpx', '6.43 in', '5000 mAh', 'Mist Black', 360.45, 'oppo_a78_mist_black_01.png', 'oppo_a78_mist_black_02.png', 'oppo_a78_mist_black_03.png'),
(33, 'Motorola Edge 30 Meteor Gray', 'Motorola Edge 30 в цвят Meteor Grey е мощен телефон от среден клас с красив 144Hz OLED дисплей за супер плавни визуализации. 5G свързаността гарантира бързо изтегляне, а мощният процесор се справя с повечето ежедневни задачи и дори с леки игри. Той може да се похвали със способна система от три камери, но снимането при слаба светлина може да бъде по-добро. Животът на батерията е приличен, но скоростите на зареждане са малко по-бавни. Като цяло Motorola Edge 30 е добър избор за потребители, които търсят стилен телефон със страхотен дисплей и добро представяне на конкурентна цена.', 'Oppo', '2022-04-27', 5, 'Qualcomm Snapdragon 778G+', '256GB', '8GB', 3, '2 MP (depth), 50 MP (wide), 50 MP (macro), 32 Mpx', '6.55 in', '4020 mAh', 'Meteor Gray', 398.36, 'motorola_edge_30_meteor_gray_01.png', 'motorola_edge_30_meteor_gray_02.png', 'motorola_edge_30_meteor_gray_03.png'),
(34, 'Google Pixel 8 Pro Porcelain', 'Pixel 8 Pro на Google в Porcelain е звезден водещ телефон, който може да предложи много. 6,7-инчовият LTPO OLED дисплей може да се похвали със супер плавна честота на опресняване от 120Hz и изключителна яркост. Чипът Tensor G3, съчетан с 12 GB RAM, осигурява първокласна производителност, правейки многозадачността и игрите лесно. Системата на камерата е ненадмината, заснема зашеметяващи снимки и видеоклипове с впечатляващата обработка на AI на Google. Животът на батерията е надежден благодарение на капацитета от 5050 mAh, но скоростта на зареждане може да бъде по-бърза. Като цяло, Pixel 8 Pro е фантастичен избор за потребители, които дават приоритет на невероятна камера, красив дисплей и чисто софтуерно изживяване.', 'Google', '2023-10-12', 4, 'Google Tensor G3', '128GB', '12GB', 3, '50 MP (wide), 48 MP (telephoto), 48 MP (ultrawide), 10.5 Mpx', '6.7 in', '5050 mAh', 'Porcelain', 1843.09, 'google_pixel_8_pro_porcelain_01.png', 'google_pixel_8_pro_porcelain_02.png', 'google_pixel_8_pro_porcelain_03.png'),
(35, 'Realme GT NEO 3 Asphalt Black', 'Realme GT Neo 3 в Asphalt Black е демон на скоростта за геймърите, включващ мощния процесор MediaTek Dimensity 8100 с 12 GB RAM за гладка производителност. Дисплеят с честота на опресняване от 120 Hz осигурява копринено плавни визуализации, докато 5G свързаността ви държи свързани с изкривена скорост. Въпреки че системата с тройна камера от 50 MP прави прилични снимки, представянето при слаба светлина не е звездно. Батерията от 5000 mAh предлага добра издръжливост, но някои може да пожелаят още по-бързо зареждане. Като цяло, Realme GT Neo 3 е завладяваща опция за геймърите, които търсят телефон с първокласна производителност, бърз дисплей и издръжлива батерия.', 'Realme', '2022-04-29', 2, 'MediaTek Dimensity 8100', '256GB', '12GB', 3, '2 MP (macro), 8 MP (ultrawide), 50 MP (wide), 16 Mpx', '6.7 in', '4500 mAh', 'Asphalt Black', 989.99, 'realme_gt_neo_3_asphalt_black_01.png', 'realme_gt_neo_3_asphalt_black_02.png', 'realme_gt_neo_3_asphalt_black_03.png'),
(36, 'Realme GT NEO 3T Dragon Ball Z Blue', 'Изданието Realme GT Neo 3T Dragon Ball Z в синьо е забавна опция за феновете с мощна страна. Въпреки че може да се похвали с малко по-малко тежки 8 GB RAM в сравнение със стандартния Neo 3, процесорът Snapdragon 870 осигурява гладка производителност за ежедневна употреба и дори някои игри. 120Hz AMOLED дисплей е удоволствие за гледане или игра, а 5G свързаността ви предпазва от бъдещето. 64MP основната камера заснема прилични снимки, но системата на камерата не е основният фокус тук. Този телефон дава приоритет на производителността и стила за феновете на Dragon Ball Z, с уникален дизайн и персонализирани софтуерни щрихи.', 'Realme', '2022-06-15', 0, 'Qualcomm Snapdragon 870', '256GB', '8GB', 3, '2 MP (macro), 8 MP (ultrawide), 64 MP (ide), 16 Mpx', '6.62 in', '5000 mAh', 'Blue', 1002.03, 'realme_gt_neo_3t_dragon_ball_z_blue_01.png', 'realme_gt_neo_3t_dragon_ball_z_blue_02.png', 'realme_gt_neo_3t_dragon_ball_z_blue_03.png'),
(37, 'Samsung Galaxy S24+ Onyx Black', 'Samsung Galaxy S24+ Onyx Black е силен конкурент на пазара на водещи телефони, предлагащ прекрасен 6,7-инчов дисплей, мощен чип Exynos 2400 и изключителен живот на батерията благодарение на своята клетка от 4900 mAh. Въпреки че системата на камерата е добра, тя не отговаря съвсем на най-доброто в ситуации на слаба светлина. Като цяло, S24+ предоставя фантастично потребителско изживяване с цена, която е малко по-ниска от своя брат Ultra.', 'Samsung', '2024-01-31', 3, 'Exynos 2400', '512GB', '12GB', 3, '12 MP (ultrawide), 50 MP (wide), 10 MP (telephoto), 12 Mpx', '6.7 in', '4900 mAh', 'Onyx Black', 2177.12, 'samsung_galaxy_s24+_onyx_black_01.png', 'samsung_galaxy_s24+_onyx_black_02.png', 'samsung_galaxy_s24+_onyx_black_03.png');

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
(1, 1, '2024-01-21 08:42:15', 'Jewel', 'joeimportant1020@gmail.com', '0878146923', 'Samsung', 'Дълг', 0, NULL, 'pending', 'no', 43.53, '-'),
(2, 1, '2024-01-27 09:03:48', 'Joe', 'jewel@gmail.com', '0879456200', 'Samsung', 'Основното безпокойство е, че екранът на телефона изглежда напукан и има забележима липса на реакция. За първи път забелязах проблема на [посочете датата или приблизителния час]. Нямаше конкретен инцидент, който мога да си спомня, но поведението на екрана се промени внезапно. При по-внимателно разглеждане забелязах няколко пукнатини по повърхността на екрана. Струва си да се отбележи, че тези пукнатини изглежда засягат цялостната функционалност на сензорния екран. Няма скорошни софтуерни актуализации или промени в настройките, за които знам. Телефонът работи нормално до появата на проблема с екрана.', 1, 'cash on delivery', 'completed', 'no', 28.00, '- '),
(3, 1, '2024-02-12 13:21:26', 'Jewel Shahi', 'jewel@jewel.com', '0877323151', 'Apple', 'Не е добре', 0, 'cash on delivery', 'pending', 'yes', 22.35, 'Блок №: 23, Улица: Улица Амбър, Град: София, Квартал: Вазов, Държава: България, Пощенски код: 12336'),
(5, 1, '2024-04-16 22:10:30', 'Джуел Шахи', 'joe@pro.com', '0877564574', 'Samsung', 'Дисплейят се изгори!!', 0, NULL, 'pending', 'no', 0.00, '\'-\'');

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
(1, 'User', 'user@user.com', '12dea96fec20593566ab75692c9949596833adc9', 0, 'grimmjow-jaegerjaquez.png', '2023-12-15'),
(2, 'Admin', 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'sung-jinwoo-death-look.png', '2023-12-15'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
