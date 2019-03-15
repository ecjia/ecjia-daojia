<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 03:00
 */

namespace Ecjia\App\Refund\Enums;


use Royalcms\Component\Enum\Enum;

/**
 * Class RefundPayEnum
 * 打款状态
 *
 * @package Ecjia\App\Refund\Enums
 */
class RefundPayEnum extends Enum
{
    /**
     * ===================
     * 打款状态
     * ===================
     */
    const PAY_NOTRANSFER	    = 0;//无打款请求（无）

    const PAY_UNTRANSFER   	    = 1;//待处理打款（待处理）

    const PAY_TRANSFERED        = 2;//已打款（已打款）

    protected function __statusMap()
    {
        return [
            self::PAY_NOTRANSFER => __('无打款请求', 'refund'),
            self::PAY_UNTRANSFER => __('待处理打款', 'refund'),
            self::PAY_TRANSFERED => __('已打款', 'refund'),
        ];
    }

}