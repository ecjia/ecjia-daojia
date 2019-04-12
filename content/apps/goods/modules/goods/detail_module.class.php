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
use \Ecjia\App\Goods\Models\GoodsModel;

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 单个商品的信息
 * @author royalwang
 */
class goods_detail_module extends api_front implements api_interface {

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
        //如果用户登录获取其session
		
        $goods_id = $this->requestData('goods_id', 0);
      
        $product_id = $this->requestData('product_id', 0);
        
        if (empty($goods_id)) {
        	return new ecjia_error('invalid_parameter', __('参数错误', 'goods'));
        }
		
        RC_Loader::load_app_class('groupbuy_activity', 'groupbuy', false);
        
        $object_id = $this->requestData('goods_activity_id', 0);
        
        //判断商品是否是团购商品
        
        list($is_groupbuy, $object_id) = $this->_is_groupbuy($object_id, $goods_id);
        
        /* 获得商品的信息 */
        RC_Loader::load_app_func('admin_goods', 'goods');
        
        $groupbuy_activity_desc = '';
        $groupbuy_price_ladder_str = '';
        $price_ladder_str = '';
        $price_ladder = [];
        if (!empty($object_id)) {
        	$group_buy = groupbuy_activity::group_buy_info($object_id);
        	if (!empty($group_buy)) {
        		$rec_type = 'GROUPBUY_GOODS';
        		$groupbuy_activity_desc = $group_buy['group_buy_desc'];
        		$price_ladder = $group_buy['price_ladder'];
        		if (!empty($price_ladder)) {
        			foreach ($price_ladder as $rows) {
                        $price_ladder_str .= sprintf(__('满%d份%s元，', 'goods'), $rows['amount'], $rows['price']);
        			}
        			$groupbuy_price_ladder_str = mb_substr($price_ladder_str, 0, -1);
        		}
        		
        	}else {
        		$rec_type = '';
        	}
        } else {
        	$rec_type = '';
        }
        
        /*商品基本信息*/
        $goods = get_goods_info($goods_id);
        if ($goods === false) {
           return new ecjia_error('does_not_exist', __('不存在的信息', 'goods'));
        } 
        
        if ($goods['brand_id'] > 0) {
        	$goods['goods_brand_url'] = build_uri('brand', array('bid' => $goods['brand_id']), $goods['goods_brand']);
        }
        /* 加入验证如果价格不存在，则为0 */
        $shop_price = $goods['shop_price'];
        $linked_goods = array();
        
        /*获得商品的规格和属性*/
        $properties = Ecjia\App\Goods\GoodsFunction::get_goods_properties($goods_id); 
        
        /* 更新点击次数 */
		$this->update_goods_click_count($goods_id);

        $data = $goods;
        
        //商品会员等级价
        $user_rank_prices = $this->get_user_rank_prices($goods_id, $shop_price);
        
        /*商品的相册*/
        $goods_gallery = $this->_getGoodsGallery($goods_id, $product_id);
        
        $data['rank_prices']     = !empty($shop_price) ? $user_rank_prices : 0;
        $data['pictures']        = $goods_gallery;
        $data['properties']      = $properties['pro'];
        $data['specification']   = $properties['spe'];
        //用户登录的话，有没收藏此商品
        $data['collected']       = $this->is_collect_goods($goods_id, $_SESSION['user_id']);
        
       	/*优惠活动获取*/
        $favourable_list = $this->get_favourable_list($goods, $rec_type);

        $data = ecjia_api::transformerData('GOODS', $data);
        //商品货品信息
        if (!empty($data['specification'])) {
        	$GoodsProductPrice = new \Ecjia\App\Goods\Product\GoodsProductPrice($goods_id);
        	
        	$GoodsProductPrice->setUserRank($_SESSION['user_rank']);
        	$GoodsProductPrice->setUserRankDiscount($_SESSION['discount']);
        	$GoodsProductPrice->setGoodsSpecification($data['specification']);
        	$GoodsProductPrice->setGoodsInfo();
        	$GoodsProductPrice->getGoodsProducts();
        	
        	$product_specification = $GoodsProductPrice->getData();
        	 
        	$data['product_specification'] = $product_specification;
        	
        } else {
        	$data['product_specification'] = [];
        }
        
        $data['unformatted_shop_price'] = $goods['shop_price'];
        
