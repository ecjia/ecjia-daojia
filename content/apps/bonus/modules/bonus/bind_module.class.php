<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 兑换线下红包绑定
 * @author zrl
 *
 */
class bonus_bind_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
		$this->authSession();
		if ($_SESSION['user_id'] <= 0 ) {
			return new ecjia_error(100, 'Invalid session');
		}
		$bonus_sn = $this->requestData('bonus_sn', '0');
		if (empty($bonus_sn)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		$time = RC_Time::gmtime();
    	$db_bonus_view = RC_DB::table('bonus_type as bt')->leftJoin('user_bonus as ub', RC_DB::raw('bt.type_id'), '=', RC_DB::raw('ub.bonus_type_id'));
    	
		$bonus_info = $db_bonus_view
		->where(RC_DB::raw('ub.bonus_sn'), $bonus_sn)
		->where(RC_DB::raw('ub.user_id'), 0)
		->where(RC_DB::raw('bt.use_end_date'), '>', $time)
		->select(RC_DB::raw('bt.use_start_date, bt.use_end_date, bt.min_goods_amount'))
		->first();
		
		if (empty($bonus_info)) {
			return new ecjia_error('bonus_error', '红包信息有误！');
		}
		
		RC_DB::table('user_bonus')->where('bonus_sn', $bonus_sn)->where('user_id', 0)->where('order_id', 0)->update(array('user_id' => $_SESSION['user_id']));
		
		return array();
 		
	}
}

// end