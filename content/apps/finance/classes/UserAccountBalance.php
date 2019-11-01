<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/2
 * Time: 14:39
 */

namespace Ecjia\App\Finance;

use RC_Time;
use RC_DB;

class UserAccountBalance
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }


    /**
     * 获取用户账户余额
     * @return float 用户账户余额
     */
    public function getUserMoney()
    {
        $user_money = RC_DB::table('users')->where('user_id', $this->user_id)->value('user_money');
        return $user_money ?: 0.00;
    }

    /**
     * 获取用户冻结金额
     * @return float
     */
    public function getFrozenMoney()
    {
        $frozen_money = RC_DB::table('users')->where('user_id', $this->user_id)->value('frozen_money');
        return $frozen_money ?: 0.00;
    }


    /**
     * 账户充值
     * 向用户资金里充入余额
     */
    public function charge($user_money, $change_desc = '账户充值', $from_type = null, $from_value = null)
    {
        $data = [
            'user_id'      => $this->user_id,
            'user_money'   => $user_money,
            'frozen_money' => 0,
            'change_desc'  => $change_desc,
            'change_time'  => RC_Time::gmtime(),
            'change_type'  => AccountConstant::BALANCE_SAVING, //充值
            'from_type'    => $from_type,
            'from_value'   => $from_value,
        ];

        return $this->transactionChangeAccountBalance($data);
    }

    /**
     * 账户提现申请
     * 从用户的余额里划一笔金额至冻结资金里
     */
    public function withdrawApply($user_money, $change_desc = '提现申请', $from_type = null, $from_value = null)
    {
        $data = [
            'user_id'      => $this->user_id,
            'user_money'   => -$user_money,
            'frozen_money' => $user_money,
            'change_desc'  => $change_desc,
            'change_time'  => RC_Time::gmtime(),
            'change_type'  => AccountConstant::BALANCE_DRAWING, //提款
            'from_type'    => $from_type,
            'from_value'   => $from_value,
        ];

        return $this->transactionChangeAccountBalance($data);
    }

    /**
     * 账户提现完成
     * 将用户的冻结资金设为0
     */
    public function withdrawSuccessful($user_money, $change_desc = '提现成功', $from_type = null, $from_value = null)
    {
        $data = [
            'user_id'      => $this->user_id,
            'user_money'   => 0,
            'frozen_money' => -$user_money,
            'change_desc'  => $change_desc,
            'change_time'  => RC_Time::gmtime(),
            'change_type'  => AccountConstant::BALANCE_DRAWING, //提款
            'from_type'    => $from_type,
            'from_value'   => $from_value,
        ];

        return $this->transactionChangeAccountBalance($data);
    }

    /**
     * 帐户提现取消
     * 将冻结资金再转回用户资金里
     */
    public function withdrawCancel($user_money, $change_desc = '提现取消', $from_type = null, $from_value = null)
    {
        $data = [
            'user_id'      => $this->user_id,
            'user_money'   => $user_money,
            'frozen_money' => -$user_money,
            'change_desc'  => $change_desc,
            'change_time'  => RC_Time::gmtime(),
            'change_type'  => AccountConstant::BALANCE_SAVING, //充入
            'from_type'    => $from_type,
            'from_value'   => $from_value,
        ];

        return $this->transactionChangeAccountBalance($data);
    }

    /**
     * 事务操作
     * 修改账户余额
     * @param array $data
     */
    protected function transactionChangeAccountBalance(array $data)
    {
        return RC_DB::transaction(function () use ($data) {

            $log_id = RC_DB::table('account_log')->insertGetId($data);

            RC_DB::table('users')->where('user_id', $this->user_id)->increment('user_money', floatval($data['user_money']));
            RC_DB::table('users')->where('user_id', $this->user_id)->increment('frozen_money', floatval($data['frozen_money']));

            return $log_id;
        });
    }

}