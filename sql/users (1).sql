-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2018 at 10:56 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `map`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permissions` int(1) UNSIGNED DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `permissions`, `email`, `join_date`) VALUES
(2, 'Testman', '', '$2y$10$REnYPy3rrjVVa74/3gnof.Sx5Pq5CF6lGaSPMwreh9eDM95Fi95MG', NULL, '', '2018-11-30 19:50:32'),
(3, 'mapYang21', '', '$2y$10$047CmBPzp6MJyw747rq/0OsC9.6jfFRiMAFcbgp/oae4j/fBzCMse', 1, 'mapYang21@gmail.com', '2018-11-30 01:58:20'),
(4, 'demodemo', '', '$2y$10$/GCGnowbZjwMk1wEvGRWFOpzaQE8Matc./usAqhBtp/s9PnTQa5ei', 1, 'demodemo@gmail.cn', '2018-11-30 02:54:58'),
(5, 'cdchessmore', '', '$2y$10$xSpbJ6GGFUNdwDLGWhtIcem1YAGmVmcxZXTgxupVxP2tJGXJU3upK', 1, 'cdchessmore@mail.fhsu.edu', '2018-11-30 03:42:06'),
(6, 'Conner', 'Chessmore', '$2y$10$JmU7XL0veFmF3rPv5F5yOuM09OdX7am8R725VMa.5h5q9yXwGaQ3m', 1, 'cchess2014@hotmail.com', '2018-12-03 08:10:00'),
(7, 'Testy', 'Test', '$2y$10$Uh7BghfJ6NMep24zEzjcXObIlxmqHWRsx8g88uBiAm.EjpNTkhqdu', 0, 'supertest@test.net', '2018-12-03 21:00:00'),
(8, 'bob', 'the builder', '$2y$10$B2c2WwapzdJwX.7TkBvjje0oOA65CxBrlCnY602f8zdRQKbzUWKd2', NULL, 'bob@builder.com', '2018-12-03 09:01:11');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
