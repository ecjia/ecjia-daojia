<?php

namespace Ecjia\App\Mobile;

use Royalcms\Component\Foundation\Object;

class MobileAction extends Object
{
    const MAIN              = 'main';    //主页
    const SINGIN            = 'singin';    //登录
    const SIGNUP            = 'signup';    //注册
    const FORGET_PASSWORD   = 'forget_password';  //忘记密码
    const DISCOVER          = 'discover'; //发现
    const QRCODE            = 'qrcode';    //二维码扫描
    const QRSHARE           = 'qrshare';  //二维码分享
    const HISTORY           = 'history';  //浏览记录
    const FEEDBACK          = 'feedback';    //咨询
    const MAP               = 'map';  //地图
    const MESSAGE           = 'message';  //消息中心
    const WEBVIEW           = 'webview';  //内置浏览器
    const SETTING           = 'setting';  //设置
    const LANGUAGE          = 'language'; //语言选择
    const CART              = 'cart'; //购物车
    const SEARCH            = 'search'; //搜索
    const HELP              = 'help'; //帮助中心
    const GOODS_LIST        = 'goods_list'; //商品列表
    const GOODS_COMMENT     = 'goods_comment'; //商品评论
    const GOODS_DETAIL      = 'goods_detail'; //商品详情
    const ORDERS_LIST       = 'orders_list'; //我的订单
    const ORDERS_DETAIL     = 'orders_detail'; //订单详情
    const USER_CENTER       = 'user_center'; //用户中心
    const USER_WALLET       = 'user_wallet'; //我的钱包
    const USER_ADDRESS      = 'user_address'; //地址管理
    const USER_ACCOUNT      = 'user_account'; //账户余额
    const USER_COLLECT      = 'user_collect'; //我的关注
    const USER_PASSWORD     = 'user_password'; //修改密码
    const SELLER            = 'seller'; //店铺街
    const MERCHANT          = 'merchant'; //店铺首页
    const MERCHANT_GOODS_LIST   = 'merchant_goods_list'; //店铺内分类商品
    const MERCHANT_SUGGEST_LIST = 'merchant_suggest_list'; //店铺内活动商品
    const MERCHANT_DETAIL       = 'merchant_detail'; //店铺详情
    
    
    public function opentype($opentype)
    {
        $method = 'get'.studly_case($opentype);
        
        if (method_exists($this, $method)) {
            $data = $this->$method();
            return new MobileOpenType($data['name'], $data['opentype'], $data['args']);
        }
    }
    
    /**
     * 主页
     * @return array
     */
    public function getMain()
    {
        return array(
        	'name'     => '主页',
            'opentype' => 'main',
            'args'     => [],
        );
    }
    
    /**
     * 登录
     * @return array
     */
    public function getSingin()
    {
        return array(
            'name'     => '登录',
            'opentype' => 'singin',
            'args'     => [],
        );
    }
    
    /**
     * 注册
     * @return array
     */
    public function getSignup()
    {
        return array(
            'name'     => '注册',
            'opentype' => 'signup',
            'args'     => [],
        );
    }
    
    /**
     * 忘记密码
     * @return array
     */
    public function getForgetPassword()
    {
        return array(
            'name'     => '忘记密码',
            'opentype' => 'forget_password',
            'args'     => [],
        );
    }
    
    /**
     * 发现
     * @return array
     */
    public function getDiscover()
    {
        return array(
            'name'     => '发现',
            'opentype' => 'discover',
            'args'     => [],
        );
    }
    
    /**
     * 二维码扫描
     * @return array
     */
    public function getQrcode()
    {
        return array(
            'name'     => '二维码扫描',
            'opentype' => 'qrcode',
            'args'     => [],
        );
    }
    
    /**
     * 二维码分享
     * @return array
     */
    public function getQrshare()
    {
        return array(
            'name'     => '二维码分享',
            'opentype' => 'qrshare',
            'args'     => [],
        );
    }
    
    /**
     * 浏览记录
     * @return array
     */
    public function getHistory()
    {
        return array(
            'name'     => '浏览记录',
            'opentype' => 'history',
            'args'     => [],
        );
    }
    
    /**
     * 咨询
     * @return array
     */
    public function getFeedback()
    {
        return array(
            'name'     => '咨询',
            'opentype' => 'feedback',
            'args'     => [],
        );
    }
    
    /**
     * 地图
     * @return array
     */
    public function getMap()
    {
        return array(
            'name'     => '地图',
            'opentype' => 'map',
            'args'     => [],
        );
    }
    
    /**
     * 消息中心
     * @return array
     */
    public function getMessage()
    {
        return array(
            'name'     => '消息中心',
            'opentype' => 'message',
            'args'     => [],
        );
    }
    
    /**
     * 内置浏览器
     * @return array
     */
    public function getWebview()
    {
        return array(
            'name'     => '内置浏览器',
            'opentype' => 'webview',
            'args'     => [
                'url' => 'URL'
            ],
        );
    }
    
