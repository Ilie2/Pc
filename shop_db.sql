-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 02:45 PM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_responses`
--

CREATE TABLE `chatbot_responses` (
  `id` int(11) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `response` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot_responses`
--

INSERT INTO `chatbot_responses` (`id`, `question`, `response`) VALUES
(1, 'Hello', 'Hi! How can i help you ?');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `comment_content` text DEFAULT NULL,
  `comment_author` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `comment_content`, `comment_author`, `created_at`) VALUES
(1, 1, 'ffff', 'fggf', '2023-11-26 19:39:41'),
(2, 1, '223232', 'dan', '2023-11-26 23:35:23'),
(3, 1, '223232', 'dan', '2023-11-26 23:36:14'),
(7, 2, 'rr', 'dan', '2023-11-26 23:59:32'),
(8, 2, 'rr', 'dan', '2023-11-26 23:59:37'),
(10, 7, 'asdfgh\r\n', 'zfsdfdds', '2023-11-27 07:57:44');

-- --------------------------------------------------------

--
-- Table structure for table `comment_1`
--

CREATE TABLE `comment_1` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `comment_content` text DEFAULT NULL,
  `comment_author` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_1`
--

INSERT INTO `comment_1` (`id`, `product_id`, `comment_content`, `comment_author`, `created_at`) VALUES
(1, 7, 'asdfgh\r\n', 'zfsdfdds', '2023-11-27 08:01:23'),
(2, 7, 'ddd', 'ddd', '2023-11-27 08:01:42'),
(3, 5, 'este fain', 'dan', '2023-11-27 11:22:05'),
(4, 1, 'dddddddd', 'zfsdfdds', '2024-03-20 18:25:44'),
(5, 7, 'relol\r\n', 'dan', '2024-05-04 16:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `discountper` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`name`, `price`, `image`, `discountper`, `id`) VALUES
('Mouse Gaming LOGITECH G502 HERO', 300, 'discounts/product-1.png', 16, 1),
('Mouse Gaming RAZER Viper Mini', 103, 'discounts/product-2.png', 12, 2),
('Mouse gaming SteelSeries Rival 3, Negru', 190, 'discounts/product-3.png', 25, 3),
('Tastatura mecanica HP HyperX Alloy 65 Red, Iluminare RGB, Negru', 300, 'discounts/product-4.png', 25, 4),
('Tastatura Marvo KG962, iluminare Rainbow, USB-C, negru', 190, 'discounts/product-5.png', 30, 5),
('Tastatura Gaming Genesis Rhod 420 RGB', 135, 'discounts/product-6.png', 28, 6),
('Kit gaming Onikuma tastatura mecanica RGB G26 89 taste si mouse RGB CW905 7 butoane 6400 DPI ', 240, 'discounts/product-7.png', 15, 7),
('Pachet sistem PC Gaming Pro377, Procesor Intel® Core™ I7 3,4 GHz, 16GB RAM,2TB HDD, GeForce GT710,Monitor 21.5\" ', 3600, 'discounts/product-8.png', 10, 8),
('Desktop PC Gaming Serioux cu procesor AMD Ryzen™ 9 5900X, 32GB DDR4, 1TB SSD, GeForce® RTX 3070 8GB GDDR6,', 8000, 'discounts/product-9.png', 21, 9);

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

CREATE TABLE `email_verification` (
  `user_id` int(11) DEFAULT NULL,
  `verification_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_verification`
--

INSERT INTO `email_verification` (`user_id`, `verification_code`) VALUES
(4, 649143),
(4, 913856),
(4, 111997),
(4, 945785),
(4, 807558),
(4, 903656),
(4, 377411),
(4, 530102),
(4, 112762),
(4, 830315),
(4, 374879),
(4, 957726),
(4, 142133),
(4, 133895),
(4, 706422),
(4, 717257),
(4, 152553),
(4, 380401),
(4, 178186),
(4, 333937),
(4, 566855),
(4, 455268),
(4, 619569),
(4, 832259),
(4, 580483),
(4, 563717),
(4, 324345),
(6, 766652),
(4, 125581),
(4, 786921),
(4, 243776),
(4, 872777),
(4, 356215),
(4, 522017),
(4, 449895);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(0, 4, 'Alexandru Benteu', '0770751534', 'alex.benteu@benzone.work', 'cash on delivery', 'flat no. 156, liviu R, Timisoara, Timis, Romania - 123456', 'Mouse gaming T-Dagger Lance Corporal, Negru, T-TGM107 (120 x 1) - ', 120, '2024-05-09', 'pending'),
(0, 4, 'Alexandru', '0770751534', 'alexandrescudan19@gmail.com', 'cash on delivery', 'flat no. 156, liviu R, Timisoara, Timis, Romania - 123456', 'AirPods (2000 x 1) - Blitzwolf BW-FYE5 earbuds (443 x 1) - ', 2443, '2024-05-09', 'pending'),
(0, 6, 'Alexandru', '0770751534', 'alexandrescudan19@gmail.com', 'cash on delivery', 'flat no. 156, liviu R, Timisoara, Timis, Romania - 123456', 'AirPods (2000 x 1) - ', 2000, '2024-05-09', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `produse`
--

CREATE TABLE `produse` (
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `stock` int(10) NOT NULL,
  `categorie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produse`
--

INSERT INTO `produse` (`name`, `price`, `image`, `id`, `stock`, `categorie`) VALUES
(' Apple Watch 4', 2000, 'smartwear/smartwatch1.png', 1, 100, 'smartwear'),
('Galxy Watch 3', 1300, 'smartwear/smartwatch2.jpg', 2, 100, 'smartwear'),
('Huawei Watch', 3500, 'smartwear/smartwatch3.jpg', 3, 100, 'smartwear'),
('Frigider Smart', 999, 'frigidere/produs1.png', 4, 100, 'frigider'),
('Casti gaming cu microfon Aqirys Altair, 7.1 USB, Virtual surround, Iluminare RGB, Negre, (AQRYS_ALTAIRWH)', 186, 'headsets/produs1.jpg', 5, 100, 'headsets'),
('Casti gaming wireless ASUS TUF Gaming H3 Wireless, 2.4 GHz, sunet surround 7.1, difuzoare 50mm', 370, 'headsets/produs2.jpg', 6, 100, 'headsets'),
('Casti gaming wireless Razer Barracuda X, Multiplatforma PC, Playstation, Switch, surround 7.1 Virtual', 560, 'headsets/produs3.jpg', 7, 100, 'headsets'),
('Tastatura gaming mecanica A+ K75, iluminare rainbow, Neagra', 110, 'keyboards/product1.jpg', 8, 100, 'keyboards'),
('Tastatura Mecanica Wireless, Fir Dongle 2.4Ghz ROYAL KLUDGE', 360, 'keyboards/product2.jpg', 9, 100, 'keyboards'),
('Tastatura mecanica gaming HyperX Alloy Origins Core, RGB, Switch HX-Blue', 290, 'keyboards/product3.jpg', 10, 100, 'keyboards'),
('Mouse gaming Logitech G102, 8000 dpi, RGB, Negru', 300, 'mice/mouse1.jpg', 11, 100, 'mice'),
('Mouse gaming T-Dagger Lance Corporal, Negru, T-TGM107', 120, 'mice/mouse2.jpg', 12, 100, 'mice'),
('Mouse gaming Corsair M65 Pro RGB, senzor optic 12000DPI, Negru ', 250, 'mice/mouse3.jpg', 13, 100, 'mice'),
('AirPods', 2000, 'wirelessearbuds/airpods.jpg', 14, 100, 'wirelessearbuds'),
('Blitzwolf BW-FYE5 earbuds', 443, 'wirelessearbuds/blitzwolfbuds.jpg', 15, 100, 'wirelessearbuds'),
('Galaxy Buds', 395, 'wirelessearbuds/galaxybuds.jpeg', 16, 100, 'wirelessearbuds'),
('Sistem Gaming Lenovo IdeaCentre 5 14ACN6 cu procesor AMD Ryzen™ 5 5600G pana la 4.40 GHz, 16GB DDR4, 512GB SSD M.2 2280 PCIe NVMe, NVIDIA GeForce GTX 1650 SUPER 4GB GDDR6, No OS', 2600, 'pcgaming/produs1.jpg', 17, 100, 'pcgaming'),
('Sistem Desktop PC Gaming Lenovo Legion T5 26AMR5 cu procesor AMD Ryzen™ 5 5600G pana la 4.40GHz, 16GB DDR4, 512GB SSD M.2 PCIe, GeForce RTX 3060 12GB GDDR6, No OS', 6110, 'pcgaming/produs2.jpg', 18, 100, 'pcgaming'),
('Sistem Gaming HP Pavilion cu procesor Intel® Core™ i5-10400 pana la 4.30 GHz, Comet Lake, 8GB DDR4, 512GB SSD, NVIDIA GeForce GTX 1650 SUPER 4GB, Windows 11 Home, Shadow Black', 2900, 'pcgaming/produs3.jpg', 19, 100, 'pcgaming');

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `is_verified`) VALUES
(4, 'Singren12', 'alexandrescudan19@gmail.com', 'ba0a5587353d249bc38b6511db3f1202', 0),
(6, 'Alexandru', 'ilie.alexandrescu03@e-uvt.ro', 'ba0a5587353d249bc38b6511db3f1202', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_discounts` (`product_id`);

--
-- Indexes for table `comment_1`
--
ALTER TABLE `comment_1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD KEY `email_verification_ibfk_1` (`user_id`);

--
-- Indexes for table `produse`
--
ALTER TABLE `produse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comment_1`
--
ALTER TABLE `comment_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `fk_comments_discounts` FOREIGN KEY (`product_id`) REFERENCES `discounts` (`id`);

--
-- Constraints for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD CONSTRAINT `email_verification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_form` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
