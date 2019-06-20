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
 * 添加到购物车
 * @author zrl
 */
class bbc_cart_create_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}

    	$user_id = $_SESSION['user_id'];
    	$api_version = $this->request->header('api-version');
    	//判断用户有没申请注销
    	if (version_compare($api_version, '1.25', '>=')) {
    		$account_status = Ecjia\App\User\Users::UserAccountStatus($user_id);
    		if ($account_status == Ecjia\App\User\Users::WAITDELETE) {
    			return new ecjia_error('account_status_error', __('当前账号已申请注销，不可执行此操作！', 'cart'));
    		}
    	}
    	
	    $goods_id		= $this->requestData('goods_id', 0);
	    $goods_number	= $this->requestData('number', 1);
	    $location		= $this->requestData('location', array());
	    $product_id		= $this->requestData('product_id', 0);  //货品id
	    
	    if (empty($goods_id) || !is_numeric($goods_id)) {
	        return new ecjia_error('invalid_parameter', __('请求接口bbc_cart_create_module参数错误', 'cart'));
	    }
	    $goods_spec		= $this->requestData('spec', array());
	    
	    if ($product_id > 0) {
	    	$goods_attr = RC_DB::table('products')->where('product_id', $product_id)->pluck('goods_attr');
	    	$goods_spec = explode('|', $goods_attr);
	    }
	    
	    $rec_type		= trim($this->requestData('rec_type', 'GENERAL_GOODS')); 
	    $object_id 		= $this->requestData('goods_activity_id', 0);

	    RC_Loader::load_app_func('cart', 'cart');

	    unset($_SESSION['flow_type']);
	    unset($_SESSION['extension_code']);
	    unset($_SESSION['extension_id']);
	    
    	//该商品对应店铺是否被锁定
		$store_id 		= Ecjia\App\Cart\StoreStatus::GetStoreId($goods_id);
		$store_status 	= Ecjia\App\Cart\StoreStatus::GetStoreStatus($store_id);
		if ($store_status == Ecjia\App\Cart\StoreStatus::LOCKED) {
			return new ecjia_error('store_locked', __('对不起，该商品所属的店铺已锁定！', 'cart'));
		}
    	
    	$store_id_group = array($store_id);
    	
    	if ($rec_type == 'GROUPBUY_GOODS') {
    		$flow_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS;
    		$result = RC_Api::api('cart', 'cart_groupbuy_manage', array('goods_id' => $goods_id, 'goods_number' => $goods_number, 'goods_spec' => $goods_spec, 'rec_type' => $rec_type, 'store_group' => $store_id_group, 'goods_activity_id' => $object_id));
    	} else {
    		$flow_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
    		$result = RC_Api::api('cart', 'cart_manage', array('goods_id' => $goods_id, 'goods_number' => $goods_number, 'goods_spec' => $goods_spec, 'rec_type' => $rec_type, 'store_group' => $store_id_group, $product_id));
    	}

	    if (is_ecjia_error($result)) {
	    	return $result;
	    }

	    $dbview = RC_DB::table('cart as c')->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))->leftJoin('store_franchisee as sf', RC_DB::raw('sf.store_id'), '=', RC_DB::raw('c.store_id'));
	    $field  ="c.*, c.goods_price*c.goods_number as subtotal, g. goods_thumb, g.goods_img, g.original_img, sf.merchants_name as store_name";
	    $data 	= $dbview->select(RC_DB::raw($field))->where(RC_DB::raw('c.user_id'), $user_id)->where(RC_DB::raw('c.rec_id'), $result)->where(RC_DB::raw('c.rec_type'), $flow_type)->first();
	    if (!empty($data)) {
	    	$goods_attrs = array();
	    	/* 查询规格 */
	    	if (trim($data['goods_attr']) != '') {
	    		$goods_attr = explode("\n", $data['goods_attr']);
	    		$goods_attr = array_filter($goods_attr);
	    		foreach ($goods_attr as $v) {
	    			$a = explode(':', $v);
	    			if (!empty($a[0]) && !empty($a[1])) {
	    				$goods_attrs[] = array('name' => $a[0], 'value' => $a[1]);
	    			}
	    		}
	    	}
	    	$cartGoods = array(
	    			'rec_id'				=> intval($data['rec_id']),
	    			'store_id'				=> intval($data['store_id']),
	    			'store_name'			=> trim($data['store_name']),
	    			'goods_id'				=> intval($data['goods_id']),
	    			'goods_sn'				=> trim($data['goods_sn']),
	    			'goods_name'			=> trim($data['goods_name']),
	    			'goods_price'			=> $data['goods_price'],
	    			'market_price'			=> $data['market_price'],
	    			'formated_goods_price'	=> ecjia_price_format($data['goods_price'], false),
	    			'formated_market_price'	=> ecjia_price_format($data['market_price'], false),
	    			'goods_number'			=> intval($data['goods_number']),
	    			'attr'					=> empty($data['goods_attr']) ? '' : $data['goods_attr'],
	    			'goods_attr'			=> $goods_attrs,
	    			'goods_attr_id'			=> intval($data['goods_attr_id']),
	    			'subtotal'				=> $data['subtotal'],
	    			'formated_subtotal'		=> ecjia_price_format($data['subtotal'], false),
	    			'img'					=> array(
	    											'thumb' 	=> empty($data['goods_img']) ? '' : RC_Upload::upload_url($data['goods_img']),
	    											'url' 		=> empty($data['original_img']) ? '' : RC_Upload::upload_url($data['original_img']),
	    											'small'		=> empty($data['goods_thumb']) ? '' : RC_Upload::upload_url($data['goods_thumb']),
	    										),
	    		);
	    	return $cartGoods;
	    }
	}
}

// end