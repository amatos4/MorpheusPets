-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2015 at 07:35 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `morpheus_pets`
--
CREATE DATABASE IF NOT EXISTS `morpheus_pets` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `morpheus_pets`;

-- --------------------------------------------------------

--
-- Table structure for table `species`
--

CREATE TABLE IF NOT EXISTS `species` (
  `id` int(11) NOT NULL,
  `species` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `stats` char(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `species`
--

INSERT INTO `species` (`id`, `species`, `type`, `stats`) VALUES
(1, 'Pikachoo', 'Air', 'bgesfr'),
(2, 'Darius', 'Light', 'rfsegb'),
(5, 'Char', 'Fire', 'frbges'),
(6, 'Bulba', 'Earth', 'gebgfs'),
(7, 'Arc', 'Dark', 'fsrebg'),
(8, 'Poly', 'Water', 'bfsreg');

-- --------------------------------------------------------

--
-- Table structure for table `user_pets`
--

CREATE TABLE IF NOT EXISTS `user_pets` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `experience` int(255) NOT NULL,
  `brawn` int(255) NOT NULL,
  `guts` int(255) NOT NULL,
  `essence` int(255) NOT NULL,
  `speed` int(255) NOT NULL,
  `focus` int(255) NOT NULL,
  `grit` int(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `species_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_pets`
--

INSERT INTO `user_pets` (`id`, `name`, `experience`, `brawn`, `guts`, `essence`, `speed`, `focus`, `grit`, `active`, `species_id`, `owner_id`) VALUES
(1, 'Pikachoo', 278, 14, 16, 10, 16, 9, 10, 1, 1, 1),
(2, 'Charmy', 278, 16, 14, 10, 15, 12, 13, 1, 5, 1),
(3, 'Bulbasaur bb', 278, 16, 27, 19, 14, 16, 10, 1, 6, 1),
(7, 'Scoot1', 100, 19, 23, 22, 21, 32, 30, 1, 2, 4),
(8, 'Scoot2', 100, 27, 23, 33, 16, 17, 0, 1, 6, 4),
(9, 'Scoot3', 100, 38, 23, 28, 28, 13, 17, 1, 1, 4),
(10, 'Scoot4', 0, 25, 25, 16, 8, 25, 27, 0, 5, 4),
(11, 'Ayyyyy', 0, 27, 18, 17, 12, 26, 26, 1, 5, 5),
(12, '3Edgy5Me', 0, 12, 10, 27, 24, 25, 28, 1, 7, 5),
(13, 'HYPN0T1Z3', 0, 34, 8, 16, 22, 24, 22, 1, 8, 5),
(14, 'Pikachu', 0, 26, 27, 26, 23, 15, 9, 1, 1, 6),
(15, 'Charmy', 0, 21, 23, 14, 18, 28, 22, 1, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email_address` varchar(320) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `email_address`, `description`) VALUES
(1, 'scoot', '$2y$10$8c0ErCLI5KjZBozNzW0iMeyWnTlOGW/sdzC/oYInzdfnRRY/DApya', 'bleh@bleh.com', 'I''M SCOOT BOW BEFORE ME'),
(4, 'scooty', '$2y$10$LC8oib5dfXK/Dx6OLAy1b.NBhkU.b3doCkmvcWZ9BwVpEBdT5EeUa', 'scoot@scoot.com', 'the scootiest scoot'),
(5, 'dennis', '$2y$10$JnGr5CxJKVYa8JInuMCFjelwHVx5kdw0nUKkS2IK/gjgFCLTBrajC', 'dennis@dennis.com', 'I''m dennis.'),
(6, 'mpeleshe', '$2y$10$tCQ1pOcaTEQghZNNpdynWe41mQEofZBUpujoNyhYzemtlJb6KDjZy', 'mpeleshe@stevens.edu', 'Battle Generation!'),
(7, 'amatos', '$2y$10$6T/8X.ls1zC6TSAl2.53vueY.BY8Y.Fv.BG/C2oBDTCyUbXs6R31u', 'amatos@stevens.edu', 'Are you ready to battle me?'),
(8, 'ntrischi', '$2y$10$CdtJS6JPTP2DHOpZIeJBN.a.y7lmwuawbpPgU7Z7RkIGo106OFlra', 'ntrischi@stevens.edu', 'Time to Battle!'),
(9, 'divy', '$2y$10$gG7lUDdr17M8TOWFcgjVauGEnvsBlE35kjthKavdykPyjKNjy7O/O', 'divy@divy.com', 'Battle Time!');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pets`
--
ALTER TABLE `user_pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `species_id` (`species_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `species`
--
ALTER TABLE `species`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_pets`
--
ALTER TABLE `user_pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_pets`
--
ALTER TABLE `user_pets`
  ADD CONSTRAINT `owner_fk` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `species_fk` FOREIGN KEY (`species_id`) REFERENCES `species` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
