-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 14 jun 2021 om 12:25
-- Serverversie: 10.4.17-MariaDB-cll-lve
-- PHP-versie: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `michaib313_Protocoil`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `firstname`, `lastname`) VALUES
(5, 'test@test.com', '$2y$14$ipGv3GxHa8bZvp1piSzUQOmkSzurnaEL2ZKLm4d/w.S3WF8psrnzK', 'test', 'test');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `jacket`
--

CREATE TABLE `jacket` (
  `id` int(11) NOT NULL,
  `GPSX` decimal(65,0) NOT NULL,
  `GPSY` decimal(65,0) NOT NULL,
  `GPSZ` decimal(65,0) NOT NULL,
  `alert` tinyint(1) NOT NULL COMMENT '0 = gezond',
  `active` tinyint(1) NOT NULL COMMENT '0 = niet in gebruik',
  `wet` tinyint(1) NOT NULL COMMENT '0 = droog',
  `lastCheckIn` date NOT NULL COMMENT 'laatste pin (check elke 10min)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jacket_id` int(11) NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `alert` tinyint(1) NOT NULL,
  `wet` tinyint(1) NOT NULL,
  `GPSX` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GPSY` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastCheckIn` date NOT NULL,
  `fallDirection` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fallTime` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `jacket_id`, `email`, `avatar`, `active`, `alert`, `wet`, `GPSX`, `GPSY`, `lastCheckIn`, `fallDirection`, `fallTime`) VALUES
(1, 'Gregory', 'Cloetens', 5, 'greg@test.com', '../images/user.png', 1, 0, 0, '0', '0', '0000-00-00', NULL, NULL),
(2, 'Michael', 'Storms', 1, 'ducky@test.com', '../images/user.png', 1, 1, 0, '0', '0', '0000-00-00', '6', 17),
(3, 'Tommy', 'Hollander', 6, 'tomtom@test.com', '../images/user.png', 0, 1, 0, '51.258520', '4.362005', '0000-00-00', NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `jacket`
--
ALTER TABLE `jacket`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `jacket`
--
ALTER TABLE `jacket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
