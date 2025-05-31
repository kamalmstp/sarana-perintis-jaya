Enter password: 
/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.0-MariaDB, for Android (aarch64)
--
-- Host: localhost    Database: kaido_kit
-- ------------------------------------------------------
-- Server version	11.8.0-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `books` VALUES
(1,'Sunt voluptatum dolore.','Weldon Hoppe','Eum dolorem consectetur debitis quo aperiam. Et dolorem sed voluptatibus temporibus cumque sunt doloribus ex. Recusandae quia asperiores eos. Neque unde laboriosam odio dolorem accusantium. Ea suscipit ut consequatur ea corrupti a ea.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(2,'Voluptatem vero ut.','Mariam Flatley','Autem cupiditate vel accusamus aperiam. Consequatur eos excepturi est cum.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(3,'Voluptatem veritatis sint.','Nico Hermiston I','Dolorem accusamus debitis sit rerum molestias consequatur veritatis hic. Nam quaerat rerum consequatur occaecati. Aut animi quae est ipsam enim qui. Maxime excepturi sed non voluptas aut amet quae.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(4,'Dolor porro magni nobis.','Murray Moore','Ex dolorum esse quam soluta ut facere omnis sit. Ut quas molestiae dolorum. Voluptatibus laborum iure nostrum qui nemo sit. Quae praesentium sunt eos.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(5,'Et quo reiciendis.','Liza Hartmann','Optio et suscipit necessitatibus eum amet. Accusantium labore delectus reprehenderit ipsum beatae. Maxime temporibus dolor iusto fugit magni dolorum. Quo et ut vel et nihil. Alias eum voluptatibus et et ut voluptatem nam.','2025-05-29 07:32:30','2025-05-29 07:32:30');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `breezy_sessions`
--

DROP TABLE IF EXISTS `breezy_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `breezy_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `authenticatable_type` varchar(255) NOT NULL,
  `authenticatable_id` bigint(20) unsigned NOT NULL,
  `panel_id` varchar(255) DEFAULT NULL,
  `guard` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `breezy_sessions_authenticatable_type_authenticatable_id_index` (`authenticatable_type`,`authenticatable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breezy_sessions`
--

LOCK TABLES `breezy_sessions` WRITE;
/*!40000 ALTER TABLE `breezy_sessions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `breezy_sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `cache` VALUES
('livewire-rate-limiter:bab6dbeb0e81aed5e85f76d808a7b69ccdca7f79','i:1;',1748584826),
('livewire-rate-limiter:bab6dbeb0e81aed5e85f76d808a7b69ccdca7f79:timer','i:1748584826;',1748584826),
('livewire-rate-limiter:bcdd25071d99a56268a4f5d7340d25668c9fd50e','i:2;',1748584773),
('livewire-rate-limiter:bcdd25071d99a56268a4f5d7340d25668c9fd50e:timer','i:1748584773;',1748584773),
('spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:122:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"view_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:13:\"view_any_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"create_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"update_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:12:\"restore_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:16:\"restore_any_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"replicate_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"reorder_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:11:\"delete_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"delete_any_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:17:\"force_delete_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:21:\"force_delete_any_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:16:\"book:create_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:16:\"book:update_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"book:delete_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:20:\"book:pagination_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"book:detail_book\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:13:\"view_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:17:\"view_any_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:15:\"create_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:15:\"update_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:16:\"restore_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:20:\"restore_any_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:18:\"replicate_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:16:\"reorder_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:15:\"delete_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:19:\"delete_any_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:21:\"force_delete_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:25:\"force_delete_any_customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:11:\"view_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"view_any_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:13:\"create_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:13:\"update_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:14:\"restore_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:18:\"restore_any_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:16:\"replicate_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:14:\"reorder_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:13:\"delete_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:17:\"delete_any_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:19:\"force_delete_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:23:\"force_delete_any_driver\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:13:\"view_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:17:\"view_any_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:15:\"create_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:15:\"update_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:16:\"restore_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:20:\"restore_any_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:18:\"replicate_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:16:\"reorder_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:15:\"delete_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:19:\"delete_any_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:21:\"force_delete_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:25:\"force_delete_any_location\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:10:\"view_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:14:\"view_any_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"create_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:12:\"update_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:13:\"restore_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:17:\"restore_any_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:15:\"replicate_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:13:\"reorder_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:12:\"delete_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:16:\"delete_any_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:18:\"force_delete_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:22:\"force_delete_any_order\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:18:\"view_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:22:\"view_any_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:20:\"create_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:20:\"update_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:21:\"restore_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:25:\"restore_any_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:23:\"replicate_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:21:\"reorder_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:20:\"delete_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:24:\"delete_any_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:26:\"force_delete_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:30:\"force_delete_any_order::proses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:9:\"view_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:13:\"view_any_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:11:\"create_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:11:\"update_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:11:\"delete_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:15:\"delete_any_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:10:\"view_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:14:\"view_any_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:12:\"create_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:12:\"update_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:13:\"restore_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:17:\"restore_any_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:15:\"replicate_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:13:\"reorder_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:12:\"delete_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:16:\"delete_any_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:18:\"force_delete_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:22:\"force_delete_any_token\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:10:\"view_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:14:\"view_any_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:12:\"create_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:12:\"update_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:13:\"restore_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:17:\"restore_any_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:15:\"replicate_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:13:\"reorder_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:12:\"delete_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:16:\"delete_any_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:18:\"force_delete_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:22:\"force_delete_any_truck\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:9:\"view_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:13:\"view_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:11:\"create_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:110;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:11:\"update_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:111;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:12:\"restore_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:112;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:16:\"restore_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:113;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:14:\"replicate_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:12:\"reorder_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:115;a:4:{s:1:\"a\";i:116;s:1:\"b\";s:11:\"delete_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:116;a:4:{s:1:\"a\";i:117;s:1:\"b\";s:15:\"delete_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:117;a:4:{s:1:\"a\";i:118;s:1:\"b\";s:17:\"force_delete_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:118;a:4:{s:1:\"a\";i:119;s:1:\"b\";s:21:\"force_delete_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:119;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:18:\"page_ManageSetting\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:120;a:4:{s:1:\"a\";i:121;s:1:\"b\";s:11:\"page_Themes\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:121;a:4:{s:1:\"a\";i:122;s:1:\"b\";s:18:\"page_MyProfilePage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super_admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"Kasir\";s:1:\"c\";s:3:\"web\";}}}',1748671270);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `contacts` VALUES
(1,'Lauretta Brakus Jr.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(2,'Ruben Wiza','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(3,'Vivienne Grady','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(4,'Lelah Stamm','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(5,'Maryjane Reilly','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(6,'Enid Cremin','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(7,'Lucius Stiedemann DVM','2025-05-29 07:32:31','2025-05-29 07:32:31'),
(8,'Mrs. Mireya Aufderhar II','2025-05-29 07:32:31','2025-05-29 07:32:31'),
(9,'Nico Towne IV','2025-05-29 07:32:31','2025-05-29 07:32:31'),
(10,'Erik Watsica','2025-05-29 07:32:31','2025-05-29 07:32:31');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `pic_name` varchar(255) DEFAULT NULL,
  `pic_phone` varchar(255) DEFAULT NULL,
  `pic_email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `customers` VALUES
(1,'PT. Terang Samudera Logistik','PT. TSL',NULL,NULL,NULL,NULL,NULL,'2025-05-29 10:37:06','2025-05-29 10:37:06');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drivers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('karyawan','vendor') NOT NULL,
  `identity_number` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` enum('aktif','non-aktif') DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drivers`
--

LOCK TABLES `drivers` WRITE;
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `drivers` VALUES
(1,'Driver Test','karyawan',NULL,NULL,'aktif',NULL,'2025-05-30 09:56:55','2025-05-30 09:56:55');
/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `exports`
--

DROP TABLE IF EXISTS `exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `exporter` varchar(255) NOT NULL,
  `processed_rows` int(10) unsigned NOT NULL DEFAULT 0,
  `total_rows` int(10) unsigned NOT NULL,
  `successful_rows` int(10) unsigned NOT NULL DEFAULT 0,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exports_user_id_foreign` (`user_id`),
  CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exports`
--

LOCK TABLES `exports` WRITE;
/*!40000 ALTER TABLE `exports` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `exports` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `failed_import_rows`
--

DROP TABLE IF EXISTS `failed_import_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_import_rows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `import_id` bigint(20) unsigned NOT NULL,
  `validation_error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_import_rows_import_id_foreign` (`import_id`),
  CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_import_rows`
--

LOCK TABLES `failed_import_rows` WRITE;
/*!40000 ALTER TABLE `failed_import_rows` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `failed_import_rows` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `imports`
--

DROP TABLE IF EXISTS `imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `importer` varchar(255) NOT NULL,
  `processed_rows` int(10) unsigned NOT NULL DEFAULT 0,
  `total_rows` int(10) unsigned NOT NULL,
  `successful_rows` int(10) unsigned NOT NULL DEFAULT 0,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imports_user_id_foreign` (`user_id`),
  CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imports`
--

LOCK TABLES `imports` WRITE;
/*!40000 ALTER TABLE `imports` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `imports` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `locations` VALUES
(1,'PT. TSL','Pelabuhan Sampit (KM. Bunga Teratai 17)',NULL,NULL,NULL,'2025-05-29 10:37:46','2025-05-29 10:37:54'),
(2,'tes','tes',NULL,NULL,NULL,'2025-05-30 09:06:50','2025-05-30 09:06:50'),
(3,'kldjfkjjk','kjk','kk',NULL,NULL,'2025-05-30 19:53:06','2025-05-30 19:53:06');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2022_12_14_083707_create_settings_table',1),
(5,'2024_12_04_025120_create_media_table',1),
(6,'2024_12_04_041953_create_breezy_sessions_table',1),
(7,'2025_01_01_120813_create_books_table',1),
(8,'2025_01_02_064819_create_permission_tables',1),
(9,'2025_01_02_225927_add_avatar_url_column_to_users_table',1),
(10,'2025_01_03_114929_create_personal_access_tokens_table',1),
(11,'2025_01_04_125650_create_posts_table',1),
(12,'2025_01_08_152510_create_kaido_settings',1),
(13,'2025_01_08_233142_create_socialite_users_table',1),
(14,'2025_01_09_225908_update_user_table_make_password_column_nullable',1),
(15,'2025_01_12_031340_create_notifications_table',1),
(16,'2025_01_12_031357_create_imports_table',1),
(17,'2025_01_12_031358_create_exports_table',1),
(18,'2025_01_12_031359_create_failed_import_rows_table',1),
(19,'2025_01_12_091355_create_contacts_table',1),
(20,'2025_01_31_020024_add_themes_settings_to_users_table',1),
(21,'2025_05_27_201412_create_trucks_table',1),
(22,'2025_05_27_201418_create_drivers_table',1),
(23,'2025_05_27_201617_create_locations_table',1),
(24,'2025_05_27_201633_create_customers_table',1),
(25,'2025_05_27_233418_create_orders_table',1),
(26,'2025_05_27_233629_create_order_proses_table',1),
(27,'2025_05_27_233650_create_order_details_table',1),
(28,'2025_05_30_174525_add_driver_id_to_order_details_table',2),
(29,'2025_05_31_040033_create_truck_maintenances_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `model_has_roles` VALUES
(1,'App\\Models\\User',12);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_proses_id` bigint(20) unsigned NOT NULL,
  `truck_id` bigint(20) unsigned NOT NULL,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `date_detail` date NOT NULL,
  `bag_send` int(11) DEFAULT NULL,
  `bag_received` int(11) DEFAULT NULL,
  `bruto` decimal(10,2) DEFAULT NULL,
  `tara` decimal(10,2) DEFAULT NULL,
  `netto` decimal(10,2) DEFAULT NULL,
  `status_detail` enum('pending','proses','selesai') DEFAULT NULL,
  `note_detail` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_details_order_proses_id_foreign` (`order_proses_id`),
  KEY `order_details_truck_id_foreign` (`truck_id`),
  KEY `order_details_driver_id_foreign` (`driver_id`),
  CONSTRAINT `order_details_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
  CONSTRAINT `order_details_order_proses_id_foreign` FOREIGN KEY (`order_proses_id`) REFERENCES `order_proses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_details_truck_id_foreign` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `order_details` VALUES
(1,1,1,1,'2025-05-31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-05-30 09:57:09','2025-05-30 09:57:09');
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `order_proses`
--

DROP TABLE IF EXISTS `order_proses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_proses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `do_number` varchar(255) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `so_number` varchar(255) DEFAULT NULL,
  `item_proses` varchar(255) DEFAULT NULL,
  `total_kg_proses` decimal(10,2) DEFAULT NULL,
  `total_bag_proses` int(11) DEFAULT NULL,
  `delivery_location_id` bigint(20) unsigned NOT NULL,
  `type_proses` enum('gudang','kapal','container') NOT NULL,
  `tally_proses` varchar(255) DEFAULT NULL,
  `tarif` decimal(12,2) DEFAULT NULL,
  `operation_proses` enum('bongkar','teruskan') DEFAULT NULL,
  `total_container_proses` int(11) DEFAULT NULL,
  `no_container_proses` varchar(255) DEFAULT NULL,
  `lock_number_proses` varchar(255) DEFAULT NULL,
  `vessel_name_proses` varchar(255) DEFAULT NULL,
  `warehouse_proses` varchar(255) DEFAULT NULL,
  `invoice_status` enum('none','pending','sent','paid','canceled') DEFAULT NULL,
  `note_proses` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_proses_order_id_foreign` (`order_id`),
  KEY `order_proses_delivery_location_id_foreign` (`delivery_location_id`),
  CONSTRAINT `order_proses_delivery_location_id_foreign` FOREIGN KEY (`delivery_location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_proses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_proses`
--

LOCK TABLES `order_proses` WRITE;
/*!40000 ALTER TABLE `order_proses` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `order_proses` VALUES
(1,1,'S02501000231','8700175864',NULL,'Cakra Pandawa AC',483000.00,9660,1,'gudang',NULL,NULL,'bongkar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-05-29 11:57:30','2025-05-29 11:57:30'),
(2,1,NULL,NULL,NULL,NULL,NULL,NULL,2,'gudang',NULL,NULL,'teruskan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-05-30 09:07:35','2025-05-30 09:07:35');
/*!40000 ALTER TABLE `order_proses` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `spk_number` varchar(255) NOT NULL,
  `spk_date` date NOT NULL,
  `delivery_term` enum('dtd','dtp','ptd','ptp') NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `period` varchar(255) DEFAULT NULL,
  `total_kg` decimal(10,2) DEFAULT NULL,
  `total_bag` int(11) DEFAULT NULL,
  `loading_location_id` bigint(20) unsigned DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_loading_location_id_foreign` (`loading_location_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_loading_location_id_foreign` FOREIGN KEY (`loading_location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `orders` VALUES
(1,1,'01002C-TSL-SK/MDN/I/2025','2025-01-24','ptd',NULL,NULL,1596000.00,31920,1,NULL,'2025-05-29 10:49:59','2025-05-29 10:49:59');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `permissions` VALUES
(1,'view_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(2,'view_any_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(3,'create_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(4,'update_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(5,'restore_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(6,'restore_any_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(7,'replicate_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(8,'reorder_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(9,'delete_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(10,'delete_any_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(11,'force_delete_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(12,'force_delete_any_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(13,'book:create_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(14,'book:update_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(15,'book:delete_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(16,'book:pagination_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(17,'book:detail_book','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(18,'view_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(19,'view_any_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(20,'create_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(21,'update_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(22,'restore_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(23,'restore_any_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(24,'replicate_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(25,'reorder_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(26,'delete_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(27,'delete_any_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(28,'force_delete_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(29,'force_delete_any_customer','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(30,'view_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(31,'view_any_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(32,'create_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(33,'update_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(34,'restore_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(35,'restore_any_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(36,'replicate_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(37,'reorder_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(38,'delete_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(39,'delete_any_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(40,'force_delete_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(41,'force_delete_any_driver','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(42,'view_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(43,'view_any_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(44,'create_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(45,'update_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(46,'restore_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(47,'restore_any_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(48,'replicate_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(49,'reorder_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(50,'delete_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(51,'delete_any_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(52,'force_delete_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(53,'force_delete_any_location','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(54,'view_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(55,'view_any_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(56,'create_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(57,'update_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(58,'restore_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(59,'restore_any_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(60,'replicate_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(61,'reorder_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(62,'delete_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(63,'delete_any_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(64,'force_delete_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(65,'force_delete_any_order','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(66,'view_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(67,'view_any_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(68,'create_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(69,'update_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(70,'restore_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(71,'restore_any_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(72,'replicate_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(73,'reorder_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(74,'delete_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(75,'delete_any_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(76,'force_delete_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(77,'force_delete_any_order::proses','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(78,'view_role','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(79,'view_any_role','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(80,'create_role','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(81,'update_role','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(82,'delete_role','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(83,'delete_any_role','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(84,'view_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(85,'view_any_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(86,'create_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(87,'update_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(88,'restore_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(89,'restore_any_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(90,'replicate_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(91,'reorder_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(92,'delete_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(93,'delete_any_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(94,'force_delete_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(95,'force_delete_any_token','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(96,'view_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(97,'view_any_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(98,'create_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(99,'update_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(100,'restore_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(101,'restore_any_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(102,'replicate_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(103,'reorder_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(104,'delete_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(105,'delete_any_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(106,'force_delete_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(107,'force_delete_any_truck','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(108,'view_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(109,'view_any_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(110,'create_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(111,'update_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(112,'restore_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(113,'restore_any_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(114,'replicate_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(115,'reorder_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(116,'delete_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(117,'delete_any_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(118,'force_delete_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(119,'force_delete_any_user','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(120,'page_ManageSetting','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(121,'page_Themes','web','2025-05-29 07:33:23','2025-05-29 07:33:23'),
(122,'page_MyProfilePage','web','2025-05-29 07:33:23','2025-05-29 07:33:23');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `posts` VALUES
(1,'Doloribus voluptas laboriosam expedita velit ex qui aspernatur.','Tenetur in saepe rerum libero. Quam non sed perferendis nostrum tenetur earum. Dolorum facilis sit quibusdam numquam.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(2,'Sit sequi incidunt ipsa esse officia consequatur vel dolores.','Et omnis minima error ea. Vel doloribus autem deleniti beatae ea aliquid. Magnam dolor corporis modi sed quia ut ut.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(3,'Tempora molestiae deserunt maiores minus sapiente.','Adipisci eum impedit omnis eos. Facere dolor cumque soluta culpa. Nulla harum voluptatem ducimus maxime. Possimus nemo eum dolores dolore. Laboriosam inventore mollitia est perferendis suscipit molestiae.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(4,'Blanditiis quas et consectetur dolores tenetur earum beatae sed.','Eos placeat deleniti labore nostrum occaecati. Id dolorem voluptatibus aut dolorem molestiae laboriosam mollitia. Ea inventore expedita odit voluptatibus consequatur commodi. Et vel vitae in officia repudiandae voluptate ea.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(5,'Quo consequatur magni eveniet iusto quia ducimus.','Sit quia hic beatae aperiam qui corporis sequi. Id rerum explicabo fuga facere voluptate. Libero incidunt libero voluptatibus quod.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(6,'Omnis optio facere quidem pariatur nemo quia consequatur.','Cumque quis asperiores dolorem tenetur est optio tenetur. Fugit corporis repellendus quos dolor exercitationem excepturi ut. Nisi ipsa occaecati quod consectetur unde. Ipsam amet numquam dicta enim facilis.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(7,'Ut eos cumque veniam aut qui officiis dolor eaque.','Nihil quas magnam a voluptate. Quia esse aut voluptatem odio tenetur eos. Ea culpa perferendis rerum facilis.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(8,'Nostrum autem impedit sint.','Velit nisi laborum sunt rem cupiditate fuga. Quia qui enim dicta et dolor odit. Harum ipsum est qui.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(9,'Nam praesentium ipsum placeat officiis iusto.','Blanditiis et est modi incidunt possimus. Corporis harum repellendus et facilis rerum ipsa ea. Nihil itaque inventore libero blanditiis laudantium.','2025-05-29 07:32:30','2025-05-29 07:32:30'),
(10,'Voluptates itaque quis dolores est eum quae.','Aut sequi nisi quia quo quos fuga. Et et aut sunt sed voluptatem. Consequatur voluptas sint et omnis beatae amet cupiditate quis. Officia aperiam doloremque ad reprehenderit quis.','2025-05-29 07:32:30','2025-05-29 07:32:30');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `role_has_permissions` VALUES
(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(6,1),
(7,1),
(8,1),
(9,1),
(10,1),
(11,1),
(12,1),
(13,1),
(14,1),
(15,1),
(16,1),
(17,1),
(18,1),
(19,1),
(20,1),
(21,1),
(22,1),
(23,1),
(24,1),
(25,1),
(26,1),
(27,1),
(28,1),
(29,1),
(30,1),
(31,1),
(32,1),
(33,1),
(34,1),
(35,1),
(36,1),
(37,1),
(38,1),
(39,1),
(40,1),
(41,1),
(42,1),
(43,1),
(44,1),
(45,1),
(46,1),
(47,1),
(48,1),
(49,1),
(50,1),
(51,1),
(52,1),
(53,1),
(54,1),
(55,1),
(56,1),
(57,1),
(58,1),
(59,1),
(60,1),
(61,1),
(62,1),
(63,1),
(64,1),
(65,1),
(66,1),
(67,1),
(68,1),
(69,1),
(70,1),
(71,1),
(72,1),
(73,1),
(74,1),
(75,1),
(76,1),
(77,1),
(78,1),
(79,1),
(80,1),
(81,1),
(82,1),
(83,1),
(84,1),
(85,1),
(86,1),
(87,1),
(88,1),
(89,1),
(90,1),
(91,1),
(92,1),
(93,1),
(94,1),
(95,1),
(96,1),
(97,1),
(98,1),
(99,1),
(100,1),
(101,1),
(102,1),
(103,1),
(104,1),
(105,1),
(106,1),
(107,1),
(108,1),
(109,1),
(110,1),
(111,1),
(112,1),
(113,1),
(114,1),
(115,1),
(116,1),
(117,1),
(118,1),
(119,1),
(120,1),
(121,1),
(122,1),
(18,2),
(19,2),
(20,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `roles` VALUES
(1,'super_admin','web','2025-05-29 07:33:22','2025-05-29 07:33:22'),
(2,'Kasir','web','2025-05-29 22:01:10','2025-05-29 22:01:10');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sessions` VALUES
('k2wtz7GKQATfvAsfRuAxZQfhbfJxRagnTefxhv9g',12,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMVNzeENZeDRQRnl2TW9HVTdNcGNMUXRGTG5XeFpmSEliem9pUG85NSI7czo1MDoibG9naW5fd2ViXzNkYzdhOTEzZWY1ZmQ0Yjg5MGVjYWJlMzQ4NzA4NTU3M2UxNmNmODIiO2k6MTI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiR4TTV0aUo1OXVyTHdFYk10c3M5clQuaWtrd0pEN3dXa0FaOVpPbVVuY09KNVp4SWhoQ2czcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9vcmRlci1kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',1748627898),
('R9tExSUSKFaR0poNku8DLZEsIMEbi8PzWFAySnS4',12,'127.0.0.1','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTmdiMXFDRjR3dmhwcFZhZnlpdUd0QXJaRFJVVk8yQXdMNjVqZ2RSbSI7czo1MDoibG9naW5fd2ViXzNkYzdhOTEzZWY1ZmQ0Yjg5MGVjYWJlMzQ4NzA4NTU3M2UxNmNmODIiO2k6MTI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiR4TTV0aUo1OXVyTHdFYk10c3M5clQuaWtrd0pEN3dXa0FaOVpPbVVuY09KNVp4SWhoQ2czcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9vcmRlci1kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748664920);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_name_unique` (`group`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `settings` VALUES
(1,'KaidoSetting','site_name',0,'\"Spatie\"','2025-05-29 07:32:24','2025-05-29 07:32:24'),
(2,'KaidoSetting','site_active',0,'true','2025-05-29 07:32:24','2025-05-29 07:32:24'),
(3,'KaidoSetting','registration_enabled',0,'true','2025-05-29 07:32:24','2025-05-29 07:32:24'),
(4,'KaidoSetting','login_enabled',0,'true','2025-05-29 07:32:24','2025-05-29 07:32:24'),
(5,'KaidoSetting','password_reset_enabled',0,'true','2025-05-29 07:32:24','2025-05-29 07:32:24'),
(6,'KaidoSetting','sso_enabled',0,'true','2025-05-29 07:32:24','2025-05-29 07:32:24');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `socialite_users`
--

DROP TABLE IF EXISTS `socialite_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `socialite_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `provider` varchar(255) NOT NULL,
  `provider_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `socialite_users_provider_provider_id_unique` (`provider`,`provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `socialite_users`
--

LOCK TABLES `socialite_users` WRITE;
/*!40000 ALTER TABLE `socialite_users` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `socialite_users` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `truck_maintenances`
--

DROP TABLE IF EXISTS `truck_maintenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `truck_maintenances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `truck_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `qty` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `truck_maintenances`
--

LOCK TABLES `truck_maintenances` WRITE;
/*!40000 ALTER TABLE `truck_maintenances` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `truck_maintenances` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `trucks`
--

DROP TABLE IF EXISTS `trucks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trucks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `plate_number` varchar(255) NOT NULL,
  `ownership` enum('company','rental') NOT NULL DEFAULT 'company',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trucks_plate_number_unique` (`plate_number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trucks`
--

LOCK TABLES `trucks` WRITE;
/*!40000 ALTER TABLE `trucks` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `trucks` VALUES
(1,'KH 1234 AA','company',NULL,'2025-05-29 22:03:40','2025-05-29 22:03:40');
/*!40000 ALTER TABLE `trucks` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `theme` varchar(255) DEFAULT 'default',
  `theme_color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `users` VALUES
(1,'Alan Dooley','pstokes@example.org','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','YSe52gAoqo','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(2,'Prof. Hilton O\'Kon','kirlin.ethel@example.net','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','nU3ddDFJzB','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(3,'Rita Ortiz MD','mcdermott.durward@example.net','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','HLQj4I6LfM','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(4,'Murphy Littel','brandon.denesik@example.net','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','sUFlHUgsk7','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(5,'Oleta Block','ardith13@example.com','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','RN5RR5ovPu','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(6,'Ivy Romaguera','kbaumbach@example.org','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','GjcGP0VKrm','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(7,'Rubie Schumm','brandy35@example.net','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','twJVCeopaN','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(8,'Zachariah Gislason II','nwiza@example.com','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','n4uaD1TBYY','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(9,'Vidal Ernser','gerhard92@example.org','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','SfkQMMmKtg','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(10,'Prof. Tyshawn Sauer','alexanne31@example.com','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','ka2lGLytFo','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(11,'admin','admin@admin.com','2025-05-29 07:32:30','$2y$12$o45hVW16OT0xwR1Wm3DJ3eOHNllCBB9Ex7TppE8I7YK0T165YCmQK','wXGsSRQEZtWJwlZjgxidRizpy1mqKraLrXO6SBkv4tcTt3DAcUUW6eiKIlbH','2025-05-29 07:32:30','2025-05-29 07:32:30',NULL,'default',NULL),
(12,'Administrator','admin@gmail.com',NULL,'$2y$12$xM5tiJ59urLwEbMtss9rT.ikkwJD7wWkAZ9ZOmUncOJ5ZxIhhCg3q','2kOkdyd376gZT4ZZu4sOzqZIqgwQTzX94Wj5rT17HlypgIXCCTi3loJI8oV0','2025-05-29 07:33:03','2025-05-29 07:33:03',NULL,'default',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-05-31 12:23:23
