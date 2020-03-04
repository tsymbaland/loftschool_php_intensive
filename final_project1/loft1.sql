-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2020 at 05:06 PM
-- Server version: 5.6.43-log
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loft1`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `dont_call_back` tinyint(1) DEFAULT '0',
  `card_payment` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `comment`, `dont_call_back`, `card_payment`) VALUES
(1, 3, 'street,Sezam,house,64,block,1,appartment,9,floor,3', 'U WOT M8', 0, 0),
(2, 3, 'street,Sezam,house,64,block,1,appartment,9,floor,3', 'U WOT M8', 0, 0),
(3, 4, 'street,sezam,house,23,block,2,apartment,132,floor,12', 'U WOT M8 ?!?!??!', 0, 0),
(4, 4, 'street,sezam,house,23,block,2,apartment,132,floor,12', 'U WOT M8 ?!?!??!', 0, 0),
(5, 4, 'street,sezam,house,23,block,2,apartment,132,floor,12', 'U WOT M8 ?!?!??!', 0, 0),
(6, 4, 'street,sezam,house,23,block,2,apartment,132,floor,12', 'U WOT M8 ?!?!??!', 0, 0),
(7, 5, 'street,q,house,12,block,2,apartment,1,floor,1', 'qqqq', 0, 0),
(8, 4, 'street,,house,13,block,6,apartment,1,floor,1', '13', 1, 0),
(9, 4, 'street,g,house,123,block,,apartment,12,floor,1', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `phone_number`) VALUES
(1, 'a@a.ru', 'a', '8909900000'),
(2, 's@s.ru', 'b', '8-900-000-1234'),
(3, 'd@d.ru', 'd', '8-900-000-1235'),
(4, 'g@g.ru', 'gogi', '+7 (995) 345 34'),
(5, 'q@q.ru', 'q', '+7 (213) 123 13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order-of-user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order-of-user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
