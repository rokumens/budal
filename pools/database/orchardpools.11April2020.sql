/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 5.7.29-0ubuntu0.18.04.1 : Database - orchardpools
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`orchardpools` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `orchardpools`;

/*Table structure for table `activations` */

DROP TABLE IF EXISTS `activations`;

CREATE TABLE `activations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activations_user_id_index` (`user_id`),
  CONSTRAINT `activations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `activations` */

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `laravel2step` */

DROP TABLE IF EXISTS `laravel2step`;

CREATE TABLE `laravel2step` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) unsigned NOT NULL,
  `authCode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authCount` int(11) NOT NULL,
  `authStatus` tinyint(1) NOT NULL DEFAULT '0',
  `authDate` datetime DEFAULT NULL,
  `requestDate` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laravel2step_userid_index` (`userId`),
  CONSTRAINT `laravel2step_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `laravel2step` */

/*Table structure for table `laravel_blocker` */

DROP TABLE IF EXISTS `laravel_blocker`;

CREATE TABLE `laravel_blocker` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeId` int(10) unsigned NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `userId` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `laravel_blocker_value_unique` (`value`),
  KEY `laravel_blocker_typeid_index` (`typeId`),
  KEY `laravel_blocker_userid_index` (`userId`),
  CONSTRAINT `laravel_blocker_typeid_foreign` FOREIGN KEY (`typeId`) REFERENCES `laravel_blocker_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `laravel_blocker` */

insert  into `laravel_blocker`(`id`,`typeId`,`value`,`note`,`userId`,`created_at`,`updated_at`,`deleted_at`) values 
(1,3,'test.com','Block all domains/emails @test.com',NULL,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(2,3,'test.ca','Block all domains/emails @test.ca',NULL,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(3,3,'fake.com','Block all domains/emails @fake.com',NULL,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(4,3,'example.com','Block all domains/emails @example.com',NULL,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(5,3,'mailinator.com','Block all domains/emails @mailinator.com',NULL,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL);

/*Table structure for table `laravel_blocker_types` */

DROP TABLE IF EXISTS `laravel_blocker_types`;

CREATE TABLE `laravel_blocker_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `laravel_blocker_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `laravel_blocker_types` */

insert  into `laravel_blocker_types`(`id`,`slug`,`name`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'email','E-mail','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(2,'ipAddress','IP Address','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(3,'domain','Domain Name','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(4,'user','User','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(5,'city','City','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(6,'state','State','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(7,'country','Country','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(8,'countryCode','Country Code','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(9,'continent','Continent','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(10,'region','Region','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL);

/*Table structure for table `laravel_logger_activity` */

DROP TABLE IF EXISTS `laravel_logger_activity`;

CREATE TABLE `laravel_logger_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `userType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `route` longtext COLLATE utf8mb4_unicode_ci,
  `ipAddress` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userAgent` text COLLATE utf8mb4_unicode_ci,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referer` longtext COLLATE utf8mb4_unicode_ci,
  `methodType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `laravel_logger_activity` */

