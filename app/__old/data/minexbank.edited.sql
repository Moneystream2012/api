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
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1495717708),('m140501_075311_add_oauth2_server',1495717724);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

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
  UNIQUE KEY `idx_UNIQUE_id_3407_00` (`id`),
  KEY `FK_notification_user_id` (`user_id`),
  CONSTRAINT `FK_notification_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (2,1,0,'Title','Content',0,'1545156486'),(3,1,0,'Title','Content',0,'1545156486'),(4,1,0,'Title','Content',0,'1545156486'),(5,1,0,'Title','Content',0,'1545156486'),(6,1,0,'Title','Content',0,'1545156486'),(7,1,0,'Title','Content',0,'1545156486'),(10,1,0,'Title','Content',0,'1545156486'),(11,1,0,'Title','Content',0,'1545156486'),(12,1,0,'Title','Content',0,'1545156486'),(13,1,0,'Title','Content',0,'1545156486'),(14,1,0,'Title','Content',0,'1545156486'),(15,1,0,'Title','Content',0,'1545156486'),(16,1,0,'Title','Content',0,'1545156486'),(17,1,0,'Title','Content',0,'1545156486'),(18,1,0,'Title','Content',0,'1545156486'),(19,1,0,'Title','Content',0,'1545156486'),(20,1,0,'Title','Content',0,'1545156486'),(21,1,0,'Title','Content',0,'1545156486'),(22,1,0,'Title','Content',0,'1545156486'),(23,1,0,'Title','Content',0,'1545156486'),(24,1,0,'Title','Content',0,'1545156486'),(25,1,0,'Title','Content',0,'1545156486'),(26,1,0,'Title','Content',0,'1545156486'),(27,1,0,'Title','Content',0,'1545156486'),(28,1,0,'Title','Content',0,'1545156486'),(29,1,0,'Title','Content',0,'1545156486'),(30,1,0,'Title','Content',0,'1545156486'),(31,1,0,'Title','Content',0,'1545156486'),(32,1,0,'Title','Content',0,'1545156486'),(33,1,0,'Title','Content',0,'1545156486');
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
  `created` varchar(255) DEFAULT NULL,
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
-- Table structure for table `notification_seen_index`
--

DROP TABLE IF EXISTS `notification_seen_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_seen_index` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `notification_id` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_seen_index`
--

