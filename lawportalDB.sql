DROP TABLE IF EXISTS `attendences`;

CREATE TABLE `attendences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logged_at` datetime DEFAULT NULL,
  `logged_out_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `attendences` */

/*Table structure for table `case_files` */

DROP TABLE IF EXISTS `case_files`;

CREATE TABLE `case_files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `case_files` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `formfields` */

DROP TABLE IF EXISTS `formfields`;

CREATE TABLE `formfields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `formfields` */

insert  into `formfields`(`id`,`field_name`,`active`) values 
(5,'Client',1),
(6,'Opponent',1);

/*Table structure for table `logged_details` */

DROP TABLE IF EXISTS `logged_details`;

CREATE TABLE `logged_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `logged_at` datetime DEFAULT NULL,
  `logged_out_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `logged_details` */

insert  into `logged_details`(`id`,`user_id`,`logged_at`,`logged_out_at`) values 
(1,29,'2020-09-02 22:12:29',NULL);

/*Table structure for table `mastermetas` */

DROP TABLE IF EXISTS `mastermetas`;

CREATE TABLE `mastermetas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int(11) NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `master_id` (`master_id`)
) ENGINE=InnoDB AUTO_INCREMENT=252 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mastermetas` */

insert  into `mastermetas`(`id`,`master_id`,`meta_key`,`meta_value`) values 
(10,1,'holiday_date','2020-01-01'),
(11,4,'holiday_date','2020-01-26'),
(52,30,'holiday_date','2020-12-25'),
(53,44,'holiday_date','2020-08-15'),
(54,46,'holiday_date','2020-01-26'),
(55,53,'holiday_date','2020-01-01'),
(56,55,'holiday_date','2020-01-26'),
(57,57,'holiday_date','2020-01-29'),
(58,59,'holiday_date','2020-03-09'),
(59,61,'holiday_date','2020-04-14'),
(60,63,'holiday_date','2020-08-15'),
(61,65,'holiday_date','2020-09-17'),
(62,67,'holiday_date','2020-10-02'),
(63,69,'holiday_date','2020-10-21'),
(64,71,'holiday_date','2020-10-22'),
(65,73,'holiday_date','2020-10-24'),
(66,75,'holiday_date','2020-10-23'),
(67,77,'holiday_date','2020-10-30'),
(68,79,'holiday_date','2020-11-14'),
(69,81,'holiday_date','2020-12-25'),
(70,83,'holiday_date','2020-04-14');

/*Table structure for table `masters` */

DROP TABLE IF EXISTS `masters`;

CREATE TABLE `masters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `master_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `create_by` int(11) NOT NULL,
  `master_parent_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `master_parent_id` (`master_parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=637 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `masters` */

insert  into `masters`(`id`,`name`,`master_type`,`active`,`create_by`,`master_parent_id`,`created_at`,`updated_at`) values 
(1,'NEW YEARS DAY','holiday',0,26,0,'2020-08-04 11:10:34','2020-08-05 13:26:26'),
(4,'REPUBLIC DAY','holiday',0,26,0,'2020-08-04 11:11:39','2020-08-05 13:26:31'),
(30,'CHRISTMAS','holiday',0,26,0,'2020-08-05 13:15:15','2020-08-05 13:25:51'),
(44,'Independence Day','holiday',0,29,0,'2020-08-05 13:24:38','2020-08-05 13:26:04'),
(46,'REPUBLIC DAY','holiday',0,26,0,'2020-08-05 13:25:12','2020-08-05 13:26:29'),
(53,'NEW YEARS DAY','holiday',1,26,0,'2020-08-05 13:26:49','2020-08-05 13:26:49'),
(55,'REPUBLIC DAY','holiday',1,26,0,'2020-08-05 13:29:02','2020-08-05 13:29:02'),
(57,'SARASWATI PUJA','holiday',1,26,0,'2020-08-05 13:29:23','2020-08-05 13:29:23'),
(59,'DOL YATRA','holiday',1,26,0,'2020-08-05 13:29:50','2020-08-05 13:29:50'),
(61,'BENGALI NEW YEAR','holiday',1,26,0,'2020-08-05 13:30:25','2020-08-05 13:30:25'),
(63,'INDEPENDENCE DAY','holiday',1,26,0,'2020-08-05 13:31:01','2020-08-05 13:31:01'),
(65,'MAHALAYA','holiday',1,26,0,'2020-08-05 13:31:21','2020-08-05 13:31:21'),
(67,'GANDHI JAYANTI','holiday',1,26,0,'2020-08-05 13:32:03','2020-08-05 13:32:03'),
(69,'DURGA PUJA','holiday',1,26,0,'2020-08-05 13:32:24','2020-08-05 13:32:24'),
(71,'DURGA PUJA','holiday',1,26,0,'2020-08-05 13:32:36','2020-08-05 13:32:36'),
(73,'DURGA PUJA','holiday',1,26,0,'2020-08-05 13:33:05','2020-08-05 13:33:05'),
(75,'DURGA PUJA','holiday',1,26,0,'2020-08-05 13:33:24','2020-08-05 13:33:24'),
(77,'LAXMI PUJA','holiday',1,26,0,'2020-08-05 13:33:46','2020-08-05 13:33:46'),
(79,'KAALI PUJA','holiday',1,26,0,'2020-08-05 13:34:17','2020-08-05 13:34:17'),
(81,'CHRISTMAS','holiday',1,26,0,'2020-08-05 13:34:32','2020-08-05 13:34:32'),
(83,'Bengali New Year','holiday',0,29,0,'2020-08-05 14:46:36','2020-08-05 14:46:54');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2019_08_19_000000_create_failed_jobs_table',1),
(3,'2014_10_12_100000_create_password_resets_table',2),
(4,'2020_06_29_195222_create_usermetas_table',3),
(11,'2020_07_04_073819_create_masters_table',4),
(12,'2020_07_04_074323_create_mastermetas_table',4),
(13,'2020_07_06_172803_create_userroles_table',5),
(14,'2020_07_06_191439_create_userforms_table',5),
(15,'2020_07_06_192045_create_formfields_table',5),
(16,'2020_07_14_155438_create_todoassignees_table',6),
(17,'2020_07_15_182043_create_attendences_table',6),
(18,'2020_08_06_010421_create_permissions_table',7),
(19,'2020_08_06_010537_create_permission_roles_table',7),
(20,'2020_08_08_133655_create_route_permissions_table',8),
(21,'2020_08_11_233145_create_permission_parents_table',9),
(22,'2020_08_23_040855_create_case_files_table',10),
(23,'2020_08_29_045023_create_options_table',11);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`(191),`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notifications` */

/*Table structure for table `objectives` */

DROP TABLE IF EXISTS `objectives`;

CREATE TABLE `objectives` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int(11) NOT NULL,
  `objective` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `weightage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewer_comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `objectives` */

/*Table structure for table `options` */

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `options` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `permission_parents` */

DROP TABLE IF EXISTS `permission_parents`;

CREATE TABLE `permission_parents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(16,'My Assessment',1),
(17,'File Manager',1),
(19,'Judgement',1),
(20,'Contact',1),
(21,'Site Settings',1);

/*Table structure for table `permission_roles` */

DROP TABLE IF EXISTS `permission_roles`;

CREATE TABLE `permission_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `userrole_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=609 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permission_roles` */

insert  into `permission_roles`(`id`,`permission_id`,`userrole_id`) values 
(1,52,20),
(2,51,20),
(3,50,20),
(4,49,20),
(5,48,20),
(6,47,20),
(7,46,20),
(8,45,20),
(9,44,20),
(10,43,20),
(11,42,20),
(12,41,20),
(13,40,20),
(14,39,20),
(15,38,20),
(16,37,20),
(17,36,20),
(18,35,20),
(19,34,20),
(20,33,20),
(21,32,20),
(22,31,20),
(23,30,20),
(24,29,20),
(25,28,20),
(26,27,20),
(27,26,20),
(28,25,20),
(29,24,20),
(30,23,20),
(31,22,20),
(32,16,20),
(33,15,20),
(34,14,20),
(35,13,20),
(36,12,20),
(37,11,20),
(38,10,20),
(39,9,20),
(40,8,20),
(41,7,20),
(42,6,20),
(43,17,20),
(44,5,20),
(45,4,20),
(46,3,20),
(47,2,20),
(48,1,20),
(149,5,19),
(150,13,19),
(151,15,19),
(152,16,19),
(153,18,19),
(154,44,19),
(155,46,19),
(156,49,19),
(157,50,19),
(158,51,19),
(159,52,19),
(265,1,9),
(266,2,9),
(267,3,9),
(268,4,9),
(269,5,9),
(270,17,9),
(271,6,9),
(272,7,9),
(273,8,9),
(274,53,9),
(275,9,9),
(276,10,9),
(277,11,9),
(278,12,9),
(279,13,9),
(280,14,9),
(281,15,9),
(282,16,9),
(283,18,9),
(284,19,9),
(285,20,9),
(286,21,9),
(287,22,9),
(288,23,9),
(289,24,9),
(290,25,9),
(291,26,9),
(292,27,9),
(293,28,9),
(294,29,9),
(295,30,9),
(296,31,9),
(297,32,9),
(298,33,9),
(299,34,9),
(300,35,9),
(301,36,9),
(302,37,9),
(303,38,9),
(304,39,9),
(305,40,9),
(306,41,9),
(307,42,9),
(308,43,9),
(309,44,9),
(310,45,9),
(311,46,9),
(312,47,9),
(313,48,9),
(314,49,9),
(315,50,9),
(316,51,9),
(317,52,9),
(384,2,2),
(385,62,2),
(533,1,10),
(534,2,10),
(535,3,10),
(536,4,10),
(537,5,10),
(538,17,10),
(539,6,10),
(540,7,10),
(541,8,10),
(542,53,10),
(543,9,10),
(544,10,10),
(545,11,10),
(546,75,10),
(547,76,10),
(548,12,10),
(549,13,10),
(550,14,10),
(551,15,10),
(552,16,10),
(553,18,10),
(554,19,10),
(555,20,10),
(556,21,10),
(557,22,10),
(558,62,10),
(559,23,10),
(560,24,10),
(561,25,10),
(562,26,10),
(563,27,10),
(564,28,10),
(565,29,10),
(566,30,10),
(567,31,10),
(568,32,10),
(569,33,10),
(570,34,10),
(571,35,10),
(572,36,10),
(573,37,10),
(574,38,10),
(575,39,10),
(576,40,10),
(577,41,10),
(578,42,10),
(579,43,10),
(580,44,10),
(581,45,10),
(582,46,10),
(583,47,10),
(584,48,10),
(585,49,10),
(586,50,10),
(587,51,10),
(588,52,10),
(589,54,10),
(590,55,10),
(591,56,10),
(592,63,10),
(593,57,10),
(594,58,10),
(595,59,10),
(596,60,10),
(597,61,10),
(598,64,10),
(599,65,10),
(600,66,10),
(601,67,10),
(602,68,10),
(603,69,10),
(604,70,10),
(605,71,10),
(606,72,10),
(607,73,10),
(608,74,10);

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permission_parent_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`permission_parent_id`,`name`,`active`,`sort`) values 
(1,1,'View Attendence on Dashboard',1,1),
(2,1,'View Recent Case Updates on Dashboard',1,5),
(3,1,'View Todo on Dashboard',1,10),
(4,1,'View Holiday Lists on Dashboard',1,15),
(5,2,'View User',1,20),
(6,2,'Edit User',1,25),
(7,2,'Delete User',1,30),
(8,2,'View User Role',1,35),
(9,2,'Edit User Role',1,40),
(10,2,'Delete User Role',1,45),
(11,3,'View Attendence',1,50),
(12,4,'View Activity',1,55),
(13,5,'View Court',1,60),
(14,5,'Add Court',1,65),
(15,5,'Edit Court',1,70),
(16,5,'Delete Court',1,75),
(17,2,'Add User',1,21),
(18,8,'View State',1,80),
(19,8,'Add State',1,85),
(20,8,'Edit State',1,90),
(21,8,'Delete State',1,95),
(22,9,'View Case',1,100),
(23,9,'Add Case',1,105),
(24,9,'Edit Case',1,110),
(25,9,'Delete Case',1,115),
(26,9,'View Case Category',1,120),
(27,9,'Add Case Category',1,125),
(28,9,'Edit Case Category',1,130),
(29,9,'Delete Case Category',1,135),
(30,10,'View Todo',1,140),
(31,10,'Add Todo',1,145),
(32,10,'Edit Todo',1,150),
(33,10,'Delete Todo',1,155),
(34,11,'View Holiday',1,160),
(35,11,'Add Holiday',1,165),
(36,11,'Edit Holiday',1,170),
(37,11,'Delete Holiday',1,175),
(38,12,'View Assessment',1,180),
(39,12,'Add Assessment',1,185),
(40,12,'Edit Assessment',1,190),
(41,12,'Delete Assessment',1,195),
(42,13,'View Incident',1,200),
(43,13,'Add Incident',1,205),
(44,13,'Edit Incident',1,210),
(45,13,'Delete Incident',1,215),
(46,14,'View My Todo',1,220),
(47,14,'Open/Close My Todo',1,225),
(48,14,'Comment on My Todo',1,230),
(49,15,'View My Incident',1,235),
(50,15,'Comment on My Incident',1,240),
(51,16,'View My Assessment',1,245),
(52,16,'Comment on My Assessment',1,250),
(53,2,'Add User Role',1,36),
(54,17,'View File Manager',1,255),
(55,17,'Add File Manager',1,260),
(56,17,'Edit File Manager',1,265),
(57,17,'Delete File Manager',1,270),
(58,17,'View Location',1,275),
(59,17,'Add Location',1,280),
(60,17,'Edit Location',1,285),
(61,17,'Delete Location',1,290),
(62,9,'Show Case',1,101),
(63,17,'Upload File Manager',1,266),
(64,19,'View Judgement',1,295),
(65,19,'Add Judgement',1,300),
(66,19,'Edit Judgement',1,305),
(67,19,'Delete Judgement',1,310),
(68,20,'View Contact',1,315),
(69,20,'Add Contact',1,320),
(70,20,'Edit Contact',1,325),
(71,20,'Delete Contact',1,330),
(72,20,'Send Email',1,335),
(73,20,'Send SMS',1,340),
(74,21,'Edit Site Settings',1,345),
(75,3,'Add Attendence',1,51),
(76,3,'Approve Attendence',1,52);

/*Table structure for table `route_permissions` */

DROP TABLE IF EXISTS `route_permissions`;

CREATE TABLE `route_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `master_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `route_permissions` */

insert  into `route_permissions`(`id`,`permission_id`,`route_name`,`master_type`) values 
(1,5,'user.index',NULL),
(2,5,'user.show',NULL),
(3,6,'user.edit',NULL),
(4,6,'user.update',NULL),
(5,7,'user.destroy',NULL),
(6,8,'userrole.index',NULL),
(7,8,'userrole.show',NULL),
(8,9,'userrole.edit',NULL),
(9,9,'userrole.update',NULL),
(10,10,'userrole.destroy',NULL),
(11,11,'attendence',NULL),
(12,11,'attendence_logs',NULL),
(13,17,'user.create',NULL),
(14,17,'user.store',NULL),
(15,53,'userrole.create',NULL),
(16,53,'userrole.store',NULL),
(17,12,'master.index','revision'),
(18,12,'master.show','revision'),
(19,13,'master.index','court'),
(20,13,'master.show','court'),
(21,14,'master.create','court'),
(22,14,'master.store','court'),
(23,15,'master.edit','court'),
(24,15,'master.update','court'),
(25,16,'master.destroy','court'),
(26,18,'master.index','state'),
(27,18,'master.show','state'),
(28,19,'master.create','state'),
(29,19,'master.store','state'),
(30,20,'master.edit','state'),
(31,20,'master.update','state'),
(32,21,'master.destroy','state'),
(33,22,'master.index','case'),
(34,62,'master.show','case'),
(35,23,'master.create','case'),
(36,23,'master.store','case'),
(37,24,'master.edit','case'),
(38,24,'master.update','case'),
(39,25,'master.destroy','case'),
(40,26,'master.index','case_category'),
(41,26,'master.show','case_category'),
(42,27,'master.create','case_category'),
(43,27,'master.store','case_category'),
(44,28,'master.edit','case_category'),
(45,28,'master.update','case_category'),
(46,29,'master.destroy','case_category'),
(47,30,'master.index','todo'),
(48,30,'master.show','todo'),
(49,31,'master.create','todo'),
(50,31,'master.store','todo'),
(51,32,'master.edit','todo'),
(52,32,'master.update','todo'),
(53,33,'master.destroy','todo'),
(54,34,'master.index','holiday'),
(55,34,'master.show','holiday'),
(56,35,'master.create','holiday'),
(57,35,'master.store','holiday'),
(58,36,'master.edit','holiday'),
(59,36,'master.update','holiday'),
(60,37,'master.destroy','holiday'),
(61,38,'master.index','evaluation'),
(62,38,'master.show','evaluation'),
(63,39,'master.create','evaluation'),
(64,39,'master.store','evaluation'),
(65,40,'master.edit','evaluation'),
(66,40,'master.update','evaluation'),
(67,41,'master.destroy','evaluation'),
(68,42,'master.index','incident'),
(69,42,'master.show','incident'),
(70,43,'master.create','incident'),
(71,43,'master.store','incident'),
(72,44,'master.edit','incident'),
(73,44,'master.update','incident'),
(74,45,'master.destroy','incident'),
(75,46,'todo_list',NULL),
(76,46,'mytodo',NULL),
(77,47,'change.todo_status',NULL),
(78,48,'add.todo.comment',NULL),
(79,48,'delete_todo_comment',NULL),
(80,48,'update_todo_comment',NULL),
(81,49,'incident_list',NULL),
(82,49,'myincident',NULL),
(83,50,'add.incident.comment',NULL),
(84,50,'update_incident_comment',NULL),
(85,50,'delete_incident_comment',NULL),
(86,51,'user_evaluation',NULL),
(87,51,'evaluation',NULL),
(88,52,'evaluation_review',NULL),
(91,16,'master.bulk.delete','court'),
(92,21,'master.bulk.delete','state'),
(93,25,'master.bulk.delete','case'),
(94,29,'master.bulk.delete','case_category'),
(95,33,'master.bulk.delete','todo'),
(96,37,'master.bulk.delete','holiday'),
(97,41,'master.bulk.delete','evaluation'),
(98,45,'master.bulk.delete','incident'),
(99,54,'master.index','file_manager'),
(100,54,'master.show','file_manager'),
(101,55,'master.create','file_manager'),
(102,55,'master.store','file_manager'),
(103,56,'master.edit','file_manager'),
(104,56,'master.update','file_manager'),
(105,57,'master.destroy','file_manager'),
(106,58,'master.index','file_location'),
(107,58,'master.show','file_location'),
(108,59,'master.create','file_location'),
(109,59,'master.store','file_location'),
(110,60,'master.edit','file_location'),
(111,60,'master.update','file_location'),
(112,61,'master.destroy','file_location'),
(113,64,'master.index','judgement'),
(114,64,'master.show','judgement'),
(115,65,'master.create','judgement'),
(116,65,'master.store','judgement'),
(117,66,'master.edit','judgement'),
(118,66,'master.update','judgement'),
(119,67,'master.destroy','judgement'),
(120,68,'master.index','contact'),
(121,68,'master.show','contact'),
(122,69,'master.create','contact'),
(123,69,'master.store','contact'),
(124,70,'master.edit','contact'),
(125,70,'master.update','contact'),
(126,71,'master.destroy','contact'),
(127,72,'send.email','contact'),
(128,72,'post.email','contact'),
(129,73,'send.sms','contact'),
(130,73,'post.sms','contact'),
(131,63,'upload.excel.index','file_manager'),
(132,63,'upload.excel','file_manager'),
(133,74,'option.index',NULL),
(135,74,'option.update',NULL),
(136,75,'attendence.create',NULL),
(137,75,'attendence.store',NULL),
(138,76,'attendence.edit',NULL),
(139,76,'attendence.update',NULL);

/*Table structure for table `todoassignees` */

DROP TABLE IF EXISTS `todoassignees`;

CREATE TABLE `todoassignees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `todoassignees` */

/*Table structure for table `userforms` */

DROP TABLE IF EXISTS `userforms`;

CREATE TABLE `userforms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userrole_id` int(11) NOT NULL,
  `formfield_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userrole_id` (`userrole_id`),
  KEY `formfield_id` (`formfield_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `userforms` */

insert  into `userforms`(`id`,`userrole_id`,`formfield_id`) values 
(26,3,6),
(30,2,5);

/*Table structure for table `usermetas` */

DROP TABLE IF EXISTS `usermetas`;

CREATE TABLE `usermetas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `usermetas` */

insert  into `usermetas`(`id`,`user_id`,`meta_key`,`meta_value`) values 
(4,29,'created_by','1'),
(16,29,'updated_by','29'),
(17,29,'_profile_image','2020/07/nRrm7Fg7JUKUH5xyc6VGWvk5o3vkyPl7Vk1g0cIn.png'),
(23,29,'_userrole_id','10'),
(60,26,'_userrole_id','10'),
(61,26,'created_by','1'),
(62,26,'updated_by','26'),
(63,26,'_profile_image','2020/07/nRrm7Fg7JUKUH5xyc6VGWvk5o3vkyPl7Vk1g0cIn.png'),
(78,26,'id_proof','a:0:{}'),
(93,29,'id_proof','a:0:{}'),
(122,29,'mobile','7777777777'),
(123,29,'address','');

/*Table structure for table `userroles` */

DROP TABLE IF EXISTS `userroles`;

CREATE TABLE `userroles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `userroles` */

insert  into `userroles`(`id`,`name`,`active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values 
(9,'HR',1,1,29,'2020-07-13 08:01:33','2020-08-12 14:53:13'),
(2,'Client',1,1,29,'2020-07-13 08:01:47','2020-08-04 13:53:10'),
(3,'Opponent',1,1,29,'2020-07-13 08:02:05','2020-08-08 02:10:40'),
(10,'Admin',1,1,29,'2020-07-13 08:02:31','2020-08-09 07:42:00'),
(12,'Lawyer',1,1,29,'2020-07-31 11:05:46','2020-08-08 01:32:24'),
(14,'Personal Manager',1,26,26,'2020-08-01 15:22:52','2020-08-01 15:22:52'),
(15,'Advocate',1,26,26,'2020-08-01 15:23:14','2020-08-01 15:23:14'),
(16,'Accounts',1,26,26,'2020-08-01 15:23:33','2020-08-01 15:23:33'),
(19,'Office Admin',1,29,29,'2020-08-01 16:42:44','2020-08-01 16:44:18'),
(18,'Office Associate',1,26,26,'2020-08-01 16:33:14','2020-08-01 16:33:14');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`email`,`email_verified_at`,`password`,`active`,`remember_token`,`created_at`,`updated_at`) values 
(26,'Debasmita Sarkar Bhattacharjee','admin','admin@shainelex.com',NULL,'$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe',1,'00bjpISoIW76YaSrxoz443udAspYJc9YHT3atY0sOmMZEDKWzE2d9IReNEXL','2020-06-30 17:39:09','2020-08-01 16:32:02'),
(29,'Alphaxine','admin@alphaxine.com','admin@alphaxine.com',NULL,'$2y$10$hmS22PAqwoxffC9ldFIGaO4mi7gD6JHQ4melcS57kL22cGqtD2Pwe',1,'PwbPCIEk60salUYMMhRfReFJWEQo7g2t0KJNzLUwGrj9unFIMQCZiGh74NYB','2020-06-30 17:39:09','2020-07-13 14:06:16');

/*Table structure for table `websockets_statistics_entries` */

DROP TABLE IF EXISTS `websockets_statistics_entries`;

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
