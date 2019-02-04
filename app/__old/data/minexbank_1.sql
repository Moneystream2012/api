-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2017 at 05:19 PM
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
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` varchar(1024) NOT NULL DEFAULT '',
  `seen` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created` bigint(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `type`, `title`, `content`, `seen`, `created`) VALUES
(2, 0, 0, '1', '1', 0, 1494947496),
(3, 5, 0, '2', '2', 0, 1494947535),
(4, 0, 0, '3', '3', 0, 1494950741),
(5, 0, 0, 'sdf', 'sdfsdfsdf', 0, 1494249787),
(6, 0, 0, 'sdf', 'sdfsdfsdf', 0, 1494249810),
(7, 0, 0, 'df', 'dfdff', 0, 1494250502),
(8, 0, 0, 'df', 'dfdff', 0, 1494250511),
(9, 0, 0, 'df', 'dfdff', 0, 1494250511),
(10, 0, 0, 'df', 'dfdff', 0, 1494250513),
(11, 0, 0, 'df', 'dfdff', 0, 1494250513),
(12, 0, 0, 'df', 'dfdff', 0, 1494250514),
(13, 0, 0, 'df', 'dfdff', 0, 1494250516),
(14, 0, 0, 'df', 'dfdff', 0, 1494250517),
(15, 0, 0, 'df', 'dfdff', 0, 1494250517),
(16, 0, 0, 'df', 'dfdff', 0, 1494250517),
(17, 0, 0, 'df', 'dfdff', 0, 1494250520),
(18, 0, 0, 'df', 'dfdff', 0, 1494250520),
(19, 0, 0, 'df', 'dfdff', 0, 1494250521),
(20, 0, 0, 'df', 'dfdff', 0, 1494250521),
(21, 0, 0, 'df', 'dfdff', 0, 1494250521),
(22, 0, 0, 'sdf', 'sdfsdfsfd', 0, 1494250625),
(23, 0, 0, 'sdf', 'sdfsdfsfd', 0, 1494250627),
(24, 0, 0, 'sdf', 'sdfsdfsfd', 0, 1494250629),
(25, 0, 0, 'sdf', 'sdfsdfsfd', 0, 1494250630),
(26, 0, 0, 'sdf', 'sdfsdfsfd', 0, 1494250632),
(27, 0, 0, 'sdf', 'sdfsdfsfd', 0, 1494250634),
(28, 0, 0, 'dsf', 'sdfsdfsdf', 0, 1494250703),
(29, 0, 0, 'dsf', 'sdfsdfsdf', 0, 1494250704),
(30, 0, 0, 'dsf', 'sdfsdfsdf', 0, 1494250706),
(31, 0, 0, 'fasdf', 'afdsads', 0, 1494250942),
(32, 0, 0, 'fasdf', 'adsfsdf', 0, 1494250963),
(33, 0, 0, '\\cx\\', 'fsdaf', 0, 1494251016),
(34, 0, 0, 'GFDSG', 'SDGFSDFG', 0, 1494251054),
(35, 0, 0, 'fasdf', 'fasdfa', 0, 1494251087),
(36, 0, 0, 'fasd', 'afsdsdf', 0, 1494251103),
(37, 0, 0, 'fdagg', 'fasd', 0, 1494251136),
(38, 0, 0, 'asfd', 'fadsf', 0, 1494251191),
(39, 0, 0, 'asdfasd', 'afsdfas', 0, 1494251238),
(40, 0, 0, 'afsdf', 'fasdfas', 0, 1494251306),
(41, 0, 0, 'asdfasd', 'asdfasdf', 0, 1494251366),
(42, 0, 0, 'fasdf', 'fasdf', 0, 1494251380),
(43, 0, 0, 'fasdfasd', 'adsfsdf', 0, 1494251421),
(44, 0, 0, 'afsd', 'fasd', 0, 1494251434),
(45, 0, 0, 'dsafasd', 'afsdfasd', 0, 1494251465),
(46, 0, 0, 'dasfsda', 'afsdadsf', 0, 1494944549);

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE IF NOT EXISTS `parking` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `rate` varchar(8) NOT NULL DEFAULT '',
  `amount` varchar(32) NOT NULL DEFAULT '',
  `info` varchar(1024) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `created` bigint(16) NOT NULL DEFAULT '0',
  `device` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `user_id`, `type`, `rate`, `amount`, `info`, `status`, `created`, `device`) VALUES
