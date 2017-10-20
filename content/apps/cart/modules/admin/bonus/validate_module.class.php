<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台红包验证
 * @author 
 *
 */
class validate_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$bonus_sn = $this->requestData('bonus_sn');
		if (empty($bonus_sn)) {
			return new ecjia_error(101, '错误的参数提交');
		}
		RC_Loader::load_app_func('admin_bonus', 'bonus');
		RC_Loader::load_app_func('cart', 'cart');
		$bonus = bonus_info(0, $bonus_sn);
		$now = RC_Time::gmtime();
		
		/* 取得购物类型 */
		$flow_type  = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
		
        if (empty($bonus)) {
			return new ecjia_error('bonus_error', '红包信息有误！');
		}
		if ($bonus['order_id'] > 0) {
		    return new ecjia_error('bonus_error', '红包已使用！');
		}
		if ($bonus['min_goods_amount'] > cart_amount(true, $flow_type)) {
		    return new ecjia_error('bonus_error', '红包使用最小金额为'.$bonus['min_goods_amount'].'！');
		}
		if ($now < $bonus['use_start_date'] ||  $now > $bonus['use_end_date']) {
		    return new ecjia_error('bonus_error', '红包不在有效期！');
		}
		
		if (isset($_SESSION['user_id']) && $bonus['user_id'] > 0 && $_SESSION['user_id'] != $bonus['user_id']) {
		    return new ecjia_error('bonus_error', '红包信息有误！');
		} else {
		    return array('bonus' => $bonus['type_money'], 'bonus_formated' => price_format($bonus['type_money']));
		}
	}
}

// end