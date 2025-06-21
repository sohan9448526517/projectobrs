-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 01:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `obrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `bikes`
--

CREATE TABLE `bikes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bikes`
--

INSERT INTO `bikes` (`id`, `name`, `city`, `price_per_day`, `image_path`, `description`) VALUES
(1, 'Royal Enfield Classic', 'Bangalore', 700.00, 'img/royalenfield.jpg', 'beast'),
(2, 'Honda Activa 125', 'Mysore', 500.00, 'img/honda.jpeg', 'Perfect for city rides.'),
(3, 'Bajaj Pulsar NS200', 'Hubli', 650.00, 'img/pulsar.jpg', 'Sporty and stylish.'),
(4, 'KTM Rc 390', 'Bangalore', 700.00, 'img/ktm.jpg', 'High performance supersports machine.'),
(5, 'Himalayan 450', 'Bangalore', 800.00, 'img/himalayan.jpg', 'Sports touring bike.'),
(6, 'TVS Ntorq', 'Mysore', 400.00, 'img/tvsntorq.jpg', 'Great for city rides.'),
(7, 'Duke', 'Hubli', 500.00, 'img/duke.png', 'sports bike'),
(8, 'Apache RTR', 'Mysore', 500.00, 'img/apache.jpg', 'High performance machine'),
(9, 'FZ', 'Hubli', 400.00, 'img/FZ.jpg', 'perfect city ride'),
(10, 'Hero-pleasure', 'Mangalore', 200.00, 'img/Hero-Pleasure.jpg', 'High Mileage scooty'),
(11, 'Pulsar-220', 'Mangalore', 400.00, 'img/pulsar-220.jpg', 'Definitely Male'),
(12, 'Fascino-125', 'Mangalore', 350.00, 'img/Fascino.jpg', 'Emphasizes the scooter style design'),
(13, 'TVS Jupiter125', 'Belgaum', 400.00, 'img/TVS Jupiter 125.jpg', 'Zyada Se Bhi Zyada'),
(14, 'Pulsar 150', 'Belgaum', 500.00, 'img/bajaj-pulsar-150cc.jpg', 'Definitely Male'),
(15, 'Bajaj-Avenger220', 'Belgaum', 600.00, 'img/bajaj avenger.jpg', 'Feel Like God'),
(16, 'Platina 125', 'Belgaum', 400.00, 'img/platina 125.jpg', 'The Perfect Blend of Comfort and Mileage'),
(17, 'Yamaha R15', 'Belgaum', 1000.00, 'img/r15.jpg', 'Revs Your Heart'),
(18, 'Splendor', 'Mangalore', 200.00, 'img/splendor.jpg', 'Feels like family'),
(19, 'OLA-S1-pro', 'Bangalore', 300.00, 'img/OLA-S1-Pro.jpg', 'Engineered to Thrill'),
(20, 'Ather 450x', 'Bangalore', 250.00, 'img/Ather.jpg', 'Bike of Scooters'),
(21, 'Aprilla-SR160', 'Bangalore', 400.00, 'img/Aprilla sr160.jpg', 'Be a Racer'),
(22, 'Continental GT 650', 'Mysore', 1000.00, 'img/continantial gt 650.jpg', 'Retro Racer Dreams Unlocked'),
(23, 'Honda Dio', 'Mysore', 300.00, 'img/dio.jpg', 'Dio Wanna Have Fun'),
(24, 'Vespa', 'Mysore', 400.00, 'img/vespa.jpg', 'Lets Vespa'),
(25, 'Royal Enfiels Hunter 350', 'Hubli', 700.00, 'img/royal enfield hunter 350.jpg', 'Hunter 350 KeepHunting'),
(26, 'Ather Rizta', 'Hubli', 400.00, 'img/ather-rizta.jpg', 'The Best Family EV Scooter'),
(27, 'Harley-Davidson', 'Hubli', 1000.00, 'img/harley davidson.jpg', 'All for Freedom,Freedom for All'),
(28, 'Himalayan', 'Mangalore', 800.00, 'img/Himalayan1.jpg', 'wellness in Every Home'),
(29, 'Suzuki Gixxer-250', 'Mangalore', 600.00, 'img/suzuki.jpg', 'Best in the World'),
(30, 'Shine-125', 'Belgaum', 300.00, 'uploads/1748749477_shine.jpg', 'Mileage bike'),
(31, 'Jawa 350', 'Hubli', 800.00, 'uploads/1748749494_jawa.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `price_at_booking` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `bike_id`, `user_id`, `customer_name`, `phone`, `start_date`, `end_date`, `status`, `created_at`, `price_at_booking`) VALUES
(1, 1, 1, 'SOHAN SURE', '9448423985', '2025-05-28', '2025-05-30', 'status-confirmed', '2025-05-28 09:17:16', 700.00),
(2, 2, 1, 'SOHAN SURE', '9448423985', '2025-05-28', '2025-05-28', 'status-confirmed', '2025-05-28 09:22:24', 500.00),
(3, 4, 1, 'SOHAN SURE', '9448423985', '2025-05-28', '2025-05-30', 'status-confirmed', '2025-05-28 12:42:10', 700.00),
(4, 11, 1, 'SOHAN SURE', '9448423985', '2025-05-28', '2025-05-30', 'status-confirmed', '2025-05-28 14:54:37', 400.00),
(5, 10, 1, 'SOHAN SURE', '9448423985', '2025-05-28', '2025-05-28', 'status-confirmed', '2025-05-28 15:08:53', 200.00),
(6, 7, 1, 'SOHAN SURE', '9448423985', '2025-05-29', '2025-05-30', 'status-confirmed', '2025-05-29 13:12:34', 500.00),
(7, 13, 1, 'SOHAN SURE', '9448423985', '2025-05-29', '2025-05-29', 'status-confirmed', '2025-05-29 13:48:46', 400.00),
(8, 28, 1, 'SOHAN SURE', '9448423985', '2025-05-30', '2025-06-01', 'status-confirmed', '2025-05-30 08:46:12', 800.00),
(9, 5, 1, 'SOHAN SURE', '9448423985', '2025-05-30', '2025-06-01', 'status-confirmed', '2025-05-30 08:48:21', 800.00),
(10, 14, 1, 'SOHAN SURE', '9448423985', '2025-05-30', '2025-05-31', 'status-confirmed', '2025-05-30 16:03:26', 500.00),
(11, 18, 1, 'sohan SURE', '9448526517', '2025-06-01', '2025-06-01', 'status-confirmed', '2025-06-01 04:23:50', 200.00),
(12, 28, 1, 'sohan sure', '9448526517', '2025-06-02', '2025-06-04', 'Cancelled', '2025-06-02 06:57:16', 800.00),
(13, 29, 1, 'sohan sure', '9448526517', '2025-06-02', '2025-06-04', 'Cancelled', '2025-06-02 10:53:23', 600.00),
(14, 23, 1, 'sohan sure', '9448526517', '2025-06-03', '2025-06-03', 'Cancelled', '2025-06-03 01:31:40', 300.00),
(15, 11, 1, 'sohan sure', '9448526517', '2025-06-03', '2025-06-05', 'status-confirmed', '2025-06-03 05:53:01', 400.00),
(16, 26, 1, 'sohan sure', '9448526517', '2025-06-03', '2025-06-05', 'status-confirmed', '2025-06-03 06:20:00', 400.00),
(17, 21, 1, 'sohan sure', '9448526517', '2025-06-03', '2025-06-05', 'status-confirmed', '2025-06-03 07:04:08', 400.00),
(18, 10, 1, 'sohan sure', '9448526517', '2025-06-03', '2025-06-05', 'status-confirmed', '2025-06-03 07:08:01', 200.00),
(19, 20, 1, 'sohan sure', '9448526517', '2025-06-03', '2025-06-05', 'status-confirmed', '2025-06-03 07:22:27', 250.00),
(20, 19, 4, 'sujan jannu', '9071559573', '2025-06-03', '2025-06-05', 'status-confirmed', '2025-06-03 09:41:16', 300.00);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(2, 'ADMIN'),
(1, 'USER');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(64) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `roles` varchar(20) NOT NULL DEFAULT 'CUSTOMER',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `aadhaar_number` varchar(12) DEFAULT NULL,
  `license_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `phone_number`, `email`, `password`, `first_name`, `last_name`, `created_at`, `roles`, `status`, `aadhaar_number`, `license_number`) VALUES
