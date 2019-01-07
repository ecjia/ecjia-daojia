<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/2
 * Time: 14:13
 */

namespace Ecjia\App\Withdraw\Orders;

use Ecjia\App\Finance\UserAccountBalance;
use Ecjia\App\Withdraw\Models\UserAccountModel;
use Ecjia\App\Withdraw\Repositories\UserAccountRepository;
use RC_Api;
use RC_DB;
use ecjia;

/**
 * Class WithdrawOrderSuccess
 * 提现订单成功
 */
class WithdrawOrderSuccessProcess
{
    protected $order;

    protected $user_account;

    protected $repository;

    public function __construct($order_sn)
    {
        $this->order = UserAccountModel::where('order_sn', $order_sn)->first();

        $this->user_account = new UserAccountBalance($this->order->user_id);

        $this->repository = new UserAccountRepository();
    }

    /**
     * 提现处理操作
     */
    public function process($admin_user, $admin_note)
    {
        //更新提现订单
        $this->updateWithdrawOrder($admin_user, $admin_note);
        //处理冻结金额
        //更新账户日志
        $this->updateAccountMoney($admin_note);

        //发送提现通知
        $this->sendSmsMessageNotice();
    }

    /**
     * 更新提现订单
     */
    protected function updateWithdrawOrder($admin_user, $admin_note)
    {
        $amount = $this->order->amount;

        $this->repository->updatePaidOrderUserAccount($this->order->order_sn, $amount, $admin_user, $admin_note);
    }

    /**
     * 更新帐户资金
     */
    protected function updateAccountMoney($change_desc = null)
    {
        $amount = $this->order->amount;

        $this->user_account->withdrawSuccessful($amount, $change_desc);
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
            'event'  => 'sms_withdraw_success',
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