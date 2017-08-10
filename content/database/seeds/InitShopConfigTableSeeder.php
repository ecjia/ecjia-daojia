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
        $this->shop_info_group_1();
        
        $this->basic_group_2();
        
        $this->display_group_3();
        
        $this->shopping_flow_group_4();
        
        $this->smtp_group_5();
        
        $this->hidden_group_6();
        
        $this->goods_group_7();
        
        $this->sms_group_8();
        
        $this->wap_group_9();
        
        $this->mobile_group_10();
        
        $this->addon_group_11();
    }
    
    protected function add_config($group, array $data)
    {
        collect($data)->each(function($item) use ($group) {
        	ecjia_config::add($group, $item['code'], $item['value'], $item['options']);
        });
    }
    
    protected function shop_info_group_1()
    {
        $group = 'shop_info';
        
        $data = [
        	['code' => 'shop_name', 'value' => 'ECJia到家', 'options' => ['type' => 'text']],
        	['code' => 'shop_title', 'value' => 'ECJia到家 - 同城上门O2O解决方案', 'options' => ['type' => 'text']],
        	['code' => 'shop_desc', 'value' => '', 'options' => ['type' => 'text']],
        	['code' => 'shop_keywords', 'value' => 'ECJia', 'options' => ['type' => 'text']],
        	['code' => 'shop_country', 'value' => '1', 'options' => ['type' => 'manual']],
        	['code' => 'shop_province', 'value' => '25', 'options' => ['type' => 'manual']],
        	['code' => 'shop_city', 'value' => '321', 'options' => ['type' => 'manual']],
        	['code' => 'shop_address', 'value' => '上海市中山北路3553号伸大厦301', 'options' => ['type' => 'text']],
        	['code' => 'qq', 'value' => '', 'options' => ['type' => 'text']],
        	['code' => 'ww', 'value' => '', 'options' => ['type' => 'text']],
        	['code' => 'skype', 'value' => '', 'options' => ['type' => 'text']],
        	['code' => 'ym', 'value' => '', 'options' => ['type' => 'text']],
        	['code' => 'msn', 'value' => '', 'options' => ['type' => 'text']],
        	['code' => 'service_email', 'value' => 'ecjia@ecjia.com ', 'options' => ['type' => 'text']],
        	['code' => 'service_phone', 'value' => '4001-021-758', 'options' => ['type' => 'text']],
        	['code' => 'shop_closed', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        	['code' => 'close_comment', 'value' => '', 'options' => ['type' => 'hidden']],
        	['code' => 'shop_logo', 'value' => 'data/assets/ecjia-intro/shop_logo.gif', 'options' => ['type' => 'file', 'store_dir' => 'content/themes/{$template}/images/']],
        	['code' => 'licensed', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        	['code' => 'user_notice', 'value' => '用户中心公告！', 'options' => ['type' => 'textarea']],
        	['code' => 'shop_notice', 'value' => 'ecjia系统，追求极致体验', 'options' => ['type' => 'textarea']],
        	['code' => 'shop_reg_closed', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
        	['code' => 'company_name', 'value' => '上海商创网络科技有限公司', 'options' => ['type' => 'text']],
        	['code' => 'shop_weibo_url', 'value' => 'http://weibo.com/ECMBT', 'options' => ['type' => 'text']],
        	['code' => 'shop_wechat_qrcode', 'value' => 'data/assets/ecjia-intro/shop_wechat_qrcode.jpg', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
        ];
        
        $this->add_config($group, $data);
    }
    
    
    protected function basic_group_2()
    {
        $group = 'basic';
        
        $data = [
            ['code' => 'lang', 'value' => 'zh_CN', 'options' => ['type' => 'manual']],
            ['code' => 'icp_number', 'value' => '沪ICP备20170120号', 'options' => ['type' => 'text']],
            ['code' => 'icp_file', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/cert/']],
            ['code' => 'watermark', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'watermark_place', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4,5']],
            ['code' => 'watermark_alpha', 'value' => '65', 'options' => ['type' => 'text']],
            ['code' => 'use_storage', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'market_price_rate', 'value' => '1.2', 'options' => ['type' => 'text']],
            ['code' => 'rewrite', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1,2']],
            ['code' => 'integral_name', 'value' => '积分', 'options' => ['type' => 'text']],
            ['code' => 'integral_scale', 'value' => '1', 'options' => ['type' => 'text']],
            ['code' => 'integral_percent', 'value' => '1', 'options' => ['type' => 'text']],
            ['code' => 'sn_prefix', 'value' => 'ECS', 'options' => ['type' => 'text']],
            ['code' => 'comment_check', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'no_picture', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'stats_code', 'value' => "<script>\r\nvar _hmt = _hmt || [];\r\n(function() {\r\n  var hm = document.createElement(\"script\");\r\n  hm.src = \"https://hm.baidu.com/hm.js?45572e750ba4de1ede0e776212b5f6cd\";\r\n  var s = document.getElementsByTagName(\"script\")[0]; \r\n  s.parentNode.insertBefore(hm, s);\r\n})();\r\n</script>", 'options' => ['type' => 'textarea']],
            ['code' => 'cache_time', 'value' => '3600', 'options' => ['type' => 'text']],
            ['code' => 'register_points', 'value' => '20', 'options' => ['type' => 'text']],
            ['code' => 'enable_gzip', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'top10_time', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4']],
            ['code' => 'timezone', 'value' => '8', 'options' => ['type' => 'options', 'store_range' => '-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,8,9,9.5,10,11,12']],
            ['code' => 'upload_size_limit', 'value' => '64', 'options' => ['type' => 'options', 'store_range' => '-1,0,64,128,256,512,1024,2048,4096']],
            ['code' => 'cron_method', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'comment_factor', 'value' => '0', 'options' => ['type' => 'hidden', 'store_range' => '0,1,2,3']],
            ['code' => 'enable_order_check', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'default_storage', 'value' => '1000', 'options' => ['type' => 'text']],
            ['code' => 'bgcolor', 'value' => '#FFFFFF', 'options' => ['type' => 'text']],
            ['code' => 'visit_stats', 'value' => 'on', 'options' => ['type' => 'select', 'store_range' => 'on,off']],
            ['code' => 'send_mail_on', 'value' => 'off', 'options' => ['type' => 'select', 'store_range' => 'on,off']],
            ['code' => 'auto_generate_gallery', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'retain_original_img', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'member_email_validate', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'message_board', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'certificate_id', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'token', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'certi', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'send_verify_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'ent_id', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'ent_ac', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'ent_sign', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'ent_email', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'message_check', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'review_goods', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'store_identity_certification', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'comment_award_open', 'value' => '0', 'options' => ['type' => 'hidden']],
            ['code' => 'comment_award', 'value' => '0', 'options' => ['type' => 'hidden']],
            ['code' => 'comment_award_rules', 'value' => '', 'options' => ['type' => 'hidden']],
        ];
        
        $this->add_config($group, $data);
    }
    
    
    protected function display_group_3()
    {
        $group = 'display';
        
        $data = [
        	['code' => 'date_format', 'value' => 'Y-m-d', 'options' => ['type' => 'hidden']],
        	['code' => 'time_format', 'value' => 'Y-m-d H:i:s', 'options' => ['type' => 'text']],
        	['code' => 'currency_format', 'value' => '￥%s', 'options' => ['type' => 'text']],
        	['code' => 'thumb_width', 'value' => '240', 'options' => ['type' => 'text']],
        	['code' => 'thumb_height', 'value' => '240', 'options' => ['type' => 'text']],
        	['code' => 'image_width', 'value' => '1200', 'options' => ['type' => 'text']],
        	['code' => 'image_height', 'value' => '1200', 'options' => ['type' => 'text']],
        	['code' => 'history_number', 'value' => '18', 'options' => ['type' => 'text']],
        	['code' => 'comments_number', 'value' => '10', 'options' => ['type' => 'text']],
        	['code' => 'bought_goods', 'value' => '15', 'options' => ['type' => 'text']],
        	['code' => 'article_number', 'value' => '8', 'options' => ['type' => 'text']],
        	['code' => 'goods_name_length', 'value' => '100', 'options' => ['type' => 'text']],
        	['code' => 'price_format', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4,5']],
        	['code' => 'page_size', 'value' => '20', 'options' => ['type' => 'text']],
        	['code' => 'sort_order_type', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1,2']],
        	['code' => 'sort_order_method', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        	['code' => 'show_order_type', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1,2']],
        	['code' => 'attr_related_number', 'value' => '5', 'options' => ['type' => 'text']],
        	['code' => 'goods_gallery_number', 'value' => '5', 'options' => ['type' => 'text']],
        	['code' => 'article_title_length', 'value' => '20', 'options' => ['type' => 'text']],
        	['code' => 'name_of_region_1', 'value' => '国家', 'options' => ['type' => 'text']],
        	['code' => 'name_of_region_2', 'value' => '省', 'options' => ['type' => 'text']],
        	['code' => 'name_of_region_3', 'value' => '市', 'options' => ['type' => 'text']],
        	['code' => 'name_of_region_4', 'value' => '区', 'options' => ['type' => 'text']],
        	['code' => 'search_keywords', 'value' => '苹果,连衣裙,男鞋,笔记本,光碟', 'options' => ['type' => 'text']],
        	['code' => 'related_goods_number', 'value' => '5', 'options' => ['type' => 'text']],
        	['code' => 'help_open', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        	['code' => 'article_page_size', 'value' => '20', 'options' => ['type' => 'text']],
        	['code' => 'page_style', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        	['code' => 'recommend_order', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        	['code' => 'index_ad', 'value' => 'sys', 'options' => ['type' => 'hidden']],
        ];
        
        $this->add_config($group, $data);
    }
    
    
    protected function shopping_flow_group_4()
    {
        $group = 'shopping_flow';
        
        $data = [
            ['code' => 'can_invoice', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'use_integral', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'use_bonus', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'use_surplus', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'use_how_oos', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'send_confirm_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'send_ship_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'send_cancel_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'send_invalid_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_pay_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_unpay_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_ship_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_receive_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_unship_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_return_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_invalid_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_cancel_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'invoice_content', 'value' => "水果蔬菜\r\n肉禽蛋奶\r\n冷热速食\r\n休闲食品", 'options' => ['type' => 'textarea']],
            ['code' => 'anonymous_buy', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'min_goods_amount', 'value' => '0', 'options' => ['type' => 'text']],
            ['code' => 'one_step_buy', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'invoice_type', 'value' => 'a:2:{s:4:"type";a:3:{i:0;s:12:"普通发票";i:1;s:15:"增值税发票";i:2;s:0:"";}s:4:"rate";a:3:{i:0;d:0;i:1;d:13;i:2;d:0;}}', 'options' => ['type' => 'manual']],
            ['code' => 'stock_dec_time', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'cart_confirm', 'value' => '3', 'options' => ['type' => 'options', 'store_range' => '1,2,3,4']],
            ['code' => 'send_service_email', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'show_goods_in_cart', 'value' => '3', 'options' => ['type' => 'select', 'store_range' => '1,2,3']],
            ['code' => 'show_attr_in_cart', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
        ];
        
        $this->add_config($group, $data);
    }
    
    
    protected function smtp_group_5()
    {
        $group = 'smtp';
        
        $data = [
            ['code' => 'smtp_host', 'value' => 'smtp.qq.com', 'options' => ['type' => 'text']],
            ['code' => 'smtp_port', 'value' => '25', 'options' => ['type' => 'text']],
            ['code' => 'smtp_user', 'value' => '', 'options' => ['type' => 'text']],
            ['code' => 'smtp_pass', 'value' => '', 'options' => ['type' => 'password']],
            ['code' => 'smtp_mail', 'value' => '', 'options' => ['type' => 'text']],
            ['code' => 'mail_charset', 'value' => 'UTF8', 'options' => ['type' => 'select', 'store_range' => 'UTF8,GB2312,BIG5']],
            ['code' => 'mail_service', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'smtp_ssl', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        ];
        
        $this->add_config($group, $data);
    }
    
    
    protected function hidden_group_6()
    {
        $group = 'hidden';
        
        $data = [
            ['code' => 'integrate_code', 'value' => 'ecjia', 'options' => ['type' => 'hidden']],
            ['code' => 'integrate_config', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'hash_code', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'template', 'value' => 'ecjia-pc', 'options' => ['type' => 'hidden']],
            ['code' => 'install_date', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'ecjia_version', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'ecjia_db_version', 'value' => '5', 'options' => ['type' => 'hidden']],
//             ['code' => 'sms_user_name', 'value' => '', 'options' => ['type' => 'hidden']],
//             ['code' => 'sms_password', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'sms_auth_str', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'sms_domain', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'sms_count', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'sms_total_money', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'sms_balance', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'sms_last_request', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'affiliate', 'value' => 'a:5:{s:2:"on";i:1;s:6:"config";a:7:{s:6:"expire";d:24;s:11:"expire_unit";s:4:"hour";s:11:"separate_by";i:0;s:15:"level_point_all";s:2:"5%";s:15:"level_money_all";s:2:"1%";s:18:"level_register_all";i:2;s:17:"level_register_up";i:60;}s:13:"intvie_reward";a:3:{s:16:"intive_reward_by";s:6:"signup";s:18:"intive_reward_type";s:5:"bonus";s:19:"intive_reward_value";i:106;}s:14:"intviee_reward";a:3:{s:17:"intivee_reward_by";s:6:"signup";s:19:"intivee_reward_type";s:5:"bonus";s:20:"intivee_reward_value";i:106;}s:4:"item";a:4:{i:0;a:2:{s:11:"level_point";s:3:"60%";s:11:"level_money";s:3:"60%";}i:1;a:2:{s:11:"level_point";s:3:"30%";s:11:"level_money";s:3:"30%";}i:2;a:2:{s:11:"level_point";s:2:"7%";s:11:"level_money";s:2:"7%";}i:3;a:2:{s:11:"level_point";s:2:"3%";s:11:"level_money";s:2:"3%";}}}', 'options' => ['type' => 'hidden']],
            ['code' => 'captcha', 'value' => '45', 'options' => ['type' => 'hidden']],
            ['code' => 'captcha_width', 'value' => '100', 'options' => ['type' => 'hidden']],
            ['code' => 'captcha_height', 'value' => '28', 'options' => ['type' => 'hidden']],
            ['code' => 'sitemap', 'value' => 'a:6:{s:19:"homepage_changefreq";s:6:"hourly";s:17:"homepage_priority";s:3:"0.9";s:19:"category_changefreq";s:6:"hourly";s:17:"category_priority";s:3:"0.8";s:18:"content_changefreq";s:6:"weekly";s:16:"content_priority";s:3:"0.7";}', 'options' => ['type' => 'hidden']],
            ['code' => 'points_rule', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'flash_theme', 'value' => 'dynfocus', 'options' => ['type' => 'hidden']],
            ['code' => 'stylename', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'certificate_sn', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'certificate_file', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'auth_key', 'value' => '', 'options' => ['type' => 'hidden']],
//             ['code' => 'cycleimage_data', 'value' => 'a:5:{i:0;a:4:{s:3:"src";s:27:"data/afficheimg/banner1.png";s:3:"url";s:26:"https://ecjia.com/o2o.html";s:4:"text";s:0:"";s:4:"sort";i:1;}i:1;a:4:{s:3:"src";s:27:"data/afficheimg/banner2.png";s:3:"url";s:17:"https://ecjia.com";s:4:"text";s:0:"";s:4:"sort";i:2;}i:2;a:4:{s:3:"src";s:27:"data/afficheimg/banner3.png";s:3:"url";s:65:"https://ecjia.com/wiki/%E5%B8%AE%E5%8A%A9:ECJia%E5%88%B0%E5%AE%B6";s:4:"text";s:0:"";s:4:"sort";i:3;}i:3;a:4:{s:3:"src";s:27:"data/afficheimg/banner4.png";s:3:"url";s:23:"http://www.ecmoban.com/";s:4:"text";s:0:"";s:4:"sort";i:4;}i:4;a:4:{s:3:"src";s:27:"data/afficheimg/banner5.png";s:3:"url";s:22:"http://www.dscmall.cn/";s:4:"text";s:0:"";s:4:"sort";i:5;}}', 'options' => ['type' => 'hidden']],
//             ['code' => 'cycleimage_style', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'captcha_style', 'value' => 'captcha_royalcms', 'options' => ['type' => 'hidden']],
            ['code' => 'navigator_data', 'value' => 'a:4:{i:0;a:2:{s:4:"type";s:3:"top";s:4:"name";s:6:"顶部";}i:1;a:2:{s:4:"type";s:6:"middle";s:4:"name";s:6:"中间";}i:2;a:2:{s:4:"type";s:6:"bottom";s:4:"name";s:6:"底部";}i:3;a:2:{s:4:"type";s:5:"touch";s:4:"name";s:10:"ECJiaTouch";}}', 'options' => ['type' => 'hidden']],
//             ['code' => 'sms_receipt_verification', 'value' => '1', 'options' => ['type' => 'hidden']],
            ['code' => 'last_check_upgrade_time', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'app_key_android', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'app_secret_android', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'app_key_iphone', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'app_secret_iphone', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'app_key_ipad', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'app_secret_ipad', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'touch_template', 'value' => 'h5', 'options' => ['type' => 'hidden']],
            ['code' => 'touch_stylename', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'merchant_admin_cpname', 'value' => 'ECJia商家后台管理', 'options' => ['type' => 'hidden']],
            ['code' => 'merchant_admin_login_logo', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'mobile_seller_home_adsense', 'value' => '94', 'options' => ['type' => 'hidden']],
            ['code' => 'app_name', 'value' => 'EC+到家', 'options' => ['type' => 'hidden']],
//             ['code' => 'app_push_development', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//             ['code' => 'push_order_placed_apps', 'value' => '', 'options' => ['type' => 'hidden']],
//             ['code' => 'push_user_signin', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//             ['code' => 'push_order_shipped', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//             ['code' => 'push_order_payed', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//             ['code' => 'push_order_placed', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//             ['code' => 'push_order_payed_apps', 'value' => '', 'options' => ['type' => 'hidden']],
//             ['code' => 'push_order_shipped_apps', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'invite_template', 'value' => '你的好友（{$user_name}）向您推荐了一款购物应用【{$shop_name}】，优惠活动多多，新人注册还有红包奖励，赶紧下载体验吧！', 'options' => ['type' => 'hidden']],
            ['code' => 'invite_explain', 'value' => "1、通过推广页面把属于自己的二维码通过第三方平台分享给新人好友；\r\n2、新人好友通过您的邀请，打开链接，在活动页输入自己的手机号，并通过指定渠道下载客户端完成注册，即可获得奖励；\r\n3、每邀请一位新人好友并完成注册都可获得相应奖励；\r\n4、奖励一经领取后，不可删除，不可提现，不可转赠；\r\n5、新用户领取的奖励查看方式：【App-我的－我的钱包】查看，也可通过【我的推广—奖励明细】查看；\r\n6、如有任何的疑问请咨询官网客服人员；", 'options' => ['type' => 'hidden']],
            //v1.5.0新增
            ['code' => 'app_template', 'value' => 'ecjia-app', 'options' => ['type' => 'hidden']],
            ['code' => 'app_stylename', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'cloud_express_key', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'cloud_express_secret', 'value' => '', 'options' => ['type' => 'hidden']],
            //v1.7.0新增
            ['code' => 'store_model', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'region_cn_version', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'region_last_checktime', 'value' => '', 'options' => ['type' => 'hidden']],
        ];
        
        $this->add_config($group, $data);
    }
    
    protected function goods_group_7()
    {
        $group = 'goods';
        
        $data= [
            ['code' => 'show_goodssn', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'show_brand', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'show_goodsweight', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'show_goodsnumber', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'show_addtime', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'goodsattr_style', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'show_marketprice', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
        ];
        
        $this->add_config($group, $data);
    }
    
    
    protected function sms_group_8()
    {
        $group = 'sms';
        
        $data = [
            ['code' => 'sms_shop_mobile', 'value' => '', 'options' => ['type' => 'text']],
//             ['code' => 'sms_order_placed', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//             ['code' => 'sms_order_payed', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//             ['code' => 'sms_order_shipped', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'sms_signin', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'sms_send', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//             ['code' => 'sms_user_signin', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
        ];
        
        $this->add_config($group, $data);
    }
    
    protected function wap_group_9()
    {
        $group = 'wap';
        
        $data = [
            ['code' => 'wap_config', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'wap_logo', 'value' => 'data/assets/ecjia-intro/wap_logo.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'map_qq_key', 'value' => 'HVNBZ-HHR3P-HVBDP-LID55-D2YM3-2AF2W', 'options' => ['type' => 'text', 'sort_order' => '2']],
            ['code' => 'map_qq_referer', 'value' => 'ecjiaapp', 'options' => ['type' => 'text', 'sort_order' => '3']],
//             ['code' => 'map_baidu_key', 'value' => 'cZV7jwY5aiZcCqKqRMB6ASWRa2x4ptBV', 'options' => ['type' => 'text', 'sort_order' => '4']],
//             ['code' => 'map_baidu_referer', 'value' => 'ecjiaapp', 'options' => ['type' => 'text', 'sort_order' => '5']],
            ['code' => 'wap_app_download_show', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0', 'sort_order' => '11']],
            ['code' => 'wap_app_download_img', 'value' => 'data/assets/ecjia-intro/wap_app_download_img.png', 'options' => ['type' => 'file', 'store_range' => 'data/assets/', 'sort_order' => '12']],
        ];
        
        $this->add_config($group, $data);
    }
    
    
    protected function mobile_group_10()
    {
        $group = 'mobile';
        
        $data = [
//             ['code' => 'mobile_discover_data', 'value' => 'a:13:{i:4;a:5:{s:3:"src";s:37:"data/discover/1477876567618286130.png";s:3:"url";s:26:"https://ecjia.com/o2o.html";s:4:"text";s:15:"EC+到家简介";s:4:"sort";i:0;s:7:"display";i:1;}i:5;a:5:{s:3:"src";s:37:"data/discover/1478110259511162569.png";s:3:"url";s:44:"https://dn-ecmoban.qbox.me/ECJIAo2o-rwxf.mp4";s:4:"text";s:18:"到家视频介绍";s:4:"sort";s:1:"1";s:7:"display";i:0;}i:6;a:5:{s:3:"src";s:37:"data/discover/1477877330512416792.png";s:3:"url";s:35:"https://ecjia.com/wiki/常见问题";s:4:"text";s:12:"常见问题";s:4:"sort";s:1:"2";s:7:"display";i:1;}i:7;a:5:{s:3:"src";s:37:"data/discover/1477876646108552339.png";s:3:"url";s:40:"https://ecjia.com/readme/disclaimer.html";s:4:"text";s:12:"免责声明";s:4:"sort";i:3;s:7:"display";i:0;}i:8;a:5:{s:3:"src";s:37:"data/discover/1459462286529291580.png";s:3:"url";s:40:"https://ecjia.com/readme/disclaimer.html";s:4:"text";s:12:"会员专享";s:4:"sort";s:1:"4";s:7:"display";i:0;}i:9;a:5:{s:3:"src";s:37:"data/discover/1461121219027514959.png";s:3:"url";s:38:"ecjiaopen://app?open_type=user_address";s:4:"text";s:6:"地址";s:4:"sort";i:4;s:7:"display";i:1;}i:10;a:5:{s:3:"src";s:37:"data/discover/1461120899663962607.png";s:3:"url";s:37:"ecjiaopen://app?open_type=orders_list";s:4:"text";s:6:"订单";s:4:"sort";s:1:"4";s:7:"display";i:0;}i:11;a:5:{s:3:"src";s:37:"data/discover/1459462356158907938.png";s:3:"url";s:17:"https://ecjia.com";s:4:"text";s:9:"ec+官网";s:4:"sort";s:1:"5";s:7:"display";i:1;}i:12;a:5:{s:3:"src";s:37:"data/discover/1459462516430706755.png";s:3:"url";s:32:"ecjiaopen://app?open_type=qrcode";s:4:"text";s:15:"二维码扫描";s:4:"sort";s:1:"9";s:7:"display";i:0;}i:13;a:5:{s:3:"src";s:37:"data/discover/1484012474751128146.png";s:3:"url";s:41:"https://ecjia.com/wiki/帮助:ECJia到家";s:4:"text";s:18:"ECJia到家帮助 ";s:4:"sort";s:2:"11";s:7:"display";i:1;}i:14;a:5:{s:3:"src";s:37:"data/discover/1459462573769329651.png";s:3:"url";s:34:"ecjiaopen://app?open_type=groupbuy";s:4:"text";s:12:"意见反馈";s:4:"sort";s:2:"11";s:7:"display";i:0;}i:15;a:5:{s:3:"src";s:37:"data/discover/1459462586681562881.png";s:3:"url";s:34:"ecjiaopen://app?open_type=feedback";s:4:"text";s:6:"咨询";s:4:"sort";s:2:"12";s:7:"display";i:0;}i:16;a:5:{s:3:"src";s:37:"data/discover/1459462602180937166.png";s:3:"url";s:30:"ecjiaopen://app?open_type=help";s:4:"text";s:12:"帮助中心";s:4:"sort";s:2:"13";s:7:"display";i:1;}}', 'options' => ['type' => 'hidden']],
//             ['code' => 'mobile_shortcut_data', 'value' => 'a:10:{i:0;a:5:{s:3:"src";s:37:"data/shortcut/1478221589448573017.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1032";s:4:"text";s:12:"水果蔬菜";s:4:"sort";s:1:"0";s:7:"display";i:1;}i:1;a:5:{s:3:"src";s:37:"data/shortcut/1477700183823048386.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1047";s:4:"text";s:12:"肉禽蛋奶";s:4:"sort";s:1:"1";s:7:"display";i:1;}i:2;a:5:{s:3:"src";s:37:"data/shortcut/1477700190620505129.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1064";s:4:"text";s:12:"冷热速食";s:4:"sort";s:1:"2";s:7:"display";i:1;}i:3;a:5:{s:3:"src";s:37:"data/shortcut/1477700197732149350.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1078";s:4:"text";s:12:"休闲食品";s:4:"sort";s:1:"3";s:7:"display";i:1;}i:4;a:5:{s:3:"src";s:37:"data/shortcut/1477700204215089751.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1092";s:4:"text";s:12:"酒水饮料";s:4:"sort";s:1:"5";s:7:"display";i:1;}i:5;a:5:{s:3:"src";s:37:"data/shortcut/1477700210378659761.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1114";s:4:"text";s:12:"粮油调味";s:4:"sort";s:1:"6";s:7:"display";i:1;}i:6;a:5:{s:3:"src";s:37:"data/shortcut/1477700217181679112.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1135";s:4:"text";s:12:"清洁日化";s:4:"sort";s:1:"7";s:7:"display";i:1;}i:7;a:5:{s:3:"src";s:37:"data/shortcut/1477700223890846471.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1167";s:4:"text";s:12:"家居用品";s:4:"sort";s:1:"8";s:7:"display";i:1;}i:8;a:5:{s:3:"src";s:37:"data/shortcut/1477700537011530251.png";s:3:"url";s:60:"ecjiaopen://app?open_type=goods_seller_list&category_id=1186";s:4:"text";s:12:"鲜花蛋糕";s:4:"sort";s:1:"9";s:7:"display";i:1;}i:9;a:5:{s:3:"src";s:37:"data/shortcut/1477700617184169592.png";s:3:"url";s:46:"ecjiaopen://app?open_type=seller&category_id=6";s:4:"text";s:12:"上门服务";s:4:"sort";s:2:"10";s:7:"display";i:1;}}', 'options' => ['type' => 'hidden']],
//             ['code' => 'mobile_launch_adsense', 'value' => '102', 'options' => ['type' => 'manual']],
//             ['code' => 'mobile_home_adsense1', 'value' => '89', 'options' => ['type' => 'hidden']],
//             ['code' => 'mobile_home_adsense2', 'value' => '90', 'options' => ['type' => 'hidden']],
            ['code' => 'mobile_recommend_city', 'value' => '52,76,77,180,220,311,321,322,343,383,394,3401', 'options' => ['type' => 'manual']],
//             ['code' => 'mobile_cycleimage_data', 'value' => "a:5:{i:0;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695891057975664.png\";s:3:\"url\";s:51:\"ecjiaopen://app?open_type=goods_detail&goods_id=507\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"1\";s:7:\"display\";i:0;}i:1;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695897009489967.png\";s:3:\"url\";s:51:\"ecjiaopen://app?open_type=goods_list&category_id=11\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"2\";s:7:\"display\";i:0;}i:2;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695966324425303.png\";s:3:\"url\";s:51:\"ecjiaopen://app?open_type=goods_list&category_id=12\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"3\";s:7:\"display\";i:0;}i:3;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695980936007359.png\";s:3:\"url\";s:52:\"ecjiaopen://app?open_type=goods_list&category_id=143\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"3\";s:7:\"display\";i:0;}i:4;a:5:{s:3:\"src\";s:39:\"data/afficheimg/1449695988307349360.png\";s:3:\"url\";s:50:\"ecjiaopen://app?open_type=goods_list&category_id=5\";s:4:\"text\";s:0:\"\";s:4:\"sort\";s:1:\"5\";s:7:\"display\";i:0;}}", 'options' => ['type' => 'hidden']],
            ['code' => 'mobile_pc_url', 'value' => 'https://cityo2o.ecjia.com', 'options' => ['type' => 'text']],
            ['code' => 'mobile_touch_url', 'value' => 'https://cityo2o.ecjia.com/sites/m/', 'options' => ['type' => 'text', 'sort_order' => '2']],
            ['code' => 'mobile_iphone_download', 'value' => 'https://itunes.apple.com/cn/app/ec+dao-jia/id1118895347?mt=8', 'options' => ['type' => 'text', 'sort_order' => '3']],
            ['code' => 'mobile_android_download', 'value' => 'http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.cityo2o', 'options' => ['type' => 'text', 'sort_order' => '4']],
            ['code' => 'mobile_ipad_download', 'value' => '', 'options' => ['type' => 'text', 'sort_order' => '5']],
            ['code' => 'mobile_app_icon', 'value' => 'data/assets/mobile_app_icon.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/', 'sort_order' => '6']],
            ['code' => 'mobile_app_description', 'value' => 'ECJia到家是上海商创网络科技有限公司推出的一款多商户原生APP，基于LBS定位功能让用户通过查找附近店铺 在手机APP下单，支付，评价，并由商家提供上门服务的一套新型服务模式的电商系统。', 'options' => ['type' => 'text', 'sort_order' => '7']],
            ['code' => 'mobile_pad_login_fgcolor', 'value' => '#ffffff', 'options' => ['type' => 'color']],
            ['code' => 'mobile_pad_login_bgcolor', 'value' => '#000000', 'options' => ['type' => 'color']],
            ['code' => 'mobile_pad_login_bgimage', 'value' => 'data/assets/mobile_pad_login_bgimage.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'mobile_phone_login_fgcolor', 'value' => '#04b24f', 'options' => ['type' => 'color']],
            ['code' => 'mobile_phone_login_bgcolor', 'value' => '#afafaf', 'options' => ['type' => 'color']],
            ['code' => 'mobile_phone_login_bgimage', 'value' => 'data/assets/mobile_phone_login_bgimage.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
//             ['code' => 'mobile_topic_adsense', 'value' => '', 'options' => ['type' => 'manual']],
            ['code' => 'mobile_shopkeeper_urlscheme', 'value' => 'com.ecjia.cityo2o://', 'options' => ['type' => 'hidden']],
//             ['code' => 'mobile_cycleimage_phone_data', 'value' => 'a:5:{i:0;a:5:{s:3:"src";s:39:"data/afficheimg/1471820010293706033.png";s:3:"url";s:53:"ecjiaopen://app?open_type=goods_list&category_id=1032";s:4:"text";s:0:"";s:4:"sort";s:1:"1";s:7:"display";i:0;}i:1;a:5:{s:3:"src";s:39:"data/afficheimg/1470680042094971654.png";s:3:"url";s:51:"ecjiaopen://app?open_type=goods_detail&goods_id=693";s:4:"text";s:0:"";s:4:"sort";s:1:"2";s:7:"display";i:0;}i:2;a:5:{s:3:"src";s:39:"data/afficheimg/1470679954374104363.png";s:3:"url";s:51:"ecjiaopen://app?open_type=goods_list&category_id=12";s:4:"text";s:0:"";s:4:"sort";s:1:"3";s:7:"display";i:0;}i:3;a:5:{s:3:"src";s:39:"data/afficheimg/1470680474723510488.png";s:3:"url";s:52:"ecjiaopen://app?open_type=goods_list&category_id=143";s:4:"text";s:0:"";s:4:"sort";s:1:"4";s:7:"display";i:0;}i:4;a:5:{s:3:"src";s:39:"data/afficheimg/1470680492405164776.png";s:3:"url";s:50:"ecjiaopen://app?open_type=goods_list&category_id=5";s:4:"text";s:0:"";s:4:"sort";s:1:"5";s:7:"display";i:0;}}', 'options' => ['type' => 'hidden']],
//             ['code' => 'mobile_home_adsense_group', 'value' => '98,97,99,100,101', 'options' => ['type' => 'manual']],
            ['code' => 'mobile_iphone_qrcode', 'value' => 'data/assets/qrcode.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'mobile_ipad_qrcode', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'mobile_android_qrcode', 'value' => 'data/assets/qrcode.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'bonus_readme_url', 'value' => '/index.php?m=article&c=mobile&a=info&id=-1', 'options' => ['type' => 'text']],
            ['code' => 'mobile_app_name', 'value' => 'EC+ 到家', 'options' => ['type' => 'text']],
            ['code' => 'mobile_app_version', 'value' => '1.4.0', 'options' => ['type' => 'text']],
            ['code' => 'mobile_app_preview', 'value' => 'a:2:{i:0;s:35:"data/assets/mobile_app_preview1.jpg";i:1;s:35:"data/assets/mobile_app_preview2.jpg";}', 'options' => ['type' => 'manual']],
            ['code' => 'mobile_app_video', 'value' => 'https://dn-ecmoban.qbox.me/ECJIAo2o-rwxf.mp4', 'options' => ['type' => 'text']],
            ['code' => 'mobile_shop_urlscheme', 'value' => 'com.ecjia.cityo2o://', 'options' => ['type' => 'text']],
            ['code' => 'mobile_share_link', 'value' => 'https://cityo2o.ecjia.com/sites/api/index.php?m=affiliate&c=mobile&a=init&invite_code={$invite_code}', 'options' => ['type' => 'text']],
            ['code' => 'mobile_feedback_autoreply', 'value' => '', 'options' => ['type' => 'textarea']],
            ['code' => 'mobile_touch_qrcode', 'value' => 'data/assets/mobile_touch_qrcode.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'mobile_location_range', 'value' => '3', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4,5']],
            ['code' => 'mobile_signup_reward_notice', 'value' => "1.本活动仅限手机号注册新用户参与；\r\n2.每个手机号仅限参与一次；\r\n3.领取红包查看方式：【我的－我的钱包】查看；", 'options' => ['type' => 'text']],
            ['code' => 'mobile_signup_reward', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        ];
        
        $this->add_config($group, $data);
    }
    
    protected function addon_group_11()
    {
        $group = 'addon';
        
        $data = [
            ['code' => 'addon_active_applications', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_active_plugins', 'value' => 'a:33:{i:0;s:25:"calculator/calculator.php";i:1;s:37:"captcha_royalcms/captcha_royalcms.php";i:2;s:37:"cron_auto_manage/cron_auto_manage.php";i:3;s:31:"cron_bill_day/cron_bill_day.php";i:4;s:35:"cron_bill_month/cron_bill_month.php";i:5;s:25:"cron_ipdel/cron_ipdel.php";i:6;s:41:"cron_order_receive/cron_order_receive.php";i:7;s:29:"cron_testlog/cron_testlog.php";i:8;s:29:"cron_unpayed/cron_unpayed.php";i:9;s:25:"mp_checkin/mp_checkin.php";i:10;s:17:"mp_dzp/mp_dzp.php";i:11;s:17:"mp_ggk/mp_ggk.php";i:12;s:21:"mp_goods/mp_goods.php";i:13;s:19:"mp_jfcx/mp_jfcx.php";i:14;s:19:"mp_kefu/mp_kefu.php";i:15;s:23:"mp_orders/mp_orders.php";i:16;s:27:"mp_userbind/mp_userbind.php";i:18;s:17:"mp_zjd/mp_zjd.php";i:19;s:25:"pay_alipay/pay_alipay.php";i:20;s:27:"pay_balance/pay_balance.php";i:21;s:21:"pay_cash/pay_cash.php";i:22;s:19:"pay_cod/pay_cod.php";i:24;s:21:"ship_cac/ship_cac.php";i:25;s:21:"ship_ems/ship_ems.php";i:26;s:23:"ship_flat/ship_flat.php";i:27;s:21:"ship_fpd/ship_fpd.php";i:28;s:37:"ship_o2o_express/ship_o2o_express.php";i:29;s:35:"ship_sf_express/ship_sf_express.php";i:30;s:37:"ship_sto_express/ship_sto_express.php";i:31;s:21:"ship_yto/ship_yto.php";i:32;s:21:"ship_zto/ship_zto.php";i:33;s:17:"sns_qq/sns_qq.php";i:34;s:19:"ueditor/ueditor.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_system_plugins', 'value' => 'a:2:{s:7:"ueditor";s:19:"ueditor/ueditor.php";s:10:"calculator";s:25:"calculator/calculator.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_nav_menu', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_cat_articles', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_cat_goods', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_brand_goods', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_ad_position', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_user_integrate_plugins', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_mobile_payment_plugins', 'value' => 'a:4:{s:11:"pay_balance";s:27:"pay_balance/pay_balance.php";s:10:"pay_alipay";s:25:"pay_alipay/pay_alipay.php";s:7:"pay_cod";s:19:"pay_cod/pay_cod.php";s:8:"pay_cash";s:21:"pay_cash/pay_cash.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_shipping_plugins', 'value' => 'a:9:{s:8:"ship_ems";s:21:"ship_ems/ship_ems.php";s:8:"ship_yto";s:21:"ship_yto/ship_yto.php";s:8:"ship_cac";s:21:"ship_cac/ship_cac.php";s:9:"ship_flat";s:23:"ship_flat/ship_flat.php";s:8:"ship_zto";s:21:"ship_zto/ship_zto.php";s:8:"ship_fpd";s:21:"ship_fpd/ship_fpd.php";s:16:"ship_o2o_express";s:37:"ship_o2o_express/ship_o2o_express.php";s:15:"ship_sf_express";s:35:"ship_sf_express/ship_sf_express.php";s:16:"ship_sto_express";s:37:"ship_sto_express/ship_sto_express.php";}', 'options' => ['type' => 'hidden']],
//             ['code' => 'addon_cycleimage_plugins', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_captcha_plugins', 'value' => 'a:1:{s:16:"captcha_royalcms";s:37:"captcha_royalcms/captcha_royalcms.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_platform_plugins', 'value' => 'a:9:{s:7:"mp_jfcx";s:19:"mp_jfcx/mp_jfcx.php";s:9:"mp_orders";s:23:"mp_orders/mp_orders.php";s:6:"mp_ggk";s:17:"mp_ggk/mp_ggk.php";s:10:"mp_checkin";s:25:"mp_checkin/mp_checkin.php";s:6:"mp_dzp";s:17:"mp_dzp/mp_dzp.php";s:6:"mp_zjd";s:17:"mp_zjd/mp_zjd.php";s:7:"mp_kefu";s:19:"mp_kefu/mp_kefu.php";s:11:"mp_userbind";s:27:"mp_userbind/mp_userbind.php";s:8:"mp_goods";s:21:"mp_goods/mp_goods.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_merchant_plugins', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_cron_plugins', 'value' => 'a:7:{s:10:"cron_ipdel";s:25:"cron_ipdel/cron_ipdel.php";s:16:"cron_auto_manage";s:37:"cron_auto_manage/cron_auto_manage.php";s:12:"cron_testlog";s:29:"cron_testlog/cron_testlog.php";s:18:"cron_order_receive";s:41:"cron_order_receive/cron_order_receive.php";s:12:"cron_unpayed";s:29:"cron_unpayed/cron_unpayed.php";s:13:"cron_bill_day";s:31:"cron_bill_day/cron_bill_day.php";s:15:"cron_bill_month";s:35:"cron_bill_month/cron_bill_month.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_connect_plugins', 'value' => 'a:1:{s:6:"sns_qq";s:17:"sns_qq/sns_qq.php";}', 'options' => ['type' => 'hidden']],
        ];
        
        $this->add_config($group, $data);
    }
    
}

// end