(5, 1, 2, '17', '0', '', 1, 1493917266, 'web'),
(6, 3, 2, '17', '0', '', 1, 1493919289, 'web'),
(7, 3, 2, '17', '0', '', 1, 1493919294, 'web'),
(8, 3, 2, '17', '0', '', 1, 1493919297, 'web'),
(9, 3, 2, '17', '0', '', 1, 1493919298, 'web'),
(10, 3, 2, '17', '0', '', 1, 1493919298, 'web'),
(11, 1, 2, '17', '0', '', 1, 1494001371, 'web'),
(12, 1, 2, '17', '0123', '', 1, 1494001376, 'web'),
(13, 1, 2, '17', '0', '', 1, 1494001378, 'web'),
(14, 1, 2, '17', '0', '', 1, 1494001378, 'web'),
(15, 1, 2, '17', '0', '', 1, 1494001378, 'web'),
(16, 1, 2, '17', '0', '', 1, 1494001378, 'web'),
(17, 1, 2, '17', '0', '', 1, 1494001379, 'web'),
(18, 1, 2, '17', '0', '', 1, 1494001381, 'web'),
(19, 1, 2, '17', '0', '', 1, 1494001381, 'web'),
(20, 1, 2, '17', '0', '', 1, 1494001382, 'web'),
(21, 1, 2, '17', '0', '', 1, 1494001382, 'web'),
(22, 1, 2, '17', '0', '', 1, 1494001383, 'web'),
(23, 1, 2, '17', '0', '', 1, 1494001383, 'web'),
(24, 1, 2, '17', '0', '', 1, 1494001384, 'web'),
(25, 1, 2, '17', '0', '', 1, 1494001385, 'web'),
(26, 1, 2, '17', '0', '', 1, 1494001385, 'web'),
(27, 1, 2, '17', '0', '', 1, 1494001385, 'web'),
(28, 1, 2, '17', '0', '', 1, 1494001385, 'web'),
(29, 1, 2, '17', '0', '', 1, 1494001386, 'web'),
(30, 1, 2, '17', '0', '', 1, 1494001386, 'web'),
(31, 1, 2, '17', '0', '', 1, 1494001386, 'web'),
(32, 1, 2, '17', '0', '', 1, 1494001386, 'web'),
(33, 1, 2, '17', '0', '', 1, 1494001388, 'web'),
(34, 1, 2, '17', '0', '', 1, 1494001388, 'web'),
(35, 1, 2, '17', '0', '', 1, 1494001389, 'web'),
(36, 1, 2, '17', '0', '', 1, 1494001389, 'web'),
(37, 1, 2, '17', '0', '', 1, 1494001389, 'web'),
(38, 1, 3, '17', '0111', '', 1, 1494001389, 'web'),
(39, 1, 2, '17', '0', '', 1, 1494001389, 'web'),
(40, 1, 1, '17', '0234', '', 1, 1494001418, 'web'),
(42, 1, 1, '17', '0', '', 1, 1494001420, 'web');

-- --------------------------------------------------------

--
-- Table structure for table `parking_type`
--

