-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2025 at 04:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rumah-kedua`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_kamars`
--

CREATE TABLE `detail_kamars` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kamar` bigint UNSIGNED NOT NULL,
  `fasilitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_kamars`
--

INSERT INTO `detail_kamars` (`id`, `id_kamar`, `fasilitas`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(2, 1, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(3, 1, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(4, 1, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(5, 1, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(6, 1, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(7, 1, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(8, 1, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(9, 1, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(10, 1, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(11, 2, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(12, 2, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(13, 2, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(14, 2, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(15, 2, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(16, 2, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(17, 2, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(18, 2, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(19, 2, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(20, 2, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(21, 3, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(22, 3, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(23, 3, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(24, 3, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(25, 3, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(26, 3, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(27, 3, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(28, 3, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(29, 3, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(30, 3, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(31, 4, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(32, 4, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(33, 4, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(34, 4, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(35, 4, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(36, 4, 'TV', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(37, 4, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(38, 4, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(39, 4, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(40, 4, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(41, 4, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(42, 4, 'Rak Sepatu', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(43, 4, 'Kipas Angin', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(44, 5, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(45, 5, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(46, 5, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(47, 5, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(48, 5, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(49, 5, 'TV', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(50, 5, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(51, 5, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(52, 5, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(53, 5, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(54, 5, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(55, 5, 'Rak Sepatu', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(56, 5, 'Kipas Angin', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(57, 6, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(58, 6, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(59, 6, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(60, 6, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(61, 6, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(62, 6, 'TV', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(63, 6, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(64, 6, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(65, 6, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(66, 6, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(67, 6, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(68, 6, 'Rak Sepatu', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(69, 6, 'Kipas Angin', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(70, 7, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(71, 7, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(72, 7, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(73, 7, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(74, 7, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(75, 7, 'TV', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(76, 7, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(77, 7, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(78, 7, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(79, 7, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(80, 7, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(81, 7, 'Rak Sepatu', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(82, 7, 'Kipas Angin', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(83, 8, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(84, 8, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(85, 8, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(86, 8, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(87, 8, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(88, 8, 'TV', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(89, 8, 'Dapur Pribadi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(90, 8, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(91, 8, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(92, 8, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(93, 8, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(94, 8, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(95, 8, 'Rak Sepatu', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(96, 8, 'AC', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(97, 9, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(98, 9, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(99, 9, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(100, 9, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(101, 9, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(102, 9, 'TV', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(103, 9, 'Dapur Pribadi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(104, 9, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(105, 9, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(106, 9, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(107, 9, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(108, 9, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(109, 9, 'Rak Sepatu', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(110, 9, 'AC', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(111, 10, 'Kasur & Bantal', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(112, 10, 'Lemari', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(113, 10, 'Meja dan Kursi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(114, 10, 'K. Mandi Dalam', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(115, 10, 'Kaca', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(116, 10, 'TV', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(117, 10, 'Dapur Pribadi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(118, 10, 'WI-FI', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(119, 10, 'Tempat Sampah', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(120, 10, 'Listrik', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(121, 10, 'Jendela dan Tirai', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(122, 10, 'Stopkontak', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(123, 10, 'Rak Sepatu', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(124, 10, 'AC', '2025-11-17 17:10:21', '2025-11-17 17:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kamars`
--