    /**
     * 设置
     * @return array
     */
    public function getSetting()
    {
        return array(
            'name'     => '设置',
            'opentype' => 'setting',
            'args'     => [],
        );
    }
    
    /**
     * 语言选择
     * @return array
     */
    public function getLanguage()
    {
        return array(
            'name'     => '语言选择',
            'opentype' => 'language',
            'args'     => [],
        );
    }
    
    /**
     * 购物车
     * @return array
     */
    public function getCart()
    {
        return array(
            'name'     => '购物车',
            'opentype' => 'cart',
            'args'     => [],
        );
    }
    
    /**
     * 搜索
     * @return array
     */
    public function getSearch()
    {
        return array(
            'name'     => '搜索',
            'opentype' => 'search',
            'args'     => [
                'keyword' => '关键字'
            ],
        );
    }
    
    /**
     * 帮助中心
     * @return array
     */
    public function getHelp()
    {
        return array(
            'name'     => '帮助中心',
            'opentype' => 'help',
            'args'     => [],
        );
    }
    
    /**
     * 商品列表
     * @return array
     */
    public function getGoodsList()
    {
        return array(
            'name'     => '商品列表',
            'opentype' => 'goods_list',
            'args'     => [
                'category_id' => '商品分类ID'
            ],
        );
    }
    
    /**
     * 商品评论
     * @return array
     */
    public function getGoodsComment()
    {
        return array(
            'name'     => '商品评论',
            'opentype' => 'goods_comment',
            'args'     => [
                'goods_id' => '商品ID'
            ],
        );
    }
    
    /**
     * 商品详情
     * @return array
     */
    public function getGoodsDetail()
    {
        return array(
            'name'     => '商品详情',
            'opentype' => 'goods_detail',
            'args'     => [
                'goods_id' => '商品ID'
            ],
        );
    }
    
    /**
     * 我的订单
     * @return array
     */
    public function getOrdersList()
    {
        return array(
            'name'     => '我的订单',
            'opentype' => 'orders_list',
            'args'     => [],
        );
    }
    
    /**
     * 订单详情
     * @return array
     */
    public function getOrdersDetail()
    {
        return array(
            'name'     => '订单详情',
            'opentype' => 'orders_detail',
            'args'     => [
        		'order_id' => '订单ID'
        	],
        );
    }
    
    /**
     * 用户中心
     * @return array
     */
    public function getUserCenter()
    {
        return array(
            'name'     => '用户中心',
            'opentype' => 'user_center',
            'args'     => [],
        );
    }
    
    /**
     * 我的钱包
     * @return array
     */
    public function getUserWallet()
    {
        return array(
            'name'     => '我的钱包',
            'opentype' => 'user_wallet',
            'args'     => [],
        );
    }
    
    /**
     * 地址管理
     * @return array
     */
    public function getUserAddress()
    {
        return array(
            'name'     => '地址管理',
            'opentype' => 'user_address',
            'args'     => [],
        );
    }
    
    /**
     * 账户余额
     * @return array
     */
    public function getUserAccount()
    {
        return array(
            'name'     => '账户余额',
            'opentype' => 'user_account',
            'args'     => [],
        );
    }
    
    /**
     * 我的关注
     * @return array
     */
    public function getUserCollect()
    {
        return array(
            'name'     => '我的关注',
            'opentype' => 'user_collect',
            'args'     => [],
        );
    }
    
    /**
     * 修改密码
     * @return array
     */
    public function getUserPassword()
    {
        return array(
            'name'     => '修改密码',
            'opentype' => 'user_password',
            'args'     => [],
        );
    }
    
    /**
     * 店铺街
     * @return array
     */
    public function getSeller()
    {
        return array(
            'name'     => '店铺街',
            'opentype' => 'seller',
            'args'     => [
                'category_id' => '店铺街分类ID'
            ],
        );
    }
    
    /**
     * 店铺首页
     * @return array
     */
    public function getMerchant()
    {
        return array(
            'name'     => '店铺首页',
            'opentype' => 'merchant',
            'args'     => [
                'merchant_id' => '店铺ID'
            ],
        );
    }
    
    /**
     * 店铺内分类商品
     * @return array
     */
    public function getMerchantGoodsList()
    {
        return array(
            'name'     => '店铺内分类商品',
            'opentype' => 'merchant_goods_list',
            'args'     => [
                'merchant_id' => '店铺ID', 
                'category_id' => '店铺街分类ID'
            ],
        );
    }
    
    /**
     * 店铺内活动商品
     * @return array
     */
    public function getMerchantSuggestList()
    {
        return array(
            'name'     => '店铺内活动商品',
            'opentype' => 'merchant_suggest_list',
            'args'     => [
                'merchant_id' => '店铺ID',
                'type' => array('活动类型', '（best：精品推荐，hot：热销商品，new：新品推荐）'),
            ],
        );
    }
    
    /**
     * 店铺详情
     * @return array
     */
    public function getMerchantDetail()
    {
        return array(
            'name'     => '店铺详情',
            'opentype' => 'merchant_detail',
            'args'     => [
                'merchant_id' => '店铺ID'
            ],
        );
    }
    
    
}