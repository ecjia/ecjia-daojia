<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 03:02
 */

namespace Ecjia\App\Refund\Enums;


use Royalcms\Component\Enum\Enum;

/**
 * Class RefundShipEnum
 * 配送状态
 *
 * @package Ecjia\App\Refund\Enums
 */
class RefundShipEnum extends Enum
{

    /**
     * ===================
     * 配送状态
     * ===================
     */
    const SHIP_NOSHIP           = 0;//无需退货

    const SHIP_UNSHIP           = 1;//买家未发货

    const SHIP_SHIPPED          = 2;//买家发货

    const SHIP_CONFIRM_RECV     = 3;//确认收货

    const SHIP_UNRECEIVE        = 11;//未收到货


    protected function __statusMap()
    {
        return [
            self::SHIP_NOSHIP       => __('无需退货', 'refund'),
            self::SHIP_UNSHIP       => __('买家未发货', 'refund'),
            self::SHIP_SHIPPED      => __('买家发货', 'refund'),
            self::SHIP_CONFIRM_RECV => __('确认收货', 'refund'),
            self::SHIP_UNRECEIVE    => __('未收到货', 'refund'),
        ];
    }
}