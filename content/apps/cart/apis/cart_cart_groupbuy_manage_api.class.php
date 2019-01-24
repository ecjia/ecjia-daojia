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
 * @author zrl
 */
 
class cart_cart_groupbuy_manage_api extends Component_Event_Api {

    /**
     * @param
     *
     * @return array
     */
    public function call(&$options) {

        if (!isset($options['store_group']) || empty($options['store_group'])) {
            return new ecjia_error('location_error', '当前定位地址超出服务范围！');
        }

        if (!isset($options['goods_id']) || empty($options['goods_id'])) {
            return new ecjia_error('not_found_goods', '请选择您所需要的商品！');
        }

        return $this->addto_cart_groupbuy($options['goods_activity_id'], $options['goods_number'], $options['goods_spec'], $options['parent_id'], $options['store_group']);
    }
    
    /**
     * 
     * @param int $act_id  团购活动id
     * @param int $number  商品数量
     * @param array $spec  商品规格属性
     * @param int $parent  父级id
     * @param array $store_group 店铺ids
     * @return ecjia_error|int
     */
    private function addto_cart_groupbuy($act_id, $number = 1, $spec = array(), $parent = 0, $store_group = array())
    {
    	$_parent_id     = $parent;
    	if (is_array($spec)) {
    		sort($spec);
    	}
    	
    	RC_Loader::load_app_class('goods_info', 'goods', false);
    	
    	/* 查询：取得团购活动信息 */
    	RC_Loader::load_app_func('admin_goods', 'goods');
    	$group_buy = group_buy_info($act_id, $number);
    	if (empty($group_buy)) {
    		return new ecjia_error('gb_error', __('对不起，该团购活动不存在！'));
    	}
    
    	/* 查询：检查团购活动是否是进行中 */
    	$now = RC_Time::gmtime();
    	if ($now < $group_buy['start_date'] || $now > $group_buy['end_date']) {
    		return new ecjia_error('gb_error_status', __('对不起，该团购活动已经结束或尚未开始，现在不能参加！'));
    	}
    
    	/* 查询：取得团购商品信息 */
    	$goods = RC_DB::table('goods')
    				->where('goods_id', $group_buy['goods_id'])
    				->where('review_status', '>', 2)
    				->where('is_on_sale', 1)
    				->where('is_alone_sale', 1)
    				->where('is_delete', 0)->first();
    	
    	if (empty($goods)) {
    		return new ecjia_error('goods_error', __('对不起，团购商品不存在！'));
    	}
    	
    	$count = RC_DB::table('store_franchisee')->where('shop_close', '0')->where('store_id', $goods['store_id'])->count();
    	if(empty($count)){
    		return new ecjia_error('no_goods', __('对不起，该商品所属的店铺已经下线！'));
    	}
		
		/* 如果商品有规格则取规格商品信息 配件除外 */
		$prod = RC_DB::table('products')->where('goods_id', $group_buy['goods_id'])->first();
		
		//商品存在规格 是货品 检查该货品库存
		if (goods_info::is_spec($spec) && !empty($prod)) {
			$product_info = goods_info::get_products_info($group_buy['goods_id'], $spec);
			$is_spec = true;
		} else {
			$is_spec = false;
		}
		if (!isset($product_info) || empty($product_info)) {
			$product_info = array('product_number' => 0, 'product_id' => 0 , 'goods_attr'=>'');
		}
		
		/* 检查：库存 */
		if (ecjia::config('use_storage') == 1) {
			//检查：商品购买数量是否大于总库存
			if ($number > $goods['goods_number']) {
				return new ecjia_error('low_stocks', __('库存不足'));
			}
			//商品存在规格 是货品 检查该货品库存
			if ($is_spec) {
				if (!empty($spec)) {
					/* 取规格的货品库存 */
					if ($number > $product_info['product_number']) {
						return new ecjia_error('low_stocks', __('库存不足'));
					}
				}
			}
		}

    	/*团购限购，看剩余数量是否足够*/
    	if ($group_buy['restrict_amount'] > 0) {
    		//限购判断
    		if ($number > $group_buy['left_num']) {
    			return new ecjia_error('error_groupbuygoods_restricted', __('对不起，超出团购商品限购数量，请您修改数量！'));
    		}
    	}
    		
    	$goods_attr_id = 0;
    	if (!empty($spec)) {
    		$spec_price             = goods_info::spec_price($spec);
    		$goods_price            = goods_info::get_final_price($group_buy['goods_id'], $number, true, $spec);
    		$goods['market_price'] += $spec_price;
    		$goods_attr             = goods_info::get_goods_attr_info($spec, 'no');
    		$goods_attr_id          = join(',', $spec);
    	}
    	$goods_attr_id = empty($goods_attr_id) ? 0 : $goods_attr_id;
    	
    	/* 更新：清空购物车中所有团购商品 */
    	RC_Loader::load_app_func('cart', 'cart');
    	clear_cart(CART_GROUP_BUY_GOODS);
    
    	/* 更新：加入购物车 */
    	$goods_price = $group_buy['deposit'] > 0 ? $group_buy['deposit'] : $group_buy['cur_price'];
    	$cart = array(
    			'user_id'        => $_SESSION['user_id'],
    			'goods_id'       => $group_buy['goods_id'],
    	        'product_id'     => isset($product_info['product_id']) ? $product_info['product_id'] : 0,
    			'goods_sn'       => addslashes($goods['goods_sn']),
    			'goods_name'     => addslashes($goods['goods_name']),
    			'market_price'   => $goods['market_price'],
    			'goods_price'    => $goods_price,
    			'goods_number'   => $number,
    			'goods_attr'     => addslashes($goods_attr),
    			'goods_attr_id'  => $goods_attr_id,
    			'store_id'		 => $goods['store_id'],
    			'is_real'        => $goods['is_real'],
    			'extension_code' => 'group_buy',
    			'parent_id'      => 0,
    			'rec_type'       => CART_GROUP_BUY_GOODS,
    			'is_gift'        => 0,
    			'is_shipping'    => $goods['is_shipping'],
    			'add_time'		 => RC_Time::gmtime()
    	);
    
    	$result = RC_DB::table('cart')->insertGetId($cart);
    
    	/* 更新：记录购物流程类型：团购 */
    	$_SESSION['flow_type'] = CART_GROUP_BUY_GOODS;
    	$_SESSION['extension_code'] = 'group_buy';
    	$_SESSION['extension_id'] = $act_id;
    	return $result;
    }
}

// end