LOCK TABLES `notification_seen_index` WRITE;
/*!40000 ALTER TABLE `notification_seen_index` DISABLE KEYS */;
INSERT INTO `notification_seen_index` VALUES (1,7),(1,6),(1,4),(1,5),(1,2),(1,3),(1,19),(1,22),(1,33),(1,23),(1,21),(1,32),(1,31),(1,30),(1,10),(1,11),(1,12),(1,13),(1,29);
/*!40000 ALTER TABLE `notification_seen_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`access_token`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `oauth_access_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('004cd4088ba54052b1821e14f5de55b16e075851','testclient',1,'2017-05-31 09:30:47',NULL),('00f9bd1e68843997eea67e8a5a977b70bc3f068d','testclient',1,'2017-05-30 13:02:44',NULL),('01b6e0cc0ce08ef91adf76e08ec492b67f2a677d','testclient',1,'2017-06-02 07:59:39',NULL),('05e34ae72830378623254d1e10a4b7c378eeae0b','testclient',1,'2017-06-01 10:31:47',NULL),('05eb123ac46a86216f221f63638ebb6cbd8665bf','testclient',1,'2017-05-30 13:00:13',NULL),('06ecc83f21310c87e84bf3287a026dc1b035a174','testclient',1,'2017-05-31 13:38:12',NULL),('07f1656b59255011a4f459fb8409503efc44e75b','testclient',1,'2017-06-06 10:32:24',NULL),('08b4f6c076ecd3ffffa9abc602fc790e4f03f70e','testclient',1,'2017-06-02 12:39:05',NULL),('0914bf96690a7551a5b7b2f65dd0c4d284b46d37','testclient',1,'2017-05-29 13:06:15',NULL),('09368ae49ccdf07c1ea99e99ac3ca9850ef552b3','testclient',1,'2017-05-29 11:43:26',NULL),('093ba94616fcab7b8cf9733e7bfe79c3e2b40247','testclient',1,'2017-05-31 13:18:42',NULL),('09ed1b4d9ef9de43d0752ca48a143ae7b39a7b4e','testclient',1,'2017-05-29 12:34:05',NULL),('0bb3be7867ba6e585e66405d663f18921418dbf4','testclient',1,'2017-05-30 14:31:20',NULL),('0bc7f75d2d42d6c25c49747fd6ae90e9359c2224','testclient',1,'2017-06-02 15:04:13',NULL),('0c9200b48190acd4493db92fb8462a793ba452fd','testclient',1,'2017-05-31 13:26:49',NULL),('0e730b92f5a95b23c3a12b1a981145c1c456c257','testclient',1,'2017-05-31 13:21:05',NULL),('0f9f28da98476bcf644ba8c1da2087f38d1c6fe7','testclient',1,'2017-06-02 14:51:47',NULL),('1136b3578a8cceb4cd4e44070ae081804acd079e','testclient',1,'2017-05-31 10:34:14',NULL),('11ba658d6efa18603550698e313b26d754466bab','testclient',1,'2017-05-29 11:55:50',NULL),('125e6c005a944d5f4ceef61f973b534e9413d530','testclient',1,'2017-06-02 07:56:11',NULL),('15ac9c6cc7db7b26cf88dc95394bda0b002b0cb0','testclient',1,'2017-05-29 12:21:26',NULL),('16f22b33d3a3eb058c626929c14232121f91a86d','testclient',1,'2017-05-30 09:16:24',NULL),('17cb2d3aa2a84f188059fa0afe0ea7f8d4c439f0','testclient',1,'2017-05-30 16:31:02',NULL),('1914c8d5fc8b78a1f6ec0f272b4b53f966d10c2d','testclient',1,'2017-05-30 09:08:54',NULL),('198dcab0604e9618f039e9116f5376939c69c8de','testclient',1,'2017-05-27 08:38:05',NULL),('1b3747383c3ae686e3e3a2d934632a22cf4ef0f9','testclient',1,'2017-06-01 14:12:38',NULL),('1b4cfbcd4db27b1e205a1ece5104a2b8c5cd02b1','testclient',1,'2017-05-30 09:23:02',NULL),('1b9c57afb8edd0dc703a1d99e96d546fb227efdc','testclient',1,'2017-06-01 12:44:46',NULL),('1f4933acd038cbe0f97240d10dc4c8c2ef3b8fff','testclient',1,'2017-05-30 16:30:17',NULL),('1fdc55d4133e8f51323fe819f9c416e7440a0ba1','testclient',1,'2017-05-30 09:28:26',NULL),('20ddd85fa43e30e33e5a0260a26f036b8dd366c7','testclient',1,'2017-05-31 12:38:56',NULL),('22f42df23768e1dc60ff55a1050c133a982593c2','testclient',1,'2017-05-30 16:36:07',NULL),('23a8f0d01ecb755571a0f2926bd7b8938162f5be','testclient',1,'2017-06-01 12:33:56',NULL),('23ed2c0f70ed0c348124079bfdbd550d3cc88bb6','testclient',1,'2017-06-01 11:37:45',NULL),('2443227faa8b85bef4066e47e24de961df6eb632','testclient',1,'2017-05-30 09:27:15',NULL),('26183f3de3836e5847581738e22f7c7f92f8d2ae','testclient',1,'2017-05-29 14:25:18',NULL),('2643e6bd45e284dc5162de53d385db307cd1f1ac','testclient',1,'2017-06-02 15:11:58',NULL),('267c56ff1569f24df719b00b43f2835f4d7e11cc','testclient',1,'2017-05-31 10:53:33',NULL),('276142c33d5f939b7064a0c3f3f9528e03631736','testclient',1,'2017-06-01 12:36:52',NULL),('28dfec667edf8887081d25181cd511a940fccebf','testclient',1,'2017-05-31 10:35:28',NULL),('29f2df48f748c26110112786d0424be29df81894','testclient',1,'2017-06-01 11:11:31',NULL),('2a01305a801f2cfcc4c54c823cd920e1f89f027e','testclient',1,'2017-05-31 08:36:17',NULL),('2b971a0f400db72d6d60d60d1ce0715f4473c345','testclient',1,'2017-06-01 12:12:22',NULL),('2cbf3aa7a29591db881e9cc9f35c306b913abc19','testclient',1,'2017-05-31 13:31:25',NULL),('2d40b9c89666caf665a2e0c10727071eb1518bb4','testclient',1,'2017-06-02 10:26:45',NULL),('2ddef2062daa208ce3c630a2121cceed5d33a8f9','testclient',1,'2017-06-01 12:33:23',NULL),('30bba14b1462bc87ad8e37c58b055efd56a796a9','testclient',1,'2017-06-02 12:41:34',NULL),('30dccc721065b60448ad5ca8ee100bf5273ef5dc','testclient',1,'2017-06-01 12:45:01',NULL),('30f3725e4cd5b168d3fbaacb9d7d8e9f697ab123','testclient',1,'2017-06-02 08:14:09',NULL),('30fd81ee0f551f5d5623e19ea2881b625e3c348b','testclient',1,'2017-06-01 08:42:53',NULL),('31ac9a14a016ca739a05c621eb4ff5c04c50d7e6','testclient',1,'2017-06-02 11:43:14',NULL),('31dd2ecd402700a0ca437690046f1d2802e58910','testclient',1,'2017-06-01 08:03:06',NULL),('320990a99e821b56375d6c5ccd5d50c8f420831a','testclient',1,'2017-05-30 14:37:00',NULL),('32494295f312d9cde9fe70ef4bdf4c6b7da20ca7','testclient',1,'2017-05-29 12:52:24',NULL),('32b27fac94455ae12ff6b952937684a16db4cc25','testclient',1,'2017-05-29 10:46:39',NULL),('34f5bfda00cdd2c7cbb920ec6165b72894ea30b5','testclient',1,'2017-06-01 12:21:36',NULL),('353ebfa7ada10d6afc09570bd174f842cb43fddc','testclient',1,'2017-06-02 12:34:49',NULL),('3572a7c126b8a629bcf23fd04d4d51126cee2be7','testclient',1,'2017-06-02 12:33:57',NULL),('35e0ad77b2290b78bfbb3d6499798a87b10c0be4','testclient',1,'2017-06-02 08:00:23',NULL),('382bbd4e6b6452f2d57f64ba239fb312cecac1a4','testclient',1,'2017-06-02 15:14:32',NULL),('38962ea8a5a5a0b0d1e6ef9856c8b2d2d9658e8d','testclient',1,'2017-06-01 11:07:43',NULL),('39690f9ea19523085f0742e24e7edd0cba3395a0','testclient',1,'2017-06-02 12:37:06',NULL),('398e8a261bcc8174bffd6729d5e2ccb994241916','testclient',1,'2017-05-30 09:01:19',NULL),('3beb35fb75979dd4338b5b80db398daad6d71cd7','testclient',1,'2017-05-31 12:35:01',NULL),('3c7160cfaf9d8a86ce6e6bed4faab5ad4725761f','testclient',1,'2017-06-01 12:31:27',NULL),('3d8da5f75595abdec31da4784d511f004888f831','testclient',1,'2017-05-31 10:38:17',NULL),('3f3bd4692074bd6cbeac5313db2bf6b2a4ed18b5','testclient',1,'2017-05-29 12:09:09',NULL),('3f555c5497949f4f386d4fcb735ca9f6ac33f876','testclient',1,'2017-05-30 13:06:47',NULL),('4137e80ff9fbcfb4b55490acdac3b1cc5a3510da','testclient',1,'2017-05-27 08:37:04',NULL),('41a2646335f0d9c97e5ced9e83348c44aee2f252','testclient',1,'2017-05-30 13:27:14',NULL),('42c71f7bc0146809f7451ff7a5785988e1dadc6e','testclient',1,'2017-06-02 15:12:07',NULL),('4377627723fff1cefbcae2fd85ada5d48b12bc13','testclient',1,'2017-05-30 15:33:29',NULL),('445445b832e071b571ddf05534b9b9f7b45cce34','testclient',1,'2017-05-31 10:00:03',NULL),('445e5c938fa4d1daf471cef487d81f77fd69afbb','testclient',1,'2017-05-30 09:28:38',NULL),('44a76a9438e2008c68e858d1a4904eb9959885eb','testclient',1,'2017-06-02 15:14:07',NULL),('454bbc2206e41f179df74ed112aaaa715623f609','testclient',1,'2017-06-02 14:12:08',NULL),('4844ab0ebda33c3a08a1b575673042f2c650dd5f','testclient',1,'2017-05-31 10:09:13',NULL),('4b9573e870e8e84d7a3925921dab2d6009571d4d','testclient',1,'2017-06-02 12:31:06',NULL),('4c2b7d9f0af624bb3af1aaa255d71b13a96acb9a','testclient',1,'2017-06-05 11:00:13',NULL),('4c84e12977b1ee35a931abddc3bb5034f5b4d8b7','testclient',1,'2017-06-02 10:46:28',NULL),('4cdb8b3c95ec6f2c18992281590fecd35e159d54','testclient',1,'2017-06-01 08:06:55',NULL),('4d3fed2487ee8df98f88b5db7d940532baf623e2','testclient',1,'2017-05-31 13:23:00',NULL),('4fd570d1e7c631db5153ac09bf2b9a9f93af5f6d','testclient',1,'2017-06-02 08:15:32',NULL),('4fd66d2e0c42be62850f4d92f027cc767fa9b315','testclient',1,'2017-05-31 13:16:40',NULL),('5046dab084824d3d25306af41e852a167edebf87','testclient',1,'2017-06-01 09:24:44',NULL),('50b19057ead9ed80b5a9b0379f4405697fd46e2d','testclient',1,'2017-05-30 16:31:48',NULL),('522384a7325718a03222a31e5d8b809d9f6cb73a','testclient',1,'2017-05-30 13:25:40',NULL),('52392573c847ff3e6ddfd370df935612e1c88d83','testclient',1,'2017-05-30 09:27:27',NULL),('5331dfbd3f6d66c8d369047455a7e8a77df687fa','testclient',1,'2017-06-01 08:32:34',NULL),('54e65b6d2248097c0a94a821158230cb88704688','testclient',1,'2017-06-01 08:02:25',NULL),('55357bfa525f3155ef7c8625eaa072b7eb139b27','testclient',1,'2017-06-02 12:30:38',NULL),('5845d9f7dee5ea48c43e7259cc6c26024eebeff4','testclient',1,'2017-05-31 09:41:01',NULL),('5c8c36cca2e78f2189603dbb721f1006f3faed56','testclient',1,'2017-06-02 14:16:46',NULL),('5cf76f9b3c470ff46233ba60d829a70aebef5572','testclient',1,'2017-05-31 13:32:25',NULL),('5e853826ebb8141af5297eed0f65c28947c549a0','testclient',1,'2017-06-01 13:52:00',NULL),('5f0c77c3970df11897d5e87932eec0ecf55ab024','testclient',1,'2017-05-29 11:54:49',NULL),('6053f3bdcffb55576e1edb55753e62a6b24b1331','testclient',1,'2017-06-01 08:03:06',NULL),('60caa6174aba1f1f5746ab24e707e847ce62c580','testclient',1,'2017-06-02 11:16:20',NULL),('60dc9a3b195ff57c9cf94161f20263ddcc9303c3','testclient',1,'2017-05-31 10:04:23',NULL),('62c9c74ba47cbada1ccf8c9209bcb95b47829047','testclient',1,'2017-05-30 10:20:55',NULL),('639e490721f9d9be3b6a5d305fb8856a9e4dadb3','testclient',1,'2017-05-30 16:27:19',NULL),('63ae16a819e5bbaae0934eb14fb62ae082a034f7','testclient',1,'2017-06-01 13:34:37',NULL),('63d39380c9094ca793ccd8aaa3c86d860666ea1a','testclient',1,'2017-06-02 14:56:27',NULL),('64660e63b8ccadc22ff0caaed6a07ed011272a1b','testclient',1,'2017-05-27 16:06:41',NULL),('652042ef4f072bbf3bc667fda5945f1784044b12','testclient',1,'2017-06-01 08:02:44',NULL),('6540daa609f146b374fa8381dc971b69d6739ff4','testclient',1,'2017-05-30 09:09:59',NULL),('654b53c0bce1e4c1accdf85a040e4168b666a315','testclient',1,'2017-05-30 11:54:29',NULL),('657fba7b0ace63fd38f623213b7a1fcafd0d1809','testclient',1,'2017-06-01 09:26:56',NULL),('65ec46ba3b6643c5af6fe5d922c2941842859d3a','testclient',1,'2017-06-02 11:05:53',NULL),('67980914e8b888fd6e26501d84e5061d149329c3','testclient',1,'2017-05-29 13:04:30',NULL),('68a570ed8709a13f06ec448144f6a69a981e2b21','testclient',1,'2017-06-01 13:52:29',NULL),('68c704ce7b05730dfa896704195286216dbed234','testclient',1,'2017-06-01 13:37:16',NULL),('68f5ffc3fb5f65e6aa76d7b56be90e82e647460f','testclient',1,'2017-06-02 14:15:24',NULL),('693cebdef9a4de2d14a35aa39ba5eb679fe27385','testclient',1,'2017-06-01 12:30:51',NULL),('697bdf598066b59f745ed4667cb1423dc43b5924','testclient',1,'2017-05-31 10:02:45',NULL),('6b0d01ec88c0a669e39ed92a8f7a288d360d0969','testclient',1,'2017-06-01 11:18:27',NULL),('6b486c60388e18db033783560bf0e5469050c7fd','testclient',1,'2017-05-30 14:33:58',NULL),('6b5ca9914f11715ecb3a0fbe1e89984a155f9031','testclient',1,'2017-05-31 11:05:55',NULL),('6bc443f2a9b0fd5c886b55b1dfee91e3603d991a','testclient',1,'2017-05-30 16:36:49',NULL),('6c740eaefa50020f6ca6d1591dea3bdc9c780b40','testclient',1,'2017-05-27 08:37:04',NULL),('6cd4b91a048130c28ae43c0216eeafbdd2dc1b12','testclient',1,'2017-06-02 13:25:37',NULL),('6e3f9f37b4622f12d8c999167b8ee20309a99d0b','testclient',1,'2017-06-01 10:14:10',NULL),('6e557f683633a0ea491a95ee403ac7bd672536af','testclient',1,'2017-06-01 11:37:45',NULL),('6eab3f46ea982b496eb02d7cb911b0f325b55f80','testclient',1,'2017-06-01 08:00:10',NULL),('6ef7c3808d85495cc27168718851388b4226b1d3','testclient',1,'2017-05-30 16:02:04',NULL),('7057ccbe06be8dd460e7534d295a136a1b16e200','testclient',1,'2017-05-30 16:25:06',NULL),('70e06788e9e8e6089fd6caea69f706fccc98f232','testclient',1,'2017-06-01 08:06:37',NULL),('72111f70d742ec4370eeaf8771d3800c495ed95a','testclient',1,'2017-05-30 09:27:58',NULL),('72d84fc8515448790aadace0bb4ee66d6a88b94d','testclient',1,'2017-06-02 07:48:09',NULL),('7465c498d7e723f383cd9c75e14cbe4302cb2a3d','testclient',1,'2017-05-31 12:34:46',NULL),('74837ffde5bdf8aec9e2af86eb53170b97cf78ca','testclient',1,'2017-05-30 14:26:25',NULL),('74c6e7759e2a6c176e2ac9af8a7dc5e23d76e03f','testclient',1,'2017-06-02 12:48:23',NULL),('76efe32ea8c9c920eac6e65c60011ca83643d5c8','testclient',1,'2017-06-01 14:37:03',NULL),('789952ca571dee505347a1a10ec966d252b49ed7','testclient',1,'2017-05-29 13:02:42',NULL),('79e0480c1bc9b079c24914568de38826cec01d58','testclient',1,'2017-06-01 09:24:05',NULL),('7be43a528353ce3d92ccc3372286e5d9fbed9b28','testclient',1,'2017-06-01 12:32:14',NULL),('7cb1169e8c7ee62a5ce3f06de9e561a1684d5402','testclient',1,'2017-05-29 13:05:05',NULL),('7d6def8615f9a2216a5e7229d1176ca1809aa062','testclient',1,'2017-05-31 13:22:38',NULL),('7e17524b26374f89b68309cfb2fffeb252ffd279','testclient',1,'2017-06-01 08:31:21',NULL),('7ea855345debfa5777a76fd7fd43eb91b5274ed9','testclient',1,'2017-05-31 10:12:52',NULL),('7f194d3d0e01c12e8810ec6cbbbef162c0f09081','testclient',1,'2017-06-01 13:38:10',NULL),('7fa9f00373b0b4ac5d0205d4fceae9457d1376f6','testclient',1,'2017-06-02 09:46:52',NULL),('810a0e0d94127278e0de72ac138af8f5f69218e4','testclient',1,'2017-05-29 11:59:31',NULL),('819974bb26b9031ac65e0a7222c30dd489e412c2','testclient',1,'2017-06-01 13:46:16',NULL),('821e687b46d68d638fb113a608d728a708e76b08','testclient',1,'2017-05-31 13:35:22',NULL),('827f79e962e797cc2841669b6fa4423afa104501','testclient',1,'2017-06-02 11:21:00',NULL),('84904bfcc41ae0f815ad07a6b00ef53ce5102a07','testclient',1,'2017-06-06 10:05:45',NULL),('84d4af45334248dc487ea7935540420277a9855d','testclient',1,'2017-05-30 16:32:46',NULL),('87622de75435bff973432f4d0814288a49cfaadb','testclient',1,'2017-06-01 08:40:45',NULL),('8762832bf6eb975b0d615949f924be59d3d98736','testclient',1,'2017-05-30 16:29:30',NULL),('8819b7aba3224ebe0f87935c2884cf144b946b42','testclient',1,'2017-05-29 10:44:49',NULL),('8a8c49c57f7918942aaeabc34d7fb05b84192f59','testclient',1,'2017-06-01 14:29:50',NULL),('8aea8f024d6346a99df6a200cf0fb4132bc3179b','testclient',1,'2017-05-31 13:31:41',NULL),('8c4bf226c9cee724d7724e3062078aabcae352b2','testclient',1,'2017-06-02 15:00:22',NULL),('8e555f0734df089766e97d1794f8307e70cf9975','testclient',1,'2017-06-01 08:03:37',NULL),('8e5feb4d9f4771a826e26fa5157fbcf14f591a56','testclient',1,'2017-05-31 13:29:23',NULL),('8e8fa1e7b56f02caee8ae37a4c611f5a7b287256','testclient',1,'2017-06-02 14:54:56',NULL),('901788dd8b1573ea60db9e2f678fe410623e2c15','testclient',1,'2017-05-30 14:33:58',NULL),('90ff0e1428a7d73d9808fa1e2fa1b92b0a66b911','testclient',1,'2017-06-02 08:15:06',NULL),('91f38861ae1ce43d295964d276145c54c429fdb1','testclient',1,'2017-05-27 08:39:19',NULL),('927e1ed2a978dec5c46d8aebee9fff601f186430','testclient',1,'2017-05-29 14:24:35',NULL),('959e560914928dd036ecb9b957d545f5157e2077','testclient',1,'2017-06-02 08:24:16',NULL),('95f5797aede45c3d4d99a6b75154d0055c10a0a0','testclient',1,'2017-06-01 13:52:19',NULL),('9679a831e3710ebd42472289d14b1fb7768ce1d4','testclient',1,'2017-06-02 13:25:08',NULL),('96de567dd5d8e85d48a67c7131c2d783a4ff1ba1','testclient',1,'2017-06-02 15:06:27',NULL),('9752cef5b79daded3a19961f640efea001b28cc2','testclient',1,'2017-06-02 14:53:30',NULL),('993a924b27dc2637d6ad3240d7fc645e95c08bf8','testclient',1,'2017-06-01 12:14:58',NULL),('99a5df3b20a9610c3159a1ed589aa69138d2ee66','testclient',1,'2017-05-29 14:27:10',NULL),('9a536e51dccc440fa262ab655b35cfc575647575','testclient',1,'2017-06-01 10:19:46',NULL),('9d0a1745fa72c2007435d666d1aa956b4283fc34','testclient',1,'2017-06-01 09:20:38',NULL),('9d4bd9a4e87b987336f906d9236726f17dd11588','testclient',1,'2017-06-01 13:31:17',NULL),('9fef1d9653567cebdf7088ed3c69ca7143a414cb','testclient',1,'2017-05-30 16:21:33',NULL),('a1c4d9512129372c20cd9380fd16bc392d2c6009','testclient',1,'2017-05-27 08:52:38',NULL),('a1e23be7b3a415f63bdfb2e23f82abc2197cba5f','testclient',1,'2017-06-01 11:09:41',NULL),('a2edccea43f79d7cd5556888247607a50b981575','testclient',1,'2017-05-30 09:09:51',NULL),('a307c1f38e22ada65d4bf7571c6a33f546dbdc95','testclient',1,'2017-05-30 14:34:49',NULL),('a3ae72fb380cdc6c5407116d2c88f729d36412f2','testclient',1,'2017-05-30 09:09:55',NULL),('a4fa15b403ae8010d4cfbf07ae0897a24e91b27b','testclient',1,'2017-06-01 14:15:59',NULL),('a52adfb1b425ce2be889a2e9a7a6f44c4cb84bcd','testclient',1,'2017-05-31 08:44:20',NULL),('a53f5e76e694116c050f37b8418eff2281192fb8','testclient',1,'2017-06-02 11:18:39',NULL),('a5dac5592f6f952b0041786c14ae8ccc9967dcd2','testclient',1,'2017-06-02 12:38:20',NULL),('a5e61666e40bd734e16ea1ea2941e86cdc96a538','testclient',1,'2017-06-01 13:29:05',NULL),('a6d72d842022f9e702a35d4b7157d4ca69dbea9f','testclient',1,'2017-06-01 08:12:45',NULL),('a71db0d5b01d914a52bd6cb041aff7fb088cfd0e','testclient',1,'2017-06-01 12:40:40',NULL),('a759ad9b6eee433f2a5d68cd746a2ce78d064b05','testclient',1,'2017-05-30 12:51:28',NULL),('a78be3b11310db68187070e89d98029a590d9608','testclient',1,'2017-05-31 12:37:53',NULL),('a79269f70b8d1b51f7b55166e445a58113cb8496','testclient',1,'2017-05-30 10:29:54',NULL),('a95798830c3ab49a034503709c473130ec0c3032','testclient',1,'2017-05-29 12:21:58',NULL),('aac0b1c0c990a6bff550ddc8a7dc27d691ffa2eb','testclient',1,'2017-05-27 16:09:15',NULL),('ab1d022e4333e93ab68b8ad42310c5cc43aa4415','testclient',1,'2017-06-02 08:13:35',NULL),('ab400ef4209ff4abfa9b3c23f160e92f51060e00','testclient',1,'2017-05-29 11:56:35',NULL),('adc323d9170b1c1c73e41e3075a98beaca39bddd','testclient',1,'2017-05-30 16:39:27',NULL),('ae65098961ea5aab89bdbb4eb3cdb9afca899164','testclient',1,'2017-06-01 08:03:18',NULL),('af277ecd4bc80249128b8818e4b567fabceae53a','testclient',1,'2017-06-01 09:23:07',NULL),('af608e07ee0a0bc9cadc75c6f43c297ce8a99eca','testclient',1,'2017-05-30 14:40:04',NULL),('af986c85b3fe9e22663f1af7a4f070f01b248a27','testclient',1,'2017-06-02 15:04:07',NULL),('affa8bb1c6373ec33e6b5dd7bbae45a1bdd81447','testclient',1,'2017-05-30 08:31:07',NULL),('b0114e250aa9f60e9772e23f3cfb83893e48b02f','testclient',1,'2017-05-30 10:30:04',NULL),('b028a2da61e194d12fcaf8777b94807278858fa1','testclient',1,'2017-06-01 11:10:50',NULL),('b2ee31ffe2dcc27618e633375ba2a64a1c607208','testclient',1,'2017-05-30 14:38:51',NULL),('b4357ee8025d4f9a7d4fec70762ca9c70644bd5d','testclient',1,'2017-06-01 09:27:43',NULL),('b43ad5a7f5e829b59ac625cb278dff3f5b2e5af5','testclient',1,'2017-06-01 13:45:20',NULL),('b47f3134d266955bca11359e92368a42705fb581','testclient',1,'2017-05-31 08:43:04',NULL),('b4e4ff47525e0789316d59a0717515ea2fdec7ff','testclient',1,'2017-06-01 13:52:00',NULL),('b53ca5db4e3ed726182d60cef90994826ed6b3aa','testclient',1,'2017-06-01 13:23:20',NULL),('b78219e0f607e00c6512d1dad711ddb1dbcc933c','testclient',1,'2017-05-31 13:34:25',NULL),('b7958a58f757366fc036f5a2887bdb8c368efe09','testclient',1,'2017-06-06 10:29:53',NULL),('b87569c991e4669fff7518da50909a7dfe9ccc07','testclient',1,'2017-06-02 11:35:36',NULL),('b99170e8b5dd5b406561edcf49c35a18d2c309b2','testclient',1,'2017-06-01 08:41:57',NULL),('b9a097aae24a2d2425bd7dc45478fd7814efaa91','testclient',1,'2017-06-01 09:18:03',NULL),('bbab8118c3146c29ca9bfe6b9358c6aee4bf821d','testclient',1,'2017-05-31 08:50:36',NULL),('bbca341effcbde5d0e65ee0630daee813ece1dd1','testclient',1,'2017-06-02 08:14:33',NULL),('bbda35833fee43f173a0bb1daec2093cb8e3ac1d','testclient',1,'2017-06-01 13:46:16',NULL),('bbf12dd3b1b0e7bb5402237e7749c8a15c49d7ca','testclient',1,'2017-05-29 14:28:01',NULL),('bc27748a19e0410b3ded911f16525cea1ddfb721','testclient',1,'2017-05-30 13:40:44',NULL),('bd3aedb549ac0a3201f30ac635d25281e5e650e4','testclient',1,'2017-06-02 14:57:01',NULL),('be6224c91fe446531a0b1b9386b9605e09f35206','testclient',1,'2017-06-02 13:05:54',NULL),('bf74aa8a14ce97465935a2e07a6867d2b50ba76e','testclient',1,'2017-05-31 10:59:55',NULL),('bf7ccca9eea0308254549b1b519eca45cfd75ed5','testclient',1,'2017-06-05 10:37:56',NULL),('c17e4a4ab915cf2b649e2d7583a046277e3c8110','testclient',1,'2017-06-01 11:11:44',NULL),('c1dff344432386238b9a59e1ea4fd6a0eff6221e','testclient',1,'2017-06-02 11:10:11',NULL),('c208ada5a9f41044ff53123ba76beff082ab5185','testclient',1,'2017-06-01 10:41:56',NULL),('c237f1f20d9b6c3dd1a0729d8d13f3db0fb414e8','testclient',1,'2017-06-01 14:34:55',NULL),('c3fa195efba6be793a38f472c5d4376a2912f896','testclient',1,'2017-05-30 12:24:55',NULL),('c48d25377de32b4e6105136bb62f13e05f11d1db','testclient',1,'2017-05-31 13:37:06',NULL),('c51d799ac5a722a3b32c8fdc01dc26d35ddb1c43','testclient',1,'2017-05-30 14:28:25',NULL),('c55338b5bf844dd128f371546d41fbadc4819428','testclient',1,'2017-06-02 15:04:57',NULL),('c56f599c4b6b2df1db8f5a25058c8a449adc82e0','testclient',1,'2017-06-02 11:41:44',NULL),('c680eedfbb74d7871883406df827e43e42ced933','testclient',1,'2017-05-31 13:27:45',NULL),('c6fc9a36825cf8fd83dc485a6c008b13789dec50','testclient',1,'2017-05-29 12:52:53',NULL),('c78c1fe61bfb6fbbbf197f57f65dad7951a24122','testclient',1,'2017-06-02 13:52:12',NULL),('c8014eed0a167c638ffc105ebcae8a9c6d279e76','testclient',1,'2017-06-02 15:05:29',NULL),('c85be0a82ca75d9b62e69c9cb1ee5c0c04a771f6','testclient',1,'2017-05-29 12:17:09',NULL),('c971e57cdc0c62aac4660837746b16c48bc7a49d','testclient',1,'2017-06-01 14:43:30',NULL),('ca931ed879a518a477711b9c28a99839f476437c','testclient',1,'2017-05-29 13:03:46',NULL),('ca9ff7e2dcf9788402135e5af9200bd41488fbef','testclient',1,'2017-06-01 14:42:36',NULL),('cb2690ecb7a2390788e5b211ee025cb1e34a0ef2','testclient',1,'2017-05-30 10:21:54',NULL),('cb89f3c67d72605adc556eb44b5e959f5ee65dff','testclient',1,'2017-06-01 09:19:58',NULL),('cc70fe2b324480d2a0f5be504928dd6958243743','testclient',1,'2017-05-31 10:34:02',NULL),('cd2e7213900b3cf5404e7e357052ed02ab9e1d3a','testclient',1,'2017-05-29 14:26:45',NULL),('cd898ca33f4f4c73236f9e353016dd1328e451bb','testclient',1,'2017-05-29 13:03:13',NULL),('ce1bb86e29d472d5d9fbb01c06d4279622637939','testclient',1,'2017-06-02 07:59:39',NULL),('cec7bc627a5603b92cb4c3d2b03b6ee149af5b58','testclient',1,'2017-05-31 10:12:52',NULL),('cfeef702d76651b8a6b820c24705b6452b1f75c9','testclient',1,'2017-06-06 08:50:29',NULL),('d04e6cb6bd42f843d548d63fb0e96bae0173a348','testclient',1,'2017-06-01 13:35:42',NULL),('d0ccf48dada9d29d74d142a5335e70000fd936aa','testclient',1,'2017-06-02 14:52:03',NULL),('d1ba66e41ee256badc5756434784aedb6d2afadc','testclient',1,'2017-06-01 12:25:08',NULL),('d1d53ef84f77177f3e026d6d7aa7f6974091afed','testclient',1,'2017-06-02 15:04:07',NULL),('d1e395fd25e629adf3d6401675b3a75235fc147f','testclient',1,'2017-05-30 09:28:04',NULL),('d39245a6eff081cb0940b8fd70f5e2e9df87d255','testclient',1,'2017-06-02 12:36:27',NULL),('d412df052bce6d319cadee7c4c1dc2092dba7ada','testclient',1,'2017-06-02 08:05:07',NULL),('d492687e76e083139d74ae508bf1f61a78cdbb4a','testclient',1,'2017-06-02 13:54:52',NULL),('d4bfd79197aab6d99d62ff12e9286a501e208093','testclient',1,'2017-06-01 10:08:52',NULL),('d4df7266f3fa190ac7a20ff47061fe1c6c3abebd','testclient',1,'2017-06-01 13:49:55',NULL),('d68527dc23b782be7be5f2b8c89a1d9fe888a680','testclient',1,'2017-06-01 13:24:27',NULL),('d9539406825455d04004b8799b18da7092ec9836','testclient',1,'2017-06-01 10:10:46',NULL),('d9682c9a7988f059b7c3aa107dece6225af31b10','testclient',1,'2017-06-02 13:26:32',NULL),('d9d0a1c37fb4c9101fbaf9d20fdb3a6b028e4c03','testclient',1,'2017-06-02 11:34:08',NULL),('d9ea64add7b9ccc7d70df8edcac625d807a42507','testclient',1,'2017-05-31 13:38:25',NULL),('ddc2e49dcd983add1ba441c14c7646f5c1ad7326','testclient',1,'2017-06-01 08:01:13',NULL),('ddecd813b63b2b2db1bdcd2066e6b0b8cb9ae1ab','testclient',1,'2017-05-27 16:01:39',NULL),('dfc3f7538ea0a8e8e0f93a0134543f8d6f5efe11','testclient',1,'2017-06-05 09:11:13',NULL),('dfec8162f1c2de753aef67db78459a1fcca933ee','testclient',1,'2017-06-02 12:36:27',NULL),('e060262f05fe3e800bd2dac84acbf3e1c42e29b1','testclient',1,'2017-05-30 12:52:20',NULL),('e09c7fbcee1a7e1384cdd488d01d46ef451418c1','testclient',1,'2017-06-01 12:43:38',NULL),('e1d60f7f6e504168cf6a9d3bd3541bb3725490bf','testclient',1,'2017-05-30 16:23:56',NULL),('e4023ebdec689516c19d9c20f9f3d1e28c64de69','testclient',1,'2017-06-01 13:47:11',NULL),('e58e0a17ec0f8527f4aba27d7cd31d23516ba4d4','testclient',1,'2017-05-31 10:05:20',NULL),('e67914d848fcb1e6adc770eaa7745dd4a8dc4602','testclient',1,'2017-06-01 11:58:48',NULL),('e6d3edd328897eb6a49dd9e76bb9efbb1d14848e','testclient',1,'2017-05-30 12:57:25',NULL),('e6e3cd50374da3ebb113c8a31b27199561c8093e','testclient',1,'2017-05-30 09:28:20',NULL),('e7014662430f4d5dc88ee2a50e1fbc1efa4c5c93','testclient',1,'2017-06-06 10:27:00',NULL),('e756b7f68ee6480b3f41c9ecf3940cbb78352650','testclient',1,'2017-05-27 16:06:38',NULL),('e929b0194b62c63aae714d0b2efc2eec1fa78c05','testclient',1,'2017-06-02 13:48:36',NULL),('eb6bc8b6800d7756cd7ef1dcac2d62949d21b1d1','testclient',1,'2017-06-02 12:37:06',NULL),('ec91b8ca801aad4d1f64fc62bfe3600ac1573427','testclient',1,'2017-06-06 09:07:08',NULL),('ec934b266cf64c0b442fb7d4a096c5a67ec326ab','testclient',1,'2017-05-31 13:17:23',NULL),('ec9dff7e0296ac027537fd9e3f54e35e19cf3fc4','testclient',1,'2017-05-30 13:37:57',NULL),('eca6b2a000a5f1a748c931728495e8f936267d61','testclient',1,'2017-06-02 14:53:38',NULL),('ece732f995a8ddff3d4f887f6b79f9a5134a95c4','testclient',1,'2017-05-31 12:35:18',NULL),('ed31b93f7845576b0b1f95730e3b2747c6ea6033','testclient',1,'2017-05-31 10:58:04',NULL),('eda48807ca628a1476a931bfbc2f1a4a3b8c3a7c','testclient',1,'2017-06-02 10:08:05',NULL),('edce47ea2610a532efaf6b946713fe74b9960e34','testclient',1,'2017-05-27 09:17:11',NULL),('ef4e740551c8038cd307432a44c2b09881436fe5','testclient',1,'2017-05-31 11:03:16',NULL),('efb63d9573b97829a4d954f7cf6cd6eaa7ff5216','testclient',1,'2017-06-02 15:09:12',NULL),('f19a2c233aa06d73761d09d1a474f0fc88184de7','testclient',1,'2017-05-27 08:37:06',NULL),('f28715381809bd26d32ecc3772ef6d763b458a9a','testclient',1,'2017-06-02 10:33:40',NULL),('f35bc5f4ad9cd9303538c63204ba42f9b730f3c0','testclient',1,'2017-05-30 10:30:27',NULL),('f4731babdf921f6faf650049406c270eb423263c','testclient',1,'2017-06-01 11:10:44',NULL),('f4b053f7442f7265e5f197523a7e6b9507057afb','testclient',1,'2017-05-29 13:05:36',NULL),('f5ff7777db9aac698fed7f97d55f9ba014000821','testclient',1,'2017-05-31 13:25:49',NULL),('f6d16faf99660f490c32c604b214371658e6dfdc','testclient',1,'2017-05-30 12:24:55',NULL),('f6e0c2ca444fceb91a7fa69235ae121430645b6b','testclient',1,'2017-05-31 11:07:15',NULL),('f6e70791487c905dd6707fb8d8a127778b71e366','testclient',1,'2017-05-30 13:35:28',NULL),('f7af18bdf872a3ca61b6bf4b1412bab623c3aacd','testclient',1,'2017-06-02 12:40:01',NULL),('f7dcfacf319adfcf8c2f102b3fb20308056c0d2e','testclient',1,'2017-06-02 13:03:30',NULL),('f7e8ee03276f51837531433a8ccfadfaf8780279','testclient',1,'2017-05-31 08:41:45',NULL),('f821f2d3f2aa8a58011abe38f22a91701a42427f','testclient',1,'2017-06-02 07:48:09',NULL),('fa3a964a631c7c08bac392f5c11ae30f7c1c57b6','testclient',1,'2017-05-30 13:46:15',NULL),('fa5ce747ba7638d93cda7368b164093525d57785','testclient',1,'2017-06-01 08:06:37',NULL),('fac0e5fdbb2dae15720172ec751894b15c5f73a8','testclient',1,'2017-06-02 14:00:32',NULL),('fad95d887ec481e377f16c50e03ff2da1652a697','testclient',1,'2017-05-27 08:33:57',NULL),('fbc9bce5952a1d763d6eb9b949054d32ea7beb16','testclient',1,'2017-05-31 10:08:09',NULL),('fc6c91c292e69a931becee87c2d605217a50ff1c','testclient',1,'2017-06-01 13:48:52',NULL),('fd362410637d52fcb607af4f78e6acc5e1e9e8c7','testclient',1,'2017-06-01 13:45:20',NULL),('feb052745e08e62b9d08e141aff24e7d9aa78a7f','testclient',1,'2017-05-30 09:26:33',NULL),('ff3fcc29a8339b5cecfa32f1985f41bb9fe0eb70','testclient',1,'2017-06-02 12:31:06',NULL);
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_authorization_codes`
--

DROP TABLE IF EXISTS `oauth_authorization_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `redirect_uri` varchar(1000) NOT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`authorization_code`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `oauth_authorization_codes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_authorization_codes`
--

LOCK TABLES `oauth_authorization_codes` WRITE;
/*!40000 ALTER TABLE `oauth_authorization_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_authorization_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `client_id` varchar(32) NOT NULL,
  `client_secret` varchar(32) DEFAULT NULL,
  `redirect_uri` varchar(1000) NOT NULL,
  `grant_types` varchar(100) NOT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES ('testclient','testpass','http://fake/','client_credentials authorization_code password implicit',NULL,1);
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_jwt`
--

DROP TABLE IF EXISTS `oauth_jwt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_jwt` (
  `client_id` varchar(32) NOT NULL,
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_jwt`
--

LOCK TABLES `oauth_jwt` WRITE;
/*!40000 ALTER TABLE `oauth_jwt` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_jwt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_public_keys`
--

DROP TABLE IF EXISTS `oauth_public_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_public_keys` (
  `client_id` varchar(255) NOT NULL,
  `public_key` varchar(2000) DEFAULT NULL,
  `private_key` varchar(2000) DEFAULT NULL,
  `encryption_algorithm` varchar(100) DEFAULT 'RS256'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_public_keys`
--

LOCK TABLES `oauth_public_keys` WRITE;
/*!40000 ALTER TABLE `oauth_public_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_public_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`refresh_token`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `oauth_refresh_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_scopes`
--

DROP TABLE IF EXISTS `oauth_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_scopes` (
  `scope` varchar(2000) NOT NULL,
  `is_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_scopes`
--

LOCK TABLES `oauth_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_users`
--

DROP TABLE IF EXISTS `oauth_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(2000) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_users`
--

LOCK TABLES `oauth_users` WRITE;
/*!40000 ALTER TABLE `oauth_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_users` ENABLE KEYS */;
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
  `type_id` int(11) NOT NULL DEFAULT '0',
  `rate` varchar(8) NOT NULL DEFAULT '',
  `amount` varchar(32) NOT NULL DEFAULT '',
  `return_amount` varchar(32) NOT NULL DEFAULT '',
  `info` varchar(1024) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `created` bigint(16) NOT NULL DEFAULT '0',
  `expired` bigint(16) NOT NULL DEFAULT '0',
  `device` varchar(255) NOT NULL,
  `payout_prepared` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_parking_user_id` (`user_id`),
  CONSTRAINT `FK_parking_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=267 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parking`
--

LOCK TABLES `parking` WRITE;
/*!40000 ALTER TABLE `parking` DISABLE KEYS */;
INSERT INTO `parking` VALUES (260,1,1,'18','3','0.00147945','',2,1496749971,1496750031,'web',1),(261,1,1,'18','3','0.00147945','',2,1496750182,1496750242,'web',1),(262,1,1,'18','3','0.00147945','',2,1496750186,1496750246,'web',1),(263,1,1,'18','3','0.00147945','',2,1496750190,1496750250,'web',1),(264,1,1,'18','3','0.00147945','',2,1496750194,1496750254,'web',1),(265,1,1,'18','3','0.00147945','',2,1496750198,1496750258,'web',1),(266,1,1,'18','3','0.00147945','',2,1496750888,1496750948,'web',1);
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
INSERT INTO `parking_type` VALUES (1,'18','Daily',1,0),(2,'23','Weekly',1,0),(3,'35','Monthly',1,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payout`
--

