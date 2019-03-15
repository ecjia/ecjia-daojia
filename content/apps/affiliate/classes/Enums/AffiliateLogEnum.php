<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 03:00
 */

namespace Ecjia\App\Affiliate\Enums;


use Royalcms\Component\Enum\Enum;

/**
 * Class AffiliateLogEnum
 * 订单分成记录状态
 *
 * @package Ecjia\App\Affiliate\Enums
 */
class AffiliateLogEnum extends Enum
{
    /**
     * ===================
     * 订单分成记录状态
     * ===================
     */
    const AFFILIATE_REGISTER_SEPARATED	    = 0;//推荐注册分成

    const AFFILIATE_REGISTER_CANCELED   	= -1;//推荐注册分成撤销了分成

    const AFFILIATE_ORDER_SEPARATED        	= 1;//推荐订单分成
    
    const AFFILIATE_ORDER_CANCELED        	= -2;//推荐订单分成撤销了分成

    protected function __statusMap()
    {
        return [
            self::AFFILIATE_REGISTER_SEPARATED => __('推荐注册分成', 'affiliate'),
            self::AFFILIATE_REGISTER_CANCELED => __('推荐注册分成撤销了分成', 'affiliate'),
            self::AFFILIATE_ORDER_SEPARATED => __('推荐订单分成', 'affiliate'),
            self::AFFILIATE_ORDER_CANCELED => __('推荐订单分成撤销了分成', 'affiliate'),
        ];
    }

}