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
 * 收货地址管理接口
 * @author 
 */
class user_address_manage_api extends Component_Event_Api {
    
    public function call(&$address) {
        if (!is_array($address) 
	        || !isset($address['user_id'])
	        || !isset($address['address'])
	        || !isset($address['consignee'])
	        || (!isset($address['mobile']) && !isset($address['tel']))
        ) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
        /* 验证参数的合法性*/
        /* 邮箱*/
        if (!empty($address['email'])) {
        	if (!$this->is_email($address['email'])) {
        		return new ecjia_error('invalid_email', 'email地址格式错误');
        	}
        }
        
        if (!empty($address['province']) && !empty($address['city']) && !empty($address['address']) && empty($address['location'])) {
            $province_name = ecjia_region::getRegionName($address['province']);
            $city_name = ecjia_region::getRegionName($address['city']);
            $district_name = ecjia_region::getRegionName($address['district']);
            $street_name = ecjia_region::getRegionName($address['street']);
        	
        	$consignee_address = '';
        	if (!empty($province_name)) {
        		$consignee_address .= $province_name;
        	}
        	if (!empty($city_name)) {
        		$consignee_address .= $city_name;
        	}
            if (!empty($district_name)) {
                $consignee_address .= $district_name;
            }
            if (!empty($street_name)) {
                $consignee_address .= $street_name;
            }
        	$consignee_address .= $address['address'];

            //腾讯地图api 地址解析（地址转坐标）
            $consignee_address = urlencode($consignee_address);
            $key = ecjia::config('map_qq_key');
            $shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$consignee_address."&key=".$key);
            $shop_point = json_decode($shop_point['body'], true);
            if (isset($shop_point['result']) && !empty($shop_point['result']['location'])) {
            	$address['longitude'] = $shop_point['result']['location']['lng'];
            	$address['latitude'] = $shop_point['result']['location']['lat'];
            }
            unset($address['location']);
        } else {
        	$address['longitude']	= $address['location']['longitude'];
        	$address['latitude']	= $address['location']['latitude'];
        }
     
        /* 获取用户地址 */
        $user_address	= RC_DB::table('user_address')->where('address_id', $address['address_id'])->where('user_id', $_SESSION['user_id'])->pluck('address_id');
        if ($address['address_id'] != $user_address) {
        	return new ecjia_error('not_exists_info', '不存在的信息');
        }
        
        $address_id = $this->update_address($address);
        return $address_id;
    }
       
    /**
     * 验证输入的邮件地址是否合法
     *
     * @access public
     * @param string $email
     *            需要验证的邮件地址
     * @return bool
     */
    private function is_email($email)
    {
    	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    	if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
    		if (preg_match($chars, $email))
    			return true;
    	}
    	return false;
    }
    
    /**
     *  添加或更新指定用户收货地址
     *
     * @access  public
     * @param   array       $address
     * @return  bool
     */
    private function update_address($address)
    {
    
    	$address_id = 0;
    	if (isset($address['address_id'])) {
    		$address_id = intval($address['address_id']);
    		unset($address['address_id']);
    	}
    	
    	//验证是否重复
    	$count = RC_DB::table('user_address')->where('address_id', '!=', $address_id)
    				->where('user_id', $address['user_id'])
    				->where('consignee', $address['consignee'])
    				->where('email', $address['email'])
    				->where('country', $address['country'])
    				->where('province', $address['province'])
    				->where('city', $address['city'])
    				->where('district', $address['district'])
    				->where('street', $address['street'])
    				->where('address', $address['address'])
    				->where('address_info', $address['address_info'])
    				->where('zipcode', $address['zipcode'])
    				->where('tel', $address['tel'])
    				->where('mobile', $address['mobile'])
    				->count();
    	
    	if ($count) {
    	    return new ecjia_error('address_repeat', '收货地址信息重复，请修改！');
    	}
    	//字段过滤
    	$defaul = $address['default'];
    	if (array_key_exists('default', $address)) {
    		 unset($address['default']);
    	}
    	
    	if ($address_id > 0) {
    		$address['district'] = empty($address['district']) ? '' : $address['district'];
    		
    		/* 更新指定记录 */
    		RC_DB::table('user_address')->where('address_id', $address_id)->where('user_id', $address['user_id'])->update($address);
    	} else {
    	    //上限20条
    	    $count = RC_DB::table('user_address')->where('user_id', $address['user_id'])->count();
    	    if ($count >= 20) {
    	        return new ecjia_error('overflow_number', '收货地址最多只能添加20个！');
    	    }
    		/* 插入一条新记录 */
    		$address_id = RC_DB::table('user_address')->insertGetId($address);
    	}
    
    	if (isset($defaul) && $defaul > 0 && isset($address['user_id'])) {
    		RC_DB::table('users')->where('user_id', $address['user_id'])->update(array('address_id' => $address_id));
    	}
    
    	return $address_id;
    }
}

// end