insert  into `laravel_logger_activity`(`id`,`description`,`userType`,`userId`,`route`,`ipAddress`,`userAgent`,`locale`,`referer`,`methodType`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-08 06:58:06','2020-04-08 06:58:06',NULL),
(2,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 06:58:24','2020-04-08 06:58:24',NULL),
(3,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 07:08:05','2020-04-08 07:08:05',NULL),
(4,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-08 07:08:31','2020-04-08 07:08:31',NULL),
(5,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-08 07:14:38','2020-04-08 07:14:38',NULL),
(6,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 07:14:51','2020-04-08 07:14:51',NULL),
(7,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 07:19:19','2020-04-08 07:19:19',NULL),
(8,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 07:21:49','2020-04-08 07:21:49',NULL),
(9,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 07:23:41','2020-04-08 07:23:41',NULL),
(10,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 07:24:25','2020-04-08 07:24:25',NULL),
(11,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 07:38:36','2020-04-08 07:38:36',NULL),
(12,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 07:46:15','2020-04-08 07:46:15',NULL),
(13,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:16:37','2020-04-08 08:16:37',NULL),
(14,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:18:48','2020-04-08 08:18:48',NULL),
(15,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:18:54','2020-04-08 08:18:54',NULL),
(16,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:19:07','2020-04-08 08:19:07',NULL),
(17,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:19:45','2020-04-08 08:19:45',NULL),
(18,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:20:30','2020-04-08 08:20:30',NULL),
(19,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:21:56','2020-04-08 08:21:56',NULL),
(20,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:22:48','2020-04-08 08:22:48',NULL),
(21,'Viewed apgadm/users','Registered',1,'http://pools.apg/apgadm/users','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','GET','2020-04-08 08:47:40','2020-04-08 08:47:40',NULL),
(22,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 08:49:31','2020-04-08 08:49:31',NULL),
(23,'Created apgadm/search-users','Registered',1,'http://pools.apg/apgadm/search-users','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/orchardpools','POST','2020-04-08 08:56:56','2020-04-08 08:56:56',NULL),
(24,'Created apgadm/search-users','Registered',1,'http://pools.apg/apgadm/search-users','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/orchardpools','POST','2020-04-08 08:57:14','2020-04-08 08:57:14',NULL),
(25,'Viewed apgadm/users/create','Registered',1,'http://pools.apg/apgadm/users/create','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 09:01:13','2020-04-08 09:01:13',NULL),
(26,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-08 13:33:21','2020-04-08 13:33:21',NULL),
(27,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-09 04:32:49','2020-04-09 04:32:49',NULL),
(28,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-09 04:33:45','2020-04-09 04:33:45',NULL),
(29,'Viewed apgadm/profile/hagenes.ona','Registered',1,'http://pools.apg/apgadm/profile/hagenes.ona','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/numbers','GET','2020-04-09 05:37:46','2020-04-09 05:37:46',NULL),
(30,'Viewed apgadm/profile/hagenes.ona/edit','Registered',1,'http://pools.apg/apgadm/profile/hagenes.ona/edit','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-09 05:38:07','2020-04-09 05:38:07',NULL),
(31,'Edited apgadm/profile/1/updateUserAccount','Registered',1,'http://pools.apg/apgadm/profile/1/updateUserAccount','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/profile/hagenes.ona/edit','PUT','2020-04-09 05:38:34','2020-04-09 05:38:34',NULL),
(32,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-09 05:38:55','2020-04-09 05:38:55',NULL),
(33,'Viewed apgadm/profile/admin','Registered',1,'http://pools.apg/apgadm/profile/admin','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','GET','2020-04-09 05:39:10','2020-04-09 05:39:10',NULL),
(34,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-09 10:28:52','2020-04-09 10:28:52',NULL),
(35,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-09 10:28:54','2020-04-09 10:28:54',NULL),
(36,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:08:17','2020-04-10 04:08:17',NULL),
(37,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:08:51','2020-04-10 04:08:51',NULL),
(38,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:17:58','2020-04-10 04:17:58',NULL),
(39,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 04:18:08','2020-04-10 04:18:08',NULL),
(40,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:18:24','2020-04-10 04:18:24',NULL),
(41,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:22:16','2020-04-10 04:22:16',NULL),
(42,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 04:22:22','2020-04-10 04:22:22',NULL),
(43,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:22:44','2020-04-10 04:22:44',NULL),
(44,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:26:41','2020-04-10 04:26:41',NULL),
(45,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 04:26:49','2020-04-10 04:26:49',NULL),
(46,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:27:04','2020-04-10 04:27:04',NULL),
(47,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:28:14','2020-04-10 04:28:14',NULL),
(48,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/orchardpools','POST','2020-04-10 04:28:46','2020-04-10 04:28:46',NULL),
(49,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:35:03','2020-04-10 04:35:03',NULL),
(50,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:35:48','2020-04-10 04:35:48',NULL),
(51,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 04:35:55','2020-04-10 04:35:55',NULL),
(52,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:38:31','2020-04-10 04:38:31',NULL),
(53,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:39:08','2020-04-10 04:39:08',NULL),
(54,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 04:39:15','2020-04-10 04:39:15',NULL),
(55,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:39:25','2020-04-10 04:39:25',NULL),
(56,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:40:51','2020-04-10 04:40:51',NULL),
(57,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:41:43','2020-04-10 04:41:43',NULL),
(58,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 04:41:50','2020-04-10 04:41:50',NULL),
(59,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:42:00','2020-04-10 04:42:00',NULL),
(60,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 04:54:33','2020-04-10 04:54:33',NULL),
(61,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 04:54:41','2020-04-10 04:54:41',NULL),
(62,'Failed Login Attempt','Guest',NULL,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:54:53','2020-04-10 04:54:53',NULL),
(63,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:55:04','2020-04-10 04:55:04',NULL),
(64,'Viewed apgadm/profile/admin','Registered',1,'http://pools.apg/apgadm/profile/admin','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','GET','2020-04-10 04:55:47','2020-04-10 04:55:47',NULL),
(65,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/profile/admin','POST','2020-04-10 04:55:54','2020-04-10 04:55:54',NULL),
(66,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 04:56:15','2020-04-10 04:56:15',NULL),
(67,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 05:02:06','2020-04-10 05:02:06',NULL),
(68,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 05:02:24','2020-04-10 05:02:24',NULL),
(69,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 05:02:34','2020-04-10 05:02:34',NULL),
(70,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 05:02:51','2020-04-10 05:02:51',NULL),
(71,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/orchardpools','POST','2020-04-10 05:48:06','2020-04-10 05:48:06',NULL),
(72,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 05:48:20','2020-04-10 05:48:20',NULL),
(73,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 05:50:28','2020-04-10 05:50:28',NULL),
(74,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 05:51:17','2020-04-10 05:51:17',NULL),
(75,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 05:51:29','2020-04-10 05:51:29',NULL),
(76,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 05:52:47','2020-04-10 05:52:47',NULL),
(77,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 05:54:29','2020-04-10 05:54:29',NULL),
(78,'Logged Out','Registered',1,'http://pools.apg/logout','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm/home','POST','2020-04-10 05:54:39','2020-04-10 05:54:39',NULL),
(79,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 05:54:52','2020-04-10 05:54:52',NULL),
(80,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 07:01:16','2020-04-10 07:01:16',NULL),
(81,'Logged In','Registered',1,'http://pools.apg/apgadm','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9','http://pools.apg/apgadm','POST','2020-04-10 09:09:17','2020-04-10 09:09:17',NULL),
(82,'Viewed apgadm/home','Registered',1,'http://pools.apg/apgadm/home','192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','en-US,en;q=0.9',NULL,'GET','2020-04-10 09:10:19','2020-04-10 09:10:19',NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2016_01_15_105324_create_roles_table',1),
(4,'2016_01_15_114412_create_role_user_table',1),
(5,'2016_01_26_115212_create_permissions_table',1),
(6,'2016_01_26_115523_create_permission_role_table',1),
(7,'2016_02_09_132439_create_permission_user_table',1),
(8,'2017_03_09_082449_create_social_logins_table',1),
(9,'2017_03_09_082526_create_activations_table',1),
(10,'2017_03_20_213554_create_themes_table',1),
(11,'2017_03_21_042918_create_profiles_table',1),
(12,'2017_11_04_103444_create_laravel_logger_activity_table',1),
(13,'2017_12_09_070937_create_two_step_auth_table',1),
(14,'2019_02_19_032636_create_laravel_blocker_types_table',1),
(15,'2019_02_19_045158_create_laravel_blocker_table',1),
(16,'2019_08_19_000000_create_failed_jobs_table',1),
(17,'2020_04_07_094105_create_sessions_table',1),
(18,'2020_04_07_094215_create_cache_table',1);

/*Table structure for table `orchardpools_consolation` */

DROP TABLE IF EXISTS `orchardpools_consolation`;

CREATE TABLE `orchardpools_consolation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(6) DEFAULT NULL,
  `show` tinyint(1) DEFAULT NULL,
  `prize` int(11) DEFAULT NULL,
  `draw_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `orchardpools_consolation` */

insert  into `orchardpools_consolation`(`id`,`number`,`show`,`prize`,`draw_id`,`created_at`,`updated_at`) values 
(1,'879786',0,1,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(2,'790975',0,2,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(3,'837057',0,3,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(4,'395204',0,4,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(5,'220085',0,5,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(6,'688901',0,6,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(7,'252892',0,1,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(8,'346534',0,2,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(9,'478808',0,3,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(10,'934207',0,4,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(11,'408335',0,5,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(12,'905598',0,6,2,'2020-04-10 10:33:42','2020-04-10 10:33:42');

/*Table structure for table `orchardpools_draw` */

DROP TABLE IF EXISTS `orchardpools_draw`;

CREATE TABLE `orchardpools_draw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `orchardpools_draw` */

insert  into `orchardpools_draw`(`id`,`created_at`,`updated_at`) values 
(1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(2,'2020-04-10 10:33:42','2020-04-10 10:33:42');

/*Table structure for table `orchardpools_starter` */

DROP TABLE IF EXISTS `orchardpools_starter`;

CREATE TABLE `orchardpools_starter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(6) DEFAULT NULL,
  `show` tinyint(1) DEFAULT NULL,
  `prize` int(11) DEFAULT NULL,
  `draw_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `orchardpools_starter` */

insert  into `orchardpools_starter`(`id`,`number`,`show`,`prize`,`draw_id`,`created_at`,`updated_at`) values 
(1,'879786',0,1,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(2,'790975',0,2,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(3,'837057',0,3,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(4,'395204',0,4,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(5,'220085',0,5,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(6,'688901',0,6,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(7,'252892',0,1,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(8,'346534',0,2,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(9,'478808',0,3,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(10,'934207',0,4,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(11,'408335',0,5,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(12,'905598',0,6,2,'2020-04-10 10:33:42','2020-04-10 10:33:42');

/*Table structure for table `orchardpools_winner` */

DROP TABLE IF EXISTS `orchardpools_winner`;

CREATE TABLE `orchardpools_winner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(6) DEFAULT NULL,
  `show` tinyint(1) DEFAULT NULL,
  `prize` int(11) DEFAULT NULL,
  `draw_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `orchardpools_winner` */

insert  into `orchardpools_winner`(`id`,`number`,`show`,`prize`,`draw_id`,`created_at`,`updated_at`) values 
(1,'112233',0,1,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(2,'753371',0,2,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(3,'758668',0,3,1,'2020-04-10 10:27:44','2020-04-10 10:27:44'),
(4,'223344',0,1,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(5,'827090',0,2,2,'2020-04-10 10:33:42','2020-04-10 10:33:42'),
(6,'377689',0,3,2,'2020-04-10 10:33:42','2020-04-10 10:33:42');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permission_role` */

insert  into `permission_role`(`id`,`permission_id`,`role_id`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,1,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(2,2,1,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(3,3,1,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(4,4,1,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL);

/*Table structure for table `permission_user` */

DROP TABLE IF EXISTS `permission_user`;

CREATE TABLE `permission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_index` (`permission_id`),
  KEY `permission_user_user_id_index` (`user_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permission_user` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`slug`,`description`,`model`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Can View Users','view.users','Can view users','Permission','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(2,'Can Create Users','create.users','Can create new users','Permission','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(3,'Can Edit Users','edit.users','Can edit users','Permission','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(4,'Can Delete Users','delete.users','Can delete users','Permission','2020-04-08 05:01:48','2020-04-08 05:01:48',NULL);

/*Table structure for table `prize` */

DROP TABLE IF EXISTS `prize`;

CREATE TABLE `prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `prize` */

insert  into `prize`(`id`,`name`,`image`,`created_at`,`updated_at`) values 
(1,'1st','1st.png','2020-04-09 06:05:06','2020-04-09 06:05:06'),
(2,'2nd','2nd.png','2020-04-09 06:06:14','2020-04-09 06:06:14'),
(3,'3rd','3rd.png','2020-04-09 06:06:39','2020-04-09 06:06:39');

/*Table structure for table `profiles` */

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `theme_id` bigint(20) unsigned NOT NULL DEFAULT '1',
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `twitter_username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_theme_id_foreign` (`theme_id`),
  KEY `profiles_user_id_index` (`user_id`),
  CONSTRAINT `profiles_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`),
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `profiles` */

insert  into `profiles`(`id`,`user_id`,`theme_id`,`location`,`bio`,`twitter_username`,`github_username`,`avatar`,`avatar_status`,`created_at`,`updated_at`) values 
(1,1,1,NULL,NULL,NULL,NULL,NULL,0,'2020-04-08 05:01:49','2020-04-08 05:01:49'),
(2,2,1,NULL,NULL,NULL,NULL,NULL,0,'2020-04-08 05:01:49','2020-04-08 05:01:49');

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_user` */

insert  into `role_user`(`id`,`role_id`,`user_id`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,1,'2020-04-08 05:01:49','2020-04-08 05:01:49',NULL),
(2,2,2,'2020-04-08 05:01:49','2020-04-08 05:01:49',NULL);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`slug`,`description`,`level`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Admin','admin','Admin Role',5,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(2,'User','user','User Role',1,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(3,'Unverified','unverified','Unverified Role',0,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL);

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('Aws2uDtfXh2zaPq1tXV7oDXSOjqvgsfe6YXWIUli',NULL,'192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoia0d2cjdNSUFzT0pNVjg3WERGdWxGWVlVelYyS2E4azlLWmpGSDN3bSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9wb29scy5hcGciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1586520209),
('JswASCxL2jCBL7ZonAh5P0ywaDzgS8Fv9x5WCvpo',1,'192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWldrUk9QaGMxQkJ0M0htU2hsb0FWcVE3VXNtRk5ueE81dGFxbElwWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9wb29scy5hcGciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NzoibmV4dFVyaSI7czozNToiaHR0cDovL29yY2hhcmRwb29scy5hcGcvYXBnYWRtL2hvbWUiO30=',1586518792);

/*Table structure for table `social_logins` */

DROP TABLE IF EXISTS `social_logins`;

CREATE TABLE `social_logins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `provider` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `social_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_logins_user_id_index` (`user_id`),
  CONSTRAINT `social_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `social_logins` */

/*Table structure for table `themes` */

DROP TABLE IF EXISTS `themes`;

CREATE TABLE `themes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `taggable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taggable_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_name_unique` (`name`),
  UNIQUE KEY `themes_link_unique` (`link`),
  KEY `themes_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`),
  KEY `themes_id_index` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `themes` */

insert  into `themes`(`id`,`name`,`link`,`notes`,`status`,`taggable_type`,`taggable_id`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Default','null',NULL,1,'theme',1,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(2,'Darkly','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/darkly/bootstrap.min.css',NULL,1,'theme',2,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(3,'Cyborg','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/cyborg/bootstrap.min.css',NULL,1,'theme',3,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(4,'Cosmo','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/cosmo/bootstrap.min.css',NULL,1,'theme',4,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(5,'Cerulean','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/cerulean/bootstrap.min.css',NULL,1,'theme',5,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(6,'Flatly','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/flatly/bootstrap.min.css',NULL,1,'theme',6,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(7,'Journal','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/journal/bootstrap.min.css',NULL,1,'theme',7,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(8,'Lumen','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/lumen/bootstrap.min.css',NULL,1,'theme',8,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(9,'Paper','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/paper/bootstrap.min.css',NULL,1,'theme',9,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(10,'Readable','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/readable/bootstrap.min.css',NULL,1,'theme',10,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(11,'Sandstone','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/sandstone/bootstrap.min.css',NULL,1,'theme',11,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(12,'Simplex','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/simplex/bootstrap.min.css',NULL,1,'theme',12,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(13,'Slate','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/slate/bootstrap.min.css',NULL,1,'theme',13,'2020-04-08 05:01:48','2020-04-08 05:01:48',NULL),
(14,'Spacelab','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/spacelab/bootstrap.min.css',NULL,1,'theme',14,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(15,'Superhero','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/superhero/bootstrap.min.css',NULL,1,'theme',15,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(16,'United','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/united/bootstrap.min.css',NULL,1,'theme',16,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(17,'Yeti','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/yeti/bootstrap.min.css',NULL,1,'theme',17,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(18,'Bootstrap 4.3.1','https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',NULL,1,'theme',18,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(19,'Materialize','https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.css',NULL,1,'theme',19,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(20,'Material Design for Bootstrap (MDB) 4.8.7','https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.7/css/mdb.css',NULL,1,'theme',20,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(21,'mdbootstrap','https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.3.1/css/mdb.min.css',NULL,1,'theme',21,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(22,'Litera','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/litera/bootstrap.min.css',NULL,1,'theme',22,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(23,'Lux','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/lux/bootstrap.min.css',NULL,1,'theme',23,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(24,'Materia','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/materia/bootstrap.min.css',NULL,1,'theme',24,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(25,'Minty','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/minty/bootstrap.min.css',NULL,1,'theme',25,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(26,'Pulse','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/pulse/bootstrap.min.css',NULL,1,'theme',26,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(27,'Sketchy','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/sketchy/bootstrap.min.css',NULL,1,'theme',27,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL),
(28,'Solar','https://maxcdn.bootstrapcdn.com/bootswatch/4.3.1/solar/bootstrap.min.css',NULL,1,'theme',28,'2020-04-08 05:01:48','2020-04-08 05:01:49',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signup_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signup_confirmation_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signup_sm_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`first_name`,`last_name`,`email`,`email_verified_at`,`password`,`remember_token`,`activated`,`token`,`signup_ip_address`,`signup_confirmation_ip_address`,`signup_sm_ip_address`,`admin_ip_address`,`updated_ip_address`,`deleted_ip_address`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','Jazz','Plunker','admin@admin.com',NULL,'$2y$10$my.pGk7HJ8ayYp8z2qLXr.FIut.bXbHxnoHjFRXZKNCxyqucY5uOO',NULL,1,'G766GZHwPP9m86QyaHOMjllMLNuGB29ICj0xO9NlLbJ8B3C09Bzf8NwwQ3es4MfG',NULL,'29.172.228.201',NULL,'115.13.247.209','192.168.10.1',NULL,'2020-04-08 05:01:49','2020-04-09 05:38:35',NULL),
(2,'jmayer','Garrison','Turcotte','user@user.com',NULL,'$2y$10$v8M.T0sfiYyhH8LRc9IPdekigpWL2mfV4GK/m68qSZ9BF6jUMLiF2',NULL,1,'ScYDIf4zBfFyBpO1S1NAtHbdbEu0K47c4K9qcjqSSMlD9DhamSSoNXECwVCp21MP','241.102.255.18','244.81.34.117',NULL,NULL,NULL,NULL,'2020-04-08 05:01:49','2020-04-08 05:01:49',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
