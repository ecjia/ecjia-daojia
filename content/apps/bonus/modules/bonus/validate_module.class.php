<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 线下红包兑换验证
 * @author zrl
 *
 */
class bonus_validate_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	$this->authSession();
    	$bonus_sn = $this->requestData('bonus_sn');
		
    	if (empty($bonus_sn)) {
    		return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'bonus'), __CLASS__));
    	}
    	
		$time = RC_Time::gmtime();
    	$db_bonus_view = RC_DB::table('bonus_type as bt')->leftJoin('user_bonus as ub', RC_DB::raw('bt.type_id'), '=', RC_DB::raw('ub.bonus_type_id'));
    	$bonus_info = $db_bonus_view
    						->where(RC_DB::raw('ub.bonus_sn'), $bonus_sn)
    						->where(RC_DB::raw('ub.user_id'), 0)
    						->where(RC_DB::raw('bt.use_end_date'), '>', $time)
    						->select(RC_DB::raw('bt.type_id, bt.type_name, bt.type_money, ub.bonus_id, bt.use_start_date, bt.use_end_date, bt.min_goods_amount'))
    						->first();
    	
		if (empty($bonus_info)) {
			return new ecjia_error('bonus_error', __('红包信息有误！', 'bonus'));
		}
		$data = array(
			'bonus_id'					=> $bonus_info['bonus_id'],
			'bonus_name'				=> $bonus_info['type_name'],
			'bonus_amount'				=> $bonus_info['type_money'],
			'formatted_bonus_amount' 	=> price_format($bonus_info['type_money']),
			'request_amount'			=> $bonus_info['min_goods_amount'],
			'formatted_request_amount' 	=> price_format($bonus_info['min_goods_amount']),
			'label_request_amount' 		=> sprintf(__('购物满%s才可以使用此红包', 'bonus'), price_format($bonus_info['min_goods_amount'])),
			'start_date'				=> $bonus_info['use_start_date'],
			'end_date'					=> $bonus_info['use_end_date'],
			'formatted_start_date'   	=> RC_Time::local_date(ecjia::config('date_format'), $bonus_info['use_start_date']),
			'formatted_end_date'     	=> RC_Time::local_date(ecjia::config('date_format'), $bonus_info['use_end_date']),
		);
		return $data; 
	}
}

// end