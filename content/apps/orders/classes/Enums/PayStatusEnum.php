<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/13
 * Time: 16:29
 */

namespace Ecjia\App\Orders\Enums;

use Royalcms\Component\Enum\Enum;

class PayStatusEnum extends Enum
{

    const PS_UNPAYED     = 0; // 未付款
    const PS_PAYING      = 1; // 付款中
    const PS_PAYED       = 2; // 已付款


    protected function __statusMap()
    {
        return [
            self::PS_UNPAYED       => __('未付款', 'orders'),
            self::PS_PAYING        => __('付款中', 'orders'),
            self::PS_PAYED         => __('已付款', 'orders'),
        ];
    }
    

}