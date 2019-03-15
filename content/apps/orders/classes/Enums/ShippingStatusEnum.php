<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/13
 * Time: 16:29
 */

namespace Ecjia\App\Orders\Enums;

use Royalcms\Component\Enum\Enum;

class ShippingStatusEnum extends Enum
{

    const SS_UNSHIPPED      = 0; // 未发货
    const SS_SHIPPED        = 1; // 已发货
    const SS_RECEIVED       = 2; // 已收货
    const SS_PREPARING      = 3; // 备货中
    const SS_SHIPPED_PART   = 4; // 已发货(部分商品)
    const SS_SHIPPED_ING    = 5; // 发货中(处理分单)
    const OS_SHIPPED_PART   = 6; // 已发货(部分商品)


    protected function __statusMap()
    {
        return [
            self::SS_UNSHIPPED        => __('未发货', 'orders'),
            self::SS_SHIPPED          => __('已发货', 'orders'),
            self::SS_RECEIVED         => __('已收货', 'orders'),
            self::SS_PREPARING        => __('备货中', 'orders'),
            self::SS_SHIPPED_PART     => __('已发货(部分商品)', 'orders'),
            self::SS_SHIPPED_ING      => __('发货中(处理分单)', 'orders'),
            self::OS_SHIPPED_PART     => __('已发货(部分商品)', 'orders'),
        ];
    }
    

}