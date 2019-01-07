<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/26
 * Time: 14:13
 */

namespace Ecjia\App\Withdraw\Repositories;

use Ecjia\App\Withdraw\WithdrawConstant;
use Royalcms\Component\Repository\Repositories\AbstractRepository;
use RC_Time;
use ecjia;

/**
 * Class UserAccountRepository
 * 只处理提现订单
 * @package Ecjia\App\Withdraw\Repositories
 */
class UserAccountRepository extends AbstractRepository
{
    protected $model = 'Ecjia\App\Withdraw\Models\UserAccountModel';

    protected $orderBy = ['id' => 'desc'];

    protected $process_type = 1; //提现类型


    public function findWithdraw($id)
    {
        return $this->getModel()->where('id', $id)
            ->where('process_type', $this->process_type)
            ->first();
    }

    public function getUserAccountOrder($order_sn)
    {
        return $this->getModel()->where('order_sn', $order_sn)
            ->where('process_type', $this->process_type)
            ->first();
    }

    /**
     * 插入会员提现订单
     *
     * @access  public
     * @param   array     $data     会员提现信息
     * @param   string    $amount   余额
     *
     * @return  int
     */
    public function insertUserAccount($data, $amount)
    {
        $withdraw_fee = ecjia::config('withdraw_fee');
        if ($withdraw_fee > 0) {
            $pay_fee = $amount * $withdraw_fee / 100;
        } else {
            $pay_fee = 0.00;
        }

        $data = array(
            'user_id'		=> $data['user_id'],
            'order_sn'		=> $data['order_sn'],
            'admin_user'	=> $data['admin_user'] ?: '',
            'add_time'		=> RC_Time::gmtime(),
            'paid_time'		=> 0,
            'admin_note'	=> $data['admin_note'] ?: '',
            'user_note'		=> $data['user_note'],
            'process_type'	=> $this->process_type,
            'payment'		=> $data['payment'],
            'payment_name'  => $data['payment_name'],
            'is_paid'		=> WithdrawConstant::WITHDRAW_RECORD_STATUS_WAIT,
            'amount'		=> (-1) * $amount, //申请金额
            'pay_fee'       => $pay_fee, //手续费
            'real_amount'   => $amount - $pay_fee, //到账金额
            'from_type'		=> $data['from_type'],
            'from_value'	=> $data['from_value'],

            'bank_name'         => $data['bank_name'],
            'bank_branch_name'  => $data['bank_branch_name'],
            'bank_card'         => $data['bank_card'],
            'cardholder'        => $data['cardholder'],
            'bank_en_short'     => $data['bank_en_short'],
        );
        return $this->getModel()->create($data);
    }

    /**
     * 更新会员提现订单
     *
     * @param   string     $id          帐目ID
     * @param   string     $admin_note  管理员描述
     * @param   float     $amount      操作的金额
     *
     * @return  int
     */
    public function updatePaidOrderUserAccount($order_sn, $amount, $admin_name, $admin_note)
    {
        $data = array(
            'admin_user'	=> $admin_name,
            'amount'		=> $amount,
            'paid_time'		=> RC_Time::gmtime(),
            'admin_note'	=> $admin_note,
            'is_paid'		=> WithdrawConstant::ORDER_PAY_STATUS_PAYED,
            'review_time'   => RC_Time::gmtime(),
        );
        return $this->getModel()->where('order_sn', $order_sn)
            ->where('process_type', $this->process_type)
            ->update($data);
    }


    /**
     * 更新会员提现订单
     *
     * @param   string     $id          帐目ID
     * @param   string     $admin_note  管理员描述
     * @param   float     $amount      操作的金额
     *
     * @return  int
     */
    public function updateCancelOrderUserAccount($order_sn, $admin_name, $admin_note)
    {
        $data = array(
            'admin_user'	=> $admin_name,
            'admin_note'	=> $admin_note,
            'is_paid'		=> WithdrawConstant::ORDER_PAY_STATUS_CANCEL,
            'review_time'   => RC_Time::gmtime(),
        );
        return $this->getModel()->where('order_sn', $order_sn)
            ->where('process_type', $this->process_type)
            ->update($data);
    }

    /**
     *  删除未确认的会员提现订单信息
     *
     * @access  public
     * @param   int         $rec_id     会员余额记录的ID
     * @param   int         $user_id    会员的ID
     * @return  int
     */
    public function deleteUserAccount($order_sn, $user_id)
    {
        return $this->getModel()->where('is_paid', 0)
            ->where('order_sn', $order_sn)
            ->where('user_id', $user_id)
            ->where('process_type', $this->process_type)
            ->delete();
    }



}