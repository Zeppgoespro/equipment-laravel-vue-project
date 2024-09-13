-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Sep 13, 2024 at 06:37 AM
-- Server version: 8.0.32
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
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
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` bigint UNSIGNED NOT NULL,
  `equipment_type_id` bigint UNSIGNED NOT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `equipment_type_id`, `serial_number`, `desc`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '12ABCDE7FG', 'Маршрутизатор TP-Link.', NULL, '2024-09-08 21:09:24', '2024-09-08 21:09:24'),
(2, 2, '95WECD_1xz', 'Маршрутизатор D-Link.', NULL, '2024-09-08 21:09:24', '2024-09-10 19:07:47'),
(3, 3, '9KGWJB-6PW', 'Маршрутизатор Bobrex.', NULL, '2024-09-08 21:18:10', '2024-09-08 21:18:10'),
(4, 1, '0UEKWKMZPG', 'Великий маршрутизатор TP-Link.', NULL, '2024-09-08 21:18:48', '2024-09-08 21:18:48'),
(5, 2, '8Y8VB4_Fum', 'Отрадный маршрутизатор D-Link.', NULL, '2024-09-08 21:19:26', '2024-09-08 21:19:26'),
(6, 3, '1QWXEJ-DNQ', 'Великолепный маршрутизатор Bobrex.', NULL, '2024-09-08 21:20:08', '2024-09-08 21:20:08'),
(7, 3, '8XAMDE@1VH', 'Смачный маршрутизатор Bobrex.', NULL, '2024-09-08 21:20:44', '2024-09-08 21:20:44'),
(8, 2, '3U1XQ7@4xe', 'Ошеломляющий маршрутизатор D-Link.', NULL, '2024-09-08 21:21:28', '2024-09-08 21:21:28'),
(9, 1, 'B3IDMEG6UT', 'Мощный маршрутизатор TP-Link.', NULL, '2024-09-08 21:22:22', '2024-09-08 21:22:22'),
(10, 2, '818XHC@Fje', 'Быстрый маршрутизатор D-Link.', NULL, '2024-09-08 21:23:07', '2024-09-12 20:42:51'),
(11, 3, '5IJKT3-Y4J', 'Смешной маршрутизатор Bobrex.', NULL, '2024-09-08 21:23:38', '2024-09-08 21:23:38'),
(12, 1, 'JGOBFKWHJN', 'Вредный маршрутизатор TP-Link.', '2024-09-08 21:26:35', '2024-09-08 21:24:39', '2024-09-08 21:26:35'),
(13, 2, '5FHJC5@Tnm', 'Гулкий маршрутизатор D-Link.', NULL, '2024-09-08 21:26:01', '2024-09-08 21:26:01'),
(14, 3, '4GJPY9@N92', 'Ошеломительный маршрутизатор Bobrex.', NULL, '2024-09-10 18:46:48', '2024-09-10 18:46:48'),
(15, 2, '09UXTD@Obq', 'Летающий маршрутизатор D-Link.', '2024-09-10 18:54:07', '2024-09-10 18:52:21', '2024-09-10 18:54:07'),
(16, 3, '9ZCRJM-3D6', 'Очень осознанный Bobrex.', NULL, '2024-09-10 20:09:33', '2024-09-10 20:10:20'),
(17, 3, '8QARHK_11Y', 'Сердобольный маршрутизатор Bobrex.', NULL, '2024-09-11 13:58:50', '2024-09-11 13:58:50'),
(18, 3, '2MXECN_591', 'Сверкающий маршрутизатор Bobrex.', NULL, '2024-09-11 14:03:16', '2024-09-11 14:03:16'),
(19, 3, '3FBBLZ_2H6', 'Священный маршрутизатор Bobrex.', NULL, '2024-09-11 14:28:14', '2024-09-11 14:28:14'),
(20, 2, '41SSBZ_2jt', 'Фиолетовый маршрутизатор D-Link.', NULL, '2024-09-11 14:29:59', '2024-09-11 14:29:59'),
(21, 1, 'L4SYAAI7AS', 'Мягкий маршрутизатор TP-Link.', NULL, '2024-09-11 14:34:52', '2024-09-11 14:34:52'),
(22, 3, '0SPUKY-633', 'Отпетый маршрутизатор Bobrex.', NULL, '2024-09-11 14:51:50', '2024-09-11 14:51:50'),
(23, 2, '6R7OBJ-Wmk', 'Вяленый маршрутизатор D-Link.', NULL, '2024-09-11 14:51:50', '2024-09-11 14:51:50'),
(24, 1, 'H4SBQJI9EF', 'Жидкий маршрутизатор TP-Link.', NULL, '2024-09-11 14:51:50', '2024-09-11 14:51:50'),
(25, 2, '68EMU8@1ck', 'Жёлтый маршрутизатор D-Link.', NULL, '2024-09-11 15:21:28', '2024-09-11 15:21:28'),
(26, 3, '6XUXC1@LRJ', 'Зелёный маршрутизатор Bobrex.', NULL, '2024-09-11 15:21:28', '2024-09-11 15:21:28'),
(27, 3, '2DCEP1_5AU', 'Сладкий маршрутизатор Bobrex.', NULL, '2024-09-11 16:19:00', '2024-09-11 16:19:00'),
(28, 1, 'NKLMBFQHLS', 'Славный маршрутизатор TP-Link.', NULL, '2024-09-11 16:25:40', '2024-09-11 16:25:40'),
(29, 2, '15LILC@Qbe', 'Горький маршрутизатор D-Link.', NULL, '2024-09-11 16:25:40', '2024-09-11 16:25:40'),
(30, 3, '0BITK1-HU8', 'Квадратный маршрутизатор Bobrex.', NULL, '2024-09-11 20:42:09', '2024-09-11 20:42:09'),
(31, 2, '9D7NX8-Lwd', 'Круглый маршрутизатор D-Link.', NULL, '2024-09-11 20:46:45', '2024-09-11 20:46:45'),
(32, 3, '0GPYP7-KI4', 'Ромбовидный маршрутизатор Bobrex.', NULL, '2024-09-11 20:46:45', '2024-09-11 20:46:45'),
(33, 2, '165FYX@Phi', 'Свирепый D-Link.', NULL, '2024-09-11 21:07:52', '2024-09-11 21:07:52'),
(34, 3, '2JQUU3_32G', 'Свинский Bobrex.', NULL, '2024-09-11 21:48:06', '2024-09-11 21:48:06'),
(35, 3, '1JVSQS_94O', 'Волчий Bobrex.', NULL, '2024-09-11 21:48:06', '2024-09-11 21:48:06'),
(36, 3, '0QFRSQ@835', 'Кроткий Bobrex.', NULL, '2024-09-11 21:54:55', '2024-09-11 21:54:55'),
(37, 3, '1LKPIX_748', 'Смирный Bobrex.', NULL, '2024-09-11 21:54:55', '2024-09-11 21:54:55'),
(38, 3, '2GLJB8@664', 'Северный Bobrex.', NULL, '2024-09-11 21:54:55', '2024-09-11 21:54:55'),
(39, 3, '1UHJCM@007', 'Лазурный Bobrex.', NULL, '2024-09-11 22:16:13', '2024-09-11 22:16:13'),
(40, 3, '8LMHI5@3S4', 'Крестовый Bobrex.', NULL, '2024-09-11 22:58:11', '2024-09-11 22:58:11'),
(41, 3, '8UHQGQ_80M', 'Кислый', NULL, '2024-09-11 23:02:01', '2024-09-11 23:02:01'),
(42, 3, '1JYIL0-ODK', 'Гуго', NULL, '2024-09-11 23:02:01', '2024-09-11 23:02:01'),
(43, 3, '9VUNQ3-52I', 'Тито', NULL, '2024-09-11 23:03:55', '2024-09-11 23:03:55'),
(44, 3, '1VUEHK-37M', 'Фрито', NULL, '2024-09-11 23:03:55', '2024-09-11 23:03:55'),
(45, 3, '9NOQFA-580', 'Бомбито', NULL, '2024-09-11 23:03:55', '2024-09-11 23:03:55'),
(46, 3, '6YQYY1-XF7', 'Кактус', NULL, '2024-09-12 08:41:56', '2024-09-12 08:41:56'),
(47, 3, '7QLHLH-LU7', 'Виндикатор', NULL, '2024-09-12 08:49:39', '2024-09-12 08:49:39'),
(48, 3, '1RGPM4-M78', 'Рим', NULL, '2024-09-12 08:49:39', '2024-09-12 08:49:39'),
(49, 3, '3NNAP2@6GA', 'Тарантино', NULL, '2024-09-12 09:04:20', '2024-09-12 09:04:20'),
(50, 3, '1FIOA6@G5J', '123', NULL, '2024-09-12 09:23:48', '2024-09-12 09:23:48'),
(51, 3, '4RTOTO_WP8', '321', NULL, '2024-09-12 09:23:48', '2024-09-12 09:23:48'),
(52, 3, '1YRNKU_VNO', '098', NULL, '2024-09-12 09:28:43', '2024-09-12 09:28:43'),
(53, 1, 'ISQNDVDEPW', '765', NULL, '2024-09-12 09:28:43', '2024-09-12 09:28:43'),
(54, 2, '497CZE_Qfn', '578', NULL, '2024-09-12 09:28:43', '2024-09-12 09:28:43'),
(55, 3, '8CZQCF@B08', '123', NULL, '2024-09-12 10:20:43', '2024-09-12 10:20:43'),
(56, 2, '628VJ2_Kan', '123', NULL, '2024-09-12 10:22:04', '2024-09-12 10:22:04'),
(57, 1, 'PCAFDEP9RW', '321', NULL, '2024-09-12 10:22:04', '2024-09-12 10:22:04'),
(58, 2, '084RLJ_Rrf', '4321', NULL, '2024-09-12 10:30:34', '2024-09-12 10:30:34'),
(59, 3, '1NKAGX@OZY', '123', NULL, '2024-09-12 10:36:33', '2024-09-12 10:36:33'),
(60, 3, '3QUUF4_C64', '4321', NULL, '2024-09-12 10:36:33', '2024-09-12 10:36:33'),
(61, 3, '5WMHU1_P5U', '123', NULL, '2024-09-12 10:37:45', '2024-09-12 10:37:45'),
(62, 3, '5PYIO0@7JC', '4321', NULL, '2024-09-12 10:37:45', '2024-09-12 10:37:45'),
(63, 3, '0DEQH0-39E', '54321', NULL, '2024-09-12 10:37:45', '2024-09-12 10:37:45'),
(64, 3, '7JVAH0_063', '55555', NULL, '2024-09-12 15:47:07', '2024-09-12 15:47:07'),
(65, 3, '4NEDDG_1NT', 'Камелот', NULL, '2024-09-12 17:24:08', '2024-09-12 17:24:08'),
(66, 3, '6VKZFL-6R6', 'Бельмондо', NULL, '2024-09-12 17:26:50', '2024-09-12 17:26:50'),
(67, 2, '4PXUX4-9dl', 'Жан Поль', NULL, '2024-09-12 17:26:50', '2024-09-12 17:26:50'),
(68, 2, '015MNJ-Tob', 'Пикачу', NULL, '2024-09-12 17:28:33', '2024-09-12 17:28:33'),
(69, 3, '3PZPS9@1UL', 'Бульбазавр', NULL, '2024-09-12 17:35:11', '2024-09-12 17:35:11'),
(70, 3, '5FIINY@O12', 'Пижиот', NULL, '2024-09-12 17:38:58', '2024-09-12 17:38:58'),
(71, 2, '1C4HDG@7ur', 'Флагман', NULL, '2024-09-12 17:40:06', '2024-09-12 17:40:06'),
(72, 1, 'JCVQMOEKWO', 'Саурон', NULL, '2024-09-12 17:44:19', '2024-09-12 17:44:19'),
(73, 2, '419ILO_Gmu', 'Сэм', NULL, '2024-09-12 17:45:31', '2024-09-12 17:45:31'),
(74, 3, '9PTNVR_5HK', 'Антарктида', NULL, '2024-09-12 17:51:05', '2024-09-12 17:51:05'),
(75, 1, '81USUOTVEZ', 'Бонус', NULL, '2024-09-12 17:54:18', '2024-09-12 17:54:18'),
(76, 2, '125KF6-5db', 'Атлантида', NULL, '2024-09-12 17:54:18', '2024-09-12 17:54:18'),
(77, 2, '119UVH@Zfw', 'Ива', NULL, '2024-09-12 17:59:01', '2024-09-12 17:59:01'),
(78, 2, '45EDL9_Vpq', 'Дуб', NULL, '2024-09-12 17:59:01', '2024-09-12 17:59:01'),
(79, 1, '6IRSQPH8QC', 'Берёза', NULL, '2024-09-12 18:04:47', '2024-09-12 18:04:47'),
(80, 1, 'EIVMOOW6SG', '55555', NULL, '2024-09-12 18:04:47', '2024-09-12 18:04:47'),
(81, 3, '3ZDCNI-06K', '66666', NULL, '2024-09-12 18:04:47', '2024-09-12 18:04:47'),
(82, 2, '5P3HC7@Bue', '77777', NULL, '2024-09-12 18:07:06', '2024-09-12 18:07:06'),
(83, 2, '12NSE6@1mj', '99999', NULL, '2024-09-12 18:41:27', '2024-09-12 18:41:27'),
(84, 2, '524AVM@Jkh', '88888', NULL, '2024-09-12 18:42:33', '2024-09-12 18:42:33'),
(85, 3, '7DZMJ6_6LJ', '22222', NULL, '2024-09-12 18:42:33', '2024-09-12 18:42:33'),
(86, 1, '12SRZPJADW', '33333', NULL, '2024-09-12 18:43:19', '2024-09-12 18:43:19'),
(87, 2, '5Z7FI3@6vd', 'Новый год!', NULL, '2024-09-12 18:48:50', '2024-09-12 18:48:50'),
(88, 3, '8HUQM9_2BA', 'Изумрудный', NULL, '2024-09-12 18:52:50', '2024-09-12 18:52:50'),
(89, 2, '861ID4-Hij', '00000', NULL, '2024-09-12 18:56:02', '2024-09-12 18:56:02'),
(90, 2, '3EZKV7-6uu', '99999', NULL, '2024-09-12 18:58:31', '2024-09-12 18:58:31'),
(91, 2, '738TH0@8lf', '33333', NULL, '2024-09-12 19:00:08', '2024-09-12 19:00:08'),
(92, 3, '9ZQENP-XO6', 'Пегасы', NULL, '2024-09-12 19:04:34', '2024-09-12 19:04:34'),
(93, 1, 'S3OPTTY1NB', 'Гномы', NULL, '2024-09-12 19:04:34', '2024-09-12 19:04:34'),
(94, 3, '5CRIER_AXT', 'Питон', NULL, '2024-09-12 19:07:26', '2024-09-12 19:07:26'),
(95, 2, '544YB6@Dhr', 'Жираф', NULL, '2024-09-12 19:07:26', '2024-09-12 19:07:26'),
(96, 3, '0XEJKD-8AH', 'Крокодилы', NULL, '2024-09-12 19:08:22', '2024-09-12 19:08:22'),
(97, 2, '33FVCJ_1ld', 'Львы', NULL, '2024-09-12 19:08:22', '2024-09-12 19:08:22'),
(98, 1, 'CXLOQFR2IS', 'Жуки', NULL, '2024-09-12 19:10:07', '2024-09-12 19:10:07'),
(99, 3, '5UBOLZ@Z52', 'Волки', NULL, '2024-09-12 19:10:07', '2024-09-12 19:10:07'),
(100, 1, 'X6IBHSQ7XY', 'Джедаи', NULL, '2024-09-12 19:10:07', '2024-09-12 19:10:07'),
(101, 2, '9QGBVE@8uo', '77777', NULL, '2024-09-12 19:42:17', '2024-09-12 19:42:17'),
(102, 1, '80ZVMSKLQC', '88888', NULL, '2024-09-12 19:46:47', '2024-09-12 19:46:47'),
(103, 3, '3LQHED_3N0', '11111', NULL, '2024-09-12 19:46:47', '2024-09-12 19:46:47'),
(104, 2, '8I5CNI-Jvn', '33333', NULL, '2024-09-12 20:06:43', '2024-09-12 20:06:43'),
(105, 2, '4H2BC3@8jm', '77777', NULL, '2024-09-12 20:11:25', '2024-09-12 20:11:25'),
(106, 2, '0Z0ZSA_Zee', '44444', NULL, '2024-09-12 20:12:20', '2024-09-12 20:12:20'),
(107, 2, '1XMUY8-Mxv', '44444', NULL, '2024-09-12 21:09:51', '2024-09-12 21:09:51'),
(108, 2, '7VHJT1_Uoa', '33333', NULL, '2024-09-12 21:10:06', '2024-09-12 21:10:06'),
(109, 3, '6NETN3-MS9', 'Супер', NULL, '2024-09-13 06:36:23', '2024-09-13 06:36:23'),
(110, 2, '5Q6UA1@Bma', 'Прекрасно', NULL, '2024-09-13 06:37:29', '2024-09-13 06:37:29'),
(111, 3, '2MSAXG_OK2', 'Замечательно', NULL, '2024-09-13 06:37:29', '2024-09-13 06:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_types`
--