(1, '9448526517', 'sohanvijaykumarsure@gmail.com', '$2y$10$xatl83K7cWjviKNWNU0V4unjNpAS0eIt5Ai5W7pmsmnf0qy6roJhm', 'sohan', 'sure', '2025-05-26 09:13:16', 'CUSTOMER', 'ACTIVE', '312657655150', ''),
(2, '9481010462', 'vijay123@gmail.com', '$2y$10$49RgrCqTXGngaLFqEdMi3u5Q6yGmyoHPmBJe7CPHu5SUc419qkj1m', 'Vijay', 'BH', '2025-05-30 08:50:11', 'CUSTOMER', 'active', NULL, NULL),
(3, '6001827302', 'lamurong@gmail.com', '$2y$10$81uHAmsJ67sODLKnxXCqDOGHMJcvz/KRKimlW3C9gqYp/DOf8eJiy', 'afrom1', 'lamurong', '2025-06-03 06:29:35', 'CUSTOMER', 'ACTIVE', NULL, NULL),
(4, '9071559573', 'sujan@gmail.com', '$2y$10$vtCSqEG3IxunSd6ZDIUi4uFnOfl.YalAhbf1r1alL9S6MY5aiexe2', 'sujan', 'jannu', '2025-06-03 09:38:23', 'CUSTOMER', 'active', '206737029160', 'KA6320230004841');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 1),
(4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bikes`
--
ALTER TABLE `bikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bike_users` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_roles_name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD UNIQUE KEY `uq_users_phone_number` (`phone_number`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_users_roles_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bikes`
--
ALTER TABLE `bikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bike_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `fk_users_roles_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_users_roles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
