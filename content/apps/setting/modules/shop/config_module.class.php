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

class config_module extends api_front implements api_interface
{

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	$db_region = RC_Loader::load_app_model('region_model', 'shipping');
    	
    	$mobile_recommend_city = explode(',', ecjia::config('mobile_recommend_city'));
    	
    	$regions = array ();
    	$region_data = $db_region->where(array('region_id' => $mobile_recommend_city ))->select();
    	if (!empty($region_data)) {
    		foreach ( $region_data as $val ) {
    			$regions[] = array(
    					'id'	=> $val['region_id'],
    					'name'	=> $val['region_name']
    			);
    		}	
    	}
    	
        $data = array(
            'service_phone'     => ecjia::config('service_phone'),
            'service_qq'        => ecjia_config::has('qq') ? explode(',', ecjia::config('qq')) : array(),
			'site_url'          => ecjia_config::has('mobile_pc_url') ? ecjia::config('mobile_pc_url') : RC_Config::load_config('site', 'CUSTOM_SITE_URL'),
            'goods_url'         => ecjia_config::has('mobile_touch_url') ? ecjia::config('mobile_touch_url').'?m=goods&c=index&a=init&id=' : (ecjia_config::has('mobile_pc_url') ? ecjia::config('mobile_pc_url') : RC_Config::system('CUSTOM_WEB_SITE_URL') . '/goods.php?id='),
            'shop_closed'       => ecjia::config('shop_closed'),
        	'close_comment'     => ecjia::config('close_comment'),
            'shop_reg_closed'   => ecjia::config('shop_reg_closed'),
        	'shop_name'			=> ecjia::config('shop_name'),
            'shop_desc'         => ecjia::config('shop_desc'),
        	'shop_address'		=> ecjia::config('shop_address'),
            'currency_format'   => ecjia::config('currency_format'),
            'time_format'       => ecjia::config('time_format'),
        	'get_password_url'	=> RC_Uri::url('user/get_password/forget_pwd', 'type=mobile'),
        	'recommend_city'	=> $regions,
        	'bonus_readme_url'	=> RC_Uri::site_url().ecjia::config('bonus_readme_url'),
        );
        
        $result = ecjia_app::validate_application('sms');
        $is_active = ecjia_app::is_active('ecjia.sms');
         
        if (is_ecjia_error($result) && !$is_active) {
        	$data['get_password_url'] = RC_Uri::url('user/get_password/forget_pwd', 'type=email');
        }
        
        $store_model = trim(ecjia::config('store_model'));
        
        if ($store_model == 'nearby' || empty($store_model)) {
        	$data['store_model'] = 'nearby';
        } else if (!empty($store_model)) {
        	$store_id = $store_model;
        	$store_model = explode(',', $store_model);
        	if (count($store_model) == 1) {
        		$data['store_model'] = 'single';
        		$data['store_id'] = $store_id;
        	} else {
        		$data['store_model'] = 'recommend';
        	}
        }
        
        $device	= $this->device;
        if (isset($device['client']) && ($device['client'] == 'iphone' || $device['client'] == 'android')) {
        	$data = array_merge($data, array(
        			'mobile_phone_login_fgcolor' => ecjia::config('mobile_phone_login_fgcolor'),		//前景颜色
        			'mobile_phone_login_bgcolor' => ecjia::config('mobile_phone_login_bgcolor'),		//背景颜色
        			'mobile_phone_login_bgimage' => ecjia_config::has('mobile_phone_login_bgimage') ?	RC_Upload::upload_url().'/'.ecjia::config('mobile_phone_login_bgimage') : '',		//背景图片
        	));
        }
        if (isset($device['client']) && $device['client'] == 'ipad') {
        	$data = array_merge($data, array(
        			'mobile_pad_login_fgcolor' => ecjia::config('mobile_pad_login_fgcolor'),			//前景颜色
        			'mobile_pad_login_bgcolor' => ecjia::config('mobile_pad_login_bgcolor'),			//背景颜色
        			'mobile_pad_login_bgimage' => ecjia_config::has('mobile_pad_login_bgimage') ?	RC_Upload::upload_url().'/'.ecjia::config('mobile_pad_login_bgimage') : '',		//背景图片
        	));
        }
        if (isset($device['client']) && $device['client'] == 'iphone') {
        	$mobile_iphone_qr_code = ecjia::config('mobile_iphone_qr_code');
        	$data['mobile_qr_code']	= !empty($mobile_iphone_qr_code) ? RC_Upload::upload_url().'/'.$mobile_iphone_qr_code : '';
        } elseif(isset($device['client']) && $device['client'] == 'android') {
        	$mobile_android_qr_code = ecjia::config('mobile_android_qr_code');
        	$data['mobile_qr_code']	= !empty($mobile_android_qr_code) ? RC_Upload::upload_url().'/'.$mobile_android_qr_code : '';
        } else {
        	$mobile_ipad_qr_code = ecjia::config('mobile_ipad_qr_code');
        	$data['mobile_qr_code']	= !empty($mobile_ipad_qr_code) ? RC_Upload::upload_url().'/'.$mobile_ipad_qr_code : '';
        }
        
        $data['mobile_app_icon'] = ecjia_config::has('mobile_app_icon') ? RC_Upload::upload_url() . '/' . ecjia::config('mobile_app_icon') : '';
       	$shop_type = RC_Config::load_config('site', 'SHOP_TYPE');
        $data['shop_type'] = !empty($shop_type) ? $shop_type : 'b2c';
        $data['wap_app_download_show'] = ecjia::config('wap_app_download_show');
        $data['wap_app_download_img'] = ecjia_config::has('wap_app_download_img') ? RC_Upload::upload_url() . '/' . ecjia::config('wap_app_download_img') : '';
        
        return $data;
    }
}


// end