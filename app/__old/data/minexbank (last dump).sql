-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2017 at 05:40 PM
-- Server version: 5.6.31
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minexbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1495643335),
('m140501_075311_add_oauth2_server', 1495643437),
('m170525_121139_notification', 1495716795),
('m170525_122537_parking_type', 1495718837),
('m170525_122551_payout', 1495718857),
('m170525_122604_setting', 1495718857),
('m170525_122626_subscriber', 1495718858),
('m170525_122646_support_message', 1495718860),
('m170525_122707_support_room', 1495718861),
('m170525_130417_notification_seen_index', 1495718917);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` int(1) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `seen` tinyint(1) unsigned NOT NULL,
  `created` bigint(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `type`, `title`, `content`, `seen`, `created`) VALUES
(3, 5, 0, '2', '2', 0, 1494947535),
(59, 0, 0, 'qwe', 'qwe', 0, 1495463482),
(60, 0, 0, '123', '123', 0, 1495476723),
(61, 0, 0, '12312', '3123123', 0, 1495626685),
(62, 0, 0, '1', '1', 0, 1495627054),
(63, 0, 0, '111', '111', 0, 1495640340),
(64, 0, 0, '1', '', 0, 1495792794),
(65, 0, 0, '2', '', 0, 1495792808),
(66, 0, 0, '11', '1111', 0, 1495980777);

-- --------------------------------------------------------

--
-- Table structure for table `notification_seen_index`
--

CREATE TABLE IF NOT EXISTS `notification_seen_index` (
  `user_id` bigint(20) NOT NULL,
  `notification_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification_seen_index`
--

INSERT INTO `notification_seen_index` (`user_id`, `notification_id`) VALUES
(1, 61),
(1, 62),
(1, 63),
(1, 65),
(1, 64),
(2, 64),
(3, 66);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`access_token`, `client_id`, `user_id`, `expires`, `scope`) VALUES
('3f036dd74c9fae7a038ebe5bc243a51ea9298450', 'testclient', 1, '2017-05-28 15:15:52', NULL),
('40ce37ab95dbc859424f1838eb3ab1efb578b9c8', 'testclient', 1, '2017-05-28 10:56:54', NULL),
('8181297f394563b152ca0280be03729e01688738', 'testclient', 1, '2017-05-28 14:14:58', NULL),
('ea6f5ab2668aad122d12d2720b5dfe89754bdfbd', 'testclient', 1, '2017-05-28 13:05:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_authorization_codes`
--

CREATE TABLE IF NOT EXISTS `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `redirect_uri` varchar(1000) NOT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `client_id` varchar(32) NOT NULL,
  `client_secret` varchar(32) DEFAULT NULL,
  `redirect_uri` varchar(1000) NOT NULL,
  `grant_types` varchar(100) NOT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES
('testclient', 'testpass', 'http://fake/', 'client_credentials authorization_code password implicit', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_jwt`
--

CREATE TABLE IF NOT EXISTS `oauth_jwt` (
  `client_id` varchar(32) NOT NULL,
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_public_keys`
--

CREATE TABLE IF NOT EXISTS `oauth_public_keys` (
  `client_id` varchar(255) NOT NULL,
  `public_key` varchar(2000) DEFAULT NULL,
  `private_key` varchar(2000) DEFAULT NULL,
  `encryption_algorithm` varchar(100) DEFAULT 'RS256'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
  `scope` varchar(2000) NOT NULL,
  `is_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_users`
--

CREATE TABLE IF NOT EXISTS `oauth_users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(2000) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE IF NOT EXISTS `parking` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `rate` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `info` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `created` bigint(16) NOT NULL,
  `expired` bigint(16) NOT NULL,
  `device` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `user_id`, `rate`, `amount`, `info`, `status`, `created`, `expired`, `device`, `type_id`) VALUES
