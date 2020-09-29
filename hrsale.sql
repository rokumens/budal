/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - hrsale
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `api_amp_data` */

DROP TABLE IF EXISTS `api_amp_data`;

CREATE TABLE `api_amp_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` varchar(100) NOT NULL,
  `company_id` varchar(5) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `approved_by` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `imported_at` datetime NOT NULL,
  `unique_code` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_code` (`unique_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `api_amp_data` */

/*Table structure for table `api_form_111` */

DROP TABLE IF EXISTS `api_form_111`;

CREATE TABLE `api_form_111` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_111` */

/*Table structure for table `api_form_23760` */

DROP TABLE IF EXISTS `api_form_23760`;

CREATE TABLE `api_form_23760` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_23760` */

/*Table structure for table `api_form_31392` */

DROP TABLE IF EXISTS `api_form_31392`;

CREATE TABLE `api_form_31392` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_31392` */

/*Table structure for table `api_form_36882` */

DROP TABLE IF EXISTS `api_form_36882`;

CREATE TABLE `api_form_36882` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_36882` */

/*Table structure for table `api_form_37873` */

DROP TABLE IF EXISTS `api_form_37873`;

CREATE TABLE `api_form_37873` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_37873` */

/*Table structure for table `api_form_38780` */

DROP TABLE IF EXISTS `api_form_38780`;

CREATE TABLE `api_form_38780` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_38780` */

/*Table structure for table `api_form_40811` */

DROP TABLE IF EXISTS `api_form_40811`;

CREATE TABLE `api_form_40811` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_40811` */

/*Table structure for table `api_form_43677` */

DROP TABLE IF EXISTS `api_form_43677`;

CREATE TABLE `api_form_43677` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_43677` */

/*Table structure for table `api_form_43872` */

DROP TABLE IF EXISTS `api_form_43872`;

CREATE TABLE `api_form_43872` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_43872` */

/*Table structure for table `api_form_44037` */

DROP TABLE IF EXISTS `api_form_44037`;

CREATE TABLE `api_form_44037` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_44037` */

/*Table structure for table `api_form_44547` */

DROP TABLE IF EXISTS `api_form_44547`;

CREATE TABLE `api_form_44547` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_44547` */

/*Table structure for table `api_form_44693` */

DROP TABLE IF EXISTS `api_form_44693`;

CREATE TABLE `api_form_44693` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_44693` */

/*Table structure for table `api_form_44867` */

DROP TABLE IF EXISTS `api_form_44867`;

CREATE TABLE `api_form_44867` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(6) DEFAULT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `entry_number` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  `approval_status` varchar(11) NOT NULL DEFAULT 'pending',
  `approval_note` text DEFAULT NULL,
  `approval_note_all` text DEFAULT NULL,
  `harga_usd` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `harga_idr` decimal(62,2) DEFAULT NULL COMMENT 'Price',
  `url_view_entry` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `api_form_44867` */

/*Table structure for table `api_tmp_data` */

DROP TABLE IF EXISTS `api_tmp_data`;

