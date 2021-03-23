-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2019 at 09:18 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biod`
--

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `website` varchar(63) NOT NULL,
  `login` varchar(31) NOT NULL,
  `password` varchar(511) NOT NULL,
  `login_fails` varchar(8) NOT NULL,
  `banned_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `user_id`, `website`, `login`, `password`, `login_fails`, `banned_at`) VALUES
(8, 2, 'wp.pl', 'd', 'd', '', '0000-00-00 00:00:00'),
(11, 1, 'google', 'test', 'U2FsdGVkX1+K9qoAN2tNFYyYM1Y29Wq3C+960vinc7Y=', '', '0000-00-00 00:00:00'),
(12, 3, 'user', '1234', 'U2FsdGVkX1+yuyIZhj3Auyol9qhDZDVdhpA8DyH6fhU=', '', '0000-00-00 00:00:00'),
(13, 1, 'test', '1234', 'U2FsdGVkX1+IjzVO12ohw80yczfe73rCQZgVJXbsG2M=', '', '0000-00-00 00:00:00'),
(14, 4, 'test', '1234', 'U2FsdGVkX18MaP/USLe6Wyk74jIxsOTtwxWHQOXry+I=', '', '0000-00-00 00:00:00'),
(15, 4, 'asdf', 'asdf', 'U2FsdGVkX1843TdniNkr7S4/j/OZoqGnQG66VV/BYWU=', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `Login` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Imie` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Nazwisko` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `login_fails` int(11) DEFAULT NULL,
  `banned_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `Login`, `Password`, `Imie`, `Nazwisko`, `login_fails`, `banned_at`) VALUES
(1, 'admin', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Dawid', 'Twardowski', NULL, NULL),
(2, 'regtest', '202cb962ac59075b964b07152d234b70', 'regimie', 'regnazwisko', NULL, NULL),
(3, 'testuser', 'c024c1fcea90c743cf8d55b5fa8c3a236a73a894b065d182a2d5bd5de848d2b6', '1234', '1234', 1, NULL),
(4, 'dawid', '34b37f1e6f801286d05a7818adf5c4f7542fff8a5d719bb3d832b7fa3bae4363', 'dawid', 'dawid', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_account_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `fk_account_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
