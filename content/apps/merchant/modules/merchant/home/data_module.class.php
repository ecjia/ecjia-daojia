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
 * 店铺首页信息
 * @author will.chen
 */
class merchant_home_data_module extends api_front implements api_interface {
	
	public function __construct()
	{
		parent::__construct();
		
		RC_Hook::add_filter('api_merchant_home_data_runloop', [$this , 'cycleimage_data'], 10, 2);
		RC_Hook::add_filter('api_merchant_home_data_runloop', [$this , 'mobile_menu_data'], 10, 2);
		RC_Hook::add_filter('api_merchant_home_data_runloop', [$this , 'promote_goods_data'], 10, 2);
		RC_Hook::add_filter('api_merchant_home_data_runloop', [$this , 'new_goods_data'], 10, 2);
		RC_Hook::add_filter('api_merchant_home_data_runloop', [$this , 'group_goods_data'], 10, 2);
		RC_Hook::add_filter('api_merchant_home_data_runloop', [$this , 'mobile_home_adsense_group'], 10, 2);
		RC_Hook::add_filter('api_merchant_home_data_runloop', [$this , 'store_fans_visit'], 10, 2);
		RC_Hook::add_filter('filter_merchant_adsense_group_data', [$this , 'filter_merchant_adsense_group_data']);
		
	}
	
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
		$seller_id = $this->requestData('seller_id');
		$city_id = $this->requestData('city_id');
		$location = $this->requestData('location', array());
	
		if (empty($seller_id)) {
			return new ecjia_error( 'invalid_parameter', __('参数无效' ,'merchant'));
		}
		//是否开启闪惠功能
		RC_Loader::load_app_class('quickpay_activity', 'quickpay', false);
		$allow_use_quickpay = quickpay_activity::is_open_quickpay($seller_id);
		
