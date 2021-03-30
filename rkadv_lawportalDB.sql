-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2020 at 04:27 AM
-- Server version: 5.6.49-cll-lve
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
-- Database: `rkadv_lawportalDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendences`
--

CREATE TABLE `attendences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `logged_at` datetime DEFAULT NULL,
  `logged_out_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendences`
--

INSERT INTO `attendences` (`id`, `user_id`, `user_ip`, `city`, `region`, `country`, `postal`, `latitude`, `longitude`, `user_agent`, `note`, `logged_at`, `logged_out_at`) VALUES
(43, 26, '182.50.151.15', 'Singapore', '', 'Singapore', '', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-26 23:11:00', '2020-08-26 23:53:02'),
(44, 40, '182.50.151.15', 'Singapore', '', 'Singapore', '', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-26 23:13:43', NULL),
(45, 34, '182.50.151.15', 'Singapore', '', 'Singapore', '', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-26 23:44:00', '2020-08-27 00:10:00'),
(46, 34, '182.50.151.15', 'Singapore', '', 'Singapore', '', '', '', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-27 09:21:00', '2020-08-27 22:19:58'),
(47, 40, '182.50.151.15', 'Singapore', '', 'Singapore', '', '', '', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', 'attendence check', '2020-08-27 09:23:00', '2020-08-27 18:30:00'),
(48, 35, '182.50.151.15', 'Singapore', '', 'Singapore', '', '', '', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-27 09:23:49', NULL),
(49, 35, '182.50.151.15', 'Singapore', '', 'Singapore', '', '', '', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-28 09:49:00', '2020-08-28 11:24:08'),
(50, 40, '182.50.151.15', 'Singapore', '', 'Singapore', '', '', '', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-28 09:50:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `case_files`
--

CREATE TABLE `case_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_files`
--

INSERT INTO `case_files` (`id`, `case_id`, `file_id`) VALUES
(2, 167, 115),
(4, 180, 115),
(7, 191, 115),
(8, 191, 188),
(13, 332, 115),
(14, 332, 327);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formfields`
--

CREATE TABLE `formfields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `field_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `formfields`
--