(5, 1, '17', '100', '', 0, 1493917216, 1495810228, 'web', 1),
(6, 3, '17', '0', '', 1, 1493919289, 1494005689, 'web', 1),
(7, 3, '17', '0', '', 1, 1493919294, 1494005694, 'web', 1),
(8, 1, '17', '1', '', 0, 1493919297, 1494005697, 'web', 1),
(9, 1, '17', '1', '', 1, 1493919298, 1494005698, 'web', 1),
(10, 1, '17', '1', '', 1, 1493919298, 1494005698, 'web', 1),
(11, 1, '17', '0', '', 0, 1494001371, 1494087771, 'web', 1),
(12, 1, '17', '0', '', 0, 1494001376, 1494087776, 'web', 1),
(13, 1, '17', '0', '', 0, 1494001378, 1494087778, 'web', 1),
(14, 1, '17', '0', '', 0, 1494001378, 1494087778, 'web', 1),
(15, 1, '17', '2', '', 1, 1494001378, 1494087778, 'web', 1),
(16, 1, '17', '3', '', 1, 1494001378, 1494087778, 'web', 1),
(17, 1, '17', '5', '', 1, 1494001379, 1494087779, 'web', 1),
(18, 1, '17', '1', '', 1, 1494001381, 1494087781, 'web', 1),
(19, 1, '17', '0', '', 0, 1494001381, 1494087781, 'web', 1),
(20, 1, '17', '0', '', 0, 1494001382, 1494087782, 'web', 1),
(21, 1, '17', '0', '', 0, 1494001382, 1494087782, 'web', 1),
(22, 1, '17', '0', '', 0, 1494001383, 1494087783, 'web', 1),
(23, 1, '17', '0', '', 0, 1494001383, 1494087783, 'web', 1),
(24, 1, '17', '0', '', 0, 1494001384, 1494087784, 'web', 1),
(25, 1, '17', '0', '', 0, 1494001385, 1494087785, 'web', 1),
(28, 1, '17', '0', '', 0, 1494001385, 1494087785, 'web', 1),
(51, 1, '17', '0', '', 0, 1495723828, 1495810228, 'web', 1),
(52, 1, '17', '2', '', 2, 1495723837, 1495810237, 'web', 1),
(53, 1, '17', '10', '', 2, 1495723904, 1495810303, 'web', 1),
(54, 1, '17', '1.0E-5', '', 1, 1495989951, 1495989981, 'web', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parking_type`
--

CREATE TABLE IF NOT EXISTS `parking_type` (
  `id` int(11) NOT NULL,
  `rate` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `period` bigint(16) NOT NULL,
  `created` bigint(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parking_type`
--

INSERT INTO `parking_type` (`id`, `rate`, `title`, `period`, `created`) VALUES
(1, '17', 'Daily', 86400, 0),
(2, '23', 'Weekly', 604800, 0),
(3, '35', 'Monthly', 2592000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payout`
--

CREATE TABLE IF NOT EXISTS `payout` (
  `id` bigint(20) unsigned NOT NULL,
  `parking_id` bigint(20) unsigned NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` bigint(16) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payout`
--

INSERT INTO `payout` (`id`, `parking_id`, `transaction_id`, `user_id`, `amount`, `created`) VALUES
(1, 157, '1', 5, '143.91', 1495199732),
(2, 158, '1', 5, '143.91', 1495199732),
(3, 159, '1', 5, '143.91', 1495199732),
(4, 160, '1', 5, '166.05', 1495199732),
(5, 161, '1', 5, '151.29', 1495199732),
(6, 162, '1', 5, '143.91', 1495199732),
(7, 163, '1', 5, '143.91', 1495199732),
(8, 164, '1', 5, '117', 1495199732),
(9, 165, '1', 5, '3.51', 1495199732),
(10, 166, '1', 5, '3.51', 1495199732),
(11, 167, '1', 5, '3.51', 1495199732),
(12, 168, '1', 5, '3.51', 1495199732),
(13, 169, '1', 5, '3.51', 1495199732),
(14, 170, '1', 5, '3.51', 1495199732),
(15, 171, '1', 5, '3.51', 1495199732),
(16, 172, '1', 5, '3.51', 1495199732),
(17, 173, '1', 5, '3.51', 1495199732),
(18, 174, '1', 5, '3.51', 1495199732),
(19, 175, '1', 5, '3.51', 1495199732),
(20, 176, '1', 5, '3.51', 1495199732),
(21, 177, '1', 5, '3.51', 1495199732),
(22, 178, '1', 5, '3.51', 1495199732),
(23, 181, '1', 5, '1.17', 1495199732),
(24, 182, '1', 5, '1.17', 1495199732),
(25, 183, '1', 5, '12.3', 1495199732),
(26, 184, '1', 5, '12.3', 1495199732),
(27, 185, '1', 5, '14.04', 1495199733),
(28, 186, '1', 5, '14.04', 1495199733),
(29, 187, '1', 5, '14.04', 1495199733),
(30, 188, '1', 5, '14.04', 1495199733),
(32, 191, '1', 1, '1.17E-6', 1495199733),
(34, 157, '1', 5, '143.91', 1495200095),
(35, 158, '1', 5, '143.91', 1495200095),
(36, 159, '1', 5, '143.91', 1495200095),
(37, 160, '1', 5, '166.05', 1495200095),
(38, 161, '1', 5, '151.29', 1495200095),
(39, 162, '1', 5, '143.91', 1495200095),
(40, 163, '1', 5, '143.91', 1495200095),
(41, 164, '1', 5, '117', 1495200095),
(42, 165, '1', 5, '3.51', 1495200095),
(43, 166, '1', 5, '3.51', 1495200095),
(44, 167, '1', 5, '3.51', 1495200095),
(45, 168, '1', 5, '3.51', 1495200095),
(46, 169, '1', 5, '3.51', 1495200095),
(47, 170, '1', 5, '3.51', 1495200095),
(48, 171, '1', 5, '3.51', 1495200095),
(49, 172, '1', 5, '3.51', 1495200095),
(50, 173, '1', 5, '3.51', 1495200095),
(51, 174, '1', 5, '3.51', 1495200095),
(52, 175, '1', 5, '3.51', 1495200095),
(53, 176, '1', 5, '3.51', 1495200095),
(54, 177, '1', 5, '3.51', 1495200096),
(55, 178, '1', 5, '3.51', 1495200096),
(56, 181, '1', 5, '1.17', 1495200096),
(57, 182, '1', 5, '1.17', 1495200096),
(58, 183, '1', 5, '12.3', 1495200096),
(59, 184, '1', 5, '12.3', 1495200096),
(60, 185, '1', 5, '14.04', 1495200096),
(61, 186, '1', 5, '14.04', 1495200096),
(62, 187, '1', 5, '14.04', 1495200096),
(63, 188, '1', 5, '14.04', 1495200096),
(65, 191, '1', 1, '1.17E-6', 1495200096),
(67, 157, '1', 5, '143.91', 1495200304),
(68, 158, '1', 5, '143.91', 1495200304),
(69, 159, '1', 5, '143.91', 1495200304),
(70, 160, '1', 5, '166.05', 1495200304),
(71, 161, '1', 5, '151.29', 1495200304),
(72, 162, '1', 5, '143.91', 1495200304),
(73, 163, '1', 5, '143.91', 1495200304),
(74, 164, '1', 5, '117', 1495200304),
(75, 165, '1', 5, '3.51', 1495200304),
(76, 166, '1', 5, '3.51', 1495200304),
(77, 167, '1', 5, '3.51', 1495200304),
(78, 168, '1', 5, '3.51', 1495200304),
(79, 169, '1', 5, '3.51', 1495200304),
(80, 170, '1', 5, '3.51', 1495200304),
(81, 171, '1', 5, '3.51', 1495200305),
(82, 172, '1', 5, '3.51', 1495200305),
(83, 173, '1', 5, '3.51', 1495200305),
(84, 174, '1', 5, '3.51', 1495200305),
(85, 175, '1', 5, '3.51', 1495200305),
(86, 176, '1', 5, '3.51', 1495200305),
(87, 177, '1', 5, '3.51', 1495200305),
(88, 178, '1', 5, '3.51', 1495200305),
(89, 181, '1', 5, '1.17', 1495200305),
(90, 182, '1', 5, '1.17', 1495200305),
(91, 183, '1', 5, '12.3', 1495200305),
(92, 184, '1', 5, '12.3', 1495200305),
(93, 185, '1', 5, '14.04', 1495200305),
(94, 186, '1', 5, '14.04', 1495200305),
(95, 187, '1', 5, '14.04', 1495200305),
(96, 188, '1', 5, '14.04', 1495200305),
(98, 191, '1', 1, '1.17E-6', 1495200305),
(100, 157, '1', 5, '143.91', 1495200404),
(101, 158, '1', 5, '143.91', 1495200404),
(102, 159, '1', 5, '143.91', 1495200404),
(103, 160, '1', 5, '166.05', 1495200404),
(104, 161, '1', 5, '151.29', 1495200404),
(105, 162, '1', 5, '143.91', 1495200404),
(106, 163, '1', 5, '143.91', 1495200404),
(107, 164, '1', 5, '117', 1495200404),
(108, 165, '1', 5, '3.51', 1495200404),
(109, 166, '1', 5, '3.51', 1495200404),
(110, 167, '1', 5, '3.51', 1495200404),
(111, 168, '1', 5, '3.51', 1495200404),
(112, 169, '1', 5, '3.51', 1495200404),
(113, 170, '1', 5, '3.51', 1495200404),
(114, 171, '1', 5, '3.51', 1495200404),
(115, 172, '1', 5, '3.51', 1495200404),
(116, 173, '1', 5, '3.51', 1495200404),
(117, 174, '1', 5, '3.51', 1495200404),
(118, 175, '1', 5, '3.51', 1495200404),
(119, 176, '1', 5, '3.51', 1495200404),
(120, 177, '1', 5, '3.51', 1495200404),
(121, 178, '1', 5, '3.51', 1495200404),
(122, 181, '1', 5, '1.17', 1495200404),
(123, 182, '1', 5, '1.17', 1495200404),
(124, 183, '1', 5, '12.3', 1495200404),
(125, 184, '1', 5, '12.3', 1495200404),
(126, 185, '1', 5, '14.04', 1495200404),
(127, 186, '1', 5, '14.04', 1495200404),
(128, 187, '1', 5, '14.04', 1495200404),
(129, 188, '1', 5, '14.04', 1495200405),
(131, 191, '1', 1, '1.17E-6', 1495200405),
(133, 157, '1', 5, '143.91', 1495200453),
(134, 158, '1', 5, '143.91', 1495200453),
(135, 159, '1', 5, '143.91', 1495200453),
(136, 160, '1', 5, '166.05', 1495200453),
(137, 161, '1', 5, '151.29', 1495200453),
(138, 162, '1', 5, '143.91', 1495200453),
(139, 163, '1', 5, '143.91', 1495200453),
(140, 164, '1', 5, '117', 1495200453),
(141, 165, '1', 5, '3.51', 1495200453),
(142, 166, '1', 5, '3.51', 1495200453),
(143, 167, '1', 5, '3.51', 1495200453),
(144, 168, '1', 5, '3.51', 1495200454),
(145, 169, '1', 5, '3.51', 1495200454),
(146, 170, '1', 5, '3.51', 1495200454),
(147, 171, '1', 5, '3.51', 1495200454),
(148, 172, '1', 5, '3.51', 1495200454),
(149, 173, '1', 5, '3.51', 1495200454),
(150, 174, '1', 5, '3.51', 1495200454),
(151, 175, '1', 5, '3.51', 1495200454),
(152, 176, '1', 5, '3.51', 1495200454),
(153, 177, '1', 5, '3.51', 1495200454),
(154, 178, '1', 5, '3.51', 1495200454),
(155, 181, '1', 5, '1.17', 1495200454),
(156, 182, '1', 5, '1.17', 1495200454),
(157, 183, '1', 5, '12.3', 1495200454),
(158, 184, '1', 5, '12.3', 1495200454),
(159, 185, '1', 5, '14.04', 1495200454),
(160, 186, '1', 5, '14.04', 1495200454),
(161, 187, '1', 5, '14.04', 1495200454),
(162, 188, '1', 5, '14.04', 1495200454),
(164, 191, '1', 1, '1.17E-6', 1495200454),
(166, 157, '1', 5, '143.91', 1495200541),
(167, 158, '1', 5, '143.91', 1495200541),
(168, 159, '1', 5, '143.91', 1495200541),
(169, 160, '1', 5, '166.05', 1495200541),
(170, 161, '1', 5, '151.29', 1495200541),
(171, 162, '1', 5, '143.91', 1495200541),
(172, 163, '1', 5, '143.91', 1495200541),
(173, 164, '1', 5, '117', 1495200541),
(174, 165, '1', 5, '3.51', 1495200541),
(175, 166, '1', 5, '3.51', 1495200541),
(176, 167, '1', 5, '3.51', 1495200541),
(177, 168, '1', 5, '3.51', 1495200541),
(178, 169, '1', 5, '3.51', 1495200541),
(179, 170, '1', 5, '3.51', 1495200541),
(180, 171, '1', 5, '3.51', 1495200541),
(181, 172, '1', 5, '3.51', 1495200541),
(182, 173, '1', 5, '3.51', 1495200541),
(183, 174, '1', 5, '3.51', 1495200541),
(184, 175, '1', 5, '3.51', 1495200541),
(185, 176, '1', 5, '3.51', 1495200542),
(186, 177, '1', 5, '3.51', 1495200542),
(187, 178, '1', 5, '3.51', 1495200542),
(188, 181, '1', 5, '1.17', 1495200542),
(189, 182, '1', 5, '1.17', 1495200542),
(190, 183, '1', 5, '12.3', 1495200542),
(191, 184, '1', 5, '12.3', 1495200542),
(192, 185, '1', 5, '14.04', 1495200542),
(193, 186, '1', 5, '14.04', 1495200542),
(194, 187, '1', 5, '14.04', 1495200542),
(195, 188, '1', 5, '14.04', 1495200542),
(197, 191, '1', 1, '1.17E-6', 1495200542),
(199, 157, '1', 5, '143.91', 1495200814),
(200, 158, '1', 5, '143.91', 1495200814),
(201, 159, '1', 5, '143.91', 1495200814),
(202, 160, '1', 5, '166.05', 1495200814),
(203, 161, '1', 5, '151.29', 1495200814),
(204, 162, '1', 5, '143.91', 1495200815),
(205, 163, '1', 5, '143.91', 1495200815),
(206, 164, '1', 5, '117', 1495200815),
(207, 165, '1', 5, '3.51', 1495200815),
(208, 166, '1', 5, '3.51', 1495200815),
(209, 167, '1', 5, '3.51', 1495200815),
(210, 168, '1', 5, '3.51', 1495200815),
(211, 169, '1', 5, '3.51', 1495200815),
(212, 170, '1', 5, '3.51', 1495200815),
(213, 171, '1', 5, '3.51', 1495200815),
(214, 172, '1', 5, '3.51', 1495200815),
(215, 173, '1', 5, '3.51', 1495200815),
(216, 174, '1', 5, '3.51', 1495200815),
(217, 175, '1', 5, '3.51', 1495200815),
(218, 176, '1', 5, '3.51', 1495200815),
(219, 177, '1', 5, '3.51', 1495200816),
(220, 178, '1', 5, '3.51', 1495200816),
(221, 181, '1', 5, '1.17', 1495200816),
(222, 182, '1', 5, '1.17', 1495200816),
(223, 183, '1', 5, '12.3', 1495200816),
(224, 184, '1', 5, '12.3', 1495200816),
(225, 185, '1', 5, '14.04', 1495200816),
(226, 186, '1', 5, '14.04', 1495200816),
(227, 187, '1', 5, '14.04', 1495200816),
(228, 188, '1', 5, '14.04', 1495200816),
(230, 191, '1', 1, '1.17E-6', 1495200816),
(231, 195, '1', 1, '337500', 1495538437),
(232, 197, '1', 1, '1.23', 1495538437),
(233, 51, '1', 1, '1.17', 1495787531),
(234, 52, '1', 1, '1.17', 1495787533),
(235, 53, '1', 1, '1.17', 1495787534),
(236, 51, '1', 1, '11.7', 1495788226),
(237, 52, '1', 1, '11.7', 1495788349),
(238, 53, '1', 1, '11.7', 1495788461),
(239, 5, '1', 1, '117', 1495788794),
(240, 51, '1', 1, '11.7', 1495788825),
(241, 52, '1', 1, '11.7', 1495788842),
(242, 53, '1', 1, '11.7', 1495788883),
(243, 5, '1', 1, '117', 1495789011),
(244, 51, '1', 1, '11.7', 1495789011),
(245, 52, '1', 1, '11.7', 1495789012),
(246, 53, '1', 1, '11.7', 1495789012),
(247, 5, '1', 1, '117', 1495790394),
(248, 52, '1', 1, '11.7', 1495790394),
(249, 52, '1', 1, '2.34', 1495801438),
(250, 53, '1', 1, '11.7', 1495801438);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) unsigned NOT NULL,
  `k` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `v` varchar(1024) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `k`, `v`) VALUES
(1, 'verify_address', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE IF NOT EXISTS `subscriber` (
  `id` int(11) unsigned NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_message`
--

CREATE TABLE IF NOT EXISTS `support_message` (
  `id` bigint(20) unsigned NOT NULL,
  `room_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_seen` tinyint(1) unsigned NOT NULL,
  `support_seen` tinyint(1) unsigned NOT NULL,
  `message` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `created` bigint(16) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `support_message`
--

INSERT INTO `support_message` (`id`, `room_id`, `user_id`, `user_seen`, `support_seen`, `message`, `created`) VALUES
(1, 1, 1, 0, 0, 'dfdfdf', 1493890773),
(2, 1, 1, 0, 0, 'dfdfdf', 1493890802),
(3, 1, 1, 0, 0, 'asdasdasd', 1493899068),
(4, 1, 1, 0, 0, 'asdasdasd', 1493899070),
(5, 1, 1, 0, 0, 'asdasdasd', 1493899070),
(6, 1, 1, 0, 0, 'asdasdasd', 1493899070),
(7, 1, 1, 0, 0, 'asdasdasd', 1493899071),
(8, 1, 1, 0, 0, 'asdasdasd', 1493899071),
(9, 1, 1, 0, 0, 'asdasdasd', 1493899071),
(10, 1, 1, 0, 0, 'asdasdasd', 1493899071),
(11, 1, 1, 0, 0, 'Hello there!', 1493916847),
(12, 1, 1, 0, 0, 'Hi.', 1493916976),
(13, 1, 1, 0, 0, 'How are you?', 1493916983),
(14, 2, 3, 0, 0, 'hello', 1493919365),
(15, 2, 3, 0, 0, 'fdfdsvsd', 1493919369),
(16, 2, 3, 0, 0, 'sdvsdvsd', 1493919373),
(17, 3, 2, 0, 0, 'huhuhi', 1493919727),
(18, 3, 2, 0, 0, 'hjhh77gug', 1493919740),
(19, 3, 2, 0, 0, 'hbjbjkbjjb', 1493919745),
(20, 2, 1, 0, 0, 'fdgfdgfdg', 1494339149),
(21, 2, 1, 0, 0, 'fdgdfgdfgdfg', 1494339170),
(22, 1, 1, 0, 0, '1', 1494339191),
(23, 1, 1, 0, 0, '1', 1494339319),
(24, 1, 1, 0, 0, '2', 1494339366),
(25, 1, 1, 0, 0, '3', 1494339547),
(26, 1, 1, 0, 0, '4', 1494339549),
(27, 1, 1, 0, 0, '5', 1494339551),
(28, 1, 1, 0, 0, '6', 1494339553),
(29, 1, 1, 0, 0, '7', 1494339555),
(30, 1, 1, 0, 0, '8', 1494339556),
(31, 1, 1, 0, 0, '9', 1494339558),
(32, 1, 1, 0, 0, '10', 1494339562),
(33, 1, 1, 0, 0, '11', 1494339806),
(34, 1, 1, 0, 0, '12', 1494339816),
(35, 2, 1, 0, 0, '1', 1494339830),
(36, 3, 1, 0, 0, '1', 1494339846),
(37, 3, 2, 0, 0, 'dsfdsfsdf', 1494339976),
(38, 3, 2, 0, 0, 'sdfsdfsdf', 1494339979),
(39, 3, 1, 0, 0, 'sdsdsd', 1494340002),
(40, 3, 2, 0, 0, 'sdsdsd', 1494340009),
(41, 3, 2, 0, 0, 'fgfghfghgfh', 1494340013),
(42, 3, 2, 0, 0, 'dfgdfgdfg', 1494340016),
(43, 3, 2, 0, 0, '		Trrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 1494340024),
(44, 3, 1, 0, 0, 'eeeeeeeeeeeeeeeeeeeee', 1494340079),
(45, 3, 2, 0, 0, '2qqqqq', 1494340083),
(46, 3, 2, 0, 0, 'sss', 1494340086),
(47, 3, 2, 0, 0, 'ssssssss', 1494340092),
(48, 3, 1, 0, 0, 'wwwwwwwwwwwwwwwwwwwwwww', 1494340096),
(49, 3, 2, 0, 0, 'eeeeeeeeeeee', 1494340099),
(50, 1, 1, 0, 0, '1', 1495634626),
(51, 1, 1, 0, 0, '2', 1495634632),
(52, 1, 1, 0, 0, '1', 1495634636),
(53, 1, 1, 0, 0, '1', 1495817075),
(54, 1, 1, 0, 0, 'wqeqwe', 1495817171),
(55, 1, 1, 0, 0, 'qweqw', 1495817185),
(56, 1, 1, 0, 0, 'ewqeqw', 1495817408),
(57, 1, 1, 0, 0, 'qeweq', 1495817433),
(58, 1, 1, 0, 0, 'dasda', 1495817484),
(59, 1, 1, 0, 0, 'qwe', 1495817493),
(60, 1, 1, 0, 0, 'qweq', 1495817498),
(61, 1, 1, 0, 0, 'asdas', 1495817556),
(62, 1, 1, 0, 0, '123', 1495817615),
(63, 1, 1, 0, 0, 'qweqw', 1495817631),
(64, 1, 1, 0, 0, 'eqw', 1495817637),
(65, 3, 2, 0, 0, 'wqe', 1495822088),
(66, 1, 1, 0, 0, 'eqw', 1495970349),
(67, 1, 1, 0, 0, 'qwerty', 1495991952);

-- --------------------------------------------------------

--
-- Table structure for table `support_room`
--

CREATE TABLE IF NOT EXISTS `support_room` (
  `id` bigint(20) unsigned AUTO_INCREMENT primary key,
  `user_id` bigint(20) unsigned NOT NULL,
  `support_id` bigint(20) unsigned NOT NULL,
  `status` int(1) unsigned NOT NULL DEFAULT '1',
  `created` bigint(16) unsigned NOT NULL,
  `opened` bigint(16) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `support_room`
--

INSERT INTO `support_room` (`id`, `user_id`, `support_id`, `status`, `created`, `opened`) VALUES
(1, 1, 1, 1, 1493890772, 1493890772),
(2, 3, 1, 1, 1493919359, 1493919359),
(3, 2, 1, 1, 1493919647, 1493919647),
(4, 5, 1, 1, 1494951049, 1494951049);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) unsigned NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verify_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created` bigint(16) NOT NULL,
  `twofa_enabled` tinyint(1) unsigned NOT NULL,
  `twofa_passed` tinyint(1) unsigned NOT NULL,
  `twofa_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_notification` tinyint(1) unsigned NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `authKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notification_last_id` bigint(20) NOT NULL,
  `last_sync` bigint(16) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `address`, `verify_address`, `password`, `balance`, `status`, `created`, `twofa_enabled`, `twofa_passed`, `twofa_secret`, `email_notification`, `email`, `country`, `authKey`, `notification_last_id`, `last_sync`) VALUES
(1, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2', '', '10470c3b4b1fed12c3baac014be15fac67c6e815', '25.12927366', 1, 1493310692, 0, 0, 'N5BMZ4N2RTW4MXAN', 0, 'qwerty@email.com', '', '', 0, 1495802433),
(2, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN25', '', '10470c3b4b1fed12c3baac014be15fac67c6e815', '0', 1, 1495818595, 0, 0, '', 1, '123@eqwe.1', '', '', 0, NULL),
(3, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN27', '', '10470c3b4b1fed12c3baac014be15fac67c6e815', '0', 0, 1495978114, 0, 0, '', 0, '', '', '', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_id_3407_00` (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`access_token`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD PRIMARY KEY (`authorization_code`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_jwt`
--
ALTER TABLE `oauth_jwt`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`refresh_token`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_users`
--
ALTER TABLE `oauth_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_id_8664_00` (`id`),
  ADD KEY `idx_user_id_8664_01` (`user_id`);

--
-- Indexes for table `parking_type`
--
ALTER TABLE `parking_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payout`
--
ALTER TABLE `payout`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_id_1572_00` (`id`),
  ADD KEY `idx_parking_id_1573_01` (`parking_id`),
  ADD KEY `idx_user_id_1573_02` (`user_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_id_0907_00` (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_k_0907_01` (`k`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_id_9804_00` (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_email_9804_01` (`email`);

--
-- Indexes for table `support_message`
--
ALTER TABLE `support_message`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_id_1437_00` (`id`),
  ADD KEY `idx_room_id_1438_01` (`room_id`),
  ADD KEY `idx_user_id_1438_02` (`user_id`);

--
-- Indexes for table `support_room`
--
ALTER TABLE `support_room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_id_537_00` (`id`),
  ADD KEY `idx_user_id_537_01` (`user_id`),
  ADD KEY `idx_support_id_537_02` (`support_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_UNIQUE_id_0885_00` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `parking`
--
ALTER TABLE `parking`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `parking_type`
--
ALTER TABLE `parking_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payout`
--
ALTER TABLE `payout`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=251;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `support_message`
--
ALTER TABLE `support_message`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `support_room`
--
ALTER TABLE `support_room`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD CONSTRAINT `oauth_access_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD CONSTRAINT `oauth_authorization_codes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD CONSTRAINT `oauth_refresh_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parking`
--
ALTER TABLE `parking`
  ADD CONSTRAINT `fk_user_8652_00` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `payout`
--
ALTER TABLE `payout`
  ADD CONSTRAINT `fk_parking_1561_00` FOREIGN KEY (`parking_id`) REFERENCES `parking` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_1562_01` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `support_message`
--
ALTER TABLE `support_message`
  ADD CONSTRAINT `fk_support_room_1429_00` FOREIGN KEY (`room_id`) REFERENCES `support_room` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_1429_01` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `support_room`
--
ALTER TABLE `support_room`
  ADD CONSTRAINT `fk_user_5361_00` FOREIGN KEY (`support_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_5361_01` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
