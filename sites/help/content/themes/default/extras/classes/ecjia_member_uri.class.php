<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/6
 * Time: 11:03 AM
 */

class ecjia_member_uri
{

    /**
     * 会员中心地址
     *
     * @return string
     */
    public static function home_url()
    {
        return RC_Uri::home_url() . '/sites/member/';
    }

    /**
     * 会员中心登录地址
     *
     * @return string
     */
    public static function login_url()
    {
        return RC_Uri::home_url() . '/sites/member/';
    }

    /**
     * 会员中心注册地址
     */
    public static function register_url()
    {
        $url = RC_Uri::url('user/privilege/register');

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 会员中心我的订单地址
     */
    public static function user_order_url()
    {
        $url = RC_Uri::url('user/order/init');

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 会员中心我的订单(待付款)地址
     */
    public static function user_order_await_pay_url()
    {
        $url = RC_Uri::url('user/order/init', array('type' => 'await_pay'));

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 会员中心我的订单(待收货)地址
     */
    public static function user_order_shipped_url()
    {
        $url = RC_Uri::url('user/order/init', array('type' => 'shipped'));

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 会员中心我的红包地址
     */
    public static function user_bonus_url()
    {
        $url = RC_Uri::url('user/bonus/init');

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 会员中心我的账户余额地址
     */
    public static function user_account_url()
    {
        $url = RC_Uri::url('user/account/init');

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 会员中心我的收货地址url
     */
    public static function user_address_url()
    {
        $url = RC_Uri::url('user/address/init');

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 会员中心我的推广地址
     */
    public static function user_spread_url()
    {
        $url = RC_Uri::url('user/spread/init');

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 会员中心我的账户安全地址
     */
    public static function user_safe_url()
    {
        $url = RC_Uri::url('user/index/safe');

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/member', $url);
    }

    /**
     * 商家入驻url
     */
    public static function merchant_franchisee_url()
    {
        $url = RC_Uri::url('franchisee/merchant/init');

        return str_replace(RC_Uri::site_url(), RC_Uri::home_url() . '/sites/merchant', $url);
    }

}
