<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台管理员给用户充值申请
 * @author zrl
 *
 */
class admin_user_account_deposit_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authadminSession();
      
    	if ($_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
 		
 		$amount = $this->requestData('amount');
 		$user_note = $this->requestData('note', '');
 		
 		$account_id = $this->requestData('account_id', 0);
 		$payment_id = $this->requestData('payment_id', 0);
 		$user_id 	=  $this->requestData('user_id', 0);
 		
 		if (empty($user_id)) {
 			return new ecjia_error( 'invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
 		}
 		
 		$amount = floatval($amount);
 		if ($amount <= 0) {
 			return new ecjia_error('amount_gt_zero', __('请在“金额”栏输入大于0的数字！'));
 		}
 		RC_Loader::load_app_func('admin_order', 'orders');
 		if ($account_id > 0) {
 			$res = RC_DB::table('user_account')->where('id', $account_id)->first();
 			$order_sn = $res['order_sn'];
 		} else {
 			$order_sn = get_order_sn();
 		}
 			
 		/* 变量初始化 */
 		$surplus = array(
 				'user_id'      => $user_id,
 				'order_sn'	   => $order_sn,
 				'account_id'   => intval($account_id),
 				'process_type' => 0,
 				'payment_id'   => intval($payment_id),
 				'user_note'    => $user_note,
 				'amount'       => $amount,
 		);
 		
 		if ($surplus['payment_id'] <= 0) {
 			return new ecjia_error('select_payment_pls', __('请选择支付方式！'));
 		}
 		//获取支付方式名称
 		$payment_info = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($surplus['payment_id']);
        if (empty($payment_info)) {
            $result = new ecjia_error('select_payment_pls_again', __('支付方式无效，请重新选择支付方式！'));
        }
 		$surplus['payment'] = $payment_info['pay_code'];
 		
 		if ($surplus['account_id'] > 0) {
 			//更新会员账目明细
 			$surplus['account_id'] = $this->em_update_user_account($surplus);
 		} else {
 			RC_Loader::load_app_func('admin_user', 'user');
 			//插入会员账目明细
 			$surplus['account_id'] = insert_user_account($surplus, $amount);
 		}
 		
 		$order['payment']['payment_id'] = $surplus['payment_id'];
 		$order['payment']['account_id'] = $surplus['account_id'];
 		
 		return array('payment' => $order['payment'], 'order_sn' => $surplus['order_sn']);
	}

    /**
     * 更新会员账目明细
     *
     * @access  public
     * @param   array     $surplus  会员余额信息
     *
     * @return  int
     */
    private function em_update_user_account($surplus)
    {
        $db = RC_Loader::load_app_model('user_account_model', 'user');
        $data = array(
            'amount'	=> $surplus['amount'],
            'user_note'	=> $surplus['user_note'],
            'payment'	=> $surplus['payment'],
        );
        $db->where(array('id' => $surplus['account_id']))->update($data);

        return $surplus['account_id'];
    }
}



// end