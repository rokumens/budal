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

/*Table structure for table `orchardpools_settings` */

DROP TABLE IF EXISTS `orchardpools_settings`;

CREATE TABLE `orchardpools_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timezone` varchar(255) NOT NULL,
  `countdown_start` time NOT NULL,
  `countdown_stop` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `orchardpools_settings` */

insert  into `orchardpools_settings`(`id`,`timezone`,`countdown_start`,`countdown_stop`) values 
(1,'Asia/Phnom_Penh','21:18:05','16:40:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
