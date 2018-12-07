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

class flow_done_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		/**
         * bonus 0 //红包
         * how_oos 0 //缺货处理
         * integral 0 //积分
         * payment 3 //支付方式
         * postscript //订单留言
         * shipping 3 //配送方式
         * surplus 0 //余额
         * inv_type 4 //发票类型
         * inv_payee 发票抬头
         * inv_content 发票内容
         * inv_tax_no 发票纳税人识别码
         * inv_title_type 发票抬头类型
         */
    	
    	$this->authSession();
    	$rec_id = $this->requestData('rec_id');
    	if (isset($_SESSION['cart_id'])) {
    		$rec_id = empty($rec_id) ? $_SESSION['cart_id'] : $rec_id;
    	}
    	$cart_id = array();
    	if (!empty($rec_id)) {
    		$cart_id = explode(',', $rec_id);
    	}
    	if (empty($cart_id)) {
    		return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter'));
    	}
    	$location		= $this->requestData('location',array());
    	//TODO:目前强制坐标
//     	$location = array(
//     	    'latitude'	=> '31.235450744628906',
//     	    'longitude' => '121.41641998291016',
//     	);
    	/* 取得购物类型 */
    	//$flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
    	$rec_type = RC_DB::table('cart')->whereIn('rec_id', $cart_id)->lists('rec_type');
    	$rec_type = array_unique($rec_type);
    	if (count($rec_type) > 1) {
    		return new ecjia_error( 'error_rec_type', '购物车类型不一致！');
    	} else {
    		$rec_type = $rec_type['0'];
    		if ($rec_type == 1) {
    			$flow_type = CART_GROUP_BUY_GOODS;
    		} else {
    			$flow_type = CART_GENERAL_GOODS;
    		}
    	}
    	/* 获取收货信息*/
    	$address_id = $this->requestData('address_id', 0);
    	if (empty($address_id)) {
    	    return new ecjia_error('empty_address', '请选择收货地址');
    	}
    	
    	//发票抬头处理
    	$inv_payee_last = '';
    	$inv_title_type = trim($this->requestData('inv_title_type', ''));
    	if (!empty($inv_title_type)) {
    		if ($inv_title_type == 'personal') {
    			$inv_payee_last = trim($this->requestData('inv_payee', '个人'));
    		} elseif($inv_title_type == 'enterprise') {
    			//发票纳税人识别码
    			$inv_tax_no = trim($this->requestData('inv_tax_no', ''));
    			$inv_payee = trim($this->requestData('inv_payee', ''));
    			if (empty($inv_tax_no) || empty($inv_payee)) {
    				return new ecjia_error('invoice_error', '发票抬头和识别码都不能为空！');
    			}
    			//如果有传发票识别码，发票识别码存储在inv_payee（发票抬头）字段中；格式为发票抬头 + ,发票纳税人识别码；如：（企业,789654321456987124）。
		    	$inv_payee_last = $inv_payee.','.$inv_tax_no;
    		}
    	}
    	
    	$order = array(
    		'shipping_id'   => $this->requestData('shipping_id' ,0),
    		'pay_id'        => $this->requestData('pay_id' ,0),
    		'pack_id'     	=> $this->requestData('pack', 0),
    		'card_id'    	=> $this->requestData('card', 0),
    		'card_message'  => trim($this->requestData('card_message')),
    		'surplus'   	=> $this->requestData('surplus', 0.00),
    		'integral'     	=> $this->requestData('integral', 0),
    		'bonus_id'     	=> $this->requestData('bonus', 0),
    		'need_inv'     	=> $this->requestData('need_inv', 0),
    		'inv_type'     	=> $this->requestData('inv_type', ''),
    		'inv_payee'    	=> $inv_payee_last,
    		'inv_content'   => $this->requestData('inv_content', ''),
    		'postscript'    => $this->requestData('postscript', ''),
    		'need_insure'   => $this->requestData('need_insure', 0),
    		'user_id'      	=> $_SESSION['user_id'],
    		'add_time'     	=> RC_Time::gmtime(),
    		'inv_tax_no'	=> $this->requestData('inv_tax_no', ''),
    		'inv_title_type'=> $inv_title_type, 	
    		'order_status'  	=> OS_UNCONFIRMED,
    		'shipping_status' 	=> SS_UNSHIPPED,
    		'pay_status'    	=> PS_UNPAYED,	
//     		'agency_id' => get_agency_by_regions(array(
//     			$consignee['country'],
//     			$consignee['province'],
//     			$consignee['city'],
//     			$consignee['district']
//     		))
    		'agency_id'		=> 0,
    		'expect_shipping_time' =>  $this->requestData('expect_shipping_time', ''),
    	);
		//期望送达时间过滤
    	$order['expect_shipping_time'] = empty($order['expect_shipping_time']) ? '' : $order['expect_shipping_time'];
    	
    	if (empty($order['pay_id'])) {
    	    return new ecjia_error('empty_payment', '请选择支付方式');
    	}
    	if (empty($order['shipping_id'])) {
    	    return new ecjia_error('empty_shipping', '当前收货地址暂无可用配送方式，请重新更换其他的收货地址！');
    	}
    	//选择货到付款支付方式后，不可选择上门取货配送方式
        if ($order['pay_id'] > 0) {
        	$pay_code = RC_DB::table('payment')->where('pay_id', $order['pay_id'])->pluck('pay_code');
        	if ($pay_code == 'pay_cod') {
        		if ($order['shipping_id'] > 0) {
        			$ship_code = RC_DB::table('shipping')->where('shipping_id', $order['shipping_id'])->pluck('shipping_code');
        			if ($ship_code == 'ship_cac') {
        				return new ecjia_error('not_surport_shipping', '货到付款支付不支持上门取货配送！');
        			}
        		}
        	}
        }
        
    	$result = RC_Api::api('cart', 'flow_done', array('cart_id' => $cart_id, 'order' => $order, 'address_id' => $address_id, 'flow_type' => $flow_type, 'bonus_sn' => $this->requestData('bonus_sn'), 'location' => $location, 'device' => $this->device));
    	
    	return $result;
    }
}

// end