INSERT INTO `formfields` (`id`, `field_name`, `active`) VALUES
(5, 'Client', 1),
(6, 'Opponent', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logged_details`
--

CREATE TABLE `logged_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `logged_at` datetime DEFAULT NULL,
  `logged_out_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logged_details`
--

INSERT INTO `logged_details` (`id`, `user_id`, `logged_at`, `logged_out_at`) VALUES
(4, 29, '2020-08-26 04:48:10', NULL),
(5, 29, '2020-08-26 22:54:53', '2020-08-26 22:59:12'),
(6, 29, '2020-08-26 23:00:09', '2020-08-26 23:03:07'),
(7, 29, '2020-08-26 23:05:44', '2020-08-26 23:10:51'),
(8, 29, '2020-08-26 23:07:11', NULL),
(9, 26, '2020-08-26 23:11:26', '2020-08-26 23:11:32'),
(10, 40, '2020-08-26 23:13:43', '2020-08-26 23:13:55'),
(11, 40, '2020-08-26 23:32:18', NULL),
(12, 34, '2020-08-26 23:44:40', NULL),
(13, 29, '2020-08-26 23:49:42', '2020-08-26 23:51:10'),
(14, 34, '2020-08-26 23:51:27', '2020-08-26 23:53:02'),
(15, 29, '2020-08-27 09:15:48', '2020-08-27 09:21:26'),
(16, 34, '2020-08-27 09:21:53', '2020-08-27 09:22:32'),
(17, 40, '2020-08-27 09:23:09', '2020-08-27 09:23:24'),
(18, 35, '2020-08-27 09:23:48', '2020-08-27 09:24:04'),
(19, 29, '2020-08-27 09:24:18', '2020-08-27 11:31:56'),
(20, 29, '2020-08-27 09:46:24', NULL),
(21, 40, '2020-08-27 11:32:12', '2020-08-27 11:32:31'),
(22, 29, '2020-08-27 11:32:47', NULL),
(23, 29, '2020-08-27 15:17:33', NULL),
(24, 29, '2020-08-27 19:03:26', NULL),
(25, 29, '2020-08-27 21:25:42', NULL),
(26, 29, '2020-08-27 21:26:05', NULL),
(27, 29, '2020-08-27 21:45:38', '2020-08-27 22:02:19'),
(28, 34, '2020-08-27 22:02:54', '2020-08-27 22:03:09'),
(29, 35, '2020-08-27 22:03:23', '2020-08-27 22:03:35'),
(30, 29, '2020-08-27 22:03:57', '2020-08-27 22:19:58'),
(31, 29, '2020-08-28 01:24:04', NULL),
(32, 29, '2020-08-28 09:16:36', '2020-08-28 09:19:02'),
(33, 29, '2020-08-28 09:38:55', '2020-08-28 09:48:52'),
(34, 35, '2020-08-28 09:49:17', '2020-08-28 11:24:08'),
(35, 40, '2020-08-28 09:50:41', '2020-08-28 11:23:36'),
(36, 29, '2020-08-28 11:24:25', NULL),
(37, 29, '2020-08-28 18:21:29', NULL),
(38, 29, '2020-08-29 03:19:11', NULL),
(39, 29, '2020-08-29 09:39:09', NULL),
(40, 29, '2020-08-29 13:59:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mastermetas`
--

CREATE TABLE `mastermetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_id` int(11) NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mastermetas`
--

INSERT INTO `mastermetas` (`id`, `master_id`, `meta_key`, `meta_value`) VALUES
(1, 27, 'id_proof', 'a:0:{}'),
(2, 28, 'id_proof', 'a:0:{}'),
(3, 29, 'id_proof', 'a:0:{}'),
(4, 30, 'id_proof', 'a:0:{}'),
(5, 31, 'id_proof', 'a:0:{}'),
(6, 32, 'id_proof', 'a:0:{}'),
(7, 33, 'id_proof', 'a:0:{}'),
(8, 34, 'id_proof', 'a:0:{}'),
(9, 35, 'id_proof', 'a:0:{}'),
(10, 1, 'holiday_date', '2020-01-01'),
(11, 4, 'holiday_date', '2020-01-26'),
(12, 6, '_attachment_url', '2020/08/nWzjFYcdtc7MTZB5jVmESdvmHTkkAF1qyZERZB7J.pdf'),
(13, 6, '_attachment_mime', 'application/pdf'),
(14, 6, '_attachment_size', '1142737'),
(15, 8, '_attachment_url', '2020/08/mx9uH9lSp2vp1jFzuSI3mJUbVALYaNOXtsFNdpFv.pdf'),
(16, 8, '_attachment_mime', 'application/pdf'),
(17, 8, '_attachment_size', '4255855'),
(18, 10, '_attachment_url', '2020/08/y9eprzxARpPb3jYaG2hM9XAUk3ueDgkAQfH1nFsp.pdf'),
(19, 10, '_attachment_mime', 'application/pdf'),
(20, 10, '_attachment_size', '4496178'),
(21, 36, 'id_proof', 'a:0:{}'),
(22, 12, '_attachment_url', '2020/08/MwFvXRMv8pYjYSvmI66SNxu9c6VssBeGz21illgd.jpeg'),
(23, 12, '_attachment_mime', 'image/jpeg'),
(24, 12, '_attachment_size', '78573'),
(25, 37, 'id_proof', 'a:0:{}'),
(26, 18, 'dir_name', 'subrata_ash_vs_state_of_west_bengal_20200803013624'),
(27, 18, 'case_number', 'L.A CASE NO. 35/16'),
(28, 18, 'client_id', '36'),
(29, 18, 'opponent_id', '37'),
(30, 18, 'court_id', '14'),
(31, 18, 'subcourt_id', '0'),
(32, 18, 'case_category_id', '16'),
(33, 18, 'case_subcategory_id', '0'),
(34, 18, 'case_desc', '<p>Case Closed</p>'),
(35, 18, 'case_doc', 'a:0:{}'),
(36, 18, 'case_status', 'suspended'),
(37, 19, 'hearing_date', '2014-02-10'),
(38, 21, 'hearing_date', '2019-02-08'),
(39, 38, 'id_proof', 'a:0:{}'),
(40, 27, 'dir_name', 'nashiram_josh_vs_state_of_west_bengal_20200803014938'),
(41, 27, 'case_number', 'O.A-NO. 1342/14'),
(42, 27, 'client_id', '38'),
(43, 27, 'opponent_id', '37'),
(44, 27, 'court_id', '23'),
(45, 27, 'subcourt_id', '0'),
(46, 27, 'case_category_id', '25'),
(47, 27, 'case_subcategory_id', '0'),
(48, 27, 'case_desc', '<p>CASE CLOSED</p>'),
(49, 27, 'case_doc', 'a:0:{}'),
(50, 27, 'case_status', 'active'),
(51, 28, 'hearing_date', '2019-06-27'),
(52, 30, 'holiday_date', '2020-12-25'),
(53, 44, 'holiday_date', '2020-08-15'),
(54, 46, 'holiday_date', '2020-01-26'),
(55, 53, 'holiday_date', '2020-01-01'),
(56, 55, 'holiday_date', '2020-01-26'),
(57, 57, 'holiday_date', '2020-01-29'),
(58, 59, 'holiday_date', '2020-03-09'),
(59, 61, 'holiday_date', '2020-04-14'),
(60, 63, 'holiday_date', '2020-08-15'),
(61, 65, 'holiday_date', '2020-09-17'),
(62, 67, 'holiday_date', '2020-10-02'),
(63, 69, 'holiday_date', '2020-10-21'),
(64, 71, 'holiday_date', '2020-10-22'),
(65, 73, 'holiday_date', '2020-10-24'),
(66, 75, 'holiday_date', '2020-10-23'),
(67, 77, 'holiday_date', '2020-10-30'),
(68, 79, 'holiday_date', '2020-11-14'),
(69, 81, 'holiday_date', '2020-12-25'),
(70, 83, 'holiday_date', '2020-04-14'),
(71, 86, 'todo_description', '<p>Maintain in out Register in Excel<br />\r\nPrepare Voucher &amp; Processed PaymentEntry in Tally<br />\r\nMaintain expenses in excel sheet<br />\r\nPrint out the Documents<br />\r\nVisited UCO Bank for the statement<br />\r\nVerify the Biometric Records<br />\r\n&nbsp;</p>'),
(72, 86, 'due_date', '2020-08-06'),
(73, 86, 'is_completed', '0'),
(74, 86, 'todo_priority', 'high'),
(75, 89, 'deadline', '2020-08-21'),
(76, 89, 'assignee_id', '34'),
(77, 89, 'is_assignee_accept', '0'),
(78, 94, 'incident_description', '<p>test content</p>'),
(79, 94, 'due_date', '2020-08-14'),
(80, 94, 'is_completed', '0'),
(81, 94, 'incident_priority', 'high'),
(82, 96, '_comment', '<p>test</p>'),
(83, 106, 'deadline', '2020-08-28'),
(84, 106, 'assignee_id', '40'),
(85, 106, 'is_assignee_accept', '0'),
(86, 111, 'file_number', '123'),
(87, 111, 'file_matter', '<p>test content</p>'),
(88, 111, 'file_location_id', '109'),
(89, 111, 'last_update_date', '2020-08-12'),
(90, 111, 'case_number', '12345'),
(91, 114, 'file_number', '123'),
(92, 114, 'case_number', '12345'),
(93, 114, 'file_matter', 'test'),
(94, 114, 'file_location_id', '109'),
(95, 114, 'last_update_date', '2020-08-14'),
(96, 115, 'file_number', '123'),
(97, 115, 'case_number', '12345'),
(98, 115, 'file_matter', 'test'),
(99, 115, 'file_location_id', '109'),
(100, 115, 'last_update_date', '2020-08-14'),
(101, 116, 'file_number', '123'),
(102, 116, 'case_number', '12345'),
(103, 116, 'file_matter', 'test'),
(104, 116, 'file_location_id', '109'),
(105, 116, 'last_update_date', '2020-08-14'),
(106, 117, 'file_number', '123'),
(107, 117, 'case_number', '12345'),
(108, 117, 'file_matter', 'test'),
(109, 117, 'file_location_id', '109'),
(110, 117, 'last_update_date', '2020-08-14'),
(111, 118, 'file_number', '123'),
(112, 118, 'case_number', '12345'),
(113, 118, 'file_matter', 'test'),
(114, 118, 'file_location_id', '109'),
(115, 118, 'last_update_date', '2020-08-14'),
(116, 119, 'file_number', '123'),
(117, 119, 'case_number', '12345'),
(118, 119, 'file_matter', 'test'),
(119, 119, 'file_location_id', '109'),
(120, 119, 'last_update_date', '2020-08-14'),
(121, 120, 'file_number', '123'),
(122, 120, 'case_number', '12345'),
(123, 120, 'file_matter', 'test'),
(124, 120, 'file_location_id', '109'),
(125, 120, 'last_update_date', '2020-08-14'),
(126, 128, 'dir_name', 'test_20200816122539'),
(127, 128, 'case_number', '222'),
(128, 129, 'dir_name', 'test_20200816123153'),
(129, 129, 'case_number', '222'),
(130, 130, 'dir_name', 'test_20200816012303'),
(131, 130, 'case_number', '222'),
(132, 130, 'judgement_description', '<p>test content</p>'),
(133, 134, 'email', 'souravsutradhar1993@gmail.com'),
(134, 134, 'mobile', '7777777777'),
(135, 134, 'dob', '2020-08-19'),
(136, 134, 'anniversary', '2020-08-19'),
(137, 134, 'comment', '<p>test content</p>'),
(138, 138, 'message', '<p>Hi</p>\r\n\r\n<p>I am test</p>'),
(139, 140, 'message', '<p>Hi&nbsp;</p>\r\n\r\n<p>I am test</p>'),
(140, 142, 'message', '<p>Hi</p>\r\n\r\n<p>test content</p>'),
(141, 144, 'message', '<p>Hi</p>\r\n\r\n<p>I am test</p>'),
(142, 146, 'message', '<p>Hi&nbsp;</p>\r\n\r\n<p>I am sourav</p>'),
(143, 148, 'message', '<p>test</p>'),
(144, 150, 'message', '<p>Hi</p>\r\n\r\n<p>I am human</p>'),
(145, 152, 'message', '<p>Test content</p>'),
(146, 153, 'message', '<p>Test content</p>'),
(147, 154, 'attachment_path', '2020/08/4g9JBrRtYMagXF7vORbCJjHokDsrUoOjftvTZREK.xlsx'),
(148, 155, 'attachment_path', '2020/08/ocrnIeirAZde9GdFiIzQ5eZufTKUad2bYk1RygHq.xlsx'),
(149, 157, 'message', '<p>Test content</p>'),
(150, 158, 'attachment_path', '2020/08/Xj0CX0zAz8a1OpNsj5GMe2510meY09PsbbF3iQg8.xlsx'),
(151, 159, 'attachment_path', '2020/08/TODlGVAyHba7hXADervYuTShhQwjLZ9sZwZKs2fA.xlsx'),
(152, 161, 'message', '<p>Hi&nbsp;</p>\r\n\r\n<p>This is test</p>'),
(153, 162, 'attachment_path', '2020/08/hXbw0kdJMNIMMD3uaBoW8IsfamyijN9jijheJvAE.xlsx'),
(154, 163, 'attachment_path', '2020/08/PHyrGXqpzLLV7U9JCrnnWOV8mkxCdfst54TH3qBQ.xlsx'),
(155, 165, 'email', 'sourav@gmail.com'),
(156, 165, 'additional_email', 'sourav123@gmail.com'),
(157, 165, 'mobile', '7777777777'),
(158, 165, 'additional_mobile', '8888888888'),
(159, 165, 'dob', '2020-08-18'),
(160, 165, 'anniversary', '2020-08-18'),
(161, 165, 'comment', '<p>xdfgbdg</p>'),
(162, 167, 'dir_name', 'new_case_20200823011759'),
(163, 167, 'case_number', '1234'),
(164, 167, 'client_id', '36'),
(165, 167, 'opponent_id', '37'),
(166, 167, 'court_id', '14'),
(167, 167, 'subcourt_id', '0'),
(168, 167, 'case_category_id', '16'),
(169, 167, 'case_subcategory_id', '0'),
(170, 167, 'case_desc', '<p>zdsfgerdg</p>'),
(171, 167, 'case_doc', 'a:0:{}'),
(172, 167, 'case_status', 'active'),
(173, 168, 'hearing_date', '2020-08-22'),
(174, 170, 'hearing_date', '2020-08-22'),
(175, 172, 'hearing_date', '2019-06-27'),
(176, 173, 'hearing_date', '2019-06-27'),
(177, 175, 'hearing_date', '2019-06-27'),
(178, 177, 'dir_name', 'test_new_20200823094924'),
(179, 177, 'case_number', '9876'),
(180, 177, 'client_id', '36'),
(181, 178, 'dir_name', 'test_new_20200823095013'),
(182, 178, 'case_number', '9876'),
(183, 178, 'client_id', '36'),
(184, 179, 'dir_name', 'test_new_20200823095322'),
(185, 179, 'case_number', '9876'),
(186, 179, 'client_id', '36'),
(187, 180, 'dir_name', 'test_new_20200823095427'),
(188, 180, 'case_number', '9876'),
(189, 180, 'client_id', '36'),
(190, 180, 'opponent_id', '42'),
(191, 180, 'court_id', '14'),
(192, 180, 'subcourt_id', '0'),
(193, 180, 'case_category_id', '16'),
(194, 180, 'case_subcategory_id', '0'),
(195, 180, 'case_desc', '<p>dhsgfnfx</p>'),
(196, 180, 'case_doc', 'a:0:{}'),
(197, 180, 'case_status', 'active'),
(198, 181, 'hearing_date', '2020-08-28'),
(199, 183, 'hearing_date', '2020-08-28'),
(200, 188, 'file_number', 'TEST 2'),
(201, 188, 'case_number', 'CASE 2'),
(202, 188, 'file_matter', '<p>TEST CASE</p>'),
(203, 188, 'file_location_id', '109'),
(204, 188, 'last_update_date', '2020-08-24'),
(205, 190, 'dir_name', 'test_case_2_20200824092601'),
(206, 190, 'case_number', 'CASE 2'),
(207, 190, 'client_id', '43'),
(208, 191, 'dir_name', 'test_4_20200825094900'),
(209, 191, 'case_number', 'Case 4'),
(210, 191, 'client_id', '38'),
(211, 191, 'opponent_id', '45'),
(212, 191, 'court_id', '14'),
(213, 191, 'subcourt_id', '0'),
(214, 191, 'case_category_id', '25'),
(215, 191, 'case_subcategory_id', '0'),
(216, 191, 'case_desc', '<p>TEST CASE 4</p>'),
(217, 191, 'case_doc', 'a:0:{}'),
(218, 191, 'case_status', 'active'),
(219, 192, 'hearing_date', '2020-08-31'),
(220, 264, 'hearing_date', '2020-08-31'),
(221, 285, 'email', 'subhajitkar626@gmail.com'),
(222, 285, 'additional_email', 'subhajitkar626@gmail.com'),
(223, 285, 'mobile', '7468023431'),
(224, 285, 'additional_mobile', '7001582740'),
(225, 285, 'dob', '2020-08-27'),
(226, 285, 'anniversary', '2021-12-23'),
(227, 285, 'comment', '<p>Test Contact</p>'),
(228, 290, 'message', '<p>Testing the contact working&nbsp; or not.</p>'),
(229, 298, 'dir_name', 'test_4_20200827112916'),
(230, 298, 'case_number', 'Case 4'),
(231, 298, 'judgement_description', '<p>Testing Judgement</p>'),
(232, 327, 'file_number', 'FILE 5'),
(233, 327, 'case_number', 'CASE 5'),
(234, 327, 'file_matter', '<p>TEST FILE</p>'),
(235, 327, 'file_location_id', '321'),
(236, 327, 'last_update_date', '2020-08-27'),
(237, 332, 'dir_name', 'test_case_5_20200827032226'),
(238, 332, 'case_number', 'CASE 6'),
(239, 332, 'client_id', '43'),
(240, 332, 'opponent_id', '46'),
(241, 332, 'court_id', '14'),
(242, 332, 'subcourt_id', '0'),
(243, 332, 'case_category_id', '16'),
(244, 332, 'case_subcategory_id', '0'),
(245, 332, 'case_desc', '<p>TEST CASE</p>'),
(246, 332, 'case_doc', 'a:0:{}'),
(247, 332, 'case_status', 'active'),
(248, 333, 'hearing_date', '2020-08-28'),
(249, 337, 'hearing_date', '2020-08-28'),
(250, 350, 'hearing_date', '2020-08-28'),
(251, 353, 'hearing_date', '2020-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `masters`
--

CREATE TABLE `masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `master_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `create_by` int(11) NOT NULL,
  `master_parent_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `masters`
--

INSERT INTO `masters` (`id`, `name`, `master_type`, `active`, `create_by`, `master_parent_id`, `created_at`, `updated_at`) VALUES
(1, 'NEW YEARS DAY', 'holiday', 0, 26, 0, '2020-08-04 05:40:34', '2020-08-05 07:56:26'),
(2, 'Debasmita Sarkar Bhattacharjee created a Holiday \"NEW YEARS DAY\"', 'revision', 1, 26, 1, '2020-08-04 05:40:34', '2020-08-04 05:40:34'),
(3, 'Debasmita Sarkar Bhattacharjee updated Holiday \"NEW YEARS DAY\"', 'revision', 1, 26, 1, '2020-08-04 05:40:43', '2020-08-04 05:40:43'),
(4, 'REPUBLIC DAY', 'holiday', 0, 26, 0, '2020-08-04 05:41:39', '2020-08-05 07:56:31'),
(5, 'Debasmita Sarkar Bhattacharjee created a Holiday \"REPUBLIC DAY\"', 'revision', 1, 26, 4, '2020-08-04 05:41:39', '2020-08-04 05:41:39'),
(6, 'DARSHANA MAZUMDER.pdf', 'attachment', 1, 35, 0, '2020-08-04 06:42:17', '2020-08-04 06:42:17'),
(7, 'Darshana Mazumder uploaded a file \"DARSHANA MAZUMDER.pdf\"', 'revision', 1, 35, 6, '2020-08-04 06:42:17', '2020-08-04 06:42:17'),
(8, 'ANUSHKA MAHATO.pdf', 'attachment', 1, 31, 0, '2020-08-04 06:45:27', '2020-08-04 06:45:27'),
(9, 'Ms. Anushka Mahato uploaded a file \"ANUSHKA MAHATO.pdf\"', 'revision', 1, 31, 8, '2020-08-04 06:45:27', '2020-08-04 06:45:27'),
(10, 'PRIYANKA YADAV.pdf', 'attachment', 1, 30, 0, '2020-08-04 06:48:53', '2020-08-04 06:48:53'),
(11, 'Ms. Priyanka Yadav uploaded a file \"PRIYANKA YADAV.pdf\"', 'revision', 1, 30, 10, '2020-08-04 06:48:53', '2020-08-04 06:48:53'),
(12, 'thumb-1.jpg', 'attachment', 1, 29, 0, '2020-08-04 08:50:45', '2020-08-04 08:50:45'),
(13, 'Alphaxine uploaded a file \"thumb-1.jpg\"', 'revision', 1, 29, 12, '2020-08-04 08:50:45', '2020-08-04 08:50:45'),
(14, '1st ADJ HOWRAH COURT', 'court', 1, 29, 0, '2020-08-04 08:58:31', '2020-08-04 08:58:31'),
(15, 'Alphaxine created a Court \"1st ADJ HOWRAH COURT\"', 'revision', 1, 29, 14, '2020-08-04 08:58:31', '2020-08-04 08:58:31'),
(16, 'Land Acquisition', 'case_category', 1, 29, 0, '2020-08-04 09:03:44', '2020-08-04 09:03:44'),
(17, 'Alphaxine created a Case Category \"Land Acquisition\"', 'revision', 1, 29, 16, '2020-08-04 09:03:44', '2020-08-04 09:03:44'),
(18, 'SUBRATA ASH VS STATE OF WEST BENGAL', 'case', 0, 29, 0, '2020-08-04 09:06:24', '2020-08-10 02:19:01'),
(19, 'case_hearing', 'hearing', 1, 29, 18, '2020-08-04 09:06:26', '2020-08-04 09:06:26'),
(20, 'Alphaxine created a Case \"SUBRATA ASH VS STATE OF WEST BENGAL\"', 'revision', 1, 29, 18, '2020-08-04 09:06:26', '2020-08-04 09:06:26'),
(21, 'case_hearing', 'hearing', 1, 29, 18, '2020-08-04 09:10:46', '2020-08-04 09:10:46'),
(22, 'Alphaxine updated Case \"SUBRATA ASH VS STATE OF WEST BENGAL\"', 'revision', 1, 29, 18, '2020-08-04 09:10:46', '2020-08-04 09:10:46'),
(23, 'II BENCH(SAT)', 'court', 1, 29, 0, '2020-08-04 09:16:08', '2020-08-04 09:16:08'),
(24, 'Alphaxine created a Court \"II BENCH(SAT)\"', 'revision', 1, 29, 23, '2020-08-04 09:16:08', '2020-08-04 09:16:08'),
(25, 'UNKNOWN', 'case_category', 1, 29, 0, '2020-08-04 09:16:43', '2020-08-04 09:16:43'),
(26, 'Alphaxine created a Case Category \"UNKNOWN\"', 'revision', 1, 29, 25, '2020-08-04 09:16:43', '2020-08-04 09:16:43'),
(27, 'NASHIRAM JOSH VS STATE OF WEST BENGAL', 'case', 1, 29, 0, '2020-08-04 09:19:38', '2020-08-04 09:19:38'),
(28, 'case_hearing', 'hearing', 1, 29, 27, '2020-08-04 09:19:39', '2020-08-04 09:19:39'),
(29, 'Alphaxine created a Case \"NASHIRAM JOSH VS STATE OF WEST BENGAL\"', 'revision', 1, 29, 27, '2020-08-04 09:19:39', '2020-08-04 09:19:39'),
(30, 'CHRISTMAS', 'holiday', 0, 26, 0, '2020-08-05 07:45:15', '2020-08-05 07:55:51'),
(31, 'Debasmita Sarkar Bhattacharjee created a Holiday \"SARASWATI PUUJA\"', 'revision', 1, 26, 30, '2020-08-05 07:45:15', '2020-08-05 07:45:15'),
(32, 'Debasmita Sarkar Bhattacharjee updated Holiday \"BENGALI NEW YEAR\"', 'revision', 1, 26, 30, '2020-08-05 07:46:09', '2020-08-05 07:46:09'),
(33, 'Debasmita Sarkar Bhattacharjee updated Holiday \"INDEPENDENCE DAY\"', 'revision', 1, 26, 30, '2020-08-05 07:47:56', '2020-08-05 07:47:56'),
(34, 'Debasmita Sarkar Bhattacharjee updated Holiday \"MAHALAYA\"', 'revision', 1, 26, 30, '2020-08-05 07:49:01', '2020-08-05 07:49:01'),
(35, 'Debasmita Sarkar Bhattacharjee updated Holiday \"GANDHI JAYANTI\"', 'revision', 1, 26, 30, '2020-08-05 07:49:18', '2020-08-05 07:49:18'),
(36, 'Debasmita Sarkar Bhattacharjee updated Holiday \"DURGA PUJA\"', 'revision', 1, 26, 30, '2020-08-05 07:49:50', '2020-08-05 07:49:50'),
(37, 'Debasmita Sarkar Bhattacharjee updated Holiday \"DURGA PUJA\"', 'revision', 1, 26, 30, '2020-08-05 07:49:55', '2020-08-05 07:49:55'),
(38, 'Debasmita Sarkar Bhattacharjee updated Holiday \"DURGA PUJA\"', 'revision', 1, 26, 30, '2020-08-05 07:49:59', '2020-08-05 07:49:59'),
(39, 'Debasmita Sarkar Bhattacharjee updated Holiday \"DURGA PUJA\"', 'revision', 1, 26, 30, '2020-08-05 07:50:04', '2020-08-05 07:50:04'),
(40, 'Debasmita Sarkar Bhattacharjee updated Holiday \"DURGA PUJA\"', 'revision', 1, 26, 30, '2020-08-05 07:50:29', '2020-08-05 07:50:29'),
(41, 'Debasmita Sarkar Bhattacharjee updated Holiday \"LAXMI PUJA\"', 'revision', 1, 26, 30, '2020-08-05 07:50:54', '2020-08-05 07:50:54'),
(42, 'Debasmita Sarkar Bhattacharjee updated Holiday \"KALI PUJA\"', 'revision', 1, 26, 30, '2020-08-05 07:51:10', '2020-08-05 07:51:10'),
(43, 'Debasmita Sarkar Bhattacharjee updated Holiday \"CHRISTMAS\"', 'revision', 1, 26, 30, '2020-08-05 07:51:34', '2020-08-05 07:51:34'),
(44, 'Independence Day', 'holiday', 0, 29, 0, '2020-08-05 07:54:38', '2020-08-05 07:56:04'),
(45, 'Alphaxine created a Holiday \"Independence Day\"', 'revision', 1, 29, 44, '2020-08-05 07:54:38', '2020-08-05 07:54:38'),
(46, 'REPUBLIC DAY', 'holiday', 0, 26, 0, '2020-08-05 07:55:12', '2020-08-05 07:56:29'),
(47, 'Debasmita Sarkar Bhattacharjee created a Holiday \"REPUBLIC DAY\"', 'revision', 1, 26, 46, '2020-08-05 07:55:12', '2020-08-05 07:55:12'),
(48, 'Debasmita Sarkar Bhattacharjee deleted Holiday \"CHRISTMAS\"', 'revision', 1, 26, 30, '2020-08-05 07:55:51', '2020-08-05 07:55:51'),
(49, 'Debasmita Sarkar Bhattacharjee deleted Holiday \"Independence Day\"', 'revision', 1, 26, 44, '2020-08-05 07:56:04', '2020-08-05 07:56:04'),
(50, 'Debasmita Sarkar Bhattacharjee deleted Holiday \"NEW YEARS DAY\"', 'revision', 1, 26, 1, '2020-08-05 07:56:26', '2020-08-05 07:56:26'),
(51, 'Debasmita Sarkar Bhattacharjee deleted Holiday \"REPUBLIC DAY\"', 'revision', 1, 26, 46, '2020-08-05 07:56:29', '2020-08-05 07:56:29'),
(52, 'Debasmita Sarkar Bhattacharjee deleted Holiday \"REPUBLIC DAY\"', 'revision', 1, 26, 4, '2020-08-05 07:56:31', '2020-08-05 07:56:31'),
(53, 'NEW YEARS DAY', 'holiday', 1, 26, 0, '2020-08-05 07:56:49', '2020-08-05 07:56:49'),
(54, 'Debasmita Sarkar Bhattacharjee created a Holiday \"NEW YEARS DAY\"', 'revision', 1, 26, 53, '2020-08-05 07:56:49', '2020-08-05 07:56:49'),
(55, 'REPUBLIC DAY', 'holiday', 1, 26, 0, '2020-08-05 07:59:02', '2020-08-05 07:59:02'),
(56, 'Debasmita Sarkar Bhattacharjee created a Holiday \"REPUBLIC DAY\"', 'revision', 1, 26, 55, '2020-08-05 07:59:02', '2020-08-05 07:59:02'),
(57, 'SARASWATI PUJA', 'holiday', 1, 26, 0, '2020-08-05 07:59:23', '2020-08-05 07:59:23'),
(58, 'Debasmita Sarkar Bhattacharjee created a Holiday \"SARASWATI PUJA\"', 'revision', 1, 26, 57, '2020-08-05 07:59:23', '2020-08-05 07:59:23'),
(59, 'DOL YATRA', 'holiday', 1, 26, 0, '2020-08-05 07:59:50', '2020-08-05 07:59:50'),
(60, 'Debasmita Sarkar Bhattacharjee created a Holiday \"DOL YATRA\"', 'revision', 1, 26, 59, '2020-08-05 07:59:50', '2020-08-05 07:59:50'),
(61, 'BENGALI NEW YEAR', 'holiday', 1, 26, 0, '2020-08-05 08:00:25', '2020-08-05 08:00:25'),
(62, 'Debasmita Sarkar Bhattacharjee created a Holiday \"BENGALI NEW YEAR\"', 'revision', 1, 26, 61, '2020-08-05 08:00:25', '2020-08-05 08:00:25'),
(63, 'INDEPENDENCE DAY', 'holiday', 1, 26, 0, '2020-08-05 08:01:01', '2020-08-05 08:01:01'),
(64, 'Debasmita Sarkar Bhattacharjee created a Holiday \"INDEPENDENCE DAY\"', 'revision', 1, 26, 63, '2020-08-05 08:01:01', '2020-08-05 08:01:01'),
(65, 'MAHALAYA', 'holiday', 1, 26, 0, '2020-08-05 08:01:21', '2020-08-05 08:01:21'),
(66, 'Debasmita Sarkar Bhattacharjee created a Holiday \"MAHALAYA\"', 'revision', 1, 26, 65, '2020-08-05 08:01:21', '2020-08-05 08:01:21'),
(67, 'GANDHI JAYANTI', 'holiday', 1, 26, 0, '2020-08-05 08:02:03', '2020-08-05 08:02:03'),
(68, 'Debasmita Sarkar Bhattacharjee created a Holiday \"GANDHI JAYANTI\"', 'revision', 1, 26, 67, '2020-08-05 08:02:03', '2020-08-05 08:02:03'),
(69, 'DURGA PUJA', 'holiday', 1, 26, 0, '2020-08-05 08:02:24', '2020-08-05 08:02:24'),
(70, 'Debasmita Sarkar Bhattacharjee created a Holiday \"DURGA PUJA\"', 'revision', 1, 26, 69, '2020-08-05 08:02:24', '2020-08-05 08:02:24'),
(71, 'DURGA PUJA', 'holiday', 1, 26, 0, '2020-08-05 08:02:36', '2020-08-05 08:02:36'),
(72, 'Debasmita Sarkar Bhattacharjee created a Holiday \"DURGA PUJA\"', 'revision', 1, 26, 71, '2020-08-05 08:02:36', '2020-08-05 08:02:36'),
(73, 'DURGA PUJA', 'holiday', 1, 26, 0, '2020-08-05 08:03:05', '2020-08-05 08:03:05'),
(74, 'Debasmita Sarkar Bhattacharjee created a Holiday \"DURGA PUJA\"', 'revision', 1, 26, 73, '2020-08-05 08:03:05', '2020-08-05 08:03:05'),
(75, 'DURGA PUJA', 'holiday', 1, 26, 0, '2020-08-05 08:03:24', '2020-08-05 08:03:24'),
(76, 'Debasmita Sarkar Bhattacharjee created a Holiday \"DURGA PUJA\"', 'revision', 1, 26, 75, '2020-08-05 08:03:24', '2020-08-05 08:03:24'),
(77, 'LAXMI PUJA', 'holiday', 1, 26, 0, '2020-08-05 08:03:46', '2020-08-05 08:03:46'),
(78, 'Debasmita Sarkar Bhattacharjee created a Holiday \"LAXMI PUJA\"', 'revision', 1, 26, 77, '2020-08-05 08:03:46', '2020-08-05 08:03:46'),
(79, 'KAALI PUJA', 'holiday', 1, 26, 0, '2020-08-05 08:04:17', '2020-08-05 08:04:17'),
(80, 'Debasmita Sarkar Bhattacharjee created a Holiday \"KAALI PUJA\"', 'revision', 1, 26, 79, '2020-08-05 08:04:17', '2020-08-05 08:04:17'),
(81, 'CHRISTMAS', 'holiday', 1, 26, 0, '2020-08-05 08:04:32', '2020-08-05 08:04:32'),
(82, 'Debasmita Sarkar Bhattacharjee created a Holiday \"CHRISTMAS\"', 'revision', 1, 26, 81, '2020-08-05 08:04:32', '2020-08-05 08:04:32'),
(83, 'Bengali New Year', 'holiday', 0, 29, 0, '2020-08-05 09:16:36', '2020-08-05 09:16:54'),
(84, 'Alphaxine created a Holiday \"Bengali New Year\"', 'revision', 1, 29, 83, '2020-08-05 09:16:36', '2020-08-05 09:16:36'),
(85, 'Alphaxine deleted Holiday \"Bengali New Year\"', 'revision', 1, 29, 83, '2020-08-05 09:16:54', '2020-08-05 09:16:54'),
(86, 'Accounts', 'todo', 1, 30, 0, '2020-08-05 12:55:44', '2020-08-05 12:55:44'),
(87, 'Ms. Priyanka Yadav created a Todo \"Accounts\"', 'revision', 1, 30, 86, '2020-08-05 12:55:44', '2020-08-05 12:55:44'),
(88, 'Ms. Priyanka Yadav updated Todo \"Accounts\"', 'revision', 1, 30, 86, '2020-08-05 12:55:52', '2020-08-05 12:55:52'),
(89, 'Test', 'evaluation', 1, 29, 0, '2020-08-09 03:21:44', '2020-08-09 03:21:44'),
(90, 'Alphaxine created a Assessment \"Test\"', 'revision', 1, 29, 89, '2020-08-09 03:21:45', '2020-08-09 03:21:45'),
(91, 'Alphaxine updated Assessment \"Test\"', 'revision', 1, 29, 89, '2020-08-09 03:25:33', '2020-08-09 03:25:33'),
(92, 'Alphaxine updated Assessment \"Test\"', 'revision', 1, 29, 89, '2020-08-09 03:36:57', '2020-08-09 03:36:57'),
(93, 'Alphaxine updated Assessment \"Test\"', 'revision', 1, 29, 89, '2020-08-09 03:41:44', '2020-08-09 03:41:44'),
(94, 'Test', 'incident', 1, 29, 0, '2020-08-09 04:19:38', '2020-08-09 04:19:38'),
(95, 'Alphaxine created a Incident \"Test\"', 'revision', 1, 29, 94, '2020-08-09 04:19:38', '2020-08-09 04:19:38'),
(96, 'Incident Comment', 'incident_comment', 1, 34, 94, '2020-08-09 04:28:01', '2020-08-09 04:28:01'),
(97, 'Haimantika Chaudhuri commented on a incident \"Test\"', 'revision', 1, 34, 94, '2020-08-09 04:28:01', '2020-08-09 04:28:01'),
(98, 'Alphaxine updated Todo \"Accounts\"', 'revision', 1, 29, 86, '2020-08-09 04:52:08', '2020-08-09 04:52:08'),
(99, 'West Bengal', 'state', 0, 29, 0, '2020-08-09 21:45:43', '2020-08-10 02:18:10'),
(100, 'Alphaxine created a State \"West Bengal\"', 'revision', 1, 29, 99, '2020-08-09 21:45:43', '2020-08-09 21:45:43'),
(101, 'Maharastra', 'state', 0, 29, 0, '2020-08-09 21:46:13', '2020-08-10 02:16:50'),
(102, 'Alphaxine created a State \"Maharastra\"', 'revision', 1, 29, 101, '2020-08-09 21:46:13', '2020-08-09 21:46:13'),
(103, 'Alphaxine deleted State \"West Bengal\"', 'revision', 1, 29, 99, '2020-08-10 02:18:10', '2020-08-10 02:18:10'),
(104, 'Alphaxine deleted Case \"SUBRATA ASH VS STATE OF WEST BENGAL\"', 'revision', 1, 29, 18, '2020-08-10 02:19:01', '2020-08-10 02:19:01'),
(105, 'Alphaxine updated Assessment \"Test\"', 'revision', 1, 29, 89, '2020-08-12 09:21:19', '2020-08-12 09:21:19'),
(106, 'Test 1', 'evaluation', 1, 29, 0, '2020-08-12 09:25:01', '2020-08-12 09:25:01'),
(107, 'Alphaxine created a Assessment \"Test 1\"', 'revision', 1, 29, 106, '2020-08-12 09:25:01', '2020-08-12 09:25:01'),
(108, 'Alphaxine updated Todo \"Accounts\"', 'revision', 1, 29, 86, '2020-08-12 09:54:51', '2020-08-12 09:54:51'),
(109, 'High Court', 'file_location', 1, 29, 0, '2020-08-14 07:58:32', '2020-08-14 07:58:32'),
(110, 'Alphaxine created a Location \"High Court\"', 'revision', 1, 29, 109, '2020-08-14 07:58:32', '2020-08-14 07:58:32'),
(111, 'Test', 'file_manager', 0, 29, 0, '2020-08-14 08:22:10', '2020-08-16 04:08:41'),
(112, 'Alphaxine created a File Manager \"Test\"', 'revision', 1, 29, 111, '2020-08-14 08:22:10', '2020-08-14 08:22:10'),
(113, 'Alphaxine updated File Manager \"Test\"', 'revision', 1, 29, 111, '2020-08-14 08:24:59', '2020-08-14 08:24:59'),
(114, 'Test', 'file_manager', 0, 29, 0, '2020-08-16 04:07:48', '2020-08-16 04:08:41'),
(115, 'Test', 'file_manager', 1, 29, 0, '2020-08-16 04:07:49', '2020-08-16 04:07:49'),
(116, 'Test', 'file_manager', 0, 29, 0, '2020-08-16 04:07:49', '2020-08-16 04:08:41'),
(117, 'Test', 'file_manager', 0, 29, 0, '2020-08-16 04:07:49', '2020-08-16 04:08:41'),
(118, 'Test', 'file_manager', 0, 29, 0, '2020-08-16 04:07:49', '2020-08-16 04:08:41'),
(119, 'Test', 'file_manager', 0, 29, 0, '2020-08-16 04:07:49', '2020-08-16 04:08:41'),
(120, 'Test', 'file_manager', 0, 29, 0, '2020-08-16 04:07:49', '2020-08-16 04:08:41'),
(121, 'Alphaxine deleted File Manager \"Test\"', 'revision', 1, 29, 116, '2020-08-16 04:08:41', '2020-08-16 04:08:41'),
(122, 'Alphaxine deleted File Manager \"Test\"', 'revision', 1, 29, 117, '2020-08-16 04:08:41', '2020-08-16 04:08:41'),
(123, 'Alphaxine deleted File Manager \"Test\"', 'revision', 1, 29, 118, '2020-08-16 04:08:41', '2020-08-16 04:08:41'),
(124, 'Alphaxine deleted File Manager \"Test\"', 'revision', 1, 29, 119, '2020-08-16 04:08:41', '2020-08-16 04:08:41'),
(125, 'Alphaxine deleted File Manager \"Test\"', 'revision', 1, 29, 120, '2020-08-16 04:08:41', '2020-08-16 04:08:41'),
(126, 'Alphaxine deleted File Manager \"Test\"', 'revision', 1, 29, 114, '2020-08-16 04:08:41', '2020-08-16 04:08:41'),
(127, 'Alphaxine deleted File Manager \"Test\"', 'revision', 1, 29, 111, '2020-08-16 04:08:41', '2020-08-16 04:08:41'),
(128, 'Test', 'judgement', 1, 29, 0, '2020-08-16 07:25:39', '2020-08-16 07:25:39'),
(129, 'Test', 'judgement', 1, 29, 0, '2020-08-16 07:31:53', '2020-08-16 07:31:53'),
(130, 'Test', 'judgement', 1, 29, 0, '2020-08-16 08:23:03', '2020-08-16 08:23:03'),
(131, 'Alphaxine created a Judgement \"Test\"', 'revision', 1, 29, 130, '2020-08-16 08:23:07', '2020-08-16 08:23:07'),
(132, 'Alphaxine updated Judgement \"Test\"', 'revision', 1, 29, 130, '2020-08-16 08:23:41', '2020-08-16 08:23:41'),
(133, 'Alphaxine updated Judgement \"Test\"', 'revision', 1, 29, 130, '2020-08-16 08:25:20', '2020-08-16 08:25:20'),
(134, 'Test', 'contact', 1, 29, 0, '2020-08-16 10:20:06', '2020-08-16 10:20:06'),
(135, 'Alphaxine created a Contact \"Test\"', 'revision', 1, 29, 134, '2020-08-16 10:20:06', '2020-08-16 10:20:06'),
(136, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-16 22:04:38', '2020-08-16 22:04:38'),
(137, 'Alphaxine updated Contact \"Test\"', 'revision', 1, 29, 134, '2020-08-17 00:20:46', '2020-08-17 00:20:46'),
(138, 'Greeting', 'email', 1, 29, 0, '2020-08-17 00:22:29', '2020-08-17 00:22:29'),
(139, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 00:22:29', '2020-08-17 00:22:29'),
(140, 'Greeting', 'email', 1, 29, 0, '2020-08-17 00:27:23', '2020-08-17 00:27:23'),
(141, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 00:27:23', '2020-08-17 00:27:23'),
(142, 'Greeting', 'email', 1, 29, 134, '2020-08-17 02:00:20', '2020-08-17 02:00:20'),
(143, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 02:00:20', '2020-08-17 02:00:20'),
(144, 'Greeting', 'email', 1, 29, 134, '2020-08-17 02:14:56', '2020-08-17 02:14:56'),
(145, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 02:14:56', '2020-08-17 02:14:56'),
(146, 'Greeting', 'email', 1, 29, 134, '2020-08-17 02:24:53', '2020-08-17 02:24:53'),
(147, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 02:24:53', '2020-08-17 02:24:53'),
(148, 'Greet', 'email', 1, 29, 134, '2020-08-17 02:26:00', '2020-08-17 02:26:00'),
(149, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 02:26:00', '2020-08-17 02:26:00'),
(150, 'Greeting', 'email', 1, 29, 134, '2020-08-17 03:17:21', '2020-08-17 03:17:21'),
(151, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 03:17:21', '2020-08-17 03:17:21'),
(152, 'Test Mail', 'email', 1, 29, 134, '2020-08-17 03:27:52', '2020-08-17 03:27:52'),
(153, 'Test Mail', 'email', 1, 29, 134, '2020-08-17 03:32:05', '2020-08-17 03:32:05'),
(154, 'Email Attachment', 'attachment', 1, 29, 153, '2020-08-17 03:32:05', '2020-08-17 03:32:05'),
(155, 'Email Attachment', 'attachment', 1, 29, 153, '2020-08-17 03:32:05', '2020-08-17 03:32:05'),
(156, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 03:32:05', '2020-08-17 03:32:05'),
(157, 'Greetings', 'email', 1, 29, 134, '2020-08-17 04:48:56', '2020-08-17 04:48:56'),
(158, 'Email Attachment', 'attachment', 1, 29, 157, '2020-08-17 04:48:56', '2020-08-17 04:48:56'),
(159, 'Email Attachment', 'attachment', 1, 29, 157, '2020-08-17 04:48:56', '2020-08-17 04:48:56'),
(160, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 04:48:56', '2020-08-17 04:48:56'),
(161, 'Greetings', 'email', 1, 29, 134, '2020-08-17 05:38:23', '2020-08-17 05:38:23'),
(162, 'Email Attachment', 'attachment', 1, 29, 161, '2020-08-17 05:38:23', '2020-08-17 05:38:23'),
(163, 'Email Attachment', 'attachment', 1, 29, 161, '2020-08-17 05:38:23', '2020-08-17 05:38:23'),
(164, 'Alphaxine send an email to Test', 'revision', 1, 29, 134, '2020-08-17 05:38:23', '2020-08-17 05:38:23'),
(165, 'sourav', 'contact', 1, 29, 0, '2020-08-19 09:01:51', '2020-08-19 09:01:51'),
(166, 'Alphaxine created a Contact \"sourav\"', 'revision', 1, 29, 165, '2020-08-19 09:01:51', '2020-08-19 09:01:51'),
(167, 'New Case', 'case', 1, 29, 0, '2020-08-23 20:17:59', '2020-08-23 20:17:59'),
(168, 'case_hearing', 'hearing', 1, 29, 167, '2020-08-23 20:18:05', '2020-08-23 20:18:05'),
(169, 'Alphaxine created a Case \"New Case\"', 'revision', 1, 29, 167, '2020-08-23 20:18:07', '2020-08-23 20:18:07'),
(170, 'case_hearing', 'hearing', 1, 29, 167, '2020-08-23 20:18:18', '2020-08-23 20:18:18'),
(171, 'Alphaxine updated Case \"New Case\"', 'revision', 1, 29, 167, '2020-08-23 20:18:18', '2020-08-23 20:18:18'),
(172, 'case_hearing', 'hearing', 1, 29, 27, '2020-08-23 20:54:59', '2020-08-23 20:54:59'),
(173, 'case_hearing', 'hearing', 1, 29, 27, '2020-08-23 20:56:13', '2020-08-23 20:56:13'),
(174, 'Alphaxine updated Case \"NASHIRAM JOSH VS STATE OF WEST BENGAL\"', 'revision', 1, 29, 27, '2020-08-23 20:56:14', '2020-08-23 20:56:14'),
(175, 'case_hearing', 'hearing', 1, 29, 27, '2020-08-23 20:56:23', '2020-08-23 20:56:23'),
(176, 'Alphaxine updated Case \"NASHIRAM JOSH VS STATE OF WEST BENGAL\"', 'revision', 1, 29, 27, '2020-08-23 20:56:23', '2020-08-23 20:56:23'),
(177, 'Test New', 'case', 0, 29, 0, '2020-08-24 04:49:24', '2020-08-24 04:55:41'),
(178, 'Test New', 'case', 0, 29, 0, '2020-08-24 04:50:13', '2020-08-24 04:55:41'),
(179, 'Test New', 'case', 0, 29, 0, '2020-08-24 04:53:22', '2020-08-24 04:55:41'),
(180, 'Test New', 'case', 1, 29, 0, '2020-08-24 04:54:27', '2020-08-24 04:54:27'),
(181, 'case_hearing', 'hearing', 1, 29, 180, '2020-08-24 04:54:31', '2020-08-24 04:54:31'),
(182, 'Alphaxine created a Case \"Test New\"', 'revision', 1, 29, 180, '2020-08-24 04:54:31', '2020-08-24 04:54:31'),
(183, 'case_hearing', 'hearing', 1, 29, 180, '2020-08-24 04:55:03', '2020-08-24 04:55:03'),
(184, 'Alphaxine updated Case \"Test New\"', 'revision', 1, 29, 180, '2020-08-24 04:55:03', '2020-08-24 04:55:03'),
(185, 'Alphaxine deleted Case \"Test New\"', 'revision', 1, 29, 179, '2020-08-24 04:55:41', '2020-08-24 04:55:41'),
(186, 'Alphaxine deleted Case \"Test New\"', 'revision', 1, 29, 178, '2020-08-24 04:55:41', '2020-08-24 04:55:41'),
(187, 'Alphaxine deleted Case \"Test New\"', 'revision', 1, 29, 177, '2020-08-24 04:55:41', '2020-08-24 04:55:41'),
(188, 'TEST 2', 'file_manager', 1, 29, 0, '2020-08-24 16:24:09', '2020-08-24 16:24:09'),
(189, 'Alphaxine created a File Manager \"TEST 2\"', 'revision', 1, 29, 188, '2020-08-24 16:24:09', '2020-08-24 16:24:09'),
(190, 'TEST CASE 2', 'case', 1, 29, 0, '2020-08-24 16:26:01', '2020-08-24 16:26:01'),
(191, 'Test 4', 'case', 1, 29, 0, '2020-08-25 16:49:00', '2020-08-25 16:49:00'),
(192, 'case_hearing', 'hearing', 1, 29, 191, '2020-08-25 16:49:05', '2020-08-25 16:49:05'),
(193, 'Alphaxine created a Case \"Test 4\"', 'revision', 1, 29, 191, '2020-08-25 16:49:05', '2020-08-25 16:49:05'),
(194, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-27 16:15:49', '2020-08-27 16:15:49'),
(195, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-27 16:16:28', '2020-08-27 16:16:28'),
(196, 'Alphaxine opened edit Samay Ghosh', 'revision', 1, 29, 0, '2020-08-27 16:16:56', '2020-08-27 16:16:56'),
(197, 'Alphaxine opened edit Darshana Mazumder', 'revision', 1, 29, 0, '2020-08-27 16:17:16', '2020-08-27 16:17:16'),
(198, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:17:41', '2020-08-27 16:17:41'),
(199, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:18:09', '2020-08-27 16:18:09'),
(200, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:18:29', '2020-08-27 16:18:29'),
(201, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:18:41', '2020-08-27 16:18:41'),
(202, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:18:48', '2020-08-27 16:18:48'),
(203, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:19:14', '2020-08-27 16:19:14'),
(204, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-27 16:19:30', '2020-08-27 16:19:30'),
(205, 'Alphaxine opened edit Haimantika Chaudhuri', 'revision', 1, 29, 0, '2020-08-27 16:19:40', '2020-08-27 16:19:40'),
(206, 'Alphaxine opened edit Tulip De', 'revision', 1, 29, 0, '2020-08-27 16:19:57', '2020-08-27 16:19:57'),
(207, 'Haimantika Chaudhuri opened dashboard', 'revision', 1, 34, 0, '2020-08-27 16:21:56', '2020-08-27 16:21:56'),
(208, 'Tulip De opened dashboard', 'revision', 1, 40, 0, '2020-08-27 16:23:13', '2020-08-27 16:23:13'),
(209, 'Darshana Mazumder opened dashboard', 'revision', 1, 35, 0, '2020-08-27 16:23:54', '2020-08-27 16:23:54'),
(210, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-27 16:24:20', '2020-08-27 16:24:20'),
(211, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:24:35', '2020-08-27 16:24:35'),
(212, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:25:16', '2020-08-27 16:25:16'),
(213, 'Alphaxine open approve attendence for Darshana Mazumder', 'revision', 1, 29, 0, '2020-08-27 16:25:47', '2020-08-27 16:25:47'),
(214, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:26:07', '2020-08-27 16:26:07'),
(215, 'Alphaxine open approve attendence for Haimantika Chaudhuri', 'revision', 1, 29, 0, '2020-08-27 16:27:07', '2020-08-27 16:27:07'),
(216, 'Alphaxine open approve attendence for Haimantika Chaudhuri', 'revision', 1, 29, 0, '2020-08-27 16:27:57', '2020-08-27 16:27:57'),
(217, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:28:31', '2020-08-27 16:28:31'),
(218, 'Alphaxine open approve attendence for Tulip De', 'revision', 1, 29, 0, '2020-08-27 16:29:03', '2020-08-27 16:29:03'),
(219, 'Alphaxine approved an attendence for Tulip De', 'revision', 1, 29, 0, '2020-08-27 16:30:38', '2020-08-27 16:30:38'),
(220, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:30:39', '2020-08-27 16:30:39'),
(221, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:31:08', '2020-08-27 16:31:08'),
(222, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-27 16:31:18', '2020-08-27 16:31:18'),
(223, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 16:32:32', '2020-08-27 16:32:32'),
(224, 'Alphaxine opened edit Case', 'revision', 1, 29, 191, '2020-08-27 16:32:48', '2020-08-27 16:32:48'),
(225, 'Alphaxine uploaded a file to a case \"Test 4\"', 'revision', 1, 29, 191, '2020-08-27 16:46:26', '2020-08-27 16:46:26'),
(226, 'Alphaxine deleted a file of a case \"Test 4\"', 'revision', 1, 29, 191, '2020-08-27 16:47:31', '2020-08-27 16:47:31'),
(227, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 16:47:42', '2020-08-27 16:47:42'),
(228, 'Alphaxine opened edit Case', 'revision', 1, 29, 191, '2020-08-27 16:48:28', '2020-08-27 16:48:28'),
(229, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-27 16:49:45', '2020-08-27 16:49:45'),
(230, 'Alphaxine opened edit Client Test', 'revision', 1, 29, 0, '2020-08-27 16:49:52', '2020-08-27 16:49:52'),
(231, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-27 16:51:20', '2020-08-27 16:51:20'),
(232, 'Alphaxine opened edit Client Test', 'revision', 1, 29, 0, '2020-08-27 16:51:26', '2020-08-27 16:51:26'),
(233, 'Alphaxine opened Office Associate', 'revision', 1, 29, 0, '2020-08-27 16:51:58', '2020-08-27 16:51:58'),
(234, 'Alphaxine opened Client', 'revision', 1, 29, 0, '2020-08-27 16:52:06', '2020-08-27 16:52:06'),
(235, 'Alphaxine opened edit Decard Shaw', 'revision', 1, 29, 0, '2020-08-27 16:52:14', '2020-08-27 16:52:14'),
(236, 'Alphaxine opened Client', 'revision', 1, 29, 0, '2020-08-27 16:52:45', '2020-08-27 16:52:45'),
(237, 'Alphaxine opened edit Nashiram Josh', 'revision', 1, 29, 0, '2020-08-27 16:52:52', '2020-08-27 16:52:52'),
(238, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-27 16:53:44', '2020-08-27 16:53:44'),
(239, 'Alphaxine opened edit Tulip De', 'revision', 1, 29, 0, '2020-08-27 16:54:00', '2020-08-27 16:54:00'),
(240, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-27 16:56:04', '2020-08-27 16:56:04'),
(241, 'Alphaxine opened edit Tulip De', 'revision', 1, 29, 0, '2020-08-27 16:59:30', '2020-08-27 16:59:30'),
(242, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-27 17:07:32', '2020-08-27 17:07:32'),
(243, 'Alphaxine opened edit Tulip De', 'revision', 1, 29, 0, '2020-08-27 17:07:40', '2020-08-27 17:07:40'),
(244, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 17:08:02', '2020-08-27 17:08:02'),
(245, 'Alphaxine opened File Manager', 'revision', 1, 29, 0, '2020-08-27 17:08:58', '2020-08-27 17:08:58'),
(246, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-27 17:09:12', '2020-08-27 17:09:12'),
(247, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 130, '2020-08-27 17:09:21', '2020-08-27 17:09:21'),
(248, 'Alphaxine updated Judgement \"Test\"', 'revision', 1, 29, 130, '2020-08-27 17:11:26', '2020-08-27 17:11:26'),
(249, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 130, '2020-08-27 17:11:27', '2020-08-27 17:11:27'),
(250, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-27 17:11:53', '2020-08-27 17:11:53'),
(251, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 130, '2020-08-27 17:11:59', '2020-08-27 17:11:59'),
(252, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-27 17:12:14', '2020-08-27 17:12:14'),
(253, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 129, '2020-08-27 17:12:20', '2020-08-27 17:12:20'),
(254, 'Alphaxine opened File Manager', 'revision', 1, 29, 0, '2020-08-27 17:12:37', '2020-08-27 17:12:37'),
(255, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-27 17:12:57', '2020-08-27 17:12:57'),
(256, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 128, '2020-08-27 17:13:04', '2020-08-27 17:13:04'),
(257, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-27 17:13:14', '2020-08-27 17:13:14'),
(258, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 130, '2020-08-27 17:13:21', '2020-08-27 17:13:21'),
(259, 'Alphaxine opened create Case', 'revision', 1, 29, 0, '2020-08-27 17:13:30', '2020-08-27 17:13:30'),
(260, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 17:13:44', '2020-08-27 17:13:44'),
(261, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-27 17:13:46', '2020-08-27 17:13:46'),
(262, 'Alphaxine opened edit Case', 'revision', 1, 29, 191, '2020-08-27 17:13:54', '2020-08-27 17:13:54'),
(263, 'Alphaxine uploaded a file to a case \"Test 4\"', 'revision', 1, 29, 191, '2020-08-27 17:14:39', '2020-08-27 17:14:39'),
(264, 'case_hearing', 'hearing', 1, 29, 191, '2020-08-27 17:14:59', '2020-08-27 17:14:59'),
(265, 'Alphaxine updated Case \"Test 4\"', 'revision', 1, 29, 191, '2020-08-27 17:14:59', '2020-08-27 17:14:59'),
(266, 'Alphaxine opened edit Case', 'revision', 1, 29, 191, '2020-08-27 17:15:00', '2020-08-27 17:15:00'),
(267, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 17:15:39', '2020-08-27 17:15:39'),
(268, 'Alphaxine opened edit Case', 'revision', 1, 29, 191, '2020-08-27 17:15:52', '2020-08-27 17:15:52'),
(269, 'Alphaxine opened Office Associate', 'revision', 1, 29, 0, '2020-08-27 18:18:13', '2020-08-27 18:18:13'),
(270, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-27 18:18:22', '2020-08-27 18:18:22'),
(271, 'Alphaxine opened Client', 'revision', 1, 29, 0, '2020-08-27 18:18:29', '2020-08-27 18:18:29'),
(272, 'Alphaxine opened edit Decard Shaw', 'revision', 1, 29, 0, '2020-08-27 18:18:34', '2020-08-27 18:18:34'),
(273, 'Alphaxine opened edit Decard Shaw', 'revision', 1, 29, 0, '2020-08-27 18:19:17', '2020-08-27 18:19:17'),
(274, 'Alphaxine opened edit Decard Shaw', 'revision', 1, 29, 0, '2020-08-27 18:19:35', '2020-08-27 18:19:35'),
(275, 'Alphaxine opened create File Manager', 'revision', 1, 29, 0, '2020-08-27 18:19:55', '2020-08-27 18:19:55'),
(276, 'Alphaxine opened File Manager', 'revision', 1, 29, 0, '2020-08-27 18:20:02', '2020-08-27 18:20:02'),
(277, 'Alphaxine opened edit File Manager', 'revision', 1, 29, 188, '2020-08-27 18:20:07', '2020-08-27 18:20:07'),
(278, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-27 18:20:41', '2020-08-27 18:20:41'),
(279, 'Alphaxine opened Sourav in contacts send email', 'revision', 1, 29, 165, '2020-08-27 18:20:50', '2020-08-27 18:20:50'),
(280, 'Alphaxine opened edit Contact', 'revision', 1, 29, 165, '2020-08-27 18:21:16', '2020-08-27 18:21:16'),
(281, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-27 18:21:39', '2020-08-27 18:21:39'),
(282, 'Alphaxine opened Sourav in contacts send sms', 'revision', 1, 29, 165, '2020-08-27 18:21:50', '2020-08-27 18:21:50'),
(283, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-27 18:22:08', '2020-08-27 18:22:08'),
(284, 'Alphaxine opened create Contact', 'revision', 1, 29, 0, '2020-08-27 18:22:16', '2020-08-27 18:22:16'),
(285, 'Subhajit Kar', 'contact', 1, 29, 0, '2020-08-27 18:23:28', '2020-08-27 18:23:28'),
(286, 'Alphaxine created a Contact \"Subhajit Kar\"', 'revision', 1, 29, 285, '2020-08-27 18:23:28', '2020-08-27 18:23:28'),
(287, 'Alphaxine opened edit Contact', 'revision', 1, 29, 285, '2020-08-27 18:23:29', '2020-08-27 18:23:29'),
(288, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-27 18:23:45', '2020-08-27 18:23:45'),
(289, 'Alphaxine opened Subhajit Kar in contacts send email', 'revision', 1, 29, 285, '2020-08-27 18:23:50', '2020-08-27 18:23:50'),
(290, 'Contact Testing', 'email', 1, 29, 285, '2020-08-27 18:24:31', '2020-08-27 18:24:31'),
(291, 'Alphaxine send an email to Subhajit Kar', 'revision', 1, 29, 285, '2020-08-27 18:24:31', '2020-08-27 18:24:31'),
(292, 'Alphaxine opened Subhajit Kar in contacts send email', 'revision', 1, 29, 285, '2020-08-27 18:24:32', '2020-08-27 18:24:32'),
(293, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-27 18:26:57', '2020-08-27 18:26:57'),
(294, 'Alphaxine opened edit Contact', 'revision', 1, 29, 285, '2020-08-27 18:27:06', '2020-08-27 18:27:06'),
(295, 'Alphaxine opened Subhajit Kar in contacts send sms', 'revision', 1, 29, 285, '2020-08-27 18:28:30', '2020-08-27 18:28:30'),
(296, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-27 18:28:42', '2020-08-27 18:28:42'),
(297, 'Alphaxine opened create Judgement', 'revision', 1, 29, 0, '2020-08-27 18:28:47', '2020-08-27 18:28:47'),
(298, 'Test 4', 'judgement', 1, 29, 0, '2020-08-27 18:29:16', '2020-08-27 18:29:16'),
(299, 'Alphaxine created a Judgement \"Test 4\"', 'revision', 1, 29, 298, '2020-08-27 18:29:19', '2020-08-27 18:29:19'),
(300, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 298, '2020-08-27 18:29:19', '2020-08-27 18:29:19'),
(301, 'Alphaxine updated Judgement \"Test 4\"', 'revision', 1, 29, 298, '2020-08-27 18:30:04', '2020-08-27 18:30:04'),
(302, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 298, '2020-08-27 18:30:05', '2020-08-27 18:30:05'),
(303, 'Alphaxine opened create Incident', 'revision', 1, 29, 0, '2020-08-27 18:30:34', '2020-08-27 18:30:34'),
(304, 'Alphaxine opened Incident', 'revision', 1, 29, 0, '2020-08-27 18:30:37', '2020-08-27 18:30:37'),
(305, 'Alphaxine opened create Incident', 'revision', 1, 29, 0, '2020-08-27 18:30:43', '2020-08-27 18:30:43'),
(306, 'Alphaxine opened Assessment', 'revision', 1, 29, 0, '2020-08-27 18:30:56', '2020-08-27 18:30:56'),
(307, 'Alphaxine opened edit Assessment', 'revision', 1, 29, 106, '2020-08-27 18:31:01', '2020-08-27 18:31:01'),
(308, 'Tulip De opened dashboard', 'revision', 1, 40, 0, '2020-08-27 18:32:13', '2020-08-27 18:32:13'),
(309, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-27 18:32:49', '2020-08-27 18:32:49'),
(310, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-27 18:33:00', '2020-08-27 18:33:00'),
(311, 'Alphaxine opened Subhajit Kar in contacts send sms', 'revision', 1, 29, 285, '2020-08-27 18:33:05', '2020-08-27 18:33:05'),
(312, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-27 18:33:38', '2020-08-27 18:33:38'),
(313, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-27 18:36:19', '2020-08-27 18:36:19'),
(314, 'Alphaxine opened File Manager', 'revision', 1, 29, 0, '2020-08-27 18:46:19', '2020-08-27 18:46:19'),
(315, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-27 18:46:27', '2020-08-27 18:46:27'),
(316, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 298, '2020-08-27 18:46:31', '2020-08-27 18:46:31'),
(317, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-27 18:54:43', '2020-08-27 18:54:43'),
(318, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 22:17:35', '2020-08-27 22:17:35'),
(319, 'Alphaxine opened Location', 'revision', 1, 29, 0, '2020-08-27 22:18:07', '2020-08-27 22:18:07'),
(320, 'Alphaxine opened create Location', 'revision', 1, 29, 0, '2020-08-27 22:18:16', '2020-08-27 22:18:16'),
(321, 'Signet Tower', 'file_location', 1, 29, 0, '2020-08-27 22:18:57', '2020-08-27 22:18:57'),
(322, 'Alphaxine created a Location \"Signet Tower\"', 'revision', 1, 29, 321, '2020-08-27 22:18:57', '2020-08-27 22:18:57'),
(323, 'Alphaxine opened edit Location', 'revision', 1, 29, 321, '2020-08-27 22:18:58', '2020-08-27 22:18:58'),
(324, 'Alphaxine opened Location', 'revision', 1, 29, 0, '2020-08-27 22:19:04', '2020-08-27 22:19:04'),
(325, 'Alphaxine opened File Manager', 'revision', 1, 29, 0, '2020-08-27 22:19:13', '2020-08-27 22:19:13'),
(326, 'Alphaxine opened create File Manager', 'revision', 1, 29, 0, '2020-08-27 22:19:24', '2020-08-27 22:19:24'),
(327, 'Test 5', 'file_manager', 1, 29, 0, '2020-08-27 22:20:23', '2020-08-27 22:20:23'),
(328, 'Alphaxine created a File Manager \"Test 5\"', 'revision', 1, 29, 327, '2020-08-27 22:20:23', '2020-08-27 22:20:23'),
(329, 'Alphaxine opened edit File Manager', 'revision', 1, 29, 327, '2020-08-27 22:20:24', '2020-08-27 22:20:24'),
(330, 'Alphaxine opened File Manager', 'revision', 1, 29, 0, '2020-08-27 22:20:31', '2020-08-27 22:20:31'),
(331, 'Alphaxine opened create Case', 'revision', 1, 29, 0, '2020-08-27 22:20:47', '2020-08-27 22:20:47'),
(332, 'TEST CASE 5', 'case', 1, 29, 0, '2020-08-27 22:22:26', '2020-08-27 22:22:26'),
(333, 'case_hearing', 'hearing', 1, 29, 332, '2020-08-27 22:22:41', '2020-08-27 22:22:41'),
(334, 'Alphaxine created a Case \"TEST CASE 5\"', 'revision', 1, 29, 332, '2020-08-27 22:22:41', '2020-08-27 22:22:41'),
(335, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-27 22:22:42', '2020-08-27 22:22:42'),
(336, 'Alphaxine uploaded a file to a case \"TEST CASE 5\"', 'revision', 1, 29, 332, '2020-08-27 22:23:46', '2020-08-27 22:23:46'),
(337, 'case_hearing', 'hearing', 1, 29, 332, '2020-08-27 22:23:57', '2020-08-27 22:23:57'),
(338, 'Alphaxine updated Case \"TEST CASE 5\"', 'revision', 1, 29, 332, '2020-08-27 22:23:57', '2020-08-27 22:23:57'),
(339, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-27 22:23:58', '2020-08-27 22:23:58'),
(340, 'Alphaxine opened Activity', 'revision', 1, 29, 0, '2020-08-27 22:24:20', '2020-08-27 22:24:20'),
(341, 'Alphaxine opened Activity', 'revision', 1, 29, 0, '2020-08-27 22:24:42', '2020-08-27 22:24:42'),
(342, 'Alphaxine opened Activity', 'revision', 1, 29, 0, '2020-08-27 22:25:20', '2020-08-27 22:25:20'),
(343, 'Alphaxine opened Activity', 'revision', 1, 29, 0, '2020-08-27 22:25:51', '2020-08-27 22:25:51'),
(344, 'Alphaxine opened Activity', 'revision', 1, 29, 0, '2020-08-27 22:26:03', '2020-08-27 22:26:03'),
(345, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 22:26:25', '2020-08-27 22:26:25'),
(346, 'Alphaxine opened edit Case', 'revision', 1, 29, 190, '2020-08-27 22:26:39', '2020-08-27 22:26:39'),
(347, 'Alphaxine opened edit Case', 'revision', 1, 29, 190, '2020-08-27 22:27:31', '2020-08-27 22:27:31'),
(348, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 22:27:59', '2020-08-27 22:27:59'),
(349, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-27 22:28:09', '2020-08-27 22:28:09'),
(350, 'case_hearing', 'hearing', 1, 29, 332, '2020-08-27 22:28:44', '2020-08-27 22:28:44'),
(351, 'Alphaxine updated Case \"TEST CASE 5\"', 'revision', 1, 29, 332, '2020-08-27 22:28:44', '2020-08-27 22:28:44'),
(352, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-27 22:28:45', '2020-08-27 22:28:45'),
(353, 'case_hearing', 'hearing', 1, 29, 332, '2020-08-27 22:29:11', '2020-08-27 22:29:11'),
(354, 'Alphaxine updated Case \"TEST CASE 5\"', 'revision', 1, 29, 332, '2020-08-27 22:29:12', '2020-08-27 22:29:12'),
(355, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-27 22:29:14', '2020-08-27 22:29:14'),
(356, 'Alphaxine opened Todo', 'revision', 1, 29, 0, '2020-08-27 22:29:36', '2020-08-27 22:29:36'),
(357, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-27 22:29:57', '2020-08-27 22:29:57'),
(358, 'Alphaxine opened view Case', 'revision', 1, 29, 332, '2020-08-27 22:30:11', '2020-08-27 22:30:11'),
(359, 'Alphaxine opened edit Case', 'revision', 1, 29, 180, '2020-08-27 22:31:10', '2020-08-27 22:31:10'),
(360, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 02:03:36', '2020-08-28 02:03:36'),
(361, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-28 02:03:46', '2020-08-28 02:03:46'),
(362, 'Alphaxine opened view Case', 'revision', 1, 29, 332, '2020-08-28 02:03:58', '2020-08-28 02:03:58'),
(363, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-28 02:04:13', '2020-08-28 02:04:13'),
(364, 'Alphaxine opened File Manager', 'revision', 1, 29, 0, '2020-08-28 02:07:11', '2020-08-28 02:07:11'),
(365, 'Alphaxine opened edit File Manager', 'revision', 1, 29, 327, '2020-08-28 02:07:23', '2020-08-28 02:07:23'),
(366, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-28 02:09:57', '2020-08-28 02:09:57'),
(367, 'Alphaxine opened Subhajit Kar in contacts send sms', 'revision', 1, 29, 285, '2020-08-28 02:10:01', '2020-08-28 02:10:01'),
(368, 'Alphaxine opened Subhajit Kar in contacts send sms', 'revision', 1, 29, 285, '2020-08-28 02:10:01', '2020-08-28 02:10:01'),
(369, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 04:25:44', '2020-08-28 04:25:44'),
(370, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:25:51', '2020-08-28 04:25:51'),
(371, 'Alphaxine opened create employee', 'revision', 1, 29, 0, '2020-08-28 04:25:54', '2020-08-28 04:25:54'),
(372, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 04:26:06', '2020-08-28 04:26:06'),
(373, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:26:25', '2020-08-28 04:26:25'),
(374, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:26:25', '2020-08-28 04:26:25'),
(375, 'Alphaxine opened Office Associate', 'revision', 1, 29, 0, '2020-08-28 04:26:46', '2020-08-28 04:26:46'),
(376, 'Alphaxine opened Client', 'revision', 1, 29, 0, '2020-08-28 04:26:47', '2020-08-28 04:26:47'),
(377, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:26:51', '2020-08-28 04:26:51'),
(378, 'Alphaxine opened Client', 'revision', 1, 29, 0, '2020-08-28 04:26:55', '2020-08-28 04:26:55'),
(379, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:26:56', '2020-08-28 04:26:56'),
(380, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:26:59', '2020-08-28 04:26:59'),
(381, 'Alphaxine opened user role', 'revision', 1, 29, 0, '2020-08-28 04:27:07', '2020-08-28 04:27:07'),
(382, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:27:14', '2020-08-28 04:27:14'),
(383, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:27:40', '2020-08-28 04:27:40'),
(384, 'Alphaxine opened Activity', 'revision', 1, 29, 0, '2020-08-28 04:27:47', '2020-08-28 04:27:47'),
(385, 'Alphaxine opened create Court', 'revision', 1, 29, 0, '2020-08-28 04:27:54', '2020-08-28 04:27:54'),
(386, 'Alphaxine opened Court', 'revision', 1, 29, 0, '2020-08-28 04:27:58', '2020-08-28 04:27:58'),
(387, 'Alphaxine opened Todo', 'revision', 1, 29, 0, '2020-08-28 04:28:12', '2020-08-28 04:28:12'),
(388, 'Alphaxine opened Assessment', 'revision', 1, 29, 0, '2020-08-28 04:28:18', '2020-08-28 04:28:18'),
(389, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-28 04:34:34', '2020-08-28 04:34:34'),
(390, 'Alphaxine opened view Case', 'revision', 1, 29, 27, '2020-08-28 04:34:40', '2020-08-28 04:34:40'),
(391, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-28 04:34:42', '2020-08-28 04:34:42'),
(392, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-28 04:34:48', '2020-08-28 04:34:48'),
(393, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-28 04:35:04', '2020-08-28 04:35:04'),
(394, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 04:45:41', '2020-08-28 04:45:41'),
(395, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-28 04:45:56', '2020-08-28 04:45:56'),
(396, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-28 04:46:13', '2020-08-28 04:46:13'),
(397, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 04:48:39', '2020-08-28 04:48:39'),
(398, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 05:02:06', '2020-08-28 05:02:06'),
(399, 'Haimantika Chaudhuri opened dashboard', 'revision', 1, 34, 0, '2020-08-28 05:02:56', '2020-08-28 05:02:56'),
(400, 'Darshana Mazumder opened dashboard', 'revision', 1, 35, 0, '2020-08-28 05:03:25', '2020-08-28 05:03:25'),
(401, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 05:04:00', '2020-08-28 05:04:00'),
(402, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:04:08', '2020-08-28 05:04:08'),
(403, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:04:21', '2020-08-28 05:04:21'),
(404, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:04:31', '2020-08-28 05:04:31'),
(405, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:05:04', '2020-08-28 05:05:04'),
(406, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:05:07', '2020-08-28 05:05:07'),
(407, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 05:05:16', '2020-08-28 05:05:16'),
(408, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:05:23', '2020-08-28 05:05:23'),
(409, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:05:45', '2020-08-28 05:05:45'),
(410, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:05:48', '2020-08-28 05:05:48'),
(411, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:05:53', '2020-08-28 05:05:53'),
(412, 'Alphaxine open approve attendence for Haimantika Chaudhuri', 'revision', 1, 29, 0, '2020-08-28 05:06:06', '2020-08-28 05:06:06'),
(413, 'Alphaxine open approve attendence for Haimantika Chaudhuri', 'revision', 1, 29, 0, '2020-08-28 05:06:36', '2020-08-28 05:06:36'),
(414, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:06:54', '2020-08-28 05:06:54'),
(415, 'Alphaxine approved an attendence for Haimantika Chaudhuri', 'revision', 1, 29, 0, '2020-08-28 05:06:55', '2020-08-28 05:06:55'),
(416, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:06:56', '2020-08-28 05:06:56'),
(417, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:07:06', '2020-08-28 05:07:06'),
(418, 'Alphaxine open approve attendence for Haimantika Chaudhuri', 'revision', 1, 29, 0, '2020-08-28 05:07:30', '2020-08-28 05:07:30'),
(419, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:07:50', '2020-08-28 05:07:50'),
(420, 'Alphaxine approved an attendence for Haimantika Chaudhuri', 'revision', 1, 29, 0, '2020-08-28 05:08:13', '2020-08-28 05:08:13'),
(421, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:08:14', '2020-08-28 05:08:14'),
(422, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:08:21', '2020-08-28 05:08:21'),
(423, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:08:30', '2020-08-28 05:08:30'),
(424, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:09:33', '2020-08-28 05:09:33'),
(425, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:09:41', '2020-08-28 05:09:41'),
(426, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:10:38', '2020-08-28 05:10:38'),
(427, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 05:11:12', '2020-08-28 05:11:12'),
(428, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:11:30', '2020-08-28 05:11:30'),
(429, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:11:38', '2020-08-28 05:11:38'),
(430, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:11:53', '2020-08-28 05:11:53'),
(431, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:12:58', '2020-08-28 05:12:58'),
(432, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 05:17:53', '2020-08-28 05:17:53'),
(433, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-28 05:18:00', '2020-08-28 05:18:00'),
(434, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:18:01', '2020-08-28 05:18:01'),
(435, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:18:14', '2020-08-28 05:18:14'),
(436, 'Alphaxine open approve attendence for Darshana Mazumder', 'revision', 1, 29, 0, '2020-08-28 05:18:29', '2020-08-28 05:18:29'),
(437, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:18:34', '2020-08-28 05:18:34'),
(438, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 05:18:51', '2020-08-28 05:18:51'),
(439, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 05:19:45', '2020-08-28 05:19:45'),
(440, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 08:24:05', '2020-08-28 08:24:05'),
(441, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 08:25:13', '2020-08-28 08:25:13'),
(442, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 16:16:37', '2020-08-28 16:16:37'),
(443, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 16:16:52', '2020-08-28 16:16:52'),
(444, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 16:17:03', '2020-08-28 16:17:03'),
(445, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 16:17:16', '2020-08-28 16:17:16'),
(446, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 16:38:57', '2020-08-28 16:38:57'),
(447, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-28 16:39:10', '2020-08-28 16:39:10'),
(448, 'Alphaxine opened view Case', 'revision', 1, 29, 332, '2020-08-28 16:39:46', '2020-08-28 16:39:46'),
(449, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-28 16:39:57', '2020-08-28 16:39:57'),
(450, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-28 16:40:29', '2020-08-28 16:40:29'),
(451, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 298, '2020-08-28 16:40:35', '2020-08-28 16:40:35'),
(452, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-28 16:40:44', '2020-08-28 16:40:44'),
(453, 'Alphaxine opened Subhajit Kar in contacts send sms', 'revision', 1, 29, 285, '2020-08-28 16:40:51', '2020-08-28 16:40:51'),
(454, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 16:41:05', '2020-08-28 16:41:05'),
(455, 'Darshana Mazumder opened dashboard', 'revision', 1, 35, 0, '2020-08-28 16:49:19', '2020-08-28 16:49:19'),
(456, 'Tulip De opened dashboard', 'revision', 1, 40, 0, '2020-08-28 16:50:46', '2020-08-28 16:50:46'),
(457, 'Tulip De opened dashboard', 'revision', 1, 40, 0, '2020-08-28 16:51:17', '2020-08-28 16:51:17'),
(458, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 18:24:27', '2020-08-28 18:24:27'),
(459, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 18:24:43', '2020-08-28 18:24:43'),
(460, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 18:25:03', '2020-08-28 18:25:03'),
(461, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-28 18:26:40', '2020-08-28 18:26:40'),
(462, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-28 18:27:09', '2020-08-28 18:27:09'),
(463, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-29 01:21:32', '2020-08-29 01:21:32');
INSERT INTO `masters` (`id`, `name`, `master_type`, `active`, `create_by`, `master_parent_id`, `created_at`, `updated_at`) VALUES
(464, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-29 01:21:57', '2020-08-29 01:21:57'),
(465, 'Alphaxine opened Contact', 'revision', 1, 29, 0, '2020-08-29 01:22:12', '2020-08-29 01:22:12'),
(466, 'Alphaxine opened Subhajit Kar in contacts send sms', 'revision', 1, 29, 285, '2020-08-29 01:22:16', '2020-08-29 01:22:16'),
(467, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-29 01:22:25', '2020-08-29 01:22:25'),
(468, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 298, '2020-08-29 01:22:30', '2020-08-29 01:22:30'),
(469, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-29 10:19:12', '2020-08-29 10:19:12'),
(470, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-29 10:19:22', '2020-08-29 10:19:22'),
(471, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-29 10:19:28', '2020-08-29 10:19:28'),
(472, 'Alphaxine opened edit Case', 'revision', 1, 29, 332, '2020-08-29 10:20:20', '2020-08-29 10:20:20'),
(473, 'Alphaxine opened Case', 'revision', 1, 29, 0, '2020-08-29 10:26:08', '2020-08-29 10:26:08'),
(474, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-29 10:26:20', '2020-08-29 10:26:20'),
(475, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-29 10:27:06', '2020-08-29 10:27:06'),
(476, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-29 10:27:28', '2020-08-29 10:27:28'),
(477, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-29 10:28:39', '2020-08-29 10:28:39'),
(478, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-29 10:29:30', '2020-08-29 10:29:30'),
(479, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-29 10:29:49', '2020-08-29 10:29:49'),
(480, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-29 10:30:29', '2020-08-29 10:30:29'),
(481, 'Alphaxine opened edit Case', 'revision', 1, 29, 27, '2020-08-29 11:02:23', '2020-08-29 11:02:23'),
(482, 'Alphaxine opened employee', 'revision', 1, 29, 0, '2020-08-29 11:11:58', '2020-08-29 11:11:58'),
(483, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-29 11:19:33', '2020-08-29 11:19:33'),
(484, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-29 11:19:57', '2020-08-29 11:19:57'),
(485, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-29 11:28:46', '2020-08-29 11:28:46'),
(486, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-29 11:28:58', '2020-08-29 11:28:58'),
(487, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-29 11:29:06', '2020-08-29 11:29:06'),
(488, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-29 11:29:21', '2020-08-29 11:29:21'),
(489, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-29 11:32:46', '2020-08-29 11:32:46'),
(490, 'Alphaxine opened attendence', 'revision', 1, 29, 0, '2020-08-29 11:36:09', '2020-08-29 11:36:09'),
(491, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-29 16:39:12', '2020-08-29 16:39:12'),
(492, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-29 16:39:36', '2020-08-29 16:39:36'),
(493, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 298, '2020-08-29 16:39:41', '2020-08-29 16:39:41'),
(494, 'Alphaxine updated Judgement \"Test 4\"', 'revision', 1, 29, 298, '2020-08-29 16:41:29', '2020-08-29 16:41:29'),
(495, 'Alphaxine opened edit Judgement', 'revision', 1, 29, 298, '2020-08-29 16:41:30', '2020-08-29 16:41:30'),
(496, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-29 16:45:42', '2020-08-29 16:45:42'),
(497, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-29 16:46:20', '2020-08-29 16:46:20'),
(498, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-29 18:08:04', '2020-08-29 18:08:04'),
(499, 'Alphaxine opened Judgement', 'revision', 1, 29, 0, '2020-08-29 18:09:52', '2020-08-29 18:09:52'),
(500, 'Alphaxine opened dashboard', 'revision', 1, 29, 0, '2020-08-29 20:59:35', '2020-08-29 20:59:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 2),
(4, '2020_06_29_195222_create_usermetas_table', 3),
(11, '2020_07_04_073819_create_masters_table', 4),
(12, '2020_07_04_074323_create_mastermetas_table', 4),
(13, '2020_07_06_172803_create_userroles_table', 5),
(14, '2020_07_06_191439_create_userforms_table', 5),
(15, '2020_07_06_192045_create_formfields_table', 5),
(16, '2020_07_14_155438_create_todoassignees_table', 6),
(17, '2020_07_15_182043_create_attendences_table', 6),
(18, '2020_08_06_010421_create_permissions_table', 7),
(19, '2020_08_06_010537_create_permission_roles_table', 7),
(20, '2020_08_08_133655_create_route_permissions_table', 8),
(21, '2020_08_11_233145_create_permission_parents_table', 9),
(22, '2020_08_23_040855_create_case_files_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('1395ae24-e2a0-46ee-b0f8-557920cfef70', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine updated your assigned case.\",\"body\":\"TEST CASE 5\",\"link\":\"https:\\/\\/arnabmukherje.com\\/dev\\/rkadv\\/lawportal\\/master\\/332\\/edit\"}}', NULL, '2020-08-27 22:29:12', '2020-08-27 22:29:12'),
('26192c6c-f339-46a2-a377-ba6f8eda5828', 'App\\Notifications\\TodoCreated', 'App\\User', 31, '{\"letter\":{\"title\":\"Alphaxine updated your assigned case.\",\"body\":\"New Case\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/167\\/edit\"}}', NULL, '2020-08-23 20:18:18', '2020-08-23 20:18:18'),
('33567317-0826-4dfd-a030-dd0812c747b2', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine assigned you a case.\",\"body\":\"SUBRATA ASH VS STATE OF WEST BENGAL\",\"link\":\"https:\\/\\/www.stepsworthestates.com\\/portal\\/master\\/18\\/edit\"}}', NULL, '2020-08-04 09:06:26', '2020-08-04 09:06:26'),
('33800a79-40f3-47f4-a06c-737433d6d7b0', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine assigned you in an assessment.\",\"body\":\"Test\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_evaluation\\/89\"}}', NULL, '2020-08-09 03:25:33', '2020-08-09 03:25:33'),
('33a21430-5d56-4488-bcd5-4707c1e8cf91', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine assigned you a case.\",\"body\":\"Test New\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/180\\/edit\"}}', NULL, '2020-08-24 04:54:31', '2020-08-24 04:54:31'),
('34221e8c-c7c4-4e18-913a-89ede16754f0', 'App\\Notifications\\TodoCreated', 'App\\User', 34, '{\"letter\":{\"title\":\"Alphaxine updated your assigned assessment.\",\"body\":\"Test\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_evaluation\\/89\"}}', NULL, '2020-08-09 03:41:44', '2020-08-09 03:41:44'),
('3c7354c4-c9b6-45b5-aaeb-709f01b593ef', 'App\\Notifications\\TodoCreated', 'App\\User', 31, '{\"letter\":{\"title\":\"Alphaxine updated your to be reviewed assessment.\",\"body\":\"Test\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/evaluation\\/89\"}}', NULL, '2020-08-12 09:21:19', '2020-08-12 09:21:19'),
('493c31c8-b583-4d97-a0c9-813a0e648406', 'App\\Notifications\\TodoCreated', 'App\\User', 35, '{\"letter\":{\"title\":\"Alphaxine assigned you as a reviewer in an assessment.\",\"body\":\"Test 1\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/evaluation\\/106\"}}', NULL, '2020-08-12 09:25:01', '2020-08-12 09:25:01'),
('49c03cb4-265d-4f2d-a917-ebfac7788b09', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine updated your assigned case.\",\"body\":\"NASHIRAM JOSH VS STATE OF WEST BENGAL\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/27\\/edit\"}}', NULL, '2020-08-23 20:54:59', '2020-08-23 20:54:59'),
('49fabc6e-0bc6-4125-ab1d-44dbacc15533', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine assigned you a case.\",\"body\":\"NASHIRAM JOSH VS STATE OF WEST BENGAL\",\"link\":\"https:\\/\\/www.stepsworthestates.com\\/portal\\/master\\/27\\/edit\"}}', NULL, '2020-08-04 09:19:39', '2020-08-04 09:19:39'),
('4cdafd89-d143-4503-b775-3ef21dbdce00', 'App\\Notifications\\TodoCreated', 'App\\User', 30, '{\"letter\":{\"title\":\"Alphaxine updated your assigned todo.\",\"body\":\"Accounts\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_todo\\/86\"}}', NULL, '2020-08-12 09:54:51', '2020-08-12 09:54:51'),
('55f9e537-e612-483c-8e54-c510a933e90e', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine updated your assigned case.\",\"body\":\"SUBRATA ASH VS STATE OF WEST BENGAL\",\"link\":\"https:\\/\\/www.stepsworthestates.com\\/portal\\/master\\/18\\/edit\"}}', NULL, '2020-08-04 09:10:46', '2020-08-04 09:10:46'),
('703adbc6-de34-4bfc-a58b-5ebd04901b4d', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine updated your assigned case.\",\"body\":\"Test New\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/180\\/edit\"}}', NULL, '2020-08-24 04:55:03', '2020-08-24 04:55:03'),
('7584adb5-2131-4b8a-b12b-3453e19548ba', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine updated your assigned case.\",\"body\":\"NASHIRAM JOSH VS STATE OF WEST BENGAL\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/27\\/edit\"}}', NULL, '2020-08-23 20:56:14', '2020-08-23 20:56:14'),
('7691768f-51f1-450c-b9b9-ad5df7b26638', 'App\\Notifications\\TodoCreated', 'App\\User', 31, '{\"letter\":{\"title\":\"Alphaxine assigned you a case.\",\"body\":\"New Case\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/167\\/edit\"}}', NULL, '2020-08-23 20:18:07', '2020-08-23 20:18:07'),
('7b6cf9b7-691b-4147-8038-bec36a261e8c', 'App\\Notifications\\TodoCreated', 'App\\User', 34, '{\"letter\":{\"title\":\"Alphaxine updated your assigned todo.\",\"body\":\"Accounts\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_todo\\/86\"}}', NULL, '2020-08-12 09:54:51', '2020-08-12 09:54:51'),
('8f407cd3-3262-4c32-99ab-6c7ee3f96d9b', 'App\\Notifications\\TodoCreated', 'App\\User', 30, '{\"letter\":{\"title\":\"Alphaxine updated your assigned todo.\",\"body\":\"Accounts\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_todo\\/86\"}}', NULL, '2020-08-09 04:52:08', '2020-08-09 04:52:08'),
('9808c053-83ef-4356-9892-0b330ef9e17e', 'App\\Notifications\\TodoCreated', 'App\\User', 31, '{\"letter\":{\"title\":\"Alphaxine updated your assigned todo.\",\"body\":\"Accounts\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_todo\\/86\"}}', NULL, '2020-08-12 09:54:51', '2020-08-12 09:54:51'),
('a731f5df-c9bf-4d48-95a8-e4b909a50056', 'App\\Notifications\\TodoCreated', 'App\\User', 31, '{\"letter\":{\"title\":\"Alphaxine updated your assigned case.\",\"body\":\"Test New\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/180\\/edit\"}}', NULL, '2020-08-24 04:55:03', '2020-08-24 04:55:03'),
('ad2406a5-aac9-4782-8095-d51d8d6ecb5e', 'App\\Notifications\\TodoCreated', 'App\\User', 34, '{\"letter\":{\"title\":\"Alphaxine updated your assigned todo.\",\"body\":\"Accounts\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_todo\\/86\"}}', NULL, '2020-08-09 04:52:08', '2020-08-09 04:52:08'),
('b440248d-4fa2-44ba-a7cf-29543f31b7fd', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine updated your to be reviewed assessment.\",\"body\":\"Test\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_evaluation\\/89\"}}', NULL, '2020-08-09 03:36:57', '2020-08-09 03:36:57'),
('b8c88d09-b248-4a6c-b8ad-6ca53f6b1690', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine updated your to be reviewed assessment.\",\"body\":\"Test\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_evaluation\\/89\"}}', NULL, '2020-08-09 03:41:44', '2020-08-09 03:41:44'),
('c4d23f33-3343-4787-9c9e-64741f262c74', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine assigned you in an assessment.\",\"body\":\"Test\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_evaluation\\/89\"}}', NULL, '2020-08-09 03:21:45', '2020-08-09 03:21:45'),
('cee637a2-f501-45ff-8889-6acf5bc242a0', 'App\\Notifications\\TodoCreated', 'App\\User', 31, '{\"letter\":{\"title\":\"Alphaxine assigned you a case.\",\"body\":\"Test New\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/180\\/edit\"}}', NULL, '2020-08-24 04:54:31', '2020-08-24 04:54:31'),
('df866264-4c7e-4a78-8dac-df9ff481b00a', 'App\\Notifications\\TodoCreated', 'App\\User', 34, '{\"letter\":{\"title\":\"Alphaxine assigned you a incident.\",\"body\":\"Test\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/my_incident\\/94\"}}', NULL, '2020-08-09 04:19:38', '2020-08-09 04:19:38'),
('e7c8f011-ccf3-4fc9-8b75-ae2be1200baa', 'App\\Notifications\\TodoCreated', 'App\\User', 40, '{\"letter\":{\"title\":\"Alphaxine assigned you in an assessment.\",\"body\":\"Test 1\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/evaluation\\/106\"}}', NULL, '2020-08-12 09:25:01', '2020-08-12 09:25:01'),
('eadf3d30-eb99-41a9-bea3-4287238c85f5', 'App\\Notifications\\TodoCreated', 'App\\User', 26, '{\"letter\":{\"title\":\"Alphaxine updated your assigned case.\",\"body\":\"NASHIRAM JOSH VS STATE OF WEST BENGAL\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/master\\/27\\/edit\"}}', NULL, '2020-08-23 20:56:23', '2020-08-23 20:56:23'),
('f83f7867-2209-41d1-bf18-1685268fb701', 'App\\Notifications\\TodoCreated', 'App\\User', 34, '{\"letter\":{\"title\":\"Alphaxine updated your assigned assessment.\",\"body\":\"Test\",\"link\":\"http:\\/\\/localhost\\/lawportal\\/evaluation\\/89\"}}', NULL, '2020-08-12 09:21:19', '2020-08-12 09:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `objectives`
--

CREATE TABLE `objectives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_id` int(11) NOT NULL,
  `objective` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `weightage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_comment` longtext COLLATE utf8mb4_unicode_ci,
  `reviewer_comment` longtext COLLATE utf8mb4_unicode_ci,
  `score` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `objectives`
--

INSERT INTO `objectives` (`id`, `master_id`, `objective`, `weightage`, `employee_comment`, `reviewer_comment`, `score`) VALUES
(1, 89, 'test 1', '10', NULL, NULL, NULL),
(2, 106, 'test', '10', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_parent_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_parent_id`, `name`, `active`, `sort`) VALUES
(1, 1, 'View Attendence on Dashboard', 1, 1),
(2, 1, 'View Recent Case Updates on Dashboard', 1, 5),
(3, 1, 'View Todo on Dashboard', 1, 10),
(4, 1, 'View Holiday Lists on Dashboard', 1, 15),
(5, 2, 'View User', 1, 20),
(6, 2, 'Edit User', 1, 25),
(7, 2, 'Delete User', 1, 30),
(8, 2, 'View User Role', 1, 35),
(9, 2, 'Edit User Role', 1, 40),
(10, 2, 'Delete User Role', 1, 45),
(11, 3, 'View Attendence', 1, 50),
(12, 4, 'View Activity', 1, 55),
(13, 5, 'View Court', 1, 60),
(14, 5, 'Add Court', 1, 65),
(15, 5, 'Edit Court', 1, 70),
(16, 5, 'Delete Court', 1, 75),
(17, 2, 'Add User', 1, 21),
(18, 8, 'View State', 1, 80),
(19, 8, 'Add State', 1, 85),
(20, 8, 'Edit State', 1, 90),
(21, 8, 'Delete State', 1, 95),
(22, 9, 'View Case', 1, 100),
(23, 9, 'Add Case', 1, 105),
(24, 9, 'Edit Case', 1, 110),
(25, 9, 'Delete Case', 1, 115),
(26, 9, 'View Case Category', 1, 120),
(27, 9, 'Add Case Category', 1, 125),
(28, 9, 'Edit Case Category', 1, 130),
(29, 9, 'Delete Case Category', 1, 135),
(30, 10, 'View Todo', 1, 140),
(31, 10, 'Add Todo', 1, 145),
(32, 10, 'Edit Todo', 1, 150),
(33, 10, 'Delete Todo', 1, 155),
(34, 11, 'View Holiday', 1, 160),
(35, 11, 'Add Holiday', 1, 165),
(36, 11, 'Edit Holiday', 1, 170),
(37, 11, 'Delete Holiday', 1, 175),
(38, 12, 'View Assessment', 1, 180),
(39, 12, 'Add Assessment', 1, 185),
(40, 12, 'Edit Assessment', 1, 190),
(41, 12, 'Delete Assessment', 1, 195),
(42, 13, 'View Incident', 1, 200),
(43, 13, 'Add Incident', 1, 205),
(44, 13, 'Edit Incident', 1, 210),
(45, 13, 'Delete Incident', 1, 215),
(46, 14, 'View My Todo', 1, 220),
(47, 14, 'Open/Close My Todo', 1, 225),
(48, 14, 'Comment on My Todo', 1, 230),
(49, 15, 'View My Incident', 1, 235),
(50, 15, 'Comment on My Incident', 1, 240),
(51, 16, 'View My Assessment', 1, 245),
(52, 16, 'Comment on My Assessment', 1, 250),
(53, 2, 'Add User Role', 1, 36),
(54, 17, 'View File Manager', 1, 255),
(55, 17, 'Add File Manager', 1, 260),
(56, 17, 'Edit File Manager', 1, 265),
(57, 17, 'Delete File Manager', 1, 270),
(58, 17, 'View Location', 1, 275),
(59, 17, 'Add Location', 1, 280),
(60, 17, 'Edit Location', 1, 285),
(61, 17, 'Delete Location', 1, 290),
(62, 9, 'Show Case', 1, 101),
(63, 17, 'Upload File Manager', 1, 266),
(64, 19, 'View Judgement', 1, 295),
(65, 19, 'Add Judgement', 1, 300),
(66, 19, 'Edit Judgement', 1, 305),
(67, 19, 'Delete Judgement', 1, 310),
(68, 20, 'View Contact', 1, 315),
(69, 20, 'Add Contact', 1, 320),
(70, 20, 'Edit Contact', 1, 325),
(71, 20, 'Delete Contact', 1, 330),
(72, 20, 'Send Email', 1, 335),
(73, 20, 'Send SMS', 1, 340);

-- --------------------------------------------------------

--
-- Table structure for table `permission_parents`
--

CREATE TABLE `permission_parents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_parents`
--

INSERT INTO `permission_parents` (`id`, `name`, `active`) VALUES
(1, 'Dashboard', 1),
(2, 'Manage User', 1),
(3, 'Attendence', 1),
(4, 'Activity', 1),
(5, 'Manage Court', 1),
(8, 'Manage State', 1),
(9, 'Manage Case', 1),
(10, 'Manage Todo', 1),
(11, 'Manage Holiday', 1),
(12, 'Manage Assessment', 1),
(13, 'Manage Incident', 1),
(14, 'My Todo', 1),
(15, 'My Incident', 1),
(16, 'My Assessment', 1),
(17, 'File Manager', 1),
(19, 'Judgement', 1),
(20, 'Contact', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_roles`
--

CREATE TABLE `permission_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` int(11) NOT NULL,
  `userrole_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_roles`
--

INSERT INTO `permission_roles` (`id`, `permission_id`, `userrole_id`) VALUES
(1, 52, 20),
(2, 51, 20),
(3, 50, 20),
(4, 49, 20),
(5, 48, 20),
(6, 47, 20),
(7, 46, 20),
(8, 45, 20),
(9, 44, 20),
(10, 43, 20),
(11, 42, 20),
(12, 41, 20),
(13, 40, 20),
(14, 39, 20),
(15, 38, 20),
(16, 37, 20),
(17, 36, 20),
(18, 35, 20),
(19, 34, 20),
(20, 33, 20),
(21, 32, 20),
(22, 31, 20),
(23, 30, 20),
(24, 29, 20),
(25, 28, 20),
(26, 27, 20),
(27, 26, 20),
(28, 25, 20),
(29, 24, 20),
(30, 23, 20),
(31, 22, 20),
(32, 16, 20),
(33, 15, 20),
(34, 14, 20),
(35, 13, 20),
(36, 12, 20),
(37, 11, 20),
(38, 10, 20),
(39, 9, 20),
(40, 8, 20),
(41, 7, 20),
(42, 6, 20),
(43, 17, 20),
(44, 5, 20),
(45, 4, 20),
(46, 3, 20),
(47, 2, 20),
(48, 1, 20),
(149, 5, 19),
(150, 13, 19),
(151, 15, 19),
(152, 16, 19),
(153, 18, 19),
(154, 44, 19),
(155, 46, 19),
(156, 49, 19),
(157, 50, 19),
(158, 51, 19),
(159, 52, 19),
(265, 1, 9),
(266, 2, 9),
(267, 3, 9),
(268, 4, 9),
(269, 5, 9),
(270, 17, 9),
(271, 6, 9),
(272, 7, 9),
(273, 8, 9),
(274, 53, 9),
(275, 9, 9),
(276, 10, 9),
(277, 11, 9),
(278, 12, 9),
(279, 13, 9),
(280, 14, 9),
(281, 15, 9),
(282, 16, 9),
(283, 18, 9),
(284, 19, 9),
(285, 20, 9),
(286, 21, 9),
(287, 22, 9),
(288, 23, 9),
(289, 24, 9),
(290, 25, 9),
(291, 26, 9),
(292, 27, 9),
(293, 28, 9),
(294, 29, 9),
(295, 30, 9),
(296, 31, 9),
(297, 32, 9),
(298, 33, 9),
(299, 34, 9),
(300, 35, 9),
(301, 36, 9),
(302, 37, 9),
(303, 38, 9),
(304, 39, 9),
(305, 40, 9),
(306, 41, 9),
(307, 42, 9),
(308, 43, 9),
(309, 44, 9),
(310, 45, 9),
(311, 46, 9),
(312, 47, 9),
(313, 48, 9),
(314, 49, 9),
(315, 50, 9),
(316, 51, 9),
(317, 52, 9),
(384, 2, 2),
(385, 62, 2),
(386, 1, 10),
(387, 2, 10),
(388, 3, 10),
(389, 4, 10),
(390, 5, 10),
(391, 17, 10),
(392, 6, 10),
(393, 7, 10),
(394, 8, 10),
(395, 53, 10),
(396, 9, 10),
(397, 10, 10),
(398, 11, 10),
(399, 12, 10),
(400, 13, 10),
(401, 14, 10),
(402, 15, 10),
(403, 16, 10),
(404, 18, 10),
(405, 19, 10),
(406, 20, 10),
(407, 21, 10),
(408, 22, 10),
(409, 62, 10),
(410, 23, 10),
(411, 24, 10),
(412, 25, 10),
(413, 26, 10),
(414, 27, 10),
(415, 28, 10),
(416, 29, 10),
(417, 30, 10),
(418, 31, 10),
(419, 32, 10),
(420, 33, 10),
(421, 34, 10),
(422, 35, 10),
(423, 36, 10),
(424, 37, 10),
(425, 38, 10),
(426, 39, 10),
(427, 40, 10),
(428, 41, 10),
(429, 42, 10),
(430, 43, 10),
(431, 44, 10),
(432, 45, 10),
(433, 46, 10),
(434, 47, 10),
(435, 48, 10),
(436, 49, 10),
(437, 50, 10),
(438, 51, 10),
(439, 52, 10),
(440, 54, 10),
(441, 55, 10),
(442, 56, 10),
(443, 63, 10),
(444, 57, 10),
(445, 58, 10),
(446, 59, 10),
(447, 60, 10),
(448, 61, 10),
(449, 64, 10),
(450, 65, 10),
(451, 66, 10),
(452, 67, 10),
(453, 68, 10),
(454, 69, 10),
(455, 70, 10),
(456, 71, 10),
(457, 72, 10),
(458, 73, 10);

-- --------------------------------------------------------

--
-- Table structure for table `route_permissions`
--

CREATE TABLE `route_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` int(11) NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `master_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_permissions`
--

INSERT INTO `route_permissions` (`id`, `permission_id`, `route_name`, `master_type`) VALUES
(1, 5, 'user.index', NULL),
(2, 5, 'user.show', NULL),
(3, 6, 'user.edit', NULL),
(4, 6, 'user.update', NULL),
(5, 7, 'user.destroy', NULL),
(6, 8, 'userrole.index', NULL),
(7, 8, 'userrole.show', NULL),
(8, 9, 'userrole.edit', NULL),
(9, 9, 'userrole.update', NULL),
(10, 10, 'userrole.destroy', NULL),
(11, 11, 'attendence', NULL),
(12, 11, 'attendence_logs', NULL),
(13, 17, 'user.create', NULL),
(14, 17, 'user.store', NULL),
(15, 53, 'userrole.create', NULL),
(16, 53, 'userrole.store', NULL),
(17, 12, 'master.index', 'revision'),
(18, 12, 'master.show', 'revision'),
(19, 13, 'master.index', 'court'),
(20, 13, 'master.show', 'court'),
(21, 14, 'master.create', 'court'),
(22, 14, 'master.store', 'court'),
(23, 15, 'master.edit', 'court'),
(24, 15, 'master.update', 'court'),
(25, 16, 'master.destroy', 'court'),
(26, 18, 'master.index', 'state'),
(27, 18, 'master.show', 'state'),
(28, 19, 'master.create', 'state'),
(29, 19, 'master.store', 'state'),
(30, 20, 'master.edit', 'state'),
(31, 20, 'master.update', 'state'),
(32, 21, 'master.destroy', 'state'),
(33, 22, 'master.index', 'case'),
(34, 62, 'master.show', 'case'),
(35, 23, 'master.create', 'case'),
(36, 23, 'master.store', 'case'),
(37, 24, 'master.edit', 'case'),
(38, 24, 'master.update', 'case'),
(39, 25, 'master.destroy', 'case'),
(40, 26, 'master.index', 'case_category'),
(41, 26, 'master.show', 'case_category'),
(42, 27, 'master.create', 'case_category'),
(43, 27, 'master.store', 'case_category'),
(44, 28, 'master.edit', 'case_category'),
(45, 28, 'master.update', 'case_category'),
(46, 29, 'master.destroy', 'case_category'),
(47, 30, 'master.index', 'todo'),
(48, 30, 'master.show', 'todo'),
(49, 31, 'master.create', 'todo'),
(50, 31, 'master.store', 'todo'),
(51, 32, 'master.edit', 'todo'),
(52, 32, 'master.update', 'todo'),
(53, 33, 'master.destroy', 'todo'),
(54, 34, 'master.index', 'holiday'),
(55, 34, 'master.show', 'holiday'),
(56, 35, 'master.create', 'holiday'),
(57, 35, 'master.store', 'holiday'),
(58, 36, 'master.edit', 'holiday'),
(59, 36, 'master.update', 'holiday'),
(60, 37, 'master.destroy', 'holiday'),
(61, 38, 'master.index', 'evaluation'),
(62, 38, 'master.show', 'evaluation'),
(63, 39, 'master.create', 'evaluation'),
(64, 39, 'master.store', 'evaluation'),
(65, 40, 'master.edit', 'evaluation'),
(66, 40, 'master.update', 'evaluation'),
(67, 41, 'master.destroy', 'evaluation'),
(68, 42, 'master.index', 'incident'),
(69, 42, 'master.show', 'incident'),
(70, 43, 'master.create', 'incident'),
(71, 43, 'master.store', 'incident'),
(72, 44, 'master.edit', 'incident'),
(73, 44, 'master.update', 'incident'),
(74, 45, 'master.destroy', 'incident'),
(75, 46, 'todo_list', NULL),
(76, 46, 'mytodo', NULL),
(77, 47, 'change.todo_status', NULL),
(78, 48, 'add.todo.comment', NULL),
(79, 48, 'delete_todo_comment', NULL),
(80, 48, 'update_todo_comment', NULL),
(81, 49, 'incident_list', NULL),
(82, 49, 'myincident', NULL),
(83, 50, 'add.incident.comment', NULL),
(84, 50, 'update_incident_comment', NULL),
(85, 50, 'delete_incident_comment', NULL),
(86, 51, 'user_evaluation', NULL),
(87, 51, 'evaluation', NULL),
(88, 52, 'evaluation_review', NULL),
(91, 16, 'master.bulk.delete', 'court'),
(92, 21, 'master.bulk.delete', 'state'),
(93, 25, 'master.bulk.delete', 'case'),
(94, 29, 'master.bulk.delete', 'case_category'),
(95, 33, 'master.bulk.delete', 'todo'),
(96, 37, 'master.bulk.delete', 'holiday'),
(97, 41, 'master.bulk.delete', 'evaluation'),
(98, 45, 'master.bulk.delete', 'incident'),
(99, 54, 'master.index', 'file_manager'),
(100, 54, 'master.show', 'file_manager'),
(101, 55, 'master.create', 'file_manager'),
(102, 55, 'master.store', 'file_manager'),
(103, 56, 'master.edit', 'file_manager'),
(104, 56, 'master.update', 'file_manager'),
(105, 57, 'master.destroy', 'file_manager'),
(106, 58, 'master.index', 'file_location'),
(107, 58, 'master.show', 'file_location'),
(108, 59, 'master.create', 'file_location'),
(109, 59, 'master.store', 'file_location'),
(110, 60, 'master.edit', 'file_location'),
(111, 60, 'master.update', 'file_location'),
(112, 61, 'master.destroy', 'file_location'),
(113, 64, 'master.index', 'judgement'),
(114, 64, 'master.show', 'judgement'),
(115, 65, 'master.create', 'judgement'),
(116, 65, 'master.store', 'judgement'),
(117, 66, 'master.edit', 'judgement'),
(118, 66, 'master.update', 'judgement'),
(119, 67, 'master.destroy', 'judgement'),
(120, 68, 'master.index', 'contact'),
(121, 68, 'master.show', 'contact'),
(122, 69, 'master.create', 'contact'),
(123, 69, 'master.store', 'contact'),
(124, 70, 'master.edit', 'contact'),
(125, 70, 'master.update', 'contact'),
(126, 71, 'master.destroy', 'contact'),
(127, 72, 'send.email', 'contact'),
(128, 72, 'post.email', 'contact'),
(129, 73, 'send.sms', 'contact'),
(130, 73, 'post.sms', 'contact'),
(131, 63, 'upload.excel.index', 'file_manager'),
(132, 63, 'upload.excel', 'file_manager');

-- --------------------------------------------------------

--
-- Table structure for table `todoassignees`
--

CREATE TABLE `todoassignees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `todoassignees`
--

INSERT INTO `todoassignees` (`id`, `master_id`, `user_id`) VALUES
(2, 18, 26),
(22, 27, 26),
(16, 86, 30),
(13, 89, 31),
(10, 94, 34),
(15, 86, 31),
(14, 106, 35),
(17, 86, 34),
(19, 167, 31),
(26, 180, 26),
(25, 180, 31),
(28, 191, 29),
(32, 332, 29),
(33, 332, 26);

-- --------------------------------------------------------

--
-- Table structure for table `userforms`
--

CREATE TABLE `userforms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userrole_id` int(11) NOT NULL,
  `formfield_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userforms`
--

INSERT INTO `userforms` (`id`, `userrole_id`, `formfield_id`) VALUES
(26, 3, 6),
(30, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `usermetas`
--

CREATE TABLE `usermetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usermetas`
--

INSERT INTO `usermetas` (`id`, `user_id`, `meta_key`, `meta_value`) VALUES
(4, 29, 'created_by', '1'),
(16, 29, 'updated_by', '29'),
(17, 29, '_profile_image', '2020/07/nRrm7Fg7JUKUH5xyc6VGWvk5o3vkyPl7Vk1g0cIn.png'),
(23, 29, '_userrole_id', '10'),
(60, 26, '_userrole_id', '10'),
(61, 26, 'created_by', '1'),
(62, 26, 'updated_by', '26'),
(63, 26, '_profile_image', '2020/07/nRrm7Fg7JUKUH5xyc6VGWvk5o3vkyPl7Vk1g0cIn.png'),
(70, 30, 'created_by', '26'),
(71, 30, '_userrole_id', '16'),
(72, 31, 'created_by', '26'),
(73, 31, '_userrole_id', '9'),
(74, 32, 'created_by', '26'),
(75, 32, '_userrole_id', '15'),
(76, 33, 'created_by', '26'),
(77, 33, '_userrole_id', '14'),
(78, 26, 'id_proof', 'a:0:{}'),
(79, 34, 'created_by', '26'),
(80, 34, '_userrole_id', '19'),
(81, 33, 'updated_by', '29'),
(82, 34, 'updated_by', '29'),
(83, 35, 'created_by', '29'),
(84, 35, '_userrole_id', '15'),
(85, 35, 'updated_by', '29'),
(86, 35, 'id_proof', 'a:0:{}'),
(87, 31, 'updated_by', '29'),
(88, 31, 'id_proof', 'a:1:{i:0;s:1:\"8\";}'),
(89, 30, 'updated_by', '30'),
(90, 30, 'id_proof', 'a:1:{i:0;s:2:\"10\";}'),
(91, 36, 'created_by', '29'),
(92, 36, '_userrole_id', '2'),
(93, 29, 'id_proof', 'a:0:{}'),
(94, 37, 'created_by', '29'),
(95, 37, '_userrole_id', '3'),
(96, 38, 'created_by', '29'),
(97, 38, '_userrole_id', '2'),
(98, 32, 'updated_by', '29'),
(99, 32, 'id_proof', 'a:0:{}'),
(100, 39, 'created_by', '29'),
(101, 39, '_userrole_id', '2'),
(102, 39, 'id_proof', 'a:0:{}'),
(103, 33, 'id_proof', 'a:0:{}'),
(104, 34, 'id_proof', 'a:0:{}'),
(105, 39, 'updated_by', '29'),
(106, 40, 'created_by', '29'),
(107, 40, '_userrole_id', '15'),
(108, 40, 'id_proof', 'a:0:{}'),
(109, 40, 'updated_by', '29'),
(110, 40, 'mobile', '7777777777'),
(111, 40, 'address', ''),
(112, 41, 'dir_name', 'client@test.com'),
(113, 41, 'mobile', '7777777777'),
(114, 41, 'address', 'test'),
(115, 41, 'created_by', '29'),
(116, 41, '_userrole_id', '2'),
(117, 41, 'id_proof', 'a:0:{}'),
(118, 37, 'mobile', '7777777777'),
(119, 37, 'address', 'test'),
(120, 37, 'updated_by', '29'),
(121, 37, 'id_proof', 'a:0:{}'),
(122, 29, 'mobile', '7777777777'),
(123, 29, 'address', ''),
(124, 38, 'mobile', '7777777777'),
(125, 38, 'address', ''),
(126, 38, 'updated_by', '29'),
(127, 38, 'id_proof', 'a:0:{}'),
(128, 36, 'mobile', '9900990099'),
(129, 36, 'address', ''),
(130, 36, 'updated_by', '29'),
(131, 36, 'id_proof', 'a:0:{}'),
(132, 43, 'dir_name', 'Decard Shaw'),
(133, 43, 'mobile', '9876543210'),
(134, 43, 'address', 'KOLKATA'),
(135, 43, 'created_by', '29'),
(136, 43, '_userrole_id', '2'),
(137, 43, 'id_proof', 'a:0:{}'),
(138, 35, 'mobile', '9900990099'),
(139, 35, 'address', ''),
(140, 34, 'mobile', '7777777777'),
(141, 34, 'address', ''),
(142, 34, 'dir_name', 'haimantika@shainelex.com'),
(143, 43, 'updated_by', '29');

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`id`, `name`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(9, 'HR', 1, 1, 29, '2020-07-13 02:31:33', '2020-08-12 09:23:13'),
(2, 'Client', 1, 1, 29, '2020-07-13 02:31:47', '2020-08-04 08:23:10'),
(3, 'Opponent', 1, 1, 29, '2020-07-13 02:32:05', '2020-08-07 20:40:40'),
(10, 'Admin', 1, 1, 29, '2020-07-13 02:32:31', '2020-08-09 02:12:00'),
(5, 'Associates', 0, 1, 1, '2020-07-18 01:25:04', '2020-07-31 05:39:22'),
(11, 'advocate', 0, 1, 1, '2020-07-29 12:14:37', '2020-07-31 05:38:47'),
(12, 'Lawyer', 1, 1, 29, '2020-07-31 05:35:46', '2020-08-07 20:02:24'),
(14, 'Personal Manager', 1, 26, 26, '2020-08-01 09:52:52', '2020-08-01 09:52:52'),
(15, 'Advocate', 1, 26, 26, '2020-08-01 09:53:14', '2020-08-01 09:53:14'),
(16, 'Accounts', 1, 26, 26, '2020-08-01 09:53:33', '2020-08-01 09:53:33'),
(19, 'Office Admin', 1, 29, 29, '2020-08-01 11:12:44', '2020-08-01 11:14:18'),
(18, 'Office Associate', 1, 26, 26, '2020-08-01 11:03:14', '2020-08-01 11:03:14'),
(20, 'test', 1, 29, 29, '2020-08-08 07:33:43', '2020-08-08 07:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(26, 'Debasmita Sarkar Bhattacharjee', 'admin', 'admin@shainelex.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, '00bjpISoIW76YaSrxoz443udAspYJc9YHT3atY0sOmMZEDKWzE2d9IReNEXL', '2020-06-30 12:09:09', '2020-08-01 11:02:02'),
(29, 'Alphaxine', 'admin@alphaxine.com', 'admin@alphaxine.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, 'pr0L6HeOhPyqoe6jtLm7BSUkGatBZzmRF84yPodAIMTwVrQZ0L5PNNqx15L0', '2020-06-30 12:09:09', '2020-07-13 08:36:16'),
(30, 'Ms. Priyanka Yadav', 'priyanka', 'priyanka@shainelex.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, 'dkV3bfBUSN6MEuFsOAozJa5iD4Lte5SFrQFCQvJe7wAlDFM6NqsZhCNGjsId', '2020-08-01 09:57:48', '2020-08-01 09:57:48'),
(31, 'Ms. Anushka Mahato', 'anushka@shainelex.com', 'anushka@shainelex.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, NULL, '2020-08-01 09:59:40', '2020-08-04 10:36:54'),
(32, 'Samay Ghosh', 'samay@shainelex.com', 'samay@shainelex.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, NULL, '2020-08-01 10:01:33', '2020-08-04 10:32:58'),
(33, 'Unkita De', 'unkita@shainelex.com', 'unkita@shainelex.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, NULL, '2020-08-01 10:03:17', '2020-08-04 10:37:37'),
(34, 'Haimantika Chaudhuri', 'haimantika@shainelex.com', 'haimantika@shainelex.com', NULL, '$2y$10$ZxPDmEjGDQEbBTijZDr3tuyolmxWI.bUh/U0.1AD5krn2xPAWqH/m', 1, 'ExgzRQkLqq3tHbNg7tEuukNYNfhffbPV5EPxuvsMEQbJVdUWQ871ATO5vZhX', '2020-08-01 11:04:31', '2020-08-27 06:34:16'),
(35, 'Darshana Mazumder', 'darshana@shainelex.com', 'darshana@shainelex.com', NULL, '$2y$10$cnTlvTyCg1jP0nuKWVVMlOkDeBGKOkii6yPFxuQcInpQcOyWv/sTO', 1, NULL, '2020-08-02 06:58:05', '2020-08-27 06:33:12'),
(36, 'Subrata Ash', 'subrata@client.com', 'subrata@client.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, NULL, '2020-08-04 08:44:54', '2020-08-04 08:44:54'),
(37, 'State Of West Bengal', 'State of West Bengal', 'stateofwestbengal@opponent.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, NULL, '2020-08-04 08:56:07', '2020-08-09 08:59:27'),
(38, 'Nashiram Josh', 'Nashiram Josh', 'nashiram@client.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, NULL, '2020-08-04 09:14:58', '2020-08-04 09:14:58'),
(39, 'test', 'test007', 'test@client.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 0, NULL, '2020-08-04 10:34:50', '2020-08-04 10:44:08'),
(40, 'Tulip De', 'tulip@shainelex.com', 'tulip@shainelex.com', NULL, '$2y$10$bYC.M.r41A1QwskJqSCrqeWvr0vW./SKbdBOZNkOnMuAIWmvOoObC', 1, NULL, '2020-08-05 05:47:38', '2020-08-27 06:31:59'),
(41, 'client test', 'client@test.com', 'client@test.com', NULL, '$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe', 1, NULL, '2020-08-09 08:50:48', '2020-08-09 08:50:48'),
(42, 'Test Opponent', 'test oppo', 'opponent@email.com', NULL, '$2y$10$FohM8lZ.wuA9F9YC/YPfVu1h4W9dICebgJ0s4ypNxfNIpD9EeL8iG', 0, NULL, '2020-08-24 04:54:31', '2020-08-24 04:55:03'),
(43, 'Decard Shaw', 'Decard Shaw', 'decard@gmail.com', NULL, '$2y$10$YYbJqWlSa3JkEKdawu9kWeSGSfcyTBx1HGdG7jyjbO0yU06qyHfgm', 1, NULL, '2020-08-24 16:17:03', '2020-08-24 16:17:03'),
(45, 'Subrata Jash', 'Subrata Jash', 'Subrata_Jash@email.com', NULL, '$2y$10$1bYdSunDKqZZMarQxcrsXu8MJ27k.o.fSJrn2T61QrLYw.zrvyjYW', 0, NULL, '2020-08-25 16:49:05', '2020-08-25 16:49:05'),
(46, 'LUKE HOBBS', 'VIN DIESEL', 'VIN_DIESEL@email.com', NULL, '$2y$10$hPolWJWGuDq3EoYAlCrRR.QStcMmY4mIt0nbiIUL6iY1ZQFq4Kk3G', 0, NULL, '2020-08-27 22:22:41', '2020-08-27 22:28:44');

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendences`
--
ALTER TABLE `attendences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_files`
--
ALTER TABLE `case_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formfields`
--
ALTER TABLE `formfields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `logged_details`
--
ALTER TABLE `logged_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mastermetas`
--
ALTER TABLE `mastermetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_id` (`master_id`);

--
-- Indexes for table `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `master_parent_id` (`master_parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`(191),`notifiable_id`);

--
-- Indexes for table `objectives`
--
ALTER TABLE `objectives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_parents`
--
ALTER TABLE `permission_parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_permissions`
--
ALTER TABLE `route_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todoassignees`
--
ALTER TABLE `todoassignees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userforms`
--
ALTER TABLE `userforms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userrole_id` (`userrole_id`),
  ADD KEY `formfield_id` (`formfield_id`);

--
-- Indexes for table `usermetas`
--
ALTER TABLE `usermetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendences`
--
ALTER TABLE `attendences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `case_files`
--
ALTER TABLE `case_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formfields`
--
ALTER TABLE `formfields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logged_details`
--
ALTER TABLE `logged_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `mastermetas`
--
ALTER TABLE `mastermetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `masters`
--
ALTER TABLE `masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=501;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `objectives`
--
ALTER TABLE `objectives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `permission_parents`
--
ALTER TABLE `permission_parents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `permission_roles`
--
ALTER TABLE `permission_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT for table `route_permissions`
--
ALTER TABLE `route_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `todoassignees`
--
ALTER TABLE `todoassignees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `userforms`
--
ALTER TABLE `userforms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `usermetas`
--
ALTER TABLE `usermetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `userroles`
--
ALTER TABLE `userroles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
