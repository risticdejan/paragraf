-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 15, 2019 at 07:15 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paragraf`
--

-- --------------------------------------------------------

--
-- Table structure for table `osiguranici`
--

CREATE TABLE `osiguranici` (
  `id` int(10) UNSIGNED NOT NULL,
  `puno_ime` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `datum_rodjenja` datetime NOT NULL,
  `broj_pasosa` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `nosioc_id` int(10) UNSIGNED DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefon` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `osiguranici`
--

INSERT INTO `osiguranici` (`id`, `puno_ime`, `datum_rodjenja`, `broj_pasosa`, `nosioc_id`, `email`, `telefon`) VALUES
(3, 'dejan ristić', '1977-10-26 00:00:00', '008090101', NULL, 'dejanr77@yahoo.com', NULL),
(4, 'žarko ristić', '2013-08-14 00:00:00', '000112300', 3, NULL, NULL),
(5, 'saša ristić', '2017-07-20 00:00:00', '000222001', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `polise`
--

CREATE TABLE `polise` (
  `id` int(10) UNSIGNED NOT NULL,
  `datum_polaska` datetime NOT NULL,
  `datum_dolaska` datetime NOT NULL,
  `datum_unosa` datetime DEFAULT CURRENT_TIMESTAMP,
  `tip_polise` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `nosioc_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `polise`
--

INSERT INTO `polise` (`id`, `datum_polaska`, `datum_dolaska`, `datum_unosa`, `tip_polise`, `nosioc_id`) VALUES
(3, '2019-08-22 00:00:00', '2019-08-31 00:00:00', '2019-08-15 07:14:06', '2', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `osiguranici`
--
ALTER TABLE `osiguranici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polise`
--
ALTER TABLE `polise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_polise_osiguranici_idx` (`nosioc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `osiguranici`
--
ALTER TABLE `osiguranici`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `polise`
--
ALTER TABLE `polise`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `polise`
--
ALTER TABLE `polise`
  ADD CONSTRAINT `fk_polise_osiguranici` FOREIGN KEY (`nosioc_id`) REFERENCES `osiguranici` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
