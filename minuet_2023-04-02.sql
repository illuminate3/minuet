# ************************************************************
# Sequel Ace SQL dump
# Version 20039
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.30)
# Database: minuet
# Generation Time: 2023-04-02 08:55:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table doctrine_migration_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `doctrine_migration_versions`;

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;



# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` smallint DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_slug` tinyint(1) DEFAULT NULL,
  `nofollow` tinyint(1) DEFAULT NULL,
  `new_tab` tinyint(1) DEFAULT NULL,
  `locale` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_locale_unique_key` (`url`,`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;

INSERT INTO `menu` (`id`, `title`, `sort_order`, `url`, `is_slug`, `nofollow`, `new_tab`, `locale`)
VALUES
	(1,'Homepage',NULL,'/',NULL,NULL,NULL,'bg'),
	(2,'About Us',NULL,'/page/about-us',NULL,NULL,NULL,'en'),
	(3,'Contact',NULL,'/page/contact',NULL,NULL,NULL,'en'),
	(4,'Source Code',NULL,'https://github.com/Coderberg/ResidenceCMS',0,0,0,'bg'),
	(6,'Dashboard',NULL,'/user/dash',1,0,0,'en');

/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `page`;

CREATE TABLE `page` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `show_in_menu` tinyint(1) DEFAULT NULL,
  `locale` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `publish` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_locale_unique_key` (`slug`,`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;

INSERT INTO `page` (`id`, `title`, `description`, `slug`, `content`, `show_in_menu`, `locale`, `publish`)
VALUES
	(1,'About Us','About Us Page','about-us','<h3>Why Choose Us</h3>\n                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,\n                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris\n                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in\n                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\n                <h3>Our Properties</h3>\n                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,\n                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris\n                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in\n                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\n                <h3>legal notice</h3>\n                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,\n                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris\n                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in\n                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>',1,'en',1),
	(2,'Page One on One','Page One','page-one-on-one','this is content',1,'en',0),
	(3,'addFlash','addFlash','addflash','addFlash',1,'en',1),
	(4,'addFlash',NULL,'addflash-ine',NULL,0,'en',0),
	(5,'setSlug',NULL,'setslug',NULL,0,'en',0),
	(6,'setSlug one','setSlug','setslug-one','<blockquote>\r\n<h2>asfadfasdf sdafsadf asdfasdf asdf asdf asdfsdaf asdf</h2>\r\n</blockquote>',0,'en',0),
	(7,'new page','new page','new-page','<p>this is a new page</p>',0,'en',0),
	(8,'test','test','test',NULL,0,'en',0),
	(9,'test 2','test 2','test-2',NULL,0,'en',0),
	(10,'test 3','test 2','test-3',NULL,0,'en',0),
	(11,'test 4','test 2','test-4',NULL,0,'en',0);

/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8157AA0FA76ED395` (`user_id`),
  CONSTRAINT `FK_8157AA0FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;

INSERT INTO `profile` (`id`, `user_id`, `full_name`, `phone`)
VALUES
	(1,1,'John Smith','0(0)99766899'),
	(2,2,'Rhonda Jordan','0(0)99766899'),
	(3,3,'User Test','5551236789'),
	(4,4,NULL,NULL);

/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E545A0C59F9752E0` (`setting_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `setting_name`, `setting_value`)
VALUES
	(1,'site_name','Minuet'),
	(2,'site_title','Page Titile'),
	(3,'meta_title','meta Title'),
	(4,'meta_description','meta Description'),
	(5,'meta_keywords','meta keywords'),
	(6,'meta_author','meta author'),
	(7,'meta_revisit','7'),
	(8,'site_branding','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.'),
	(9,'analytics_code',''),
	(10,'allow_register','1');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `confirmation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `roles`, `confirmation_token`, `password_requested_at`, `email_verified_at`, `is_verified`)
VALUES
	(1,'admin@admin.com','$2y$04$fpGG3Zpi/pEycWmHrJiju.GFGC8M9TFGI6IGjoXivQz5Dsc6kU3h.','[\"ROLE_ADMIN\", \"ROLE_USER\"]',NULL,NULL,'2023-02-13 06:21:59',NULL),
	(2,'user@user.com','$2y$04$biEzje0xMNWuD22WhSakruN6v/X4PlFvnjYeZfa/37PGrX8DF/Z7O','[\"ROLE_USER\"]',NULL,NULL,'2023-02-13 06:21:59',NULL),
	(3,'user1@test.com','$2y$04$bxZnwbpuI46VuGXK6t8/L.JE4aIOFT4SnrNSW28vaG.axFHNkCITS','[\"ROLE_USER\"]',NULL,NULL,'2023-02-18 07:49:01',1),
	(4,'user2@test.com','$2y$04$l9gEM0CwcCMybZUaYjaSDuwKkOmO5hNl7vzTVImF0ZoWqW8I0seTi','[\"ROLE_USER\"]',NULL,NULL,'2023-02-27 06:04:53',1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
