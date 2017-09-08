<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

$contentDir = dirname(dirname(__FILE__)) . '/content';

return array(
	
    'CreateAccountLogTable' => $contentDir . '/database/migrations/2017_03_03_170201_create_account_log_table.php',
    'CreateAdTable' => $contentDir . '/database/migrations/2017_03_06_163732_create_ad_table.php',
    'CreateAdPositionTable' => $contentDir . '/database/migrations/2017_03_06_164930_create_ad_position_table.php',
    'CreateAdminLogTable' => $contentDir . '/database/migrations/2017_03_06_181301_create_admin_log_table.php',
    'CreateAdminMessageTable' => $contentDir . '/database/migrations/2017_03_06_184226_create_admin_message_table.php',
    'CreateAdminUserTable' => $contentDir . '/database/migrations/2017_03_07_094740_create_admin_user_table.php',
    'CreateAdsenseTable' => $contentDir . '/database/migrations/2017_03_07_095103_create_adsense_table.php',
    'CreateAffiliateLogTable' => $contentDir . '/database/migrations/2017_03_07_100204_create_affiliate_log_table.php',
    'CreateAreaRegionTable' => $contentDir . '/database/migrations/2017_03_07_100507_create_area_region_table.php',
    'CreateArticleTable' => $contentDir . '/database/migrations/2017_03_07_101656_create_article_table.php',
    'CreateArticleCatTable' => $contentDir . '/database/migrations/2017_03_07_102324_create_article_cat_table.php',
    'CreateAttributeTable' => $contentDir . '/database/migrations/2017_03_07_105929_create_attribute_table.php',
    'CreateAutoManageTable' => $contentDir . '/database/migrations/2017_03_07_132654_create_auto_manage_table.php',
    'CreateBackGoodsTable' => $contentDir . '/database/migrations/2017_03_07_133247_create_back_goods_table.php',
    'CreateBackOrderTable' => $contentDir . '/database/migrations/2017_03_07_135415_create_back_order_table.php',
    'CreateBonusTypeTable' => $contentDir . '/database/migrations/2017_03_07_140959_create_bonus_type_table.php',
    'CreateBrandTable' => $contentDir . '/database/migrations/2017_03_07_141439_create_brand_table.php',
    'CreateCartTable' => $contentDir . '/database/migrations/2017_03_07_150504_create_cart_table.php',
    'CreateCatRecommendTable' => $contentDir . '/database/migrations/2017_03_07_150733_create_cat_recommend_table.php',
    'CreateCategoryTable' => $contentDir . '/database/migrations/2017_03_07_153658_create_category_table.php',
    'CreateCollectGoodsTable' => $contentDir . '/database/migrations/2017_03_07_154651_create_collect_goods_table.php',
    'CreateCollectStoreTable' => $contentDir . '/database/migrations/2017_03_07_154827_create_collect_store_table.php',
    'CreateConnectTable' => $contentDir . '/database/migrations/2017_03_07_155734_create_connect_table.php',
    'CreateConnectUserTable' => $contentDir . '/database/migrations/2017_03_07_160637_create_connect_user_table.php',
    'CreateCronsTable' => $contentDir . '/database/migrations/2017_03_07_163442_create_crons_table.php',
    'CreateDeliveryGoodsTable' => $contentDir . '/database/migrations/2017_03_07_164223_create_delivery_goods_table.php',
    'CreateDeliveryOrderTable' => $contentDir . '/database/migrations/2017_03_07_170004_create_delivery_order_table.php',
    'CreateEmailListTable' => $contentDir . '/database/migrations/2017_03_07_170342_create_email_list_table.php',
    'CreateEmailSendlistTable' => $contentDir . '/database/migrations/2017_03_07_170810_create_email_sendlist_table.php',
    'CreateExpressCheckinTable' => $contentDir . '/database/migrations/2017_03_07_173755_create_express_checkin_table.php',
    'CreateExpressOrderTable' => $contentDir . '/database/migrations/2017_03_08_103525_create_express_order_table.php',
    'CreateExpressUserTable' => $contentDir . '/database/migrations/2017_03_08_110156_create_express_user_table.php',
    'CreateFavourableActivityTable' => $contentDir . '/database/migrations/2017_03_08_112200_create_favourable_activity_table.php',
    'CreateGoodsTable' => $contentDir . '/database/migrations/2017_03_08_121311_create_goods_table.php',
    'CreateGoodsActivityTable' => $contentDir . '/database/migrations/2017_03_08_132245_create_goods_activity_table.php',
    'CreateGoodsArticleTable' => $contentDir . '/database/migrations/2017_03_08_133109_create_goods_article_table.php',
    'CreateGoodsAttrTable' => $contentDir . '/database/migrations/2017_03_08_134814_create_goods_attr_table.php',
    'CreateGoodsCatTable' => $contentDir . '/database/migrations/2017_03_08_135053_create_goods_cat_table.php',
    'CreateGoodsGalleryTable' => $contentDir . '/database/migrations/2017_03_08_135417_create_goods_gallery_table.php',
    'CreateGoodsTypeTable' => $contentDir . '/database/migrations/2017_03_08_140420_create_goods_type_table.php',
    'CreateGroupGoodsTable' => $contentDir . '/database/migrations/2017_03_08_140933_create_group_goods_table.php',
    'CreateInviteRewardTable' => $contentDir . '/database/migrations/2017_03_08_142221_create_invite_reward_table.php',
    'CreateInviteeRecordTable' => $contentDir . '/database/migrations/2017_03_08_143001_create_invitee_record_table.php',
    'CreateKeywordsTable' => $contentDir . '/database/migrations/2017_03_08_150840_create_keywords_table.php',
    'CreateLinkGoodsTable' => $contentDir . '/database/migrations/2017_03_08_155236_create_link_goods_table.php',
    'CreateMailTemplatesTable' => $contentDir . '/database/migrations/2017_03_09_144926_create_mail_templates_table.php',
    'CreateMemberPriceTable' => $contentDir . '/database/migrations/2017_03_09_145521_create_member_price_table.php',
    'CreateMerchantsCategoryTable' => $contentDir . '/database/migrations/2017_03_09_152328_create_merchants_category_table.php',
    'CreateMerchantsConfigTable' => $contentDir . '/database/migrations/2017_03_09_153012_create_merchants_config_table.php',
    'CreateMobileCheckinTable' => $contentDir . '/database/migrations/2017_03_09_153423_create_mobile_checkin_table.php',
    'CreateMobileDeviceTable' => $contentDir . '/database/migrations/2017_03_09_154426_create_mobile_device_table.php',
    'CreateMobileManageTable' => $contentDir . '/database/migrations/2017_03_09_155522_create_mobile_manage_table.php',
    'CreateMobileNewsTable' => $contentDir . '/database/migrations/2017_03_09_161915_create_mobile_news_table.php',
    'CreateMobileScreenshotsTable' => $contentDir . '/database/migrations/2017_03_09_162545_create_mobile_screenshots_table.php',
    'CreateNavTable' => $contentDir . '/database/migrations/2017_03_09_163255_create_nav_table.php',
    'CreateNotificationsTable' => $contentDir . '/database/migrations/2017_03_09_163349_create_notifications_table.php',
    'CreateOrderActionTable' => $contentDir . '/database/migrations/2017_03_09_175359_create_order_action_table.php',
    'CreateOrderGoodsTable' => $contentDir . '/database/migrations/2017_03_09_180443_create_order_goods_table.php',
    'CreateOrderInfoTable' => $contentDir . '/database/migrations/2017_03_10_132131_create_order_info_table.php',
    'CreateOrderReminderTable' => $contentDir . '/database/migrations/2017_03_10_132941_create_order_reminder_table.php',
    'CreateOrderStatusLogTable' => $contentDir . '/database/migrations/2017_03_10_133246_create_order_status_log_table.php',
    'CreatePackageGoodsTable' => $contentDir . '/database/migrations/2017_03_10_133827_create_package_goods_table.php',
    'CreatePayLogTable' => $contentDir . '/database/migrations/2017_03_10_134146_create_pay_log_table.php',
    'CreatePaymentTable' => $contentDir . '/database/migrations/2017_03_10_135231_create_payment_table.php',
    'CreatePaymentRecordTable' => $contentDir . '/database/migrations/2017_03_10_135908_create_payment_record_table.php',
    'CreatePlatformAccountTable' => $contentDir . '/database/migrations/2017_03_10_141007_create_platform_account_table.php',
    'CreatePlatformCommandTable' => $contentDir . '/database/migrations/2017_03_10_141416_create_platform_command_table.php',
    'CreatePlatformConfigTable' => $contentDir . '/database/migrations/2017_03_10_141749_create_platform_config_table.php',
    'CreatePlatformExtendTable' => $contentDir . '/database/migrations/2017_03_10_142207_create_platform_extend_table.php',
    'CreateProductsTable' => $contentDir . '/database/migrations/2017_03_10_142529_create_products_table.php',
    'CreatePushEventTable' => $contentDir . '/database/migrations/2017_03_10_143928_create_push_event_table.php',
    'CreatePushMessageTable' => $contentDir . '/database/migrations/2017_03_10_144455_create_push_message_table.php',
    'CreateRegExtendInfoTable' => $contentDir . '/database/migrations/2017_03_10_150625_create_reg_extend_info_table.php',
    'CreateRegFieldsTable' => $contentDir . '/database/migrations/2017_03_10_151013_create_reg_fields_table.php',
    'CreateRegionTable' => $contentDir . '/database/migrations/2017_03_10_151513_create_region_table.php',
    'CreateRoleTable' => $contentDir . '/database/migrations/2017_03_10_151734_create_role_table.php',
    'CreateSearchengineTable' => $contentDir . '/database/migrations/2017_03_10_165327_create_searchengine_table.php',
    'CreateSessionsTable' => $contentDir . '/database/migrations/2017_03_10_170133_create_sessions_table.php',
    'CreateSessionsDataTable' => $contentDir . '/database/migrations/2017_03_10_170350_create_sessions_data_table.php',
    'CreateShippingTable' => $contentDir . '/database/migrations/2017_03_10_171203_create_shipping_table.php',
    'CreateShippingAreaTable' => $contentDir . '/database/migrations/2017_03_10_171445_create_shipping_area_table.php',
    'CreateShopConfigTable' => $contentDir . '/database/migrations/2017_03_10_171943_create_shop_config_table.php',
    'CreateSiteOptionsTable' => $contentDir . '/database/migrations/2017_03_10_173004_create_site_options_table.php',
    'CreateSitesTable' => $contentDir . '/database/migrations/2017_03_10_174331_create_sites_table.php',
    'CreateSmsSendlistTable' => $contentDir . '/database/migrations/2017_03_13_114959_create_sms_sendlist_table.php',
    'CreateStaffGroupTable' => $contentDir . '/database/migrations/2017_03_13_115918_create_staff_group_table.php',
    'CreateStaffLogTable' => $contentDir . '/database/migrations/2017_03_13_120621_create_staff_log_table.php',
    'CreateStaffUserTable' => $contentDir . '/database/migrations/2017_03_13_133250_create_staff_user_table.php',
    'CreateStatsTable' => $contentDir . '/database/migrations/2017_03_13_165231_create_stats_table.php',
    'CreateStoreBillTable' => $contentDir . '/database/migrations/2017_03_13_170309_create_store_bill_table.php',
    'CreateStoreBillDayTable' => $contentDir . '/database/migrations/2017_03_13_171456_create_store_bill_day_table.php',
    'CreateStoreBillDetailTable' => $contentDir . '/database/migrations/2017_03_13_172202_create_store_bill_detail_table.php',
    'CreateStoreBillPaylogTable' => $contentDir . '/database/migrations/2017_03_13_172800_create_store_bill_paylog_table.php',
    'CreateStoreCategoryTable' => $contentDir . '/database/migrations/2017_03_14_102148_create_store_category_table.php',
    'CreateStoreCheckLogTable' => $contentDir . '/database/migrations/2017_03_14_102638_create_store_check_log_table.php',
    'CreateStoreFranchiseeTable' => $contentDir . '/database/migrations/2017_03_14_105627_create_store_franchisee_table.php',
    'CreateStoreKeywordsTable' => $contentDir . '/database/migrations/2017_03_14_105939_create_store_keywords_table.php',
    'CreateStorePercentTable' => $contentDir . '/database/migrations/2017_03_14_110227_create_store_percent_table.php',
    'CreateStorePreauditTable' => $contentDir . '/database/migrations/2017_03_14_115842_create_store_preaudit_table.php',
    'CreateTemplateWidgetTable' => $contentDir . '/database/migrations/2017_03_14_131256_create_template_widget_table.php',
    'CreateTermMetaTable' => $contentDir . '/database/migrations/2017_03_14_133615_create_term_meta_table.php',
    'CreateTermRelationshipTable' => $contentDir . '/database/migrations/2017_03_14_134129_create_term_relationship_table.php',
    'CreateTopicTable' => $contentDir . '/database/migrations/2017_03_14_134848_create_topic_table.php',
    'CreateUserAccountTable' => $contentDir . '/database/migrations/2017_03_14_135654_create_user_account_table.php',
    'CreateUserAddressTable' => $contentDir . '/database/migrations/2017_03_14_141935_create_user_address_table.php',
    'CreateUserBonusTable' => $contentDir . '/database/migrations/2017_03_14_142413_create_user_bonus_table.php',
    'CreateUserRankTable' => $contentDir . '/database/migrations/2017_03_14_142918_create_user_rank_table.php',
    'CreateUsersTable' => $contentDir . '/database/migrations/2017_03_14_150031_create_users_table.php',
    'CreateVolumePriceTable' => $contentDir . '/database/migrations/2017_03_14_150318_create_volume_price_table.php',
    'CreateWechatCustomMessageTable' => $contentDir . '/database/migrations/2017_03_14_150646_create_wechat_custom_message_table.php',
    'CreateWechatCustomerTable' => $contentDir . '/database/migrations/2017_03_14_152231_create_wechat_customer_table.php',
    'CreateWechatCustomerSessionTable' => $contentDir . '/database/migrations/2017_03_14_152644_create_wechat_customer_session_table.php',
    'CreateWechatMassHistoryTable' => $contentDir . '/database/migrations/2017_03_14_153258_create_wechat_mass_history_table.php',
    'CreateWechatMediaTable' => $contentDir . '/database/migrations/2017_03_14_155318_create_wechat_media_table.php',
    'CreateWechatMenuTable' => $contentDir . '/database/migrations/2017_03_15_161251_create_wechat_menu_table.php',
    'CreateWechatOauthTable' => $contentDir . '/database/migrations/2017_03_15_161822_create_wechat_oauth_table.php',
    'CreateWechatPointTable' => $contentDir . '/database/migrations/2017_03_15_162248_create_wechat_point_table.php',
    'CreateWechatPrizeTable' => $contentDir . '/database/migrations/2017_03_15_164056_create_wechat_prize_table.php',
    'CreateWechatQrcodeTable' => $contentDir . '/database/migrations/2017_03_15_165156_create_wechat_qrcode_table.php',
    'CreateWechatReplyTable' => $contentDir . '/database/migrations/2017_03_15_170058_create_wechat_reply_table.php',
    'CreateWechatRequestTimesTable' => $contentDir . '/database/migrations/2017_03_15_170511_create_wechat_request_times_table.php',
    'CreateWechatRuleKeywordsTable' => $contentDir . '/database/migrations/2017_03_15_170746_create_wechat_rule_keywords_table.php',
    'CreateWechatTagTable' => $contentDir . '/database/migrations/2017_03_15_171111_create_wechat_tag_table.php',
    'CreateWechatUserTable' => $contentDir . '/database/migrations/2017_03_15_173235_create_wechat_user_table.php',
    'CreateWechatUserTagTable' => $contentDir . '/database/migrations/2017_03_15_173743_create_wechat_user_tag_table.php',
    'CreateTermAttachmentTable' => $contentDir . '/database/migrations/2017_03_22_133140_create_term_attachment_table.php',
    'CreateCommentTable' => $contentDir . '/database/migrations/2017_03_22_170346_create_comment_table.php',
    'CreateCommentAppealTable' => $contentDir . '/database/migrations/2017_03_22_170435_create_comment_appeal_table.php',
    'CreateCommentReplyTable' => $contentDir . '/database/migrations/2017_03_22_170459_create_comment_reply_table.php',
    'CreateGoodsDataTable' => $contentDir . '/database/migrations/2017_03_23_161538_create_goods_data_table.php',
    'AlertStaffUserByGroupIdTable' => $contentDir . '/database/migrations/2017_04_20_095558_alert_staff_user_by_group_id_table.php',
    'AddCityCodeToAdPositionTable' => $contentDir . '/database/migrations/2017_05_05_101947_add_city_code_to_ad_position_table.php',
    'AddShowClientToAdTable' => $contentDir . '/database/migrations/2017_05_05_104042_add_show_client_to_ad_table.php',
    'CreateMerchantsAdTable' => $contentDir . '/database/migrations/2017_06_14_112611_create_merchants_ad_table.php',
    'CreateMerchantsAdPositionTable' => $contentDir . '/database/migrations/2017_06_14_113657_create_merchants_ad_position_table.php',
    'CreateNotificationChannelsTable' => $contentDir . '/database/migrations/2017_06_14_114511_create_notification_channels_table.php',
    'CreateNotificationTemplatesTable' => $contentDir . '/database/migrations/2017_06_14_115023_create_notification_templates_table.php',
    'CreateNotificationEventsTable' => $contentDir . '/database/migrations/2017_06_14_132723_create_notification_events_table.php',
    'CreateDiscussCommentsTable' => $contentDir . '/database/migrations/2017_06_14_133830_create_discuss_comments_table.php',
    'CreateDiscussLikesTable' => $contentDir . '/database/migrations/2017_06_14_134453_create_discuss_likes_table.php',
    'AddCatImageToMerchantsCategoryTable' => $contentDir . '/database/migrations/2017_06_14_140837_add_cat_image_to_merchants_category_table.php',
    'AlterArticleTable' => $contentDir . '/database/migrations/2017_06_14_141241_alter_article_table.php',
    'AlterSmsSendlistTable' => $contentDir . '/database/migrations/2017_06_14_143031_alter_sms_sendlist_table.php',
    'CreateFinanceInvoiceTable' => $contentDir . '/database/migrations/2017_08_03_115205_create_finance_invoice_table.php',
    'CreateMobileOptionsTable' => $contentDir . '/database/migrations/2017_08_03_115232_create_mobile_options_table.php',
    'CreateRegionCnTable' => $contentDir . '/database/migrations/2017_08_03_115254_create_region_cn_table.php',
    'AddUserTypeToConnectUserTable' => $contentDir . '/database/migrations/2017_08_03_132510_add_user_type_to_connect_user_table.php',
    'AddExpiredTimeToStoreFranchiseeTable' => $contentDir . '/database/migrations/2017_08_03_132605_add_expired_time_to_store_franchisee_table.php',
    'AddOrderTradeNoToPaymentRecordTable' => $contentDir . '/database/migrations/2017_08_03_132748_add_order_trade_no_to_payment_record_table.php',
    'AlterMsgidToSmsSendlistTable' => $contentDir . '/database/migrations/2017_08_03_184001_alter_msgid_to_sms_sendlist_table.php',
    'RecreatePushMessageTable' => $contentDir . '/database/migrations/2017_08_03_184333_recreate_push_message_table.php',
    'DropPushEventTable' => $contentDir . '/database/migrations/2017_08_03_190511_drop_push_event_table.php',
    'AlterCoverImageToArticleTable' => $contentDir . '/database/migrations/2017_08_10_140237_alter_cover_image_to_article_table.php',
    'CreateMarketActivityTable' => $contentDir . '/database/migrations/2017_09_01_135217_create_market_activity_table.php',
    'CreateMarketActivityLogTable' => $contentDir . '/database/migrations/2017_09_01_135233_create_market_activity_log_table.php',
    'CreateMarketActivityPrizeTable' => $contentDir . '/database/migrations/2017_09_01_135256_create_market_activity_prize_table.php',
    'CreateExpressTrackRecordTable' => $contentDir . '/database/migrations/2017_09_01_135329_create_express_track_record_table.php',
    'AlterAccessTokenSizeForConnectUserTable' => $contentDir . '/database/migrations/2017_09_01_145518_alter_access_token_size_for_connect_user_table.php',
    'AlterTypeSizeForWechatMenuTable' => $contentDir . '/database/migrations/2017_09_04_175915_alter_type_size_for_wechat_menu_table.php',
     
    
    // seeder
    'DatabaseSeeder' => $contentDir . '/database/seeds/DatabaseSeeder.php',
    'InitDatabaseSeeder' => $contentDir . '/database/seeds/InitDatabaseSeeder.php',
    'InitAdPositionTableSeeder' => $contentDir . '/database/seeds/InitAdPositionTableSeeder.php',
    'InitAdTableSeeder' => $contentDir . '/database/seeds/InitAdTableSeeder.php',
    'InitConnectTableSeeder' => $contentDir . '/database/seeds/InitConnectTableSeeder.php',
    'InitMailTemplatesTableSeeder' => $contentDir . '/database/seeds/InitMailTemplatesTableSeeder.php',
    'InitMobileScreenshotsTableSeeder' => $contentDir . '/database/seeds/InitMobileScreenshotsTableSeeder.php',
    'InitPaymentTableSeeder' => $contentDir . '/database/seeds/InitPaymentTableSeeder.php',
    'InitPlatformCommandTableSeeder' => $contentDir . '/database/seeds/InitPlatformCommandTableSeeder.php',
    'InitPlatformConfigTableSeeder' => $contentDir . '/database/seeds/InitPlatformConfigTableSeeder.php',
    'InitPlatformExtendTableSeeder' => $contentDir . '/database/seeds/InitPlatformExtendTableSeeder.php',
    'InitRegFieldsTableSeeder' => $contentDir . '/database/seeds/InitRegFieldsTableSeeder.php',
    'InitRegionTableSeeder' => $contentDir . '/database/seeds/InitRegionTableSeeder.php',
    'InitShippingTableSeeder' => $contentDir . '/database/seeds/InitShippingTableSeeder.php',
    'InitShopConfigTableSeeder' => $contentDir . '/database/seeds/InitShopConfigTableSeeder.php',
    'InitStoreCategoryTableSeeder' => $contentDir . '/database/seeds/InitStoreCategoryTableSeeder.php',
    'InitStorePercentTableSeeder' => $contentDir . '/database/seeds/InitStorePercentTableSeeder.php',
    'InitUserRankTableSeeder' => $contentDir . '/database/seeds/InitUserRankTableSeeder.php',
    'InitWechatMediaTableSeeder' => $contentDir . '/database/seeds/InitWechatMediaTableSeeder.php',
    'InitWechatReplyTableSeeder' => $contentDir . '/database/seeds/InitWechatReplyTableSeeder.php',
    
    
    'FixShopConfigTableSeeder' => $contentDir . '/database/seeds/FixShopConfigTableSeeder.php',
    
    'DemoDatabaseSeeder' => $contentDir . '/database/seeds/DemoDatabaseSeeder.php',
    'DemoStoreFranchiseeTableSeeder' => $contentDir . '/database/seeds/DemoStoreFranchiseeTableSeeder.php',
    'DemoMerchantsConfigTableSeeder' => $contentDir . '/database/seeds/DemoMerchantsConfigTableSeeder.php',
    'DemoStaffUserTableSeeder' => $contentDir . '/database/seeds/DemoStaffUserTableSeeder.php',
    'DemoCategoryTableSeeder' => $contentDir . '/database/seeds/DemoCategoryTableSeeder.php',
    'DemoMerchantsCategoryTableSeeder' => $contentDir . '/database/seeds/DemoMerchantsCategoryTableSeeder.php',
    'DemoGoodsTableSeeder' => $contentDir . '/database/seeds/DemoGoodsTableSeeder.php',
    'DemoGoodsGalleryTableSeeder' => $contentDir . '/database/seeds/DemoGoodsGalleryTableSeeder.php',
    'DemoGoodsAttrTableSeeder' => $contentDir . '/database/seeds/DemoGoodsAttrTableSeeder.php',
    'DemoGoodsCatTableSeeder' => $contentDir . '/database/seeds/DemoGoodsCatTableSeeder.php',
    'DemoAttributeTableSeeder' => $contentDir . '/database/seeds/DemoAttributeTableSeeder.php',
    'DemoTermMetaTableSeeder' => $contentDir . '/database/seeds/DemoTermMetaTableSeeder.php',
    'DemoArticleCatTableSeeder' => $contentDir . '/database/seeds/DemoArticleCatTableSeeder.php',
    'DemoArticleTableSeeder' => $contentDir . '/database/seeds/DemoArticleTableSeeder.php',
    'DemoArticleTableSeeder' => $contentDir . '/database/seeds/DemoArticleTableSeeder.php',
    'DemoGoodsArticleTableSeeder' => $contentDir . '/database/seeds/DemoGoodsArticleTableSeeder.php',
    
);

// end