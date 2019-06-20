<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 02:40
 */

namespace Ecjia\App\Cart\Enums;


use Royalcms\Component\Enum\Enum;

class CartEnum extends Enum
{

    /**
     * 普通商品
     * @var int
     */
    const CART_GENERAL_GOODS        = 0;

    /**
     * 团购商品
     * @var int
     */
    const CART_GROUP_BUY_GOODS      = 1;

    /**
     * 拍卖商品
     * @var int
     */
    const CART_AUCTION_GOODS        = 2;

    /**
     * 夺宝奇兵
     * @var int
     */
    const CART_SNATCH_GOODS         = 3;

    /**
     * 积分商城
     * @var int
     */
    const CART_EXCHANGE_GOODS       = 4;

    /**
     * 移动专享
     * @var int
     */
    const CART_MOBILE_BUY_GOODS     = 100;

    /**
     * 收银台
     * @var int
     */
    const CART_CASHDESK_GOODS       = 11;

    /**
     * 到店购物
     * @var int
     */
    const CART_STOREBUY_GOODS       = 12;


    protected function __statusMap()
    {
        return [
            self::CART_GENERAL_GOODS            => __('普通商品', 'cart'),
            self::CART_GROUP_BUY_GOODS          => __('团购商品', 'cart'),
            self::CART_AUCTION_GOODS            => __('拍卖商品', 'cart'),
            self::CART_SNATCH_GOODS             => __('夺宝奇兵', 'cart'),
            self::CART_EXCHANGE_GOODS           => __('积分商城', 'cart'),
            self::CART_MOBILE_BUY_GOODS         => __('移动专享', 'cart'),
            self::CART_CASHDESK_GOODS           => __('收银台', 'cart'),
            self::CART_STOREBUY_GOODS           => __('到店购物', 'cart'),
        ];
    }
}