CREATE TABLE `api_tmp_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `channel` varchar(10) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `approved_by` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `date_transaction` date NOT NULL,
  `imported_at` datetime NOT NULL,
  `unique_code` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_code` (`unique_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `api_tmp_data` */

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_sessions` */

/*Table structure for table `dayoff` */

DROP TABLE IF EXISTS `dayoff`;

CREATE TABLE `dayoff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `office_shift_id` int(11) NOT NULL,
  `dayoff_date` date NOT NULL,
  `dayoff_start_day` date NOT NULL,
  `dayoff_end_day` date NOT NULL,
  `employee_quota` int(1) NOT NULL DEFAULT 0,
  `have_quota` int(1) NOT NULL DEFAULT 1,
  `month_quota` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `approval_status` tinyint(2) NOT NULL COMMENT '	0=Pending, 1=Accepted, 2=Rejected	',
  `approval_1` int(11) NOT NULL,
  `approved_by_1` int(11) DEFAULT NULL,
  `approval_action_by_1` tinyint(2) NOT NULL,
  `approved_date_1` datetime DEFAULT NULL,
  `approval_2` int(11) NOT NULL,
  `approved_by_2` int(11) DEFAULT NULL,
  `approval_action_by_2` tinyint(2) NOT NULL,
  `approved_date_2` datetime DEFAULT NULL,
  `approval_3` int(11) NOT NULL,
  `approved_by_3` int(11) DEFAULT NULL,
  `approval_action_by_3` tinyint(2) NOT NULL,
  `approved_date_3` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `dayoff` */

/*Table structure for table `dayoff.backup` */

DROP TABLE IF EXISTS `dayoff.backup`;

CREATE TABLE `dayoff.backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `office_shift_id` int(11) NOT NULL,
  `dayoff_date` date NOT NULL,
  `dayoff_start_day` date NOT NULL,
  `dayoff_end_day` date NOT NULL,
  `employee_quota` int(1) NOT NULL DEFAULT 0,
  `have_quota` int(1) NOT NULL DEFAULT 1,
  `month_quota` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `dayoff.backup` */

/*Table structure for table `dayoff_quota` */

DROP TABLE IF EXISTS `dayoff_quota`;

CREATE TABLE `dayoff_quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_department_id` int(11) DEFAULT NULL,
  `office_shift_id` int(11) DEFAULT NULL,
  `quota_sunday` int(11) DEFAULT NULL,
  `quota_monday` int(11) DEFAULT NULL,
  `quota_tuesday` int(11) DEFAULT NULL,
  `quota_wednesday` int(11) DEFAULT NULL,
  `quota_thursday` int(11) DEFAULT NULL,
  `quota_friday` int(11) DEFAULT NULL,
  `quota_saturday` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `dayoff_quota` */

/*Table structure for table `fp_absensi_gadipakelagi` */

DROP TABLE IF EXISTS `fp_absensi_gadipakelagi`;

CREATE TABLE `fp_absensi_gadipakelagi` (
  `employee_id` int(10) unsigned NOT NULL,
  `attendance_date` date DEFAULT NULL,
  `clock_in` time DEFAULT NULL,
  `clock_out` time DEFAULT NULL,
  `break_out` time DEFAULT NULL,
  `break_in` time DEFAULT NULL,
  `waktu` datetime NOT NULL,
  `verifikasi` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `dikirim` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`employee_id`,`waktu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `fp_absensi_gadipakelagi` */

/*Table structure for table `fp_karyawan` */

DROP TABLE IF EXISTS `fp_karyawan`;

CREATE TABLE `fp_karyawan` (
  `id` int(10) unsigned NOT NULL,
  `nama` varchar(200) NOT NULL,
  `userid` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid_2` (`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `fp_karyawan` */

/*Table structure for table `fp_mesinfp` */

DROP TABLE IF EXISTS `fp_mesinfp`;

CREATE TABLE `fp_mesinfp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `fp_mesinfp` */

/*Table structure for table `fp_misc` */

DROP TABLE IF EXISTS `fp_misc`;

CREATE TABLE `fp_misc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` text NOT NULL,
  `nilai` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `fp_misc` */

/*Table structure for table `luffy_appraisal` */

DROP TABLE IF EXISTS `luffy_appraisal`;

CREATE TABLE `luffy_appraisal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reviewer_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `appraisal_task_id` int(11) NOT NULL,
  `final_point` int(5) NOT NULL DEFAULT 0,
  `final_amount` bigint(20) NOT NULL DEFAULT 0,
  `progress_percentage` int(5) NOT NULL DEFAULT 0,
  `grade_id` int(11) NOT NULL COMMENT 'grade_detail_id',
  `final_grade_id` int(11) NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `appraisal_status` int(11) NOT NULL,
  `delayed_days` int(5) NOT NULL DEFAULT 0,
  `overdue_days` int(5) NOT NULL DEFAULT 0,
  `approval_status` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `reviewer_id` (`reviewer_id`),
  KEY `sub_department_id` (`sub_department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_appraisal` */

/*Table structure for table `luffy_appraisal_approval_status` */

DROP TABLE IF EXISTS `luffy_appraisal_approval_status`;

CREATE TABLE `luffy_appraisal_approval_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `luffy_appraisal_approval_status` */

insert  into `luffy_appraisal_approval_status`(`id`,`name`) values 
(1,'Pending'),
(2,'Approved'),
(3,'Rejected');

/*Table structure for table `luffy_appraisal_report` */

DROP TABLE IF EXISTS `luffy_appraisal_report`;

CREATE TABLE `luffy_appraisal_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `total_bonus` bigint(20) NOT NULL DEFAULT 0,
  `period` date NOT NULL,
  `total_rewards_point` bigint(20) NOT NULL DEFAULT 0,
  `total_rewards_amount` bigint(20) NOT NULL DEFAULT 0,
  `total_punishment_point` bigint(20) NOT NULL DEFAULT 0,
  `total_punishment_amount` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_appraisal_report` */

/*Table structure for table `luffy_appraisal_status` */

DROP TABLE IF EXISTS `luffy_appraisal_status`;

CREATE TABLE `luffy_appraisal_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Pending TIDAK BOLEH diganti/dihapus',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `luffy_appraisal_status` */

insert  into `luffy_appraisal_status`(`id`,`name`) values 
(1,'Pending'),
(2,'In progress'),
(3,'Completed'),
(4,'Delayed'),
(5,'Overdue');

/*Table structure for table `luffy_appraisal_sub_task` */

DROP TABLE IF EXISTS `luffy_appraisal_sub_task`;

CREATE TABLE `luffy_appraisal_sub_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appraisal_task_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `point` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL COMMENT '1=qualified, 2=valid, 3=pending, 4=rejected',
  `file` varchar(255) NOT NULL,
  `file_hash` varchar(40) NOT NULL,
  `file_video` varchar(255) NOT NULL,
  `file_video_hash` varchar(40) NOT NULL,
  `url` text NOT NULL,
  `auditor_id` int(11) NOT NULL,
  `auditor_is_valid` int(11) NOT NULL DEFAULT 0,
  `auditor_is_reject` int(11) NOT NULL DEFAULT 0,
  `auditor_date` datetime DEFAULT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewer_is_qualified` int(11) NOT NULL DEFAULT 0,
  `reviewer_is_reject` int(11) NOT NULL DEFAULT 0,
  `reviewer_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `appraisal_task_id` (`appraisal_task_id`),
  KEY `file_hash` (`file_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_appraisal_sub_task` */

/*Table structure for table `luffy_appraisal_sub_task_status` */

DROP TABLE IF EXISTS `luffy_appraisal_sub_task_status`;

CREATE TABLE `luffy_appraisal_sub_task_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'DON''T Change 1=qualified, 2=valid, 3=pending, 4=rejected	',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `luffy_appraisal_sub_task_status` */

insert  into `luffy_appraisal_sub_task_status`(`id`,`name`) values 
(1,'Qualified'),
(2,'Valid'),
(3,'Pending'),
(4,'Rejected');

/*Table structure for table `luffy_appraisal_sub_task_title` */

DROP TABLE IF EXISTS `luffy_appraisal_sub_task_title`;

CREATE TABLE `luffy_appraisal_sub_task_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maintask_id` int(11) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `sub_task_title_name` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `maintask_id` (`maintask_id`) USING BTREE,
  KEY `sub_department_id` (`sub_department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_appraisal_sub_task_title` */

/*Table structure for table `luffy_appraisal_task` */

DROP TABLE IF EXISTS `luffy_appraisal_task`;

CREATE TABLE `luffy_appraisal_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sub_department_id` int(11) NOT NULL,
  `office_shift_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `sub_department_id` (`sub_department_id`),
  KEY `office_shift_id` (`office_shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_appraisal_task` */

/*Table structure for table `luffy_approver` */

DROP TABLE IF EXISTS `luffy_approver`;

CREATE TABLE `luffy_approver` (
  `approver_id` int(111) NOT NULL AUTO_INCREMENT,
  `approver` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`approver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `luffy_approver` */

/*Table structure for table `luffy_assign_punishment` */

DROP TABLE IF EXISTS `luffy_assign_punishment`;

CREATE TABLE `luffy_assign_punishment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `punishment_id` int(11) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `punishment_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_assign_punishment` */

/*Table structure for table `luffy_assign_rewards` */

DROP TABLE IF EXISTS `luffy_assign_rewards`;

CREATE TABLE `luffy_assign_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rewards_id` int(11) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `rewards_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `luffy_assign_rewards` */

insert  into `luffy_assign_rewards`(`id`,`rewards_id`,`sub_department_id`,`assigned_to`,`assigned_by`,`rewards_date`,`created_at`,`updated_at`) values 
(1,3,21,8,110,'2019-11-17','2019-11-17 17:40:07','2020-02-12 12:39:48');

/*Table structure for table `luffy_customer` */

DROP TABLE IF EXISTS `luffy_customer`;

CREATE TABLE `luffy_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_upload` varchar(20) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `appraisal_task_id` (`mobile_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_customer` */

/*Table structure for table `luffy_customer_duplicate` */

DROP TABLE IF EXISTS `luffy_customer_duplicate`;

CREATE TABLE `luffy_customer_duplicate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_upload` varchar(20) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `count_mobile_number` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appraisal_task_id` (`mobile_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_customer_duplicate` */

/*Table structure for table `luffy_dayoff_quota` */

DROP TABLE IF EXISTS `luffy_dayoff_quota`;

CREATE TABLE `luffy_dayoff_quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_dayoff_quota` */

/*Table structure for table `luffy_grade` */

DROP TABLE IF EXISTS `luffy_grade`;

CREATE TABLE `luffy_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minimum_daily_requirement` int(11) NOT NULL COMMENT 'column ini harus UNIQUE',
  `minimum_monthly_requirement` int(11) NOT NULL COMMENT 'column ini harus UNIQUE',
  `maintask_id` int(11) NOT NULL,
  `grade_detail_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `maintask_id` (`maintask_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_grade` */

/*Table structure for table `luffy_grade_detail` */

DROP TABLE IF EXISTS `luffy_grade_detail`;

CREATE TABLE `luffy_grade_detail` (
  `grade_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(10) NOT NULL,
  `grade_description` varchar(50) NOT NULL,
  `minimum_percentage` int(5) NOT NULL,
  `maximum_percentage` int(5) NOT NULL,
  PRIMARY KEY (`grade_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `luffy_grade_detail` */

insert  into `luffy_grade_detail`(`grade_detail_id`,`grade_name`,`grade_description`,`minimum_percentage`,`maximum_percentage`) values 
(1,'A+','Excellent',97,100),
(2,'A','Excellent',93,96),
(3,'A-','Excellent',90,92),
(4,'B+','Good',87,89),
(5,'B','Good',83,86),
(6,'B-','Good',80,82),
(7,'C+','Fair',77,79),
(8,'C','Fair',73,76),
(9,'C-','Fair',70,72),
(10,'D+','Passed',67,69),
(11,'D','Passed',63,66),
(12,'D-','Passed',60,62),
(13,'F','Failed',0,59);

/*Table structure for table `luffy_kpi_sales` */

DROP TABLE IF EXISTS `luffy_kpi_sales`;

CREATE TABLE `luffy_kpi_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_task` int(11) NOT NULL,
  `minimum_requirement` int(5) NOT NULL,
  `minimum_amount` bigint(20) NOT NULL,
  `value_percentage` decimal(5,4) NOT NULL,
  `value_amount` bigint(20) NOT NULL,
  `employee_bonus` bigint(20) NOT NULL,
  `total_deposit` bigint(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_kpi_sales` */

/*Table structure for table `luffy_kpi_sales_summary` */

DROP TABLE IF EXISTS `luffy_kpi_sales_summary`;

CREATE TABLE `luffy_kpi_sales_summary` (
  `date` date NOT NULL,
  `summary_employee_bonus` bigint(20) NOT NULL,
  `summary_total_deposit` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_kpi_sales_summary` */

/*Table structure for table `luffy_minimum_requirement` */

DROP TABLE IF EXISTS `luffy_minimum_requirement`;

CREATE TABLE `luffy_minimum_requirement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minimum_daily_requirement` int(11) NOT NULL COMMENT 'column ini harus UNIQUE',
  `minimum_monthly_requirement` int(11) NOT NULL COMMENT 'column ini harus UNIQUE',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_minimum_requirement` */

/*Table structure for table `luffy_punishment` */

DROP TABLE IF EXISTS `luffy_punishment`;

CREATE TABLE `luffy_punishment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `punishment_name` varchar(255) NOT NULL,
  `punishment_point` int(5) NOT NULL DEFAULT 0,
  `punishment_amount_id` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_punishment` */

/*Table structure for table `luffy_punishment_amount` */

DROP TABLE IF EXISTS `luffy_punishment_amount`;

CREATE TABLE `luffy_punishment_amount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `luffy_punishment_amount` */

insert  into `luffy_punishment_amount`(`id`,`amount`,`created_at`,`updated_at`) values 
(1,1000,'0000-00-00 00:00:00','2019-05-07 21:01:30');

/*Table structure for table `luffy_rewards` */

DROP TABLE IF EXISTS `luffy_rewards`;

CREATE TABLE `luffy_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rewards_name` varchar(255) NOT NULL,
  `rewards_point` int(5) NOT NULL DEFAULT 0,
  `rewards_amount_id` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `luffy_rewards` */

/*Table structure for table `luffy_rewards_amount` */

DROP TABLE IF EXISTS `luffy_rewards_amount`;

CREATE TABLE `luffy_rewards_amount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `luffy_rewards_amount` */

insert  into `luffy_rewards_amount`(`id`,`amount`,`created_at`,`updated_at`) values 
(1,1000,'0000-00-00 00:00:00','2019-05-07 20:58:29');

/*Table structure for table `rollingshift` */

DROP TABLE IF EXISTS `rollingshift`;

CREATE TABLE `rollingshift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period` int(11) DEFAULT NULL,
  `rollingshift_start_day` date NOT NULL,
  `rollingshift_end_day` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `office_shift_id` int(11) NOT NULL,
  `rollingshift_date` date NOT NULL,
  `is_leave_at` date DEFAULT NULL COMMENT 'use for employee Leave',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `rollingshift` */

/*Table structure for table `xin_advance_salaries` */

DROP TABLE IF EXISTS `xin_advance_salaries`;

CREATE TABLE `xin_advance_salaries` (
  `advance_salary_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `month_year` varchar(255) NOT NULL,
  `advance_amount` varchar(255) NOT NULL,
  `one_time_deduct` varchar(50) NOT NULL,
  `monthly_installment` varchar(255) NOT NULL,
  `total_paid` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` int(11) DEFAULT NULL,
  `is_deducted_from_salary` int(11) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`advance_salary_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_advance_salaries` */

/*Table structure for table `xin_announcements` */

DROP TABLE IF EXISTS `xin_announcements`;

CREATE TABLE `xin_announcements` (
  `announcement_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `company_id` int(111) NOT NULL,
  `department_id` int(111) NOT NULL,
  `published_by` int(111) NOT NULL,
  `summary` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`announcement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_announcements` */

/*Table structure for table `xin_assets` */

DROP TABLE IF EXISTS `xin_assets`;

CREATE TABLE `xin_assets` (
  `assets_id` int(111) NOT NULL AUTO_INCREMENT,
  `assets_category_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `company_asset_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` bigint(20) NOT NULL,
  `purchase_date` varchar(255) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `warranty_end_date` varchar(255) NOT NULL,
  `asset_note` text NOT NULL,
  `asset_image` varchar(255) NOT NULL,
  `asset_location` tinyint(5) NOT NULL,
  `is_working` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`assets_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_assets` */

/*Table structure for table `xin_assets_categories` */

DROP TABLE IF EXISTS `xin_assets_categories`;

CREATE TABLE `xin_assets_categories` (
  `assets_category_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`assets_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `xin_assets_categories` */

insert  into `xin_assets_categories`(`assets_category_id`,`company_id`,`category_name`,`created_at`) values 
(4,1,'FIXED ASSETS ( Aset Tetap )','12-07-2019 07:17:44'),
(5,1,'CURRENT ASSETS ( Aset Lancar )','12-07-2019 07:18:20'),
(6,1,'INTANGIBLE ASSETS ( Aset Tak Berwujud )','12-07-2019 07:20:01');

/*Table structure for table `xin_attendance_time` */

DROP TABLE IF EXISTS `xin_attendance_time`;

CREATE TABLE `xin_attendance_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `ip_fingerprint` varchar(20) NOT NULL,
  `fingerprint_location` varchar(255) NOT NULL,
  `attendance_date` varchar(255) NOT NULL,
  `clock_in` varchar(255) NOT NULL,
  `clock_out` varchar(255) NOT NULL,
  `break_out` varchar(255) DEFAULT NULL,
  `break_in` varchar(255) DEFAULT NULL,
  `late` varchar(255) NOT NULL,
  `waktu` datetime NOT NULL,
  `status` tinyint(3) NOT NULL,
  `clock_in_added_by` int(11) DEFAULT NULL,
  `approval_status` tinyint(1) NOT NULL COMMENT '0=Pending; 1=Approved; 2=Rejected',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `note_by_approver` text DEFAULT NULL,
  `manual_clock_created_at` datetime DEFAULT NULL,
  `verifikasi` tinyint(3) DEFAULT NULL,
  `clock_in_ip_address` varchar(255) NOT NULL,
  `clock_out_ip_address` varchar(255) NOT NULL,
  `clock_in_out` varchar(255) NOT NULL,
  `clock_in_latitude` varchar(150) NOT NULL,
  `clock_in_longitude` varchar(150) NOT NULL,
  `clock_out_latitude` varchar(150) NOT NULL,
  `clock_out_longitude` varchar(150) NOT NULL,
  `time_late` varchar(255) NOT NULL,
  `early_leaving` varchar(255) NOT NULL,
  `overtime` varchar(255) NOT NULL,
  `total_work` varchar(255) NOT NULL,
  `total_rest` varchar(255) NOT NULL,
  `attendance_status` varchar(100) NOT NULL,
  `will_calculated` tinyint(1) DEFAULT 0,
  `is_calculated` tinyint(1) DEFAULT 0,
  `each_break` int(3) DEFAULT 0,
  `total_break` int(3) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id` (`employee_id`,`waktu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_attendance_time` */

/*Table structure for table `xin_attendance_time.bak` */

DROP TABLE IF EXISTS `xin_attendance_time.bak`;

CREATE TABLE `xin_attendance_time.bak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `ip_fingerprint` varchar(20) NOT NULL,
  `fingerprint_location` varchar(255) NOT NULL,
  `attendance_date` varchar(255) NOT NULL,
  `clock_in` varchar(255) NOT NULL,
  `clock_out` varchar(255) NOT NULL,
  `break_out` varchar(255) DEFAULT NULL,
  `break_in` varchar(255) DEFAULT NULL,
  `waktu` datetime NOT NULL,
  `status` tinyint(3) NOT NULL,
  `clock_in_added_by` int(11) DEFAULT NULL,
  `approval_status` tinyint(1) NOT NULL COMMENT '0=Pending; 1=Approved; 2=Rejected',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `manual_clock_created_at` datetime DEFAULT NULL,
  `verifikasi` tinyint(3) DEFAULT NULL,
  `clock_in_ip_address` varchar(255) NOT NULL,
  `clock_out_ip_address` varchar(255) NOT NULL,
  `clock_in_out` varchar(255) NOT NULL,
  `clock_in_latitude` varchar(150) NOT NULL,
  `clock_in_longitude` varchar(150) NOT NULL,
  `clock_out_latitude` varchar(150) NOT NULL,
  `clock_out_longitude` varchar(150) NOT NULL,
  `time_late` varchar(255) NOT NULL,
  `early_leaving` varchar(255) NOT NULL,
  `overtime` varchar(255) NOT NULL,
  `total_work` varchar(255) NOT NULL,
  `total_rest` varchar(255) NOT NULL,
  `attendance_status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id` (`employee_id`,`waktu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_attendance_time.bak` */

/*Table structure for table `xin_award_type` */

DROP TABLE IF EXISTS `xin_award_type`;

CREATE TABLE `xin_award_type` (
  `award_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `award_type` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`award_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_award_type` */

insert  into `xin_award_type`(`award_type_id`,`company_id`,`award_type`,`created_at`) values 
(1,1,'Performer of the Year','22-03-2018 01:33:57');

/*Table structure for table `xin_awards` */

DROP TABLE IF EXISTS `xin_awards`;

CREATE TABLE `xin_awards` (
  `award_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(200) NOT NULL,
  `award_type_id` int(200) NOT NULL,
  `gift_item` varchar(200) NOT NULL,
  `cash_price` varchar(200) NOT NULL,
  `award_photo` varchar(255) NOT NULL,
  `award_month_year` varchar(200) NOT NULL,
  `award_information` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`award_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_awards` */

/*Table structure for table `xin_chat_messages` */

DROP TABLE IF EXISTS `xin_chat_messages`;

CREATE TABLE `xin_chat_messages` (
  `message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` varchar(40) NOT NULL DEFAULT '',
  `to_id` varchar(50) NOT NULL DEFAULT '',
  `message_frm` varchar(255) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `message_content` longtext NOT NULL,
  `message_date` varchar(255) DEFAULT NULL,
  `recd` tinyint(1) NOT NULL DEFAULT 0,
  `message_type` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_chat_messages` */

/*Table structure for table `xin_clients` */

DROP TABLE IF EXISTS `xin_clients`;

CREATE TABLE `xin_clients` (
  `client_id` int(111) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `client_username` varchar(255) NOT NULL,
  `client_password` varchar(255) NOT NULL,
  `client_profile` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `address_1` mediumtext NOT NULL,
  `address_2` mediumtext NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(111) NOT NULL,
  `is_active` int(11) NOT NULL,
  `last_logout_date` varchar(255) NOT NULL,
  `last_login_date` varchar(255) NOT NULL,
  `last_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_clients` */

/*Table structure for table `xin_companies` */

DROP TABLE IF EXISTS `xin_companies`;

CREATE TABLE `xin_companies` (
  `company_id` int(111) NOT NULL AUTO_INCREMENT,
  `type_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `trading_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_no` varchar(255) NOT NULL,
  `government_tax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `address_1` mediumtext NOT NULL,
  `address_2` mediumtext NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(111) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_companies` */

insert  into `xin_companies`(`company_id`,`type_id`,`name`,`trading_name`,`username`,`password`,`registration_no`,`government_tax`,`email`,`logo`,`contact_number`,`website_url`,`address_1`,`address_2`,`city`,`state`,`zipcode`,`country`,`is_active`,`created_by`,`created_at`,`updated_by`,`updated_at`,`deleted_by`,`deleted_at`) values 
(1,1,'-','-','-','','','','-','-','12345678','google.com','Manchester City 77','','London','London','888',229,0,1,'2018-05-22 00:00:00',0,NULL,0,NULL);

/*Table structure for table `xin_company_documents` */

DROP TABLE IF EXISTS `xin_company_documents`;

CREATE TABLE `xin_company_documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `license_name` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `license_number` varchar(255) NOT NULL,
  `notification_interval_1` int(5) NOT NULL,
  `notification_interval_satuan_1` varchar(10) NOT NULL,
  `notification_date_1` date NOT NULL,
  `notification_interval_2` int(5) NOT NULL,
  `notification_interval_satuan_2` varchar(10) NOT NULL,
  `notification_date_2` date NOT NULL,
  `document` varchar(255) NOT NULL,
  `is_sent_notification_1` int(1) DEFAULT 0,
  `is_sent_notification_2` int(1) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `xin_company_documents` */

/*Table structure for table `xin_company_info` */

DROP TABLE IF EXISTS `xin_company_info`;

CREATE TABLE `xin_company_info` (
  `company_info_id` int(111) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  `logo_second` varchar(255) NOT NULL,
  `sign_in_logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `website_url` mediumtext NOT NULL,
  `starting_year` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_contact` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_1` mediumtext NOT NULL,
  `address_2` mediumtext NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(111) NOT NULL,
  `updated_at` varchar(255) NOT NULL,
  PRIMARY KEY (`company_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `xin_company_info` */

insert  into `xin_company_info`(`company_info_id`,`logo`,`logo_second`,`sign_in_logo`,`favicon`,`website_url`,`starting_year`,`company_name`,`company_email`,`company_contact`,`contact_person`,`email`,`phone`,`address_1`,`address_2`,`city`,`state`,`zipcode`,`country`,`updated_at`) values 
(1,'logo_1520722747.png','logo2_1520609223.png','apg.png','favicon_1577448131.png','','','ASIA POWER GAMES','','','ROY','8000@asiapowergames.com','8559688785251','Address Line 1','Address Line 2','Citys','States','11461',229,'2017-05-20 12:05:53');

/*Table structure for table `xin_company_policy` */

DROP TABLE IF EXISTS `xin_company_policy`;

CREATE TABLE `xin_company_policy` (
  `policy_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`policy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_company_policy` */

insert  into `xin_company_policy`(`policy_id`,`company_id`,`title`,`description`,`created_by`,`created_at`,`updated_by`,`updated_at`) values 
(1,1,'Do','&lt;p&gt;&lt;ul&gt;&lt;li&gt;Bureaucrats are chosen in a process similar to that for selecting administrators. There are not very many bureaucrats. They have the technical ability to add or remove admin rights and approve or revoke \\&quot;bot\\&quot; privileges.&lt;/li&gt;&lt;li&gt;The Arbitration Committee is analogous to Wikipedia\\&#039;s supreme court. They deal with disputes that remain unresolved after other attempts at dispute resolution have failed. Members of this Committee are elected by the community and tend to be selected from among the pool of experienced admins.&lt;/li&gt;&lt;li&gt;Stewards hold the top echelon of community permissions. Stewards can do a few technical things, and one almost never hears much about them since they normally act only when a local admin or bureaucrat is not available, and hence almost never on the English Wikipedia. There are very few stewards.&lt;/li&gt;&lt;li&gt;Jimmy Wales, the founder of Wikipedia, has several special roles and privileges. In most instances, however, he does not expect to be treated differently than any other editor or administrator.&lt;/li&gt;&lt;li&gt;Unresolved disputes between editors, whether based upon behavior, editorial approach, or validity of content, can be addressed through the talk page of an article, through requesting comments from other editors or through Wikipedia\\&#039;s comprehensive dispute resolution process.&lt;/li&gt;&lt;li&gt;Abuse of user accounts, such as the creation of \\&quot;Internet sock puppets\\&quot; or solicitation of friends and other parties to enforce a non-neutral viewpoint or inappropriate consensus within a discussion, or to disrupt other Wikipedia processes in an annoying manner, are addressed through the sock puppet policy.&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;',1,'2018-02-28 00:00:00',NULL,'0000-00-00 00:00:00'),
(2,1,'Don\'t','&lt;p&gt;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;Bureaucrats are chosen in a process similar to that for selecting administrators. There are not very many bureaucrats. They have the technical ability to add or remove admin rights and approve or revoke \\\\\\&quot;bot\\\\\\&quot; privileges.&lt;/li&gt;&lt;li&gt;The Arbitration Committee is analogous to Wikipedia\\\\\\&#039;s supreme court. They deal with disputes that remain unresolved after other attempts at dispute resolution have failed. Members of this Committee are elected by the community and tend to be selected from among the pool of experienced admins.&lt;/li&gt;&lt;li&gt;Stewards hold the top echelon of community permissions. Stewards can do a few technical things, and one almost never hears much about them since they normally act only when a local admin or bureaucrat is not available, and hence almost never on the English Wikipedia. There are very few stewards.&lt;/li&gt;&lt;li&gt;Jimmy Wales, the founder of Wikipedia, has several special roles and privileges. In most instances, however, he does not expect to be treated differently than any other editor or administrator.&lt;/li&gt;&lt;li&gt;Unresolved disputes between editors, whether based upon behavior, editorial approach, or validity of content, can be addressed through the talk page of an article, through requesting comments from other editors or through Wikipedia\\\\\\&#039;s comprehensive dispute resolution process.&lt;/li&gt;&lt;li&gt;Abuse of user accounts, such as the creation of \\\\\\&quot;Internet sock puppets\\\\\\&quot; or solicitation of friends and other parties to enforce a non-neutral viewpoint or inappropriate consensus within a discussion, or to disrupt other Wikipedia processes in an annoying manner, are addressed through the sock puppet policy.&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;/p&gt;',35,'2019-12-13 00:00:00',NULL,'0000-00-00 00:00:00'),
(3,1,'Peraturan Perusahaan','&lt;p&gt;&lt;ul&gt;&lt;li&gt;In 1994, D\\&#039;Virgilio joined Kevin Gilbert\\&#039;s reformed band Giraffe for a one-off performance of the Genesis piece \\&quot;The Lamb Lies Down on Broadway\\&quot; at Progfest \\&#039;94. In 1995, he performed drums as part of Gilbert\\&#039;s touring band, Thud, which recorded a live album, Live at the Troubadour, released in 1999.&lt;/li&gt;&lt;li&gt;A lifelong fan of the progressive rock band Genesis, D\\&#039;Virgilio was given an opportunity by the band to replace Phil Collins on drums for their 1997 album Calling All Stations. D\\&#039;Virgilio split percussion duties with Nir Zidkyahu during work on the album.&lt;/li&gt;&lt;li&gt;D\\&#039;Virgilio had been a full member of the Mike Keneally Band from 2001 to 2004, playing on the tour supporting Keneally\\&#039;s 2000 album Dancing and later providing drums and vocals on the 2004 album Dog, as can be seen on the DVD included as part of the Dog Special Edition in both live as well as \\&quot;making-of\\&quot; studio footage.&lt;/li&gt;&lt;li&gt;D\\&#039;Virgilio\\&#039;s first solo album, Karma, was recorded in 2001 at Kevin Gilbert\\&#039;s former studio, Lawnmower and Garden Supplies Studio, in Pasadena.[2] The album included performances by Mike Keneally and Bryan Beller, D\\&#039;Virgilio\\&#039;s bandmates in The Mike Keneally Band.&lt;/li&gt;&lt;li&gt;D\\&#039;Virgilio filled in for Mark Zonder on Fates Warning\\&#039;s summer tour with Dream Theater and Queensrÿche in 2003. Zonder\\&#039;s prior commitments prevented him from taking part in the tour, and he ceased performing with the band following its 2005 release FWX due to a reported aversion to touring.&lt;/li&gt;&lt;li&gt;After guesting on three tracks on Big Big Train\\&#039;s 2007 album The Difference Machine, he was billed as a \\&quot;permanent guest\\&quot; on The Underfall Yard (2009) and subsequently joined the band as a full member, appearing on the 2010 EP Far Skies Deep Time, English Electric Part One (2012), English Electric Part Two (2013), the Wassail EP (2015), and most recently Folklore (2016), Grimspound (2017) and The Second Brightest Star (2017).&lt;/li&gt;&lt;li&gt;On July 26, 2011, D\\&#039;Virgilio released a solo EP called Pieces.[3] He performed a show in Quebec City, Canada performing the EP in its entirety with local musicians on the day of the album release.[4] On November 18, 2011, D\\&#039;Virgilio announced that he had left Spock\\&#039;s Beard, because of his work with Cirque du Soleil, \\&quot;It is very hard for me to write this, but as all good things come to an end at sometime or another, unfortunately I have to tell you all that my time with Spock\\&#039;s Beard has come to a close.&lt;/li&gt;&lt;li&gt;In early 2014, D\\&#039;Virgilio appeared on Strattman\\&#039;s album The Lie of the Beholder stating: \\&quot;Recording the drums for Roy\\&#039;s record was a total blast. I am really honored that he asked me to be a part of his new musical adventure. The record rocks and, from a drummer\\&#039;s perspective, I got to hit \\&#039;em hard and got challenged by the songs – 2 things drummers love.&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;',35,'2019-12-13 00:00:00',NULL,'0000-00-00 00:00:00');

/*Table structure for table `xin_company_type` */

DROP TABLE IF EXISTS `xin_company_type`;

CREATE TABLE `xin_company_type` (
  `type_id` int(111) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `xin_company_type` */

insert  into `xin_company_type`(`type_id`,`name`,`created_at`) values 
(1,'Corporation',''),
(2,'Exempt Organization',''),
(3,'Partnership',''),
(4,'Private Foundation',''),
(5,'Limited Liability Company','');

/*Table structure for table `xin_contract_type` */

DROP TABLE IF EXISTS `xin_contract_type`;

CREATE TABLE `xin_contract_type` (
  `contract_type_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`contract_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_contract_type` */

insert  into `xin_contract_type`(`contract_type_id`,`company_id`,`name`,`created_at`) values 
(1,1,'Permanent','05-04-2018 06:10:32');

/*Table structure for table `xin_countries` */

DROP TABLE IF EXISTS `xin_countries`;

CREATE TABLE `xin_countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(255) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_flag` varchar(255) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=utf8;

/*Data for the table `xin_countries` */

insert  into `xin_countries`(`country_id`,`country_code`,`country_name`,`country_flag`) values 
(1,'+93','Afghanistan','flag_1500831780.gif'),
(2,'+355','Albania','flag_1500831815.gif'),
(3,'DZ','Algeria',''),
(4,'DS','American Samoa',''),
(5,'AD','Andorra',''),
(6,'AO','Angola',''),
(7,'AI','Anguilla',''),
(8,'AQ','Antarctica',''),
(9,'AG','Antigua and Barbuda',''),
(10,'AR','Argentina',''),
(11,'AM','Armenia',''),
(12,'AW','Aruba',''),
(13,'AU','Australia',''),
(14,'AT','Austria',''),
(15,'AZ','Azerbaijan',''),
(16,'BS','Bahamas',''),
(17,'BH','Bahrain',''),
(18,'BD','Bangladesh',''),
(19,'BB','Barbados',''),
(20,'BY','Belarus',''),
(21,'BE','Belgium',''),
(22,'BZ','Belize',''),
(23,'BJ','Benin',''),
(24,'BM','Bermuda',''),
(25,'BT','Bhutan',''),
(26,'BO','Bolivia',''),
(27,'BA','Bosnia and Herzegovina',''),
(28,'BW','Botswana',''),
(29,'BV','Bouvet Island',''),
(30,'BR','Brazil',''),
(31,'IO','British Indian Ocean Territory',''),
(32,'BN','Brunei Darussalam',''),
(33,'BG','Bulgaria',''),
(34,'BF','Burkina Faso',''),
(35,'BI','Burundi',''),
(36,'KH','Cambodia',''),
(37,'CM','Cameroon',''),
(38,'CA','Canada',''),
(39,'CV','Cape Verde',''),
(40,'KY','Cayman Islands',''),
(41,'CF','Central African Republic',''),
(42,'TD','Chad',''),
(43,'CL','Chile',''),
(44,'CN','China',''),
(45,'CX','Christmas Island',''),
(46,'CC','Cocos (Keeling) Islands',''),
(47,'CO','Colombia',''),
(48,'KM','Comoros',''),
(49,'CG','Congo',''),
(50,'CK','Cook Islands',''),
(51,'CR','Costa Rica',''),
(52,'HR','Croatia (Hrvatska)',''),
(53,'CU','Cuba',''),
(54,'CY','Cyprus',''),
(55,'CZ','Czech Republic',''),
(56,'DK','Denmark',''),
(57,'DJ','Djibouti',''),
(58,'DM','Dominica',''),
(59,'DO','Dominican Republic',''),
(60,'TP','East Timor',''),
(61,'EC','Ecuador',''),
(62,'EG','Egypt',''),
(63,'SV','El Salvador',''),
(64,'GQ','Equatorial Guinea',''),
(65,'ER','Eritrea',''),
(66,'EE','Estonia',''),
(67,'ET','Ethiopia',''),
(68,'FK','Falkland Islands (Malvinas)',''),
(69,'FO','Faroe Islands',''),
(70,'FJ','Fiji',''),
(71,'FI','Finland',''),
(72,'FR','France',''),
(73,'FX','France, Metropolitan',''),
(74,'GF','French Guiana',''),
(75,'PF','French Polynesia',''),
(76,'TF','French Southern Territories',''),
(77,'GA','Gabon',''),
(78,'GM','Gambia',''),
(79,'GE','Georgia',''),
(80,'DE','Germany',''),
(81,'GH','Ghana',''),
(82,'GI','Gibraltar',''),
(83,'GK','Guernsey',''),
(84,'GR','Greece',''),
(85,'GL','Greenland',''),
(86,'GD','Grenada',''),
(87,'GP','Guadeloupe',''),
(88,'GU','Guam',''),
(89,'GT','Guatemala',''),
(90,'GN','Guinea',''),
(91,'GW','Guinea-Bissau',''),
(92,'GY','Guyana',''),
(93,'HT','Haiti',''),
(94,'HM','Heard and Mc Donald Islands',''),
(95,'HN','Honduras',''),
(96,'HK','Hong Kong',''),
(97,'HU','Hungary',''),
(98,'IS','Iceland',''),
(99,'IN','India',''),
(100,'IM','Isle of Man',''),
(101,'ID','Indonesia',''),
(102,'IR','Iran (Islamic Republic of)',''),
(103,'IQ','Iraq',''),
(104,'IE','Ireland',''),
(105,'IL','Israel',''),
(106,'IT','Italy',''),
(107,'CI','Ivory Coast',''),
(108,'JE','Jersey',''),
(109,'JM','Jamaica',''),
(110,'JP','Japan',''),
(111,'JO','Jordan',''),
(112,'KZ','Kazakhstan',''),
(113,'KE','Kenya',''),
(114,'KI','Kiribati',''),
(115,'KP','Korea, Democratic People\'s Republic of',''),
(116,'KR','Korea, Republic of',''),
(117,'XK','Kosovo',''),
(118,'KW','Kuwait',''),
(119,'KG','Kyrgyzstan',''),
(120,'LA','Lao People\'s Democratic Republic',''),
(121,'LV','Latvia',''),
(122,'LB','Lebanon',''),
(123,'LS','Lesotho',''),
(124,'LR','Liberia',''),
(125,'LY','Libyan Arab Jamahiriya',''),
(126,'LI','Liechtenstein',''),
(127,'LT','Lithuania',''),
(128,'LU','Luxembourg',''),
(129,'MO','Macau',''),
(130,'MK','Macedonia',''),
(131,'MG','Madagascar',''),
(132,'MW','Malawi',''),
(133,'MY','Malaysia',''),
(134,'MV','Maldives',''),
(135,'ML','Mali',''),
(136,'MT','Malta',''),
(137,'MH','Marshall Islands',''),
(138,'MQ','Martinique',''),
(139,'MR','Mauritania',''),
(140,'MU','Mauritius',''),
(141,'TY','Mayotte',''),
(142,'MX','Mexico',''),
(143,'FM','Micronesia, Federated States of',''),
(144,'MD','Moldova, Republic of',''),
(145,'MC','Monaco',''),
(146,'MN','Mongolia',''),
(147,'ME','Montenegro',''),
(148,'MS','Montserrat',''),
(149,'MA','Morocco',''),
(150,'MZ','Mozambique',''),
(151,'MM','Myanmar',''),
(152,'NA','Namibia',''),
(153,'NR','Nauru',''),
(154,'NP','Nepal',''),
(155,'NL','Netherlands',''),
(156,'AN','Netherlands Antilles',''),
(157,'NC','New Caledonia',''),
(158,'NZ','New Zealand',''),
(159,'NI','Nicaragua',''),
(160,'NE','Niger',''),
(161,'NG','Nigeria',''),
(162,'NU','Niue',''),
(163,'NF','Norfolk Island',''),
(164,'MP','Northern Mariana Islands',''),
(165,'NO','Norway',''),
(166,'OM','Oman',''),
(167,'PK','Pakistan',''),
(168,'PW','Palau',''),
(169,'PS','Palestine',''),
(170,'PA','Panama',''),
(171,'PG','Papua New Guinea',''),
(172,'PY','Paraguay',''),
(173,'PE','Peru',''),
(174,'PH','Philippines',''),
(175,'PN','Pitcairn',''),
(176,'PL','Poland',''),
(177,'PT','Portugal',''),
(178,'PR','Puerto Rico',''),
(179,'QA','Qatar',''),
(180,'RE','Reunion',''),
(181,'RO','Romania',''),
(182,'RU','Russian Federation',''),
(183,'RW','Rwanda',''),
(184,'KN','Saint Kitts and Nevis',''),
(185,'LC','Saint Lucia',''),
(186,'VC','Saint Vincent and the Grenadines',''),
(187,'WS','Samoa',''),
(188,'SM','San Marino',''),
(189,'ST','Sao Tome and Principe',''),
(190,'SA','Saudi Arabia',''),
(191,'SN','Senegal',''),
(192,'RS','Serbia',''),
(193,'SC','Seychelles',''),
(194,'SL','Sierra Leone',''),
(195,'SG','Singapore',''),
(196,'SK','Slovakia',''),
(197,'SI','Slovenia',''),
(198,'SB','Solomon Islands',''),
(199,'SO','Somalia',''),
(200,'ZA','South Africa',''),
(201,'GS','South Georgia South Sandwich Islands',''),
(202,'ES','Spain',''),
(203,'LK','Sri Lanka',''),
(204,'SH','St. Helena',''),
(205,'PM','St. Pierre and Miquelon',''),
(206,'SD','Sudan',''),
(207,'SR','Suriname',''),
(208,'SJ','Svalbard and Jan Mayen Islands',''),
(209,'SZ','Swaziland',''),
(210,'SE','Sweden',''),
(211,'CH','Switzerland',''),
(212,'SY','Syrian Arab Republic',''),
(213,'TW','Taiwan',''),
(214,'TJ','Tajikistan',''),
(215,'TZ','Tanzania, United Republic of',''),
(216,'TH','Thailand',''),
(217,'TG','Togo',''),
(218,'TK','Tokelau',''),
(219,'TO','Tonga',''),
(220,'TT','Trinidad and Tobago',''),
(221,'TN','Tunisia',''),
(222,'TR','Turkey',''),
(223,'TM','Turkmenistan',''),
(224,'TC','Turks and Caicos Islands',''),
(225,'TV','Tuvalu',''),
(226,'UG','Uganda',''),
(227,'UA','Ukraine',''),
(228,'AE','United Arab Emirates',''),
(229,'GB','United Kingdom',''),
(230,'US','United States',''),
(231,'UM','United States minor outlying islands',''),
(232,'UY','Uruguay',''),
(233,'UZ','Uzbekistan',''),
(234,'VU','Vanuatu',''),
(235,'VA','Vatican City State',''),
(236,'VE','Venezuela',''),
(237,'VN','Vietnam',''),
(238,'VG','Virgin Islands (British)',''),
(239,'VI','Virgin Islands (U.S.)',''),
(240,'WF','Wallis and Futuna Islands',''),
(241,'EH','Western Sahara',''),
(242,'YE','Yemen',''),
(243,'ZR','Zaire',''),
(244,'ZM','Zambia',''),
(245,'ZW','Zimbabwe','');

/*Table structure for table `xin_currencies` */

DROP TABLE IF EXISTS `xin_currencies`;

CREATE TABLE `xin_currencies` (
  `currency_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_currencies` */

insert  into `xin_currencies`(`currency_id`,`company_id`,`name`,`code`,`symbol`) values 
(1,1,'Rupiah','IDR','Rp.');

/*Table structure for table `xin_currency_converter` */

DROP TABLE IF EXISTS `xin_currency_converter`;

CREATE TABLE `xin_currency_converter` (
  `currency_converter_id` int(11) NOT NULL AUTO_INCREMENT,
  `usd_currency` varchar(11) NOT NULL DEFAULT '1',
  `to_currency_title` varchar(200) NOT NULL,
  `to_currency_rate` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`currency_converter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `xin_currency_converter` */

insert  into `xin_currency_converter`(`currency_converter_id`,`usd_currency`,`to_currency_title`,`to_currency_rate`,`created_at`) values 
(1,'1','MYR','4.11','17-08-2018 03:29:58');

/*Table structure for table `xin_database_backup` */

DROP TABLE IF EXISTS `xin_database_backup`;

CREATE TABLE `xin_database_backup` (
  `backup_id` int(111) NOT NULL AUTO_INCREMENT,
  `backup_file` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`backup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_database_backup` */

/*Table structure for table `xin_departments` */

DROP TABLE IF EXISTS `xin_departments`;

CREATE TABLE `xin_departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(200) NOT NULL,
  `company_id` int(11) NOT NULL,
  `location_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `created_by` int(111) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `xin_departments` */

insert  into `xin_departments`(`department_id`,`department_name`,`company_id`,`location_id`,`employee_id`,`created_by`,`created_at`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`,`status`) values 
(1,'IT',1,1,7,0,'2018-03-06 00:00:00',NULL,0,NULL,0,1),
(2,'OPERASIONAL',1,0,7,1,'2018-03-06 00:01:00',NULL,0,NULL,0,1),
(5,'HRD MANAGEMENT',1,0,7,1,'2019-03-12 07:38:11',NULL,0,NULL,0,1),
(6,'ACCOUNTING & FINANCE',1,0,7,1,'2019-03-12 07:38:28',NULL,0,NULL,0,1),
(9,'DIGITAL MARKETING',1,0,7,1,'2019-03-14 20:34:56',NULL,0,NULL,0,1),
(10,'AUDITOR & RESEARCH',1,0,7,6,'2019-05-04 21:08:52',NULL,0,NULL,0,1),
(11,'TOP MANAGEMENT',1,0,7,73,'2019-07-12 17:38:19',NULL,0,NULL,0,1),
(13,'BUSINESS DEVELOPMENT',1,0,7,73,'2019-12-20 15:12:20',NULL,0,NULL,0,1);

/*Table structure for table `xin_designations` */

DROP TABLE IF EXISTS `xin_designations`;

CREATE TABLE `xin_designations` (
  `designation_id` int(11) NOT NULL AUTO_INCREMENT,
  `top_designation_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(200) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `designation_name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`designation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

/*Data for the table `xin_designations` */

insert  into `xin_designations`(`designation_id`,`top_designation_id`,`department_id`,`sub_department_id`,`company_id`,`designation_name`,`status`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(13,0,2,21,1,'Staff CS & Sales',1,'2019-03-14 00:00:00',1,NULL,0,NULL,0),
(14,0,2,21,1,'Officer CS & Sales',1,'2019-03-14 00:00:00',1,NULL,0,NULL,0),
(15,0,2,21,1,'Supervisor Operasional',1,'2019-03-14 00:00:00',1,NULL,0,NULL,0),
(16,0,5,16,1,'Officer Recruitment/Personalia',1,'2019-03-14 00:00:00',1,NULL,0,NULL,0),
(17,0,6,34,1,'Officer Accounting',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(21,0,5,16,1,'Staff Recruitment/Personalia',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(22,0,5,16,1,'Supervisor HR',1,'2019-03-14 00:00:00',6,'2019-11-25 11:29:21',35,NULL,0),
(25,0,5,17,1,'Supervisor Legal & QA',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(26,0,5,17,1,'Officer Legal & QA',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(27,0,5,17,1,'Staff Legal & QA',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(31,0,6,19,1,'Staff Finance Analyst',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(32,0,6,19,1,'Officer Finance Analyst',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(35,0,1,14,1,'Officer Developer',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(36,0,1,14,1,'Staff Developer',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(37,0,9,20,1,'Officer Digital Marketing',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(38,0,9,20,1,'Staff Digital Marketing',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(39,0,9,21,1,'Officer Sales',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(40,0,9,21,1,'Staff Sales',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(41,0,1,15,1,'Officer Sysadmin',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(42,0,1,15,1,'Staff Sysadmin',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(43,0,2,13,1,'Officer Withdraw',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(44,0,2,13,1,'Staff Withdraw',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(47,0,5,33,1,'Officer GA',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(48,0,5,29,1,'Staff GA',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(49,0,6,34,1,'Staff Accounting',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(50,0,10,35,1,'Officer Auditor',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(51,0,10,35,1,'Staff Auditor',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(52,0,10,36,1,'Officer Research',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(53,0,10,36,1,'Staff Research',1,'2019-03-14 00:00:00',6,NULL,0,NULL,0),
(54,0,2,32,1,'Officer CS & Deposit',1,'2019-03-14 00:00:00',73,NULL,0,NULL,0),
(55,0,2,32,1,'Staff CS & Deposit',1,'2019-03-14 00:00:00',73,NULL,0,NULL,0),
(57,0,11,37,1,'DIrector',1,'2019-12-18 12:47:14',35,NULL,0,NULL,0),
(58,0,11,38,1,'Manager',1,'2019-12-18 12:47:38',35,NULL,0,NULL,0),
(59,0,13,42,1,'Officer Business Development',1,'2019-12-20 15:13:48',73,NULL,0,NULL,0);

/*Table structure for table `xin_document_type` */

DROP TABLE IF EXISTS `xin_document_type`;

CREATE TABLE `xin_document_type` (
  `document_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`document_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `xin_document_type` */

insert  into `xin_document_type`(`document_type_id`,`company_id`,`document_type`,`created_at`) values 
(1,1,'Passport','09-05-2018 12:34:55'),
(2,1,'Visa','17-03-2019 07:01:24'),
(3,1,'Ijazah','15-12-2019 05:34:06'),
(4,1,'KTP','15-12-2019 05:34:17');

/*Table structure for table `xin_email_template` */

DROP TABLE IF EXISTS `xin_email_template`;

CREATE TABLE `xin_email_template` (
  `template_id` int(111) NOT NULL AUTO_INCREMENT,
  `template_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `xin_email_template` */

insert  into `xin_email_template`(`template_id`,`template_code`,`name`,`subject`,`message`,`status`) values 
(2,'code1','Forgot Password','Forgot Password','&lt;p&gt;There was recently a request for password for your  {var site_name} account.&lt;/p&gt;&lt;p&gt;Please, keep it in your records so you don\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\&#039;t forget it.&lt;/p&gt;&lt;p&gt;Your username: {var username}&lt;br&gt;Your email address: {var email}&lt;br&gt;Your password: {var password}&lt;/p&gt;&lt;p&gt;Thank you,&lt;br&gt;The {var site_name} Team&lt;/p&gt;',1),
(3,'code2','New Project','New Project','&lt;p&gt;Dear {var name},&lt;/p&gt;&lt;p&gt;New project has been assigned to you.&lt;/p&gt;&lt;p&gt;Project Name: {var project_name}&lt;/p&gt;&lt;p&gt;Project Start Date:&amp;nbsp;&lt;span 1rem;\\\\\\&quot;=\\&quot;\\&quot;&gt;{var project_start_date}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span 1rem;\\\\\\&quot;=\\&quot;\\&quot;&gt;Thank you,&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;',1),
(5,'code3','Leave Request ','A Leave Request from you','&lt;p&gt;Dear Admin,&lt;/p&gt;&lt;p&gt;{var employee_name} wants a leave from you.&lt;/p&gt;&lt;p&gt;You can view this leave request by logging in to the portal using the link below.&lt;/p&gt;&lt;p&gt;{var site_url}admin/&lt;br&gt;&lt;br&gt;Regards&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;',1),
(6,'code4','Leave Approve','Your leave request has been approved','&lt;p&gt;Your leave request has been approved&lt;/p&gt;&lt;p&gt;&lt;span style=\\&quot;font-size: 1rem;\\&quot;&gt;Congratulations! Your leave request from&lt;/span&gt;&lt;font color=\\&quot;#333333\\&quot; face=\\&quot;sans-serif, Arial, Verdana, Trebuchet MS\\&quot;&gt;&amp;nbsp;&lt;/font&gt;{var leave_start_date}&amp;nbsp;to&amp;nbsp;{var leave_end_date}&amp;nbsp;has been approved by your company management.&lt;/p&gt;&lt;p&gt;Check here&lt;/p&gt;&lt;p&gt;{var site_url}hr/user/leave/&lt;br&gt;&lt;/p&gt;&lt;p&gt;Regards&lt;br&gt;The {var site_name} Team&lt;/p&gt;',1),
(7,'code5','Leave Reject','Your leave request has been Rejected','&lt;p&gt;Your leave request has been Rejected&lt;/p&gt;&lt;p&gt;Unfortunately ! Your leave request from {var leave_start_date} to {var leave_end_date} has been Rejected by your company management.&lt;/p&gt;&lt;p&gt;Check here&lt;/p&gt;&lt;p&gt;{var site_url}hr/user/leave/&lt;/p&gt;&lt;p&gt;Regards&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;',1),
(8,'code6','Welcome Email ','Welcome Email ','&lt;p&gt;Hello&amp;nbsp;{var employee_name},&lt;/p&gt;&lt;p&gt;Welcome to&amp;nbsp;{var site_name}&amp;nbsp;.Thanks for joining&amp;nbsp;{var site_name}. We listed your sign in details below, make sure you keep them safe.&lt;/p&gt;&lt;p&gt;Your Username: {var username}&lt;/p&gt;&lt;p&gt;Your Employee ID: {var employee_id}&lt;br&gt;Your Email Address: {var email}&lt;br&gt;Your Password: {var password}&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;a href=\\&quot;{var site_url}\\&quot;&gt;&lt;a href=\\&quot;{var site_url}/hr/\\&quot;&gt;Login Panel&lt;/a&gt;&lt;/a&gt;&lt;/p&gt;&lt;p&gt;Link doesn\\&#039;t work? Copy the following link to your browser address bar:&lt;/p&gt;&lt;p&gt;{var site_url}/hr/&lt;/p&gt;&lt;p&gt;Have fun!&lt;/p&gt;&lt;p&gt;The&amp;nbsp;{var site_name}&amp;nbsp;Team.&lt;/p&gt;',1),
(9,'code7','Transfer','New Transfer','&lt;p&gt;Hello&amp;nbsp;{var employee_name},&lt;/p&gt;&lt;p&gt;You have been&amp;nbsp;transfered to another department and location.&lt;/p&gt;&lt;p&gt;You can view the transfer details by logging in to the portal using the link below.&lt;/p&gt;&lt;p&gt;{var site_url}hr/user/transfer/&lt;/p&gt;&lt;p&gt;Regards&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;',1),
(10,'code8','Award','Award Received','&lt;p&gt;Hello&amp;nbsp;{var employee_name},&lt;/p&gt;&lt;p&gt;You have been&amp;nbsp;awarded&amp;nbsp;{var award_name}.&lt;/p&gt;&lt;p&gt;You can view this award by logging in to the portal using the link below.&lt;/p&gt;&lt;p&gt;&lt;span style=\\&quot;font-size: 1rem;\\&quot;&gt;{var site_url}hr/&lt;/span&gt;&lt;span style=\\&quot;font-size: 1rem;\\&quot;&gt;user/awards/&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;Regards&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;',1),
(14,'code9','New Task','Task assigned','&lt;p&gt;Dear Employee,&lt;/p&gt;&lt;p&gt;A new task&amp;nbsp;&lt;span style=\\&quot;\\\\&amp;quot;font-weight:\\&quot; bolder;\\\\\\&quot;=\\&quot;\\&quot;&gt;{var task_name}&lt;/span&gt;&amp;nbsp;has been assigned to you by&amp;nbsp;&lt;span style=\\&quot;\\\\&amp;quot;font-weight:\\&quot; bolder;\\\\\\&quot;=\\&quot;\\&quot;&gt;{var task_assigned_by}&lt;/span&gt;.&lt;/p&gt;&lt;p&gt;You can view this task by logging in to the portal using the link below.&lt;/p&gt;&lt;p&gt;{var site_url}hr/user/tasks/&lt;br&gt;&lt;/p&gt;&lt;p&gt;Link doesn\\\\\\&#039;t work? Copy the following link to your browser address bar:&lt;/p&gt;&lt;p&gt;{var site_url}&lt;/p&gt;&lt;p&gt;Regards,&lt;/p&gt;&lt;p&gt;The {var site_name} Team&lt;/p&gt;',1),
(15,'code10','New Inquiry','New Inquiry [#{var ticket_code}]','&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;&lt;span xss=removed&gt;Dear Admin,&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;&lt;span xss=removed&gt;Your received a new inquiry.&lt;/span&gt;&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;&lt;span xss=removed&gt;Inquiry Code: #{var ticket_code}&lt;/span&gt;&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;Status : Open&lt;br&gt;&lt;br&gt;Click on the below link to see the inquiry details and post additional comments.&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;{var site_url}admin/tickets/&lt;br&gt;&lt;br&gt;Regards&lt;/p&gt;&lt;p xss=removed rgb(51,=\\&quot;\\\\\\&quot; font-family:=\\&quot;\\\\\\&quot; sans-serif,=\\&quot;\\\\\\&quot; arial,=\\&quot;\\\\\\&quot; verdana,=\\&quot;\\\\\\&quot; trebuchet=\\&quot;\\\\\\\\\\&quot;&gt;The {var site_name} Team&lt;/p&gt;',1),
(16,'code11','Client Welcome Email','Welcome Email','&lt;p&gt;Hello {var client_name},&lt;/p&gt;&lt;p&gt;Welcome to {var site_name} .Thanks for joining {var site_name}. We listed your sign in details below, make sure you keep them safe. You can login to your panel using email and password.&lt;/p&gt;&lt;p&gt;Your Username: {var username}&lt;/p&gt;&lt;p&gt;&lt;span xss=\\&quot;removed\\&quot;&gt;Your Email Address: {var email}&lt;/span&gt;&lt;/p&gt;&lt;p&gt;Your Password: {var password}&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;a href=\\&quot;\\\\\\\\\\&quot;&gt;&lt;/a&gt;&lt;a href=\\&quot;\\\\\\\\\\&quot; hr=\\&quot;\\\\\\\\\\&quot;&gt;&lt;/a&gt;&lt;a href=\\&quot;\\\\\\\\\\&quot; client=\\&quot;\\&quot;&gt;Login Panel&lt;/a&gt;&lt;/p&gt;&lt;p&gt;Link doesn\\\\\\\\\\\\\\&#039;t work? Copy the following link to your browser address bar:&lt;/p&gt;&lt;p&gt;{var site_url}/client/&lt;/p&gt;&lt;p&gt;Have fun!&lt;/p&gt;&lt;p&gt;The {var site_name} Team.&lt;/p&gt;',1);

/*Table structure for table `xin_employee_bankaccount` */

DROP TABLE IF EXISTS `xin_employee_bankaccount`;

CREATE TABLE `xin_employee_bankaccount` (
  `bankaccount_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `is_primary` int(11) NOT NULL,
  `account_title` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_code` varchar(255) NOT NULL,
  `bank_branch` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`bankaccount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_bankaccount` */

/*Table structure for table `xin_employee_complaints` */

DROP TABLE IF EXISTS `xin_employee_complaints`;

CREATE TABLE `xin_employee_complaints` (
  `complaint_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `complaint_from` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `complaint_date` varchar(255) NOT NULL,
  `complaint_against` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `company_response` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`complaint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_complaints` */

insert  into `xin_employee_complaints`(`complaint_id`,`company_id`,`complaint_from`,`title`,`complaint_date`,`complaint_against`,`description`,`company_response`,`status`,`created_at`) values 
(1,1,75,'gaji','2019-11-17','75','minta naik gaji','',0,'17-11-2019'),
(2,1,73,'ENTERTAINMENT WITH TEAM','2019-12-20','7','&lt;p&gt;ENTERTAINMENT WITH TEAM ya Pak dalam rangka Tahun Baruan, please&lt;/p&gt;','',0,'20-12-2019');

/*Table structure for table `xin_employee_contacts` */

DROP TABLE IF EXISTS `xin_employee_contacts`;

CREATE TABLE `xin_employee_contacts` (
  `contact_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `relation` varchar(255) NOT NULL,
  `is_primary` int(111) NOT NULL,
  `is_dependent` int(111) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `work_phone` varchar(255) NOT NULL,
  `work_phone_extension` varchar(255) NOT NULL,
  `mobile_phone` varchar(255) NOT NULL,
  `home_phone` varchar(255) NOT NULL,
  `work_email` varchar(255) NOT NULL,
  `personal_email` varchar(255) NOT NULL,
  `address_1` mediumtext NOT NULL,
  `address_2` mediumtext NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_contacts` */

insert  into `xin_employee_contacts`(`contact_id`,`employee_id`,`relation`,`is_primary`,`is_dependent`,`contact_name`,`work_phone`,`work_phone_extension`,`mobile_phone`,`home_phone`,`work_email`,`personal_email`,`address_1`,`address_2`,`city`,`state`,`zipcode`,`country`,`created_at`) values 
(1,13,'Parent',1,0,'Rajab Nasution','','','6281375412641','','6319@asiapowergames.com','rachmatandriansyah.ka1@gmail.com','Jln. Sei Mencirim , Medan Sunngal','','Medan','','','101','26-07-2019'),
(2,75,'Self',1,0,'Roy Testing','','','0968878525','','8000@nexia.biz','','Pegasus Casino Krong ST, Victory Beach Krong Preah','','Sihanouke','Sihanouke','18000','36','17-11-2019'),
(3,108,'Parent',1,0,'I Wayan Kantun Arimbawa','','','081237270418','','iwayankantumarimbawa@gmail.com','','Banjar Tua, Desa Tua, Kec Marga','','Tabanan','Bali','82181','101','15-12-2019'),
(16,110,'Self',0,0,'asasas','','','23223','','8000@asiapowergames.com','','','','','','213232','','13-02-2020');

/*Table structure for table `xin_employee_contract` */

DROP TABLE IF EXISTS `xin_employee_contract`;

CREATE TABLE `xin_employee_contract` (
  `contract_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `contract_type_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `title` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_contract` */

/*Table structure for table `xin_employee_documents` */

DROP TABLE IF EXISTS `xin_employee_documents`;

CREATE TABLE `xin_employee_documents` (
  `document_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `document_type_id` int(111) NOT NULL,
  `date_of_expiry` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notification_email` varchar(255) DEFAULT NULL,
  `is_alert` tinyint(1) NOT NULL,
  `description` mediumtext NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `notification_interval_1` int(5) NOT NULL,
  `notification_interval_satuan_1` varchar(10) NOT NULL,
  `notification_date_1` date NOT NULL,
  `notification_interval_2` int(5) NOT NULL,
  `notification_interval_satuan_2` varchar(10) NOT NULL,
  `notification_date_2` date NOT NULL,
  `is_sent_notification_1` int(1) DEFAULT 0,
  `is_sent_notification_2` int(1) DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_documents` */

/*Table structure for table `xin_employee_exit` */

DROP TABLE IF EXISTS `xin_employee_exit`;

CREATE TABLE `xin_employee_exit` (
  `exit_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `exit_date` varchar(255) NOT NULL,
  `exit_type_id` int(111) NOT NULL,
  `exit_interview` int(111) NOT NULL,
  `is_inactivate_account` int(111) NOT NULL,
  `reason` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`exit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_exit` */

/*Table structure for table `xin_employee_exit_type` */

DROP TABLE IF EXISTS `xin_employee_exit_type`;

CREATE TABLE `xin_employee_exit_type` (
  `exit_type_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`exit_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_exit_type` */

insert  into `xin_employee_exit_type`(`exit_type_id`,`company_id`,`type`,`created_at`) values 
(1,1,'Resign',''),
(2,1,'Contract Ends','29-12-2019 06:04:31'),
(3,1,'Terminated','29-12-2019 06:04:47'),
(4,1,'Runaway','29-12-2019 06:04:54'),
(5,1,'Annual Leave','29-12-2019 06:05:20'),
(6,1,'Unpaid Leave','29-12-2019 06:05:29');

/*Table structure for table `xin_employee_immigration` */

DROP TABLE IF EXISTS `xin_employee_immigration`;

CREATE TABLE `xin_employee_immigration` (
  `immigration_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `document_type_id` int(111) NOT NULL,
  `document_number` varchar(255) NOT NULL,
  `document_file` varchar(255) NOT NULL,
  `issue_date` varchar(255) NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `country_id` varchar(255) NOT NULL,
  `eligible_review_date` varchar(255) NOT NULL,
  `comments` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`immigration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_immigration` */

/*Table structure for table `xin_employee_leave` */

DROP TABLE IF EXISTS `xin_employee_leave`;

CREATE TABLE `xin_employee_leave` (
  `leave_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `contract_id` int(111) NOT NULL,
  `casual_leave` varchar(255) NOT NULL,
  `medical_leave` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_leave` */

/*Table structure for table `xin_employee_location` */

DROP TABLE IF EXISTS `xin_employee_location`;

CREATE TABLE `xin_employee_location` (
  `office_location_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `location_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`office_location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_location` */

/*Table structure for table `xin_employee_promotions` */

DROP TABLE IF EXISTS `xin_employee_promotions`;

CREATE TABLE `xin_employee_promotions` (
  `promotion_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `title` int(11) NOT NULL,
  `promotion_date` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_promotions` */

insert  into `xin_employee_promotions`(`promotion_id`,`company_id`,`employee_id`,`title`,`promotion_date`,`description`,`added_by`,`created_at`) values 
(1,1,11,41,'2019-05-14','&lt;p&gt;*Probation selama 2 bulan &lt;/p&gt;&lt;p&gt;*Wakil Manager I&lt;/p&gt;&lt;p&gt;*Top Manajemen&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;',73,'11-07-2019'),
(2,1,9,17,'2019-05-14','*Probation selama 2 bulan&amp;nbsp;&lt;p&gt;*Wakil Manager II&lt;/p&gt;&lt;p&gt;*Top Manajemen&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;',73,'11-07-2019');

/*Table structure for table `xin_employee_qualification` */

DROP TABLE IF EXISTS `xin_employee_qualification`;

CREATE TABLE `xin_employee_qualification` (
  `qualification_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `name` varchar(255) NOT NULL,
  `education_level_id` int(111) NOT NULL,
  `from_year` varchar(255) NOT NULL,
  `language_id` int(111) NOT NULL,
  `to_year` varchar(255) NOT NULL,
  `skill_id` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`qualification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_qualification` */

insert  into `xin_employee_qualification`(`qualification_id`,`employee_id`,`name`,`education_level_id`,`from_year`,`language_id`,`to_year`,`skill_id`,`description`,`created_at`) values 
(1,75,'Binus',4,'2019-11-01',1,'2019-11-11','1','','17-11-2019'),
(2,108,'STT PLN',4,'2014-06-15',1,'2019-04-19','','','15-12-2019');

/*Table structure for table `xin_employee_resignations` */

DROP TABLE IF EXISTS `xin_employee_resignations`;

CREATE TABLE `xin_employee_resignations` (
  `resignation_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `notice_date` varchar(255) NOT NULL,
  `resignation_date` varchar(255) NOT NULL,
  `reason` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`resignation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_resignations` */

insert  into `xin_employee_resignations`(`resignation_id`,`company_id`,`employee_id`,`notice_date`,`resignation_date`,`reason`,`added_by`,`created_at`) values 
(1,1,75,'2019-11-09','2019-11-10','pecat',54,'17-11-2019'),
(2,1,104,'2019-11-20','2019-11-30','test add, error?',35,'18-11-2019');

/*Table structure for table `xin_employee_shift` */

DROP TABLE IF EXISTS `xin_employee_shift`;

CREATE TABLE `xin_employee_shift` (
  `emp_shift_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `shift_id` int(111) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`emp_shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_shift` */

/*Table structure for table `xin_employee_terminations` */

DROP TABLE IF EXISTS `xin_employee_terminations`;

CREATE TABLE `xin_employee_terminations` (
  `termination_id` int(111) NOT NULL AUTO_INCREMENT,
  `termination_letter_number` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `terminated_by` int(111) NOT NULL,
  `termination_type_id` int(111) NOT NULL,
  `termination_date` varchar(255) NOT NULL,
  `notice_date` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `termination_attachment` text NOT NULL,
  `approval_1` int(11) NOT NULL,
  `approval_2` int(11) NOT NULL,
  `approved_by_1` int(11) NOT NULL,
  `approval_date_1` datetime DEFAULT NULL,
  `approval_status_by_1` int(1) NOT NULL,
  `approved_by_2` int(11) NOT NULL,
  `approval_date_2` datetime DEFAULT NULL,
  `approval_status_by_2` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`termination_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_terminations` */

/*Table structure for table `xin_employee_transfer` */

DROP TABLE IF EXISTS `xin_employee_transfer`;

CREATE TABLE `xin_employee_transfer` (
  `transfer_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `transfer_date` varchar(255) NOT NULL,
  `transfer_department` int(111) NOT NULL,
  `transfer_location` int(111) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_transfer` */

/*Table structure for table `xin_employee_travels` */

DROP TABLE IF EXISTS `xin_employee_travels`;

CREATE TABLE `xin_employee_travels` (
  `travel_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `visit_purpose` varchar(255) NOT NULL,
  `visit_place` varchar(255) NOT NULL,
  `travel_mode` int(111) DEFAULT NULL,
  `arrangement_type` int(111) DEFAULT NULL,
  `expected_budget` varchar(255) NOT NULL,
  `actual_budget` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`travel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_travels` */

insert  into `xin_employee_travels`(`travel_id`,`company_id`,`employee_id`,`start_date`,`end_date`,`visit_purpose`,`visit_place`,`travel_mode`,`arrangement_type`,`expected_budget`,`actual_budget`,`description`,`status`,`added_by`,`created_at`) values 
(1,1,75,'2019-11-15','2019-11-17','Liburan','Siem Reap',1,1,'1000000','500000','',1,54,'17-11-2019'),
(2,1,75,'2019-11-18','2019-11-21','Dinas','Poipet',5,1,'5000000','3000000','',0,54,'18-11-2019');

/*Table structure for table `xin_employee_warnings` */

DROP TABLE IF EXISTS `xin_employee_warnings`;

CREATE TABLE `xin_employee_warnings` (
  `warning_id` int(111) NOT NULL AUTO_INCREMENT,
  `warning_letter_number` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `warning_to` int(111) NOT NULL,
  `warning_by` int(111) NOT NULL,
  `warning_date` varchar(255) NOT NULL,
  `warning_type_id` int(111) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL COMMENT '0=Pending, 1=Accepted, 2=Rejected',
  `warning_counter` tinyint(2) NOT NULL DEFAULT 0,
  `warning_attachment` text DEFAULT NULL,
  `approval_1` int(11) NOT NULL,
  `approval_2` int(11) NOT NULL,
  `approved_by_1` int(11) NOT NULL,
  `approval_date_1` datetime DEFAULT NULL,
  `approval_status_by_1` int(11) NOT NULL,
  `approved_by_2` int(11) NOT NULL,
  `approval_date_2` datetime DEFAULT NULL,
  `approval_status_by_2` int(11) NOT NULL,
  `approval_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`warning_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_warnings` */

/*Table structure for table `xin_employee_work_experience` */

DROP TABLE IF EXISTS `xin_employee_work_experience`;

CREATE TABLE `xin_employee_work_experience` (
  `work_experience_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `from_date` varchar(255) NOT NULL,
  `to_date` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`work_experience_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employee_work_experience` */

insert  into `xin_employee_work_experience`(`work_experience_id`,`employee_id`,`company_name`,`from_date`,`to_date`,`post`,`description`,`created_at`) values 
(1,75,'Tokopedia','2019-11-01','2019-11-17','Less than 1 year experience','','17-11-2019'),
(2,108,'PT. Bali Semesta Agung|Bali,Indonesia','2019-06-01','2019-12-01','IT Support','1. IT Support & Maintenance\n2. Inventaris kantor (seleuruh cabang)\n3. Design (Logo, Banner, Company Profile, dll)','15-12-2019'),
(4,76,'test update','2020-01-01','2020-01-31','tukang sapu update','bersih2 atap bawah update','07-01-2020');

/*Table structure for table `xin_employees` */

DROP TABLE IF EXISTS `xin_employees`;

CREATE TABLE `xin_employees` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(200) NOT NULL,
  `office_shift_id` int(111) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `fingerprint_location` int(11) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `date_of_birth` varchar(200) NOT NULL,
  `time_of_birth` time NOT NULL,
  `gender` varchar(200) NOT NULL,
  `e_status` int(11) NOT NULL,
  `is_director` int(1) NOT NULL DEFAULT 0,
  `is_manager` int(1) NOT NULL DEFAULT 0,
  `is_wakil_manager` int(1) NOT NULL DEFAULT 0,
  `is_supervisor` int(1) NOT NULL DEFAULT 0,
  `is_officer` int(1) NOT NULL DEFAULT 0,
  `user_role_id` int(100) NOT NULL,
  `department_id` int(100) NOT NULL,
  `sub_department_id` int(11) NOT NULL,
  `designation_id` int(100) NOT NULL,
  `company_id` int(111) DEFAULT NULL,
  `fingerprint_shift` varchar(50) NOT NULL,
  `bazi_file` varchar(255) NOT NULL,
  `bazi_description` text NOT NULL,
  `transfer_to` int(11) DEFAULT 1,
  `salary_template` varchar(255) NOT NULL,
  `hourly_grade_id` int(111) NOT NULL,
  `monthly_grade_id` int(111) NOT NULL,
  `date_of_joining` varchar(200) NOT NULL,
  `date_of_leaving` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `salary` varchar(200) NOT NULL,
  `wages_type` int(11) NOT NULL,
  `basic_salary` varchar(200) NOT NULL DEFAULT '0',
  `daily_wages` varchar(200) NOT NULL DEFAULT '0',
  `salary_ssempee` varchar(200) NOT NULL DEFAULT '0',
  `salary_ssempeer` varchar(200) DEFAULT '0',
  `salary_income_tax` varchar(200) NOT NULL DEFAULT '0',
  `salary_overtime` varchar(200) NOT NULL DEFAULT '0',
  `salary_commission` varchar(200) NOT NULL DEFAULT '0',
  `salary_claims` varchar(200) NOT NULL DEFAULT '0',
  `salary_paid_leave` varchar(200) NOT NULL DEFAULT '0',
  `salary_director_fees` varchar(200) NOT NULL DEFAULT '0',
  `salary_bonus` varchar(200) NOT NULL DEFAULT '0',
  `salary_advance_paid` varchar(200) NOT NULL DEFAULT '0',
  `address` mediumtext NOT NULL,
  `profile_picture_sso` mediumtext NOT NULL,
  `profile_picture` mediumtext NOT NULL,
  `profile_background` mediumtext NOT NULL,
  `resume` mediumtext NOT NULL,
  `skype_id` varchar(200) NOT NULL,
  `contact_no` varchar(200) NOT NULL,
  `facebook_link` mediumtext NOT NULL,
  `twitter_link` mediumtext NOT NULL,
  `blogger_link` mediumtext NOT NULL,
  `linkdedin_link` mediumtext NOT NULL,
  `google_plus_link` mediumtext NOT NULL,
  `instagram_link` varchar(255) NOT NULL,
  `pinterest_link` varchar(255) NOT NULL,
  `youtube_link` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `inactive_reason` tinyint(1) NOT NULL COMMENT '1=resign, 2=contract, 3=terminate, 4=runaway',
  `last_login_date` varchar(255) NOT NULL,
  `last_logout_date` varchar(255) NOT NULL,
  `last_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(111) NOT NULL,
  `online_status` int(111) NOT NULL,
  `fixed_header` varchar(150) NOT NULL,
  `compact_sidebar` varchar(150) NOT NULL,
  `boxed_wrapper` varchar(150) NOT NULL,
  `leave_categories` varchar(255) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

/*Data for the table `xin_employees` */

insert  into `xin_employees`(`user_id`,`employee_id`,`office_shift_id`,`first_name`,`last_name`,`username`,`email`,`fingerprint_location`,`password`,`date_of_birth`,`time_of_birth`,`gender`,`e_status`,`is_director`,`is_manager`,`is_wakil_manager`,`is_supervisor`,`is_officer`,`user_role_id`,`department_id`,`sub_department_id`,`designation_id`,`company_id`,`fingerprint_shift`,`bazi_file`,`bazi_description`,`transfer_to`,`salary_template`,`hourly_grade_id`,`monthly_grade_id`,`date_of_joining`,`date_of_leaving`,`marital_status`,`salary`,`wages_type`,`basic_salary`,`daily_wages`,`salary_ssempee`,`salary_ssempeer`,`salary_income_tax`,`salary_overtime`,`salary_commission`,`salary_claims`,`salary_paid_leave`,`salary_director_fees`,`salary_bonus`,`salary_advance_paid`,`address`,`profile_picture_sso`,`profile_picture`,`profile_background`,`resume`,`skype_id`,`contact_no`,`facebook_link`,`twitter_link`,`blogger_link`,`linkdedin_link`,`google_plus_link`,`instagram_link`,`pinterest_link`,`youtube_link`,`is_active`,`inactive_reason`,`last_login_date`,`last_logout_date`,`last_login_ip`,`is_logged_in`,`online_status`,`fixed_header`,`compact_sidebar`,`boxed_wrapper`,`leave_categories`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(1,'1000',1,'Company','-','Alpha','1000@asiapowergames.com',0,'$2y$12$BJPmIZshgdFtO.7yrk6MauQ4LPajdo8kF686fJH8JD4gdFAbXLKUq','2018-03-28','00:00:00','Male',0,0,0,0,0,0,1,2,21,13,1,'','','',0,'monthly',0,0,'2018-02-01','','Single','',1,'1000','0','8','17','10','0','1','2','3','0','0','0','Test Address','','profile_1546421723.png','profile_background_1519924152.jpg','','','12345678900','','','','','','','','',1,0,'07-02-2020 19:57:23','07-02-2020 20:17:18','103.209.255.1',0,1,'fixed_layout_hrsale','','boxed_layout_hrsale','0,1,2','2018-02-28 05:30:44',0,'2019-11-25 06:32:08',35,NULL,0),
(35,'7380',1,'Ras Edro Raymond','Ginting','Luffy','7380@asiapowergames.com',5,'$2y$12$jTSR/hF29l2U/Dw0PMcLX.4gCkNJTzPwXi/RuqkUk5Rvd9tAPdoka','1983-04-14','05:01:00','Male',0,0,0,0,0,1,4,1,14,35,1,'morning','','',0,'',0,0,'2019-01-30','','Single','',0,'0','0','0','0','0','0','0','0','0','0','0','0','Jakarta','https://lh3.googleusercontent.com/a-/AOh14GiOm_M8qMakwtOJ8irjuNyRQsrVSPEpp4GGrvix=s50','profile_1564149116.jpg','','','','081212372171','','','','','','','','',1,0,'20-03-2020 11:56:04','14-02-2020 12:41:05','37.120.154.66',1,0,'','','','0,1','2019-03-14 04:17:18',0,'2020-02-14 10:40:59',35,NULL,0);

/*Table structure for table `xin_events` */

DROP TABLE IF EXISTS `xin_events`;

CREATE TABLE `xin_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_date` varchar(255) NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `event_note` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `xin_events` */

insert  into `xin_events`(`event_id`,`company_id`,`employee_id`,`event_title`,`event_date`,`event_time`,`event_note`,`created_at`) values 
(2,1,1,'EMPLOYEE HOT EVENT','2019-11-17','09:30','Untuk syarat dan ketentuan untuk event ini akan diumumkan melalui Channel Slack APG - LOUNGE.&lt;br&gt;Terima Kasih.','2019-11-16'),
(5,1,110,'terminations','2020-04-16','16:15','edfedewfefefefefefefxx','2020-02-08');

/*Table structure for table `xin_expense_type` */

DROP TABLE IF EXISTS `xin_expense_type`;

CREATE TABLE `xin_expense_type` (
  `expense_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`expense_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `xin_expense_type` */

insert  into `xin_expense_type`(`expense_type_id`,`company_id`,`name`,`status`,`created_at`) values 
(1,1,'Supplies',1,'22-03-2018 01:17:42'),
(2,1,'Utility',1,'22-03-2018 01:17:48'),
(3,1,'Salary',1,'18-11-2019 05:56:34'),
(4,1,'Ticket',1,'18-11-2019 05:58:25'),
(5,1,'Visa',1,'18-11-2019 05:58:32');

/*Table structure for table `xin_expenses` */

DROP TABLE IF EXISTS `xin_expenses`;

CREATE TABLE `xin_expenses` (
  `expense_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(200) NOT NULL,
  `company_id` int(11) NOT NULL,
  `expense_type_id` int(200) NOT NULL,
  `billcopy_file` mediumtext NOT NULL,
  `amount` varchar(200) NOT NULL,
  `purchase_date` varchar(200) NOT NULL,
  `remarks` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `status_remarks` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`expense_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_expenses` */

/*Table structure for table `xin_file_manager` */

DROP TABLE IF EXISTS `xin_file_manager`;

CREATE TABLE `xin_file_manager` (
  `file_id` int(111) NOT NULL AUTO_INCREMENT,
  `user_id` int(111) NOT NULL,
  `department_id` int(111) NOT NULL,
  `name` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_file_manager` */

/*Table structure for table `xin_file_manager_settings` */

DROP TABLE IF EXISTS `xin_file_manager_settings`;

CREATE TABLE `xin_file_manager_settings` (
  `setting_id` int(111) NOT NULL AUTO_INCREMENT,
  `allowed_extensions` mediumtext NOT NULL,
  `maximum_file_size` varchar(255) NOT NULL,
  `is_enable_all_files` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `xin_file_manager_settings` */

insert  into `xin_file_manager_settings`(`setting_id`,`allowed_extensions`,`maximum_file_size`,`is_enable_all_files`,`updated_at`) values 
(1,'jpg,gif,png,pdf,txt,doc','10','','2020-02-08 11:34:01');

/*Table structure for table `xin_finance_bankcash` */

DROP TABLE IF EXISTS `xin_finance_bankcash`;

CREATE TABLE `xin_finance_bankcash` (
  `bankcash_id` int(111) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(255) NOT NULL,
  `account_balance` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `branch_code` varchar(255) NOT NULL,
  `bank_branch` text NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`bankcash_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_finance_bankcash` */

/*Table structure for table `xin_finance_deposit` */

DROP TABLE IF EXISTS `xin_finance_deposit`;

CREATE TABLE `xin_finance_deposit` (
  `deposit_id` int(111) NOT NULL AUTO_INCREMENT,
  `account_type_id` int(111) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `deposit_date` varchar(255) NOT NULL,
  `category_id` int(111) NOT NULL,
  `payer_id` int(111) NOT NULL,
  `payment_method` int(111) NOT NULL,
  `deposit_reference` varchar(255) NOT NULL,
  `deposit_file` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`deposit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_finance_deposit` */

insert  into `xin_finance_deposit`(`deposit_id`,`account_type_id`,`amount`,`deposit_date`,`category_id`,`payer_id`,`payment_method`,`deposit_reference`,`deposit_file`,`description`,`created_at`) values 
(3,2,'200000','2019-11-18',3,1,3,'001','no_file','','2019-11-18 18:41:23');

/*Table structure for table `xin_finance_expense` */

DROP TABLE IF EXISTS `xin_finance_expense`;

CREATE TABLE `xin_finance_expense` (
  `expense_id` int(111) NOT NULL AUTO_INCREMENT,
  `account_type_id` int(111) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `expense_date` varchar(255) NOT NULL,
  `category_id` int(111) NOT NULL,
  `payee_id` int(111) NOT NULL,
  `payment_method` int(111) NOT NULL,
  `expense_reference` varchar(255) NOT NULL,
  `expense_file` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`expense_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_finance_expense` */

insert  into `xin_finance_expense`(`expense_id`,`account_type_id`,`amount`,`expense_date`,`category_id`,`payee_id`,`payment_method`,`expense_reference`,`expense_file`,`description`,`created_at`) values 
(1,1,'70000','2019-11-17',1,1,3,'apg001','no_file','','2019-11-17 21:24:05'),
(2,1,'200000','2019-11-18',4,2,3,'apg002','no_file','','2019-11-18 18:06:50');

/*Table structure for table `xin_finance_payees` */

DROP TABLE IF EXISTS `xin_finance_payees`;

CREATE TABLE `xin_finance_payees` (
  `payee_id` int(11) NOT NULL AUTO_INCREMENT,
  `payee_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`payee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_finance_payees` */

/*Table structure for table `xin_finance_payers` */

DROP TABLE IF EXISTS `xin_finance_payers`;

CREATE TABLE `xin_finance_payers` (
  `payer_id` int(11) NOT NULL AUTO_INCREMENT,
  `payer_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`payer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_finance_payers` */

/*Table structure for table `xin_finance_transactions` */

DROP TABLE IF EXISTS `xin_finance_transactions`;

CREATE TABLE `xin_finance_transactions` (
  `transaction_id` int(111) NOT NULL AUTO_INCREMENT,
  `account_type_id` int(111) NOT NULL,
  `deposit_id` int(111) NOT NULL,
  `expense_id` int(111) NOT NULL,
  `transfer_id` int(111) NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `transaction_debit` varchar(255) NOT NULL,
  `transaction_credit` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_finance_transactions` */

/*Table structure for table `xin_finance_transfer` */

DROP TABLE IF EXISTS `xin_finance_transfer`;

CREATE TABLE `xin_finance_transfer` (
  `transfer_id` int(111) NOT NULL AUTO_INCREMENT,
  `from_account_id` int(111) NOT NULL,
  `to_account_id` int(111) NOT NULL,
  `transfer_date` varchar(255) NOT NULL,
  `transfer_amount` varchar(255) NOT NULL,
  `payment_method` varchar(111) NOT NULL,
  `transfer_reference` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_finance_transfer` */

insert  into `xin_finance_transfer`(`transfer_id`,`from_account_id`,`to_account_id`,`transfer_date`,`transfer_amount`,`payment_method`,`transfer_reference`,`description`,`created_at`) values 
(1,2,1,'2019-11-17','20000','3','DP001','Pemindahan dana','2019-11-17 21:26:11'),
(2,2,1,'2019-11-18','30000','3','DP002','pindah dana','2019-11-18 18:08:12');

/*Table structure for table `xin_goal_tracking` */

DROP TABLE IF EXISTS `xin_goal_tracking`;

CREATE TABLE `xin_goal_tracking` (
  `tracking_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `tracking_type_id` int(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `target_achiement` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `goal_progress` varchar(200) NOT NULL,
  `goal_status` int(11) NOT NULL DEFAULT 0,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`tracking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_goal_tracking` */

/*Table structure for table `xin_goal_tracking_type` */

DROP TABLE IF EXISTS `xin_goal_tracking_type`;

CREATE TABLE `xin_goal_tracking_type` (
  `tracking_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`tracking_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `xin_goal_tracking_type` */

insert  into `xin_goal_tracking_type`(`tracking_type_id`,`company_id`,`type_name`,`created_at`) values 
(1,1,'Invoice Goal','31-08-2018 01:29:44'),
(4,1,'Event Goal','31-08-2018 01:29:47'),
(5,1,'Digital-X','04-10-2019 07:15:56'),
(6,1,'kkk','11-01-2020 04:22:21'),
(7,1,'feeefef','08-02-2020 11:26:40');

/*Table structure for table `xin_holidays` */

DROP TABLE IF EXISTS `xin_holidays`;

CREATE TABLE `xin_holidays` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `description` mediumtext NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `is_publish` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_holidays` */

/*Table structure for table `xin_hourly_templates` */

DROP TABLE IF EXISTS `xin_hourly_templates`;

CREATE TABLE `xin_hourly_templates` (
  `hourly_rate_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `hourly_grade` varchar(255) NOT NULL,
  `hourly_rate` varchar(255) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`hourly_rate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_hourly_templates` */

/*Table structure for table `xin_hrsale_invoices` */

DROP TABLE IF EXISTS `xin_hrsale_invoices`;

CREATE TABLE `xin_hrsale_invoices` (
  `invoice_id` int(111) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) NOT NULL,
  `project_id` int(111) NOT NULL,
  `invoice_date` varchar(255) NOT NULL,
  `invoice_due_date` varchar(255) NOT NULL,
  `sub_total_amount` varchar(255) NOT NULL,
  `discount_type` varchar(11) NOT NULL,
  `discount_figure` varchar(255) NOT NULL,
  `total_tax` varchar(255) NOT NULL,
  `total_discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `invoice_note` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_hrsale_invoices` */

/*Table structure for table `xin_hrsale_invoices_items` */

DROP TABLE IF EXISTS `xin_hrsale_invoices_items`;

CREATE TABLE `xin_hrsale_invoices_items` (
  `invoice_item_id` int(111) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(111) NOT NULL,
  `project_id` int(111) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_tax_type` varchar(255) NOT NULL,
  `item_tax_rate` varchar(255) NOT NULL,
  `item_qty` varchar(255) NOT NULL,
  `item_unit_price` varchar(255) NOT NULL,
  `item_sub_total` varchar(255) NOT NULL,
  `sub_total_amount` varchar(255) NOT NULL,
  `total_tax` varchar(255) NOT NULL,
  `discount_type` int(11) NOT NULL,
  `discount_figure` varchar(255) NOT NULL,
  `total_discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`invoice_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_hrsale_invoices_items` */

/*Table structure for table `xin_income_categories` */

DROP TABLE IF EXISTS `xin_income_categories`;

CREATE TABLE `xin_income_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `xin_income_categories` */

insert  into `xin_income_categories`(`category_id`,`name`,`status`,`created_at`) values 
(1,'Envato',1,'25-03-2018 09:36:20'),
(2,'Salary',1,'25-03-2018 09:36:28'),
(3,'Other Income',1,'25-03-2018 09:36:32'),
(4,'Interest Income',1,'25-03-2018 09:36:53'),
(5,'Part Time Work',1,'25-03-2018 09:37:13'),
(6,'Regular Income',1,'25-03-2018 09:37:17');

/*Table structure for table `xin_job_applications` */

DROP TABLE IF EXISTS `xin_job_applications`;

CREATE TABLE `xin_job_applications` (
  `application_id` int(111) NOT NULL AUTO_INCREMENT,
  `job_id` int(111) NOT NULL,
  `user_id` int(111) NOT NULL,
  `message` mediumtext NOT NULL,
  `job_resume` mediumtext NOT NULL,
  `application_status` varchar(200) NOT NULL,
  `application_remarks` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `xin_job_applications` */

/*Table structure for table `xin_job_categories` */

DROP TABLE IF EXISTS `xin_job_categories`;

CREATE TABLE `xin_job_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `category_url` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

/*Data for the table `xin_job_categories` */

insert  into `xin_job_categories`(`category_id`,`category_name`,`category_url`,`created_at`) values 
(1,'PHP','php','2018-04-15'),
(2,'Android','andriod','2018-04-15'),
(3,'WordPress','wordpress','2018-04-15'),
(4,'Design','design','2018-04-15'),
(5,'Developer','developer','2018-04-15'),
(6,'iOS','ios','2018-04-15'),
(7,'Mobile','mobile','2018-04-15'),
(8,'MySQL','mysql','2018-04-15'),
(9,'JavaScript','javascript',''),
(10,'Software','software',''),
(11,'Website Design','',''),
(12,'Programming','',''),
(13,'SEO','',''),
(14,'Java','',''),
(15,'CSS','',''),
(16,'HTML5','',''),
(17,'Web Development','',''),
(18,'Web Design','',''),
(19,'eCommerce','',''),
(20,'Design','',''),
(21,'Logo Design','',''),
(22,'Graphic Design','',''),
(23,'Video','',''),
(24,'Animation','',''),
(25,'Adobe Photoshop','',''),
(26,'Illustration','',''),
(27,'Art','',''),
(28,'3D','',''),
(29,'Adobe Illustrator','',''),
(30,'Drawing','',''),
(31,'Web Design','',''),
(32,'Cartoon','',''),
(33,'Graphics','',''),
(34,'Fashion Design','',''),
(35,'WordPress','',''),
(36,'Editing','',''),
(37,'Writing','',''),
(38,'T-Shirt Design','',''),
(39,'Display Advertising','',''),
(40,'Email Marketing','',''),
(41,'Lead Generation','',''),
(42,'Market & Customer Research','',''),
(43,'Marketing Strategy','',''),
(44,'Public Relations','',''),
(45,'Telemarketing & Telesales','',''),
(46,'Other - Sales & Marketing','',''),
(47,'SEM - Search Engine Marketing','',''),
(48,'SEO - Search Engine Optimization','',''),
(49,'SMM - Social Media Marketing','','');

/*Table structure for table `xin_job_interviews` */

DROP TABLE IF EXISTS `xin_job_interviews`;

CREATE TABLE `xin_job_interviews` (
  `job_interview_id` int(111) NOT NULL AUTO_INCREMENT,
  `job_id` int(111) NOT NULL,
  `interviewers_id` varchar(255) NOT NULL,
  `interview_place` varchar(255) NOT NULL,
  `interview_date` varchar(255) NOT NULL,
  `interview_time` varchar(255) NOT NULL,
  `interviewees_id` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`job_interview_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_job_interviews` */

/*Table structure for table `xin_job_type` */

DROP TABLE IF EXISTS `xin_job_type`;

CREATE TABLE `xin_job_type` (
  `job_type_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `type_url` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`job_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `xin_job_type` */

insert  into `xin_job_type`(`job_type_id`,`company_id`,`type`,`type_url`,`created_at`) values 
(1,1,'Resign','full-time','22-03-2018 02:18:48'),
(2,1,'PKWT','part-time','16-04-2018 06:29:45'),
(3,1,'Terminated','internship','16-04-2018 06:30:06'),
(4,1,'Freelance','freelance','16-04-2018 06:30:21');

/*Table structure for table `xin_jobs` */

DROP TABLE IF EXISTS `xin_jobs`;

CREATE TABLE `xin_jobs` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `job_type` int(225) NOT NULL,
  `is_featured` int(11) NOT NULL,
  `job_vacancy` int(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `minimum_experience` varchar(255) NOT NULL,
  `date_of_closing` varchar(200) NOT NULL,
  `short_description` mediumtext NOT NULL,
  `long_description` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_jobs` */

/*Table structure for table `xin_languages` */

DROP TABLE IF EXISTS `xin_languages`;

CREATE TABLE `xin_languages` (
  `language_id` int(111) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(255) NOT NULL,
  `language_code` varchar(255) NOT NULL,
  `language_flag` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `xin_languages` */

insert  into `xin_languages`(`language_id`,`language_name`,`language_code`,`language_flag`,`is_active`,`created_at`) values 
(1,'English','english','language_flag_1520564355.gif',1,''),
(4,'Portuguese','portuguese','language_flag_1526420518.gif',1,'16-05-2018 12:41:57'),
(5,'Vietnamese','vietnamese','language_flag_1526728529.gif',1,'19-05-2018 02:15:28');

/*Table structure for table `xin_leave_applications` */

DROP TABLE IF EXISTS `xin_leave_applications`;

CREATE TABLE `xin_leave_applications` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(222) NOT NULL,
  `leave_type_id` int(222) NOT NULL,
  `from_date` varchar(200) NOT NULL,
  `to_date` varchar(200) NOT NULL,
  `applied_on` varchar(200) NOT NULL,
  `reason` mediumtext NOT NULL,
  `remarks` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = pending, 1 = accept, 2 = reject',
  `created_at` varchar(200) NOT NULL,
  `approval_1` int(11) NOT NULL,
  `approval_2` int(11) NOT NULL,
  `approval_action_by_1` tinyint(1) NOT NULL COMMENT '0 = pending, 1 = accept, 2 = reject	',
  `approval_action_by_2` tinyint(1) NOT NULL COMMENT '0 = pending, 1 = accept, 2 = reject	',
  `approved_date_1` datetime DEFAULT NULL,
  `approved_date_2` datetime DEFAULT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `xin_leave_applications` */

insert  into `xin_leave_applications`(`leave_id`,`company_id`,`employee_id`,`leave_type_id`,`from_date`,`to_date`,`applied_on`,`reason`,`remarks`,`status`,`created_at`,`approval_1`,`approval_2`,`approval_action_by_1`,`approval_action_by_2`,`approved_date_1`,`approved_date_2`) values 
(5,1,110,1,'2020-02-11','2020-02-22','2020-02-10 04:12:09','sdwd','dwwdwd',1,'2020-02-10 04:12:09',56,73,1,1,NULL,NULL),
(6,1,110,1,'2020-02-01','2020-02-08','2020-02-12 03:47:15','ss','ddd',0,'2020-02-12 03:47:15',56,73,0,0,NULL,NULL),
(7,1,9,1,'2020-02-24','2020-02-24','2020-02-12 03:56:02','ddd','sss',0,'2020-02-12 03:56:02',56,73,0,0,NULL,NULL);

/*Table structure for table `xin_leave_type` */

DROP TABLE IF EXISTS `xin_leave_type`;

CREATE TABLE `xin_leave_type` (
  `leave_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type_name` varchar(200) NOT NULL,
  `days_per_year` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`leave_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_leave_type` */

insert  into `xin_leave_type`(`leave_type_id`,`company_id`,`type_name`,`days_per_year`,`status`,`created_at`) values 
(1,1,'Casual Leave','3',1,'19-03-2018 07:52:20'),
(2,1,'Medical','2',1,'19-03-2018 07:52:30');

/*Table structure for table `xin_make_payment` */

DROP TABLE IF EXISTS `xin_make_payment`;

CREATE TABLE `xin_make_payment` (
  `make_payment_id` int(111) NOT NULL AUTO_INCREMENT,
  `employee_id` int(111) NOT NULL,
  `department_id` int(111) NOT NULL,
  `company_id` int(111) NOT NULL,
  `location_id` int(111) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `payment_date` varchar(200) NOT NULL,
  `basic_salary` varchar(255) NOT NULL,
  `payment_amount` varchar(255) NOT NULL,
  `gross_salary` varchar(255) NOT NULL,
  `total_allowances` varchar(255) NOT NULL,
  `total_deductions` varchar(255) NOT NULL,
  `net_salary` varchar(255) NOT NULL,
  `house_rent_allowance` varchar(255) NOT NULL,
  `medical_allowance` varchar(255) NOT NULL,
  `travelling_allowance` varchar(255) NOT NULL,
  `dearness_allowance` varchar(255) NOT NULL,
  `provident_fund` varchar(255) NOT NULL,
  `tax_deduction` varchar(255) NOT NULL,
  `security_deposit` varchar(255) NOT NULL,
  `overtime_rate` varchar(255) NOT NULL,
  `is_advance_salary_deduct` int(11) NOT NULL,
  `advance_salary_amount` varchar(255) NOT NULL,
  `is_payment` tinyint(1) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `hourly_rate` varchar(255) NOT NULL,
  `total_hours_work` varchar(255) NOT NULL,
  `comments` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`make_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_make_payment` */

/*Table structure for table `xin_meetings` */

DROP TABLE IF EXISTS `xin_meetings`;

CREATE TABLE `xin_meetings` (
  `meeting_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `meeting_title` varchar(255) NOT NULL,
  `meeting_date` varchar(255) NOT NULL,
  `meeting_time` varchar(255) NOT NULL,
  `meeting_note` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`meeting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `xin_meetings` */

insert  into `xin_meetings`(`meeting_id`,`company_id`,`employee_id`,`meeting_title`,`meeting_date`,`meeting_time`,`meeting_note`,`created_at`) values 
(4,1,8,'asdfghgfdxxxxx','2020-04-16','16:05','xxxxxxxxxxccccccccss','2020-02-08');

/*Table structure for table `xin_office_location` */

DROP TABLE IF EXISTS `xin_office_location`;

CREATE TABLE `xin_office_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(111) NOT NULL,
  `location_head` int(111) NOT NULL,
  `location_manager` int(111) NOT NULL,
  `location_name` varchar(200) NOT NULL,
  `dns` varchar(255) DEFAULT NULL,
  `local_ip` varchar(255) DEFAULT NULL,
  `location_active` tinyint(1) DEFAULT NULL COMMENT '1 = active; 0 = nonactive',
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `address_1` mediumtext NOT NULL,
  `address_2` mediumtext NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_office_location` */

/*Table structure for table `xin_office_shift` */

DROP TABLE IF EXISTS `xin_office_shift`;

CREATE TABLE `xin_office_shift` (
  `office_shift_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `shift_name` varchar(255) NOT NULL,
  `default_shift` int(111) NOT NULL,
  `monday_in_time` varchar(222) NOT NULL,
  `monday_out_time` varchar(222) NOT NULL,
  `tuesday_in_time` varchar(222) NOT NULL,
  `tuesday_out_time` varchar(222) NOT NULL,
  `wednesday_in_time` varchar(222) NOT NULL,
  `wednesday_out_time` varchar(222) NOT NULL,
  `thursday_in_time` varchar(222) NOT NULL,
  `thursday_out_time` varchar(222) NOT NULL,
  `friday_in_time` varchar(222) NOT NULL,
  `friday_out_time` varchar(222) NOT NULL,
  `saturday_in_time` varchar(222) NOT NULL,
  `saturday_out_time` varchar(222) NOT NULL,
  `sunday_in_time` varchar(222) NOT NULL,
  `sunday_out_time` varchar(222) NOT NULL,
  `created_at` varchar(222) NOT NULL,
  PRIMARY KEY (`office_shift_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_office_shift` */

insert  into `xin_office_shift`(`office_shift_id`,`company_id`,`shift_name`,`default_shift`,`monday_in_time`,`monday_out_time`,`tuesday_in_time`,`tuesday_out_time`,`wednesday_in_time`,`wednesday_out_time`,`thursday_in_time`,`thursday_out_time`,`friday_in_time`,`friday_out_time`,`saturday_in_time`,`saturday_out_time`,`sunday_in_time`,`sunday_out_time`,`created_at`) values 
(1,1,'Morning Shift',1,'09:30','21:30','09:30','21:30','09:30','21:30','09:30','21:30','09:30','21:30','09:30','21:30','09:30','21:30','2018-02-28'),
(2,1,'Night Shift',0,'21:30','09:30','21:30','09:30','21:30','09:30','21:30','09:30','21:30','09:30','21:30','09:30','21:30','09:30','2018-07-01');

/*Table structure for table `xin_payment_method` */

DROP TABLE IF EXISTS `xin_payment_method`;

CREATE TABLE `xin_payment_method` (
  `payment_method_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `payment_percentage` varchar(200) DEFAULT NULL,
  `account_number` varchar(200) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_payment_method` */

insert  into `xin_payment_method`(`payment_method_id`,`company_id`,`method_name`,`payment_percentage`,`account_number`,`created_at`) values 
(1,1,'Cash','30','','23-04-2018 05:13:52'),
(2,1,'Paypal','40','1','12-08-2018 02:18:50'),
(3,1,'Bank','30','1231232','12-08-2018 02:18:57');

/*Table structure for table `xin_payroll_custom_fields` */

DROP TABLE IF EXISTS `xin_payroll_custom_fields`;

CREATE TABLE `xin_payroll_custom_fields` (
  `payroll_custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `allow_custom_1` varchar(255) NOT NULL,
  `is_active_allow_1` int(11) NOT NULL,
  `allow_custom_2` varchar(255) NOT NULL,
  `is_active_allow_2` int(11) NOT NULL,
  `allow_custom_3` varchar(255) NOT NULL,
  `is_active_allow_3` int(11) NOT NULL,
  `allow_custom_4` varchar(255) NOT NULL,
  `is_active_allow_4` int(11) NOT NULL,
  `allow_custom_5` varchar(255) NOT NULL,
  `is_active_allow_5` int(111) NOT NULL,
  `deduct_custom_1` varchar(255) NOT NULL,
  `is_active_deduct_1` int(11) NOT NULL,
  `deduct_custom_2` varchar(255) NOT NULL,
  `is_active_deduct_2` int(11) NOT NULL,
  `deduct_custom_3` varchar(255) NOT NULL,
  `is_active_deduct_3` int(11) NOT NULL,
  `deduct_custom_4` varchar(255) NOT NULL,
  `is_active_deduct_4` int(11) NOT NULL,
  `deduct_custom_5` varchar(255) NOT NULL,
  `is_active_deduct_5` int(11) NOT NULL,
  PRIMARY KEY (`payroll_custom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_payroll_custom_fields` */

/*Table structure for table `xin_performance_appraisal` */

DROP TABLE IF EXISTS `xin_performance_appraisal`;

CREATE TABLE `xin_performance_appraisal` (
  `performance_appraisal_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `appraisal_year_month` varchar(255) NOT NULL,
  `customer_experience` int(111) NOT NULL,
  `marketing` int(111) NOT NULL,
  `management` int(111) NOT NULL,
  `administration` int(111) NOT NULL,
  `presentation_skill` int(111) NOT NULL,
  `quality_of_work` int(111) NOT NULL,
  `efficiency` int(111) NOT NULL,
  `integrity` int(111) NOT NULL,
  `professionalism` int(111) NOT NULL,
  `team_work` int(111) NOT NULL,
  `critical_thinking` int(111) NOT NULL,
  `conflict_management` int(111) NOT NULL,
  `attendance` int(111) NOT NULL,
  `ability_to_meet_deadline` int(111) NOT NULL,
  `remarks` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`performance_appraisal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_performance_appraisal` */

insert  into `xin_performance_appraisal`(`performance_appraisal_id`,`company_id`,`employee_id`,`appraisal_year_month`,`customer_experience`,`marketing`,`management`,`administration`,`presentation_skill`,`quality_of_work`,`efficiency`,`integrity`,`professionalism`,`team_work`,`critical_thinking`,`conflict_management`,`attendance`,`ability_to_meet_deadline`,`remarks`,`added_by`,`created_at`) values 
(1,1,110,'2020-04',1,4,1,0,2,1,2,2,1,2,2,3,2,1,'zxcvbnm',110,'08-02-2020'),
(2,1,7,'2020-02',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',110,'08-02-2020');

/*Table structure for table `xin_performance_indicator` */

DROP TABLE IF EXISTS `xin_performance_indicator`;

CREATE TABLE `xin_performance_indicator` (
  `performance_indicator_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `customer_experience` int(111) NOT NULL,
  `marketing` int(111) NOT NULL,
  `management` int(111) NOT NULL,
  `administration` int(111) NOT NULL,
  `presentation_skill` int(111) NOT NULL,
  `quality_of_work` int(111) NOT NULL,
  `efficiency` int(111) NOT NULL,
  `integrity` int(111) NOT NULL,
  `professionalism` int(111) NOT NULL,
  `team_work` int(111) NOT NULL,
  `critical_thinking` int(111) NOT NULL,
  `conflict_management` int(111) NOT NULL,
  `attendance` int(111) NOT NULL,
  `ability_to_meet_deadline` int(111) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`performance_indicator_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_performance_indicator` */

insert  into `xin_performance_indicator`(`performance_indicator_id`,`company_id`,`designation_id`,`customer_experience`,`marketing`,`management`,`administration`,`presentation_skill`,`quality_of_work`,`efficiency`,`integrity`,`professionalism`,`team_work`,`critical_thinking`,`conflict_management`,`attendance`,`ability_to_meet_deadline`,`added_by`,`created_at`) values 
(1,1,13,1,1,1,1,0,0,0,0,0,0,0,0,0,0,110,'11-01-2020'),
(2,1,36,1,0,0,0,0,0,0,0,0,0,0,0,0,0,110,'08-02-2020');

/*Table structure for table `xin_projects` */

DROP TABLE IF EXISTS `xin_projects`;

CREATE TABLE `xin_projects` (
  `project_id` int(111) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `client_id` int(100) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `company_id` int(111) NOT NULL,
  `assigned_to` mediumtext NOT NULL,
  `priority` varchar(255) NOT NULL,
  `summary` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `added_by` int(111) NOT NULL,
  `project_progress` varchar(255) NOT NULL,
  `project_note` longtext NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_projects` */

insert  into `xin_projects`(`project_id`,`title`,`client_id`,`start_date`,`end_date`,`company_id`,`assigned_to`,`priority`,`summary`,`description`,`added_by`,`project_progress`,`project_note`,`status`,`created_at`) values 
(1,'testing a2',0,'2019-11-17','2019-11-19',1,'75','1','testing a2 summary\r\n','testing a2 description',54,'58','',2,'17-11-2019'),
(2,'testing ',0,'2019-11-17','2019-11-19',1,'75','1','testing ','',75,'57','',1,'17-11-2019');

/*Table structure for table `xin_projects_attachment` */

DROP TABLE IF EXISTS `xin_projects_attachment`;

CREATE TABLE `xin_projects_attachment` (
  `project_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` mediumtext NOT NULL,
  `attachment_file` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`project_attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_projects_attachment` */

/*Table structure for table `xin_projects_bugs` */

DROP TABLE IF EXISTS `xin_projects_bugs`;

CREATE TABLE `xin_projects_bugs` (
  `bug_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(111) NOT NULL,
  `user_id` int(200) NOT NULL,
  `attachment_file` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_projects_bugs` */

/*Table structure for table `xin_projects_discussion` */

DROP TABLE IF EXISTS `xin_projects_discussion`;

CREATE TABLE `xin_projects_discussion` (
  `discussion_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(111) NOT NULL,
  `user_id` int(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `attachment_file` varchar(255) NOT NULL,
  `message` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`discussion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_projects_discussion` */

/*Table structure for table `xin_qualification_education_level` */

DROP TABLE IF EXISTS `xin_qualification_education_level`;

CREATE TABLE `xin_qualification_education_level` (
  `education_level_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`education_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `xin_qualification_education_level` */

insert  into `xin_qualification_education_level`(`education_level_id`,`company_id`,`name`,`created_at`) values 
(1,1,'Middle School - SMP','09-05-2018 03:11:59'),
(2,1,'High School - SMA','26-07-2019 02:39:52'),
(3,1,'Associate Degree - Diploma','26-07-2019 02:48:47'),
(4,1,'Bachelor Degree - S1','26-07-2019 02:49:11'),
(5,1,'Master Degree - S2','26-07-2019 02:49:38'),
(6,1,'Pоѕtgrаduаtе - S3','26-07-2019 02:53:24');

/*Table structure for table `xin_qualification_language` */

DROP TABLE IF EXISTS `xin_qualification_language`;

CREATE TABLE `xin_qualification_language` (
  `language_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_qualification_language` */

insert  into `xin_qualification_language`(`language_id`,`company_id`,`name`,`created_at`) values 
(1,1,'English','09-05-2018 03:12:03'),
(3,1,'cccc','08-02-2020 01:12:20');

/*Table structure for table `xin_qualification_skill` */

DROP TABLE IF EXISTS `xin_qualification_skill`;

CREATE TABLE `xin_qualification_skill` (
  `skill_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_qualification_skill` */

insert  into `xin_qualification_skill`(`skill_id`,`company_id`,`name`,`created_at`) values 
(1,1,'Microsoft Office','09-05-2018 03:12:08'),
(2,1,'Komputer','26-07-2019 03:03:02'),
(3,1,'xxx','08-02-2020 11:37:33'),
(4,1,'cccc','08-02-2020 01:11:23');

/*Table structure for table `xin_recruitment_pages` */

DROP TABLE IF EXISTS `xin_recruitment_pages`;

CREATE TABLE `xin_recruitment_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) NOT NULL,
  `page_details` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_recruitment_pages` */

insert  into `xin_recruitment_pages`(`page_id`,`page_title`,`page_details`,`status`,`created_at`) values 
(1,'Pages','Nulla dignissim gravida\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \n\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.',1,''),
(2,'About Us','Nulla dignissim gravida\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \n\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.',1,''),
(3,'Career Services','Career Services',1,''),
(4,'Success Stories','Success Stories',1,'');

/*Table structure for table `xin_recruitment_subpages` */

DROP TABLE IF EXISTS `xin_recruitment_subpages`;

CREATE TABLE `xin_recruitment_subpages` (
  `subpages_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `sub_page_title` varchar(255) NOT NULL,
  `sub_page_details` mediumtext NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`subpages_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `xin_recruitment_subpages` */

insert  into `xin_recruitment_subpages`(`subpages_id`,`page_id`,`sub_page_title`,`sub_page_details`,`status`,`created_at`) values 
(1,1,'Sub Menu 1','Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.',1,''),
(2,1,'Sub Menu 2','Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.',1,''),
(3,1,'Sub Menu 3','Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.',1,''),
(4,1,'Sub Menu 4','Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.',1,''),
(5,1,'Sub Menu 5','Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.',1,''),
(6,1,'Sub Menu 6','Nulla dignissim gravida\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies dictum ex, nec ullamcorper orci luctus eget. Integer mauris arcu, pretium eget elit vel, posuere consectetur massa. Etiam non fermentum augue, vel posuere sapien. \r\n\r\nVivamus aliquet eros bibendum ipsum euismod, non interdum dui elementum. Morbi facilisis hendrerit nisi, a volutpat velit. Donec sed malesuada felis. Nulla facilisi. Vivamus a velit vel orci euismod maximus. Praesent ut blandit orci, eget suscipit lorem. Aenean dignissim, augue at porta suscipit, est enim euismod mi, a rhoncus mi lacus ac nibh. Ut pharetra ligula sed tortor congue, pellentesque ultricies augue tincidunt.',1,'');

/*Table structure for table `xin_salary_adjustment_minus` */

DROP TABLE IF EXISTS `xin_salary_adjustment_minus`;

CREATE TABLE `xin_salary_adjustment_minus` (
  `adjustment_minus_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `adjustment_minus_title` varchar(200) DEFAULT NULL,
  `adjustment_minus_amount` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`adjustment_minus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_adjustment_minus` */

insert  into `xin_salary_adjustment_minus`(`adjustment_minus_id`,`employee_id`,`adjustment_minus_title`,`adjustment_minus_amount`,`created_at`,`created_by`,`updated_at`,`updated_by`) values 
(1,75,'Pelanggaran Pekerjaan',777,'2019-12-04 20:49:57',35,'0000-00-00 00:00:00',NULL),
(2,75,'Kerusakan Fasilitas Kantor',888,'2019-12-04 20:50:11',35,'0000-00-00 00:00:00',NULL),
(3,75,'Utang',999,'2019-12-04 20:50:23',35,'0000-00-00 00:00:00',NULL),
(4,75,'Unpaid Leaves',1010,'2019-12-04 20:50:35',35,'0000-00-00 00:00:00',NULL),
(5,9,'Pelanggaran Fengshui',5000,'2019-12-20 15:34:34',73,'0000-00-00 00:00:00',NULL),
(8,76,'test minus OISUDFONSEFIOSUDIFJ ',8237456,'2020-01-04 21:08:38',35,'2020-01-04 21:09:26',35);

/*Table structure for table `xin_salary_allowances` */

DROP TABLE IF EXISTS `xin_salary_allowances`;

CREATE TABLE `xin_salary_allowances` (
  `allowance_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `allowance_title` varchar(200) DEFAULT NULL,
  `allowance_amount` varchar(200) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`allowance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_allowances` */

insert  into `xin_salary_allowances`(`allowance_id`,`employee_id`,`allowance_title`,`allowance_amount`,`created_by`,`created_at`,`updated_by`,`updated_at`) values 
(1,76,'test plus','546',0,'0000-00-00 00:00:00',0,NULL);

/*Table structure for table `xin_salary_bank_allocation` */

DROP TABLE IF EXISTS `xin_salary_bank_allocation`;

CREATE TABLE `xin_salary_bank_allocation` (
  `bank_allocation_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `pay_percent` varchar(200) NOT NULL,
  `acc_number` varchar(200) NOT NULL,
  PRIMARY KEY (`bank_allocation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_bank_allocation` */

/*Table structure for table `xin_salary_loan_deductions` */

DROP TABLE IF EXISTS `xin_salary_loan_deductions`;

CREATE TABLE `xin_salary_loan_deductions` (
  `loan_deduction_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `loan_deduction_title` varchar(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `monthly_installment` varchar(200) NOT NULL,
  `loan_time` varchar(200) NOT NULL,
  `loan_deduction_amount` varchar(200) NOT NULL,
  `total_paid` varchar(200) NOT NULL,
  `reason` text NOT NULL,
  `status` int(11) NOT NULL,
  `is_deducted_from_salary` int(11) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`loan_deduction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_loan_deductions` */

insert  into `xin_salary_loan_deductions`(`loan_deduction_id`,`employee_id`,`loan_deduction_title`,`start_date`,`end_date`,`monthly_installment`,`loan_time`,`loan_deduction_amount`,`total_paid`,`reason`,`status`,`is_deducted_from_salary`,`created_at`) values 
(11,1,'Test Loan','2018-08-12','2018-10-14','200','2','100','','test',0,0,''),
(12,75,'Cashbon','2019-11-01','2019-11-30','1000000','0','1000000','','',0,0,''),
(13,107,'Pinjaman 1','2019-12-03','2019-12-29','100000','0','100000','','kebutuhan sehari2',0,0,'');

/*Table structure for table `xin_salary_overtime` */

DROP TABLE IF EXISTS `xin_salary_overtime`;

CREATE TABLE `xin_salary_overtime` (
  `salary_overtime_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `overtime_type` varchar(200) NOT NULL,
  `no_of_days` varchar(100) NOT NULL DEFAULT '0',
  `overtime_hours` varchar(100) NOT NULL DEFAULT '0',
  `overtime_rate` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`salary_overtime_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_overtime` */

insert  into `xin_salary_overtime`(`salary_overtime_id`,`employee_id`,`overtime_type`,`no_of_days`,`overtime_hours`,`overtime_rate`) values 
(3,1,'Lembur','26','1','100000'),
(4,75,'Lembur','1','1','100000'),
(5,75,'Juni 2019','1','2','100000'),
(7,107,'lembur tes lagi','1','3','30000'),
(8,107,'lembur tess','1','2','50000');

/*Table structure for table `xin_salary_payslip_adjustment_minus` */

DROP TABLE IF EXISTS `xin_salary_payslip_adjustment_minus`;

CREATE TABLE `xin_salary_payslip_adjustment_minus` (
  `payslip_adjustment_minus_id` int(11) NOT NULL AUTO_INCREMENT,
  `payslip_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `adjustment_minus_title` varchar(200) NOT NULL,
  `adjustment_minus_amount` varchar(200) NOT NULL,
  `salary_month` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`payslip_adjustment_minus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_payslip_adjustment_minus` */

insert  into `xin_salary_payslip_adjustment_minus`(`payslip_adjustment_minus_id`,`payslip_id`,`employee_id`,`adjustment_minus_title`,`adjustment_minus_amount`,`salary_month`,`created_at`) values 
(1,9,75,'Pelanggaran Pekerjaan','777','2019-12','2019-12-04 20:59:53'),
(2,9,75,'Kerusakan Fasilitas Kantor','888','2019-12','2019-12-04 20:59:53'),
(3,9,75,'Utang','999','2019-12','2019-12-04 20:59:53'),
(4,9,75,'Unpaid Leaves','1010','2019-12','2019-12-04 20:59:53'),
(5,10,9,'Pelanggaran Fengshui','5000','2019-12','2019-12-20 15:35:31');

/*Table structure for table `xin_salary_payslip_allowances` */

DROP TABLE IF EXISTS `xin_salary_payslip_allowances`;

CREATE TABLE `xin_salary_payslip_allowances` (
  `payslip_allowances_id` int(11) NOT NULL AUTO_INCREMENT,
  `payslip_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `allowance_title` varchar(200) NOT NULL,
  `allowance_amount` varchar(200) NOT NULL,
  `salary_month` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`payslip_allowances_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_payslip_allowances` */

insert  into `xin_salary_payslip_allowances`(`payslip_allowances_id`,`payslip_id`,`employee_id`,`allowance_title`,`allowance_amount`,`salary_month`,`created_at`) values 
(21,8,1,'Cost of Living Allowance','100','2018-10','11-10-2018 01:16:41'),
(22,8,1,'Housing Allowance','200','2018-10','11-10-2018 01:16:41'),
(23,8,1,'Market Adjustment','200','2018-10','11-10-2018 01:16:41'),
(24,8,1,'Meal Allowance','100','2018-10','11-10-2018 01:16:41'),
(25,8,1,'Transportation Allowance','200','2018-10','11-10-2018 01:16:41'),
(31,11,1,'Cost of Living Allowance','100','2019-02','04-01-2019 08:28:00'),
(32,11,1,'Housing Allowance','200','2019-02','04-01-2019 08:28:00'),
(33,11,1,'Market Adjustment','200','2019-02','04-01-2019 08:28:00'),
(34,11,1,'Meal Allowance','100','2019-02','04-01-2019 08:28:00'),
(35,11,1,'Transportation Allowance','200','2019-02','04-01-2019 08:28:00'),
(36,12,1,'Cost of Living Allowance','100','2019-01','07-01-2019 06:56:32'),
(37,12,1,'Housing Allowance','200','2019-01','07-01-2019 06:56:32'),
(38,12,1,'Market Adjustment','200','2019-01','07-01-2019 06:56:32'),
(39,12,1,'Meal Allowance','100','2019-01','07-01-2019 06:56:32'),
(40,12,1,'Transportation Allowance','200','2019-01','07-01-2019 06:56:32'),
(41,14,1,'Cost of Living Allowance','100','2019-01','07-01-2019 06:56:37'),
(42,14,1,'Housing Allowance','200','2019-01','07-01-2019 06:56:37'),
(43,14,1,'Market Adjustment','200','2019-01','07-01-2019 06:56:37'),
(44,14,1,'Meal Allowance','100','2019-01','07-01-2019 06:56:37'),
(45,14,1,'Transportation Allowance','200','2019-01','07-01-2019 06:56:37'),
(46,1,1,'Cost of Living Allowance','100','2019-06','11-07-2019 05:43:52'),
(47,1,1,'Housing Allowance','200','2019-06','11-07-2019 05:43:52'),
(48,1,1,'Market Adjustment','200','2019-06','11-07-2019 05:43:52'),
(49,1,1,'Meal Allowance','100','2019-06','11-07-2019 05:43:52'),
(50,1,1,'Transportation Allowance','200','2019-06','11-07-2019 05:43:52'),
(51,2,1,'Cost of Living Allowance','100','2019-08','09-08-2019 04:45:40'),
(52,2,1,'Housing Allowance','200','2019-08','09-08-2019 04:45:40'),
(53,2,1,'Market Adjustment','200','2019-08','09-08-2019 04:45:40'),
(54,2,1,'Meal Allowance','100','2019-08','09-08-2019 04:45:40'),
(55,2,1,'Transportation Allowance','200','2019-08','09-08-2019 04:45:40'),
(56,3,1,'Cost of Living Allowance','100','2019-07','10-08-2019 08:21:16'),
(57,3,1,'Housing Allowance','200','2019-07','10-08-2019 08:21:16'),
(58,3,1,'Market Adjustment','200','2019-07','10-08-2019 08:21:16'),
(59,3,1,'Meal Allowance','100','2019-07','10-08-2019 08:21:16'),
(60,3,1,'Transportation Allowance','200','2019-07','10-08-2019 08:21:16'),
(61,5,1,'Cost of Living Allowance','100','2019-10','18-11-2019 07:19:53'),
(62,5,1,'Housing Allowance','200','2019-10','18-11-2019 07:19:53'),
(63,5,1,'Market Adjustment','200','2019-10','18-11-2019 07:19:53'),
(64,5,1,'Meal Allowance','100','2019-10','18-11-2019 07:19:53'),
(65,5,1,'Transportation Allowance','200','2019-10','18-11-2019 07:19:53'),
(66,7,1,'Cost of Living Allowance','100','2019-09','18-11-2019 07:20:42'),
(67,7,1,'Housing Allowance','200','2019-09','18-11-2019 07:20:42'),
(68,7,1,'Market Adjustment','200','2019-09','18-11-2019 07:20:42'),
(69,7,1,'Meal Allowance','100','2019-09','18-11-2019 07:20:42'),
(70,7,1,'Transportation Allowance','200','2019-09','18-11-2019 07:20:42'),
(71,9,75,'Lembur','111','2019-12','2019-12-04 20:59:53'),
(72,9,75,'Bonus','222','2019-12','2019-12-04 20:59:53'),
(73,9,75,'Tunjangan Kesehatan','333','2019-12','2019-12-04 20:59:53'),
(74,9,75,'Tunjangan Lainnya','444','2019-12','2019-12-04 20:59:53'),
(75,9,75,'Paid Leaves','555','2019-12','2019-12-04 20:59:53'),
(76,9,75,'THR','666','2019-12','2019-12-04 20:59:53'),
(77,10,9,'Uang Lembur','10000','2019-12','2019-12-20 15:35:31'),
(78,10,9,'Uang Pijit','10000','2019-12','2019-12-20 15:35:31');

/*Table structure for table `xin_salary_payslip_loan` */

DROP TABLE IF EXISTS `xin_salary_payslip_loan`;

CREATE TABLE `xin_salary_payslip_loan` (
  `payslip_loan_id` int(11) NOT NULL AUTO_INCREMENT,
  `payslip_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `loan_title` varchar(200) NOT NULL,
  `loan_amount` varchar(200) NOT NULL,
  `salary_month` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`payslip_loan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_payslip_loan` */

insert  into `xin_salary_payslip_loan`(`payslip_loan_id`,`payslip_id`,`employee_id`,`loan_title`,`loan_amount`,`salary_month`,`created_at`) values 
(3,8,1,'Test Loan','100','2018-10','11-10-2018 01:16:41'),
(4,9,1,'Test Loan','100','2019-01','04-01-2019 08:22:50'),
(5,11,1,'Test Loan','100','2019-02','04-01-2019 08:28:00'),
(6,12,1,'Test Loan','100','2019-01','07-01-2019 06:56:32'),
(7,14,1,'Test Loan','100','2019-01','07-01-2019 06:56:37'),
(8,1,1,'Test Loan','100','2019-06','11-07-2019 05:43:52'),
(9,2,1,'Test Loan','100','2019-08','09-08-2019 04:45:40'),
(10,3,1,'Test Loan','100','2019-07','10-08-2019 08:21:16'),
(11,4,75,'Cashbon','1000000','2019-10','18-11-2019 02:45:38'),
(12,5,1,'Test Loan','100','2019-10','18-11-2019 07:19:53'),
(13,6,75,'Cashbon','1000000','2019-10','18-11-2019 07:19:53'),
(14,7,1,'Test Loan','100','2019-09','18-11-2019 07:20:42'),
(15,8,75,'Cashbon','1000000','2019-09','18-11-2019 07:20:42');

/*Table structure for table `xin_salary_payslip_overtime` */

DROP TABLE IF EXISTS `xin_salary_payslip_overtime`;

CREATE TABLE `xin_salary_payslip_overtime` (
  `payslip_overtime_id` int(11) NOT NULL AUTO_INCREMENT,
  `payslip_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `overtime_title` varchar(200) NOT NULL,
  `overtime_salary_month` varchar(200) NOT NULL,
  `overtime_no_of_days` varchar(200) NOT NULL,
  `overtime_hours` varchar(200) NOT NULL,
  `overtime_rate` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`payslip_overtime_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_payslip_overtime` */

insert  into `xin_salary_payslip_overtime`(`payslip_overtime_id`,`payslip_id`,`employee_id`,`overtime_title`,`overtime_salary_month`,`overtime_no_of_days`,`overtime_hours`,`overtime_rate`,`created_at`) values 
(3,8,1,'1/2 Rest Day','2018-10','26','4','0.5','11-10-2018 01:16:41'),
(4,9,1,'1/2 Rest Day','2019-01','26','4','0.5','04-01-2019 08:22:50'),
(5,11,1,'1/2 Rest Day','2019-02','26','4','0.5','04-01-2019 08:28:00'),
(6,12,1,'1/2 Rest Day','2019-01','26','4','0.5','07-01-2019 06:56:32'),
(7,14,1,'1/2 Rest Day','2019-01','26','4','0.5','07-01-2019 06:56:37'),
(8,1,1,'1/2 Rest Day','2019-06','26','4','0.5','11-07-2019 05:43:52'),
(9,2,1,'1/2 Rest Day','2019-08','26','4','0.5','09-08-2019 04:45:40'),
(10,3,1,'1/2 Rest Day','2019-07','26','4','0.5','10-08-2019 08:21:16'),
(11,4,75,'Lembur','2019-10','1','1','100000','18-11-2019 02:45:38'),
(12,5,1,'Lembur','2019-10','26','1','100000','18-11-2019 07:19:53'),
(13,6,75,'Lembur','2019-10','1','1','100000','18-11-2019 07:19:53'),
(14,6,75,'Juni 2019','2019-10','1','2','100000','18-11-2019 07:19:53'),
(15,7,1,'Lembur','2019-09','26','1','100000','18-11-2019 07:20:42'),
(16,8,75,'Lembur','2019-09','1','1','100000','18-11-2019 07:20:42'),
(17,8,75,'Juni 2019','2019-09','1','2','100000','18-11-2019 07:20:42');

/*Table structure for table `xin_salary_payslips` */

DROP TABLE IF EXISTS `xin_salary_payslips`;

CREATE TABLE `xin_salary_payslips` (
  `payslip_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `salary_month` varchar(200) NOT NULL,
  `wages_type` int(11) NOT NULL,
  `basic_salary` varchar(200) NOT NULL,
  `daily_wages` varchar(200) NOT NULL,
  `salary_ssempee` varchar(200) NOT NULL,
  `salary_ssempeer` varchar(200) NOT NULL,
  `salary_income_tax` varchar(200) NOT NULL,
  `salary_commission` varchar(200) NOT NULL,
  `salary_claims` varchar(200) NOT NULL,
  `salary_paid_leave` varchar(200) NOT NULL,
  `salary_director_fees` varchar(200) NOT NULL,
  `salary_advance_paid` varchar(200) NOT NULL,
  `total_allowances` varchar(200) NOT NULL,
  `total_adjustment_minus` bigint(20) NOT NULL,
  `total_loan` varchar(200) NOT NULL,
  `total_overtime` varchar(200) NOT NULL,
  `statutory_deductions` varchar(200) NOT NULL,
  `net_salary` varchar(200) NOT NULL,
  `other_payment` varchar(200) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `pay_comments` mediumtext NOT NULL,
  `is_payment` int(11) NOT NULL,
  `year_to_date` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`payslip_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_payslips` */

insert  into `xin_salary_payslips`(`payslip_id`,`employee_id`,`department_id`,`company_id`,`designation_id`,`salary_month`,`wages_type`,`basic_salary`,`daily_wages`,`salary_ssempee`,`salary_ssempeer`,`salary_income_tax`,`salary_commission`,`salary_claims`,`salary_paid_leave`,`salary_director_fees`,`salary_advance_paid`,`total_allowances`,`total_adjustment_minus`,`total_loan`,`total_overtime`,`statutory_deductions`,`net_salary`,`other_payment`,`payment_method`,`pay_comments`,`is_payment`,`year_to_date`,`created_at`) values 
(1,1,2,1,15,'2019-06',1,'1000','','8','17','10','1','2','3','0','0','800',0,'100','2','324','2032.00','6',0,'',1,'11-07-2019','11-07-2019 05:43:52'),
(2,1,2,1,15,'2019-08',1,'1000','','8','17','10','1','2','3','0','0','800',0,'100','2','324','2032.00','6',0,'',1,'09-08-2019','09-08-2019 04:45:40'),
(3,1,2,1,15,'2019-07',1,'1000','','8','17','10','1','2','3','0','0','800',0,'100','2','324','2032.00','6',0,'',1,'10-08-2019','10-08-2019 08:21:16'),
(4,75,2,1,13,'2019-10',1,'7000000','','0','0','0','500000','500000','500000','500000','500000','0',0,'1000000','100000','0','8600000.00','2500000',0,'',1,'18-11-2019','18-11-2019 02:45:38'),
(5,1,2,1,15,'2019-10',1,'1000','','8','17','10','1','2','3','0','0','800',0,'100','100000','324','102030.00','6',0,'',1,'18-11-2019','18-11-2019 07:19:53'),
(6,75,2,1,13,'2019-10',1,'7000000','','0','0','0','500000','500000','500000','500000','500000','0',0,'1000000','300000','0','8800000.00','2500000',0,'',1,'18-11-2019','18-11-2019 07:19:53'),
(7,1,2,1,15,'2019-09',1,'1000','','8','17','10','1','2','3','0','0','800',0,'100','100000','324','102030.00','6',0,'',1,'18-11-2019','18-11-2019 07:20:42'),
(8,75,2,1,13,'2019-09',1,'7000000','','0','0','0','500000','500000','500000','500000','500000','0',0,'1000000','300000','0','8800000.00','2500000',0,'',1,'18-11-2019','18-11-2019 07:20:42'),
(9,75,2,1,13,'2019-12',1,'7000000','','0','0','0','0','0','0','0','0','2331',3674,'','','','6998657.00','',0,'',1,'04-12-2019','04-12-2019 08:59:53'),
(10,9,6,1,17,'2019-12',1,'100000','','0','0','0','0','0','0','0','0','20000',5000,'','','','115000.00','',0,'',1,'20-12-2019','20-12-2019 03:35:31');

/*Table structure for table `xin_salary_templates` */

DROP TABLE IF EXISTS `xin_salary_templates`;

CREATE TABLE `xin_salary_templates` (
  `salary_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `salary_grades` varchar(255) NOT NULL,
  `basic_salary` varchar(255) NOT NULL,
  `overtime_rate` varchar(255) NOT NULL,
  `house_rent_allowance` varchar(255) NOT NULL,
  `medical_allowance` varchar(255) NOT NULL,
  `travelling_allowance` varchar(255) NOT NULL,
  `dearness_allowance` varchar(255) NOT NULL,
  `security_deposit` varchar(255) NOT NULL,
  `provident_fund` varchar(255) NOT NULL,
  `tax_deduction` varchar(255) NOT NULL,
  `gross_salary` varchar(255) NOT NULL,
  `total_allowance` varchar(255) NOT NULL,
  `total_deduction` varchar(255) NOT NULL,
  `net_salary` varchar(255) NOT NULL,
  `added_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`salary_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `xin_salary_templates` */

insert  into `xin_salary_templates`(`salary_template_id`,`company_id`,`salary_grades`,`basic_salary`,`overtime_rate`,`house_rent_allowance`,`medical_allowance`,`travelling_allowance`,`dearness_allowance`,`security_deposit`,`provident_fund`,`tax_deduction`,`gross_salary`,`total_allowance`,`total_deduction`,`net_salary`,`added_by`,`created_at`) values 
(1,1,'Monthly','2500','','50','60','70','80','40','20','30','2760','260','90','2670',1,'22-03-2018 01:40:06');

/*Table structure for table `xin_sub_departments` */

DROP TABLE IF EXISTS `xin_sub_departments`;

CREATE TABLE `xin_sub_departments` (
  `sub_department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `department_name` varchar(200) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`sub_department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

/*Data for the table `xin_sub_departments` */

insert  into `xin_sub_departments`(`sub_department_id`,`department_id`,`department_name`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(13,2,'Withdrawl','2019-03-14 20:33:41',0,NULL,0,NULL,0),
(14,1,'Developer','2019-03-14 20:33:46',0,NULL,0,NULL,0),
(15,1,'Sysadmin','2019-03-14 20:33:50',0,NULL,0,NULL,0),
(16,5,'Recruitment/Personalia','2019-03-14 20:34:02',0,NULL,0,NULL,0),
(17,5,'Legal & QA','2019-03-14 20:34:10',0,NULL,0,NULL,0),
(19,6,'Finance Analyst','2019-03-14 20:34:37',0,NULL,0,NULL,0),
(20,9,'Digital Marketing','2019-03-14 20:35:07',0,NULL,0,NULL,0),
(21,2,'CS & Sales','2019-03-14 20:35:24',0,NULL,0,NULL,0),
(32,2,'CS & Deposit','2019-07-12 17:40:01',0,NULL,0,NULL,0),
(33,5,'GA','2019-07-12 17:41:25',0,NULL,0,NULL,0),
(34,6,'Accounting','2019-07-12 17:41:52',0,NULL,0,NULL,0),
(35,10,'Auditor','2019-07-12 17:42:54',0,NULL,0,NULL,0),
(36,10,'Research','2019-07-12 17:43:08',0,NULL,0,NULL,0),
(37,11,'Director','2019-07-12 17:43:27',0,NULL,0,NULL,0),
(38,11,'Manager','2019-07-12 17:43:42',0,NULL,0,NULL,0),
(39,11,'Wakil Manager I','2019-07-12 17:43:56',0,NULL,0,NULL,0),
(40,11,'Wakil Manager II','2019-07-12 17:44:06',0,NULL,0,NULL,0),
(42,13,'BUSINESS DEVELOPMENT','2019-12-20 15:12:58',0,NULL,0,NULL,0);

/*Table structure for table `xin_support_ticket_files` */

DROP TABLE IF EXISTS `xin_support_ticket_files`;

CREATE TABLE `xin_support_ticket_files` (
  `ticket_file_id` int(111) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(111) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `ticket_files` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`ticket_file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_support_ticket_files` */

/*Table structure for table `xin_support_tickets` */

DROP TABLE IF EXISTS `xin_support_tickets`;

CREATE TABLE `xin_support_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `ticket_code` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `employee_id` int(111) NOT NULL,
  `ticket_priority` varchar(255) NOT NULL,
  `department_id` int(111) NOT NULL,
  `sub_department_id` int(11) NOT NULL DEFAULT 0,
  `assigned_to` mediumtext NOT NULL,
  `message` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `ticket_remarks` mediumtext NOT NULL,
  `ticket_status` varchar(200) NOT NULL,
  `ticket_note` mediumtext NOT NULL,
  `received_by` int(111) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `xin_support_tickets` */

insert  into `xin_support_tickets`(`ticket_id`,`company_id`,`ticket_code`,`subject`,`employee_id`,`ticket_priority`,`department_id`,`sub_department_id`,`assigned_to`,`message`,`description`,`ticket_remarks`,`ticket_status`,`ticket_note`,`received_by`,`created_at`) values 
(1,1,'YD9M7AX','Test tickewt',11,'2',0,0,'','','Ngopi pakkk','gmn','2','',11,'02-07-2019 12:18:48'),
(2,1,'I8SJ09I','sudah makan ?',75,'3',0,0,'','','','','3','',0,'17-11-2019 02:38:20'),
(3,1,'L744LS4','test',0,'3',2,21,'','','','','1','',0,'17-11-2019 02:38:55'),
(4,1,'MMNNG18','testt',75,'3',0,0,'','','tess','','1','',0,'17-11-2019 02:39:22'),
(5,1,'UILDBL4','subject dah',35,'3',0,0,'','','desc dah','','1','',0,'18-11-2019 10:39:07'),
(6,1,'BC5423B','test',75,'4',0,0,'','','','','1','',0,'18-11-2019 10:54:37'),
(7,1,'1LUSPLG','aaaaaaa',75,'1',0,0,'','','','','1','',0,'18-11-2019 10:55:23'),
(8,1,'9UKWQ3R','test ganti status open pending close blah blah',76,'2',0,0,'','','test ganti status open pending close blah blah','','3','',0,'18-11-2019 08:13:55'),
(9,1,'8LWAJV9','halo',0,'3',2,21,'','','','','1','',0,'19-11-2019 10:30:41'),
(10,1,'MQWL4NL','TESTING',9,'3',0,0,'','','BAYAR UTANG','','1','',0,'20-12-2019 03:22:00');

/*Table structure for table `xin_system_setting` */

DROP TABLE IF EXISTS `xin_system_setting`;

CREATE TABLE `xin_system_setting` (
  `setting_id` int(111) NOT NULL AUTO_INCREMENT,
  `application_name` varchar(255) NOT NULL,
  `default_currency` varchar(255) NOT NULL,
  `default_currency_id` int(11) NOT NULL,
  `default_currency_symbol` varchar(255) NOT NULL,
  `show_currency` varchar(255) NOT NULL,
  `currency_position` varchar(255) NOT NULL,
  `notification_position` varchar(255) NOT NULL,
  `notification_close_btn` varchar(255) NOT NULL,
  `notification_bar` varchar(255) NOT NULL,
  `enable_registration` varchar(255) NOT NULL,
  `login_with` varchar(255) NOT NULL,
  `date_format_xi` varchar(255) NOT NULL,
  `employee_manage_own_contact` varchar(255) NOT NULL,
  `employee_manage_own_profile` varchar(255) NOT NULL,
  `employee_manage_own_qualification` varchar(255) NOT NULL,
  `employee_manage_own_work_experience` varchar(255) NOT NULL,
  `employee_manage_own_document` varchar(255) NOT NULL,
  `employee_manage_own_picture` varchar(255) NOT NULL,
  `employee_manage_own_social` varchar(255) NOT NULL,
  `employee_manage_own_bank_account` varchar(255) NOT NULL,
  `enable_attendance` varchar(255) NOT NULL,
  `enable_clock_in_btn` varchar(255) NOT NULL,
  `enable_email_notification` varchar(255) NOT NULL,
  `payroll_include_day_summary` varchar(255) NOT NULL,
  `payroll_include_hour_summary` varchar(255) NOT NULL,
  `payroll_include_leave_summary` varchar(255) NOT NULL,
  `enable_job_application_candidates` varchar(255) NOT NULL,
  `job_logo` varchar(255) NOT NULL,
  `payroll_logo` varchar(255) NOT NULL,
  `is_payslip_password_generate` int(11) NOT NULL,
  `payslip_password_format` varchar(255) NOT NULL,
  `enable_profile_background` varchar(255) NOT NULL,
  `enable_policy_link` varchar(255) NOT NULL,
  `enable_layout` varchar(255) NOT NULL,
  `job_application_format` mediumtext NOT NULL,
  `project_email` varchar(255) NOT NULL,
  `holiday_email` varchar(255) NOT NULL,
  `leave_email` varchar(255) NOT NULL,
  `payslip_email` varchar(255) NOT NULL,
  `award_email` varchar(255) NOT NULL,
  `recruitment_email` varchar(255) NOT NULL,
  `announcement_email` varchar(255) NOT NULL,
  `training_email` varchar(255) NOT NULL,
  `task_email` varchar(255) NOT NULL,
  `compact_sidebar` varchar(255) NOT NULL,
  `fixed_header` varchar(255) NOT NULL,
  `fixed_sidebar` varchar(255) NOT NULL,
  `boxed_wrapper` varchar(255) NOT NULL,
  `layout_static` varchar(255) NOT NULL,
  `system_skin` varchar(255) NOT NULL,
  `animation_effect` varchar(255) NOT NULL,
  `animation_effect_modal` varchar(255) NOT NULL,
  `animation_effect_topmenu` varchar(255) NOT NULL,
  `footer_text` varchar(255) NOT NULL,
  `system_timezone` varchar(200) NOT NULL,
  `system_ip_address` varchar(255) NOT NULL,
  `system_ip_restriction` varchar(200) NOT NULL,
  `google_maps_api_key` mediumtext NOT NULL,
  `module_recruitment` varchar(100) NOT NULL,
  `module_travel` varchar(100) NOT NULL,
  `module_performance` varchar(100) NOT NULL,
  `module_files` varchar(100) NOT NULL,
  `module_awards` varchar(100) NOT NULL,
  `module_training` varchar(100) NOT NULL,
  `module_inquiry` varchar(100) NOT NULL,
  `module_language` varchar(100) NOT NULL,
  `module_orgchart` varchar(100) NOT NULL,
  `module_accounting` varchar(111) NOT NULL,
  `module_events` varchar(100) NOT NULL,
  `module_goal_tracking` varchar(100) NOT NULL,
  `module_assets` varchar(100) NOT NULL,
  `module_projects_tasks` varchar(100) NOT NULL,
  `module_chat_box` varchar(100) NOT NULL,
  `module_appraisal` varchar(100) NOT NULL,
  `module_offday` varchar(100) NOT NULL,
  `module_immigrations` varchar(100) NOT NULL,
  `enable_page_rendered` varchar(255) NOT NULL,
  `enable_current_year` varchar(255) NOT NULL,
  `employee_login_id` varchar(200) NOT NULL,
  `enable_auth_background` varchar(11) NOT NULL,
  `hr_version` varchar(200) NOT NULL,
  `hr_release_date` varchar(100) NOT NULL,
  `updated_at` varchar(255) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `xin_system_setting` */

insert  into `xin_system_setting`(`setting_id`,`application_name`,`default_currency`,`default_currency_id`,`default_currency_symbol`,`show_currency`,`currency_position`,`notification_position`,`notification_close_btn`,`notification_bar`,`enable_registration`,`login_with`,`date_format_xi`,`employee_manage_own_contact`,`employee_manage_own_profile`,`employee_manage_own_qualification`,`employee_manage_own_work_experience`,`employee_manage_own_document`,`employee_manage_own_picture`,`employee_manage_own_social`,`employee_manage_own_bank_account`,`enable_attendance`,`enable_clock_in_btn`,`enable_email_notification`,`payroll_include_day_summary`,`payroll_include_hour_summary`,`payroll_include_leave_summary`,`enable_job_application_candidates`,`job_logo`,`payroll_logo`,`is_payslip_password_generate`,`payslip_password_format`,`enable_profile_background`,`enable_policy_link`,`enable_layout`,`job_application_format`,`project_email`,`holiday_email`,`leave_email`,`payslip_email`,`award_email`,`recruitment_email`,`announcement_email`,`training_email`,`task_email`,`compact_sidebar`,`fixed_header`,`fixed_sidebar`,`boxed_wrapper`,`layout_static`,`system_skin`,`animation_effect`,`animation_effect_modal`,`animation_effect_topmenu`,`footer_text`,`system_timezone`,`system_ip_address`,`system_ip_restriction`,`google_maps_api_key`,`module_recruitment`,`module_travel`,`module_performance`,`module_files`,`module_awards`,`module_training`,`module_inquiry`,`module_language`,`module_orgchart`,`module_accounting`,`module_events`,`module_goal_tracking`,`module_assets`,`module_projects_tasks`,`module_chat_box`,`module_appraisal`,`module_offday`,`module_immigrations`,`enable_page_rendered`,`enable_current_year`,`employee_login_id`,`enable_auth_background`,`hr_version`,`hr_release_date`,`updated_at`) values 
(1,'KANON - HRM','IDR - Rp.',1,'IDR - Rp.','symbol','Prefix','toast-bottom-right','true','false','no','username','d-M-Y','','','','','','','yes','','yes','','','yes','yes','yes','','job_logo_1577969217.png','payroll_logo_1534786335.jpg',0,'dateofbirth','yes','yes','yes','doc,docx,pdf','yes','yes','yes','yes','yes','yes','yes','yes','yes','sidebar_layout_hrsale','','fixed-sidebar','boxed_layout_hrsale','','skin-default','fadeInDown','tada','tada','KANON - HRM','Asia/Bangkok','::1','','AIzaSyB3gP8H3eypotNeoEtezbRiF_f8Zh_p4ck','true','true','true','true','true','true','true','true','true','true','true','true','true','true','true','true','true','true','','yes','username','','1.0.3','2018-03-28','2018-03-28 04:27:32');

/*Table structure for table `xin_tasks` */

DROP TABLE IF EXISTS `xin_tasks`;

CREATE TABLE `xin_tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `project_id` int(111) NOT NULL,
  `created_by` int(111) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `assigned_to` varchar(255) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `task_hour` varchar(200) NOT NULL,
  `task_progress` varchar(200) NOT NULL,
  `description` mediumtext NOT NULL,
  `task_status` int(5) NOT NULL,
  `task_note` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_tasks` */

insert  into `xin_tasks`(`task_id`,`company_id`,`project_id`,`created_by`,`task_name`,`assigned_to`,`start_date`,`end_date`,`task_hour`,`task_progress`,`description`,`task_status`,`task_note`,`created_at`) values 
(1,1,1,54,'test a2','75','2019-11-18','2019-11-19','24','0','',2,'segera','2019-11-18 07:33:24'),
(3,1,1,110,'debug','7,8','2020-02-02','2020-02-09','12','32','xxxxxxx',3,'bbbb','2020-02-08 09:28:41');

/*Table structure for table `xin_tasks_attachment` */

DROP TABLE IF EXISTS `xin_tasks_attachment`;

CREATE TABLE `xin_tasks_attachment` (
  `task_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` mediumtext NOT NULL,
  `attachment_file` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`task_attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_tasks_attachment` */

insert  into `xin_tasks_attachment`(`task_attachment_id`,`task_id`,`upload_by`,`file_title`,`file_description`,`attachment_file`,`created_at`) values 
(1,1,75,'aaaa','tes','task_1574081506.png','18-11-2019 07:51:45'),
(2,3,110,'debugger','edyfbjekfregrig','task_1581129022.xlsx','08-02-2020 09:30:21');

/*Table structure for table `xin_tasks_comments` */

DROP TABLE IF EXISTS `xin_tasks_comments`;

CREATE TABLE `xin_tasks_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `task_comments` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `xin_tasks_comments` */

insert  into `xin_tasks_comments`(`comment_id`,`task_id`,`user_id`,`task_comments`,`created_at`) values 
(1,1,75,'halo','18-11-2019 07:51:12'),
(2,1,75,'tes','18-11-2019 07:51:19'),
(3,1,75,'iya lalu ?','18-11-2019 07:51:25'),
(4,3,110,'oke oke','08-02-2020 09:29:18'),
(5,3,110,'sippp','08-02-2020 09:29:33');

/*Table structure for table `xin_tax_types` */

DROP TABLE IF EXISTS `xin_tax_types`;

CREATE TABLE `xin_tax_types` (
  `tax_id` int(111) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `xin_tax_types` */

insert  into `xin_tax_types`(`tax_id`,`name`,`rate`,`type`,`description`,`created_at`) values 
(1,'No Tax','0','fixed','test','25-05-2018'),
(2,'IVU','2','fixed','test','25-05-2018'),
(3,'VAT','5','percentage','testttt','25-05-2018');

/*Table structure for table `xin_termination_type` */

DROP TABLE IF EXISTS `xin_termination_type`;

CREATE TABLE `xin_termination_type` (
  `termination_type_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`termination_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_termination_type` */

insert  into `xin_termination_type`(`termination_type_id`,`company_id`,`type`,`created_at`) values 
(1,1,'Voluntary Termination','22-03-2018 01:38:41');

/*Table structure for table `xin_theme_settings` */

DROP TABLE IF EXISTS `xin_theme_settings`;

CREATE TABLE `xin_theme_settings` (
  `theme_settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `fixed_layout` varchar(200) NOT NULL,
  `fixed_footer` varchar(200) NOT NULL,
  `boxed_layout` varchar(200) NOT NULL,
  `page_header` varchar(200) NOT NULL,
  `footer_layout` varchar(200) NOT NULL,
  `statistics_cards` varchar(200) NOT NULL,
  `statistics_cards_background` varchar(200) NOT NULL,
  `employee_cards` varchar(200) NOT NULL,
  `card_border_color` varchar(200) NOT NULL,
  `compact_menu` varchar(200) NOT NULL,
  `flipped_menu` varchar(200) NOT NULL,
  `right_side_icons` varchar(200) NOT NULL,
  `bordered_menu` varchar(200) NOT NULL,
  `form_design` varchar(200) NOT NULL,
  `is_semi_dark` int(11) NOT NULL,
  `semi_dark_color` varchar(200) NOT NULL,
  `top_nav_dark_color` varchar(200) NOT NULL,
  `menu_color_option` varchar(200) NOT NULL,
  `export_orgchart` varchar(100) NOT NULL,
  `export_file_title` mediumtext NOT NULL,
  `org_chart_layout` varchar(200) NOT NULL,
  `org_chart_zoom` varchar(100) NOT NULL,
  `org_chart_pan` varchar(100) NOT NULL,
  PRIMARY KEY (`theme_settings_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `xin_theme_settings` */

insert  into `xin_theme_settings`(`theme_settings_id`,`fixed_layout`,`fixed_footer`,`boxed_layout`,`page_header`,`footer_layout`,`statistics_cards`,`statistics_cards_background`,`employee_cards`,`card_border_color`,`compact_menu`,`flipped_menu`,`right_side_icons`,`bordered_menu`,`form_design`,`is_semi_dark`,`semi_dark_color`,`top_nav_dark_color`,`menu_color_option`,`export_orgchart`,`export_file_title`,`org_chart_layout`,`org_chart_zoom`,`org_chart_pan`) values 
(1,'false','true','false','','','4','','','','true','false','false','false','basic_form',1,'bg-primary','bg-blue-grey','menu-dark','true','APG Organization Chart','t2b','true','true');

/*Table structure for table `xin_tickets_attachment` */

DROP TABLE IF EXISTS `xin_tickets_attachment`;

CREATE TABLE `xin_tickets_attachment` (
  `ticket_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(200) NOT NULL,
  `upload_by` int(255) NOT NULL,
  `file_title` varchar(255) NOT NULL,
  `file_description` mediumtext NOT NULL,
  `attachment_file` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`ticket_attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xin_tickets_attachment` */

/*Table structure for table `xin_tickets_comments` */

DROP TABLE IF EXISTS `xin_tickets_comments`;

CREATE TABLE `xin_tickets_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `ticket_comments` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_tickets_comments` */

insert  into `xin_tickets_comments`(`comment_id`,`ticket_id`,`user_id`,`ticket_comments`,`created_at`) values 
(1,1,7,'komen1','03-07-2019 12:15:44'),
(2,1,11,'kopinya habis pak','15-12-2019 02:30:38');

/*Table structure for table `xin_trainers` */

DROP TABLE IF EXISTS `xin_trainers`;

CREATE TABLE `xin_trainers` (
  `trainer_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `designation_id` int(111) NOT NULL,
  `expertise` mediumtext NOT NULL,
  `address` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`trainer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `xin_trainers` */

insert  into `xin_trainers`(`trainer_id`,`company_id`,`first_name`,`last_name`,`contact_number`,`email`,`designation_id`,`expertise`,`address`,`status`,`created_at`) values 
(1,1,'Vegeta','bucin','000000','bucin@gmail.com',0,'dddddd','sssssssss',1,'08-02-2020'),
(2,1,'sssss','ssssss','ssssss','sss@g.c',0,'ssssss','ssssssss',1,'08-02-2020');

/*Table structure for table `xin_training` */

DROP TABLE IF EXISTS `xin_training`;

CREATE TABLE `xin_training` (
  `training_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` varchar(200) NOT NULL,
  `training_type_id` int(200) NOT NULL,
  `trainer_id` int(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `finish_date` varchar(200) NOT NULL,
  `training_cost` varchar(200) NOT NULL,
  `training_status` int(200) NOT NULL,
  `description` mediumtext NOT NULL,
  `performance` varchar(200) NOT NULL,
  `remarks` mediumtext NOT NULL,
  `created_at` varchar(200) NOT NULL,
  PRIMARY KEY (`training_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `xin_training` */

insert  into `xin_training`(`training_id`,`company_id`,`employee_id`,`training_type_id`,`trainer_id`,`start_date`,`finish_date`,`training_cost`,`training_status`,`description`,`performance`,`remarks`,`created_at`) values 
(1,1,'110',3,1,'2020-02-01','2020-03-31','3000 USD',0,'sddwddw','','','08-02-2020 11:19:08');

/*Table structure for table `xin_training_types` */

DROP TABLE IF EXISTS `xin_training_types`;

CREATE TABLE `xin_training_types` (
  `training_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`training_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_training_types` */

insert  into `xin_training_types`(`training_type_id`,`company_id`,`type`,`created_at`,`status`) values 
(1,1,'Job Training','19-03-2018 06:45:47',1),
(2,1,'Workshop','19-03-2018 06:45:51',1),
(3,1,'healthy','08-02-2020 11:17:57',1);

/*Table structure for table `xin_travel_arrangement_type` */

DROP TABLE IF EXISTS `xin_travel_arrangement_type`;

CREATE TABLE `xin_travel_arrangement_type` (
  `arrangement_type_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`arrangement_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_travel_arrangement_type` */

insert  into `xin_travel_arrangement_type`(`arrangement_type_id`,`company_id`,`type`,`status`,`created_at`) values 
(1,1,'Corporation',1,'19-03-2018 08:45:17'),
(2,1,'Guest House',1,'19-03-2018 08:45:27');

/*Table structure for table `xin_user_roles` */

DROP TABLE IF EXISTS `xin_user_roles`;

CREATE TABLE `xin_user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `role_name` varchar(200) NOT NULL,
  `role_access` varchar(200) NOT NULL,
  `role_resources` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_user_roles` */

insert  into `xin_user_roles`(`role_id`,`company_id`,`role_name`,`role_access`,`role_resources`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(1,1,'Manager','1','0,13,88,3,4,5,249,6,253,28,2088,1017,2075,2076,2086,30,30,277,278,279,31,7,280,281,379,46,46,287,288,289,290,383,1001,2001,2004,1002,2008,1003,2011,2013,2085,1004,2018,1008,2039,1005,2023,1009,2044,1006,2028,1007,2033,1012,1015,1024,1027','2018-02-20 00:00:00',35,'2020-02-14 09:28:14',35,NULL,0),
(2,1,'Supervisor','2','0,13,201,202,88,23,204,205,3,4,5,249,6,253,,28,2087,2088,1017,1017,2075,2076,2078,2086,30,277,278,31,7,379,46,287,288,289,383,40,41,41,298,299,300,301,42,42,302,303,304,305,380,1001,2001,2004,1002,2008,1003,2011,2013,2084,1004,2018,1008,2039,1005,2023,1009,2044,1006,2028,1007,2033,1012,1015,1024,1027','2018-03-21 00:00:00',35,'2020-02-14 09:22:58',35,NULL,0),
(3,1,'User','2','0,13,201,202,88,3,4,5,249,6,253,28,2087,1017,2075,2076,2078,31,7,379,46,287,288,289,383,1001,2001,2004,1002,2008,1003,2010,2011,2014,1004,2018,1008,2039,1005,2023,1009,2044,1006,2028,1007,2033,1012,1015,1024,1027','2018-03-21 00:00:00',35,'2020-02-14 09:22:58',35,NULL,0),
(4,1,'Staff Adm','2','0,13,201,202,88,3,4,5,249,6,253,28,2087,1017,2075,2076,2078,31,7,379,46,287,288,289,383,1001,2001,2004,1002,2008,1003,2010,2011,2014,1004,2018,1008,2039,1005,2023,1009,2044,1006,2028,1007,2033,1012,1015,1024,1027','2018-03-21 00:00:00',35,'2020-02-14 09:22:58',35,NULL,0);

/*Table structure for table `xin_users` */

DROP TABLE IF EXISTS `xin_users`;

CREATE TABLE `xin_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(30) NOT NULL DEFAULT 'administrator',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `profile_background` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address_1` text NOT NULL,
  `address_2` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` int(11) NOT NULL,
  `last_login_date` varchar(255) NOT NULL,
  `last_login_ip` varchar(255) NOT NULL,
  `is_logged_in` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_users` */

insert  into `xin_users`(`user_id`,`user_role`,`first_name`,`last_name`,`company_name`,`company_logo`,`user_type`,`email`,`username`,`password`,`profile_photo`,`profile_background`,`contact_number`,`gender`,`address_1`,`address_2`,`city`,`state`,`zipcode`,`country`,`last_login_date`,`last_login_ip`,`is_logged_in`,`is_active`,`created_at`) values 
(1,'administrator','Thomas','Fleming','','',2,'test1@test.com','admin','test123','user_1520720863.jpg','profile_background_1505458640.jpg','12333332','Male','Address Line 1','Address Line 2','City','State','12345',230,'15-04-2018 07:36:12','::1',0,1,'14-09-2017 10:02:54'),
(2,'administrator','Main','Office','','',2,'test@test.com','test','test123','user_1523821315.jpg','','1234567890','Male','Address Line 1','Address Line 2','City','State','11461',190,'23-04-2018 05:34:47','::1',0,1,'15-04-2018 06:13:08'),
(4,'administrator','Fiona','Grace','HRSALE','employer_1524025572.jpg',1,'employer@test.com','','test123','','','1234567890','Male','Address Line 1','Address Line 2','City','State','11461',190,'23-04-2018 05:34:54','::1',0,1,'18-04-2018 07:26:12');

/*Table structure for table `xin_warning_type` */

DROP TABLE IF EXISTS `xin_warning_type`;

CREATE TABLE `xin_warning_type` (
  `warning_type_id` int(111) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`warning_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `xin_warning_type` */

insert  into `xin_warning_type`(`warning_type_id`,`company_id`,`type`,`created_by`,`created_at`) values 
(1,1,'First Warning',35,'2019-06-18 00:00:00'),
(2,1,'Second Warning',35,'2019-06-18 04:58:31'),
(3,1,'Third Warning',35,'2019-06-18 04:59:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