CREATE TABLE `equipment_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mask` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment_types`
--

INSERT INTO `equipment_types` (`id`, `name`, `mask`, `created_at`, `updated_at`) VALUES
(1, 'TP-Link TL-WR74', 'XXAAAAAXAA', '2024-09-08 21:08:48', '2024-09-08 21:08:48'),
(2, 'D-Link DIR-300', 'NXXAAXZXaa', '2024-09-08 21:08:48', '2024-09-08 21:08:48'),
(3, 'Bobrex BOB-135', 'NAAAAXZXXX', '2024-09-08 21:08:48', '2024-09-08 21:08:48');

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
(4, '2024_09_03_165005_create_equipment_types_table', 1),
(5, '2024_09_03_165858_create_equipments_table', 1),
(6, '2024_09_05_130300_create_personal_access_tokens_table', 1),
(7, '2024_09_10_173304_update_equipment_table_for_unique_serial_number', 2);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
('0YrZORnHpF29EzaKxwFBWr1gZ8RGEv4QrjVhd89R', NULL, '172.18.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicGFNQUhycTg5bmRHNk9hNFhzVnNxRDl4OURqS05TNTExTEQ4M0w2aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1726209307),
('kfOqbRTCaDEnqSKsjbzZxRHxn3Y2mJiOU8RVlK6o', NULL, '172.18.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZFBNdmN2OVRLWGhqRkZ3MWdwRXRoYzlwS0o5OG1SN3F5dFlrMTlONCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1726175314);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipment_serial_number_equipment_type_id_unique` (`serial_number`,`equipment_type_id`),
  ADD KEY `equipment_equipment_type_id_foreign` (`equipment_type_id`);

--
-- Indexes for table `equipment_types`
--
ALTER TABLE `equipment_types`
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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `equipment_types`
--
ALTER TABLE `equipment_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_equipment_type_id_foreign` FOREIGN KEY (`equipment_type_id`) REFERENCES `equipment_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
