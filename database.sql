/*
SQLyog Ultimate v12.5.1 (32 bit)
MySQL - 10.4.19-MariaDB : Database - crud_fullstack_test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`crud_fullstack_test` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `crud_fullstack_test`;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`created_at`,`updated_at`) values 
(6,'3443','2023-10-07 17:21:25','2023-10-07 17:21:25'),
(7,'3434fdad','2023-10-07 17:36:45','2023-10-07 17:36:45'),
(8,'3434fdad','2023-10-07 17:36:49','2023-10-07 17:36:49'),
(9,'hhhh','2023-10-07 17:37:06','2023-10-07 17:37:06'),
(10,'gafdasfasf','2023-10-07 17:37:53','2023-10-07 17:37:53');

/*Table structure for table `user_has_roles` */

DROP TABLE IF EXISTS `user_has_roles`;

CREATE TABLE `user_has_roles` (
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_has_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_has_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_has_roles` */

insert  into `user_has_roles`(`user_id`,`role_id`) values 
(1,9),
(28,8),
(28,10);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Rizkysss','2023-10-07 13:22:48','2023-10-07 19:17:01'),
(3,'test gantix','2023-10-07 16:33:24','2023-10-07 19:07:39'),
(10,'asdf','2023-10-07 16:33:27','2023-10-07 16:33:27'),
(12,'adsfe','2023-10-07 16:33:27','2023-10-07 16:33:27'),
(13,'a','2023-10-07 16:33:27','2023-10-07 16:33:27'),
(14,'fasdf','2023-10-07 16:33:28','2023-10-07 16:33:28'),
(15,'asf','2023-10-07 16:33:28','2023-10-07 16:33:28'),
(16,'ewr','2023-10-07 16:33:28','2023-10-07 16:33:28'),
(17,'sdaf','2023-10-07 16:33:28','2023-10-07 16:33:28'),
(18,'asf','2023-10-07 16:33:29','2023-10-07 16:33:29'),
(19,'asf','2023-10-07 16:33:29','2023-10-07 16:33:29'),
(20,'asf','2023-10-07 16:33:29','2023-10-07 16:33:29'),
(21,'dasf','2023-10-07 16:33:29','2023-10-07 16:33:29'),
(22,'dasf','2023-10-07 16:33:29','2023-10-07 16:33:29'),
(23,'dasf','2023-10-07 16:33:30','2023-10-07 16:33:30'),
(24,'dasf','2023-10-07 16:33:30','2023-10-07 16:33:30'),
(25,'asder','2023-10-07 16:33:30','2023-10-07 16:33:30'),
(26,'fdas','2023-10-07 16:33:30','2023-10-07 16:33:30'),
(27,'dauss','2023-10-07 16:58:32','2023-10-07 16:58:32'),
(28,'ini baruu','2023-10-07 19:26:22','2023-10-07 19:26:22');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
