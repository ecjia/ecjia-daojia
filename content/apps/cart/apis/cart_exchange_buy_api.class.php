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
 * 获取积分兑换添加购物车
 * @author will.chen
 */
 
class cart_exchange_buy_api extends Component_Event_Api {
    
    public function call(&$options) {
    	if (!is_array($options)) {
    		return new ecjia_error('invalid_parameter', __('参数无效', 'cart'));
    	}
        return $this->exchange_buy($options);
    }
    
    /**
	 * 获取积分兑换商品列表
	 * @param   array	 $options（包含当前页码，每页显示条数）
	 * @return  array   商家活动数组
	 */
	private function exchange_buy($options) {
		$goods_id = $options['goods_id'];
		
		/* 查询：取得兑换商品信息 */
		$field = 'g.goods_id, g.goods_sn, g.goods_name, g.cat_id, g.brand_id, g.goods_number, g.warn_number, g.keywords, g.goods_weight, eg.exchange_integral, g.goods_type, g.goods_brief, g.goods_desc, g.goods_thumb, g.seller_note, g.goods_img, eg.is_exchange, eg.is_hot';
    	$goods = RC_Model::model('exchange/exchange_goods_viewmodel')->exchange_goods_find(array('eg.goods_id' => $goods_id), $field);
        
    	if (empty($goods)) {
    		return new ecjia_error('goods_not_exist', __('商品不存在', 'cart'));
    	}
    	
	    /* 查询：检查兑换商品是否有库存 */
	    if($goods['goods_number'] == 0 && ecjia::config('use_storage') == 1) {
	    	return new ecjia_error('eg_error_number', __('商品库存不足！', 'cart'));
	    }
	    
	    /* 查询：检查兑换商品是否是取消 */
	    if ($goods['is_exchange'] == 0) {
	    	return new ecjia_error('eg_error_status', __('积分商品已下架！', 'cart'));
	    }
	
	    $user_info = RC_Api::api('user', 'user_info', array('user_id' => $_SESSION['user_id']));
	    $user_points = $user_info['pay_points']; // 用户的积分总数
	    
	    if ($goods['exchange_integral'] > $user_points) {
	    	return new ecjia_error('eg_error_integral', __('用户积分不足！', 'cart'));
	    }
	
	    /* 查询：取得规格 */
	    $specs = '';
	    foreach ($options['specs'] as $key => $value) {
// 	        if (strpos($key, 'spec_') !== false) {
// 	            $specs .= ',' . intval($value);
// 	        }
			$specs[] = $value;
	    }
// 	    $specs = trim($specs, ',');
	    $product_info = null;
	    
	    /* 查询：如果商品有规格则取规格商品信息 配件除外 */
	    if (!empty($specs)) {
// 	        $_specs = explode(',', $specs);
	    	$_specs = $specs;
	        RC_Loader::load_app_func('admin_goods', 'goods');
	        $product_info = get_products_info($goods_id, $_specs);
	    }
	    
	    if (empty($product_info)) {
	        $product_info = array('product_number' => '', 'product_id' => 0);
	    }
	
	    //查询：商品存在规格 是货品 检查该货品库存
	    if ((!empty($specs)) && ($product_info['product_number'] == 0) && (ecjia::config('use_storage') == 1)) {
	    	return new ecjia_error('eg_error_number', __('商品库存不足！', 'cart'));
	    }
	
	    /* 查询：查询规格名称和值，不考虑价格 */
	    $attr_list = array();
	    
	    $attr_list_res = RC_Model::model('goods/goods_attr_viewmodel')->field('a.attr_name, ga.attr_value')->where(array('ga.goods_attr_id' => $specs))->select();
	    if (!empty($attr_list_res)) {
	    	foreach ($attr_list_res as $row) {
	    		$attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
	    	}
	    } 
	    
	    $goods_attr = join(chr(13) . chr(10), $attr_list);
	
	    /* 更新：清空购物车中所有团购商品 */
	    RC_Model::model('cart/cart_model')->clear_cart(CART_EXCHANGE_GOODS);
	
	    /* 更新：加入购物车 */
	    $number = 1;
	    $cart = array(
	        'user_id'        => $_SESSION['user_id'],
// 	        'session_id'     => SESS_ID,
	        'goods_id'       => $goods['goods_id'],
	        'product_id'     => $product_info['product_id'],
	        'goods_sn'       => addslashes($goods['goods_sn']),
	        'goods_name'     => addslashes($goods['goods_name']),
	        'market_price'   => $goods['market_price'],
	        'goods_price'    => 0,
	        'goods_number'   => $number,
	        'goods_attr'     => addslashes($goods_attr),
	        'goods_attr_id'  => $specs,
	        'is_real'        => $goods['is_real'],
	        'extension_code' => addslashes($goods['extension_code']),
	        'parent_id'      => 0,
	        'rec_type'       => CART_EXCHANGE_GOODS,
	        'is_gift'        => 0
	    );
	    RC_Model::model('cart/cart_model')->insert($cart);
	
	    /* 记录购物流程类型：团购 */
	    $_SESSION['flow_type']		= CART_EXCHANGE_GOODS;
	    $_SESSION['extension_code'] = 'exchange_goods';
	    $_SESSION['extension_id']	= $goods_id;
	
	    return true;
	}
}

// end