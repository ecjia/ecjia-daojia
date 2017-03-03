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

class sms_installer extends ecjia_installer {
    
    protected $dependent = array(
    	'ecjia.system'    => '1.0',
        'ecjia.promotion' => '1.0',
    );
    
    public function __construct() {
        $id = 'ecjia.bonus';
        parent::__construct($id);
    }
    
    
    public function install() {
        $table_name = 'sms_sendlist';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
            	"`id` MEDIUMINT(8) NOT NULL AUTO_INCREMENT",
                "`mobile` VARCHAR(100) NOT NULL",
                "`template_id` MEDIUMINT(8) NOT NULL",
                "`sms_content` TEXT NULL",
                "`error` TINYINT(1) NOT NULL DEFAULT '0'",
                "`pri` TINYINT(10) NULL",
                "`last_send` INT(10) NULL",
                "PRIMARY KEY (`id`)"
            );
            
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        if (!ecjia::config('sms_user_name', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'sms_user_name', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('sms_password', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'sms_password', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('sms_user_signin', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_user_signin', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('sms_order_shipped', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_order_shipped', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('sms_order_payed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_order_payed', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('sms_order_placed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_order_placed', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('sms_shop_mobile', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_shop_mobile', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        /* 收货短信码*/
        if (!ecjia::config('sms_receipt_verification', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('sms', 'sms_receipt_verification', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        $template_code = RC_Model::model('sms/mail_templates_model')->get_field('template_code', true);
        /* 收货短信码*/
        if (!in_array('sms_receipt_verification', $template_code)) {
        		$data = array(
        		'template_code' => 'sms_receipt_verification',	
        		'is_html' => 0,
        		'template_subject' => '订单收货验证码',
        		'template_content' => '尊敬的{$user_name} ，您在我们网站已成功下单。订单号：{$order_sn}，收货验证码为：{$code}。请保管好您的验证码，以便收货验证。',
        		'last_modify' => RC_Time::gmtime(),
        		'last_send' => 0,
        		'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
       	
        /*手机发送验证码*/
        if (!in_array('sms_get_validate', $template_code)) {
        	$data = array(
        		'template_code' => 'sms_get_validate',	
        		'is_html' => 0,
        		'template_subject' => '获取验证码',
        		'template_content' => '您的校验码是：{$code}，请在页面中输入以完成验证。如非本人操作，请忽略本短信。如有问题请拨打客服电话：{$service_phone}。',
        		'last_modify' => RC_Time::gmtime(),
        		'last_send' => 0,
        		'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
        /*新订单短信提醒*/
        if (!in_array('order_placed_sms', $template_code)) {
        	$data = array(
        			'template_code' => 'order_placed_sms',
        			'is_html' => 0,
        			'template_subject' => '新订单短信提醒（客户下订单时给商家发短信）',
        			'template_content' => '有客户下单啦！快去看看吧！订单编号：{$order.order_sn}，收货人：{$order.consignee}，联系电话{$order.mobile}，订单金额{$order.order_amount}。',
        			'last_modify' => RC_Time::gmtime(),
        			'last_send' => 0,
        			'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
        /*订单付款短信通知*/
        if (!in_array('order_payed_sms', $template_code)) {
        	$data = array(
        			'template_code' => 'order_payed_sms',
        			'is_html' => 0,
        			'template_subject' => '订单付款短信通知 (客户付款时给商家发短信)',
        			'template_content' => '订单编号：{$order.order_sn} 已付款。 收货人：{$order.consignee}，联系电话{$order.mobile}，订单金额{$order.order_amount}。',
        			'last_modify' => RC_Time::gmtime(),
        			'last_send' => 0,
        			'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
    
        /*发货短信通知*/
        if (!in_array('order_shipped_sms', $template_code)) {
        	$data = array(
        			'template_code' => 'order_shipped_sms',
        			'is_html' => 0,
        			'template_subject' => '发货短信通知 (商家发货时给客户发短信)',
        			'template_content' => '您的订单：{$order.order_sn} ，已于{$delivery_time} 通过{$order.shipping_name}进行发货。发货单号为：{$order.invoice_no}，请注意查收。',
        			'last_modify' => RC_Time::gmtime(),
        			'last_send' => 0,
        			'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
        
        /*修改邮箱邮件通知模板*/
        if (!in_array('email_verifying_authentication', $template_code)) {
        	$data = array(
        			'template_code' => 'email_verifying_authentication',
        			'is_html' => 1,
        			'template_subject' => '验证用户发送邮箱验证码',
        			'template_content' => '{$user_name}您好！<br/><br/>这封邮件是 {$shop_name} 发送的。您正在进行{$action}，需要进行验证，验证码为：{$code}，如有问题请拨打客服电话{$service_phone}。<br/><p><br/></p><br/><br/>{$shop_name}<br/>{$send_date}',
        			'last_modify' => RC_Time::gmtime(),
        			'last_send' => 0,
        			'type' => 'template'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'sms_sendlist';
        if (RC_Model::make()->table_exists($table_name)) {
           RC_Model::make()->drop_table($table_name);
        }
        
        if (ecjia::config('sms_user_name', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_user_name');
        }
        if (ecjia::config('sms_password', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_password');
        }
        
        if (ecjia::config('sms_user_signin', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_user_signin');
        }
        if (ecjia::config('sms_order_shipped', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_order_shipped');
        }
        if (ecjia::config('sms_order_payed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_order_payed');
        }
        if (ecjia::config('sms_order_placed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_order_placed');
        }
        if (ecjia::config('sms_shop_mobile', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_shop_mobile');
        }
        /* 收货短信码*/
        if (ecjia::config('sms_receipt_verification', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('sms_receipt_verification');
        }
        RC_Model::model('sms/mail_templates_model')->where(array('type' => 'sms'))->delete();
        
        return true;
    }
    
}

// end