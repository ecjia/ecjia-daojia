# ************************************************************
#
# ECJia到家数据库安装脚本-1/2
# 数据表结构
#
# ************************************************************

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_account_log`
--

DROP TABLE IF EXISTS `ecjia_account_log`;
CREATE TABLE `ecjia_account_log` (
  `log_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `user_money` decimal(10,2) NOT NULL,
  `frozen_money` decimal(10,2) NOT NULL,
  `rank_points` mediumint(9) NOT NULL,
  `pay_points` mediumint(9) NOT NULL,
  `change_time` int(10) unsigned NOT NULL,
  `change_desc` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `change_type` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_ad`
--

DROP TABLE IF EXISTS `ecjia_ad`;
CREATE TABLE `ecjia_ad` (
  `ad_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `media_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ad_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `ad_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `ad_code` text COLLATE utf8mb4_unicode_ci,
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `link_man` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `link_email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `link_phone` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `click_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ad_id`),
  KEY `position_id` (`position_id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_ad_position`
--

DROP TABLE IF EXISTS `ecjia_ad_position`;
CREATE TABLE `ecjia_ad_position` (
  `position_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `position_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `ad_width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ad_height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `position_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `position_style` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_admin_log`
--

DROP TABLE IF EXISTS `ecjia_admin_log`;
CREATE TABLE `ecjia_admin_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_info` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `ip_address` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_admin_message`
--

DROP TABLE IF EXISTS `ecjia_admin_message`;
CREATE TABLE `ecjia_admin_message` (
  `message_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `receiver_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sent_time` int(11) unsigned NOT NULL DEFAULT '0',
  `read_time` int(11) unsigned NOT NULL DEFAULT '0',
  `readed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(150) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `message` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`message_id`),
  KEY `sender_id` (`sender_id`,`receiver_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_admin_user`
--

DROP TABLE IF EXISTS `ecjia_admin_user`;
CREATE TABLE `ecjia_admin_user` (
  `user_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `password` varchar(32) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `ec_salt` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `action_list` text COLLATE utf8mb4_unicode_ci,
  `nav_list` text COLLATE utf8mb4_unicode_ci,
  `lang_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `agency_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `suppliers_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `todolist` longtext CHARACTER SET utf8mb4,
  `role_id` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `agency_id` (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_adsense`
--

