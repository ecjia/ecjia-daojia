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
/**
 * 插入数据 `ecjia_shop_config` 商店配置
 */
use Royalcms\Component\Database\Seeder;

class InitShopConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RC_DB::table('shop_config')->where('code', 'shop_name')->update(['value' => 'ECJia到家']);
		RC_DB::table('shop_config')->where('code', 'shop_title')->update(['value' => 'ECJia到家 - 同城上门O2O解决方案']);
		RC_DB::table('shop_config')->where('code', 'shop_keywords')->update(['value' => 'ECJia']);
		RC_DB::table('shop_config')->where('code', 'shop_country')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'shop_province')->update(['value' => '25']);
		RC_DB::table('shop_config')->where('code', 'shop_city')->update(['value' => '321']);
		RC_DB::table('shop_config')->where('code', 'shop_address')->update(['value' => '上海市中山北路3553号伸大厦301']);
		RC_DB::table('shop_config')->where('code', 'service_email')->update(['value' => 'ecjia@ecjia.com ']);
		RC_DB::table('shop_config')->where('code', 'service_phone')->update(['value' => '4001-021-758']);
		RC_DB::table('shop_config')->where('code', 'shop_closed')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'shop_logo')->update(['value' => 'data/assets/ecjia-intro/shop_logo.gif']);
		RC_DB::table('shop_config')->where('code', 'licensed')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'user_notice')->update(['value' => '用户中心公告！']);
		RC_DB::table('shop_config')->where('code', 'shop_notice')->update(['value' => 'ecjia系统，追求极致体验']);
		RC_DB::table('shop_config')->where('code', 'shop_reg_closed')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'company_name')->update(['value' => '上海商创网络科技有限公司']);
		RC_DB::table('shop_config')->where('code', 'shop_weibo_url')->update(['value' => 'http://weibo.com/ECMBT']);
		RC_DB::table('shop_config')->where('code', 'shop_wechat_qrcode')->update(['value' => 'data/assets/ecjia-intro/shop_wechat_qrcode.jpg']);
		RC_DB::table('shop_config')->where('code', 'lang')->update(['value' => 'zh_CN']);
		RC_DB::table('shop_config')->where('code', 'icp_number')->update(['value' => '沪ICP备20170120号']);
		RC_DB::table('shop_config')->where('code', 'watermark_place')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'watermark_alpha')->update(['value' => '65']);
		RC_DB::table('shop_config')->where('code', 'use_storage')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'market_price_rate')->update(['value' => '1.2']);
		RC_DB::table('shop_config')->where('code', 'rewrite')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'integral_name')->update(['value' => '积分']);
		RC_DB::table('shop_config')->where('code', 'integral_scale')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'integral_percent')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'sn_prefix')->update(['value' => 'ECS']);
		RC_DB::table('shop_config')->where('code', 'comment_check')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'stats_code')->update(['value' => "<script>\r\nvar _hmt = _hmt || [];\r\n(function() {\r\n  var hm = document.createElement(\"script\");\r\n  hm.src = \"https://hm.baidu.com/hm.js?45572e750ba4de1ede0e776212b5f6cd\";\r\n  var s = document.getElementsByTagName(\"script\")[0]; \r\n  s.parentNode.insertBefore(hm, s);\r\n})();\r\n</script>"]);
		RC_DB::table('shop_config')->where('code', 'cache_time')->update(['value' => '3600']);
		RC_DB::table('shop_config')->where('code', 'register_points')->update(['value' => '20']);
		RC_DB::table('shop_config')->where('code', 'enable_gzip')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'top10_time')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'timezone')->update(['value' => '8']);
		RC_DB::table('shop_config')->where('code', 'upload_size_limit')->update(['value' => '64']);
		RC_DB::table('shop_config')->where('code', 'cron_method')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'comment_factor')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'enable_order_check')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'default_storage')->update(['value' => '1000']);
		RC_DB::table('shop_config')->where('code', 'bgcolor')->update(['value' => '#FFFFFF']);
		RC_DB::table('shop_config')->where('code', 'visit_stats')->update(['value' => 'on']);
		RC_DB::table('shop_config')->where('code', 'send_mail_on')->update(['value' => 'off']);
		RC_DB::table('shop_config')->where('code', 'auto_generate_gallery')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'retain_original_img')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'member_email_validate')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'message_board')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'certificate_id')->update(['value' => '1133133131']);
		RC_DB::table('shop_config')->where('code', 'token')->update(['value' => 'c49edab224d09de5d24e1bcdf9a18508322868ca44f62506af25f77b45af4e5b']);
		RC_DB::table('shop_config')->where('code', 'send_verify_email')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'date_format')->update(['value' => 'Y-m-d']);
		RC_DB::table('shop_config')->where('code', 'time_format')->update(['value' => 'Y-m-d H:i:s']);
		RC_DB::table('shop_config')->where('code', 'currency_format')->update(['value' => '￥%s']);
		RC_DB::table('shop_config')->where('code', 'thumb_width')->update(['value' => '240']);
		RC_DB::table('shop_config')->where('code', 'thumb_height')->update(['value' => '240']);
		RC_DB::table('shop_config')->where('code', 'image_width')->update(['value' => '1200']);
		RC_DB::table('shop_config')->where('code', 'image_height')->update(['value' => '1200']);
		RC_DB::table('shop_config')->where('code', 'top_number')->update(['value' => '5']);
		RC_DB::table('shop_config')->where('code', 'history_number')->update(['value' => '18']);
		RC_DB::table('shop_config')->where('code', 'comments_number')->update(['value' => '10']);
		RC_DB::table('shop_config')->where('code', 'bought_goods')->update(['value' => '15']);
		RC_DB::table('shop_config')->where('code', 'article_number')->update(['value' => '8']);
		RC_DB::table('shop_config')->where('code', 'goods_name_length')->update(['value' => '100']);
		RC_DB::table('shop_config')->where('code', 'price_format')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'page_size')->update(['value' => '20']);
		RC_DB::table('shop_config')->where('code', 'sort_order_type')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'sort_order_method')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'show_order_type')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'attr_related_number')->update(['value' => '5']);
		RC_DB::table('shop_config')->where('code', 'goods_gallery_number')->update(['value' => '5']);
		RC_DB::table('shop_config')->where('code', 'article_title_length')->update(['value' => '20']);
		RC_DB::table('shop_config')->where('code', 'name_of_region_1')->update(['value' => '国家']);
		RC_DB::table('shop_config')->where('code', 'name_of_region_2')->update(['value' => '省']);
		RC_DB::table('shop_config')->where('code', 'name_of_region_3')->update(['value' => '市']);
		RC_DB::table('shop_config')->where('code', 'name_of_region_4')->update(['value' => '区']);
		RC_DB::table('shop_config')->where('code', 'search_keywords')->update(['value' => '苹果,连衣裙,男鞋,笔记本,光碟']);
		RC_DB::table('shop_config')->where('code', 'related_goods_number')->update(['value' => '5']);
		RC_DB::table('shop_config')->where('code', 'help_open')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'article_page_size')->update(['value' => '20']);
		RC_DB::table('shop_config')->where('code', 'page_style')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'recommend_order')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'index_ad')->update(['value' => 'sys']);
		RC_DB::table('shop_config')->where('code', 'can_invoice')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'use_integral')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'use_bonus')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'use_surplus')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'use_how_oos')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'send_confirm_email')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'send_ship_email')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'send_cancel_email')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'send_invalid_email')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'order_pay_note')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'order_unpay_note')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'order_ship_note')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'order_receive_note')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'order_unship_note')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'order_return_note')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'order_invalid_note')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'order_cancel_note')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'invoice_content')->update(['value' => "水果蔬菜\r\n肉禽蛋奶\r\n冷热速食\r\n休闲食品"]);
		RC_DB::table('shop_config')->where('code', 'anonymous_buy')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'min_goods_amount')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'one_step_buy')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'invoice_type')->update(['value' => 'a:2:{s:4:"type";a:3:{i:0;s:12:"普通发票";i:1;s:15:"增值税发票";i:2;s:0:"";}s:4:"rate";a:3:{i:0;d:0;i:1;d:13;i:2;d:0;}}']);
		RC_DB::table('shop_config')->where('code', 'stock_dec_time')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'cart_confirm')->update(['value' => '3']);
		RC_DB::table('shop_config')->where('code', 'send_service_email')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'show_goods_in_cart')->update(['value' => '3']);
		RC_DB::table('shop_config')->where('code', 'show_attr_in_cart')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'smtp_host')->update(['value' => 'smtp.qq.com']);
		RC_DB::table('shop_config')->where('code', 'smtp_port')->update(['value' => '25']);
		RC_DB::table('shop_config')->where('code', 'mail_charset')->update(['value' => 'UTF8']);
		RC_DB::table('shop_config')->where('code', 'mail_service')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'smtp_ssl')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'integrate_code')->update(['value' => 'ecjia']);
		RC_DB::table('shop_config')->where('code', 'hash_code')->update(['value' => 'b76989c756aab2c64cf941eb31dec09c']);
		RC_DB::table('shop_config')->where('code', 'template')->update(['value' => 'ecjia-intro']);
		RC_DB::table('shop_config')->where('code', 'install_date')->update(['value' => '1379320265']);
		RC_DB::table('shop_config')->where('code', 'sms_user_name')->update(['value' => '请先填写']);
		RC_DB::table('shop_config')->where('code', 'sms_password')->update(['value' => 'xxxxxxxx']);
		RC_DB::table('shop_config')->where('code', 'affiliate')->update(['value' => 'a:5:{s:2:"on";i:1;s:6:"config";a:7:{s:6:"expire";d:24;s:11:"expire_unit";s:4:"hour";s:11:"separate_by";i:0;s:15:"level_point_all";s:2:"5%";s:15:"level_money_all";s:2:"1%";s:18:"level_register_all";i:2;s:17:"level_register_up";i:60;}s:13:"intvie_reward";a:3:{s:16:"intive_reward_by";s:6:"signup";s:18:"intive_reward_type";s:5:"bonus";s:19:"intive_reward_value";i:106;}s:14:"intviee_reward";a:3:{s:17:"intivee_reward_by";s:6:"signup";s:19:"intivee_reward_type";s:5:"bonus";s:20:"intivee_reward_value";i:106;}s:4:"item";a:4:{i:0;a:2:{s:11:"level_point";s:3:"60%";s:11:"level_money";s:3:"60%";}i:1;a:2:{s:11:"level_point";s:3:"30%";s:11:"level_money";s:3:"30%";}i:2;a:2:{s:11:"level_point";s:2:"7%";s:11:"level_money";s:2:"7%";}i:3;a:2:{s:11:"level_point";s:2:"3%";s:11:"level_money";s:2:"3%";}}}']);
		RC_DB::table('shop_config')->where('code', 'captcha')->update(['value' => '45']);
		RC_DB::table('shop_config')->where('code', 'captcha_width')->update(['value' => '100']);
		RC_DB::table('shop_config')->where('code', 'captcha_height')->update(['value' => '28']);
		RC_DB::table('shop_config')->where('code', 'sitemap')->update(['value' => 'a:6:{s:19:"homepage_changefreq";s:6:"hourly";s:17:"homepage_priority";s:3:"0.9";s:19:"category_changefreq";s:6:"hourly";s:17:"category_priority";s:3:"0.8";s:18:"content_changefreq";s:6:"weekly";s:16:"content_priority";s:3:"0.7";}']);
		RC_DB::table('shop_config')->where('code', 'flash_theme')->update(['value' => 'dynfocus']);
		RC_DB::table('shop_config')->where('code', 'show_goodssn')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'show_brand')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'show_goodsweight')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'show_goodsnumber')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'show_addtime')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'goodsattr_style')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'show_marketprice')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'sms_shop_mobile')->update(['value' => '请先填写']);
		RC_DB::table('shop_config')->where('code', 'sms_order_placed')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'sms_order_payed')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'sms_order_shipped')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'wap_config')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'wap_logo')->update(['value' => 'data/assets/ecjia-intro/wap_logo.png']);
		RC_DB::table('shop_config')->where('code', 'message_check')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'review_goods')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'store_identity_certification')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'sms_signin')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'sms_send')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'addon_active_applications')->update(['value' => 'a:13:{i:0;s:15:"ecjia.affiliate";i:1;s:13:"ecjia.connect";i:2;s:15:"ecjia.logviewer";i:3;s:12:"ecjia.mobile";i:4;s:15:"ecjia.mobilebuy";i:5;s:14:"ecjia.platform";i:6;s:10:"ecjia.push";i:7;s:12:"ecjia.seller";i:8;s:9:"ecjia.sms";i:9;s:11:"ecjia.topic";i:10;s:11:"ecjia.touch";i:11;s:12:"ecjia.wechat";i:12;s:19:"ecmoban.achievement";}']);
		RC_DB::table('shop_config')->where('code', 'addon_system_plugins')->update(['value' => 'a:2:{s:7:"ueditor";s:19:"ueditor/ueditor.php";s:10:"calculator";s:25:"calculator/calculator.php";}']);
		RC_DB::table('shop_config')->where('code', 'addon_active_plugins')->update(['value' => 'a:33:{i:0;s:25:"calculator/calculator.php";i:1;s:37:"captcha_royalcms/captcha_royalcms.php";i:2;s:37:"cron_auto_manage/cron_auto_manage.php";i:3;s:31:"cron_bill_day/cron_bill_day.php";i:4;s:35:"cron_bill_month/cron_bill_month.php";i:5;s:25:"cron_ipdel/cron_ipdel.php";i:6;s:41:"cron_order_receive/cron_order_receive.php";i:7;s:29:"cron_testlog/cron_testlog.php";i:8;s:29:"cron_unpayed/cron_unpayed.php";i:9;s:25:"mp_checkin/mp_checkin.php";i:10;s:17:"mp_dzp/mp_dzp.php";i:11;s:17:"mp_ggk/mp_ggk.php";i:12;s:21:"mp_goods/mp_goods.php";i:13;s:19:"mp_jfcx/mp_jfcx.php";i:14;s:19:"mp_kefu/mp_kefu.php";i:15;s:23:"mp_orders/mp_orders.php";i:16;s:27:"mp_userbind/mp_userbind.php";i:18;s:17:"mp_zjd/mp_zjd.php";i:19;s:25:"pay_alipay/pay_alipay.php";i:20;s:27:"pay_balance/pay_balance.php";i:21;s:21:"pay_cash/pay_cash.php";i:22;s:19:"pay_cod/pay_cod.php";i:24;s:21:"ship_cac/ship_cac.php";i:25;s:21:"ship_ems/ship_ems.php";i:26;s:23:"ship_flat/ship_flat.php";i:27;s:21:"ship_fpd/ship_fpd.php";i:28;s:37:"ship_o2o_express/ship_o2o_express.php";i:29;s:35:"ship_sf_express/ship_sf_express.php";i:30;s:37:"ship_sto_express/ship_sto_express.php";i:31;s:21:"ship_yto/ship_yto.php";i:32;s:21:"ship_zto/ship_zto.php";i:33;s:17:"sns_qq/sns_qq.php";i:34;s:19:"ueditor/ueditor.php";}']);
		RC_DB::table('shop_config')->where('code', 'ecjia_db_version')->update(['value' => '5']);
		RC_DB::table('shop_config')->where('code', 'addon_mobile_payment_plugins')->update(['value' => 'a:4:{s:11:"pay_balance";s:27:"pay_balance/pay_balance.php";s:10:"pay_alipay";s:25:"pay_alipay/pay_alipay.php";s:7:"pay_cod";s:19:"pay_cod/pay_cod.php";s:8:"pay_cash";s:21:"pay_cash/pay_cash.php";}']);
		RC_DB::table('shop_config')->where('code', 'auth_key')->update(['value' => '888888']);
		RC_DB::table('shop_config')->where('code', 'addon_shipping_plugins')->update(['value' => 'a:9:{s:8:"ship_ems";s:21:"ship_ems/ship_ems.php";s:8:"ship_yto";s:21:"ship_yto/ship_yto.php";s:8:"ship_cac";s:21:"ship_cac/ship_cac.php";s:9:"ship_flat";s:23:"ship_flat/ship_flat.php";s:8:"ship_zto";s:21:"ship_zto/ship_zto.php";s:8:"ship_fpd";s:21:"ship_fpd/ship_fpd.php";s:16:"ship_o2o_express";s:37:"ship_o2o_express/ship_o2o_express.php";s:15:"ship_sf_express";s:35:"ship_sf_express/ship_sf_express.php";s:16:"ship_sto_express";s:37:"ship_sto_express/ship_sto_express.php";}']);
		RC_DB::table('shop_config')->where('code', 'cycleimage_data')->update(['value' => 'a:5:{i:0;a:4:{s:3:"src";s:27:"data/afficheimg/banner1.png";s:3:"url";s:26:"https://ecjia.com/o2o.html";s:4:"text";s:0:"";s:4:"sort";i:1;}i:1;a:4:{s:3:"src";s:27:"data/afficheimg/banner2.png";s:3:"url";s:17:"https://ecjia.com";s:4:"text";s:0:"";s:4:"sort";i:2;}i:2;a:4:{s:3:"src";s:27:"data/afficheimg/banner3.png";s:3:"url";s:65:"https://ecjia.com/wiki/%E5%B8%AE%E5%8A%A9:ECJia%E5%88%B0%E5%AE%B6";s:4:"text";s:0:"";s:4:"sort";i:3;}i:3;a:4:{s:3:"src";s:27:"data/afficheimg/banner4.png";s:3:"url";s:23:"http://www.ecmoban.com/";s:4:"text";s:0:"";s:4:"sort";i:4;}i:4;a:4:{s:3:"src";s:27:"data/afficheimg/banner5.png";s:3:"url";s:22:"http://www.dscmall.cn/";s:4:"text";s:0:"";s:4:"sort";i:5;}}']);
		RC_DB::table('shop_config')->where('code', 'sms_user_signin')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'captcha_style')->update(['value' => 'captcha_royalcms']);
		RC_DB::table('shop_config')->where('code', 'addon_captcha_plugins')->update(['value' => 'a:1:{s:16:"captcha_royalcms";s:37:"captcha_royalcms/captcha_royalcms.php";}']);
		RC_DB::table('shop_config')->where('code', 'mobile_discover_data')->update(['value' => 'a:13:{i:4;a:5:{s:3:"src";s:37:"data/discover/1477876567618286130.png";s:3:"url";s:26:"https://ecjia.com/o2o.html";s:4:"text";s:15:"EC+到家简介";s:4:"sort";i:0;s:7:"display";i:1;}i:5;a:5:{s:3:"src";s:37:"data/discover/1478110259511162569.png";s:3:"url";s:44:"https://dn-ecmoban.qbox.me/ECJIAo2o-rwxf.mp4";s:4:"text";s:18:"到家视频介绍";s:4:"sort";s:1:"1";s:7:"display";i:0;}i:6;a:5:{s:3:"src";s:37:"data/discover/1477877330512416792.png";s:3:"url";s:35:"https://ecjia.com/wiki/常见问题";s:4:"text";s:12:"常见问题";s:4:"sort";s:1:"2";s:7:"display";i:1;}i:7;a:5:{s:3:"src";s:37:"data/discover/1477876646108552339.png";s:3:"url";s:40:"https://ecjia.com/readme/disclaimer.html";s:4:"text";s:12:"免责声明";s:4:"sort";i:3;s:7:"display";i:0;}i:8;a:5:{s:3:"src";s:37:"data/discover/1459462286529291580.png";s:3:"url";s:40:"https://ecjia.com/readme/disclaimer.html";s:4:"text";s:12:"会员专享";s:4:"sort";s:1:"4";s:7:"display";i:0;}i:9;a:5:{s:3:"src";s:37:"data/discover/1461121219027514959.png";s:3:"url";s:38:"ecjiaopen://app?open_type=user_address";s:4:"text";s:6:"地址";s:4:"sort";i:4;s:7:"display";i:1;}i:10;a:5:{s:3:"src";s:37:"data/discover/1461120899663962607.png";s:3:"url";s:37:"ecjiaopen://app?open_type=orders_list";s:4:"text";s:6:"订单";s:4:"sort";s:1:"4";s:7:"display";i:0;}i:11;a:5:{s:3:"src";s:37:"data/discover/1459462356158907938.png";s:3:"url";s:17:"https://ecjia.com";s:4:"text";s:9:"ec+官网";s:4:"sort";s:1:"5";s:7:"display";i:1;}i:12;a:5:{s:3:"src";s:37:"data/discover/1459462516430706755.png";s:3:"url";s:32:"ecjiaopen://app?open_type=qrcode";s:4:"text";s:15:"二维码扫描";s:4:"sort";s:1:"9";s:7:"display";i:0;}i:13;a:5:{s:3:"src";s:37:"data/discover/1484012474751128146.png";s:3:"url";s:41:"https://ecjia.com/wiki/帮助:ECJia到家";s:4:"text";s:18:"ECJia到家帮助 ";s:4:"sort";s:2:"11";s:7:"display";i:1;}i:14;a:5:{s:3:"src";s:37:"data/discover/1459462573769329651.png";s:3:"url";s:34:"ecjiaopen://app?open_type=groupbuy";s:4:"text";s:12:"意见反馈";s:4:"sort";s:2:"11";s:7:"display";i:0;}i:15;a:5:{s:3:"src";s:37:"data/discover/1459462586681562881.png";s:3:"url";s:34:"ecjiaopen://app?open_type=feedback";s:4:"text";s:6:"咨询";s:4:"sort";s:2:"12";s:7:"display";i:0;}i:16;a:5:{s:3:"src";s:37:"data/discover/1459462602180937166.png";s:3:"url";s:30:"ecjiaopen://app?open_type=help";s:4:"text";s:12:"帮助中心";s:4:"sort";s:2:"13";s:7:"display";i:1;}}']);
		RC_DB::table('shop_config')->where('code', 'mobile_shortcut_data')->update(['value' => 'a:10:{i:0;a:5:{s:3:"src";s:37:"data/shortcut/1478221589448573017.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1032";s:4:"text";s:12:"水果蔬菜";s:4:"sort";s:1:"0";s:7:"display";i:1;}i:1;a:5:{s:3:"src";s:37:"data/shortcut/1477700183823048386.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1047";s:4:"text";s:12:"肉禽蛋奶";s:4:"sort";s:1:"1";s:7:"display";i:1;}i:2;a:5:{s:3:"src";s:37:"data/shortcut/1477700190620505129.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1064";s:4:"text";s:12:"冷热速食";s:4:"sort";s:1:"2";s:7:"display";i:1;}i:3;a:5:{s:3:"src";s:37:"data/shortcut/1477700197732149350.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1078";s:4:"text";s:12:"休闲食品";s:4:"sort";s:1:"3";s:7:"display";i:1;}i:4;a:5:{s:3:"src";s:37:"data/shortcut/1477700204215089751.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1092";s:4:"text";s:12:"酒水饮料";s:4:"sort";s:1:"5";s:7:"display";i:1;}i:5;a:5:{s:3:"src";s:37:"data/shortcut/1477700210378659761.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1114";s:4:"text";s:12:"粮油调味";s:4:"sort";s:1:"6";s:7:"display";i:1;}i:6;a:5:{s:3:"src";s:37:"data/shortcut/1477700217181679112.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1135";s:4:"text";s:12:"清洁日化";s:4:"sort";s:1:"7";s:7:"display";i:1;}i:7;a:5:{s:3:"src";s:37:"data/shortcut/1477700223890846471.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1167";s:4:"text";s:12:"家居用品";s:4:"sort";s:1:"8";s:7:"display";i:1;}i:8;a:5:{s:3:"src";s:37:"data/shortcut/1477700537011530251.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1186";s:4:"text";s:12:"鲜花蛋糕";s:4:"sort";s:1:"9";s:7:"display";i:1;}i:9;a:5:{s:3:"src";s:37:"data/shortcut/1477700617184169592.png";s:3:"url";s:46:"ecjiaopen://app?open_type=seller&category_id=6";s:4:"text";s:12:"上门服务";s:4:"sort";s:2:"10";s:7:"display";i:1;}}']);
		RC_DB::table('shop_config')->where('code', 'mobile_launch_adsense')->update(['value' => '102']);
		RC_DB::table('shop_config')->where('code', 'mobile_home_adsense1')->update(['value' => '89']);
		RC_DB::table('shop_config')->where('code', 'mobile_home_adsense2')->update(['value' => 'mobile_home_adsense2']);
		RC_DB::table('shop_config')->where('code', 'navigator_data')->update(['value' => 'a:4:{i:0;a:2:{s:4:"type";s:3:"top";s:4:"name";s:6:"顶部";}i:1;a:2:{s:4:"type";s:6:"middle";s:4:"name";s:6:"中间";}i:2;a:2:{s:4:"type";s:6:"bottom";s:4:"name";s:6:"底部";}i:3;a:2:{s:4:"type";s:5:"touch";s:4:"name";s:10:"ECJiaTouch";}}']);
		RC_DB::table('shop_config')->where('code', 'mobile_recommend_city')->update(['value' => '52,76,77,180,220,311,321,322,343,383,394,3401']);
		RC_DB::table('shop_config')->where('code', 'mobile_cycleimage_data')->update(['value' => "a:5:{i:0;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695891057975664.png\";s:3:\"url\";s:51:\"ecjiaopen://app?open_type=goods_detail&goods_id=507\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"1\";s:7:\"display\";i:0;}i:1;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695897009489967.png\";s:3:\"url\";s:51:\"ecjiaopen://app?open_type=goods_list&category_id=11\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"2\";s:7:\"display\";i:0;}i:2;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695966324425303.png\";s:3:\"url\";s:51:\"ecjiaopen://app?open_type=goods_list&category_id=12\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"3\";s:7:\"display\";i:0;}i:3;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695980936007359.png\";s:3:\"url\";s:52:\"ecjiaopen://app?open_type=goods_list&category_id=143\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"3\";s:7:\"display\";i:0;}i:4;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695988307349360.png\";s:3:\"url\";s:50:\"ecjiaopen://app?open_type=goods_list&category_id=5\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"5\";s:7:\"display\";i:0;}}"]);
		RC_DB::table('shop_config')->where('code', 'sms_receipt_verification')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'last_check_upgrade_time')->update(['value' => 'last_check_upgrade_time']);
		RC_DB::table('shop_config')->where('code', 'touch_template')->update(['value' => 'h5']);
		RC_DB::table('shop_config')->where('code', 'mobile_pc_url')->update(['value' => 'https://cityo2o.ecjia.com']);
		RC_DB::table('shop_config')->where('code', 'mobile_touch_url')->update(['value' => 'https://cityo2o.ecjia.com/sites/m/']);
		RC_DB::table('shop_config')->where('code', 'mobile_iphone_download')->update(['value' => 'https://itunes.apple.com/cn/app/ec+dao-jia/id1118895347?mt=8']);
		RC_DB::table('shop_config')->where('code', 'mobile_android_download')->update(['value' => 'http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.cityo2o']);
		RC_DB::table('shop_config')->where('code', 'mobile_app_icon')->update(['value' => 'data/assets/mobile_app_icon.png']);
		RC_DB::table('shop_config')->where('code', 'mobile_app_description')->update(['value' => 'ECJia到家是上海商创网络科技有限公司推出的一款多商户原生APP，基于LBS定位功能让用户通过查找附近店铺 在手机APP下单，支付，评价，并由商家提供上门服务的一套新型服务模式的电商系统。']);
		RC_DB::table('shop_config')->where('code', 'mobile_pad_login_fgcolor')->update(['value' => '#ffffff']);
		RC_DB::table('shop_config')->where('code', 'mobile_pad_login_bgcolor')->update(['value' => '#000000']);
		RC_DB::table('shop_config')->where('code', 'mobile_pad_login_bgimage')->update(['value' => 'data/assets/mobile_pad_login_bgimage.png']);
		RC_DB::table('shop_config')->where('code', 'mobile_phone_login_fgcolor')->update(['value' => '#04b24f']);
		RC_DB::table('shop_config')->where('code', 'mobile_phone_login_bgcolor')->update(['value' => '#afafaf']);
		RC_DB::table('shop_config')->where('code', 'mobile_phone_login_bgimage')->update(['value' => 'data/assets/mobile_phone_login_bgimage.png']);
		RC_DB::table('shop_config')->where('code', 'merchant_admin_cpname')->update(['value' => 'ECJia商家后台管理']);
		RC_DB::table('shop_config')->where('code', 'mobile_seller_home_adsense')->update(['value' => '94']);
		RC_DB::table('shop_config')->where('code', 'addon_platform_plugins')->update(['value' => 'a:9:{s:7:"mp_jfcx";s:19:"mp_jfcx/mp_jfcx.php";s:9:"mp_orders";s:23:"mp_orders/mp_orders.php";s:6:"mp_ggk";s:17:"mp_ggk/mp_ggk.php";s:10:"mp_checkin";s:25:"mp_checkin/mp_checkin.php";s:6:"mp_dzp";s:17:"mp_dzp/mp_dzp.php";s:6:"mp_zjd";s:17:"mp_zjd/mp_zjd.php";s:7:"mp_kefu";s:19:"mp_kefu/mp_kefu.php";s:11:"mp_userbind";s:27:"mp_userbind/mp_userbind.php";s:8:"mp_goods";s:21:"mp_goods/mp_goods.php";}']);
		RC_DB::table('shop_config')->where('code', 'mobile_shopkeeper_urlscheme')->update(['value' => 'com.ecjia.cityo2o://']);
		RC_DB::table('shop_config')->where('code', 'mobile_cycleimage_phone_data')->update(['value' => 'a:5:{i:0;a:5:{s:3:"src";s:39:"data/afficheimg/1471820010293706033.png";s:3:"url";s:53:"ecjiaopen://app?open_type=goods_list&category_id=1032";s:4:"text";s:0:"";s:4:"sort";s:1:"1";s:7:"display";i:0;}i:1;a:5:{s:3:"src";s:39:"data/afficheimg/1470680042094971654.png";s:3:"url";s:51:"ecjiaopen://app?open_type=goods_detail&goods_id=693";s:4:"text";s:0:"";s:4:"sort";s:1:"2";s:7:"display";i:0;}i:2;a:5:{s:3:"src";s:39:"data/afficheimg/1470679954374104363.png";s:3:"url";s:51:"ecjiaopen://app?open_type=goods_list&category_id=12";s:4:"text";s:0:"";s:4:"sort";s:1:"3";s:7:"display";i:0;}i:3;a:5:{s:3:"src";s:39:"data/afficheimg/1470680474723510488.png";s:3:"url";s:52:"ecjiaopen://app?open_type=goods_list&category_id=143";s:4:"text";s:0:"";s:4:"sort";s:1:"4";s:7:"display";i:0;}i:4;a:5:{s:3:"src";s:39:"data/afficheimg/1470680492405164776.png";s:3:"url";s:50:"ecjiaopen://app?open_type=goods_list&category_id=5";s:4:"text";s:0:"";s:4:"sort";s:1:"5";s:7:"display";i:0;}}']);
		RC_DB::table('shop_config')->where('code', 'app_name')->update(['value' => 'EC+到家']);
		RC_DB::table('shop_config')->where('code', 'app_push_development')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'push_user_signin')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'push_order_shipped')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'push_order_payed')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'push_order_placed')->update(['value' => '0']);
		RC_DB::table('shop_config')->where('code', 'mobile_home_adsense_group')->update(['value' => '98,97,99,100,101']);
		RC_DB::table('shop_config')->where('code', 'mobile_iphone_qrcode')->update(['value' => 'data/assets/qrcode.png']);
		RC_DB::table('shop_config')->where('code', 'mobile_android_qrcode')->update(['value' => 'data/assets/qrcode.png']);
		RC_DB::table('shop_config')->where('code', 'invite_template')->update(['value' => '你的好友（{$user_name}）向您推荐了一款购物应用【{$shop_name}】，优惠活动多多，新人注册还有红包奖励，赶紧下载体验吧！']);
		RC_DB::table('shop_config')->where('code', 'invite_explain')->update(['value' => "1、通过推广页面把属于自己的二维码通过第三方平台分享给新人好友；\r\n2、新人好友通过您的邀请，打开链接，在活动页输入自己的手机号，并通过指定渠道下载客户端完成注册，即可获得奖励；\r\n3、每邀请一位新人好友并完成注册都可获得相应奖励；\r\n4、奖励一经领取后，不可删除，不可提现，不可转赠；\r\n5、新用户领取的奖励查看方式：【App-我的－我的钱包】查看，也可通过【我的推广—奖励明细】查看；\r\n6、如有任何的疑问请咨询官网客服人员；"]);
		RC_DB::table('shop_config')->where('code', 'bonus_readme_url')->update(['value' => '/index.php?m=article&c=mobile&a=info&id=-1']);
		RC_DB::table('shop_config')->where('code', 'mobile_app_name')->update(['value' => 'EC+ 到家']);
		RC_DB::table('shop_config')->where('code', 'mobile_app_version')->update(['value' => '1.3.0']);
		RC_DB::table('shop_config')->where('code', 'mobile_app_preview')->update(['value' => 'a:2:{i:0;s:35:"data/assets/mobile_app_preview1.jpg";i:1;s:35:"data/assets/mobile_app_preview2.jpg";}']);
		RC_DB::table('shop_config')->where('code', 'mobile_app_video')->update(['value' => 'https://dn-ecmoban.qbox.me/ECJIAo2o-rwxf.mp4']);
		RC_DB::table('shop_config')->where('code', 'mobile_shop_urlscheme')->update(['value' => 'com.ecjia.cityo2o://']);
		RC_DB::table('shop_config')->where('code', 'addon_cron_plugins')->update(['value' => 'a:7:{s:10:"cron_ipdel";s:25:"cron_ipdel/cron_ipdel.php";s:16:"cron_auto_manage";s:37:"cron_auto_manage/cron_auto_manage.php";s:12:"cron_testlog";s:29:"cron_testlog/cron_testlog.php";s:18:"cron_order_receive";s:41:"cron_order_receive/cron_order_receive.php";s:12:"cron_unpayed";s:29:"cron_unpayed/cron_unpayed.php";s:13:"cron_bill_day";s:31:"cron_bill_day/cron_bill_day.php";s:15:"cron_bill_month";s:35:"cron_bill_month/cron_bill_month.php";}']);
		RC_DB::table('shop_config')->where('code', 'mobile_share_link')->update(['value' => 'https://cityo2o.ecjia.com/sites/api/index.php?m=affiliate&c=mobile&a=init&invite_code={$invite_code}']);
		RC_DB::table('shop_config')->where('code', 'addon_connect_plugins')->update(['value' => 'a:1:{s:6:"sns_qq";s:17:"sns_qq/sns_qq.php";}']);
		RC_DB::table('shop_config')->where('code', 'mobile_touch_qrcode')->update(['value' => 'data/assets/mobile_touch_qrcode.png']);
		RC_DB::table('shop_config')->where('code', 'map_qq_key')->update(['value' => 'HVNBZ-HHR3P-HVBDP-LID55-D2YM3-2AF2W']);
		RC_DB::table('shop_config')->where('code', 'map_qq_referer')->update(['value' => 'ecjiaapp']);
		RC_DB::table('shop_config')->where('code', 'wap_app_download_show')->update(['value' => '1']);
		RC_DB::table('shop_config')->where('code', 'wap_app_download_img')->update(['value' => 'data/assets/ecjia-intro/wap_app_download_img.png']);
		RC_DB::table('shop_config')->where('code', 'mobile_location_range')->update(['value' => '3']);
        
    }
}