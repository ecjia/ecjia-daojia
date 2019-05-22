<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-19
 * Time: 11:22
 */

class ecjia_open_handler
{


    public static function macro()
    {

        //首页
        ecjia_open::macro('main', [__CLASS__, 'open_main']);
        //我的订单
        ecjia_open::macro('orders_list', [__CLASS__, 'open_orders_list']);
        //订单详情
        ecjia_open::macro('orders_detail', [__CLASS__, 'open_orders_detail']);
        //收货地址
        ecjia_open::macro('user_address', [__CLASS__, 'open_user_address']);
        //帮助中心
        ecjia_open::macro('help', [__CLASS__, 'open_help']);
        //用户中心
        ecjia_open::macro('user_center', [__CLASS__, 'open_user_center']);
        //商品详情
        ecjia_open::macro('goods_detail', [__CLASS__, 'open_goods_detail']);
        //商品评论
        ecjia_open::macro('goods_comment', [__CLASS__, 'open_goods_comment']);
        //发现
        ecjia_open::macro('discover', [__CLASS__, 'open_user_discover']);
        //钱包
        ecjia_open::macro('user_wallet', [__CLASS__, 'open_user_wallet']);
        //购物车
        ecjia_open::macro('cart', [__CLASS__, 'open_cart']);
        //我的余额
        ecjia_open::macro('user_account', [__CLASS__, 'open_user_account']);
        //注册
        ecjia_open::macro('sign_up', [__CLASS__, 'open_sign_up']);
        //找回密码
        ecjia_open::macro('forget_password', [__CLASS__, 'open_forget_password']);
        //修改密码
        ecjia_open::macro('user_password', [__CLASS__, 'open_user_password']);
        //促销商品/新品
        ecjia_open::macro('goods_suggest', [__CLASS__, 'open_goods_suggest']);
        //店铺分类列表
        ecjia_open::macro('goods_seller_list', [__CLASS__, 'open_goods_seller_list']);
        //所有分类
        ecjia_open::macro('goods_list', [__CLASS__, 'open_goods_list']);
        //店铺列表
        ecjia_open::macro('seller', [__CLASS__, 'open_seller']);
        //我的红包
        ecjia_open::macro('user_bonus', [__CLASS__, 'open_user_bonus']);
        //店铺优惠买单
        ecjia_open::macro('quickpay', [__CLASS__, 'open_quickpay']);
        //收款二维码
        ecjia_open::macro('collectmoney', [__CLASS__, 'open_collectmoney']);
        //历史记录
        ecjia_open::macro('history', [__CLASS__, 'open_history']);
        //店铺首页
        ecjia_open::macro('merchant', [__CLASS__, 'open_merchant']);

    }

    /**
     * 首页
     * @param $querys
     * @return string
     */
    public static function open_main($querys)
    {
        return RC_Uri::url('touch/index/init');
    }

    /**
     * 我的订单
     * @param $querys
     * @return string
     */
    public static function open_orders_list($querys)
    {
        return RC_Uri::url('user/order/order_list');
    }

    /**
     * 订单详情
     * @param $querys
     * @return string
     */
    public static function open_orders_detail($querys)
    {
        return RC_Uri::url('user/order/order_detail', array('order_id' => $querys['order_id']));
    }

    /**
     * 收货地址
     * @param $querys
     * @return string
     */
    public static function open_user_address($querys)
    {
        return RC_Uri::url('user/address/address_list');
    }

    /**
     * 帮助中心
     * @param $querys
     * @return string
     */
    public static function open_help($querys)
    {
        return RC_Uri::url('article/help/init');
    }

    /**
     * 用户中心
     * @param $querys
     * @return string
     */
    public static function open_user_center($querys) {
        return RC_Uri::url('user/profile/init');
    }

    /**
     * 商品详情
     * @param $querys
     * @return string
     */
    public static function open_goods_detail($querys)
    {
        return RC_Uri::url('goods/index/show', array('goods_id' => $querys['goods_id']));
    }

    /**
     * 商品评论
     * @param $querys
     * @return string
     */
    public static function open_goods_comment($querys)
    {
        return RC_Uri::url('goods/index/show', array('goods_id' => $querys['goods_id']));
    }

    /**
     * 发现
     * @param $querys
     * @return string
     */
    public static function open_discover($querys)
    {
        return RC_Uri::url('article/index/init');
    }

    /**
     * 钱包
     * @param $querys
     * @return string
     */
    public static function open_user_wallet($querys) {
        return RC_Uri::url('user/account/init');
    }

    /**
     * 购物车
     * @param $querys
     * @return string
     */
    public static function open_cart($querys)
    {
        return RC_Uri::url('cart/index/init');
    }

    /**
     * 我的余额
     * @param $querys
     * @return string
     */
    public static function open_user_account($querys)
    {
        return RC_Uri::url('user/account/balance');
    }

    /**
     * 注册
     * @param $querys
     * @return string
     */
    public static function open_sign_up($querys)
    {
        return RC_Uri::url('user/privilege/login');
    }

    /**
     * 找回密码
     * @param $querys
     * @return string
     */
    public static function open_forget_password($querys) {
        return RC_Uri::url('user/get_password/init');
    }

    /**
     * 修改密码
     * @param $querys
     * @return string
     */
    public static function open_user_password($querys)
    {
        return RC_Uri::url('user/profile/edit_password');
    }

    /**
     * 促销商品/新品
     * @param $querys
     * @return string
     */
    public static function open_goods_suggest($querys)
    {
        if ($querys['type'] == 'promotion') {
            return RC_Uri::url('goods/index/promotion');
        } elseif ($querys['type'] == 'new') {
            return RC_Uri::url('goods/index/new');
        }
    }

    /**
     * 店铺分类列表
     * @param $querys
     * @return string
     */
    public static function open_goods_seller_list($querys)
    {
        return RC_Uri::url('goods/category/store_list', array('cid' => $querys['category_id']));
    }

    /**
     * 所有分类
     * @param $querys
     * @return string
     */
    public static function open_goods_list($querys)
    {
        return RC_Uri::url('goods/category/init', array('category_id' => $querys['category_id']));
    }

    /**
     * 店铺列表
     * @param $querys
     * @return string
     */
    public static function open_seller($querys)
    {
        if (!empty($querys['category_id'])) {
            return RC_Uri::url('merchant/category/list', array('cid' => $querys['category_id']));
        } else {
            return RC_Uri::url('merchant/category/list');
        }
    }

    /**
     * 我的红包
     * @param $querys
     * @return string
     */
    public static function open_user_bonus($querys)
    {
        return RC_Uri::url('user/bonus/init', array('type' => $querys['type']));
    }

    /**
     * 店铺优惠买单
     * @param $querys
     * @return string
     */
    public static function open_quickpay($querys)
    {
        return RC_Uri::url('user/quickpay/init', array('store_id' => $querys['merchant_id']));
    }

    /**
     * 收款二维码
     * @param $querys
     * @return string
     */
    public static function open_collectmoney($querys)
    {
        return RC_Uri::url('merchant/quickpay/collectmoney', array('store_id' => $querys['merchant_id']));
    }

    /**
     * 历史记录
     * @param $querys
     * @return string
     */
    public static function open_history($querys)
    {
        return RC_Uri::url('touch/index/search');
    }

    /**
     * 店铺首页
     * @param $querys
     * @return string
     */
    public static function open_merchant($querys)
    {
        return RC_Uri::url('merchant/index/init', array('store_id' => $querys['merchant_id']));
    }




}