LOCK TABLES `payout` WRITE;
/*!40000 ALTER TABLE `payout` DISABLE KEYS */;
INSERT INTO `payout` VALUES (21,260,'eedf68e76fc2fe06123c973bf939e27f536c03c886a3ed842f3d25ab6b6d2661',1,'0',1496750031),(22,261,'8b4bd0e2670545891d2aefd1778e4589c568e292fd00c4962d0aecf277289ce4',1,'0',1496750243),(23,262,'59886c61f1ee469ab40b9959b2e0377aff65f2d8a6dd59a6681e91f20e176295',1,'0',1496750246),(24,263,'322002f0eb8e8b34154f3c3a1f061ebe7e0030bfb9a9fd332d55a72dcd0e2b32',1,'0',1496750250),(25,264,'b6a1b79a392b37a67a8d111296ed2b96acac6ced644afeb6e103dc812934a56a',1,'0',1496750255),(26,265,'4cc86a374a42ff0ee99b251fd5c941ab50649d2e2da7eb294709626590839d9f',1,'0',1496750258),(27,266,'5422a6f04924cb0a1e226bddce0c1a4c0260eadef25103029bfaab17f55dea14',1,'0',1496751745);
/*!40000 ALTER TABLE `payout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payout_transaction`
--

DROP TABLE IF EXISTS `payout_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payout_transaction` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parking_id` bigint(20) NOT NULL DEFAULT '0',
  `txid` varchar(255) NOT NULL,
  `created` bigint(16) NOT NULL DEFAULT '0',
  `spended` bigint(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `txid` (`txid`)
) ENGINE=InnoDB AUTO_INCREMENT=673 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payout_transaction`
--

LOCK TABLES `payout_transaction` WRITE;
/*!40000 ALTER TABLE `payout_transaction` DISABLE KEYS */;
INSERT INTO `payout_transaction` VALUES (1,132,'7a632e9d435efcb5587f36877e1f82e2ebc038b3fba090f4ebe70f41a14c2b5d',1496480656,0),(2,135,'75eeebd1fbe44b944845d48decce9e690e161798c93176387dc19a0032939a30',1496483156,0),(3,144,'b1a630757c687d01fab02c1302e136007552de0cf27e7b3d7888c574d01f43bc',1496483362,0),(4,145,'574ea9962116fe9ff685c6d61c5a1e3fd78c2edc599ec141fc102b1b798d01cd',1496483363,0),(5,146,'e8d4ae88c074c98e2d8b7c8be671b38bf5903e42668b13e352812bd976e3b12f',1496483364,0),(6,147,'ed37695f6403e2863f5f51ff6321716a97416e60307015214bc8eaace467675a',1496483367,0),(7,148,'6a992e064af2de436511e1cac2324b6d8de2aa450ba0752287c5183b9b36659d',1496483367,0),(8,149,'9958cca291cbf098a9185428eb001a2da2de7c35cdcab6e735c0bc9d9c5f3dec',1496483368,0),(9,150,'2a2eedb29d8f60f4f0fefb9168f6004fd82b2426aa164a8a31ba9b620ceb033b',1496483368,0),(10,151,'ae7c4f0cb77b536dd4079b1b175a6f9282d4de5e23a4a08c21c5d07d1014b073',1496483369,0),(11,152,'b784a3b8f3e20078426ff2233c9b5a45884f9f2be8e494bdfa572d709a1f0f4f',1496483369,0),(12,155,'c8904f55292640d538390f5e5d4d5b915124823e161d9fa4d8095be0cbda6e85',1496483370,0),(13,156,'fac12361748f24fc1e5e3ca2c7fcafad9d152222c488748728a5d87d00210ac1',1496483370,0),(14,157,'81698749ba7da6b429651f05616400c31b8960d9f4c309c1c960d3bafff4085e',1496483371,0),(15,174,'4a0b668827093d5d50cc4f143224cad5908d1eee8bed465de9047ededbfd8298',1496483439,0),(16,175,'0fbbba7d7f1ecb7b7a25f417576b88ff3e0e82594622b1c700735bc4f5042266',1496483439,0),(17,158,'dc45b9743e9e5639d3103683cb2895a72388ecee02f393d9da9260affa0253e7',1496483440,0),(18,159,'b71efac37c1fb0e1907ee3c98769fa38d2e2f83e9dd67187de222f6c5b5ab708',1496483441,0),(19,160,'ae9e53c65a85e2726f9325c40ba9da62f54763e9b4ae452d80b42dd711fe7f91',1496483441,0),(20,161,'fbd6e0ad7ac272f96f8ad66d38deadd4c764be4ac84d8ee50f1d93de6b96fbba',1496483442,0),(21,179,'c95572ac27386a9a24659a9bd0bb0169fae90226e5d0299c195516902aea5491',1496483443,0),(22,180,'fea953bc29eff7bcbbdbddf3c7d862de972e6b34383e27e1fa4e5e12a61e8e01',1496483443,0),(23,181,'f51667d977efbe7f0a003d4d2af3d89153e92013a0e1c42d321b7f0d7ef5a5fc',1496483444,0),(24,182,'bbb35669aab13819bc619130593b738f6728db069bf1326f55a071e979050fe2',1496483444,0),(25,183,'edcbe15cd1d75457ac507ab09250408c3f5642e786bccfe9eee8f8fc4fd8a5f0',1496483445,0),(26,184,'0e168856c12bc08237c8ade0fd1378fb78e2cad678791a8f86fb64ced42bdd9e',1496483453,0),(27,185,'e04a963d5918fbde01d2d060e91bbb02f79dfbcb7288839e83689a94e9cef3ce',1496483453,0),(28,186,'f2319c52dde615f36635cf9b36d9f916ab664962b5f4954f9f4c2a9b2c9d8105',1496483454,0),(29,187,'d5f9b50445ec6cd36c00f8aea32950b4a56444143b3659effe8097259b2b4ca7',1496483455,0),(30,188,'84c471a6a12418aa65b10ca864bcffb06c820a0ad5ff40458fa0a34dc85d9208',1496483455,0),(31,189,'bc5271b1afa5456c092d69d763152799ddbedca7f983997779a549856c0a9352',1496483456,0),(32,190,'5bcafc41d13e75ce41561ab74feae7d4686716a1a2188572d95f04376aa945a3',1496483457,0),(33,191,'9f6f217c84de8696bb30178d59da2bee76eb520aa5e4c18dadddee77ad01e8e6',1496483458,0),(46,193,'25b0c7792de03ebfc48aaf0674dcd736871c00a8fa718e4f4f892d1e84758cd5',1496484158,0),(47,194,'fc4a3928842104fd695966bb8265cf6fa970d246d9ee8aa5af01c0640c4a59ea',1496486072,0),(48,195,'24f60a5b15f5d151f0deb76b6a499a7221b4291174e5984a62adddf8b5785fd4',1496486080,0),(49,196,'4b245e7dc8b5231e262fa09723b2bdca16e471895893fa12adc60fda3b12aa1f',1496486081,0),(50,197,'ccdad5df8c7314484d7f55bfba32aa54969dd300d7a12fc1d78734a932a48ea0',1496486083,0),(51,198,'873183bd0aabacaaeaee40982d4bb7c1e587a42e2b268120be24056b680942af',1496486084,0),(52,199,'0ca5ce13618b0c7991d61755c1f672ab2a86eccf7190a8122788f36eab46733d',1496486085,0),(53,200,'72848ff5b987e3fa3013df56cb7b40e5a8f76ead98993be3d517259747e189e9',1496486091,0),(54,201,'1811cbdfb52011a0f9f5efc3396f39a189d5d77cad10db7c6eee6f16722e5eda',1496486146,0),(55,202,'f31d477805df260ff0db873c4f9bf1823f2afad728dbb783e7c23f8e0bb9abd2',1496486150,0),(56,203,'13dbdbb018d7c13e78c1cce3fcb20ff8a6ffa854a60ef1e1e5362aa30c152e85',1496486161,0),(57,204,'6a093b70c48d3352ccc8e27d0b70444b1e7a50befe8aa7b48f88bc516a87be60',1496486178,0),(58,205,'bfeb58e18c9a6b571c62e90f2d0916a6a5515988d7bc157d512cc6441dbb9b6f',1496486701,0),(59,206,'50981128ef8823654138932beb903fc6c6b532894bc75218e1e8777301cebd6d',1496487131,0),(60,208,'29deff448c61130e67a1be93a8ab6e4715bce4635eb7d0421f2d9ffc052c79a0',1496487756,0),(61,211,'b99b7628b19e66c1256f0e98cec1790f0c29052e019cf95c1f207467bce4235e',1496491320,0),(62,212,'9b5644193d2e24069ca38bff2beadb26973cd5bfa5b85c01001cbf056b92aa9c',1496491321,0),(63,213,'1f82e44a25b27f7aabb2c929b89ebd63402ce02a926c76a407dbfdcb47711cb4',1496491324,0),(64,214,'82d68f86c422448473d2e64ea78e15edd38decc1611fa8105616aa13590a7b7e',1496491326,0),(65,215,'0417f705c504119209bd4ad12c5f9c43519330ccd658e0cb6a3f02cc4613da43',1496491328,0),(66,216,'6342874374ea09f6e8733b288833064475608c4766c4decd77493f921cc66bbe',1496491330,0),(67,217,'50bf4fae6e6a7f22f9bf9fdd0adc2bc385ee5e0cefb0f7e7b4d92373a2205e85',1496491332,0),(68,218,'429e06bac24d190902b405d32ffd2004b117a3bc771f54d54c233e8d31c6771c',1496656265,0),(627,219,'4968ab9ef3210d8f6cae5345037e9cb6e4d8df1acd70f9a3bbe7bcd47244f72a',1496656859,0),(628,220,'108b42ebdc838205a3c309172cd7ced01bcd8f988d05c298e103cd46ab8219a8',1496657968,0),(629,221,'806de3207cd00af2e4265d48698cf6cca22c0f211da43bb2cd480ac494666206',1496658306,0),(630,227,'5dace0a7e6a0a4d68402e404a1984a43214e0b93f7c6a3257693aa262a5f248a',1496658756,0),(631,229,'00387970ddee043e6e91fcbee887d6b53a30f5ca9ce64303907cdd5c815a5899',1496658775,0),(632,230,'421078634c736391a3625d0646d00619e03cd777bd863a91b2a03759a2c14898',1496658779,0),(633,223,'d58c51c2094714600096b16e5bd0ea680623662b9a62cb7f5cd1c7543f8a0813',1496658839,0),(634,231,'2942e2926d6038d2220166f98928c032951e70c72f28a1905b2f22a76f3afc1a',1496658840,0),(635,224,'36c5eaf1c6320550d6cf585341f4b7a7f4469ea81ee34de9958968be7c51b879',1496658841,0),(636,225,'af968bbece277f24f05c07057d55873ac591dcb8a3b6f09490beec2bab3faa3a',1496658846,0),(637,226,'6e458c86ee85d3f2c8fa572603c131a8f03623354184429a59d7545a565a74e4',1496658850,0),(638,232,'f719fcf06f9ecb0c9fbbe627db04568f432f642fe6b3469a7fd5ee9d619a610b',1496660203,0),(639,233,'176d669526704cb2d06b219ce9c75b14b03fea18c89a772c5a696dc396323507',1496660208,0),(640,234,'bbd31da3cb5754157c3179fc4a8d3ca11db8eb952aa3d030b6d3e9fa0b24f1fa',1496660210,0),(641,235,'fa0d366b07b987736dc27d038698236bb35ed6be4cf6062217a51e8588cc9086',1496660217,0),(642,236,'866de2f2409bb6d090b50c7ca21e9cb7fdfddc73730ef8763caa15059a79492a',1496660222,0),(643,237,'1aa6c81676b2f737369401a85d4c59b4b7dfa8cd2565b48343cf83fb5369d2b8',1496660633,0),(644,238,'1ac594c32082b0caf9dc9142bd52723beaacdc0a917de5c8ac7a72e08b559270',1496663963,0),(645,239,'616761c49ae5670bd43bc802fd46ec79203b0ecf6ce9369c0f484a2c87be93b1',1496666106,0),(646,240,'6b6e965f36debcc11811c9141ef9ce7ad5d388cab2530200642f680c7c4c7112',1496666477,0),(647,241,'c8cd4ba86364bd035b323d35d4d4f5a5c5a0aaac9d963003fc8a8dc0a2196190',1496666485,0),(648,242,'d4501c465bf561213e582fc8b09026a2860b70872692a4e99e1f5040a6af832b',1496666493,0),(649,243,'1c95edccd2e7a7a4006c8e8f1e8d8be4352a183a22a144e4f6365424b5566f39',1496666499,0),(650,244,'cc9ab4d56b34266eba39be5f576f061db4d867d7863f6eb961c0c1d9d4422729',1496666510,0),(651,245,'435570035a2c48133b276af286da89af47e3ada99073cde9ce4f0621cbcc4830',1496666517,0),(652,246,'e25e2aa663cb0990ee6d4238abd5a0d2190009bfb9e9c19513ffbfdc3d9c4a4e',1496666524,0),(653,247,'d1a562f12c8b897625b383fe299128f0abe9c0cbf7b65e9630538b1122965393',1496666531,0),(654,248,'e5b871408cdad23cc408aeb25e420381761c8df633e644fa6661690bcd3dcbbd',1496666538,0),(655,249,'adce20f9c486e41a8d42fff7525824e52b758a3ed3adaeeeacbae9d8c78fa5c9',1496666548,0),(656,250,'b69f3ab7bc9068ca2a6e1024789af93e0e2f68680121adf26d6a3aa53268ba28',1496666559,0),(657,255,'872d0b35d2cee5d0191c4e7768e24108cf7136e55adbdc9bf4ac130e6302420b',1496682382,0),(658,251,'40fa1be50dfc30e9cedf2c0b357f6ad2a90093fee0d0559b3241c43a79d150d2',1496682399,0),(659,252,'1a52a92d5387ba6c7c15a0803292210ea494b82b9a90b31279b824c0d3ba6147',1496682410,0),(660,253,'81fe2cdbd2e9cef3e06a23f00d44a71f9a0ef4de05ea71fb2f1cc88374cf4d6e',1496682414,0),(661,254,'9b316021281d44ef67768ff90d66195820716ba79aefc9321ef9d82daa5dde36',1496682418,0),(662,256,'70e7645f3ae549c166f0b3629a10c020ea76342a6d7073568dee38ed696ecbe1',1496682868,0),(663,257,'0282e578727ebbab6efcf4ef8eb1650c13a94737107f2cf236bf04e7d728e7ed',1496683089,0),(664,258,'19fe9c1af9b1b793c2eb0d0c700826553e5c6b7864a73b6cb7bb7326525d4850',1496683176,0),(665,259,'ae0efeccfbcc694ef7b35abd27ee2b05ebb44f06d6b8fca8b44e64c41df82b16',1496749412,0),(666,260,'1054bbd7a6c0ac4d648bea1ebcd7ea252076dafc7571309a93369ca0b6bf3c2a',1496750003,0),(667,261,'c96dee4c18cda6bb456e472bde69c5c96d8fc26e5686b485ab1dc9284905ee63',1496750215,0),(668,262,'fd24a53d29593a65f33076cbdc4dd43a94fd14fb1f9cad73591e4d12577c7adc',1496750216,0),(669,263,'4e1ffa3e874b85a43ae11a3837302adee0d7e256532d5164976887717200a218',1496750220,0),(670,264,'c0e65c3881fef64c2785e649f9949ff47834010b015b1bc9553a8ee8a63f7f61',1496750224,0),(671,265,'e6be749587271b8b71328c2bfeee4da8ff929ef902e10c8d0a287511de1fe676',1496750228,0),(672,266,'f2ae5125fc92634384431036d0a615dff34d78dbc389ff4010882837bc8babfd',1496750919,0);
/*!40000 ALTER TABLE `payout_transaction` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_message`
--

LOCK TABLES `support_message` WRITE;
/*!40000 ALTER TABLE `support_message` DISABLE KEYS */;
INSERT INTO `support_message` VALUES (1,1,1,0,0,'dfdfdf',1493890773),(2,1,1,0,0,'dfdfdf',1493890802),(3,1,1,0,0,'asdasdasd',1493899068),(4,1,1,0,0,'asdasdasd',1493899070),(5,1,1,0,0,'asdasdasd',1493899070),(6,1,1,0,0,'asdasdasd',1493899070),(7,1,1,0,0,'asdasdasd',1493899071),(8,1,1,0,0,'asdasdasd',1493899071),(9,1,1,0,0,'asdasdasd',1493899071),(10,1,1,0,0,'asdasdasd',1493899071),(11,1,1,0,0,'Hello there!',1493916847),(12,1,1,0,0,'Hi.',1493916976),(13,1,1,0,0,'How are you?',1493916983),(14,2,3,0,0,'hello',1493919365),(15,2,3,0,0,'fdfdsvsd',1493919369),(16,2,3,0,0,'sdvsdvsd',1493919373),(17,3,2,0,0,'huhuhi',1493919727),(18,3,2,0,0,'hjhh77gug',1493919740),(19,3,2,0,0,'hbjbjkbjjb',1493919745),(20,4,4,0,0,'Hi',1495199294),(21,4,4,0,0,'I have some problems here',1495199307),(22,5,5,0,0,'asdasdasd',1495460026),(23,5,5,0,0,'asdasdasd',1495460029),(24,5,5,0,0,'aasdasdasdasd',1495461959),(25,5,5,0,0,'123456',1495461969),(26,5,5,0,0,'qwerty',1495461982),(27,5,5,0,0,'zxc',1495462864),(28,4,1,0,0,'Hay.',1495483380),(29,1,1,0,0,'111',1495645759),(30,1,1,0,0,'a',1495645763),(31,1,1,0,0,'a',1495645764),(32,1,1,0,0,'a',1495645764),(33,1,1,0,0,'a',1495645765),(34,1,1,0,0,'a',1495645766),(35,1,1,0,0,'a',1495645767),(36,1,1,0,0,'a',1495645768),(37,1,1,0,0,'a',1495645769),(38,1,1,0,0,'a',1495645769),(39,1,1,0,0,'a',1495645770),(40,1,1,0,0,'vcbcvbvcb',1495648385),(41,1,1,0,0,'cvbcvb',1495648395),(42,1,1,0,0,'cvbvcb',1495648396),(43,1,1,0,0,'cvbcvb',1495648398),(44,5,1,0,0,'gfbvcbvcvn',1495649455),(45,1,1,0,0,'dddddd',1495735758),(46,1,1,0,0,'Hello',1495805145),(47,1,1,0,0,'dsksnfklnsdklcs\nsdosdocmsdkmc\ndsmdocmsdkocms\nsodcmsdcmsd\nsdmckos',1495805244),(48,1,1,0,0,'dsmcdksmckdscsdcmksdcms',1495805250),(49,1,1,0,0,'1',1495805288),(50,1,1,0,0,'121212',1495805293),(51,5,1,0,0,'Срываыаыв',1495806265),(52,1,1,0,0,'sdsd',1495811631),(53,1,1,0,0,'1234',1495811638),(54,1,1,0,0,'12',1495811641),(55,1,1,0,0,'sdsd',1495883052),(56,1,1,0,0,'sdsd',1495883057),(57,1,1,0,0,'hddhhddhdh',1496158686),(58,1,1,0,0,'yttttgvcg',1496158708),(59,1,1,0,0,'hzhzhsdhdhd',1496158849),(60,1,1,0,0,'isjdudududududdududu',1496158854),(61,1,1,0,0,'agshzjz',1496158912),(62,1,1,0,0,'555',1496158921),(63,1,1,0,0,'6',1496158924),(64,1,1,0,0,'7',1496158925),(65,1,1,0,0,'5',1496158927),(66,1,1,0,0,'6',1496158928),(67,1,1,0,0,'&amp;#-4738383626',1496158932),(68,1,1,0,0,'rdhddhhdhdd',1496322689),(69,1,1,0,0,'gzgshsjssjddjjdjddjd',1496322702),(70,1,1,0,0,'Hello',1496398166),(71,1,1,0,0,'про',1496418606),(72,1,1,0,0,'Hdhhd',1496422689),(73,1,1,0,0,'1',1496658422),(74,1,1,0,0,'hi',1496667712),(75,1,1,0,0,'ggdhch',1496667722),(76,1,1,0,0,'gcyvgu',1496667724);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_room`
--

LOCK TABLES `support_room` WRITE;
/*!40000 ALTER TABLE `support_room` DISABLE KEYS */;
INSERT INTO `support_room` VALUES (1,1,1,1,1493890772,1493890772),(2,3,1,1,1493919359,1493919359),(3,2,1,1,1493919647,1493919647),(4,4,1,1,1495199286,1495199286),(5,5,1,1,1495460020,1495460020),(6,6,1,1,1496666941,1496666941);
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
  `last_sync` bigint(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'XE8qCNQGpf59mki96Ad8sffuRFnzfFuM3B','','10470c3b4b1fed12c3baac014be15fac67c6e815','1000',1,1493310692,0,1,'WHPJLHGU2T4AGEXJ',1,'xinonghost@gmail.com','','',0,1495805438),(2,'XCe97Uv6VN1nMewCStYeCQY38h4KDcs7sW','','f0cff509a02114047d4c3e29c5ffcd6e5b2ad416','1000',1,1493919170,0,0,'',0,'','','',0,1495805438),(3,'XFiyacMUrouqCUFBDXbmbvfBJDAR37FZvx','','f0cff509a02114047d4c3e29c5ffcd6e5b2ad416','1000',1,1493919226,0,0,'',0,'','','',0,1495805438),(4,'XLzbAu38WkorJVmWEggAq3XyUvHaKd3t72','','f0cff509a02114047d4c3e29c5ffcd6e5b2ad416','1000',1,1495199251,0,0,'',0,'','','',0,1495805438),(5,'1DKSt2yjJhrZBdz1r3AkUkKTMauwX3nanJ1','','10470c3b4b1fed12c3baac014be15fac67c6e815','1000',1,1495459897,0,0,'',0,'123123@qw.com','','',0,1495805439),(6,'1K4pAf57aVdD2mxN3RH22tw24C3WKFjtp','','f0cff509a02114047d4c3e29c5ffcd6e5b2ad416','0',0,1496666803,0,0,'',0,'','','',0,0);
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

-- Dump completed on 2017-06-06 15:32:31
