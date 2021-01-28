CREATE TABLE `ecjia_meta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `metable_type` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `metable_id` int(10) unsigned NOT NULL,
  `type` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `metable_type_id` (`metable_type`,`metable_id`),
  KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;