<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/2
 * Time: 14:55
 */

namespace Ecjia\App\Finance;


class AccountConstant
{

    /**
     * 账户余额
     */

    const BALANCE_SAVING = 0; // 帐户冲值

    const BALANCE_DRAWING = 1; // 帐户提款

    const BALANCE_ADJUSTING = 2; // 调节帐户

    const BALANCE_REFUND = 3; // 退款


    /**
     * 账户消费积分
     */

    const PAY_POINT_SAVING = 11; // 消费积分充入

    const PAY_POINT_DEDUCTION = 12; // 消费积分抵扣

    const PAY_POINT_ADJUSTING = 13; // 调节帐户

    const PAY_POINT_ACTIVITY = 98;  // 活动奖励

    const PAY_POINT_OTHER = 99; // 其他类型


    /**
     * 账户等级积分
     */

    const RANK_POINT_SAVING = 21; // 成长值充入

    const RANK_POINT_DEDUCTION = 22; // 成长值扣除

    const RANK_POINT_ADJUSTING = 23; // 调节帐户


}