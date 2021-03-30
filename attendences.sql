-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2020 at 04:59 AM
-- Server version: 5.6.48-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shainelexportalDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendences`
--

CREATE TABLE `attendences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logged_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendences`
--

INSERT INTO `attendences` (`id`, `user_id`, `user_ip`, `city`, `region`, `country`, `postal`, `latitude`, `longitude`, `user_agent`, `logged_at`) VALUES
(1,1,'103.76.211.126','Bhubaneswar','Odisha','India','752101','20.2713','85.8334','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:79.0) Gecko/20100101 Firefox/79.0','2020-07-30 23:50:45'),
(4,1,'103.77.45.19','Kalyani','West Bengal','India','741245','22.9833','88.4833','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-07-31 14:07:53'),
(3,26,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-07-31 00:31:12'),
(5,26,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-07-31 22:14:58'),
(7,31,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-01 04:30:35'),
(8,32,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Linux; Android 8.0.0; Smart TV Build/OPR5.170623.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/62.0.3202.73 Safari/537.36','2020-08-01 05:21:09'),
(9,30,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-01 22:14:25'),
(10,31,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-01 23:03:34'),
(11,35,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-02 00:02:43'),
(12,32,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-02 00:09:02'),
(13,26,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-03 22:35:53'),
(14,32,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-03 23:15:23'),
(15,35,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-03 23:27:57'),
(16,31,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-03 23:36:17'),
(17,30,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36','2020-08-03 23:46:42'),
(18,30,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-04 21:29:19'),
(19,34,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-04 22:33:46'),
(20,26,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Linux; Android 9; Redmi Note 7S) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Mobile Safari/537.36','2020-08-04 22:40:30'),
(21,32,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-04 22:46:41'),
(22,31,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-04 22:52:21'),
(23,35,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-04 23:05:29'),
(24,30,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-06 21:25:56'),
(25,34,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-06 22:07:51'),
(26,26,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-06 22:42:34'),
(27,32,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-06 23:57:34'),
(28,31,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-07 00:39:01'),
(29,35,'103.121.157.24','Amtala','West Bengal','India','743503','22.3706','88.2775','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36','2020-08-07 00:39:50'),
(30, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-08 23:36:17'),
(31, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-08 00:39:50'),
(32, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-08 00:39:50'),
(33, 26, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-08 23:40:17'),
(34, 32, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-08 23:36:17'),
(35, 56, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-08 22:44:53'),
(36, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-10 22:33:46'),
(37, 26, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-10 22:40:46'),
(38, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-10 21:33:46'),
(39, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-10 22:33:46'),
(40, 56, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743503', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-10 22:33:46'),
(41, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-11 21:30:53'),
(42, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-11 22:44:53'),
(43, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-11 23:30:53'),
(44, 32, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-11 21:44:53'),
(45, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-12 21:44:53'),
(46, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-12 22:44:53'),
(47, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-12 20:27:53'),
(48, 26, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Linux; Android 9; Redmi Note 7S) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Mobile Safari/537.36', '2020-08-12 22:44:53'),
(49, 32, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-12 22:44:53'),
(50, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '2020-08-13 22:44:53'),
(51, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-13 22:44:53'),
(52, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-13 22:44:53'),
(53, 32, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-13 22:44:53'),
(54, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-14 22:44:53'),
(55, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-14 22:44:53'),
(56, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-14 22:44:53'),
(57, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-14 22:44:53'),
(58, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-15 22:44:53'),
(59, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-15 22:44:53'),
(60, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-17 22:44:53'),
(61, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-17 22:44:53'),
(62, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-18 22:44:53'),
(63, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-18 22:44:53'),
(64, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-18 22:44:53'),
(65, 30, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-19 22:44:53'),
(66, 26, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-19 22:44:53'),
(67, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-19 22:44:53'),
(68, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-19 22:44:53'),
(69, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-20 22:44:53'),
(70, 26, '103.244.242.208', 'Kolkata', 'West Bengal', 'India', '700075', '22.5655', '88.3653', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-20 03:34:05'),
(71, 30, '162.158.166.130', 'Kolkata', '', 'Singapore', '18', '1.2929', '103.8547', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-20 22:44:53'),
(72, 32, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-20 22:44:53'),
(73, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-20 22:44:53'),
(74, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36', '2020-08-20 22:44:53'),
(75, 26, '172.69.134.186', 'Kolkata', '', 'Singapore', '18', '1.2929', '103.8547', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-21 22:44:53'),
(76, 26, '162.158.167.193', 'Kolkata', '', 'Singapore', '18', '1.2929', '103.8547', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-22 22:44:53'),
(77, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-22 22:44:53'),
(83, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-22 18:16:46'),
(79, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-24 22:44:53'),
(82, 30, '162.158.166.178', 'Kolkata', '', 'Singapore', '18', '1.2929', '103.8547', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-25 17:48:17'),
(81, 31, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-24 22:44:53'),
(84, 35, '103.121.157.24', 'Kolkata', 'West Bengal', 'India', '743395', '22.3706', '88.2775', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '2020-08-25 18:50:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendences`
--
ALTER TABLE `attendences`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendences`
--
ALTER TABLE `attendences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
