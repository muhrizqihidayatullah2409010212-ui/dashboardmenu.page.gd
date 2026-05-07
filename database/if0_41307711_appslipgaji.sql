-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql312.infinityfree.com
-- Generation Time: May 07, 2026 at 01:39 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41307711_appslipgaji`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `nama_menu`, `harga`, `qty`, `subtotal`) VALUES
(21, 8, 'kopi-aren', 15000, 1, 15000),
(22, 8, 'matcha', 18000, 1, 18000);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `token_expire` datetime DEFAULT NULL,
  `otp_code` varchar(10) DEFAULT NULL,
  `otp_expire` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `password`, `reset_token`, `token_expire`, `otp_code`, `otp_expire`) VALUES
(1, '1@1', '$2y$10$Wb5x0OJ.aQqrfYti0Fjefu.DgIjBvGBW5Ohy5u56INEu35haNLWaq', 'b26a6589b0f9111d56dff26d5514f532', '2026-05-01 23:56:28', '404713', '2026-05-05 23:43:24'),
(6, 'dimas@gmail.com', '$2y$10$z6kINdR6t93K9F6EO4fDfu/66kwKH9Pmpi14nGWlyb6YDfwgmCr1a', NULL, NULL, NULL, NULL),
(7, 'admin@admin', '$2y$10$feTAP74ly5gIk7mmI8ZgqukZdCVE.J6rkSe9CvFOmF/ZCyzWsZrXS', '08354101486cf7b9e8062a08f8ff94ec', '2026-05-02 00:09:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `invoice` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `tipe_pesanan` varchar(50) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `invoice`, `tanggal`, `tipe_pesanan`, `metode_pembayaran`, `total`) VALUES
(1, 'RZQ-63346', '2026-04-30 12:18:57', 'Ditempat', 'Cash', 15000),
(2, 'RZQ-23498', '2026-04-30 12:23:53', 'Ditempat', 'Cash', 202000),
(3, 'RZQ-49513', '2026-04-30 12:44:38', 'Ditempat', 'Cash', 30000),
(4, 'RZQ-91005', '2026-05-01 20:05:09', 'Ditempat', 'Cash', 55000),
(5, 'RZQ-68637', '2026-05-01 20:05:20', 'Ditempat', 'QRIS', 8000),
(6, 'RZQ-90611', '2026-05-04 10:57:28', 'Ditempat', 'Cash', 98000),
(7, 'RZQ-95067', '2026-05-05 19:52:48', 'Take Away', 'QRIS', 15000),
(8, 'RZQ-76020', '2026-05-06 09:40:09', 'Take Away', 'Cash', 33000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
