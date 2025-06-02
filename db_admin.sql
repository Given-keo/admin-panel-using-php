-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2025 at 12:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_project_uas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','operator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `nama`, `username`, `password`, `level`) VALUES
(1, 'Given Ezra Dominic Keo', 'given', '$2y$10$X.paRR7TWWFTxTYf2pwOm.7JZYZtqjlqkPl6NlA28pA6ssHD3GvTq', 'admin'),
(2, 'adyl pandu setiawan', 'adyl', '$2y$10$81GdupSXl9/3fjhXKh5jCuBWcmq7dcW24sKIivzL9ipWA6Gc61Jki', 'admin'),
(3, 'rezky agung', 'rezky', '$2y$10$nrEsQJOAP2XJvm5giDbrAe6bGCzDr5PZPi.w9Uit4HP1tW71sWLJq', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `id_gunung` int(11) NOT NULL,
  `id_jalur` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `status` enum('Pending','Confirmed','Canceled') DEFAULT 'Pending',
  `nominal` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `jumlah_orang` int(11) NOT NULL DEFAULT 1,
  `is_entered` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id_booking`, `nama_pemesan`, `id_gunung`, `id_jalur`, `id_paket`, `tanggal_booking`, `status`, `nominal`, `created_at`, `jumlah_orang`, `is_entered`) VALUES
(7, 'Muhamad miftah ulum', 2, 2, 1, '2025-05-13', 'Confirmed', 200000, '2025-05-13 07:49:23', 1, 1),
(8, 'Given Ezra Dominic Keo', 1, 1, 1, '2025-05-13', 'Confirmed', 200000, '2025-05-13 07:51:49', 1, 1),
(9, 'Rayhan Ramadansyah', 2, 2, 1, '2025-05-13', 'Confirmed', 200000, '2025-05-13 08:43:13', 1, 1),
(14, 'Adit Sopo', 1, 1, 1, '2025-05-15', 'Confirmed', 200000, '2025-05-14 18:33:50', 1, 1),
(15, 'Bernard Bear', 1, 1, 1, '2025-05-15', 'Confirmed', 200000, '2025-05-14 18:49:49', 1, 1),
(16, 'Cristiano Ronaldo', 1, 1, 1, '2025-05-15', 'Confirmed', 200000, '2025-05-14 19:09:37', 1, 1),
(17, 'Raka Arkana', 1, 1, 1, '2025-05-15', 'Confirmed', 200000, '2025-05-15 13:13:34', 1, 1),
(18, 'Rezky Agung', 5, 3, 4, '2025-05-19', 'Confirmed', 500000, '2025-05-19 12:13:19', 1, 1),
(19, 'Ical', 5, 3, 4, '2025-05-20', 'Confirmed', 500000, '2025-05-20 06:33:57', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gunung`
--

CREATE TABLE `gunung` (
  `id` int(11) NOT NULL,
  `nama_gunung` varchar(100) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gunung`
--

INSERT INTO `gunung` (`id`, `nama_gunung`, `lokasi`, `deskripsi`, `foto`, `status`, `created_at`) VALUES
(1, 'Gunung Bromo', 'Provinsi Jawa Timur', 'Gunung Bromo atau dalam bahasa Tengger dieja Brama, juga disebut Kaldera Tengger, adalah sebuah gunung berapi aktif di Jawa Timur, Indonesia. Gunung ini memiliki ketinggian 2.614 meter.', 'uploads/gunung-bromo.jpg', 'active', '2025-05-10 06:21:28'),
(2, 'Gunung Rinjani', 'Provinsi Nusa Tenggara Barat', 'Gunung Rinjani adalah gunung yang berlokasi di Pulau Lombok, Nusa Tenggara Barat. Gunung yang merupakan gunung berapi kedua tertinggi di Indonesia dengan ketinggian 3.726', 'uploads/gunung-rinjani.jpeg', 'active', '2025-05-10 06:23:32'),
(3, 'Gunung Semeru', 'Provinsi Jawa Timur', 'tes', 'uploads/semeru.jpeg', 'active', '2025-05-11 19:25:04'),
(5, 'Gunung Gede', 'Provinsi Jawa Barat', 'testing', 'uploads/gunung-gede.jpg', 'active', '2025-05-19 12:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `jalur`
--

CREATE TABLE `jalur` (
  `id` int(11) NOT NULL,
  `id_gunung` int(11) NOT NULL,
  `nama_jalur` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jalur`
--

INSERT INTO `jalur` (`id`, `id_gunung`, `nama_jalur`, `deskripsi`, `status`, `created_at`) VALUES
(1, 1, 'Cemoro Lawang', 'Jalur Cemoro Lawang merupakan rute pendakian paling populer dan mudah diakses menuju Gunung Bromo, terutama bagi wisatawan yang datang dari arah Probolinggo. Desa Cemoro Lawang sendiri berada di ketinggian sekitar 2.200 mdpl ', 'aktif', '2025-05-10 06:33:38'),
(2, 2, 'Sembalun', 'Jalur Sembalun adalah salah satu rute pendakian paling populer menuju Gunung Rinjani di Lombok, Nusa Tenggara Barat. ', 'aktif', '2025-05-10 06:36:12'),
(3, 5, 'Jalur Via Putri', 'Di bogor', 'aktif', '2025-05-19 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `kuota`
--

CREATE TABLE `kuota` (
  `id` int(11) NOT NULL,
  `id_gunung` int(11) NOT NULL,
  `id_jalur` int(11) NOT NULL,
  `jumlah_kuota` int(11) NOT NULL,
  `status` enum('tersedia','habis') DEFAULT 'tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kuota`
--

INSERT INTO `kuota` (`id`, `id_gunung`, `id_jalur`, `jumlah_kuota`, `status`, `created_at`, `updated_at`) VALUES
(3, 2, 2, 30, 'tersedia', '2025-05-13 16:02:53', '2025-05-13 16:02:53'),
(4, 1, 1, 30, 'tersedia', '2025-05-13 16:02:53', '2025-05-13 16:02:53'),
(6, 5, 3, 30, 'tersedia', '2025-05-19 12:12:09', '2025-05-19 12:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `id_gunung` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `durasi_hari` int(11) NOT NULL,
  `harga` int(255) NOT NULL,
  `fasilitas` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id`, `id_gunung`, `nama_paket`, `durasi_hari`, `harga`, `fasilitas`, `status`, `created_at`) VALUES
(1, 1, 'Paket Wisata Tour Pendakian ', 3, 200000, 'transportasi dari titik pertemuan, perlengkapan camping premium, pemandu lokal bersertifikat, makanan bergizi selama pendakian, serta dokumentasi foto dan video profesional.', 'aktif', '2025-05-10 06:42:37'),
(4, 5, 'Paket Private Trip', 2, 500000, 'makan, minum, camping', 'aktif', '2025-05-19 12:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `payment_status` enum('Lunas','Belum Lunas','Pending') NOT NULL,
  `confirmation_date` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `payment_date`, `amount`, `payment_method_id`, `payment_status`, `confirmation_date`, `notes`, `created_at`) VALUES
(6, 7, '2025-05-13', 200000.00, 2, 'Lunas', NULL, NULL, '2025-05-13 07:49:37'),
(7, 8, '2025-05-13', 200000.00, 3, 'Lunas', NULL, NULL, '2025-05-13 07:52:05'),
(8, 9, '2025-05-13', 200000.00, 2, 'Lunas', NULL, NULL, '2025-05-13 08:43:34'),
(14, 14, '2025-05-14', 200000.00, 3, 'Lunas', NULL, NULL, '2025-05-14 18:34:34'),
(15, 15, '2025-05-15', 200000.00, 1, 'Lunas', NULL, NULL, '2025-05-14 18:50:07'),
(16, 16, '2025-05-15', 200000.00, 1, 'Lunas', NULL, NULL, '2025-05-14 19:10:07'),
(17, 17, '2025-05-15', 200000.00, 1, 'Lunas', NULL, NULL, '2025-05-15 13:14:03'),
(18, 18, '2025-05-19', 500000.00, 2, 'Lunas', NULL, NULL, '2025-05-19 12:13:48'),
(19, 19, '2025-05-20', 500000.00, 1, 'Lunas', NULL, NULL, '2025-05-20 06:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method_name`, `is_active`, `created_at`) VALUES
(1, 'Mandiri', 1, '2025-05-12 12:12:13'),
(2, 'BCA', 1, '2025-05-12 12:12:13'),
(3, 'OVO', 1, '2025-05-12 12:12:13'),
(4, 'Tunai', 1, '2025-05-12 12:12:13'),
(12, 'BRI', 1, '2025-05-19 12:14:14'),
(13, 'BNI', 1, '2025-05-31 13:55:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_gunung` (`id_gunung`),
  ADD KEY `id_jalur` (`id_jalur`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indexes for table `gunung`
--
ALTER TABLE `gunung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jalur`
--
ALTER TABLE `jalur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_gunung` (`id_gunung`);

--
-- Indexes for table `kuota`
--
ALTER TABLE `kuota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_gunung` (`id_gunung`),
  ADD KEY `id_jalur` (`id_jalur`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_gunung` (`id_gunung`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `gunung`
--
ALTER TABLE `gunung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jalur`
--
ALTER TABLE `jalur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kuota`
--
ALTER TABLE `kuota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_gunung`) REFERENCES `gunung` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`id_jalur`) REFERENCES `jalur` (`id`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`id_paket`) REFERENCES `paket` (`id`);

--
-- Constraints for table `jalur`
--
ALTER TABLE `jalur`
  ADD CONSTRAINT `jalur_ibfk_1` FOREIGN KEY (`id_gunung`) REFERENCES `gunung` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kuota`
--
ALTER TABLE `kuota`
  ADD CONSTRAINT `kuota_ibfk_1` FOREIGN KEY (`id_gunung`) REFERENCES `gunung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kuota_ibfk_2` FOREIGN KEY (`id_jalur`) REFERENCES `jalur` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `paket`
--
ALTER TABLE `paket`
  ADD CONSTRAINT `paket_ibfk_1` FOREIGN KEY (`id_gunung`) REFERENCES `gunung` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id_booking`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
