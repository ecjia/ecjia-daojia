<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/13
 * Time: 16:29
 */

namespace Ecjia\App\Orders\Enums;

use Royalcms\Component\Enum\Enum;

class OrderStatusEnum extends Enum
{

    const OS_UNCONFIRMED    = 0; // 未确认
    const OS_CONFIRMED      = 1; // 已确认
    const OS_CANCELED       = 2; // 已取消
    const OS_INVALID        = 3; // 无效
    const OS_RETURNED       = 4; // 退货
    const OS_SPLITED        = 5; // 已分单
    const OS_SPLITING_PART  = 6; // 部分分单


    protected function __statusMap()
    {
        return [
            self::OS_UNCONFIRMED        => __('未确认', 'orders'),
            self::OS_CONFIRMED          => __('已确认', 'orders'),
            self::OS_CANCELED           => __('已取消', 'orders'),
            self::OS_INVALID            => __('无效', 'orders'),
            self::OS_RETURNED           => __('退货', 'orders'),
            self::OS_SPLITED            => __('已分单', 'orders'),
            self::OS_SPLITING_PART      => __('部分分单', 'orders'),
        ];
    }


}