<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    //address
    'address/add'           => 'user::address/add',
    'address/delete'        => 'user::address/delete',
    'address/info'          => 'user::address/info',
    'address/list'          => 'user::address/list',
    'address/setDefault'    => 'user::address/setDefault',
    'address/update'        => 'user::address/update',

    //article
    'article/category'      => 'api::article/category',//2.4+api(测试)
    'article/detail'        => 'article::article/detail',
	//article 1.0
    'article'				=> 'article::article/detail',

    //cart
    'cart/create'           => 'cart::cart/create',
    //'cart/gift/create'      => 'cart::cart/gift/create',//2.4+api(测试) //hyy 9.12
    'cart/delete'           => 'cart::cart/delete',
    'cart/list'             => 'cart::cart/list',
    'cart/update'           => 'cart::cart/update',
    'flow/checkOrder'       => 'cart::flow/checkOrder',
    'flow/done'             => 'cart::flow/done',

    //comments
	'comment/create'        => 'comment::goods/create',

    //feedback
    'feedback/list'         => 'feedback::feedback/list',
    'feedback/create'       => 'feedback::feedback/create',

    //goods
    'goods/category'        => 'goods::goods/category',
	'goods/list'        	=> 'goods::goods/list',
	'goods/suggestlist'     => 'goods::goods/suggestlist',
	'goods/groupbuygoods'   => 'groupbuy::groupbuygoods',
    'goods/comments'        => 'comment::goods/comments',
    'goods/detail'          => 'goods::goods/detail',
    'goods/desc'            => 'goods::goods/desc',
    'goods/brand'           => 'goods::goods/brand',
    'goods/price_range'     => 'goods::goods/price_range',
	/*商品店铺搜索*/
	'goods/search'		    	=> 'goods::goods/search',
    //goods 1.0
    'brand'					=> 'goods::goods/brand',
	'category'              => 'goods::goods/category',
	'comments'				=> 'comment::goods/comments',
	'goods'					=> 'goods::goods/detail',
	'price_range'			=> 'goods::goods/price_range',

    //home
    'home/category'         => 'goods::home/category',
    'home/data'             => 'mobile::home/data',
	'home/adsense'          => 'adsense::home/adsense',
	'home/discover'         => 'mobile::home/discover',
	'home/news'         	=> 'mobile::home/news',
	//home

    //order
    'order/affirmReceived'  => 'orders::order/affirmReceived',
    'order/cancel'          => 'orders::order/cancel',
    'order/list'            => 'orders::order/list',
    'order/pay'             => 'orders::order/pay',
    'order/detail'          => 'orders::order/detail',
    'order/update'          => 'orders::order/update',
    'order/express'         => 'orders::order/express',

    //shop
    'shop/config'           => 'setting::shop/config',
    'shop/server'           => 'setting::shop/server',
    'shop/region'           => 'setting::shop/region',
    'shop/payment'          => 'payment::shop/payment',
    'shop/help'             => 'article::shop/help',
    'shop/help/detail'      => 'article::shop/help/detail',


    //user
    'user/collect/create'   => 'user::user/collect/create',
    'user/collect/delete'   => 'user::user/collect/delete',
    'user/collect/list'     => 'user::user/collect/list',
    'user/info'             => 'user::user/info',
    'user/signin'           => 'user::user/signin',
	'user/signout'          => 'user::user/signout',
    'user/signup'           => 'user::user/signup',
	'user/update'           => 'user::user/update',
    'user/password'         => 'user::user/password',
    'user/signupFields'     => 'user::user/signupFields',
    'user/account/record'   => 'user::user/account/record',
    'user/account/log'      => 'user::user/account/log',
    'user/account/deposit'  => 'user::user/account/deposit',
    'user/account/pay'      => 'user::user/account/pay',
    'user/account/raply'    => 'user::user/account/raply',
    'user/account/cancel'   => 'user::user/account/cancel',
    'validate/bonus'        => 'user::validate/bonus',
    'validate/integral'     => 'user::validate/integral',

	'user/connect/signin'	=> 'user::user/connect/signin',
	'user/connect/signup'	=> 'user::user/connect/signup',

    //coupon
    'bonus/coupon'          => 'bonus::bonus/coupon',
    'receive/coupon'        => 'bonus::bonus/receive_coupon',

	//多商铺
	'seller/category'              => 'store::seller/category',
	'seller/list'                  => 'store::seller/list',
	'seller/search'                => 'store::seller/search',
	'seller/collect/list'          => 'store::seller/collect/list',
	'seller/collect/create'        => 'store::seller/collect/create',
	'seller/collect/delete'	       => 'store::seller/collect/delete',
	'merchant/config'              => 'store::merchant/config',
	'merchant/home/data'           => 'store::merchant/home/data',
	'merchant/goods/category'      => 'store::merchant/goods/category',
	'merchant/goods/list'          => 'store::merchant/goods/list',
	'merchant/goods/suggestlist'   => 'store::merchant/goods/suggestlist',

	//手机注册
	'user/userbind'     	=> 'user::user/userbind',
	'validate/bind'         => 'user::validate/bind',
	//第三方登录
	'user/snsbind'           => 'user::user/snsbind',

	//ecjia
	'admin/orders/list'			=> 'orders::admin/orders/list',
	'admin/orders/detail'		=> 'orders::admin/orders/detail',
	'admin/orders/cancel'		=> 'orders::admin/orders/cancel',


	'admin/goods/list'			=> 'goods::admin/goods/list',
	'admin/goods/detail'		=> 'goods::admin/goods/detail',
	'admin/goods/togglesale'	=> 'goods::admin/goods/togglesale',
	'admin/goods/trash'			=> 'goods::admin/goods/trash',
	'admin/goods/desc'			=> 'goods::admin/goods/desc',
	'admin/goods/product_search' => 'goods::admin/goods/product_search',


	'admin/user/signin'			=> 'user::v2/admin/user/signin',
    'admin/user/signout'		=> 'user::admin/user/signout',
    'admin/user/search' 		=> 'user::admin/user/search',
	'admin/user/userinfo'		=> 'user::v2/admin/user/userinfo',
	'admin/user/forget_request'	=> 'user::v2/admin/user/forget_request',
	'admin/user/forget_validate' => 'user::v2/admin/user/forget_validate',
	'admin/user/password' 		=> 'user::admin/user/password',

	'admin/home/data'			=> 'mobile::admin/home/data',
	'admin/shop/config'			=> 'setting::admin/shop/config',

	'admin/goods/category'		=> 'goods::admin/goods/category',
	'admin/goods/updatePrice'	=> 'goods::admin/goods/updateprice',
	'admin/merchant/info'		=> 'store::admin/merchant/info',
	'admin/merchant/update'		=> 'store::admin/merchant/update',
	//mobile
	'device/setDeviceToken' => 'mobile::device/setDeviceToken',


	'admin/connect/validate'	=> 'connect::admin/connect/validate',
	'admin/connect/signin'		=> 'connect::admin/connect/signin',

	'admin/flow/checkOrder'		=> 'cart::admin/flow/checkOrder',
	'admin/flow/done'			=> 'cart::admin/flow/done',
	'admin/goods/product_search' => 'goods::admin/goods/product_search',

	'admin/stats/orders'		=> 'orders::admin/stats/orders',
	'admin/stats/sales'			=> 'orders::admin/stats/sales',
	'admin/stats/sales_details'	=> 'orders::admin/stats/salesdetails',
	'admin/stats/visitor'		=> 'user::admin/stats/visitor',
	'admin/stats/order_sales'	=> 'orders::admin/stats/order_sales',


	'admin/order/split'			=> 'orders::admin/orders/split',
	'admin/order/receive'		=> 'orders::admin/orders/receive',
	'admin/order/update'		=> 'orders::admin/orders/update',



	'admin/order/payConfirm'	=> 'orders::admin/orders/payConfirm',	//收银台支付验证
	'admin/order/refundConfirm'	=> 'orders::admin/orders/refundConfirm',	//收银台退款验证
	'admin/order/check'			=> 'orders::admin/orders/check',	//收银台验单


	/* 消息*/
	'admin/message'				=> 'mobile::admin/message',

	'shop/token'           		=> 'setting::shop/token',

	'user/forget_password'      => 'user::user/forget_password',
	'validate/forget_password'  => 'user::validate/forget_password',
	'user/reset_password'       => 'user::user/reset_password',

	'goods/mobilebuygoods'		=> 'goods::goods/mobilebuygoods',

	'seller/home/data'			=> 'seller::home/data',


	//专题功能
	'topic/list'				=> 'topic::topic/list',
	'topic/info'				=> 'topic::topic/info',
	//扫码登录
	'mobile/qrcode/create'				=> 'mobile::qrcode/create',
	'mobile/qrcode/bind'				=> 'mobile::qrcode/bind',
	'mobile/qrcode/validate'			=> 'mobile::qrcode/validate',

	//后台咨询功能
	'admin/feedback/list'				=> 'feedback::admin/feedback/list',
	'admin/feedback/messages'			=> 'feedback::admin/feedback/messages',
	'admin/feedback/reply'				=> 'feedback::admin/feedback/reply',

	'goods/filter'          => 'goods::goods/filter',

	'order/comment'			=> 'comment::goods/detail',

	/* 入驻申请*/

	'admin/merchant/signup'			=> 'store::admin/merchant/signup',
	'admin/merchant/process'		=> 'store::admin/merchant/process',
	'admin/merchant/account/info' 	=> 'store::admin/account/info',
	'admin/merchant/account/validate'=>'store::admin/account/validate',
	'admin/merchant/validate'		=> 'store::admin/merchant/validate',


	/*掌柜1.1*/
	'admin/user/rank'           => 'user::admin/user/rank',
	'admin/favourable/list'		=> 'favourable::admin/favourable/list',
	'admin/favourable/add'		=> 'favourable::admin/favourable/manage',
	'admin/favourable/update'	=> 'favourable::admin/favourable/manage',
	'admin/favourable/info'		=> 'favourable::admin/favourable/info',
	'admin/favourable/delete'	=> 'favourable::admin/favourable/delete',
	'admin/goods/brand'			=> 'goods::admin/goods/brand',

	'admin/promotion/list'		=> 'promotion::admin/promotion/list',
	'admin/promotion/detail'	=> 'promotion::admin/promotion/detail',
	'admin/promotion/delete'	=> 'promotion::admin/promotion/delete',
	'admin/promotion/add'	    => 'promotion::admin/promotion/manage',
	'admin/promotion/update'	=> 'promotion::admin/promotion/manage',


	'mobile/checkin'			=> 'mobile::checkin/integral',
	'mobile/checkin/record'		=> 'mobile::checkin/record',

    'mobile/toutiao'		    => 'mobile::mobile/toutiao',

	/* o2o1.2*/
	'invite/user'				=> 'affiliate::invite/user',
	'invite/reward'				=> 'affiliate::invite/reward',
	'invite/record'				=> 'affiliate::invite/record',
	'invite/validate'			=> 'affiliate::invite/validate',

	'connect/signin'			=> 'connect::connect/signin',
	'connect/signup'			=> 'connect::connect/signup',
	'connect/bind'				=> 'connect::connect/bind',

	'shop/info'             	=> 'article::shop/info',
	'shop/info/detail'			=> 'article::shop/info/detail',

	'user/bonus'             	=> 'user::user/bonus',

	'device/setDeviceinfo' 	    => 'mobile::device/setDeviceinfo',

	//新增
	'merchant/goods/category'	=> 'store::merchant/goods/category',

	'goods/seller/list'			=> 'goods::seller/list',

    'cart/checked'              => 'cart::cart/checked', //购物车选中状态切换

    'admin/merchant/cancel'     => 'store::admin/merchant/cancel', //入驻撤销

    'admin/merchant/resignup'   => 'store::admin/merchant/resignup', //入驻修改信息提交

	'admin/merchant/preaudit'	=> 'store::admin/merchant/preaudit', //入驻修改获取信息
	
	/* o2o1.3*/
	'express/grab_list'			=> 'express::express/grab_list',
	'express/list'				=> 'express::express/list',
	'express/detail'			=> 'express::express/detail',
	'express/user/location'		=> 'express::express/user/location',
	'express/user/info'			=> 'express::express/user/info',
	'express/pickup'			=> 'express::express/pickup',
	'express/grab'				=> 'express::express/grab',
		
	'express/basicinfo'			=> 'express::express/basicinfo',
	'admin/user/update'			=> 'user::v2/admin/user/update',
	
	'admin/orders/delivery'		=> 'orders::admin/orders/delivery',
	'admin/user/account/validate'	=> 'user::admin/user/account/validate',
	'admin/user/account/update'	=> 'user::admin/user/account/update',

	'express/user/checkin'		=> 'express::express/user/checkin',
	'admin/merchant/notification'	=> 'notification::admin/merchant/notification',
	'admin/merchant/notification/read'	=> 'notification::admin/merchant/read',
);

// end
