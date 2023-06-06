-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: revista
-- ------------------------------------------------------
-- Server version	8.0.32-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subscription_level_id` int NOT NULL,
  `author_id` int unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `preview` text,
  `slug` varchar(255) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `subscription_level_id` (`subscription_level_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`subscription_level_id`) REFERENCES `subscription_levels` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,1,2,'The Test Article','Some more text\nto test a different linux tool\nto convert text to pdf.','Some more text\nto test a different linux tool\nto convert text to pdf.','the-test-article','2023-04-29 09:09:12'),(2,1,3,'Pulp Fiction Essay','Latest Updates\r\n- Added PHP 8.2.5, 8.1.18\r\n- Catch for ctrl+s now open the save dialog and ctrl+r triggers a save in local storage\r\n- Fixed error reporting issue with PHP 5.3 and lower\r\n- Compiled Calendar extension in most PHP versions\r\n- Renamed Autoload to \"Auto Save\" and enabled by default\r\n\r\nPlease let me know when you find any bugs or annoyances to help make this website better :)\r\n\r\nSee all updates in the changelog','Latest Updates\r\n- Added PHP 8.2.5, 8.1.18\r\n- Catch for ctrl+s now open the save dialog and ctrl+r triggers a save in local storage\r\n- Fixed error reporting issue with PHP 5.3 and lower\r\n- Compiled Cal','pulp-fiction-essay','2023-04-30 08:12:08'),(5,1,41,'Notes','Network access is rerouted from within the Sandbox, and system access is limited for now. Read about how to use network functions and example files.\r\n\r\nIf you feel like a function should be enabled/disabled, or if you have any other suggestions, let me know through the comments below or send me an email :).\r\n\r\nLooking for the old version?\r\nCheck this out: The Legacy Online PHP Sandbox\r\n\r\nComments?\r\nYou can find comments here','Network access is rerouted from within the Sandbox, and system access is limited for now. Read about how to use network functions and example files.\r\n\r\nIf you feel like a function should be enabled/di','notes','2023-04-30 08:22:18');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `authors` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `profile_image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'John Doe','A writer and journalist','https://example.com/profile.jpg'),(2,'Jane Doe','A writer and poetess','https://example.com/profile.jpg'),(3,'Dashiel Hammet','THE Writer','https://example.com/profile.jpg'),(4,'Ernest Hemingway','An earnest writer','https://example.com/profile.jpg'),(23,'His Dark Majora','Majora Mask','http://important.stuff.com'),(25,'Who SHot ya','bigggie biggie smalls','oiasdjoiajsdoaisjda'),(26,'Who SHot ya 2','sadsad','asdasdasda'),(41,'Alexandre Duma Duma','Numas','sakdjasldjalsda'),(54,'Jane Numark','asda','dasdasda');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Subscriber'),(2,'Editor'),(3,'Admin');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_levels`
--

DROP TABLE IF EXISTS `subscription_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `level_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level_name` (`level_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_levels`
--

LOCK TABLES `subscription_levels` WRITE;
/*!40000 ALTER TABLE `subscription_levels` DISABLE KEYS */;
INSERT INTO `subscription_levels` VALUES (1,'Free'),(2,'Paid');
/*!40000 ALTER TABLE `subscription_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `subscription_level_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `confirmation_code` varchar(255) DEFAULT NULL,
  `is_email_validated` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_users_subscription_level_id` (`subscription_level_id`),
  KEY `fk_users_roles` (`role_id`),
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `fk_users_subscription_level_id` FOREIGN KEY (`subscription_level_id`) REFERENCES `subscription_levels` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'admin','$2y$10$.y92Aa6R.PcniX1MoNKcEugcW4g/oQ63Nm12VqTycho9CzCH33z7C',2,'',NULL,0,2),(8,'test1','$2y$10$thRzPfau3/wNKb4RVxKtz.GYItduwE6sxRqLArCrgHasLvdIluYki',1,'a@a.com','008e7538828c63c800a8b6e19a798e54f496eb1937483fba361bdf96a61458da',0,1),(18,'testulescu','$2y$10$ymUYuuvyOPbeUIUxvwPxe.c9i5lY76LLSqtJqU3nRFTpTv7sfiP3W',1,'t@t.com',NULL,1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-30 10:41:12
