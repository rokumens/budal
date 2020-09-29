/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - apgdb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `activity_log` */

DROP TABLE IF EXISTS `activity_log`;

CREATE TABLE `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_log_log_name_index` (`log_name`),
  KEY `subject` (`subject_id`,`subject_type`),
  KEY `causer` (`causer_id`,`causer_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `activity_log` */

/*Table structure for table `assigned` */

DROP TABLE IF EXISTS `assigned`;

CREATE TABLE `assigned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `assigned` */

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `campaign_result` */

DROP TABLE IF EXISTS `campaign_result`;

CREATE TABLE `campaign_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `campaign_result` */

insert  into `campaign_result`(`id`,`name`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Interest (Player)','2020-03-04 12:17:04','2020-03-04 12:17:04',NULL),
(2,'Not Interest (Bukan Player)','2020-03-04 12:17:04','2020-03-04 12:17:04',NULL),
(3,'Unknown (Tidak Diketahui)','2020-03-04 12:17:04','2020-03-04 12:17:04',NULL);

/*Table structure for table `category_game` */

DROP TABLE IF EXISTS `category_game`;

CREATE TABLE `category_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `category_game` */

insert  into `category_game`(`id`,`name`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Sportsbook','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL),
(2,'Live Casino','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL),
(3,'Casino Games','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL),
(4,'Tembak Ikan','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL),
(5,'Togel','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL),
(6,'Poker/P2P','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL),
(7,'Slots','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL),
(8,'Whitelabel Umum','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL),
(9,'Ikan Kuning','2020-03-04 11:35:57','2020-03-04 11:35:57',NULL);

/*Table structure for table `category_web` */

DROP TABLE IF EXISTS `category_web`;

CREATE TABLE `category_web` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `category_web` */

insert  into `category_web`(`id`,`name`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Web Agent','2020-03-04 11:38:59','2020-03-04 11:38:59',NULL),
(2,'Whitelabel Umum','2020-03-04 11:38:59','2020-03-04 11:38:59',NULL),
(3,'Whitelabel P2P','2020-03-04 11:38:59','2020-03-04 11:38:59',NULL),
(4,'Web Togel','2020-03-04 11:38:59','2020-03-04 11:38:59',NULL),
(5,'Web Tembak Ikan','2020-03-04 11:38:59','2020-03-04 11:38:59',NULL),
(6,'Web Slots','2020-03-04 11:38:59','2020-03-04 11:38:59',NULL);

/*Table structure for table `check` */

DROP TABLE IF EXISTS `check`;

CREATE TABLE `check` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `check` */

/*Table structure for table `connect_response` */

DROP TABLE IF EXISTS `connect_response`;

CREATE TABLE `connect_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `connect_response` */

insert  into `connect_response`(`id`,`name`,`description`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Active Call','Pembicaraan aktif dengan pelanggan','2020-03-04 11:00:04','2020-03-04 11:00:04',NULL),
(2,'Blocked','Orangnya memblokir nomor telp perusahaan','2020-03-04 11:00:04','2020-03-04 11:00:04',NULL),
(3,'Line Busy','Jaringan sedang sibuk, orangnya lagi online telepon','2020-03-04 11:00:04','2020-03-04 11:00:04',NULL),
(4,'Mailbox','Hpnya di forward ke mailbox atau sedang tidak ada jaringan','2020-03-04 11:00:04','2020-03-04 11:00:04',NULL),
(5,'Tidak Diangkat','Telepon nyambung tapi belum di angkat','2020-03-04 11:00:04','2020-03-04 11:00:04',NULL),
(6,'Tidak Terdaftar','Nomor sudah hangus','2020-03-04 11:00:04','2020-03-04 11:00:04',NULL),
(7,'Tidak Aktif','Hpnya mati karena tidak ada battery (low batt)','2020-03-04 11:00:04','2020-03-04 11:00:04',NULL),
(8,'Rejected','Orangnya menolak untuk angkat telepon','2020-03-04 11:00:04','2020-03-04 11:00:04',NULL);

/*Table structure for table `constant_yesno` */

DROP TABLE IF EXISTS `constant_yesno`;

CREATE TABLE `constant_yesno` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `constant_yesno` */

insert  into `constant_yesno`(`id`,`value`,`name`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,'Yes','2020-03-04 10:01:57','2020-03-04 10:01:57',NULL),
(2,0,'No','2020-03-04 10:01:57','2020-03-04 10:01:57',NULL);

/*Table structure for table `contacted` */

DROP TABLE IF EXISTS `contacted`;

CREATE TABLE `contacted` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `contacted` */

/*Table structure for table `icons` */

DROP TABLE IF EXISTS `icons`;

CREATE TABLE `icons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `icons` */

insert  into `icons`(`id`,`name`,`icon`,`created_at`,`updated_at`) values 
(1,'Tao','fa-fas fa-adjust','2020-03-14 09:46:20','2020-03-14 09:46:20'),
(2,'Archive','fa-fas fa-archive','2020-03-14 09:46:20','2020-03-14 09:46:20'),
(3,'Right','fa-fas fa-angle-right','2020-03-14 09:46:20','2020-03-14 09:46:20'),
(4,'Home page','fa-fas fa-home','2020-03-14 09:46:20','2020-03-14 09:46:20');

/*Table structure for table `index_master_numbers` */

DROP TABLE IF EXISTS `index_master_numbers`;

CREATE TABLE `index_master_numbers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `index_master_numbers` */

/*Table structure for table `interested` */

DROP TABLE IF EXISTS `interested`;

CREATE TABLE `interested` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `interested` */

/*Table structure for table `master_numbers` */

DROP TABLE IF EXISTS `master_numbers`;

CREATE TABLE `master_numbers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connect_response_by_cs` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campaign_result` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_action_old` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note_contacted` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_assigned` tinyint(1) NOT NULL DEFAULT 0,
  `is_contacted` tinyint(1) NOT NULL DEFAULT 0,
  `assign_to` int(11) DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `assigned_date` datetime DEFAULT NULL,
  `contacted_date` datetime DEFAULT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `index_id` int(11) NOT NULL,
  `next_action_interested` int(11) DEFAULT NULL,
  `next_action_registered` int(11) DEFAULT NULL,
  `contacted_times` int(11) NOT NULL DEFAULT 0,
  `contacted_by` int(11) DEFAULT NULL,
  `is_interested` tinyint(1) NOT NULL DEFAULT 0,
  `note_interested` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deposit` tinyint(1) NOT NULL DEFAULT 0,
  `deposit_by` int(11) DEFAULT NULL,
  `deposit_date` datetime DEFAULT NULL,
  `is_registered` tinyint(1) NOT NULL DEFAULT 0,
  `registered_by` int(11) DEFAULT NULL,
  `note_registered` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registered_date` datetime DEFAULT NULL,
  `assigned_times` int(11) NOT NULL DEFAULT 0,
  `check_1_1` int(11) DEFAULT NULL COMMENT 'check by leader',
  `check_1_2` datetime DEFAULT NULL COMMENT 'check date by leader',
  `check_1_3` int(11) DEFAULT NULL COMMENT 'check connect response by leader',
  `check_1_4` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'check note by leader',
  PRIMARY KEY (`id`),
  KEY `assign_to` (`assign_to`),
  KEY `assign_by` (`assigned_by`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `master_numbers` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(26,'2020_02_23_184322_create_new_numbers_table',13),
(28,'2020_02_24_144357_create_assigned_table',13),
(29,'2020_02_24_165039_create_contacted_table',13),
(31,'2020_02_25_115151_create_registered_table',13),
(32,'2020_02_25_115354_create_check_table',13),
(33,'2020_02_25_115547_create_reassign_table',13),
(34,'2020_02_25_115858_create_trash_table',13),
(35,'2020_02_25_141102_create_players_table',13),
(49,'2020_02_27_193956_create_interested_table',18),
(53,'2020_02_23_202951_create_index_master_numbers_table',21),
(62,'2020_03_04_123644_create_campaign_result_table',23),
(64,'2020_03_04_123644_create_category_web_table',23),
(65,'2020_03_04_123644_create_connect_response_table',23),
(66,'2020_03_04_123644_create_constant_yesno_table',23),
(67,'2020_03_04_123644_create_next_action_table',23),
(68,'2020_03_04_123644_create_category_game_table',24),
(69,'2020_03_04_225905_create_settings_table',25),
(70,'2020_03_05_191641_alter_items_to_master_numbers',26),
(71,'2020_03_20_214046_create_users_table',29),
(72,'2020_03_18_022011_add_deleted_at_to_users_table',28),
(73,'2020_03_20_214046_create_icons_table',29),
(74,'2020_03_20_214046_create_model_has_permissions_table',29),
(75,'2020_03_20_214046_create_model_has_roles_table',29),
(76,'2020_03_20_214046_create_permissions_table',29),
(77,'2020_03_20_214046_create_roles_table',29),
(78,'2020_03_20_214046_create_role_has_permissions_table',29),
(80,'2020_03_20_214047_add_foreign_keys_to_model_has_permissions_table',29),
(81,'2020_03_20_214047_add_foreign_keys_to_model_has_roles_table',29),
(82,'2020_03_20_214047_add_foreign_keys_to_role_has_permissions_table',29),
(83,'2020_03_22_194610_create_sessions_table',30),
(84,'2020_03_22_201730_create_cache_table',31),
(85,'2020_08_01_231627_create_notifications_table',32);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values 
(1,'App\\Models\\BackpackUser',1),
(1,'App\\Models\\BackpackUser',39),
(1,'App\\Models\\BackpackUser',40),
(1,'App\\Models\\BackpackUser',59),
(1,'App\\Models\\BackpackUser',79),
(1,'App\\Models\\BackpackUser',83),
(1,'App\\Models\\BackpackUser',84),
(1,'App\\Models\\BackpackUser',135),
(2,'App\\Models\\BackpackUser',3),
(2,'App\\Models\\BackpackUser',19),
(2,'App\\Models\\BackpackUser',44),
(2,'App\\Models\\BackpackUser',58),
(2,'App\\Models\\BackpackUser',61),
(3,'App\\Models\\BackpackUser',2),
(3,'App\\Models\\BackpackUser',29),
(3,'App\\Models\\BackpackUser',32),
(3,'App\\Models\\BackpackUser',33),
(3,'App\\Models\\BackpackUser',46),
(3,'App\\Models\\BackpackUser',47),
(3,'App\\Models\\BackpackUser',56),
(3,'App\\Models\\BackpackUser',60),
(3,'App\\Models\\BackpackUser',62),
(3,'App\\Models\\BackpackUser',63),
(3,'App\\Models\\BackpackUser',64),
(3,'App\\Models\\BackpackUser',66),
(3,'App\\Models\\BackpackUser',67),
(3,'App\\Models\\BackpackUser',68),
(3,'App\\Models\\BackpackUser',69),
(3,'App\\Models\\BackpackUser',71),
(3,'App\\Models\\BackpackUser',72),
(3,'App\\Models\\BackpackUser',75),
(3,'App\\Models\\BackpackUser',77),
(3,'App\\Models\\BackpackUser',80),
(3,'App\\Models\\BackpackUser',81),
(3,'App\\Models\\BackpackUser',82),
(3,'App\\Models\\BackpackUser',133),
(3,'App\\Models\\BackpackUser',134);

/*Table structure for table `new_numbers` */

DROP TABLE IF EXISTS `new_numbers`;

CREATE TABLE `new_numbers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `new_numbers` */

/*Table structure for table `next_action` */

DROP TABLE IF EXISTS `next_action`;

CREATE TABLE `next_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `next_action` */

insert  into `next_action`(`id`,`name`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Follow up by WA','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(2,'Follow up by Telegram','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(3,'Follow up by Wechat','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(4,'Follow up by Skype','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(5,'Follow up by Facebook','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(6,'Follow up by Signal','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(7,'Follow up by Line','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(8,'Follow up by SMS','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(9,'Follow up by Instagram','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(10,'Follow up by Viber','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(11,'Follow up by BeeTalk','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(12,'Follow up by Twitter','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(13,'Follow up by Youtube','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL),
(14,'Follow up by Web Livechat','2020-03-04 12:19:02','2020-03-04 12:19:02',NULL);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `notifications` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values 
(4,'manage-users','backpack','2020-03-14 09:46:21','2020-03-18 12:24:46'),
(5,'manage-roles','backpack','2020-03-14 09:46:21','2020-03-18 12:24:35'),
(6,'manage-permissions','backpack','2020-03-14 09:46:21','2020-03-18 12:24:22'),
(10,'menu-upload','backpack','2020-03-14 10:43:09','2020-03-18 07:41:59'),
(12,'menu-newnumbers','backpack','2020-03-14 12:51:49','2020-03-18 05:57:47'),
(13,'list-interested-own','backpack','2020-03-17 10:47:33','2020-03-18 07:10:46'),
(14,'change-cs-assigned','backpack','2020-03-17 10:48:16','2020-03-17 10:48:16'),
(15,'menu-check','backpack','2020-03-18 03:50:06','2020-03-18 07:46:33'),
(16,'menu-reassign','backpack','2020-03-18 03:50:18','2020-03-18 07:46:12'),
(17,'view-assigned','backpack','2020-03-18 04:13:24','2020-03-18 04:13:24'),
(18,'edit-assigned','backpack','2020-03-18 04:35:26','2020-03-18 06:02:30'),
(19,'menu-assigned','backpack','2020-03-18 04:37:34','2020-03-18 05:58:12'),
(20,'list-assigned-own','backpack','2020-03-18 05:18:10','2020-03-18 07:10:17'),
(21,'menu-contacted','backpack','2020-03-18 05:28:48','2020-03-18 05:52:31'),
(22,'view-contacted','backpack','2020-03-18 06:03:46','2020-03-18 06:03:46'),
(23,'edit-contacted','backpack','2020-03-18 06:04:09','2020-03-18 06:06:13'),
(24,'menu-interested','backpack','2020-03-18 06:19:15','2020-03-18 06:19:15'),
(25,'change-cs-contacted','backpack','2020-03-18 06:42:32','2020-03-18 06:42:32'),
(26,'view-interested','backpack','2020-03-18 06:59:19','2020-03-18 06:59:19'),
(27,'edit-interested','backpack','2020-03-18 06:59:27','2020-03-18 06:59:27'),
(28,'change-cs-interested','backpack','2020-03-18 07:05:56','2020-03-18 07:05:56'),
(29,'list-interested-all','backpack','2020-03-18 07:09:55','2020-03-21 16:40:15'),
(30,'list-contacted-own','backpack','2020-03-18 07:12:06','2020-03-18 07:12:06'),
(31,'menu-registered','backpack','2020-03-18 07:19:51','2020-03-18 07:19:51'),
(32,'list-registered-own','backpack','2020-03-18 07:35:31','2020-03-18 07:35:31'),
(33,'view-registered','backpack','2020-03-18 07:36:01','2020-03-18 07:36:01'),
(34,'edit-registered','backpack','2020-03-18 07:36:10','2020-03-18 07:36:10'),
(35,'change-cs-registered','backpack','2020-03-18 07:38:10','2020-03-18 07:38:10'),
(36,'view-check','backpack','2020-03-18 08:05:59','2020-03-18 08:05:59'),
(37,'edit-check','backpack','2020-03-18 08:06:10','2020-03-18 08:06:10'),
(38,'change-cs-check','backpack','2020-03-18 08:06:19','2020-03-18 08:06:19'),
(39,'assign-cs','backpack','2020-03-18 08:32:43','2020-03-18 08:32:43'),
(40,'reassign-cs','backpack','2020-03-18 08:32:51','2020-03-18 08:32:51'),
(41,'view-reassign','backpack','2020-03-18 08:33:01','2020-03-18 08:33:01'),
(42,'menu-players','backpack','2020-03-18 08:41:18','2020-03-18 08:41:18'),
(43,'menu-trash','backpack','2020-03-18 08:45:07','2020-03-18 08:45:07'),
(44,'dashboard-all','backpack','2020-03-18 11:37:04','2020-03-18 11:37:04'),
(45,'menu-settings','backpack','2020-03-18 12:55:59','2020-03-18 18:24:42'),
(46,'demo-leader','backpack','2020-03-18 18:51:37','2020-03-18 18:51:37'),
(47,'demo-cs','backpack','2020-03-18 18:51:42','2020-03-20 15:53:12'),
(48,'menu-profile','backpack','2020-03-21 04:34:18','2020-03-21 04:34:18'),
(49,'list-assigned-all','backpack','2020-03-21 16:38:22','2020-03-21 16:38:22'),
(50,'list-contacted-all','backpack','2020-03-21 16:38:38','2020-03-22 17:14:05'),
(51,'list-registered-all','backpack','2020-03-21 16:41:14','2020-03-21 16:41:14');

/*Table structure for table `players` */

DROP TABLE IF EXISTS `players`;

CREATE TABLE `players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `connect_response_by_cs` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campaign_result` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_action_old` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note_contacted` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_assigned` tinyint(1) DEFAULT NULL,
  `	is_contacted` tinyint(1) DEFAULT NULL,
  `assign_to` int(11) DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `	assigned_date` datetime DEFAULT NULL,
  `contacted_date` datetime DEFAULT NULL,
  `	category_web` int(11) DEFAULT NULL,
  `	category_game` int(11) DEFAULT NULL,
  `	index` int(11) DEFAULT NULL,
  `next_action_interested` int(11) DEFAULT NULL,
  `	next_action_registered` int(11) DEFAULT NULL,
  `	contacted_times` int(11) DEFAULT NULL,
  `contacted_by` int(11) DEFAULT NULL,
  `is_interested` tinyint(1) DEFAULT NULL,
  `note_interested` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deposit` tinyint(4) DEFAULT NULL,
  `deposit_by` int(11) DEFAULT NULL,
  `deposit_date` datetime DEFAULT NULL,
  `	is_registered` tinyint(4) DEFAULT NULL,
  `registered_by` int(11) DEFAULT NULL,
  `note_registered` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registered_date` datetime DEFAULT NULL,
  `	assigned_times` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `players` */

/*Table structure for table `reassign` */

DROP TABLE IF EXISTS `reassign`;

CREATE TABLE `reassign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `reassign` */

/*Table structure for table `registered` */

DROP TABLE IF EXISTS `registered`;

CREATE TABLE `registered` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `registered` */

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `role_has_permissions` */

insert  into `role_has_permissions`(`permission_id`,`role_id`) values 
(4,1),
(5,1),
(6,1),
(10,1),
(12,1),
(12,2),
(13,1),
(13,2),
(13,3),
(14,1),
(14,2),
(15,1),
(15,2),
(16,1),
(16,2),
(17,1),
(17,2),
(18,1),
(18,2),
(18,3),
(19,1),
(19,2),
(19,3),
(20,1),
(20,2),
(20,3),
(21,1),
(21,2),
(21,3),
(22,1),
(22,2),
(23,1),
(23,2),
(23,3),
(24,1),
(24,2),
(24,3),
(25,1),
(25,2),
(26,1),
(26,2),
(27,1),
(27,2),
(27,3),
(28,1),
(28,2),
(29,1),
(29,2),
(30,1),
(30,2),
(30,3),
(31,1),
(31,2),
(31,3),
(32,1),
(32,2),
(32,3),
(33,1),
(33,2),
(34,1),
(34,2),
(34,3),
(35,1),
(35,2),
(36,1),
(36,2),
(37,1),
(37,2),
(38,1),
(38,2),
(39,1),
(39,2),
(40,1),
(40,2),
(41,1),
(41,2),
(42,1),
(42,2),
(43,1),
(43,2),
(44,1),
(44,2),
(45,1),
(46,1),
(46,2),
(47,1),
(47,2),
(47,3),
(48,1),
(48,2),
(48,3),
(49,1),
(49,2),
(50,1),
(50,2),
(51,1),
(51,2);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values 
(1,'manager','backpack','2020-03-14 09:46:21','2020-03-20 03:07:13'),
(2,'supervisor','backpack','2020-03-14 09:46:21','2020-03-20 03:07:26'),
(3,'user','backpack','2020-03-14 09:46:21','2020-03-20 03:07:36');

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('XWlPLWuKUjw4azOjOtPS8d4AWDI4lIs7AxBHLnKG',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibkJOZjhPYjR3VDNDekFOV1dhMTIyRGVJTWwyS09GWjVOTGRXYU0wYyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1601407305);

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contacted_times` int(11) NOT NULL,
  `assigned_times_previous` int(11) NOT NULL,
  `assigned_times_now` int(11) NOT NULL,
  `assigned_times_max` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `settings` */

insert  into `settings`(`id`,`contacted_times`,`assigned_times_previous`,`assigned_times_now`,`assigned_times_max`,`created_at`,`updated_at`) values 
(1,1,1,1,1,'2020-03-02 00:00:00','2020-03-04 12:54:13');

/*Table structure for table `trash` */

DROP TABLE IF EXISTS `trash`;

CREATE TABLE `trash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_numbers_id` int(11) NOT NULL,
  `category_web` int(11) NOT NULL DEFAULT 1,
  `category_game` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_web` (`category_web`),
  KEY `category_game` (`category_game`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `trash` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL COMMENT 'used for username',
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`nik`,`name`,`email`,`password`,`remember_token`,`created_by`,`updated_by`,`deleted_by`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'7380','luffy','7380@asiapowergames.com','$2y$10$d5B64ozYNd12b/ufhOQshuKl/AWft/hvpJ3q8fzClFBPZN90SPbKm','maqe2o2wLYoz6YWMx7pYUDQTiMEE5cziTLsMmZrdR4sVlLjviwNGLSMYuQep',NULL,1,NULL,'2019-01-30 18:59:59','2020-03-21 04:18:47',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
