<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 02:59
 */

namespace Ecjia\App\Refund\Enums;


use Royalcms\Component\Enum\Enum;

/**
 * Class RefundOrderEnum
 * 退款单状态
 *
 * @package Ecjia\App\Refund\Enums
 */
class RefundOrderEnum extends Enum
{

    /**
     * ===================
     * 退款单状态
     * ===================
     */
    const ORDER_UNCHECK 	 	= 0;//退款申请(待审核)

    const ORDER_AGREE   	 	= 1;//退款确认(同意)

    const ORDER_CANCELED        = 10;//取消申请（已取消）

    const ORDER_REFUSED         = 11;//拒绝退款（不同意）


    protected function __statusMap()
    {
        return [
            self::ORDER_UNCHECK     => __('退款申请', 'refund'),
            self::ORDER_AGREE       => __('退款确认', 'refund'),
            self::ORDER_CANCELED    => __('取消申请', 'refund'),
            self::ORDER_REFUSED     => __('拒绝退款', 'refund'),
        ];
    }

}