<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/2
 * Time: 14:13
 */

namespace Ecjia\App\Withdraw\Orders;

use RC_Api;
use RC_DB;
use ecjia;

/**
 * Class WithdrawOrderFailed
 * 提现订单失败
 */
class WithdrawOrderFailedProcess extends WithdrawOrderSuccessProcess
{

    /**
     * 更新提现订单
     */
    protected function updateWithdrawOrder($admin_user, $admin_note)
    {
        $amount = $this->order->amount;

        $this->repository->updateCancelOrderUserAccount($this->order->order_sn, $admin_user, $admin_note);
    }

    /**
     * 更新帐户资金
     */
    protected function updateAccountMoney()
    {
        $amount = abs($this->order->amount);

        $this->user_account->withdrawCancel($amount);
    }

    /**
     * 发送短信消息通知
     */
    protected function sendSmsMessageNotice()
    {
        $order_info   = $this->order;
        $user_account = $this->user_account;
        $user_info    = RC_DB::table('users')->where('user_id', $this->order->user_id)->first();

        $options  = array(
            'mobile' => $user_info['mobile_phone'],
            'event'  => 'sms_withdraw_fail',
            'value'  => array(
                'user_name'     => $user_info['user_name'],
                'amount'        => abs($order_info['amount']),
                'user_money'    => $user_account->getUserMoney(),
                'service_phone' => ecjia::config('service_phone')
            )
        );
        $response = RC_Api::api('sms', 'send_event_sms', $options);
    }


}