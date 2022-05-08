CREATE TABLE `ecjia_session_logins` (
  `id` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL,
  `user_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Http User Agent',
  `login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `login_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录IP地址',
  `login_ip_location` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IP地址转换成的地理位置',
  `from_type` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '来源类型weblogin, apilogin',
  `from_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '来源选项，有值就填',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;