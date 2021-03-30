

CREATE TABLE `case_files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

