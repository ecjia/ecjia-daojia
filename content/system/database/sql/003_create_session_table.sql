CREATE TABLE `ecjia_session` (
  `id` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `user_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT '',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;