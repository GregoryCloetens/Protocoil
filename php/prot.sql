-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 26, 2021 at 07:28 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prot`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `firstname`, `lastname`) VALUES
(5, 'test@test.com', '$2y$14$ipGv3GxHa8bZvp1piSzUQOmkSzurnaEL2ZKLm4d/w.S3WF8psrnzK', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `jacket`
--

DROP TABLE IF EXISTS `jacket`;
CREATE TABLE IF NOT EXISTS `jacket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `GPSX` decimal(65,0) NOT NULL,
  `GPSY` decimal(65,0) NOT NULL,
  `GPSZ` decimal(65,0) NOT NULL,
  `alert` tinyint(1) NOT NULL COMMENT '0 = gezond',
  `active` tinyint(1) NOT NULL COMMENT '0 = niet in gebruik',
  `wet` tinyint(1) NOT NULL COMMENT '0 = droog',
  `lastCheckIn` date NOT NULL COMMENT 'laatste pin (check elke 10min)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `jacket_id` int(11) NOT NULL,
  `email` varchar(300) NOT NULL,
  `avatar` varchar(300) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `alert` tinyint(1) NOT NULL,
  `wet` tinyint(1) NOT NULL,
  `GPSX` varchar(300) NOT NULL,
  `GPSY` varchar(300) NOT NULL,
  `lastCheckIn` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `jacket_id`, `email`, `avatar`, `active`, `alert`, `wet`, `GPSX`, `GPSY`, `lastCheckIn`) VALUES
(1, 'Gregory', 'Cloetens', 4, 'greg@test.com', '../images/user.png', 1, 0, 0, '51.251397', '4.353256', '0000-00-00'),
(2, 'Michael', 'Storms', 5, 'ducky@test.com', '../images/user.png', 1, 1, 0, '51.252257', '4.376589', '0000-00-00'),
(3, 'Tommy', 'Hollander', 6, 'tomtom@test.com', '../images/user.png', 0, 0, 0, '51.258520', '4.362005', '0000-00-00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
