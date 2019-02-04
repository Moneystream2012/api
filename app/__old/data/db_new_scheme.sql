-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: minexbank
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` varchar(1024) NOT NULL DEFAULT '',
  `seen` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_notification_user_id` (`user_id`),
  CONSTRAINT `FK_notification_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_heap`
--

DROP TABLE IF EXISTS `notification_heap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_heap` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` varchar(1024) NOT NULL DEFAULT '',
  `created` bigint(16) not null DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_heap`
--

LOCK TABLES `notification_heap` WRITE;
/*!40000 ALTER TABLE `notification_heap` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_heap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parking`
--

DROP TABLE IF EXISTS `parking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parking` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `rate` varchar(8) NOT NULL DEFAULT '',
  `amount` varchar(32) NOT NULL DEFAULT '',
  `info` varchar(1024) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `created` bigint(16) NOT NULL DEFAULT '0',
  `device` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_parking_user_id` (`user_id`),
  CONSTRAINT `FK_parking_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parking`
--

LOCK TABLES `parking` WRITE;
/*!40000 ALTER TABLE `parking` DISABLE KEYS */;
INSERT INTO `parking` VALUES (5,1,2,'17','0','',1,1493917266,'web'),(6,3,2,'17','0','',1,1493919289,'web'),(7,3,2,'17','0','',1,1493919294,'web'),(8,3,2,'17','0','',1,1493919297,'web'),(9,3,2,'17','0','',1,1493919298,'web'),(10,3,2,'17','0','',1,1493919298,'web'),(11,1,2,'17','0','',1,1494001371,'web'),(12,1,2,'17','0','',1,1494001376,'web'),(13,1,2,'17','0','',1,1494001378,'web'),(14,1,2,'17','0','',1,1494001378,'web'),(15,1,2,'17','0','',1,1494001378,'web'),(16,1,2,'17','0','',1,1494001378,'web'),(17,1,2,'17','0','',1,1494001379,'web'),(18,1,2,'17','0','',1,1494001381,'web'),(19,1,2,'17','0','',1,1494001381,'web'),(20,1,2,'17','0','',1,1494001382,'web'),(21,1,2,'17','0','',1,1494001382,'web'),(22,1,2,'17','0','',1,1494001383,'web'),(23,1,2,'17','0','',1,1494001383,'web'),(24,1,2,'17','0','',1,1494001384,'web'),(25,1,2,'17','0','',1,1494001385,'web'),(26,1,2,'17','0','',1,1494001385,'web'),(27,1,2,'17','0','',1,1494001385,'web'),(28,1,2,'17','0','',1,1494001385,'web'),(29,1,2,'17','0','',1,1494001386,'web'),(30,1,2,'17','0','',1,1494001386,'web'),(31,1,2,'17','0','',1,1494001386,'web'),(32,1,2,'17','0','',1,1494001386,'web'),(33,1,2,'17','0','',1,1494001388,'web'),(34,1,2,'17','0','',1,1494001388,'web'),(35,1,2,'17','0','',1,1494001389,'web'),(36,1,2,'17','0','',1,1494001389,'web'),(37,1,2,'17','0','',1,1494001389,'web'),(38,1,2,'17','0','',1,1494001389,'web'),(39,1,2,'17','0','',1,1494001389,'web'),(40,1,1,'17','0','',1,1494001418,'web'),(41,1,1,'17','0','',1,1494001420,'web'),(42,1,1,'17','0','',1,1494001420,'web');
/*!40000 ALTER TABLE `parking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parking_type`
--

DROP TABLE IF EXISTS `parking_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parking_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rate` varchar(16) NOT NULL DEFAULT '0',
  `title` varchar(64) NOT NULL DEFAULT '',
  `period` bigint(16) NOT NULL DEFAULT '0',
  `created` bigint(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parking_type`
--

LOCK TABLES `parking_type` WRITE;
/*!40000 ALTER TABLE `parking_type` DISABLE KEYS */;
INSERT INTO `parking_type` VALUES (1,'17','Daily',78000,0),(2,'23','Weekly',560000,0),(3,'35','Monthly',3000000,0);
/*!40000 ALTER TABLE `parking_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payout`
--

DROP TABLE IF EXISTS `payout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payout` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parking_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `transaction_id` varchar(255) NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `amount` varchar(32) DEFAULT '0',
  `created` bigint(16) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_payout_parking_id` (`parking_id`),
  KEY `FK_payout_user_id` (`user_id`),
  CONSTRAINT `FK_payout_parking_id` FOREIGN KEY (`parking_id`) REFERENCES `parking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_payout_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payout`
--

LOCK TABLES `payout` WRITE;
/*!40000 ALTER TABLE `payout` DISABLE KEYS */;
/*!40000 ALTER TABLE `payout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `k` varchar(255) NOT NULL,
  `v` varchar(1024) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `k` (`k`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'verify_address','12345');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriber`
--

DROP TABLE IF EXISTS `subscriber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriber` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `created` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriber`
--

LOCK TABLES `subscriber` WRITE;
/*!40000 ALTER TABLE `subscriber` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriber` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_message`
--

DROP TABLE IF EXISTS `support_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_message` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_seen` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `support_seen` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `message` varchar(1024) NOT NULL DEFAULT '',
  `created` bigint(16) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_support_message_support_room_id` (`room_id`),
  KEY `FK_support_message_user_id` (`user_id`),
  CONSTRAINT `FK_support_message_support_room_id` FOREIGN KEY (`room_id`) REFERENCES `support_room` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_support_message_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_message`
--

LOCK TABLES `support_message` WRITE;
/*!40000 ALTER TABLE `support_message` DISABLE KEYS */;
INSERT INTO `support_message` VALUES (1,1,1,0,0,'dfdfdf',1493890773),(2,1,1,0,0,'dfdfdf',1493890802),(3,1,1,0,0,'asdasdasd',1493899068),(4,1,1,0,0,'asdasdasd',1493899070),(5,1,1,0,0,'asdasdasd',1493899070),(6,1,1,0,0,'asdasdasd',1493899070),(7,1,1,0,0,'asdasdasd',1493899071),(8,1,1,0,0,'asdasdasd',1493899071),(9,1,1,0,0,'asdasdasd',1493899071),(10,1,1,0,0,'asdasdasd',1493899071),(11,1,1,0,0,'Hello there!',1493916847),(12,1,1,0,0,'Hi.',1493916976),(13,1,1,0,0,'How are you?',1493916983),(14,2,3,0,0,'hello',1493919365),(15,2,3,0,0,'fdfdsvsd',1493919369),(16,2,3,0,0,'sdvsdvsd',1493919373),(17,3,2,0,0,'huhuhi',1493919727),(18,3,2,0,0,'hjhh77gug',1493919740),(19,3,2,0,0,'hbjbjkbjjb',1493919745);
/*!40000 ALTER TABLE `support_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_room`
--

DROP TABLE IF EXISTS `support_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_room` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `support_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `status` int(1) unsigned NOT NULL DEFAULT '1',
  `created` bigint(16) unsigned NOT NULL DEFAULT '0',
  `opened` bigint(16) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_support_room_user_id` (`user_id`),
  KEY `FK_support_room_support_user_id` (`support_id`),
  CONSTRAINT `FK_support_room_support_user_id` FOREIGN KEY (`support_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_support_room_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_room`
--

LOCK TABLES `support_room` WRITE;
/*!40000 ALTER TABLE `support_room` DISABLE KEYS */;
INSERT INTO `support_room` VALUES (1,1,1,1,1493890772,1493890772),(2,3,1,1,1493919359,1493919359),(3,2,1,1,1493919647,1493919647);
/*!40000 ALTER TABLE `support_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `notification_last_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2','','10470c3b4b1fed12c3baac014be15fac67c6e815','0',1,1493310692,1,0,'N5BMZ4N2RTW4MXAN',0,'xinonghost@gmail.com','','',0),(2,'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN3','','f0cff509a02114047d4c3e29c5ffcd6e5b2ad416','0',1,1493919170,0,0,'',0,'','','',0),(3,'1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN4','','f0cff509a02114047d4c3e29c5ffcd6e5b2ad416','0',1,1493919226,0,0,'',0,'','','',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-08 14:55:37
