-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 08 nov 2021 om 10:33
-- Serverversie: 10.4.20-MariaDB
-- PHP-versie: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `winkel`
--
CREATE DATABASE IF NOT EXISTS `Klantenservice` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `Klantenservice`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE OR REPLACE TABLE `klant` (
  `nummer` SMALLINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `naam` varchar(50) NOT NULL,
  `woonplaats` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`nummer`, `naam`, `woonplaats`) VALUES
(1, 'Teije van \'t Hart', 'Deventer'),
(2, 'Pim Marijnnissen', 'Zwolle'),
(3, 'Eddie Adelaar', 'Deventer'),
(4, 'Marnix Koller', 'Olst'),
(5, 'Alexandra Schalke', 'Breda');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
