-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2017 at 09:33 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ajari`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
`id_booking` int(8) NOT NULL,
  `id_user` int(8) NOT NULL,
  `id_mapel` int(8) NOT NULL,
  `status` enum('tunggu','konfirmasi','batal','selesai') NOT NULL,
  `id_mentor` int(8) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alamat` varchar(64) NOT NULL,
  `catatan` varchar(256) NOT NULL,
  `jumlah_siswa` int(2) NOT NULL,
  `durasi` int(1) NOT NULL,
  `biaya` int(8) NOT NULL,
  `kode_booking` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id_booking`, `id_user`, `id_mapel`, `status`, `id_mentor`, `tanggal`, `jam_mulai`, `create_at`, `alamat`, `catatan`, `jumlah_siswa`, `durasi`, `biaya`, `kode_booking`) VALUES
(1, 1, 8, 'konfirmasi', NULL, '2017-11-20', '13:38:00', '2017-11-20 07:02:43', 'perum tanjung raya', 'bawa spidol sendiri', 3, 2, 90000, '5472c0488c962f86864685bf10e110ef87018d85'),
(2, 1, 8, 'batal', NULL, '2017-11-20', '13:38:00', '2017-11-20 07:03:33', 'perum tanjung raya', 'bawa spidol sendiri', 3, 2, 90000, '86328855f04d213ae473b8f709ff4b9426a393c9'),
(3, 1, 1, 'tunggu', NULL, '2017-11-20', '18:00:00', '2017-11-20 06:39:40', 'Purwokerto', 'df', 1, 1, 30000, '3634fd5e44bff515723a158987701064488961c9'),
(4, 1, 4, 'selesai', NULL, '2017-11-20', '13:39:00', '2017-11-20 07:03:38', 'sokaraja polres', 'bawa makanan', 3, 3, 120000, '4e2dd20c33f75cebf273b701684dca9eee5f712a'),
(5, 1, 4, 'tunggu', NULL, '2017-11-20', '13:39:00', '2017-11-20 06:40:21', 'sokaraja polres', 'bawa makanan', 3, 3, 120000, '164b899cfde2d565edba79ed61a1e93f6f02581f');

-- --------------------------------------------------------

--
-- Table structure for table `durasi`
--

CREATE TABLE IF NOT EXISTS `durasi` (
`id_durasi` int(8) NOT NULL,
  `durasi` int(2) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `show` enum('0','1') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `durasi`
--

INSERT INTO `durasi` (`id_durasi`, `durasi`, `create_at`, `show`) VALUES
(1, 1, '2017-11-08 01:31:19', '1'),
(2, 2, '2017-11-08 01:31:25', '1'),
(3, 3, '2017-11-08 01:31:30', '1');

-- --------------------------------------------------------

--
-- Table structure for table `harga_penimbang`
--

CREATE TABLE IF NOT EXISTS `harga_penimbang` (
`id_harga` int(8) NOT NULL,
  `harga_penimbang` int(8) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jumlah_murid`
--

CREATE TABLE IF NOT EXISTS `jumlah_murid` (
`id_jumlah_murid` int(8) NOT NULL,
  `jumlah` int(2) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `show` enum('0','1') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jumlah_murid`
--

INSERT INTO `jumlah_murid` (`id_jumlah_murid`, `jumlah`, `create_at`, `show`) VALUES
(1, 1, '2017-11-08 01:35:25', '1'),
(2, 2, '2017-11-08 01:35:25', '1'),
(3, 3, '2017-11-08 01:35:25', '1'),
(4, 4, '2017-11-08 01:35:25', '1');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
`id_kategori` int(8) NOT NULL,
  `nama_kategori` varchar(16) NOT NULL,
  `icon` varchar(64) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `show` enum('0','1') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `icon`, `create_at`, `show`) VALUES
(1, 'SD', 'sd.png', '2017-11-08 00:45:52', '1'),
(2, 'SMP', 'smp.png', '2017-11-08 00:47:03', '1'),
(3, 'SMA', 'sma.png', '2017-11-08 00:47:14', '1'),
(4, 'Mengaji', 'mengaji.png', '2017-11-08 00:47:03', '1'),
(5, 'Musik', 'musik.png', '2017-11-08 00:47:03', '1'),
(6, 'Melukis', 'lukis.png', '2017-11-20 07:02:18', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE IF NOT EXISTS `mapel` (
`id_mapel` int(8) NOT NULL,
  `nama_mapel` varchar(32) NOT NULL,
  `id_kategori` int(8) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `show` enum('0','1') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`, `id_kategori`, `create_at`, `show`) VALUES
