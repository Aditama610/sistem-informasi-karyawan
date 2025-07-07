-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2025 at 03:05 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jab` int NOT NULL,
  `nama_jab` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jab`, `nama_jab`) VALUES
(1, 'Staf HRD'),
(2, 'Staf Finance'),
(3, 'Kepala Bagian'),
(4, 'Supervisor'),
(5, 'Direktur'),
(6, 'Kru');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_kar` int NOT NULL,
  `no_induk` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `foto` blob NOT NULL,
  `id_jab` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_kar`, `no_induk`, `nama`, `foto`, `id_jab`) VALUES
(43, '12344', 'diana', 0x74342e6a7067, 4),
(44, '821712', 'Aditama Fadillah', 0x74322e6a7067, 3),
(45, '8745f', 'ardian', 0x74332e6a7067, 5),
(46, '3484hd', 'Rina', 0x74352e6a7067, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `email`, `pass`) VALUES
(1, 'dina', 'aaa@afafa', '$2y$10$QXhYhY1ZYURpVLQ0MHe2CevWxvl/trdQwgCOAfnDUSnHt0ELqg8oy'),
(5, 'dina', 'AcerA5142023@outlook.com', '$2y$10$NkNP36eJWKBJHpqxoe0MnesJf4JvNlPmf9Xw8Q3AINscMDV9hqhX6'),
(8, 'aditaam', 'aditamamuhammad8@gmail.com', '$2y$10$3PvUwMtd80O70yMxacS4.e7ccWAb3xuyT2zH4lD7eXg820.P5dVxq'),
(9, 'banisa', 'adkjdk@nf', '$2y$10$tkT5Y7OgNqXWTPhMai4XkO2CduXNJchPxPCCPBEHpo45.KRjGFdA2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jab`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_kar`),
  ADD KEY `id_jab` (`id_jab`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_kar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_jab`) REFERENCES `jabatan` (`id_jab`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
