-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2026 at 05:16 AM
-- Server version: 8.0.44
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cara_ecommerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Áo', 'Các loại áo sơ mi, áo thun thời trang'),
(2, 'Quần', 'Các loại quần âu, quần short, quần đũi');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên người nhận',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SĐT người nhận',
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Địa chỉ giao hàng',
  `total_money` int NOT NULL COMMENT 'Tổng tiền đơn hàng',
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'COD' COMMENT 'COD / VNPay / Banking',
  `status` tinyint DEFAULT '1' COMMENT '1: Chờ xử lý, 2: Đang giao, 3: Đã giao, 0: Hủy',
  `note` text COLLATE utf8mb4_unicode_ci COMMENT 'Ghi chú của khách',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `phone`, `address`, `total_money`, `payment_method`, `status`, `note`, `created_at`) VALUES
(1, NULL, 'Khanh My', '123456789', '123 Dinh Bo linh', 580000, 'COD', 1, NULL, '2026-01-30 13:26:39'),
(2, NULL, 'Trương Khiết Anh', '123456789', '123 Dinh Bo linh', 865000, 'COD', 0, NULL, '2026-02-02 14:14:37'),
(3, 9, 'Như Nghĩa', '123456789', '123 Dinh Bo linh', 460000, 'COD', 2, NULL, '2026-02-12 13:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tên SP tại thời điểm mua',
  `price` int NOT NULL COMMENT 'Giá mua tại thời điểm đặt',
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 16, 'Áo sơ mi nam tay ngắn cổ trụ vải Cotton', 300000, 1),
(2, 1, 15, 'Áo sơ mi nam tay dài có túi vải Cotton', 280000, 1),
(3, 2, 18, 'Áo Sơ Mi Demin Nữ Cột Eo Retro', 285000, 1),
(4, 2, 16, 'Áo sơ mi nam tay ngắn cổ trụ vải Cotton', 300000, 1),
(5, 2, 15, 'Áo sơ mi nam tay dài có túi vải Cotton', 280000, 1),
(6, 3, 3, 'Áo sơ mi nữ họa tiết Abstract Multi-color', 230000, 1),
(7, 3, 8, 'Áo thun nữ in hình mèo cổ chữ V, dáng rộng', 230000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` int NOT NULL DEFAULT '0' COMMENT 'Giá VND (Số nguyên)',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT '0' COMMENT 'Số lượng trong kho',
  `featured` tinyint DEFAULT '0' COMMENT '1: Nổi bật, 0: Thường',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `price`, `image`, `quantity`, `featured`, `created_at`) VALUES
(1, 'Áo sơ mi nữ họa tiết Abstract Multi-color', 1, 'Áo sơ mi họa tiết độc đáo, chất vải thoáng mát phù hợp mùa hè.', 230000, 'assets/img/products/f1.jpg', 50, 1, '2026-01-24 12:38:18'),
(2, 'Áo sơ mi nữ họa tiết Abstract Multi-color', 1, 'Thiết kế họa tiết trừu tượng, mang lại vẻ ngoài trẻ trung.', 250000, 'assets/img/products/f2.jpg', 50, 1, '2026-01-24 12:38:18'),
(3, 'Áo sơ mi nữ họa tiết Abstract Multi-color', 1, 'Họa tiết hoa nhí vintage, dễ dàng phối đồ dạo phố.', 230000, 'assets/img/products/f3.jpg', 50, 1, '2026-01-24 12:38:18'),
(4, 'Áo sơ mi nữ họa tiết Abstract Multi-color', 1, 'Sự kết hợp màu sắc hài hòa, tôn dáng người mặc.', 250000, 'assets/img/products/f4.jpg', 50, 1, '2026-01-24 12:38:18'),
(5, 'Áo sơ mi nữ họa tiết Abstract Multi-color', 1, 'Mẫu áo sơ mi bán chạy nhất mùa này với họa tiết hoa.', 230000, 'assets/img/products/f5.jpg', 50, 1, '2026-01-24 12:38:18'),
(6, 'Áo sơ mi nhung tăm phối màu UNISEX', 1, 'Chất liệu nhung tăm dày dặn, phong cách Unisex cá tính.', 270000, 'assets/img/products/f6.jpg', 30, 1, '2026-01-24 12:38:18'),
(7, 'Quần đũi nữ thêu họa tiết', 2, 'Quần đũi mềm mại, ống rộng thoải mái, có thêu họa tiết nhỏ.', 200000, 'assets/img/products/f7.jpg', 60, 1, '2026-01-24 12:38:18'),
(8, 'Áo thun nữ in hình mèo cổ chữ V, dáng rộng', 1, 'Áo thun form rộng năng động, hình in mèo dễ thương.', 230000, 'assets/img/products/f8.jpg', 45, 1, '2026-01-24 12:38:18'),
(9, 'Áo sơ mi nam tay dài cổ trụ vải cotton', 1, 'Sơ mi cổ trụ lịch lãm, chất vải cotton thấm hút mồ hôi.', 300000, 'assets/img/products/n1.jpg', 40, 0, '2026-01-24 12:38:18'),
(10, 'Áo sơ mi nam tay dài vải Cotton', 1, 'Thiết kế basic, màu xám trung tính dễ phối đồ công sở.', 280000, 'assets/img/products/n2.jpg', 40, 0, '2026-01-24 12:38:18'),
(11, 'Áo sơ mi nam tay dài vải Oxford cổ trụ', 1, 'Vải Oxford cao cấp, đứng form, màu trắng tinh tế.', 330000, 'assets/img/products/n3.jpg', 35, 0, '2026-01-24 12:38:18'),
(12, 'Áo sơ mi họa tiết Abstract Multi-color', 1, 'Phiên bản màu cam rực rỡ, nổi bật cho các chuyến du lịch.', 250000, 'assets/img/products/n4.jpg', 40, 0, '2026-01-24 12:38:18'),
(13, 'Áo sơ mi nam tay dài vải Cotton', 1, 'Màu xanh denim nam tính, phù hợp đi làm và đi chơi.', 280000, 'assets/img/products/n5.jpg', 40, 0, '2026-01-24 12:38:18'),
(14, 'Quần Short kẻ sọc nam', 2, 'Quần short form rộng, họa tiết kẻ sọc năng động.', 250000, 'assets/img/products/n6.jpg', 55, 0, '2026-01-24 12:38:18'),
(15, 'Áo sơ mi nam tay dài có túi vải Cotton', 1, 'Thiết kế túi ngực tiện lợi, màu be nhã nhặn.', 280000, 'assets/img/products/n7.jpg', 40, 0, '2026-01-24 12:38:18'),
(16, 'Áo sơ mi nam tay ngắn cổ trụ vải Cotton', 1, 'Phiên bản tay ngắn mát mẻ, cổ trụ trẻ trung.', 300000, 'assets/img/products/n8.jpg', 45, 0, '2026-01-24 12:38:18'),
(17, 'Áo Thun Thời Trang Nam', 1, 'Áo thun nam thời trang với thiết kế hiện đại, chất liệu cotton cao cấp mang lại cảm giác thoải mái và dễ chịu khi mặc. Phù hợp cho mọi dịp từ đi chơi đến dạo phố.', 1200000, 'assets/img/products/f1.jpg', 100, 0, '2026-01-24 14:16:11'),
(18, 'Áo Sơ Mi Demin Nữ Cột Eo Retro', 1, 'Thiết kế áo sơ mi chất liệu denim mềm mại, phong cách retro cổ điển pha lẫn hiện đại.', 285000, 'assets/img/products/prod_1769768433.png', 0, 0, '2026-01-30 17:20:33'),
(19, 'Con rùa', 1, 'Hình ảnh con rùa', 100000, 'assets/img/products/prod_1770881217.jpg', 0, 0, '2026-02-12 14:26:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `role` tinyint DEFAULT '0' COMMENT '0: Khách hàng, 1: Admin',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(5, 'Minh Admin', 'admin@gmail.com', '$2y$10$AHLq1rcU8vV59ZlUGlb0r.K7pcEg80y6IZkzKSW7ONzCHdsnQdJC2', NULL, NULL, 1, '2026-01-30 03:03:54'),
(8, 'Trần Thị Mai Thúy', 'thuyttm0205@gmail.com', '$2y$10$4RV9gKJKs7vswRbk568quOHlc2rLdOa5TNEGHXYxkimkWXC8q4E9C', NULL, NULL, 0, '2026-02-03 03:40:08'),
(9, 'Như Nghĩa', 'ngnhunghia@gmail.com', '$2y$10$IcjLC1w5ABDvRRb.hY6.Vu3g.ZZth5F1lI3QIZdg6DdXAoEmgPQo6', NULL, NULL, 0, '2026-02-12 13:34:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
