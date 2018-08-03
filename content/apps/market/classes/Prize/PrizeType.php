<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/2
 * Time: 1:02 PM
 */

namespace Ecjia\App\Market\Prize;


class PrizeType
{

    /**
     * 未中奖
     */
    const TYPE_NONE     = 0;


    /**
     * 礼券红包
     */
    const TYPE_BONUS    = 1;

    /**
     * 实物奖品
     */
    const TYPE_REAL     = 2;

    /**
     * 积分奖励
     */
    const TYPE_INTEGRAL  = 3;

    /**
     * 商品展示
     */
    const TYPE_GOODS    = 4;

    /**
     * 店铺展示
     */
    const TYPE_STORE    = 5;

    /**
     * 现金红包
     */
    const TYPE_BALANCE  = 6;


    protected static $typeNames = [
        self::TYPE_NONE       => '未中奖',
        self::TYPE_BONUS      => '礼券红包',
        self::TYPE_REAL       => '实物奖品',
        self::TYPE_INTEGRAL   => '积分奖励',
        self::TYPE_GOODS      => '商品展示',
        self::TYPE_STORE      => '店铺展示',
        self::TYPE_BALANCE    => '现金红包',
    ];


    public static function getPrizeTypes()
    {
        return self::$typeNames;
    }


}