CREATE TABLE IF NOT EXISTS `parking_type` (
  `id` int(11) NOT NULL,
  `rate` varchar(16) NOT NULL DEFAULT '0',
  `title` varchar(64) NOT NULL DEFAULT '',
  `period` bigint(16) NOT NULL DEFAULT '0',
  `created` bigint(16) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parking_type`
--

INSERT INTO `parking_type` (`id`, `rate`, `title`, `period`, `created`) VALUES
(1, '17', 'Daily', 78000, 0),
(2, '23', 'Weekly', 560000, 0),
(3, '35', 'Monthly', 3000000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payout`
--

CREATE TABLE IF NOT EXISTS `payout` (
  `id` bigint(20) unsigned NOT NULL,
  `parking_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `transaction_id` varchar(255) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `amount` varchar(32) DEFAULT '0',
  `created` bigint(16) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) unsigned NOT NULL,
  `k` varchar(255) NOT NULL,
  `v` varchar(1024) NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
  `email` varchar(64) NOT NULL,
  `created` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `support_message`
--

CREATE TABLE IF NOT EXISTS `support_message` (
  `id` bigint(20) unsigned NOT NULL,
  `room_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_seen` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `support_seen` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `message` varchar(1024) NOT NULL DEFAULT '',
  `created` bigint(16) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

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
(43, 3, 2, 0, 0, 'Trrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 1494340024),
(44, 3, 1, 0, 0, 'eeeeeeeeeeeeeeeeeeeee', 1494340079),
(45, 3, 2, 0, 0, '2qqqqq', 1494340083),
(46, 3, 2, 0, 0, 'sss', 1494340086),
(47, 3, 2, 0, 0, 'ssssssss', 1494340092),
(48, 3, 1, 0, 0, 'wwwwwwwwwwwwwwwwwwwwwww', 1494340096),
(49, 3, 2, 0, 0, 'eeeeeeeeeeee', 1494340099);

-- --------------------------------------------------------

--
-- Table structure for table `support_room`
--

CREATE TABLE IF NOT EXISTS `support_room` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `support_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `status` int(1) unsigned NOT NULL DEFAULT '1',
  `created` bigint(16) unsigned NOT NULL DEFAULT '0',
  `opened` bigint(16) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
  `address` varchar(255) NOT NULL DEFAULT '',
  `verify_address` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `balance` varchar(32) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `created` bigint(16) NOT NULL DEFAULT '0',
  `twofa_enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `twofa_passed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `twofa_secret` varchar(255) NOT NULL DEFAULT '',
  `email_notification` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `email` varchar(64) NOT NULL DEFAULT '',
  `country` varchar(4) NOT NULL DEFAULT '',
  `authKey` varchar(255) NOT NULL DEFAULT '',
  `notification_last_id` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `address`, `verify_address`, `password`, `balance`, `status`, `created`, `twofa_enabled`, `twofa_passed`, `twofa_secret`, `email_notification`, `email`, `country`, `authKey`, `notification_last_id`) VALUES
(1, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2', '', '10470c3b4b1fed12c3baac014be15fac67c6e815', '0', 1, 1493310692, 1, 0, 'N5BMZ4N2RTW4MXAN', 0, 'xinonghost@gmail.com', '', '', 0),
(2, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN3', '', 'f0cff509a02114047d4c3e29c5ffcd6e5b2ad416', '0', 1, 1493919170, 0, 0, '', 0, '', '', '', 0),
(3, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN4', '', 'f0cff509a02114047d4c3e29c5ffcd6e5b2ad416', '0', 1, 1493919226, 0, 0, '', 0, '', '', '', 0),
(4, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN25', '', '7f06c04d59bd83605193621e8d0d693bd30cdc9e', '0', 1, 1494579293, 0, 0, '', 0, '', '', '', 0),
(5, '1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN37', '', '10470c3b4b1fed12c3baac014be15fac67c6e815', '0', 1, 1494949449, 0, 0, '', 0, '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_parking_user_id` (`user_id`);

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
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_payout_parking_id` (`parking_id`),
  ADD KEY `FK_payout_user_id` (`user_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `k` (`k`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `support_message`
--
ALTER TABLE `support_message`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_support_message_support_room_id` (`room_id`),
  ADD KEY `FK_support_message_user_id` (`user_id`);

--
-- Indexes for table `support_room`
--
ALTER TABLE `support_room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_support_room_user_id` (`user_id`),
  ADD KEY `FK_support_room_support_user_id` (`support_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `parking`
--
ALTER TABLE `parking`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `parking_type`
--
ALTER TABLE `parking_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payout`
--
ALTER TABLE `payout`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `support_room`
--
ALTER TABLE `support_room`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `parking`
--
ALTER TABLE `parking`
  ADD CONSTRAINT `FK_parking_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payout`
--
ALTER TABLE `payout`
  ADD CONSTRAINT `FK_payout_parking_id` FOREIGN KEY (`parking_id`) REFERENCES `parking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_payout_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `support_message`
--
ALTER TABLE `support_message`
  ADD CONSTRAINT `FK_support_message_support_room_id` FOREIGN KEY (`room_id`) REFERENCES `support_room` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_support_message_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `support_room`
--
ALTER TABLE `support_room`
  ADD CONSTRAINT `FK_support_room_support_user_id` FOREIGN KEY (`support_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_support_room_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
