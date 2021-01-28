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

/**
 * 申请商家入驻
 * @author will.chen
 */
class admin_merchant_signup_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
        $this->authadminSession();
		$responsible_person = $this->requestData('responsible_person', '');
		$email 				= $this->requestData('email', '');
		$mobile				= $this->requestData('mobile', '');
		$seller_name		= $this->requestData('seller_name', '');
		$seller_category	= $this->requestData('seller_category', '');
		$validate_type		= $this->requestData('validate_type');
		$province			= $this->requestData('province');
		$city				= $this->requestData('city');
		$district			= $this->requestData('district');
		$street				= $this->requestData('street');
		$address			= $this->requestData('address');
		$longitude			= $this->requestData('location.longitude');
		$latitude			= $this->requestData('location.latitude');
		$validate_code	    = $this->requestData('validate_code');


		if (empty($responsible_person) || empty($email) || empty($mobile) || empty($seller_name) || empty($seller_category)
		     || empty($validate_type) || empty($province) || empty($city)|| empty($district) || empty($street) || empty($address) || empty($longitude) || empty($latitude)) {
			return new ecjia_error( 'invalid_parameter', sprintf(__('请求接口%s参数无效', 'merchant'), __CLASS__));
		}

        $preaudit_count   = RC_DB::table('store_preaudit')->where('email', '=', $email)->count();
        $franchisee_count = RC_DB::table('store_franchisee')->where('email', '=', $email)->count();
        if(!empty($preaudit_count) || !empty($franchisee_count)){
            return new ecjia_error('validate_email_error', __('邮箱地址已经被使用，请填写其他邮箱地址', 'merchant'));
        }

		/* 判断校验码*/
		if ($_SESSION['merchant_validate_code'] != $validate_code) {
			return new ecjia_error('validate_code_error', __('校验码错误！', 'merchant'));
		} elseif ($_SESSION['merchant_validate_expiry'] < RC_Time::gmtime()) {
			return new ecjia_error('validate_code_time_out', __('校验码已过期！', 'merchant'));
		} elseif ($_SESSION['merchant_validate_mobile'] != $mobile) {
			return new ecjia_error('validate_mobile_error', __('手机号码已经更改请重新获取验证码', 'merchant'));
		}
        //店铺名称不可超过20个字符
		if (mb_strlen($seller_name) > 20) {
            return new ecjia_error('seller_name_exist', __('店铺名称不可超过20个字符', 'merchant'));
        }
		
		$count = RC_DB::table('store_franchisee')->where(RC_DB::raw('merchants_name'), $seller_name)->count();
		if ($count > 0) {
		    return new ecjia_error('seller_name_exist', __('店铺名称已存在，请修改', 'merchant'));
		}

        if(empty($longitude) || empty($latitude)){
            $location  = $this->getgeohash($city, $address);
            $latitude  = $location['lat'];
            $longitude = $location['lng'];
        }
        $geohash      = RC_Loader::load_app_class('geohash', 'store');
        $geohash_code = $geohash->encode($latitude, $longitude);
        $geohash_code = substr($geohash_code, 0, 10);


		$info_store_preaudit	= RC_DB::table('store_preaudit')->where(RC_DB::raw('contact_mobile'), $mobile)->first();
		$info_store_franchisee	= RC_DB::table('store_franchisee')->where(RC_DB::raw('contact_mobile'), $mobile)->first();
		$info_staff_user		= RC_DB::table('staff_user')->where('mobile', $mobile)->first();
		if (!empty($info_store_preaudit) || !empty($info_store_franchisee)) {
			return new ecjia_error('already_signup', __('您已申请请勿重复申请！', 'merchant'));
		}
        if(!empty($info_staff_user)){
            return new ecjia_error('already_signup', __('该手机号码已被注册为店铺员工', 'merchant'));
        }

		$merchant_shop_data = array(
			'responsible_person'	=> $responsible_person,
			'merchants_name'		=> $seller_name,
			'contact_mobile'		=> $mobile,
			'email'					=> $email,
			'check_status'			=> 1,
			'apply_time'			=> RC_Time::gmtime(),
			'store_id'				=> 0,
			'cat_id'				=> $seller_category,
			'validate_type'			=> $validate_type,
			'province'				=> $province,
			'city'					=> $city,
			'district'				=> $district,
			'street'				=> $street,
			'address'				=> $address,
			'longitude'				=> $longitude,
			'latitude'				=> $latitude,
		);
		
		$insert_id = RC_DB::table('store_preaudit')->insertGetId($merchant_shop_data);
		//审核日志
		RC_Loader::load_app_func('merchant_franchisee', 'franchisee');
		add_check_log($merchant_shop_data, '', $insert_id);

		unset($_SESSION['merchant_validate_code']);
		unset($_SESSION['merchant_validate_expiry']);
		return array();
    }
	
    /**
     * 根据地区获取经纬度
     */
    private function getgeohash($city, $address){
    	$shop_city          = !empty($city)        ? intval($city)               : 0;
    	$shop_address       = !empty($address)     ? htmlspecialchars($address)  : 0;
    
    	$city_name	= ecjia_region::getRegionName($shop_city);
    	$address  	= $city_name.$shop_address;
    
    	//腾讯地图api 地址解析（地址转坐标）
    	$address = urlencode($address);
    	$key = ecjia::config('map_qq_key');
    	$shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$address."&key=".$key);
    	$shop_point = json_decode($shop_point['body'], true);
    	$location   = (array)$shop_point['result']['location'];
    	return $location;
    }
}

//end