-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 05:43 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absenreal`
--

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `materi_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `isi` varchar(10000) NOT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`materi_id`, `user_id`, `judul`, `isi`, `tanggal_upload`) VALUES
(27, 19, 'Materi Kuliah seni #1', 'pp', '2023-11-30 12:58:07'),
(38, 31, 'Materi Kuliah seni #2', 'n', '2023-11-30 14:00:36'),
(40, 33, 'Materi Kuliah seni #1', 'mklo', '2023-12-01 00:39:48'),
(41, 34, 'Materi Kuliah seni #2', 'apakekoop', '2023-12-01 01:59:20'),
(42, 34, 'Materi Kuliah seni #2', 'apakekya', '2023-12-01 02:00:52'),
(43, 34, 'Materi Kuliah seni #4', 'apa\r\n', '2023-12-02 06:21:18'),
(44, 37, 'sx', 'apaa\r\n', '2023-12-02 06:27:19'),
(45, 33, 'Materi Kuliah seni #2', 'tau\r\n', '2023-12-02 09:28:24'),
(46, 33, 'Materi Kuliah seni #2', 'Kuliah Seni Pengembangan', '2023-12-05 09:15:26'),
(47, 33, 'Materi Kuliah seni #5', 'Kuliah seni pembelajaran', '2023-12-06 01:56:05'),
(48, 34, 'Materi Kuliah seni #6', 'apa', '2023-12-06 01:58:34'),
(51, 37, 'kuliah baru banget', 'apa ajaaa', '2023-12-13 01:33:25'),
(53, 33, 'Materi Kuliah seni #7', 'baru baru banget', '2023-12-13 02:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `siswa_id` int(11) DEFAULT NULL,
  `materi_id` int(11) DEFAULT NULL,
  `tanggal_presensi` date DEFAULT NULL,
  `hadir` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`siswa_id`, `materi_id`, `tanggal_presensi`, `hadir`) VALUES
(32, NULL, '2023-12-01', 1),
(32, NULL, '2023-12-01', 0),
(35, NULL, '2023-12-01', 0),
(36, NULL, '2023-12-01', 0),
(32, NULL, '2023-12-01', 1),
(35, NULL, '2023-12-01', 0),
(36, NULL, '2023-12-01', 0),
(32, NULL, '2023-12-01', 1),
(35, NULL, '2023-12-01', 0),
(36, NULL, '2023-12-01', 0),
(32, NULL, '2023-12-01', 1),
(35, NULL, '2023-12-01', 0),
(36, NULL, '2023-12-01', 0),
(32, NULL, '2023-12-01', 1),
(35, NULL, '2023-12-01', 0),
(36, NULL, '2023-12-01', 0),
(32, 0, '2023-12-01', 1),
(35, 0, '2023-12-01', 0),
(36, 0, '2023-12-01', 0),
(32, 0, '2023-12-01', 1),
(35, 0, '2023-12-01', 0),
(36, 0, '2023-12-01', 0),
(32, 0, '2023-12-01', 0),
(35, 0, '2023-12-01', 1),
(36, 0, '2023-12-01', 0),
(32, NULL, '2023-12-02', 1),
(36, NULL, '2023-12-02', 1),
(32, 0, '2023-12-02', 1),
(36, 0, '2023-12-02', 0),
(37, 42, '2023-12-02', 1),
(33, 42, '2023-12-02', 1),
(33, 41, '2023-12-02', 1),
(33, 40, '2023-12-02', 1),
(33, 40, '2023-12-02', 1),
(33, 38, '2023-12-02', 1),
(33, 41, '2023-12-02', 1),
(33, 42, '2023-12-02', 1),
(33, 40, '2023-12-02', 1),
(33, 38, '2023-12-02', 1),
(33, 40, '2023-12-02', 1),
(34, 40, '2023-12-02', 1),
(34, 43, '2023-12-02', 1),
(34, 43, '2023-12-02', 1),
(37, 43, '2023-12-02', 1),
(37, 43, '2023-12-02', 1),
(37, 42, '2023-12-02', 1),
(37, 41, '2023-12-02', 1),
(37, 38, '2023-12-02', 1),
(37, 40, '2023-12-02', 1),
(32, 0, '2023-12-02', 0),
(36, 0, '2023-12-02', 0),
(37, 0, '2023-12-02', 1),
(37, 44, '2023-12-02', 1),
(37, 44, '2023-12-02', 1),
(39, 45, '2023-12-02', 1),
(39, 45, '2023-12-02', 1),
(37, 46, '2023-12-05', 1),
(37, 45, '2023-12-05', 1),
(33, 45, '2023-12-06', 1),
(37, 38, '2023-12-06', 1),
(37, 40, '2023-12-06', 1),
(33, 46, '2023-12-06', 1),
(40, 46, '2023-12-06', 1),
(33, 46, '2023-12-06', 1),
(33, 47, '2023-12-06', 1),
(34, 48, '2023-12-06', 1),
(32, NULL, '2023-12-06', 0),
(36, NULL, '2023-12-06', 0),
(37, NULL, '2023-12-06', 1),
(39, NULL, '2023-12-06', 1),
(40, NULL, '2023-12-06', 1),
(37, 48, '2023-12-08', 1),
(32, NULL, '2023-12-13', 0),
(36, NULL, '2023-12-13', 1),
(37, NULL, '2023-12-13', 1),
(39, NULL, '2023-12-13', 1),
(40, NULL, '2023-12-13', 1),
(32, NULL, '2023-12-13', 0),
(36, NULL, '2023-12-13', 0),
(37, NULL, '2023-12-13', 1),
(39, NULL, '2023-12-13', 1),
(40, NULL, '2023-12-13', 1),
(37, 51, '2023-12-13', 1),
(37, 48, '2023-12-13', 1),
(37, 53, '2023-12-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(256) NOT NULL,
  `no` varchar(256) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','mentor','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `nama`, `alamat`, `no`, `username`, `password`, `role`) VALUES
(31, 'admin1', 'admin1', 'admin1', 'admin2', 'admin2', 'admin'),
(33, 'admin', 'admin', '09882', 'admin', 'admin', 'admin'),
(34, 'mentor', 'mentor', 'mentor', 'mentor', 'mentor', 'mentor'),
(35, 'Raihan Zhafiriensyah', 'Sorowajan', '308982083', 'raihan kolo5t', 'popo', 'admin'),
(37, 'siswa', 'siswa', 'siswa', 'siswa', 'siswa', 'siswa'),
(38, 'Safir Kiram Firdaus', 'Jl. Gito Gati', '089383928392', 'safir', 'safir', 'mentor'),
(39, 'Salma Hamida', 'Sleman', '0986467999865', 'salma', 'salma', 'siswa'),
(40, 'madin', 'papringan', '089289898', 'madin', 'madin', 'siswa'),
(41, 'rina', 'sorowajan', '09288289', 'rina', 'rina', 'mentor'),
(46, 'siswa1', 'jogja', '082837290', 'siswa1', '$2y$10$iP.VMwVaDfIU8y6I.HOGA.jvjq71ZljLpUg5eexEsclHHqSUQVX2u', 'siswa'),
(50, 'putri', 'bantul', '03', 'putri', 'putri', 'siswa'),
(51, 'putra', 'jogja', '05', 'putra', 'putri', 'siswa'),
(53, 'gajah', 'gajah', 'gajah', 'gajah', 'gajah', 'admin'),
(54, '5', '5', '5', '5', '5', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`materi_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `materi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
