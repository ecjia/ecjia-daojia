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
 * 店铺列表接口
 * @author
 */
class store_store_list_api extends Component_Event_Api {
	/**
	 *
	 * @param array $options
	 * @return  array
	 */
	public function call (&$options) {
        if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}

		return $this->store_list($options);
	}

    /**
	 *  获取店铺列表
	 *
	 * @access  private
	 * @return  array       $order_list     订单列表
	 */
	private function store_list($filter)
	{
		$where = array();
		$where['ssi.status'] = 1;
		//$where['ssi.store_id'] = array(0);
		
		/* 商家列表缓存key*/
		$cache_key = 'store-list';
		
		/* 商品分类*/
		if (isset($filter['goods_category']) && !empty($filter['goods_category'])) {
			RC_Loader::load_app_class('goods_category', 'goods', false);

			$key = 'category-children-'.$filter['goods_category'];
			$category_children_cachekey = sprintf('%X', crc32($key));
			$children = RC_Cache::app_cache_get($category_children_cachekey, 'goods');
			
			if (empty($children)) {
				$children = goods_category::get_children($filter['goods_category']);
				RC_Cache::app_cache_set($category_children_cachekey, $children, 'goods');
			}

			$seller_group_where = array(
					"(". $children ." OR ".goods_category::get_extension_goods($children, 'goods_id').")",
					'is_on_sale'	=> 1,
					'is_alone_sale' => 1,
					'is_delete'		=> 0,
					'review_status'	=> array('gt' => 2),
			);

			$seller_group = RC_Model::model('goods/goods_viewmodel')->join(null)
									->where($seller_group_where)
									->get_field('store_id', true);

			if (!empty($seller_group)) {
				$seller_group = array_merge(array(0), $seller_group);
				$where['ssi.store_id'] = $seller_group = array_unique($seller_group);
			} else {
				$where['ssi.store_id'] = array(0);
			}
			
			$cache_key .= '-goods_category-' . $filter['goods_category'];
		}

		/* 关键字*/
		if (!empty($filter['keywords'])) {
			$cache_key .= '-keywords-' . $filter['keywords'];
			$where[]    = '(merchants_name like "%'.$filter['keywords'].'%" or goods_name like "%'.$filter['keywords'].'%")';
		}

		/* 店铺分类*/
		if (isset($filter['seller_category']) && !empty($filter['seller_category'])) {
			$cache_key           .= '-seller_category-' . $filter['seller_category'];
			$where['ssi.cat_id']  = $filter['seller_category'];
		}


		/* 获取当前经纬度周边的geohash值*/
		if (isset($filter['geohash']) && !empty($filter['geohash'])) {
			/* 载入geohash类*/
			$geohash	                 = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code                = substr($filter['geohash'], 0, 5);
			$geohash_group               = $geohash->geo_neighbors($geohash_code);
			$store_geohash               = array_merge(array($geohash_code), $geohash_group);
			$where['left(geohash, 5)']   = $store_geohash;
			$cache_key                   .= '-geohash-' . $filter['geohash'];
		}
		
		/* 店铺条件*/
		if (isset($filter['store_id']) && !empty($filter['store_id'])) {
			$filter['store_id'] = array_merge(array(0), $filter['store_id']);
			if (!empty($where['ssi.store_id'])) {
				$where['ssi.store_id'] = array_intersect($where['ssi.store_id'], $filter['store_id']);
			} else {
				$where['ssi.store_id'] = $filter['store_id'];
			}
			
			/* 缓存对象*/
			if (is_array($where['ssi.store_id'])) {
				foreach ($where['ssi.store_id'] as $v) {
					$cache_key .= '-store-' . $v;
				}
			}
		}

		$where['shop_close'] = '0';

		if (isset($filter['limit']) && $filter['limit'] == 'all') {
			$cache_key .= '-limit-all';
		} else {
		    $cache_key .= '-size-' . $filter['size'] . '-page-' . $filter['page'];
		}
		
		$store_franchisee_db = RC_Model::model('store/orm_store_franchisee_model');
		/* 储存商品列表缓存key*/
		$fomated_cache_key = $store_franchisee_db->create_cache_key_array($cache_key, 2880);
		$store_list = $store_franchisee_db->get_cache_item($fomated_cache_key);
		
		if (empty($store_list)) {
			$db_store_franchisee = RC_Model::model('store/store_franchisee_viewmodel');
			$count = $db_store_franchisee->join(array('goods'))->where($where)->count('distinct(ssi.store_id)');
			
			//加载分页类
			RC_Loader::load_sys_class('ecjia_page', false);
			//实例化分页
			$page_row = new ecjia_page($count, $filter['size'], 6, '', $filter['page']);
			
			$limit = $filter['limit'] == 'all' ? null : $page_row->limit();
			
			$seller_list = array();
			
			$field = 'ssi.*, sc.cat_name, count(cs.store_id) as follower';
			$result = $db_store_franchisee->join(array('collect_store', 'store_category', 'goods'))->field($field)->where($where)->limit($limit)->group('ssi.store_id')->order(array())->select();
			
			if (!empty($result)) {
			    RC_Loader::load_app_func('merchant', 'merchant');
				foreach($result as $k => $val){
					$store_config = array(
							'shop_kf_mobile'            => '', // 客服手机号码
							'shop_logo'                 => '', // 默认店铺页头部LOGO
							'shop_banner_pic'           => '', // banner图
							'shop_trade_time'           => '', // 营业时间
							'shop_description'          => '', // 店铺描述
							'shop_notice'               => '', // 店铺公告
			
					);
					$config = RC_DB::table('merchants_config')->where('store_id', $val['store_id'])->select('code', 'value')->get();
					foreach ($config as $key => $value) {
						$store_config[$value['code']] = $value['value'];
					}
					$result[$k] = array_merge($result[$k], $store_config);
			
					if(substr($result[$k]['shop_logo'], 0, 1) == '.') {
						$result[$k]['shop_logo'] = str_replace('../', '/', $val['shop_logo']);
					}
					$seller_list[] = array(
							'id'				 => $result[$k]['store_id'],
							'seller_name'		 => $result[$k]['merchants_name'],
							'seller_category'	 => $result[$k]['cat_name'],//后期删除
							'manage_mode'		 => empty($result[$k]['manage_mode']) ? 'join' : $result[$k]['manage_mode'],
							'shop_logo'		     => empty($result[$k]['shop_logo']) ?  '' : RC_Upload::upload_url($result[$k]['shop_logo']),//后期增加
							'seller_logo'		 => empty($result[$k]['shop_logo']) ?  '' : RC_Upload::upload_url($result[$k]['shop_logo']),//后期删除
							'follower'			 => $result[$k]['follower'],
							'sort_order'		 => $result[$k]['sort_order'],
							'location' => array(
									'latitude'  => $result[$k]['latitude'],
									'longitude' => $result[$k]['longitude'],
							),
					        'province' => $result[$k]['province'] ? RC_DB::table('region')->where('region_id', $result[$k]['province'])->pluck('region_name') : '',
    					    'city' => $result[$k]['city'] ? RC_DB::table('region')->where('region_id', $result[$k]['city'])->pluck('region_name') : '',
    					    'district' => $result[$k]['district'] ? RC_DB::table('region')->where('region_id', $result[$k]['district'])->pluck('region_name') : '',
					        'address' => $result[$k]['address'],
							'label_trade_time'	 => get_store_trade_time($result[$k]['store_id']),
					        'seller_notice'      => $result[$k]['shop_notice'],
					);
				}
			}
			
			$store_list = array('seller_list' => $seller_list, 'page' => $page_row);
			
			$store_franchisee_db->set_cache_item($fomated_cache_key, $store_list, 2880);
		}
		return $store_list;
	}
}

// end
