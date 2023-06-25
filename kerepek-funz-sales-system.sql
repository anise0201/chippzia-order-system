-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2023 at 08:23 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kerepek-funz-sales-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_price` decimal(10,2) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_price`, `date_created`, `user_id`, `order_status`) VALUES
(1, '10.99', '2023-06-21 21:35:21', 1, 'COMPLETED'),
(2, '58.91', '2023-06-21 23:44:55', 1, 'COMPLETED');

-- --------------------------------------------------------

--
-- Table structure for table `order_lines`
--

CREATE TABLE `order_lines` (
  `order_line_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_lines`
--

INSERT INTO `order_lines` (`order_line_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 4, 1),
(2, 2, 1, 5),
(3, 2, 2, 2),
(4, 2, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`order_status`) VALUES
('CANCELLED'),
('COMPLETED'),
('PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_code`, `product_image`, `product_price`) VALUES
(1, 'Kerepek Ubi', 'KPKU001', '/assets/images/kerepe-kubi.jpg', '5.99'),
(2, 'Kerepek Pedas', 'KPKP002', '/assets/images/kerepek-pedas.jpg', '6.99'),
(3, 'Kerepek Pisang', 'KPKP003', '/assets/images/kerepek-pisang.jpg', '4.99'),
(4, 'Kerepek Jejari Ubi', 'KJU004', '/assets/images/jejari-ubi%20(2).jpg', '5.99');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_code` varchar(255) NOT NULL,
  `state_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_code`, `state_name`) VALUES
('JHR', 'Johor'),
('KDH', 'Kedah'),
('KL', 'Kuala Lumpur'),
('KTN', 'Kelantan'),
('LBN', 'Labuan'),
('MLK', 'Melaka'),
('NS', 'Negeri Sembilan'),
('PHG', 'Pahang'),
('PJ', 'Putrajaya'),
('PJY', 'Perlis'),
('PNG', 'Penang'),
('PRK', 'Perak'),
('SBH', 'Sabah'),
('SGR', 'Selangor'),
('SWK', 'Sarawak'),
('TRG', 'Terengganu');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(255) DEFAULT NULL,
  `user_lname` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_city` varchar(255) DEFAULT NULL,
  `user_phone` varchar(255) DEFAULT NULL,
  `user_postcode` varchar(255) DEFAULT NULL,
  `state_code` varchar(255) DEFAULT NULL,
  `registration_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fname`, `user_lname`, `username`, `password`, `user_email`, `user_type`, `user_address`, `user_city`, `user_phone`, `user_postcode`, `state_code`, `registration_date`) VALUES
(1, 'ABDUL WAFI', 'CHE AB.RAHIM', 'wafi', '$2y$10$Yk4P3TNRxlBDpvpB7ybSSOcBxXh1nkG/lMWVih5V0UFJOzQvpi0PG', 'wafithird@gmail.com', 'customer', 'PT 10215', 'SITIAWAN', '0108857639', '32000', 'PRK', '2023-06-22 14:06:09'),
(2, 'ABDUL ENTHUAST', 'AB.RAHIM', 'EnthuWafi', '$2y$10$I1OGqU1IrGXz8TkXMpGg.Ocy0npCI8JmY5GZg7d0C6zTZkR7uXhny', 'wafipoop@gmail.com', 'admin', NULL, NULL, NULL, NULL, NULL, '2023-06-22 14:06:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `FK_STATUS` (`order_status`),
  ADD KEY `FK_USER` (`user_id`);

--
-- Indexes for table `order_lines`
--
ALTER TABLE `order_lines`
  ADD PRIMARY KEY (`order_line_id`),
  ADD KEY `FK_PRODUCT` (`product_id`),
  ADD KEY `FK_ORDER` (`order_id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`order_status`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `unique_code` (`product_code`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_STATE` (`state_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_lines`
--
ALTER TABLE `order_lines`
  MODIFY `order_line_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_STATUS` FOREIGN KEY (`order_status`) REFERENCES `order_statuses` (`order_status`),
  ADD CONSTRAINT `FK_USER` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION;

--
-- Constraints for table `order_lines`
--
ALTER TABLE `order_lines`
  ADD CONSTRAINT `FK_ORDER` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PRODUCT` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_STATE` FOREIGN KEY (`state_code`) REFERENCES `states` (`state_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