        /*如果用户登录，获取该会员的等级对应的商品的shop_price*/
        if ($_SESSION['user_id'] > 0 && !empty($user_rank_prices)) {
        	$user_info = RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->first();
        	/* 取得用户等级 */
        	if ($user_info['user_rank'] == 0) {
        		// 非特殊等级，根据成长值计算用户等级（注意：不包括特殊等级）
        		$user_rank_info = RC_DB::table('user_rank')->where('special_rank', 0)->where('min_points', '<=', $user_info['rank_points'])->where('max_points', '>', $user_info['rank_points'])->first();
        	} else {
        		// 特殊等级
        		$user_rank_info = RC_DB::table('user_rank')->where('rank_id', $user_info['user_rank'])->first();
        	}
        	foreach ($user_rank_prices as $key => $val) {
        		if ($key == $user_rank_info['rank_id']) {
        			$data['shop_price'] = $val['price'];
        			$data['unformatted_shop_price'] = $val['unformatted_price'];
        			break;
        		}
        	}
        }
        
        $groupbuy_info = [];        
        if ($rec_type == 'GROUPBUY_GOODS') {
        	/* 取得团购活动信息 */
        	$data['promote_price'] 			= $group_buy['cur_price'];
        	$data['formated_promote_price'] = $group_buy['formated_cur_price'];
        	$data['promote_start_date'] 	= $group_buy['formated_start_date'];
        	$data['promote_end_date'] 		= $group_buy['formated_end_date'];
        	$activity_type 					= 'GROUPBUY_GOODS';
        	$groupbuy_info = array(
        			'activity_id'				=> $group_buy['act_id'],
        			'deposit'					=> empty($group_buy['deposit']) ? 0 : $group_buy['deposit'],
        			'formated_deposit'			=> $group_buy['formated_deposit'],
        			'resitrict_num'				=> empty($group_buy['restrict_amount']) ? 0 : $group_buy['restrict_amount'],
        			'left_num'					=> $group_buy['left_num'],
        			'groupbuy_activity_desc'	=> empty($groupbuy_activity_desc) ? '' : $groupbuy_activity_desc,
        			'groupbuy_price_ladder'		=> empty($groupbuy_price_ladder_str) ? '' : $groupbuy_price_ladder_str,
        			'price_ladder'				=> $price_ladder,
        	);
        } else {
        	/* 判断是否有促销价格*/
        	$price = ($data['unformatted_shop_price'] > $goods['promote_price_org'] && $goods['promote_price_org'] > 0) ? $goods['promote_price_org'] : $data['unformatted_shop_price'];
        	$activity_type = ($data['unformatted_shop_price'] > $goods['promote_price_org'] && $goods['promote_price_org'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
        }
        $data['groupbuy_info'] = $groupbuy_info;

        /* 计算节约价格*/
        $saving_price = ($data['unformatted_shop_price'] - $price) > 0 ? $data['unformatted_shop_price'] - $price : 0;
        $data['is_groupbuy']	= $is_groupbuy;
        $data['activity_type']	= $activity_type;
        $data['goods_activity_id'] = empty($object_id) ? 0 : intval($object_id);
        $data['saving_price']	= $saving_price;
        $data['formatted_saving_price'] = sprintf(__('已省%s元', 'goods'), $saving_price);
        if ($price < $data['unformatted_shop_price'] && isset($price)) {
        	$data['promote_price'] = $price;
        	$data['formated_promote_price'] = price_format($price);
        	$data['promote_start_date'] = RC_Time::local_date('Y/m/d H:i:s O', $goods['promote_start_date']);
        	$data['promote_end_date']	= RC_Time::local_date('Y/m/d H:i:s O', $goods['promote_end_date']);
        }

        $data['rec_type'] = empty($rec_type) ? $activity_type : 'GROUPBUY_GOODS';
        $data['object_id'] = empty($object_id) ? 0 : $object_id;
        $data['promote_user_limited'] = $activity_type == 'PROMOTE_GOODS' ? $goods['promote_user_limited'] : 0;

        if (ecjia_config::has('mobile_touch_url')) {
        	$data['goods_url'] = ecjia::config('mobile_touch_url').'index.php?m=goods&c=index&a=show&goods_id='.$goods_id.'&hidenav=1&hidetab=1';
        } else {
        	$data['goods_url'] = null;
        }
        
        $data['favourable_list'] = $favourable_list;

       //商品详情页猜你喜欢 
        $options = array(
        		'cat_id'	=> $data['cat_id'],
        		'intro'		=> 'hot',
        		'page'		=> 1,
        		'size'		=> 8,
        		'store_id'	=> $goods['store_id'],
        );
        $data['related_goods'] = $this->_related_goods($options);

        //多店铺的内容
        $data['seller_id'] = $goods['store_id'];
        if ($goods['store_id'] > 0) {
        	$info = Ecjia\App\Store\StoreFranchisee::StoreFranchiseeInfo(array('status' => 1, 'store_id' => $goods['store_id'], 'field' => 'sf.*, sc.cat_name'));
            //营业时间
            $info['trade_time']    = Ecjia\App\Store\StoreFranchisee::GetStoreTradetime($goods['store_id']);
            
            $store_config = array(
                'shop_kf_mobile'            => '', // 客服手机号码
                'shop_logo'                 => '', // 默认店铺页头部LOGO
                'shop_banner_pic'           => '', // banner图
                'shop_trade_time'           => '', // 营业时间
                'shop_description'          => '', // 店铺描述
                'shop_notice'               => '', // 店铺公告
            );
            $config = RC_DB::table('merchants_config')->where('store_id', $goods['store_id'])->select('code','value')->get();
            foreach ($config as $key => $value) {
                $store_config[$value['code']] = $value['value'];
            }
            $info = array_merge($info, $store_config);
        
            
        	if(substr($info['shop_logo'], 0, 1) == '.') {
        		$info['shop_logo'] = str_replace('../', '/', $info['shop_logo']);
        	}
        	$db_goods = RC_Model::model('goods/goods_model');
        	$goods_count = $db_goods->where(array('store_id' => $data['seller_id'], 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0))->count();

        	$follower_count = RC_DB::table('collect_store')->where('store_id', $data['seller_id'])->count();

        	$data['merchant_info'] = array(
        		'seller_id'			=> $info['store_id'],
        		'seller_name'		=> $info['merchants_name'],
        		'shop_logo'		    => !empty($info['shop_logo']) ? RC_Upload::upload_url().'/'.$info['shop_logo'] : '',
        		'store_service_phone'=> !empty($info['shop_kf_mobile']) ? $info['shop_kf_mobile'] : '',
        		'goods_count'		=> $goods_count,
        	   	'manage_mode'       => $info['manage_mode'],
        		'label_trade_time'	=> $info['trade_time'],
 				'follower'			=> $follower_count,
        		'comment' 			=> array(
        			'comment_goods' 	=> '100%',
        			'comment_server'	=> '100%',
        			'comment_delivery'	=> '100%',
        		)
        	);
        }
        $data['seller_name'] = $info['merchants_name'];
        $shop_name = empty($info['merchants_name']) ? ecjia::config('shop_name') : $info['merchants_name'];
        $data['server_desc'] = sprintf(__('由%s发货并提供售后服务', 'goods'), $shop_name);

        /* 分享链接*/
        $data['share_link'] = '';
        $mobile_touch_url = ecjia::config('mobile_touch_url');
        if (!empty($mobile_touch_url)) {
        	/*商品分享链接*/
        	$data['share_link'] = ecjia::config('mobile_touch_url').'index.php?m=goods&c=index&a=show&goods_id='.$goods_id.'&hidenav=1&hidetab=1';
        } else {
        	$data['share_link'] = null;
        }
        $data['goods_brief'] = $goods['goods_brief'];
        
		//商店设置市场价不显示时，商品详情市场价返回空字符
		if (ecjia::config('show_marketprice') == '0') {
			$data['market_price'] = '';
		}
		//商品货号是否显示
		if (ecjia::config('show_goodssn') == '1') {
			$arr_goods_sn = array('name' => __('商品货号', 'goods'), 'value' => $data['goods_sn']);
			array_push($data['properties'], $arr_goods_sn); 
		} 
		//商品重量是否显示
		if (ecjia::config('show_goodsweight') == '1') {
			$arr_goods_weight = array('name' => __('商品重量', 'goods'), 'value' => $data['goods_weight']);
			array_push($data['properties'], $arr_goods_weight);
			$data['goods_weight'] = '';
		} else {
			$data['goods_weight'] = '';
		}
		//商品库存是否显示
		if (ecjia::config('show_goodsnumber') == '1') {
			$arr_goods_number = array('name' => __('商品库存', 'goods'), 'value' => $data['goods_number']);
			array_push($data['properties'], $arr_goods_number);
		} 
		//商品上架时间是否显示
		if (ecjia::config('show_addtime') == '1') {
			$arr_goods_addtime = array('name' => __('商品上架时间', 'goods'), 'value' => $data['add_time']);
			array_push($data['properties'], $arr_goods_addtime);
			$data['add_time'] = '';
		} else {
			$data['add_time'] = '';
		}
		
		//判断货品，是货品，替换部分基本信息字段
		if ($product_id > 0) {
			$data = $this->_formate_data($product_id, $data);
		}
		
		
		
        return $data;
    }
	
	/**
	 * 获得指定商品的各会员等级对应的价格
	 *
	 * @access public
	 * @param integer $goods_id
	 * @return array
	 */
	private function get_user_rank_prices($goods_id, $shop_price) {
		$dbview = RC_DB::table('user_rank as ur')->leftJoin('member_price as mp', function ($join) use ($goods_id) {
			$join->where(RC_DB::raw('mp.user_rank'), '=', RC_DB::raw('ur.rank_id'))
			->where(RC_DB::raw('mp.goods_id'), '=', $goods_id);
		});
		
		$user_rank = $_SESSION['user_rank'];
		
		$res = $dbview->selectRaw("ur.rank_id, IFNULL(mp.user_price, ur.discount * $shop_price / 100) AS price, ur.rank_name, ur.discount")->whereRaw("ur.show_price = 1 OR ur.rank_id = $user_rank")->get();
			
		$arr = array();
		foreach ($res as $row) {
			$arr[$row['rank_id']] = array(
					'rank_name' => htmlspecialchars($row['rank_name']),
					'price' => ecjia_price_format($row['price'], false),
					'unformatted_price' => number_format( $row['price'], 2, '.', '')
			);
		}
		
		return $arr;
	}
	
	/**
	 * 商品基本信息
	 * @param int $goods_id
	 * @return array
	 */
	private function _get_goods_info($goods_id)
	{
		$goods = [];
		if (ecjia::config('review_goods') == '1') {
			$goods = GoodsModel::where('goods_id', $goods_id)->where('review_status', '>', 2)->first();
			$goods = $goods->toArray();
		} else {
			$goods = GoodsModel::where('goods_id', $goods_id)->first();
			$goods = $goods->toArray();
		}
		return $goods;
	}
	
	/**
	 * 判断是否是团购商品，团购活动id
	 * @param int $object_id
	 * @param int $goods_id
	 * @return array
	 */
	private function _is_groupbuy($object_id, $goods_id)
	{
		$is_groupbuy = 0;
		if (empty($object_id)) {
			$is_groupbuy_result = groupbuy_activity::is_groupbuy_goods($goods_id);
			if (!empty($is_groupbuy_result)) {
				$object_id = $is_groupbuy_result['act_id'];
				$is_groupbuy = 1;
			}
		}
		return [$is_groupbuy, $object_id];
	}
	
	/**
	 * 更新商品点击数
	 */
	private function update_goods_click_count($goods_id)
	{
		GoodsModel::where('goods_id', $goods_id)->increment('click_count', 1);
	}
	
	/**
	 * 用户有没收藏此商品
	 * @param int $goods_id
	 * @param int $user_id
	 * @return int
	 */
	private function is_collect_goods($goods_id, $user_id)
	{
		$collected = 0;
		if ($user_id > 0) {
			// 查询收藏夹状态
			$db_collect_goods = RC_DB::table('collect_goods');
			$count = $db_collect_goods->where('user_id', $user_id)->where('goods_id', $goods_id)->count();
			if ($count > 0) {
				$collected = 1;
			}
		}
		return $collected;
	}
	
	/**
	 * 获取优惠活动
	 * @param array $goods
	 * @param string $rec_type
	 * @return array
	 */
	private function get_favourable_list($goods, $rec_type)
	{
		$store_options = array(
				'store_id' => $goods['store_id']
		);
		$favourable_result = RC_Api::api('favourable', 'store_favourable_list', $store_options);
		$favourable_list = []; 
		if (empty($rec_type)) {
			if (!empty($favourable_result)) {
				foreach ($favourable_result as $val) {
					if ($val['act_range'] == '0') {
						$favourable_list[] = array(
								'name' => $val['act_name'],
								'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
								'type_label' => $val['act_type'] == '1' ? __('满减', 'goods') : __('满折', 'goods'),
						);
					} else {
						$act_range_ext = explode(',', $val['act_range_ext']);
						switch ($val['act_range']) {
							case 1 :
								if (in_array($goods['cat_id'], $act_range_ext)) {
									$favourable_list[] = array(
											'name' => $val['act_name'],
											'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
											'type_label' => $val['act_type'] == '1' ? __('满减', 'goods') : __('满折', 'goods'),
									);
								}
								break;
							case 2 :
								if (in_array($goods['brand_id'], $act_range_ext)) {
									$favourable_list[] = array(
											'name' => $val['act_name'],
											'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
											'type_label' => $val['act_type'] == '1' ? __('满减', 'goods') : __('满折', 'goods'),
									);
								}
								break;
							case 3 :
								if (in_array($goods['goods_id'], $act_range_ext)) {
									$favourable_list[] = array(
											'name' => $val['act_name'],
											'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
											'type_label' => $val['act_type'] == '1' ? __('满减', 'goods') : __('满折', 'goods'),
									);
								}
								break;
							default:
								break;
						}
					}
				}
			}
		}
		
		return $favourable_list;
	}
	
	
	private function _related_goods($options)
	{
		$goods_list = [];
		
		//用户端商品展示基础条件
		$filters = [
			'store_unclosed' 		=> 0,    //店铺未关闭的
			'is_delete'		 		=> 0,	 //未删除的
			'is_on_sale'	 		=> 1,    //已上架的
			'is_alone_sale'	 		=> 1,	 //单独销售的
			'review_status'  		=> 2,    //审核通过的
			'no_need_cashier_goods'	=> true, //不需要收银台商品
		];
		//是否展示货品
		if (ecjia::config('show_product') == 1) {
			$filters['product'] = true;
		}
		//定位附近店铺id
		if (!empty($options['store_id'])) {
			$filters['store_id'] = $options['store_id'];
		}
		//平台分类id
		if (!empty($options['cat_id'])) {
			$filters['cat_id'] = $options['cat_id'];
		}
		$filters['is_hot'] = 1;
		//会员等级价格
		$filters['user_rank'] = $_SESSION['user_rank'];
		$filters['user_rank_discount'] = $_SESSION['discount'];
		
		$filters['size'] = 8;
		$filters['page'] = 1;
		
		$collection = (new \Ecjia\App\Goods\GoodsSearch\GoodsApiCollection($filters))->getData();
		
		$goods_list = $collection['goods_list'];
		
		return $goods_list;
	}
	
	
	private function _getGoodsGallery($goods_id, $product_id = 0)
	{
		if (!empty($product_id)) {
			$p_row = RC_DB::table('goods_gallery')->where('goods_id', $goods_id)->where('product_id', $product_id)->select('img_id', 'img_url', 'thumb_url', 'img_desc', 'img_original', 'product_id')->where('goods_id', $goods_id)->take(ecjia::config('goods_gallery_number'))->get();
		}
		
		$g_row = RC_DB::table('goods_gallery')->where('product_id', 0)->select('img_id', 'img_url', 'thumb_url', 'img_desc', 'img_original', 'product_id')->where('goods_id', $goods_id)->take(ecjia::config('goods_gallery_number'))->get();
		
		$row = $g_row;
		
		if (!empty($p_row)) {
			$row = $p_row;
		} 
		
		$img_list_sort = $img_list_id = array();
		if (!empty($row)) {
			foreach ($row as $key => $gallery_img) {
				$desc_index = intval(strrpos($gallery_img['img_original'], '?')) + 1;
				!empty($desc_index) && $row[$key]['desc'] = substr($gallery_img['img_original'], $desc_index);
				$row[$key]['img_url'] = empty($gallery_img ['img_original']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($gallery_img ['img_original']);
				$row[$key]['thumb_url'] = empty($gallery_img ['img_url']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($gallery_img ['img_url']);
				$img_list_sort[$key] = $row[$key]['desc'];
				$img_list_id[$key] = $gallery_img['img_id'];
			}
			//先使用sort排序，再使用id排序。
			if ($row) {
				array_multisort($img_list_sort, $img_list_id, $row);
			}
		}
		return $row;
	}
	
	private function _formate_data($product_id, $data)
	{
		$product_specification = $data['product_specification'];
		if (!empty($product_specification)) {
			foreach ($product_specification as $val) {
				if ($product_id == $val['product_id']) {
					$product_info = $val;
				}
				unset($val['img']);
				unset($val['product_name']);
				$arr[] = $val;
			}
			$data['goods_sn'] 				= $product_info['product_sn'] ?: $data['goods_sn'];
			$data['goods_name'] 			= $product_info['product_name'] ?: $data['goods_name'];
			$data['goods_number'] 			= $product_info['product_number'] ?: $data['goods_number'];
			$data['shop_price'] 			= $product_info['formatted_product_shop_price'] ?: $data['shop_price'];
			$data['unformatted_shop_price'] = $product_info['product_shop_price'] ?: $data['unformatted_shop_price'];
			$data['promote_user_limited']   = $product_info['promote_user_limited'] ?: $data['promote_user_limited'];
			$data['promote_price'] 			= $product_info['promote_price'] ?: $data['shop_price'];
			$data['formated_promote_price'] = $product_info['formatted_promote_price'] ?: $data['formated_promote_price'];
			$data['promote_user_limited']   = $product_info['promote_user_limited'] ?: $data['promote_user_limited'];
			$data['img']   					= $product_info['img'] ?: $data['img'];
			$data['product_specification']  = $arr;
		}
		return $data;
	}
}

// end