CREATE TABLE `kamars` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_kamar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lebar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Tersedia','Terisi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kamars`
--

INSERT INTO `kamars` (`id`, `kode_kamar`, `harga`, `tipe`, `lebar`, `deskripsi`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'A-101', '1500000', 'Standard', '12.5', 'Kamar Standard nyaman dengan luas 12.5m², cocok untuk penghuni tunggal dengan fasilitas lengkap untuk kebutuhan sehari-hari.', 'kamar/standard.jpg', 'Terisi', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(2, 'A-102', '1450000', 'Standard', '12', 'Kamar Standard dengan desain minimalis, luas 12m² dilengkapi dengan fasilitas standar yang memadai.', 'kamar/standard.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(3, 'A-103', '1550000', 'Standard', '13', 'Kamar Standard luas 13m² dengan ventilasi yang baik, cocok untuk kenyamanan maksimal.', 'kamar/standard.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(4, 'B-201', '2200000', 'Medium', '18', 'Kamar Medium dengan luas 18m², dilengkapi fasilitas tambahan untuk kenyamanan lebih.', 'kamar/medium.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(5, 'B-202', '2300000', 'Medium', '19.5', 'Kamar Medium nyaman dengan luas 19.5m², memiliki ruang yang lebih luas dan fasilitas lengkap.', 'kamar/medium.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(6, 'B-203', '2100000', 'Medium', '17.5', 'Kamar Medium dengan desain modern, luas 17.5m² cocok untuk profesional muda.', 'kamar/medium.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(7, 'B-204', '2400000', 'Medium', '20', 'Kamar Medium premium dengan luas 20m², view yang bagus dan fasilitas terbaik di kelasnya.', 'kamar/medium.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(8, 'C-301', '3500000', 'Exclusive', '25', 'Kamar Exclusive mewah dengan luas 25m², dilengkapi dengan fasilitas premium dan furniture berkualitas tinggi.', 'kamar/exclusive.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(9, 'C-302', '3800000', 'Exclusive', '28', 'Kamar Exclusive suite dengan luas 28m², memiliki ruang living area terpisah dan kamar mandi mewah.', 'kamar/exclusive.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(10, 'C-303', '3200000', 'Exclusive', '24', 'Kamar Exclusive dengan desain elegan, luas 24m² menawarkan kenyamanan maksimal dengan privacy terjamin.', 'kamar/exclusive.jpg', 'Tersedia', '2025-11-17 17:10:21', '2025-11-17 17:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_27_160559_create_kamars_table', 1),
(5, '2025_10_02_143422_create_detail_kamars_table', 1),
(6, '2025_10_05_155422_create_transaksis_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7Asi736phT5OCSDisNIsIzhKvyHn2IhlCg6stnx9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibldaZWJwZVF3ZkdmekMzTHNoMkVxOU04Rnk4T1l1MzdzcmJXOFhRSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763439274);

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_kamar` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `tanggal_jatuhtempo` date NOT NULL,
  `periode_pembayaran` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `masuk_kamar` date DEFAULT NULL,
  `durasi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bayar` decimal(15,2) NOT NULL,
  `metode_pembayaran` enum('cash','midtrans') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'midtrans',
  `status_pembayaran` enum('pending','paid','failed','cancelled','expired','challenge') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `midtrans_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_response` json DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `id_user`, `id_kamar`, `kode`, `tanggal_pembayaran`, `tanggal_jatuhtempo`, `periode_pembayaran`, `masuk_kamar`, `durasi`, `total_bayar`, `metode_pembayaran`, `status_pembayaran`, `midtrans_order_id`, `midtrans_transaction_id`, `midtrans_payment_type`, `midtrans_response`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'INV-44HJORAG', '2025-06-26', '2025-06-26', 'Januari 2025', '2025-06-26', '1 bulan', 750000.00, 'midtrans', 'paid', 'MID-AICHFY', 'TRX-YJGAXPNZEJ', 'bank_transfer', '{\"bank\": \"bca\", \"status\": \"settlement\"}', '2025-06-26 00:10:18', '2025-06-25 17:10:18', '2025-06-25 17:10:18'),
