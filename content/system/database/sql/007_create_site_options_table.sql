CREATE TABLE `ecjia_site_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint(20) NOT NULL DEFAULT '0',
  `option_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`(191)),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;