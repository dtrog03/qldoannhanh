-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 12:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qldan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(34, 3, 26, 4, '2024-11-06 02:24:04'),
(35, 6, 22, 10, '2024-11-11 07:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(4, 'Ưu Đãi', 'Món ăn với ưu đãi đặc biệt'),
(5, 'Món Mới', 'Các món ăn mới ra mắt'),
(6, 'Combo 1 Người', 'Combo dành cho 1 người dùng'),
(7, 'Combo Nhóm', 'Combo dành cho nhóm người dùng'),
(8, 'Gà Rán - Gà Quay', 'Các món ăn từ gà rán và gà quay'),
(9, 'Burger - Cơm - Mì Ý', 'Các món burger, cơm và mì Ý'),
(10, 'Thức Ăn Nhẹ', 'Các món ăn nhẹ và nhanh'),
(11, 'Thức Uống & Tráng Miệng', 'Các loại thức uống và món tráng miệng');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `message`, `create_at`, `user_id`) VALUES
(1, 'Nguyễn Trung Tâm', 'tamnguyen0205036@gmail.com', '0763120024', 'Xin chào', '2024-11-01 15:00:37', 3),
(2, 'Nguyễn Trung Tâm', 'tamnguyen0205036@gmail.com', '0763120024', 'Xin chào , đồ ăn đắt vc', '2024-11-01 15:04:58', 3),
(3, 'Nguyễn Trung Tâm', 'tamnguyen0205036@gmail.com', '0763120024', 'Xin chao trung nu', '2024-11-01 15:31:14', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','canceled') NOT NULL DEFAULT 'pending',
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fullname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total`, `status`, `address`, `phone`, `fullname`) VALUES
(23, 3, '2024-11-01 15:20:45', 1173000.00, 'canceled', 'Thanh Hóa', '0763120024', 'Nguyễn Trung Tâm'),
(24, 3, '2024-11-01 15:30:13', 13539000.00, 'completed', 'Thanh Hóa', '0763120024', 'Nguyễn Trung Tâm'),
(25, 3, '2024-11-02 03:24:11', 14232000.00, 'completed', 'Thanh Hóa', '0763120024', 'Nguyễn Trung Tâm'),
(27, 3, '2024-11-02 10:09:20', 12422536.00, 'completed', 'Thanh Hóa', '0987654321', 'nguyen trung tam'),
(28, 3, '2024-11-02 10:10:16', 12422536.00, 'completed', 'tht', '0987654321', 'nguyen trung tam'),
(29, 3, '2024-11-03 03:12:27', 12422536.00, 'completed', 'Thanh Hóa', '0763120024', 'Nguyễn Trung Tâm'),
(31, 3, '2024-11-06 02:24:32', 516000.00, 'pending', 'Thanh Hóa', '0763120024', 'Nguyễn Trung Tâm'),
(32, 6, '2024-11-11 07:38:19', 1170000.00, 'pending', 'Hai Duong', '0763120024', 'Le Cong Kun');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category_id`) VALUES
(13, '1 BURGER BÁNH MÌ', '1 BURGER BÁNH MÌ', 48000.00, 'burgerbanhmi.jpg', 5),
(14, 'BURGER BÁNH MÌ HDA', '1 Burger Bánh Mì + 1 Khoai Tây Chiên (vừa) + 1 Lon Pepsi', 77000.00, 'burgerhda.jpg', 5),
(15, 'BURGER BÁNH MÌ HDB', '2 Burger Bánh Mì + 2 Miếng Gà Rán + 2 Lon Pepsi', 189000.00, 'HD_B.jpg', 5),
(16, '6 GÀ XỐT ỚT XIÊM XANH', '6 Gà Xốt Ớt Xiêm Xanh', 261000.00, '6-new.jpg', 5),
(17, 'CƠM GÀ VIÊN NANBAN', '01 Cơm Gà Viên Nanban', 39000.00, 'NANBAN.jpg', 5),
(18, 'COMBO CƠM GÀ VIÊN NANBAN HDA', '01 Cơm Gà Viên Nanban + 01 Miếng Gà Rán + 01 Pepsi lon', 86000.00, 'COMBO-A-Nan.jpg', 5),
(19, 'COMBO CƠM GÀ VIÊN NANBAN HDB', '01 Cơm Gà Viên Nanban + 03 Miếng Gà Rán + 01 Khoai tây chiên (vừa)/ 01 Khoai tây nghiền & 01 Bắp cải trộn (vừa) + 02 Pepsi lon', 189000.00, 'COMBO-B-Nan.jpg', 5),
(20, 'COMBO GÀ RÁN 1', '1 Miếng Gà + 1 Khoai Tây Chiên / 1 Khoai Tây Nghiền & Bắp Cải Trộn + 1 Pepsi (lớn)', 59000.00, 'D-CBO-CHICKEN-1.jpg', 6),
(21, 'COMBO GÀ RÁN 2', '2 Miếng Gà + 1 Khoai Tây Chiên / 1 Khoai Tây Nghiền & Bắp Cải Trộn + 1 Pepsi (lớn)', 89000.00, 'D-CBO-CHICKEN-2.jpg', 6),
(22, 'COMBO GÀ QUAY', '1 Đùi Gà Quay Flava + 1 Salad Hạt + 1 Lipton (lớn)', 117000.00, 'D-CBO-Big-Juicy.jpg', 6),
(23, 'COMBO PHI-LÊ GÀ QUAY', '1 Phi-Lê Gà Quay Flava + 1 Salad Hạt + 1 Lipton (lớn)', 84000.00, 'D-CBO-Flava-Fillet.jpg', 6),
(24, 'COMBO BURGER TÔM', '1 Burger Tôm + 1 Khoai Tây Chiên (vừa) + 1 Pepsi (lớn)', 67000.00, 'D-CBO-B-Shrimp.jpg', 6),
(25, 'COMBO CƠM PHI-LÊ GÀ QUAY', '1 Cơm Gà Flava + 1 Súp Rong Biển + 1 Pepsi (lớn)', 71000.00, 'D-CBO-Rice-Flava.jpg', 4),
(26, '10 GÀ RÁN TENDERS VỊ NGUYÊN BẢN', '1 Cơm Gà Flava + 1 Súp Rong Biển + 1 Pepsi (lớn)', 129000.00, '10-TENDERS.jpg', 4),
(27, 'MÌ Ý GÀ RÁN', '1 Mì Ý Gà Rán', 64000.00, 'MI-Y-GA-RAN.jpg', 4),
(28, 'SÚP RONG BIỂN', 'SÚP RONG BIỂN', 19000.00, 'Soup-Rong-Bien.jpg', 4),
(29, 'PEPSI KHÔNG CALO LON', 'PEPSI KHÔNG CALO LON', 19000.00, 'pepsi-zero.jpg', 4),
(30, 'COMBO BURGER ZINGER', '1 Burger Zinger + 1 Khoai Tây Chiên (vừa) + 1 Pepsi (lớn)', 77000.00, 'D-CBO-B-Zinger.jpg', 6),
(31, 'COMBO BURGER PHI-LÊ GÀ QUAY', '1 Burger Flava + 1 Khoai Tây Chiên (vừa) + 1 Pepsi (lớn)', 77000.00, 'D-CBO-B-Flava.jpg', 6),
(32, 'Combo Mì Ý Gà Viên', '1 Mì Ý Popcorn + 1 Pepsi (lớn)', 47000.00, 'D-CBO-PastaPop2.jpg', 6),
(33, 'COMBO NHÓM 2', '2 Miếng Gà + 1 Burger Zinger + 2 Pepsi (lớn)', 127000.00, 'D-CBO-Bucket-1.jpg', 7),
(34, 'Combo nhóm 3', '3 Miếng Gà + 1 Mì Ý Popcorn + 1 Khoai Tây Chiên (vừa) + 2 Pepsi (lớn)', 160000.00, 'D-CBO-Bucket-2.jpg', 7),
(35, 'Combo nhóm 4', '4 Miếng Gà + 1 Khoai Tây Múi Cau (vừa) + 2 Pepsi (lớn)', 167000.00, 'D-CBO-Bucket-3.jpg', 7),
(36, 'Combo nhóm 5', '5 Miếng Gà + 1 Khoai Tây Chiên (vừa) + 3 Pepsi (lớn)', 205000.00, 'D-CBO-Bucket-4.jpg', 7),
(37, 'Trà Đào', 'Trà Đào', 24000.00, 'Peach-Tea.jpg', 11),
(38, 'Salad Hạt', '1 Salad Hạt', 38000.00, 'SALAD-HAT.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `address`, `created_at`, `role`) VALUES
(3, 'tam11', '$2y$10$7XZopNeNvpBcf8QzQ2xlj.cUEAG7VTJFfz9VVNk9B2A/G.c24A52e', 'tamnguyen0205036@gmail.com', '0763120024', 'Thanh Hóa', '2024-11-01 02:21:59', 'admin'),
(5, 'admin', '$2y$10$QncWfghBLJLEtuVG1Op8t.vLDRQsFu8sU0aGQGLDwg/kGjn9mg7Py', 'admin@gmail.com', '0763120024', 'Thanh Hóa', '2024-11-02 04:21:26', 'admin'),
(6, 'kun', '$2y$10$R8YmrkjRatEjjL49zN6zdO9VVDKXk3Jr8ysZtosT2BHV1cgAFcu7K', 'kun@gmail.com', '0763120024', 'Thanh Hóa', '2024-11-11 07:37:02', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
