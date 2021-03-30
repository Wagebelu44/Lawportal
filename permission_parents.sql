DROP TABLE IF EXISTS `permission_parents`;

CREATE TABLE `permission_parents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permission_parents` */

insert  into `permission_parents`(`id`,`name`,`active`) values 
(1,'Dashboard',1),
(2,'Manage User',1),
(3,'Attendence',1),
(4,'Activity',1),
(5,'Manage Court',1),
(8,'Manage State',1),
(9,'Manage Case',1),
(10,'Manage Todo',1),
(11,'Manage Holiday',1),
(12,'Manage Assessment',1),
(13,'Manage Incident',1),
(14,'My Todo',1),
(15,'My Incident',1),
(16,'My Assessment',1);