		$user_id = $_SESSION['user_id'];
		$api_version = $request->header('api-version');
		$api_version = empty($api_version) ? $this->requestData('api_version') : $api_version;
		$api_old = false;
		if (version_compare($api_version, '1.6', '<')) {
		    $api_old = true;
		}
		
// 		if ($api_old) {
	    if (!$api_old) {
		    $request_param['seller_id'] = $seller_id;
		    
		    $info = RC_DB::table('store_franchisee')->where('store_id', $seller_id)->first();
		    if ($info['status'] == 2 || $info['shop_close'] == 1) {
		        return array('shop_close' => 1);
		    }
		    $info['allow_use_quickpay'] = empty($allow_use_quickpay) ? 0 : 1;
		    //流程逻辑开始
		    // runloop 流
		    $response = array();
		    $response = RC_Hook::apply_filters('api_merchant_home_data_runloop', $response, $request_param);//mobile_home_adsense1
		    return $response;
		} else {
		    $where = array();
		    
		    $info = RC_DB::table('store_franchisee as sf')
		    ->leftJoin('store_category as sc', RC_DB::raw('sf.cat_id'), '=', RC_DB::raw('sc.cat_id'))
		    ->leftJoin('collect_store as cs', RC_DB::raw('sf.cat_id'), '=', RC_DB::raw('cs.store_id'))
		    ->select(RC_DB::raw('sf.*, sc.cat_name, count(cs.store_id) as follower, SUM(IF(cs.user_id = '.$user_id.',1,0)) as is_follower'))
		    ->where(RC_DB::raw('sf.status'), 1)->where(RC_DB::raw('sf.store_id'), $seller_id)
		    ->first();
		    $store_config = array(
		        'shop_title'                => '', // 店铺标题
		        'shop_kf_mobile'            => '', // 客服手机号码
		        'shop_kf_email'             => '', // 客服邮件地址
		        'shop_logo'                 => '', // 默认店铺页头部LOGO
		        'shop_banner_pic'           => '', // banner图
		        'shop_trade_time'           => '', // 营业时间
		        'shop_description'          => '', // 店铺描述
		        'shop_notice'               => '', // 店铺公告
		    );
		    $config = RC_DB::table('merchants_config')->where('store_id', $seller_id)->select('code', 'value')->get();
		    foreach ($config as $key => $value) {
		        $store_config[$value['code']] = $value['value'];
		    }
		    $info = array_merge($info, $store_config);
		    
		    
		    if(substr($info['shop_logo'], 0, 1) == '.') {
		        $info['shop_logo'] = str_replace('../', '/', $info['shop_logo']);
		    }
		    
		    $goods_db = RC_Model::model('goods/goods_model');
		    $gfield = 'count(*) as count, SUM(IF(store_new=1, 1, 0)) as new_goods, SUM(IF(store_best=1, 1, 0)) as best_goods, SUM(IF(store_hot=1, 1, 0)) as hot_goods';
		    $count_where = array('store_id' => $seller_id, 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0);
		    
		    $count_where['review_status'] = array('gt' => 2);
		    
		    $goods_count = $goods_db->field($gfield)->where($count_where)->find();
		    
		    $distance = (!empty($location['latitude']) && !empty($location['longitude']) && !empty($info)) ? $this->getDistance($info['latitude'], $info['longitude'], $location['latitude'], $location['longitude']) : null;
		    
		    $province_name = ecjia_region::getRegionName($info['province']);
			$city_name = ecjia_region::getRegionName($info['city']);
			$district_name = ecjia_region::getRegionName($info['district']);
			$street_name = ecjia_region::getRegionName($info['street']);
		    
		    //TODO ::增加优惠活动缓存
		    $store_options = array(
		        'store_id' => $info['store_id']
		    );
		    $favourable_result = RC_Api::api('favourable', 'store_favourable_list', $store_options);
		    if (!empty($favourable_result)) {
		        $favourable_list = array();
		        foreach ($favourable_result as $val) {
		            if ($val['act_range'] == '0') {
		                $favourable_list[] = array(
		                    'name' => $val['act_name'],
		                    'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
		                    'type_label' => $val['act_type'] == '1' ? __('满减', 'merchant') : __('满折', 'merchant'),
		                );
		            } else {
		                $act_range_ext = explode(',', $val['act_range_ext']);
		                switch ($val['act_range']) {
		                    case 1 :
		                        $favourable_list[] = array(
		                        'name' => $val['act_name'],
		                        'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
		                        'type_label' => $val['act_type'] == '1' ? __('满减', 'merchant') : __('满折', 'merchant'),
		                        );
		                        break;
		                    case 2 :
		                        $favourable_list[] = array(
		                        'name' => $val['act_name'],
		                        'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
		                        'type_label' => $val['act_type'] == '1' ? __('满减', 'merchant') : __('满折', 'merchant'),
		                        );
		                        break;
		                    case 3 :
		                        $favourable_list[] = array(
		                        'name' => $val['act_name'],
		                        'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
		                        'type_label' => $val['act_type'] == '1' ? __('满减', 'merchant') : __('满折', 'merchant'),
		                        );
		                        break;
		                    default:
		                        break;
		                }
		            }
		        }
		    }
		    
		    /*店铺闪惠活动列表*/
		    $quickpay_activity_list = array();
		  
		    $quickpay_activity_list = RC_Api::api('quickpay', 'quickpay_activity_list', array('store_id' => $info['store_id']));
		  
		    if (is_ecjia_error($quickpay_activity_list)) {
		    	return $quickpay_activity_list;
		    }
		    
		    $quickpay_activity_list_new = array();
		    if (!empty($quickpay_activity_list['list'])) {
		    	foreach($quickpay_activity_list['list'] as $key => $val) {
		    		$quickpay_activity_list_new[] = array(
	    				'activity_id' 			=> $val['id'],
	    				'title' 	  			=> $val['title'],
	    				'activity_type' 		=> $val['activity_type'],
	    				'label_activity_type' 	=> $val['label_activity_type'],
	    				'limit_time_type'		=> $val['limit_time_type'],
	    				'limit_time_weekly'		=> $val['limit_time_weekly_str'],
	    				'limit_time_daily'		=> $val['limit_time_daily_str'],
	    				'limit_time_exclude'	=> $val['limit_time_exclude'],
		    		);
		    	}	
		    }
		    if (isset($location['latitude']) && !empty($location['latitude']) && isset($location['longitude']) && !empty($location['longitude'])) {
    			$geohash         = RC_Loader::load_app_class('geohash', 'store');
    			$geohash_code    = $geohash->encode($location['latitude'] , $location['longitude']);
    			$store_id_group  = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code, 'city_id' => $city_id));
    		}
    		
    		RC_Loader::load_app_func('merchant', 'merchant');
    		$info['trade_time'] = get_store_trade_time($info['store_id']);
		    $seller_info = array(
		        'id'				=> $info['store_id'],
		    	'allow_use_quickpay' => empty($allow_use_quickpay) ? 0 : 1,
		        'seller_name'		=> $info['merchants_name'],
		        'seller_logo'		=> empty($info['shop_logo']) ?  '' : RC_Upload::upload_url($info['shop_logo']),
		        'seller_banner'		=> empty($info['shop_banner_pic']) ?  '' : RC_Upload::upload_url($info['shop_banner_pic']),
		        'seller_qrcode'		=> with(new Ecjia\App\Mobile\Qrcode\GenerateMerchant($info['store_id'], empty($info['shop_logo']) ?  '' : RC_Upload::upload_url($info['shop_logo'])))->getQrcodeUrl(),
		        'seller_category'	=> $info['cat_name'],
		        'shop_name'			=> $info['company_name'],
		        'shop_address'		=> $province_name.$city_name.$district_name.$street_name.' '.$info['address'],
		        'telephone'			=> $info['shop_kf_mobile'],
		        'seller_qq'			=> $info['shop_kf_qq'],
		        'seller_description'	=> $info['shop_description'],
		        'seller_notice'		=> $info['shop_notice'],
		        'manage_mode'       => $info['manage_mode'],
		        'follower'			=> $info['follower'],
		        'is_follower'		=> $info['is_follower'],
		        'location'			=> array(
		            'longitude' => $info['longitude'],
		            'latitude'	=> $info['latitude'],
		            'distance'	=> $distance,
		        ),
		        'distance'	=> $distance,
		        'goods_count'		=> array(
		            'count'			=> $goods_count['count'],
		            'new_goods'		=> $goods_count['new_goods'],
		            'best_goods'	=> $goods_count['best_goods'],
		            'hot_goods'		=> $goods_count['hot_goods'],
		        ),
		        'comment' 	=> array(
		            'comment_goods'			=> '100%',
		            'comment_server'		=> '100%',
		            'comment_delivery'		=> '100%',
		        ),
		        'favourable_list'	=> $favourable_list,
		    	'quickpay_activity_list' => $quickpay_activity_list_new,
		        'label_trade_time'	=> $info['trade_time'],
		        'delivery_range'    => in_array($info['store_id'], $store_id_group) ? 'in' : 'out',
		    );
		    
		    return $seller_info;
		}
		
	}
	
	public function filter_merchant_adsense_group_data($data) {
		return collect($data)->map(function($item, $key) {
			return [
			'image' => $item['ad_img'],
			'text' => $item['ad_name'],
			'url' => $item['ad_link'],
			];
		})->toArray();
	}
	
	public function cycleimage_data($response, $request_params)
	{
		$request = royalcms('request');
	
		$device_client = $request->header('device-client', 'iphone');
	
		if ($device_client == 'android') {
			$client = Ecjia\App\Adsense\Client::ANDROID;
		} elseif ($device_client == 'h5') {
			$client = Ecjia\App\Adsense\Client::H5;
		} else {
			$client = Ecjia\App\Adsense\Client::IPHONE;
		}
	
		$cycleimageDatas = RC_Api::api('adsense',  'cycleimage_merchant', [
				'code'     => 'home_cycleimage',
				'client'   => $client,
				'store_id' => $request_params['seller_id']
				]);
	
		$player_data = array();
		foreach ($cycleimageDatas as $val) {
			$player_data[] = array(
					'photo' => array(
							'small'      => $val['image'],
							'thumb'      => $val['image'],
							'url'        => $val['image'],
					),
					'url'        => $val['url'],
					'description'=> $val['text'],
			);
		}
	
		$response['player'] = $player_data;
	
		return $response;
	}
	
	/**
	 * 计算两组经纬度坐标 之间的距离
	 * @param params ：lat1 纬度1； lng1 经度1； lat2 纬度2； lng2 经度2； len_type （1:m or 2:km);
	 * @return return m or km
	 */
	private function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 1) {
		// 	define('EARTH_RADIUS', 6378.137);//地球半径
		// 	define('PI', 3.1415926);
		$EARTH_RADIUS = 6378.137;
		$PI = 3.1415926;
		$radLat1 = $lat1 * $PI / 180.0;
		$radLat2 = $lat2 * $PI / 180.0;
		$a = $radLat1 - $radLat2;
		$b = ($lng1 * $PI / 180.0) - ($lng2 * $PI / 180.0);
		$s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
		$s = $s * $EARTH_RADIUS;
		$s = round($s * 1000);
		if ($len_type > 1) {
			$s /= 1000;
		}
	
		return round($s, $decimal);
	}
	

	public function mobile_menu_data($response, $request_params) {
		$request = royalcms('request');
	
		$city_id	= $request->input('city_id', 0);
	
		$device_client = $request->header('device-client', 'iphone');
	
		if ($device_client == 'android') {
			$client = Ecjia\App\Adsense\Client::ANDROID;
		} elseif ($device_client == 'h5') {
			$client = Ecjia\App\Adsense\Client::H5;
		} else {
			$client = Ecjia\App\Adsense\Client::IPHONE;
		}
	
		$shortcutDatas = RC_Api::api('adsense',  'shortcut_merchant', [
				'code'     => 'home_shortcut',
				'client'   => $client,
				'store_id' => $request_params['seller_id']
				]);
	
		$response['mobile_menu'] = $shortcutDatas;
		return $response;
	}
	
	public function promote_goods_data($response, $request) {
	
		$promote_goods_data = array();
		$order_sort         = array('g.sort_order' => 'ASC', 'goods_id' => 'DESC');
		$filter = array(
				'intro'	  => 'promotion',
				'sort'	  => $order_sort,
				'page'	  => 1,
				'size'	  => 6,
				'store_id' => $request['seller_id'],
		);
	
		$result = RC_Api::api('goods', 'goods_list', $filter);
		
		if ( !empty($result['list']) ) {
			RC_Loader::load_app_func('admin_goods', 'goods');
			foreach ( $result['list'] as $key => $val ) {
				$properties = get_goods_properties($val['goods_id']); // 获得商品的规格和属性
				$promote_goods_data[] = array(
						'id'		                => intval($val['goods_id']),
						'goods_id'	                => intval($val['goods_id']),
						'name'		                => $val['goods_name'],
						'market_price'	            => $val['market_price'],
						'shop_price'	            => $val['shop_price'],
						'promote_price'	            => $val['promote_price'],
						'manage_mode'               => $val['manage_mode'],
						'unformatted_shop_price' 	=> $val['unformatted_shop_price'],
						'unformatted_promote_price' => $val['unformatted_promote_price'],
						'promote_start_date'        => $val['promote_start_date'],
						'promote_end_date'          => $val['promote_end_date'],
						'img'                       => array(
								'small' => $val['goods_thumb'],
								'thumb' => $val['goods_img'],
								'url'	=> $val['original_img'],
						),
						'properties'      => $properties['pro'],
						'specification'   => $properties['spe'],
				);
			}
		}
	
		$response['promote_goods'] = $promote_goods_data;
		return $response;
	}
	

	public function new_goods_data($response, $request) {
		$new_goods_data = array();
	
		$order_sort = array('g.sort_order' => 'ASC', 'goods_id' => 'DESC');
		$filter     = array(
				'store_intro'	=> 'new',
				'store_id' => $request['seller_id'],
				'sort'	=> $order_sort,
				'page'	=> 1,
				'size'	=> 6,
	
		);
	
		$result = RC_Api::api('goods', 'goods_list', $filter);
		if ( !empty($result['list']) ) {
			RC_Loader::load_app_func('admin_goods', 'goods');
			foreach ( $result['list'] as $key => $val ) {
				$properties = get_goods_properties($val['goods_id']); // 获得商品的规格和属性
				$new_goods_data[] = array(
						'id'            => intval($val['goods_id']),
						'goods_id'      => intval($val['goods_id']),           //多商铺中不用，后期删除
						'name'          => $val['goods_name'],
						'manage_mode'   => $val['manage_mode'],
						'unformatted_shop_price' 	=> $val['unformatted_shop_price'],
						'unformatted_promote_price' => $val['unformatted_promote_price'],
						'market_price'	=> $val['market_price'],
						'shop_price'	=> $val['shop_price'],
						'promote_price'	=> $val['promote_price'],
						'img'           => array(
								'small' => $val['goods_thumb'],
								'thumb' => $val['goods_img'],
								'url'	=> $val['original_img'],
						),
						'properties'      => $properties['pro'],
						'specification'   => $properties['spe'],
				);
			}
		}
	
		$response['new_goods'] = $new_goods_data;
		return $response;
	}
	
	public function group_goods_data($response, $request) {
		$api_version = royalcms('request')->header('api-version');
		if (version_compare($api_version, '1.18', '>=')) {
			$store_id = $request['seller_id'];
	
			$db_goods_activity = RC_DB::table('goods_activity as ga')
			->leftJoin('goods as g', RC_DB::raw('ga.goods_id'), '=', RC_DB::raw('g.goods_id'));
	
			$db_goods_activity
			->where(RC_DB::raw('ga.act_type'),GAT_GROUP_BUY)
			->where(RC_DB::raw('ga.start_time'),'<=', RC_Time::gmtime())
			->where(RC_DB::raw('ga.end_time'),'>=', RC_Time::gmtime())
			->whereRaw('g.goods_id is not null')
			->where(RC_DB::raw('g.is_delete'),0)
			->where(RC_DB::raw('g.is_on_sale'),1)
			->where(RC_DB::raw('g.is_alone_sale'),1);
	
			if (!empty($store_id)) {
				$db_goods_activity->where(RC_DB::raw('g.store_id'), $store_id);
			} else {
				$response['group_goods'] = array();
				return $response;
			}
	
			if (ecjia::config('review_goods') == 1) {
				$db_goods_activity->where(RC_DB::raw('g.review_status'), '>', 2);
			}
			$res = $db_goods_activity
			->select(RC_DB::raw('ga.*,g.shop_price, g.market_price, g.goods_brief, g.goods_thumb, g.goods_img, g.original_img'))
			->take(6)->orderBy(RC_DB::raw('ga.act_id'),'desc')
			->get();
	
			$group_goods_data = array();
			if (!empty($res)) {
				foreach ($res as $val) {
					$ext_info = unserialize($val['ext_info']);
					$price_ladder = $ext_info['price_ladder'];
					if (!is_array($price_ladder) || empty($price_ladder)) {
						$price_ladder = array(array('amount' => 0, 'price' => 0));
					} else {
						foreach ($price_ladder AS $key => $amount_price) {
							$price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
						}
					}
	
					$cur_price  = $price_ladder[0]['price'];    // 初始化
					$group_goods_data[] = array(
							'id'						=> $val['goods_id'],
							'name'						=> $val['goods_name'],
							'market_price'				=> $val['market_price'],
							'formated_market_price'		=> price_format($val['market_price'], false),
							'shop_price'				=> $val['market_price'],
							'formated_shop_price'		=> price_format($val['market_price'], false),
							'promote_price'				=> $cur_price,
							'formated_promote_price'	=> price_format($cur_price, false),
							'promote_start_date'		=> RC_Time::local_date('Y/m/d H:i:s', $val['start_time']),
							'promote_end_date'			=> RC_Time::local_date('Y/m/d H:i:s', $val['end_time']),
							'img'						=> array(
									'small'	=> empty($val['goods_thumb']) ? '' : RC_Upload::upload_url($val['goods_thumb']),
									'thumb'	=> empty($val['goods_img']) ? '' 	: RC_Upload::upload_url($val['goods_img']),
									'url'	=> empty($val['original_img']) ? '' : RC_Upload::upload_url($val['original_img'])
							),
							'goods_activity_id'			=> $val['act_id'],
							'activity_type'				=> 'GROUPBUY_GOODS'
									);
				}
			}
	
		} else {
			$group_goods_data = array();
		}
	
		$response['group_goods'] = $group_goods_data;
		return $response;
	}
	
	public function mobile_home_adsense_group($response, $request_params) {
		$request = royalcms('request');
	
		$device_client = $request->header('device-client', 'iphone');
	
		if ($device_client == 'android') {
			$client = Ecjia\App\Adsense\Client::ANDROID;
		} elseif ($device_client == 'h5') {
			$client = Ecjia\App\Adsense\Client::H5;
		} else {
			$client = Ecjia\App\Adsense\Client::IPHONE;
		}
	
		$mobile_home_adsense_group = RC_Api::api('adsense',  'adsense_group_merchant', [
				'code'     => 'home_group',
				'client'   => $client,
				'store_id' => $request_params['seller_id']
				]);
		 
		$response['adsense_group'] = $mobile_home_adsense_group;
	
		return $response;
	}
	
	public function store_fans_visit($response, $request_params) {
	    
	    RC_Api::api('customer', 'store_fans_visit', [
	        'user_id'  => $_SESSION['user_id'],
	        'store_id' => $request_params['seller_id'],
	        'longitude'=> $request_params['location']['longitude'],
	        'latitude' => $request_params['location']['latitude'],
	    ]);
	    
	    return $response;
	}
}

// RC_Hook::add_filter('api_merchant_home_data_runloop', 'cycleimage_data', 10, 2);
// RC_Hook::add_filter('api_merchant_home_data_runloop', 'mobile_menu_data', 10, 2);
// RC_Hook::add_filter('api_merchant_home_data_runloop', 'promote_goods_data', 10, 2);
// RC_Hook::add_filter('api_merchant_home_data_runloop', 'new_goods_data', 10, 2);
// RC_Hook::add_filter('api_merchant_home_data_runloop', 'group_goods_data', 10, 2);
// RC_Hook::add_filter('api_merchant_home_data_runloop', 'mobile_home_adsense_group', 10, 2);
// RC_Hook::add_filter('api_merchant_home_data_runloop', 'group_goods_data', 10, 2);
// RC_Hook::add_filter('api_merchant_home_data_runloop', 'mobilebuy_goods_data', 10, 2);
// RC_Hook::add_filter('api_merchant_home_data_runloop', 'topic_data', 10, 2);

// end