DROP TABLE IF EXISTS `ecjia_adsense`;
CREATE TABLE `ecjia_adsense` (
  `from_ad` smallint(5) NOT NULL DEFAULT '0',
  `referer` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `clicks` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `from_ad` (`from_ad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_adviser`
--

DROP TABLE IF EXISTS `ecjia_adviser`;
CREATE TABLE `ecjia_adviser` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '导购员：guider;收银员：casher',
  `username` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `qq` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `tel` varchar(13) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `email` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `identifier` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `admin_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '是导购员，目前默认0;是收银员，去选管理员',
  `seller_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '入驻商家id',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_adviser_log`
--

DROP TABLE IF EXISTS `ecjia_adviser_log`;
CREATE TABLE `ecjia_adviser_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adviser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `device_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` smallint(3) NOT NULL COMMENT '1、开单，2、收款，3、验单',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `adviser_id` (`adviser_id`),
  KEY `order_id` (`order_id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_affiliate_log`
--

DROP TABLE IF EXISTS `ecjia_affiliate_log`;
CREATE TABLE `ecjia_affiliate_log` (
  `log_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `order_id` mediumint(8) NOT NULL,
  `time` int(10) NOT NULL,
  `user_id` mediumint(8) NOT NULL,
  `user_name` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `point` int(10) NOT NULL DEFAULT '0',
  `separate_type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_area_region`
--

DROP TABLE IF EXISTS `ecjia_area_region`;
CREATE TABLE `ecjia_area_region` (
  `shipping_area_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `region_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`shipping_area_id`,`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_article`
--

DROP TABLE IF EXISTS `ecjia_article`;
CREATE TABLE `ecjia_article` (
  `article_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) NOT NULL DEFAULT '0',
  `title` varchar(150) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `content` longtext CHARACTER SET utf8mb4 NULL,
  `author` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `author_email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `keywords` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `article_type` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `is_open` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `file_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `open_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_article_cat`
--

DROP TABLE IF EXISTS `ecjia_article_cat`;
CREATE TABLE `ecjia_article_cat` (
  `cat_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cat_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `keywords` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cat_desc` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50',
  `show_in_nav` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `cat_type` (`cat_type`),
  KEY `sort_order` (`sort_order`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_attribute`
--

DROP TABLE IF EXISTS `ecjia_attribute`;
CREATE TABLE `ecjia_attribute` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `attr_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `attr_cat_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `attr_input_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `attr_type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `attr_values` text CHARACTER SET utf8mb4 NULL,
  `color_values` text CHARACTER SET utf8mb4 NULL,
  `attr_index` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_linked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `attr_group` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `attr_input_category` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`attr_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_auto_manage`
--

DROP TABLE IF EXISTS `ecjia_auto_manage`;
CREATE TABLE `ecjia_auto_manage` (
  `item_id` mediumint(8) NOT NULL,
  `type` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `starttime` int(10) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_back_goods`
--

DROP TABLE IF EXISTS `ecjia_back_goods`;
CREATE TABLE `ecjia_back_goods` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `back_id` mediumint(8) unsigned DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product_sn` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `goods_name` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `brand_name` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `goods_sn` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `is_real` tinyint(1) unsigned DEFAULT '0',
  `send_number` smallint(5) unsigned DEFAULT '0',
  `goods_attr` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`rec_id`),
  KEY `back_id` (`back_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_back_order`
--

DROP TABLE IF EXISTS `ecjia_back_order`;
CREATE TABLE `ecjia_back_order` (
  `back_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `delivery_sn` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `order_sn` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `invoice_no` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `add_time` int(10) unsigned DEFAULT '0',
  `shipping_id` tinyint(3) unsigned DEFAULT '0',
  `shipping_name` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `user_id` mediumint(8) unsigned DEFAULT '0',
  `action_user` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `consignee` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `address` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `country` smallint(5) unsigned DEFAULT '0',
  `province` smallint(5) unsigned DEFAULT '0',
  `city` smallint(5) unsigned DEFAULT '0',
  `district` smallint(5) unsigned DEFAULT '0',
  `sign_building` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `zipcode` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `tel` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `mobile` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `best_time` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `postscript` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `how_oos` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `insure_fee` decimal(10,2) unsigned DEFAULT '0.00',
  `shipping_fee` decimal(10,2) unsigned DEFAULT '0.00',
  `update_time` int(10) unsigned DEFAULT '0',
  `suppliers_id` smallint(5) DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `return_time` int(10) unsigned DEFAULT '0',
  `agency_id` smallint(5) unsigned DEFAULT '0',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`back_id`),
  UNIQUE KEY `store_back_order_id` (`back_id`,`store_id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `store_id` (`store_id`),
  KEY `store_back_order` (`order_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_bonus_type`
--

DROP TABLE IF EXISTS `ecjia_bonus_type`;
CREATE TABLE `ecjia_bonus_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `type_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `send_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `usebonus_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `min_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `max_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `send_start_date` int(11) NOT NULL DEFAULT '0',
  `send_end_date` int(11) NOT NULL DEFAULT '0',
  `use_start_date` int(11) NOT NULL DEFAULT '0',
  `use_end_date` int(11) NOT NULL DEFAULT '0',
  `min_goods_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `store_bonus_type` (`type_id`,`store_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_brand`
--

DROP TABLE IF EXISTS `ecjia_brand`;
CREATE TABLE `ecjia_brand` (
  `brand_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `brand_logo` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `brand_desc` text COLLATE utf8mb4_unicode_ci NULL,
  `site_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`brand_id`),
  KEY `is_show` (`is_show`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_cart`
--

DROP TABLE IF EXISTS `ecjia_cart`;
CREATE TABLE `ecjia_cart` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺街主键',
  `session_id` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_sn` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `product_id` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `group_id` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `goods_attr` text CHARACTER SET utf8mb4 NULL,
  `is_real` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `extension_code` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rec_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_gift` smallint(5) unsigned NOT NULL DEFAULT '0',
  `is_shipping` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_handsel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `model_attr` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `goods_attr_id` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `shopping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_checked` tinyint(1) NOT NULL DEFAULT '1' COMMENT '选中状态，0未选中，1选中',
  `add_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rec_id`),
  KEY `session_id` (`session_id`(191)),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_cat_recommend`
--

DROP TABLE IF EXISTS `ecjia_cat_recommend`;
CREATE TABLE `ecjia_cat_recommend` (
  `cat_id` smallint(5) NOT NULL,
  `recommend_type` tinyint(1) NOT NULL,
  PRIMARY KEY (`cat_id`,`recommend_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_category`
--

DROP TABLE IF EXISTS `ecjia_category`;
CREATE TABLE `ecjia_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(90) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `category_img` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `keywords` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cat_desc` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '50',
  `template_file` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `measure_unit` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `show_in_nav` tinyint(1) NOT NULL DEFAULT '0',
  `style` varchar(150) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `grade` tinyint(4) NOT NULL DEFAULT '0',
  `filter_attr` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_collect_goods`
--

DROP TABLE IF EXISTS `ecjia_collect_goods`;
CREATE TABLE `ecjia_collect_goods` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `is_attention` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rec_id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`goods_id`),
  KEY `is_attention` (`is_attention`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_collect_store`
--

DROP TABLE IF EXISTS `ecjia_collect_store`;
CREATE TABLE `ecjia_collect_store` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `is_attention` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rec_id`),
  KEY `user_id` (`user_id`),
  KEY `is_attention` (`is_attention`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_comment`
--

DROP TABLE IF EXISTS `ecjia_comment`;
CREATE TABLE `ecjia_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_value` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8mb4 NULL,
  `comment_rank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment_server` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment_delivery` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` mediumint(8) DEFAULT '0',
  `goods_tag` varchar(500) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `parent_id` (`parent_id`),
  KEY `id_value` (`id_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_connect`
--

DROP TABLE IF EXISTS `ecjia_connect`;
CREATE TABLE `ecjia_connect` (
  `connect_id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `connect_code` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `connect_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `connect_desc` text CHARACTER SET utf8mb4 NULL,
  `connect_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `connect_config` text CHARACTER SET utf8mb4 NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `support_type` mediumint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`connect_id`),
  KEY `connect_code` (`connect_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_connect_user`
--

DROP TABLE IF EXISTS `ecjia_connect_user`;
CREATE TABLE `ecjia_connect_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `connect_code` char(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `open_id` char(64) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `refresh_token` char(64) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `access_token` char(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `profile` text CHARACTER SET utf8mb4,
  `create_at` int(10) unsigned NOT NULL DEFAULT '0',
  `expires_in` int(10) unsigned NOT NULL DEFAULT '0',
  `expires_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `open_id` (`connect_code`,`open_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_crons`
--

DROP TABLE IF EXISTS `ecjia_crons`;
CREATE TABLE `ecjia_crons` (
  `cron_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `cron_code` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cron_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cron_desc` text CHARACTER SET utf8mb4,
  `cron_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cron_config` text CHARACTER SET utf8mb4 NULL,
  `thistime` int(10) NOT NULL DEFAULT '0',
  `nextime` int(10) NULL,
  `day` tinyint(2) NULL,
  `week` varchar(1) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `hour` varchar(2) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `minute` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `run_once` tinyint(1) NOT NULL DEFAULT '0',
  `allow_ip` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `alow_files` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`cron_id`),
  KEY `nextime` (`nextime`),
  KEY `enable` (`enable`),
  KEY `cron_code` (`cron_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_delivery_goods`
--

DROP TABLE IF EXISTS `ecjia_delivery_goods`;
CREATE TABLE `ecjia_delivery_goods` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `delivery_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product_id` mediumint(8) unsigned DEFAULT '0',
  `product_sn` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `goods_name` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `brand_name` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `goods_sn` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `is_real` tinyint(1) unsigned DEFAULT '0',
  `extension_code` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `parent_id` mediumint(8) unsigned DEFAULT '0',
  `send_number` smallint(5) unsigned DEFAULT '0',
  `goods_attr` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`rec_id`),
  KEY `delivery_id` (`delivery_id`,`goods_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_delivery_order`
--

DROP TABLE IF EXISTS `ecjia_delivery_order`;
CREATE TABLE `ecjia_delivery_order` (
  `delivery_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `delivery_sn` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `order_sn` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `invoice_no` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `add_time` int(10) unsigned DEFAULT '0',
  `shipping_id` tinyint(3) unsigned DEFAULT '0',
  `shipping_name` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `user_id` mediumint(8) unsigned DEFAULT '0',
  `action_user` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `consignee` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `address` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `longitude` varchar(20) COLLATE utf8mb4_unicode_ci NULL COMMENT '经度',
  `latitude` varchar(20) COLLATE utf8mb4_unicode_ci NULL COMMENT '纬度',
  `country` smallint(5) unsigned DEFAULT '0',
  `province` smallint(5) unsigned DEFAULT '0',
  `city` smallint(5) unsigned DEFAULT '0',
  `district` smallint(5) unsigned DEFAULT '0',
  `sign_building` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `zipcode` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `tel` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `mobile` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `best_time` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `postscript` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `how_oos` varchar(120) CHARACTER SET utf8mb4 DEFAULT NULL,
  `insure_fee` decimal(10,2) unsigned DEFAULT '0.00',
  `shipping_fee` decimal(10,2) unsigned DEFAULT '0.00',
  `update_time` int(10) unsigned DEFAULT '0',
  `suppliers_id` smallint(5) DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `agency_id` smallint(5) unsigned DEFAULT '0',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`delivery_id`),
  UNIQUE KEY `store_delivery_order` (`delivery_id`,`store_id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `store_id` (`store_id`),
  KEY `store_order` (`order_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_email_list`
--

DROP TABLE IF EXISTS `ecjia_email_list`;
CREATE TABLE `ecjia_email_list` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `stat` tinyint(1) NOT NULL DEFAULT '0',
  `hash` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_email_sendlist`
--

DROP TABLE IF EXISTS `ecjia_email_sendlist`;
CREATE TABLE `ecjia_email_sendlist` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_id` mediumint(8) NOT NULL,
  `email_content` text COLLATE utf8mb4_unicode_ci NULL,
  `error` tinyint(1) NOT NULL DEFAULT '0',
  `pri` tinyint(10) NOT NULL  DEFAULT '0',
  `last_send` int(10) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_express_checkin`
--

DROP TABLE IF EXISTS `ecjia_express_checkin`;
CREATE TABLE `ecjia_express_checkin` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `checkin_date` date DEFAULT NULL,
  `start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `duration` int(10) NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_express_order`
--

DROP TABLE IF EXISTS `ecjia_express_order`;
CREATE TABLE `ecjia_express_order` (
  `express_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `express_sn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '流水号',
  `order_sn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `delivery_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `delivery_sn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '发货单流水',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) unsigned DEFAULT '0',
  `consignee` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '收货人',
  `address` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` smallint(5) unsigned DEFAULT '0',
  `province` smallint(5) unsigned DEFAULT '0',
  `city` smallint(5) unsigned DEFAULT '0',
  `district` smallint(5) unsigned DEFAULT '0',
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `best_time` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `shipping_fee` decimal(10,2) unsigned DEFAULT '0.00',
  `commision` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '佣金',
  `add_time` int(10) unsigned DEFAULT '0' COMMENT '添加时间',
  `receive_time` int(10) unsigned DEFAULT '0' COMMENT '接单时间',
  `express_time` int(10) unsigned DEFAULT '0' COMMENT '取货配送时间',
  `signed_time` int(10) unsigned DEFAULT '0' COMMENT '签收时间',
  `update_time` int(10) unsigned DEFAULT '0',
  `longitude` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '纬度',
  `distance` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '距离',
  `from` char(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '来源：assign(派单)，grab(抢单)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未分配派单,1已接派单待取货,2已取货派送中,3退货中,4拒收,5已签收,6已退回',
  `staff_id` int(10) unsigned DEFAULT '0',
  `express_user` varchar(20) COLLATE utf8mb4_unicode_ci NULL COMMENT '配送员名字',
  `express_mobile` varchar(20) COLLATE utf8mb4_unicode_ci NULL COMMENT '配送员联系电话',
  `comment_rank` tinyint(1) unsigned NOT NULL DEFAULT '5' COMMENT '评分',
  `comment_content` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`express_id`),
  UNIQUE KEY `store_express_order` (`express_id`,`store_id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `order_sn` (`order_sn`),
  KEY `delivery_id` (`delivery_id`),
  KEY `delivery_sn` (`delivery_sn`),
  KEY `store_id` (`store_id`),
  KEY `store_order` (`order_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='自营配送订单信息表';

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_express_user`
--

DROP TABLE IF EXISTS `ecjia_express_user`;
CREATE TABLE `ecjia_express_user` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `longitude` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '纬度',
  `delivery_count` int(11) unsigned DEFAULT '0' COMMENT '配送总数',
  `delivery_distance` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '0' COMMENT '配送总距离',
  `comment_rank` tinyint(1) unsigned NOT NULL DEFAULT '5' COMMENT '评分',
  PRIMARY KEY (`user_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配送员信息表';

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_favourable_activity`
--

DROP TABLE IF EXISTS `ecjia_favourable_activity`;
CREATE TABLE `ecjia_favourable_activity` (
  `act_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `act_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `user_rank` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `act_range` tinyint(3) unsigned NULL,
  `act_range_ext` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `min_amount` decimal(10,2) unsigned NULL,
  `max_amount` decimal(10,2) unsigned NULL,
  `act_type` tinyint(3) unsigned NULL,
  `act_type_ext` decimal(10,2) unsigned NULL,
  `gift` text CHARACTER SET utf8mb4 NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50',
  PRIMARY KEY (`act_id`),
  UNIQUE KEY `store_activity` (`act_id`,`store_id`),
  KEY `act_name` (`act_name`(191)),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_feedback`
--

DROP TABLE IF EXISTS `ecjia_feedback`;
CREATE TABLE `ecjia_feedback` (
  `msg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `msg_title` varchar(200) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `msg_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `msg_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `msg_content` text CHARACTER SET utf8mb4 NULL,
  `msg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `message_img` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '0',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0',
  `msg_area` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_goods`
--

DROP TABLE IF EXISTS `ecjia_goods`;
CREATE TABLE `ecjia_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `merchant_cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `goods_sn` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_name_style` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '+',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `provider_name` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `goods_weight` decimal(10,3) unsigned NOT NULL DEFAULT '0.000',
  `default_shipping` int(11) unsigned NULL,
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `shop_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `promote_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `promote_start_date` int(11) unsigned NOT NULL DEFAULT '0',
  `promote_end_date` int(11) unsigned NOT NULL DEFAULT '0',
  `warn_number` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `keywords` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_brief` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_desc` text CHARACTER SET utf8mb4 NULL,
  `goods_thumb` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_img` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `original_img` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `is_real` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `extension_code` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `is_on_sale` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_alone_sale` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_shipping` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `integral` int(10) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` smallint(4) unsigned NOT NULL DEFAULT '100',
  `store_sort_order` smallint(4) unsigned NOT NULL DEFAULT '100',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_best` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_promote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bonus_type_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  `goods_type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `seller_note` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `give_integral` int(11) NOT NULL DEFAULT '-1',
  `rank_integral` int(11) NOT NULL DEFAULT '-1',
  `suppliers_id` smallint(5) unsigned DEFAULT NULL,
  `is_check` tinyint(1) unsigned DEFAULT NULL,
  `store_hot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `store_new` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `store_best` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_number` smallint(8) unsigned NOT NULL DEFAULT '0',
  `is_xiangou` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否限购',
  `xiangou_start_date` int(11) NOT NULL DEFAULT '0' COMMENT '限购开始时间',
  `xiangou_end_date` int(11) NOT NULL DEFAULT '0' COMMENT '限购结束时间',
  `xiangou_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '限购设定数量',
  `review_status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `review_content` varchar(255) CHARACTER SET utf8 NULL,
  `goods_shipai` text CHARACTER SET utf8 NULL,
  `comments_number` int(10) unsigned NOT NULL DEFAULT '0',
  `sales_volume` int(10) unsigned NOT NULL DEFAULT '0',
  `model_price` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `model_inventory` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `model_attr` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `largest_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `pinyin_keyword` text CHARACTER SET utf8,
  `goods_product_tag` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `store_goods` (`goods_id`,`store_id`),
  KEY `goods_sn` (`goods_sn`),
  KEY `cat_id` (`cat_id`),
  KEY `last_update` (`last_update`),
  KEY `brand_id` (`brand_id`),
  KEY `goods_weight` (`goods_weight`),
  KEY `promote_end_date` (`promote_end_date`),
  KEY `promote_start_date` (`promote_start_date`),
  KEY `goods_number` (`goods_number`),
  KEY `sort_order` (`sort_order`),
  KEY `sales_volume` (`sales_volume`),
  KEY `xiangou_start_date` (`xiangou_start_date`),
  KEY `xiangou_end_date` (`xiangou_end_date`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_goods_activity`
--

DROP TABLE IF EXISTS `ecjia_goods_activity`;
CREATE TABLE `ecjia_goods_activity` (
  `act_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `act_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `act_desc` text CHARACTER SET utf8mb4 NULL,
  `act_type` tinyint(3) unsigned NULL,
  `goods_id` mediumint(8) unsigned NOT NULL,
  `product_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `start_time` int(10) unsigned NOT NULL,
  `end_time` int(10) unsigned NOT NULL,
  `is_finished` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ext_info` text CHARACTER SET utf8mb4 NULL,
  PRIMARY KEY (`act_id`),
  UNIQUE KEY `store_activity` (`store_id`,`act_id`),
  KEY `act_name` (`act_name`(191),`act_type`,`goods_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_goods_article`
--

DROP TABLE IF EXISTS `ecjia_goods_article`;
CREATE TABLE `ecjia_goods_article` (
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `article_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `admin_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`,`article_id`,`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_goods_attr`
--

DROP TABLE IF EXISTS `ecjia_goods_attr`;
CREATE TABLE `ecjia_goods_attr` (
  `goods_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `attr_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `attr_value` text CHARACTER SET utf8mb4 NULL,
  `color_value` text CHARACTER SET utf8mb4 NULL,
  `attr_price` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `attr_sort` int(11) unsigned NULL,
  `attr_img_flie` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `attr_gallery_flie` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `attr_img_site` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `attr_checked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_attr_id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_goods_cat`
--

DROP TABLE IF EXISTS `ecjia_goods_cat`;
CREATE TABLE `ecjia_goods_cat` (
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`,`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_goods_gallery`
--

DROP TABLE IF EXISTS `ecjia_goods_gallery`;
CREATE TABLE `ecjia_goods_gallery` (
  `img_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `img_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `img_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `thumb_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `img_original` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`img_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_goods_type`
--

DROP TABLE IF EXISTS `ecjia_goods_type`;
CREATE TABLE `ecjia_goods_type` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `attr_group` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `store_cat` (`store_id`,`cat_name`) USING BTREE,
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_group_goods`
--

DROP TABLE IF EXISTS `ecjia_group_goods`;
CREATE TABLE `ecjia_group_goods` (
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `admin_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配件分组',
  PRIMARY KEY (`parent_id`,`goods_id`,`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_invite_reward`
--

DROP TABLE IF EXISTS `ecjia_invite_reward`;
CREATE TABLE `ecjia_invite_reward` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invite_id` int(11) unsigned NOT NULL,
  `invitee_id` int(10) unsigned NOT NULL COMMENT '被邀请人id',
  `invitee_name` varchar(60) COLLATE utf8mb4_unicode_ci NULL COMMENT '被邀请人名称',
  `reward_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '奖励类型（红包：bouns，积分：integral，余额：balance）',
  `reward_value` varchar(100) COLLATE utf8mb4_unicode_ci NULL COMMENT '获得的奖励',
  `reward_desc` varchar(100) COLLATE utf8mb4_unicode_ci NULL COMMENT '奖励补充描述说明',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invite_id` (`invite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_invitee_record`
--

DROP TABLE IF EXISTS `ecjia_invitee_record`;
CREATE TABLE `ecjia_invitee_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invite_id` int(11) unsigned NOT NULL,
  `invitee_phone` char(11) COLLATE utf8mb4_unicode_ci NULL COMMENT '受邀者手机号',
  `invite_type` varchar(10) COLLATE utf8mb4_unicode_ci NULL,
  `is_registered` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已注册',
  `expire_time` int(10) unsigned NULL COMMENT '有效期',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `invite_id` (`invite_id`),
  KEY `invite_type` (`invite_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_keywords`
--

DROP TABLE IF EXISTS `ecjia_keywords`;
CREATE TABLE `ecjia_keywords` (
  `date` date NOT NULL DEFAULT '2017-01-01',
  `searchengine` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `keyword` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`date`,`searchengine`,`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_link_goods`
--

DROP TABLE IF EXISTS `ecjia_link_goods`;
CREATE TABLE `ecjia_link_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `link_goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `is_double` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`,`link_goods_id`,`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_mail_templates`
--

DROP TABLE IF EXISTS `ecjia_mail_templates`;
CREATE TABLE `ecjia_mail_templates` (
  `template_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `template_code` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `is_html` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `template_subject` varchar(200) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `template_content` text CHARACTER SET utf8mb4 NULL,
  `last_modify` int(10) unsigned NOT NULL DEFAULT '0',
  `last_send` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`template_id`),
  UNIQUE KEY `template_code` (`template_code`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_member_price`
--

DROP TABLE IF EXISTS `ecjia_member_price`;
CREATE TABLE `ecjia_member_price` (
  `price_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_rank` tinyint(3) NOT NULL DEFAULT '0',
  `user_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`price_id`),
  KEY `goods_id` (`goods_id`,`user_rank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_merchants_category`
--

DROP TABLE IF EXISTS `ecjia_merchants_category`;
CREATE TABLE `ecjia_merchants_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) unsigned NOT NULL DEFAULT '0',
  `cat_name` varchar(90) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cat_desc` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '50',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `store_cat` (`store_id`,`cat_name`) USING BTREE,
  KEY `parent_id` (`parent_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_merchants_config`
--

DROP TABLE IF EXISTS `ecjia_merchants_config`;
CREATE TABLE `ecjia_merchants_config` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group` int(10) unsigned NOT NULL DEFAULT '0',
  `code` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `type` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `store_range` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `store_dir` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `value` text CHARACTER SET utf8mb4 NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_code` (`store_id`,`code`) USING BTREE,
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_mobile_checkin`
--

DROP TABLE IF EXISTS `ecjia_mobile_checkin`;
CREATE TABLE `ecjia_mobile_checkin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL COMMENT '用户id',
  `checkin_time` int(10) unsigned DEFAULT NULL COMMENT '签到时间',
  `integral` int(10) unsigned DEFAULT NULL COMMENT '签到获取积分',
  `source` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '签到来源',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `checkin_time` (`checkin_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_mobile_device`
--

DROP TABLE IF EXISTS `ecjia_mobile_device`;
CREATE TABLE `ecjia_mobile_device` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `device_udid` char(40) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `device_client` char(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `device_code` char(4) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `device_name` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `device_alias` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `device_token` char(64) CHARACTER SET utf8mb4 DEFAULT NULL,
  `device_os` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL,
  `device_type` varchar(30) COLLATE utf8mb4_unicode_ci NULL COMMENT '设备类型',
  `user_id` int(9) NOT NULL DEFAULT '0',
  `user_type` varchar(10) COLLATE utf8mb4_unicode_ci NULL COMMENT '用户类型',
  `location_province` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `location_city` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `visit_times` int(10) NOT NULL DEFAULT '0',
  `in_status` tinyint(1) NULL,
  `add_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `device_udid` (`device_udid`,`device_client`,`device_code`,`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_mobile_manage`
--

DROP TABLE IF EXISTS `ecjia_mobile_manage`;
CREATE TABLE `ecjia_mobile_manage` (
  `app_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_name` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '应用名称',
  `bundle_id` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT 'app包名',
  `app_key` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT 'appkey',
  `app_secret` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT 'AppSecret',
  `device_code` char(4) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `device_client` char(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `platform` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '服务平台名称',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `sort` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_mobile_message`
--

DROP TABLE IF EXISTS `ecjia_mobile_message`;
CREATE TABLE `ecjia_mobile_message` (
  `message_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(3) NOT NULL DEFAULT '0',
  `sender_admin` tinyint(1) NOT NULL DEFAULT '0',
  `receiver_id` int(3) NOT NULL DEFAULT '0',
  `receiver_admin` tinyint(1) NOT NULL DEFAULT '0',
  `send_time` int(11) unsigned NOT NULL DEFAULT '0',
  `read_time` int(11) unsigned NOT NULL DEFAULT '0',
  `readed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(150) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `message` text CHARACTER SET utf8mb4 NULL,
  `message_type` varchar(25) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`message_id`),
  KEY `sender_id` (`sender_id`,`receiver_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_mobile_news`
--

DROP TABLE IF EXISTS `ecjia_mobile_news`;
CREATE TABLE `ecjia_mobile_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '标题',
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '描述',
  `image` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '图片地址',
  `content_url` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '详情跳转链接',
  `type` char(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT 'article或goods',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_mobile_screenshots`
--

DROP TABLE IF EXISTS `ecjia_mobile_screenshots`;
CREATE TABLE `ecjia_mobile_screenshots` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `app_code` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `img_desc` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `img_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `sort` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_nav`
--

DROP TABLE IF EXISTS `ecjia_nav`;
CREATE TABLE `ecjia_nav` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `ctype` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `cid` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `ifshow` tinyint(1) NULL,
  `vieworder` tinyint(1) NULL,
  `opennew` tinyint(1) NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `type` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `ifshow` (`ifshow`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_notifications`
--

DROP TABLE IF EXISTS `ecjia_notifications`;
CREATE TABLE `ecjia_notifications` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notifiable_id` int(10) unsigned NOT NULL,
  `notifiable_type` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_order_action`
--

DROP TABLE IF EXISTS `ecjia_order_action`;
CREATE TABLE `ecjia_order_action` (
  `action_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `action_user` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `action_place` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `action_note` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `log_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`action_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_order_goods`
--

DROP TABLE IF EXISTS `ecjia_order_goods`;
CREATE TABLE `ecjia_order_goods` (
  `rec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_sn` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `product_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_attr` text CHARACTER SET utf8mb4 NULL,
  `send_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `is_real` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `extension_code` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `is_gift` smallint(5) unsigned NOT NULL DEFAULT '0',
  `model_attr` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `goods_attr_id` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `shopping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`rec_id`),
  KEY `goods_id` (`goods_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_order_info`
--

DROP TABLE IF EXISTS `ecjia_order_info`;
CREATE TABLE `ecjia_order_info` (
  `order_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_sn` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `consignee` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `country` smallint(5) unsigned NOT NULL DEFAULT '0',
  `province` smallint(5) unsigned NOT NULL DEFAULT '0',
  `city` smallint(5) unsigned NOT NULL DEFAULT '0',
  `district` smallint(5) unsigned NOT NULL DEFAULT '0',
  `address` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `longitude` varchar(20) COLLATE utf8mb4_unicode_ci NULL COMMENT '经度',
  `latitude` varchar(20) COLLATE utf8mb4_unicode_ci NULL COMMENT '纬度',
  `zipcode` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `tel` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `mobile` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `best_time` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `sign_building` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `postscript` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `shipping_id` tinyint(3) NOT NULL DEFAULT '0',
  `shipping_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `expect_shipping_time` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '预期送货时间',
  `pay_id` tinyint(3) NOT NULL DEFAULT '0',
  `pay_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `how_oos` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `how_surplus` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `pack_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `card_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `card_message` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `inv_payee` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `inv_content` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `insure_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pay_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pack_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `card_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `money_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `surplus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `integral` int(10) unsigned NOT NULL DEFAULT '0',
  `integral_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `from_ad` smallint(5) NOT NULL DEFAULT '0',
  `referer` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `confirm_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `shipping_time` int(10) unsigned NOT NULL DEFAULT '0',
  `auto_delivery_time` int(11) unsigned NOT NULL DEFAULT '15',
  `pack_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `card_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bonus_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `invoice_no` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `extension_code` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `extension_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `to_buyer` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `pay_note` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `agency_id` smallint(5) unsigned NULL,
  `inv_type` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `tax` decimal(10,2) NULL,
  `is_separate` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `discount` decimal(10,2) NULL,
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  `is_settlement` tinyint(1) NOT NULL DEFAULT '0',
  `sign_time` int(30) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  UNIQUE KEY `store_order` (`order_id`,`store_id`),
  KEY `user_id` (`user_id`),
  KEY `order_status` (`order_status`),
  KEY `shipping_status` (`shipping_status`),
  KEY `pay_status` (`pay_status`),
  KEY `shipping_id` (`shipping_id`),
  KEY `pay_id` (`pay_id`),
  KEY `extension_code` (`extension_code`,`extension_id`),
  KEY `agency_id` (`agency_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_order_reminder`
--

DROP TABLE IF EXISTS `ecjia_order_reminder`;
CREATE TABLE `ecjia_order_reminder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `create_time` int(10) NOT NULL DEFAULT '0',
  `confirm_time` int(10) NULL,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `store_order` (`order_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_order_status_log`
--

DROP TABLE IF EXISTS `ecjia_order_status_log`;
CREATE TABLE `ecjia_order_status_log` (
  `log_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_status` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `order_id` int(10) unsigned NOT NULL,
  `message` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_package_goods`
--

DROP TABLE IF EXISTS `ecjia_package_goods`;
CREATE TABLE `ecjia_package_goods` (
  `package_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1',
  `admin_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`package_id`,`goods_id`,`admin_id`,`product_id`),
  KEY `store_id` (`store_id`),
  KEY `store_package` (`package_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_pay_log`
--

DROP TABLE IF EXISTS `ecjia_pay_log`;
CREATE TABLE `ecjia_pay_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `order_amount` decimal(10,2) unsigned NOT NULL,
  `order_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_paid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_payment`
--

DROP TABLE IF EXISTS `ecjia_payment`;
CREATE TABLE `ecjia_payment` (
  `pay_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pay_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pay_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pay_fee` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `pay_desc` text COLLATE utf8mb4_unicode_ci NULL,
  `pay_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pay_config` text COLLATE utf8mb4_unicode_ci NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_cod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_online` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pay_id`),
  UNIQUE KEY `pay_code` (`pay_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_payment_record`
--

DROP TABLE IF EXISTS `ecjia_payment_record`;
CREATE TABLE `ecjia_payment_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `trade_type` char(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `trade_no` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `pay_code` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `pay_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `total_fee` decimal(10,2) unsigned NOT NULL,
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  KEY `trade_type` (`trade_type`),
  KEY `pay_code` (`pay_code`),
  KEY `trade_no` (`trade_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_platform_account`
--

DROP TABLE IF EXISTS `ecjia_platform_account`;
CREATE TABLE `ecjia_platform_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '唯一标识',
  `platform` varchar(30) COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '平台',
  `type` int(1) unsigned NULL DEFAULT '0' COMMENT '公众号类型',
  `shop_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '公众号名称',
  `logo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Token',
  `aeskey` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `appid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AppID',
  `appsecret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'AppSecret',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_platform_command`
--

DROP TABLE IF EXISTS `ecjia_platform_command`;
CREATE TABLE `ecjia_platform_command` (
  `cmd_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `cmd_word` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关键字',
  `account_id` int(10) NOT NULL,
  `platform` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '平台',
  `ext_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件标识符',
  `sub_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '子命令',
  PRIMARY KEY (`cmd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_platform_config`
--

DROP TABLE IF EXISTS `ecjia_platform_config`;
CREATE TABLE `ecjia_platform_config` (
  `account_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ext_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '扩展关键字',
  `ext_config` text COLLATE utf8mb4_unicode_ci NULL COMMENT '扩展配置',
  PRIMARY KEY (`account_id`,`ext_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_platform_extend`
--

DROP TABLE IF EXISTS `ecjia_platform_extend`;
CREATE TABLE `ecjia_platform_extend` (
  `ext_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '扩展id',
  `ext_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '扩展名称',
  `ext_desc` text COLLATE utf8mb4_unicode_ci NULL COMMENT '扩展描述',
  `ext_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '扩展关键字',
  `ext_config` text COLLATE utf8mb4_unicode_ci NULL COMMENT '扩展配置',
  `enabled` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '是否安装，1开启，0禁用',
  PRIMARY KEY (`ext_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_products`
--

DROP TABLE IF EXISTS `ecjia_products`;
CREATE TABLE `ecjia_products` (
  `product_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_attr` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `product_sn` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `product_number` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_push_event`
--

DROP TABLE IF EXISTS `ecjia_push_event`;
CREATE TABLE `ecjia_push_event` (
  `event_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息事件id',
  `event_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '消息事件名称',
  `event_code` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '消息事件code',
  `app_id` int(10) unsigned NULL COMMENT '客户端设备id',
  `template_id` int(10) unsigned NOT NULL COMMENT '模板id',
  `is_open` tinyint(3) NULL COMMENT '是否启用',
  `create_time` int(100) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_push_message`
--

DROP TABLE IF EXISTS `ecjia_push_message`;
CREATE TABLE `ecjia_push_message` (
  `message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(10) unsigned NOT NULL,
  `device_token` char(64) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `device_client` char(10) CHARACTER SET utf8mb4 NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `content` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `add_time` int(10) NOT NULL DEFAULT '0',
  `push_time` int(10) NOT NULL DEFAULT '0',
  `push_count` tinyint(1) NOT NULL DEFAULT '0',
  `template_id` mediumint(8) NULL,
  `in_status` tinyint(1) NOT NULL DEFAULT '0',
  `extradata` text CHARACTER SET utf8mb4 NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_qrcode_validate`
--

DROP TABLE IF EXISTS `ecjia_qrcode_validate`;
CREATE TABLE `ecjia_qrcode_validate` (
  `user_id` int(40) NOT NULL COMMENT 'user_id',
  `is_admin` bit(1) NULL COMMENT '是否是管理员',
  `uuid` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT 'code',
  `status` tinyint(4) NULL COMMENT '状态',
  `expires_in` int(11) NULL COMMENT '有效期',
  `device_udid` char(40) CHARACTER SET utf8mb4 DEFAULT NULL,
  `device_client` char(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `device_code` char(4) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_reg_extend_info`
--

DROP TABLE IF EXISTS `ecjia_reg_extend_info`;
CREATE TABLE `ecjia_reg_extend_info` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `reg_field_id` int(10) unsigned NULL,
  `content` text CHARACTER SET utf8mb4 NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_reg_fields`
--

DROP TABLE IF EXISTS `ecjia_reg_fields`;
CREATE TABLE `ecjia_reg_fields` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `reg_field_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `dis_order` tinyint(3) unsigned NOT NULL DEFAULT '100',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_need` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_region`
--

DROP TABLE IF EXISTS `ecjia_region`;
CREATE TABLE `ecjia_region` (
  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `region_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `region_type` tinyint(1) NOT NULL DEFAULT '2',
  `agency_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`region_id`),
  KEY `parent_id` (`parent_id`),
  KEY `region_type` (`region_type`),
  KEY `agency_id` (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_role`
--

DROP TABLE IF EXISTS `ecjia_role`;
CREATE TABLE `ecjia_role` (
  `role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `action_list` text CHARACTER SET utf8mb4 NULL,
  `role_describe` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`role_id`),
  KEY `user_name` (`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_searchengine`
--

DROP TABLE IF EXISTS `ecjia_searchengine`;
CREATE TABLE `ecjia_searchengine` (
  `date` date NOT NULL DEFAULT '2017-01-01',
  `searchengine` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`date`,`searchengine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_sessions`
--

DROP TABLE IF EXISTS `ecjia_sessions`;
CREATE TABLE `ecjia_sessions` (
  `sesskey` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `expiry` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `adminid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_name` varchar(60) CHARACTER SET utf8mb4 DEFAULT '',
  `user_rank` tinyint(3) NOT NULL DEFAULT '0',
  `discount` decimal(3,2) NOT NULL DEFAULT '0.00',
  `email` varchar(60) CHARACTER SET utf8mb4 DEFAULT '',
  `data` char(255) CHARACTER SET utf8mb4 DEFAULT '',
  PRIMARY KEY (`sesskey`),
  KEY `expiry` (`expiry`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_sessions_data`
--

DROP TABLE IF EXISTS `ecjia_sessions_data`;
CREATE TABLE `ecjia_sessions_data` (
  `sesskey` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `expiry` int(10) unsigned NOT NULL DEFAULT '0',
  `data` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`sesskey`),
  KEY `expiry` (`expiry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_shipping`
--

DROP TABLE IF EXISTS `ecjia_shipping`;
CREATE TABLE `ecjia_shipping` (
  `shipping_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `shipping_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shipping_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shipping_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `insure` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `support_cod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `shipping_print` text COLLATE utf8mb4_unicode_ci NULL,
  `print_bg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config_lable` text COLLATE utf8mb4_unicode_ci,
  `print_model` tinyint(1) DEFAULT '0',
  `shipping_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`shipping_id`),
  KEY `shipping_code` (`shipping_code`,`enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_shipping_area`
--

DROP TABLE IF EXISTS `ecjia_shipping_area`;
CREATE TABLE `ecjia_shipping_area` (
  `shipping_area_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `shipping_area_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shipping_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `configure` text COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`shipping_area_id`),
  KEY `shipping_id` (`shipping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_shop_config`
--

DROP TABLE IF EXISTS `ecjia_shop_config`;
CREATE TABLE `ecjia_shop_config` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `store_range` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `store_dir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8mb4_unicode_ci NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_site_options`
--

DROP TABLE IF EXISTS `ecjia_site_options`;
CREATE TABLE `ecjia_site_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint(20) NOT NULL DEFAULT '0',
  `option_name` varchar(200) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `option_value` longtext CHARACTER SET utf8mb4 NULL,
  `autoload` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`(191)),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_sites`
--

DROP TABLE IF EXISTS `ecjia_sites`;
CREATE TABLE `ecjia_sites` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `domain` varchar(200) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `path` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `domain` (`domain`(140),`path`(51))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_sms_sendlist`
--

DROP TABLE IF EXISTS `ecjia_sms_sendlist`;
CREATE TABLE `ecjia_sms_sendlist` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `template_id` mediumint(8) NULL,
  `sms_content` text CHARACTER SET utf8mb4 NULL,
  `error` tinyint(1) NOT NULL DEFAULT '0',
  `pri` tinyint(10) NULL,
  `last_send` int(10) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_staff_group`
--

DROP TABLE IF EXISTS `ecjia_staff_group`;
CREATE TABLE `ecjia_staff_group` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `action_list` text CHARACTER SET utf8mb4 NULL,
  `groupdescribe` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `store_group` (`group_id`,`store_id`),
  KEY `group_name` (`group_name`),
  KEY `store_id` (`store_id`),
  KEY `store_group_name` (`store_id`,`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_staff_log`
--

DROP TABLE IF EXISTS `ecjia_staff_log`;
CREATE TABLE `ecjia_staff_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_info` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `ip_address` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `ip_location` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`),
  KEY `user_id` (`user_id`),
  KEY `store_id` (`store_id`),
  KEY `store_user` (`store_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_staff_user`
--

DROP TABLE IF EXISTS `ecjia_staff_user`;
CREATE TABLE `ecjia_staff_user` (
  `user_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '联系方式',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `nick_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_ident` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `password` varchar(32) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `salt` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `action_list` text CHARACTER SET utf8mb4 NULL,
  `todolist` longtext CHARACTER SET utf8mb4,
  `group_id` smallint(5) DEFAULT NULL,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `avatar` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `introduction` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `online_status` tinyint(1) unsigned NOT NULL DEFAULT '4' COMMENT '1在线,2忙碌,3离开,4离线',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_stats`
--

DROP TABLE IF EXISTS `ecjia_stats`;
CREATE TABLE `ecjia_stats` (
  `access_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `visit_times` smallint(5) unsigned NOT NULL DEFAULT '1',
  `browser` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `system` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `language` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `area` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `referer_domain` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `referer_path` varchar(200) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `access_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  KEY `access_time` (`access_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_bill`
--

DROP TABLE IF EXISTS `ecjia_store_bill`;
CREATE TABLE `ecjia_store_bill` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_sn` char(15) NOT NULL,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `bill_month` varchar(10) NOT NULL,
  `order_count` int(10) unsigned NOT NULL DEFAULT '0',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `refund_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退款订单数',
  `refund_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `available_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '有效分成金额（订单总金额-退款金额）',
  `percent_value` decimal(5,2) unsigned NOT NULL COMMENT '佣金比例',
  `bill_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本月账单佣金金额',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否打款,1未打款，2部分打款，3已打款',
  `pay_time` int(10) unsigned NOT NULL COMMENT '付款时间',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bill_id`),
  UNIQUE KEY `bill_sn` (`bill_sn`),
  UNIQUE KEY `store_bill` (`store_id`,`bill_month`),
  KEY `store_id` (`store_id`),
  KEY `store_bill_id` (`bill_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='店铺账单表';

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_bill_day`
--

DROP TABLE IF EXISTS `ecjia_store_bill_day`;
CREATE TABLE `ecjia_store_bill_day` (
  `day_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `day` date NOT NULL COMMENT '日期',
  `order_count` int(10) unsigned NOT NULL DEFAULT '0',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `refund_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退款订单数',
  `refund_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `percent_value` decimal(4,2) NOT NULL COMMENT '佣金比例',
  `brokerage_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金金额',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`day_id`),
  UNIQUE KEY `store_day` (`store_id`,`day`),
  KEY `store_id` (`store_id`),
  KEY `day` (`day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='店铺账单日统计表';

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_bill_detail`
--

DROP TABLE IF EXISTS `ecjia_store_bill_detail`;
CREATE TABLE `ecjia_store_bill_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1订单，2退货单',
  `order_id` mediumint(8) unsigned NOT NULL,
  `percent_value` decimal(5,2) unsigned NOT NULL COMMENT '佣金比例',
  `brokerage_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '佣金金额',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`detail_id`),
  UNIQUE KEY `store_detail` (`detail_id`,`store_id`),
  KEY `store_id` (`store_id`),
  KEY `order_type` (`order_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='店铺账单明细表';

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_bill_paylog`
--

DROP TABLE IF EXISTS `ecjia_store_bill_paylog`;
CREATE TABLE `ecjia_store_bill_paylog` (
  `paylog_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `bill_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账单金额',
  `payee` varchar(80) NOT NULL COMMENT '收款人',
  `bank_account_number` varchar(30) NOT NULL COMMENT '银行账号',
  `bank_name` varchar(40) NOT NULL COMMENT '收款银行',
  `bank_branch_name` varchar(40) DEFAULT NULL COMMENT '开户银行支行名称',
  `mobile` varchar(15) DEFAULT NULL COMMENT '手机',
  `admin_id` smallint(5) unsigned NOT NULL,
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`paylog_id`),
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='店铺账单付款流水';

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_category`
--

DROP TABLE IF EXISTS `ecjia_store_category`;
CREATE TABLE `ecjia_store_category` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(90) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `keywords` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cat_desc` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '50',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `cat_image` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_check_log`
--

DROP TABLE IF EXISTS `ecjia_store_check_log`;
CREATE TABLE `ecjia_store_check_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1申请入驻，2店铺信息修改',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NULL,
  `original_data` text COLLATE utf8mb4_unicode_ci NULL,
  `new_data` text COLLATE utf8mb4_unicode_ci NULL,
  `info` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_franchisee`
--

DROP TABLE IF EXISTS `ecjia_store_franchisee`;
CREATE TABLE `ecjia_store_franchisee` (
  `store_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) NOT NULL DEFAULT '0',
  `validate_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '入驻类型',
  `manage_mode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'join' COMMENT '经营模式，self自营，join入驻商家',
  `merchants_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '店铺名称',
  `shop_keyword` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '店铺关键字',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '店铺锁定 1正常，2锁定',
  `shop_close` tinyint(1) NOT NULL DEFAULT '1' COMMENT '暂时关闭商店 0否，1是',
  `responsible_person` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '责任人（法人代表或真实姓名）',
  `company_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '公司名称',
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `contact_mobile` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '联系方式',
  `apply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '申请时间',
  `confirm_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核通过时间',
  `address` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '详细地址',
  `identity_type` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '证件类型1个人2企业',
  `identity_number` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '证件号码',
  `personhand_identity_pic` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '手持证件拍照',
  `identity_pic_front` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '证件正面',
  `identity_pic_back` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '证件反面',
  `identity_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '入驻身份信息认证状态，0、待审核，1、审核中，2、审核通过，3、拒绝通过',
  `business_licence` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '营业执照注册号',
  `business_licence_pic` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '营业执照',
  `bank_account_name` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '账户名称',
  `bank_name` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '收款银行',
  `bank_branch_name` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '开户银行支行名称',
  `bank_account_number` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '银行账号',
  `bank_address` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '开户银行支行地址',
  `percent_id` int(10) unsigned DEFAULT NULL COMMENT '结算比例id',
  `remark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '网站管理员备注信息',
  `longitude` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '纬度',
  `geohash` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `sort_order` tinyint(1) NOT NULL DEFAULT '50',
  `province` int(10) NULL,
  `city` int(10) NULL,
  `district` int(10) NULL,
  PRIMARY KEY (`store_id`),
  UNIQUE KEY `merchants_name` (`merchants_name`) USING BTREE,
  UNIQUE KEY `mobile` (`contact_mobile`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `percent_id` (`percent_id`),
  KEY `geohash` (`geohash`),
  KEY `manage_mode` (`manage_mode`),
  KEY `shop_close` (`shop_close`),
  KEY `identity_status` (`identity_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_keywords`
--

DROP TABLE IF EXISTS `ecjia_store_keywords`;
CREATE TABLE `ecjia_store_keywords` (
  `date` date NOT NULL DEFAULT '2017-01-01',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `keyword` varchar(90) NOT NULL DEFAULT '',
  `count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`date`,`store_id`,`keyword`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_percent`
--

DROP TABLE IF EXISTS `ecjia_store_percent`;
CREATE TABLE `ecjia_store_percent` (
  `percent_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `percent_value` decimal(5,2) unsigned NOT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '50',
  `add_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`percent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_store_preaudit`
--

DROP TABLE IF EXISTS `ecjia_store_preaudit`;
CREATE TABLE `ecjia_store_preaudit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_id` smallint(5) NOT NULL DEFAULT '0',
  `validate_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '入驻类型',
  `merchants_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '店铺名称',
  `shop_keyword` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '店铺关键字',
  `check_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '店铺审核状态 1待审核,2通过，3不通过',
  `identity_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '证件认证状态，0待审核，1审核中，2审核通过，3拒绝通过',
  `responsible_person` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '责任人（法人代表或真实姓名）',
  `company_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '公司名称',
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `contact_mobile` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '联系方式',
  `apply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '申请时间',
  `province` int(10) NULL,
  `city` int(10) NULL,
  `district` int(10) NULL,
  `address` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '详细地址',
  `identity_type` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '证件类型1个人2企业',
  `identity_number` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '证件号码',
  `personhand_identity_pic` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '手持证件拍照',
  `identity_pic_front` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '证件正面',
  `identity_pic_back` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '证件反面',
  `business_licence` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '营业执照注册号',
  `business_licence_pic` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '营业执照',
  `bank_account_name` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '帐户名称',
  `bank_name` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '收款银行',
  `bank_branch_name` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '开户银行支行名称',
  `bank_account_number` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '银行账号',
  `bank_address` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '开户银行支行地址',
  `remark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '网站管理员备注信息',
  `longitude` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '纬度',
  `geohash` varchar(15) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`contact_mobile`),
  UNIQUE KEY `email` (`email`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_template`
--

DROP TABLE IF EXISTS `ecjia_template`;
CREATE TABLE `ecjia_template` (
  `filename` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `region` varchar(40) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `library` varchar(40) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `number` tinyint(1) unsigned NOT NULL DEFAULT '5',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `theme` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `remarks` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  KEY `filename` (`filename`,`region`),
  KEY `theme` (`theme`),
  KEY `remarks` (`remarks`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_template_widget`
--

DROP TABLE IF EXISTS `ecjia_template_widget`;
CREATE TABLE `ecjia_template_widget` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `filename` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `region` varchar(40) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `library` varchar(40) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `theme` varchar(60) CHARACTER SET utf8mb4 NULL,
  `widget_config` text COLLATE utf8mb4_unicode_ci,
  `remarks` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `filename` (`filename`,`region`),
  KEY `theme` (`theme`),
  KEY `remarks` (`remarks`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_term_meta`
--

DROP TABLE IF EXISTS `ecjia_term_meta`;
CREATE TABLE `ecjia_term_meta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_type` char(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `object_group` char(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `object_id` int(11) NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `meta_value` longtext CHARACTER SET utf8mb4,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_term_relationship`
--

DROP TABLE IF EXISTS `ecjia_term_relationship`;
CREATE TABLE `ecjia_term_relationship` (
  `relation_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_type` char(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `object_group` char(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `object_id` int(11) NOT NULL,
  `item_key1` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `item_value1` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `item_key2` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `item_value2` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `item_key3` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `item_value3` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `item_key4` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  `item_value4` varchar(60) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`relation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_topic`
--

DROP TABLE IF EXISTS `ecjia_topic`;
CREATE TABLE `ecjia_topic` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `intro` text CHARACTER SET utf8mb4 NULL,
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(10) NOT NULL DEFAULT '0',
  `data` text CHARACTER SET utf8mb4 NULL,
  `template` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `css` text CHARACTER SET utf8mb4 NULL,
  `topic_img` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `title_pic` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `base_style` char(6) CHARACTER SET utf8mb4 DEFAULT NULL,
  `htmls` mediumtext CHARACTER SET utf8mb4,
  `keywords` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_user_account`
--

DROP TABLE IF EXISTS `ecjia_user_account`;
CREATE TABLE `ecjia_user_account` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `order_sn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单编号',
  `admin_user` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `amount` decimal(10,2) NOT NULL,
  `add_time` int(10) NOT NULL DEFAULT '0',
  `paid_time` int(10) NOT NULL DEFAULT '0',
  `admin_note` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_note` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `process_type` tinyint(1) NOT NULL DEFAULT '0',
  `payment` varchar(90) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_paid` (`is_paid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_user_address`
--

DROP TABLE IF EXISTS `ecjia_user_address`;
CREATE TABLE `ecjia_user_address` (
  `address_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `address_name` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `consignee` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `country` smallint(5) NOT NULL DEFAULT '0',
  `province` smallint(5) NOT NULL DEFAULT '0',
  `city` smallint(5) NOT NULL DEFAULT '0',
  `district` smallint(5) NOT NULL DEFAULT '0',
  `address` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `address_info` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `zipcode` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `tel` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `mobile` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `sign_building` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `best_time` varchar(120) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `audit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `longitude` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '经度',
  `latitude` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '纬度',
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_user_bonus`
--

DROP TABLE IF EXISTS `ecjia_user_bonus`;
CREATE TABLE `ecjia_user_bonus` (
  `bonus_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `bonus_type_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bonus_sn` bigint(20) unsigned NOT NULL DEFAULT '0',
  `bonus_password` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `used_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `emailed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bind_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bonus_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_user_rank`
--

DROP TABLE IF EXISTS `ecjia_user_rank`;
CREATE TABLE `ecjia_user_rank` (
  `rank_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `min_points` int(10) unsigned NOT NULL DEFAULT '0',
  `max_points` int(10) unsigned NOT NULL DEFAULT '0',
  `discount` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `show_price` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `special_rank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_users`
--

DROP TABLE IF EXISTS `ecjia_users`;
CREATE TABLE `ecjia_users` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `user_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `password` varchar(32) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `avatar_img` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '用户头像',
  `question` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '1000-01-01',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `frozen_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pay_points` int(10) unsigned NOT NULL DEFAULT '0',
  `rank_points` int(10) unsigned NOT NULL DEFAULT '0',
  `address_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(11) unsigned NOT NULL DEFAULT '0',
  `last_time` datetime NOT NULL DEFAULT '2017-01-01 00:00:00',
  `last_ip` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_rank` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_special` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ec_salt` varchar(10) CHARACTER SET utf8mb4 DEFAULT NULL,
  `salt` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `parent_id` mediumint(9) NOT NULL DEFAULT '0',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `msn` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `qq` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `office_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `home_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `mobile_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `is_validated` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `credit_line` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `passwd_question` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `passwd_answer` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `email` (`email`),
  KEY `parent_id` (`parent_id`),
  KEY `flag` (`flag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_volume_price`
--

DROP TABLE IF EXISTS `ecjia_volume_price`;
CREATE TABLE `ecjia_volume_price` (
  `price_type` tinyint(1) unsigned NOT NULL,
  `goods_id` mediumint(8) unsigned NOT NULL,
  `volume_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `volume_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`price_type`,`goods_id`,`volume_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_custom_message`
--

DROP TABLE IF EXISTS `ecjia_wechat_custom_message`;
CREATE TABLE `ecjia_wechat_custom_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '信息内容',
  `iswechat` smallint(1) unsigned DEFAULT NULL,
  `send_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_customer`
--

DROP TABLE IF EXISTS `ecjia_wechat_customer`;
CREATE TABLE `ecjia_wechat_customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wechat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `kf_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '客服工号',
  `kf_account` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '完整客服账号',
  `kf_nick` varchar(100) COLLATE utf8mb4_unicode_ci NULL COMMENT '客服昵称',
  `kf_headimgurl` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '客服头像',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '客服状态',
  `online_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '客服在线状态',
  `accepted_case` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '客服当前正在接待的会话数',
  `kf_wx` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invite_wx` varchar(200) COLLATE utf8mb4_unicode_ci NULL,
  `invite_expire_time` int(10) NOT NULL DEFAULT '0',
  `invite_status` varchar(100) COLLATE utf8mb4_unicode_ci NULL,
  `file_url` varchar(255) COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_customer_session`
--

DROP TABLE IF EXISTS `ecjia_wechat_customer_session`;
CREATE TABLE `ecjia_wechat_customer_session` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wechat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `kf_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '客服账号',
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户openid',
  `opercode` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会话状态',
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '发送内容',
  `time` int(11) unsigned NOT NULL COMMENT '发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_mass_history`
--

DROP TABLE IF EXISTS `ecjia_wechat_mass_history`;
CREATE TABLE `ecjia_wechat_mass_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wechat_id` int(11) unsigned NOT NULL,
  `media_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '素材id',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '发送内容类型',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '发送状态，对应微信通通知状态',
  `send_time` int(11) unsigned NOT NULL DEFAULT '0',
  `msg_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信端返回的消息ID',
  `totalcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'group_id下粉丝数；或者openid_list中的粉丝数',
  `filtercount` int(10) unsigned NOT NULL DEFAULT '0',
  `sentcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送成功的粉丝数',
  `errorcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送失败的粉丝数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_media`
--

DROP TABLE IF EXISTS `ecjia_wechat_media`;
CREATE TABLE `ecjia_wechat_media` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `wechat_id` int(10) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图文消息标题',
  `command` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '关键词',
  `author` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_show` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示封面，1为显示，0为不显示',
  `digest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图文消息的描述',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图文消息页面的内容，支持HTML标签',
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '点击图文消息跳转链接',
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片链接',
  `size` int(7) DEFAULT NULL COMMENT '媒体文件上传后，获取时的唯一标识',
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '媒体文件上传时间戳',
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `edit_time` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `article_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `media_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_material` varchar(20) COLLATE utf8mb4_unicode_ci NULL,
  `media_url` varchar(255) COLLATE utf8mb4_unicode_ci NULL,
  `parent_id` int(10) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_menu`
--

DROP TABLE IF EXISTS `ecjia_wechat_menu`;
CREATE TABLE `ecjia_wechat_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wechat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '菜单标题',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '菜单的响应动作类型',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '菜单KEY值，click类型必须',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '网页链接，view类型必须',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_oauth`
--

DROP TABLE IF EXISTS `ecjia_wechat_oauth`;
CREATE TABLE `ecjia_wechat_oauth` (
  `wechat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `oauth_redirecturi` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `oauth_count` int(8) unsigned NOT NULL DEFAULT '0',
  `oauth_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启授权',
  `last_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wechat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_point`
--

DROP TABLE IF EXISTS `ecjia_wechat_point`;
CREATE TABLE `ecjia_wechat_point` (
  `log_id` mediumint(8) unsigned NOT NULL COMMENT '积分增加记录id',
  `openid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(100) COLLATE utf8mb4_unicode_ci NULL COMMENT '关键词',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_prize`
--

DROP TABLE IF EXISTS `ecjia_wechat_prize`;
CREATE TABLE `ecjia_wechat_prize` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `wechat_id` int(11) unsigned NOT NULL,
  `openid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prize_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_status` int(2) NOT NULL DEFAULT '0' COMMENT '发放状态，0未发放，1发放',
  `winner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0',
  `prize_type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否中奖，0未中奖，1中奖',
  `activity_type` varchar(20) COLLATE utf8mb4_unicode_ci NULL COMMENT '活动类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_qrcode`
--

DROP TABLE IF EXISTS `ecjia_wechat_qrcode`;
CREATE TABLE `ecjia_wechat_qrcode` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '二维码类型，0临时，1永久',
  `expire_seconds` int(4) DEFAULT NULL COMMENT '二维码有效时间',
  `scene_id` int(10) NULL COMMENT '场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）',
  `username` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '推荐人',
  `function` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '功能',
  `ticket` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '二维码ticket',
  `qrcode_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '二维码路径',
  `endtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `scan_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扫描量',
  `wechat_id` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_reply`
--

DROP TABLE IF EXISTS `ecjia_wechat_reply`;
CREATE TABLE `ecjia_wechat_reply` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `wechat_id` int(11) unsigned NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NULL COMMENT '自动回复类型',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_id` int(10) DEFAULT NULL,
  `rule_name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `reply_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关键词回复内容的类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_request_times`
--

DROP TABLE IF EXISTS `ecjia_wechat_request_times`;
CREATE TABLE `ecjia_wechat_request_times` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wechat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `day` date NOT NULL COMMENT '日期',
  `api_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Api名称',
  `times` int(10) NULL COMMENT '限制次数',
  `last_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后请求时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `day` (`day`,`api_name`,`wechat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_rule_keywords`
--

DROP TABLE IF EXISTS `ecjia_wechat_rule_keywords`;
CREATE TABLE `ecjia_wechat_rule_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NULL COMMENT '规则id',
  `rule_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_tag`
--

DROP TABLE IF EXISTS `ecjia_wechat_tag`;
CREATE TABLE `ecjia_wechat_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wechat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标签名字',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签内用户数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_user`
--

DROP TABLE IF EXISTS `ecjia_wechat_user`;
CREATE TABLE `ecjia_wechat_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wechat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否订阅该公众号标识',
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户的标识',
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '用户的昵称',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户的性别',
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '用户所在城市',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '用户所在国家',
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '用户所在省份',
  `language` varchar(50) COLLATE utf8mb4_unicode_ci NULL COMMENT '用户的语言',
  `headimgurl` varchar(255) COLLATE utf8mb4_unicode_ci NULL COMMENT '用户头像',
  `subscribe_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户关注时间',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privilege` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unionid` varchar(255) COLLATE utf8mb4_unicode_ci NULL,
  `group_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户组id',
  `ect_uid` int(11) unsigned NULL COMMENT 'ecjiahop会员id',
  `bein_kefu` tinyint(1) unsigned NULL COMMENT '是否处在多客服流程',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_user_group`
--

DROP TABLE IF EXISTS `ecjia_wechat_user_group`;
CREATE TABLE `ecjia_wechat_user_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wechat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分组id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分组名字，UTF8编码',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分组内用户数量',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ecjia_wechat_user_tag`
--

DROP TABLE IF EXISTS `ecjia_wechat_user_tag`;
CREATE TABLE `ecjia_wechat_user_tag` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `tagid` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `userid` (`userid`),
  KEY `tagid` (`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