(1, 'Matematika', 1, '2017-11-08 00:48:22', '1'),
(2, 'Bahasa Inggris', 1, '2017-11-08 00:48:31', '1'),
(3, 'IPA', 1, '2017-11-08 00:48:22', '1'),
(4, 'Matematika', 2, '2017-11-08 00:49:15', '1'),
(5, 'Bahasa Inggris', 2, '2017-11-08 00:49:15', '1'),
(6, 'IPA', 2, '2017-11-08 00:49:15', '1'),
(7, 'IPS', 2, '2017-11-08 00:49:15', '1'),
(8, 'Matematika', 3, '2017-11-08 00:50:26', '1'),
(9, 'Bahasa Inggris', 3, '2017-11-08 00:50:26', '1'),
(10, 'Kimia', 3, '2017-11-08 00:50:26', '1'),
(11, 'Fisika', 3, '2017-11-08 00:50:26', '1'),
(12, 'Akuntansi', 3, '2017-11-08 00:50:26', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mentors`
--

CREATE TABLE IF NOT EXISTS `mentors` (
`id_mentor` int(8) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `telepon` varchar(16) NOT NULL,
  `path_foto` varchar(128) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mentors`
--

INSERT INTO `mentors` (`id_mentor`, `email`, `username`, `password`, `telepon`, `path_foto`, `create_at`) VALUES
(1, 'adi.dharma@gmail.com', 'Adi Dharma', '$2y$10$QQHmWiOQXuZHIE8HuEyjqukOBHJUS2t7zSB5VlKNfFYIe6WFyLZe.', '08126766443', '', '2017-11-07 04:24:00'),
(2, 'shinta@gmail.com', 'Sinta Aditya', '$2y$10$PRCjcxdq.3H7hq9Z9TQO2.cw0gis9N58f/aSVB6q6WYT7va9UXee6', '08126766443', '', '2017-11-07 04:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2017_10_30_093652_create_voucher_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `spesifikasi_mentor`
--

CREATE TABLE IF NOT EXISTS `spesifikasi_mentor` (
`id_spesifikasi` int(8) NOT NULL,
  `id_mentor` int(8) NOT NULL,
  `id_mapel` int(8) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(8) NOT NULL,
  `email` varchar(128) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `path_foto` varchar(128) NOT NULL,
  `telepon` varchar(16) NOT NULL,
  `id_verification` varchar(128) NOT NULL,
  `type` enum('phone','google','fb') DEFAULT NULL,
  `qr_code` varchar(128) NOT NULL,
  `jenis_kelamin` varchar(2) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `path_foto`, `telepon`, `id_verification`, `type`, `qr_code`, `jenis_kelamin`, `create_at`) VALUES
(1, 'septiawanajipradana@gmail.com', 'Septiawan Aji', '$2y$10$ApIGaF87PmLYX307Ktha8emXDUSZeg3UvQNr5Td3oXFvmcgcJ5IQe', '', '081215749494', 'Kdxd4qwVgCcfarHoQO5yI9ZqyzQ2', 'phone', 'e32bcfc88e5071a786a1c6e2d8896a5ce72d40a4', '', '2017-11-07 04:03:06'),
(2, 'aji@gmail.com', 'aji', '', '', '+6287889205494', 'zaiRSyW9mYerqPsC9LFFO7kHJOp2', 'phone', '7543c701775e19c2b49a383f0741e9074e33a98c', '', '2017-11-19 20:33:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
 ADD PRIMARY KEY (`id_booking`), ADD KEY `id_user` (`id_user`), ADD KEY `id_mapel` (`id_mapel`), ADD KEY `durasi` (`durasi`), ADD KEY `id_mentor` (`id_mentor`), ADD KEY `id_mentor_2` (`id_mentor`), ADD KEY `durasi_2` (`durasi`);

--
-- Indexes for table `durasi`
--
ALTER TABLE `durasi`
 ADD PRIMARY KEY (`id_durasi`);

--
-- Indexes for table `harga_penimbang`
--
ALTER TABLE `harga_penimbang`
 ADD PRIMARY KEY (`id_harga`);

--
-- Indexes for table `jumlah_murid`
--
ALTER TABLE `jumlah_murid`
 ADD PRIMARY KEY (`id_jumlah_murid`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
 ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
 ADD PRIMARY KEY (`id_mapel`), ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `mentors`
--
ALTER TABLE `mentors`
 ADD PRIMARY KEY (`id_mentor`);

--
-- Indexes for table `spesifikasi_mentor`
--
ALTER TABLE `spesifikasi_mentor`
 ADD PRIMARY KEY (`id_spesifikasi`), ADD KEY `id_mentor` (`id_mentor`), ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
MODIFY `id_booking` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `durasi`
--
ALTER TABLE `durasi`
MODIFY `id_durasi` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `harga_penimbang`
--
ALTER TABLE `harga_penimbang`
MODIFY `id_harga` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jumlah_murid`
--
ALTER TABLE `jumlah_murid`
MODIFY `id_jumlah_murid` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
MODIFY `id_kategori` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
MODIFY `id_mapel` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `mentors`
--
ALTER TABLE `mentors`
MODIFY `id_mentor` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `spesifikasi_mentor`
--
ALTER TABLE `spesifikasi_mentor`
MODIFY `id_spesifikasi` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
ADD CONSTRAINT `durasi_book` FOREIGN KEY (`durasi`) REFERENCES `durasi` (`id_durasi`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `mapel_book` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `mentor_b` FOREIGN KEY (`id_mentor`) REFERENCES `mentors` (`id_mentor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user_book` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mapel`
--
ALTER TABLE `mapel`
ADD CONSTRAINT `kategori_mapel` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spesifikasi_mentor`
--
ALTER TABLE `spesifikasi_mentor`
ADD CONSTRAINT `mentor_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `spesifikasi_mentor` FOREIGN KEY (`id_mentor`) REFERENCES `mentors` (`id_mentor`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
