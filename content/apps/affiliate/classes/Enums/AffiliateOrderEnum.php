<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 02:59
 */

namespace Ecjia\App\Affiliate\Enums;


use Royalcms\Component\Enum\Enum;

/**
 * Class AffiliateOrderEnum
 * 订单分成状态
 *
 * @package Ecjia\App\Affiliate\Enums
 */
class AffiliateOrderEnum extends Enum
{

    /**
     * ===================
     * 订单分成状态
     * ===================
     */
    const UNSEPARATE 	 		= 0;//未参与分成

    const SEPARATED   	 		= 1;//已参与分成

    const CANCELE        		= 2;//取消可参与分成（既当前订单不可再参与分成）



    protected function __statusMap()
    {
        return [
            self::UNSEPARATE    => __('未参与分成', 'affiliate'),
            self::SEPARATED     => __('已参与分成', 'affiliate'),
            self::CANCELE    	=> __('取消可参与分成', 'affiliate'),
        ];
    }

}