(2, 2, 3, 'INV-KTTBVWV0', '2025-06-26', '2025-06-26', 'Januari 2025', '2025-06-26', '1 bulan', 750000.00, 'midtrans', 'pending', 'MID-ECW2JU', NULL, NULL, NULL, '2025-06-26 00:10:18', '2025-06-25 17:10:18', '2025-06-25 17:10:18'),
(3, 3, 4, 'INV-PHN0OWS9', '2025-06-26', '2025-06-26', 'Januari 2025', '2025-06-26', '1 bulan', 750000.00, 'midtrans', 'expired', 'MID-RWZJWS', 'TRX-K9OGXY7UEP', 'qris', '{\"status\": \"expire\"}', '2025-06-26 00:10:18', '2025-06-25 17:10:18', '2025-06-25 17:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kamar` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `status_penghuni` enum('aktif','nonaktif','menunggak') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user','penghuni') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_kamar`, `name`, `email`, `email_verified_at`, `password`, `telepon`, `tanggal_masuk`, `status_penghuni`, `role`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Admin', 'admin@kos.com', NULL, '$2y$12$PDoIarRUDA72fYKcMhYS3.j9/z0cZxcxj0AWk6zD.GC6pN9HCS1Rm', NULL, NULL, NULL, 'admin', NULL, NULL, '2025-11-17 17:10:18', '2025-11-17 17:10:18'),
(2, NULL, 'User1', 'user1@kos.com', NULL, '$2y$12$7kf.T7.XGFze1Nyd3m71N.kdDWt4Lv62KtbZAWRT78r70bwT5nFGC', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:18', '2025-11-17 17:10:18'),
(3, NULL, 'User2', 'user2@kos.com', NULL, '$2y$12$1gNs78ySTwgTDCbJ2QqQ2uJGQOosYvHK6NCCuCboOry9GZGWfRYXi', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:18', '2025-11-17 17:10:18'),
(4, NULL, 'User3', 'user3@kos.com', NULL, '$2y$12$5pxZDTPhszCtEKtDmzrk6ukjOA1fF.38fcVM.HpPMhvXmo8Iy3Yr6', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:19', '2025-11-17 17:10:19'),
(5, NULL, 'User4', 'user4@kos.com', NULL, '$2y$12$3ek5b0/GovJS40SQ8IVZAe4vtwnpjvDJyk4nM4.r.EKO1QZow1tCu', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:19', '2025-11-17 17:10:19'),
(6, NULL, 'User5', 'user5@kos.com', NULL, '$2y$12$Y/P/oDyPn3xSYfw9yMeTXOHih8V1H13Kw64pD1rpEbDyyTac8Ubx.', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:19', '2025-11-17 17:10:19'),
(7, NULL, 'User6', 'user6@kos.com', NULL, '$2y$12$vxegchnGDgxMg/buUwvazuov/WHRnc4HAbEAUrp48hk6aw8cHFtz2', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:20', '2025-11-17 17:10:20'),
(8, NULL, 'User7', 'user7@kos.com', NULL, '$2y$12$dGbSKJarGNYFlm5PClzjD.19zjiTmlYkIisftnz1Oq47E.c98Uk5u', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:20', '2025-11-17 17:10:20'),
(9, NULL, 'User8', 'user8@kos.com', NULL, '$2y$12$vFi2feR.OUDyu7dGZunyEO1aB1dfsDbKywy6Ul/b541raDciClHaK', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:20', '2025-11-17 17:10:20'),
(10, NULL, 'User9', 'user9@kos.com', NULL, '$2y$12$q8V16vcjYNlmiZ41/.pJbey4hR84ZOfICP/2mxHyBcR4WBDz7xWSS', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:20', '2025-11-17 17:10:20'),
(11, NULL, 'User10', 'user10@kos.com', NULL, '$2y$12$RYlZmbdREBIk0SPnR0gtf.mPap9EL2CFNdQfSr3zcmZN67xqDa2G2', NULL, NULL, NULL, 'user', NULL, NULL, '2025-11-17 17:10:21', '2025-11-17 17:10:21'),
(12, 1, 'Penghuni', 'penghuni@kos.com', NULL, '$2y$12$mJoZyl90tgJLHESXVUCPpuTh1KCG7ljqP8rGoU9zIrjYjE.fJCzp2', '6285704229619', '2025-11-18', 'aktif', 'penghuni', NULL, NULL, '2025-11-17 17:10:21', '2025-11-17 17:10:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_kamars`
--
ALTER TABLE `detail_kamars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kamars`
--
ALTER TABLE `kamars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kamars_kode_kamar_unique` (`kode_kamar`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaksis_kode_unique` (`kode`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_kamars`
--
ALTER TABLE `detail_kamars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kamars`
--
ALTER TABLE `kamars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
