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
	
    
    //cart
    'cart/create'           => 'cart::cart/create',
    //'cart/gift/create'      => 'cart::cart/gift/create',//2.4+api(测试) //hyy 9.12
    'cart/delete'           => 'cart::cart/delete',
    'cart/list'             => 'cart::cart/list',
    'cart/update'           => 'cart::cart/update',
    'flow/checkOrder'       => 'cart::flow/checkOrder',
    'flow/done'             => 'cart::flow/done',

    //goods
    'goods/category'        => 'goods::goods/category',
	'goods/list'        	=> 'goods::goods/list',
	'goods/suggestlist'     => 'goods::goods/suggestlist',
    'goods/detail'          => 'goods::goods/detail',
    'goods/desc'            => 'goods::goods/desc',
    'goods/brand'           => 'goods::goods/brand',
    'goods/price_range'     => 'goods::goods/price_range',
	'goods/search'		    => 'goods::goods/search', //商品店铺搜索
    'goods/filter'          => 'goods::goods/filter',
    
    'goods/seller/list'	    => 'goods::seller/list',
    
    //home
    'home/category'         => 'goods::home/category',
    'home/data'             => 'mobile::home/data',
	'home/adsense'          => 'adsense::home/adsense',
	'home/discover'         => 'mobile::home/discover',
	'home/news'         	=> 'mobile::home/news',

    //order
    'order/affirmReceived'  => 'orders::order/affirmReceived',
    'order/cancel'          => 'orders::order/cancel',
    'order/list'            => 'orders::order/list',
    'order/pay'             => 'payment::order/pay',
    'order/detail'          => 'orders::order/detail',
    'order/update'          => 'orders::order/update',
    'order/express'         => 'orders::order/express',

    //shop
    'shop/config'           => 'setting::shop/config',
    'shop/server'           => 'setting::shop/server',
    'shop/region'           => 'setting::shop/region',
	'shop/region/detail'	=> 'setting::shop/region/detail',
    'shop/payment'          => 'payment::shop/payment',
    'shop/help'             => 'article::shop/help',
    'shop/help/detail'      => 'article::shop/help/detail',
    'shop/info'             	=> 'article::shop/info',
    'shop/info/detail'			=> 'article::shop/info/detail',
    'shop/token'           	=> 'setting::shop/token',

    //user
    'user/info'             => 'user::user/info',
    'user/signin'           => 'user::user/signin',
	'user/signout'          => 'user::user/signout',
    'user/signup'           => 'user::user/signup',
	'user/update'           => 'user::user/update',
    'user/password'         => 'user::user/password',
    'user/signupFields'     => 'user::user/signupFields',
    'user/forget_password'  => 'user::user/forget_password',
    'user/reset_password'   => 'user::user/reset_password',
    'user/account/record'   => 'user::user/account/record',
    'user/account/log'      => 'user::user/account/log',
    'user/account/deposit'  => 'user::user/account/deposit',
    'user/account/pay'      => 'user::user/account/pay',
    'user/account/raply'    => 'user::user/account/raply',
    'user/account/cancel'   => 'user::user/account/cancel',
	'user/connect/signin'	=> 'user::user/connect/signin',
	'user/connect/signup'	=> 'user::user/connect/signup',
    'user/collect/create'   => 'user::user/collect/create',
    'user/collect/delete'   => 'user::user/collect/delete',
    'user/collect/list'     => 'user::user/collect/list',
    
    'validate/bonus'        => 'user::validate/bonus',
    'validate/integral'     => 'user::validate/integral',
    'validate/forget_password'  => 'user::validate/forget_password',

    //coupon
    'bonus/coupon'          => 'bonus::bonus/coupon',
    'receive/coupon'        => 'bonus::bonus/receive_coupon',

	//商家
	'seller/category'              => 'store::seller/category',
	'seller/list'                  => 'store::seller/list',
	'seller/search'                => 'store::seller/search',
	'seller/collect/list'          => 'store::seller/collect/list',
	'seller/collect/create'        => 'store::seller/collect/create',
	'seller/collect/delete'	       => 'store::seller/collect/delete',
	'merchant/config'              => 'store::merchant/config',
	'merchant/home/data'           => 'store::merchant/home/data',//1.6内容修改，1.5内容转移到merchant/config
    'merchant/home/category'       => 'store::merchant/home/category',//1.6新增
    'merchant/nearby'              => 'store::merchant/nearby',//1.6新增
	'merchant/goods/category'      => 'store::merchant/goods/category',
	'merchant/goods/list'          => 'store::merchant/goods/list',
	'merchant/goods/suggestlist'   => 'store::merchant/goods/suggestlist',

    

    'seller/home/data'			   => 'seller::home/data',
    
    
    //扫码登录
    'mobile/qrcode/create'		=> 'mobile::qrcode/create',
    'mobile/qrcode/bind'		=> 'mobile::qrcode/bind',
    'mobile/qrcode/validate'	=> 'mobile::qrcode/validate',
    
    //mobile device
    'device/setDeviceinfo' 	    => 'mobile::device/setDeviceinfo',
    'device/setDeviceToken'     => 'mobile::device/setDeviceToken',
    

    
    /* 邀请推广 */
    'invite/user'				=> 'affiliate::invite/user',
    'invite/reward'				=> 'affiliate::invite/reward',
    'invite/record'				=> 'affiliate::invite/record',
    'invite/validate'			=> 'affiliate::invite/validate',
    
    /* 第三方登录 */
    'connect/signin'			=> 'connect::connect/signin',
    'connect/signup'			=> 'connect::connect/signup',
    'connect/bind'				=> 'connect::connect/bind',

	
	
	'validate/bind'         => 'user::validate/bind',
    'user/userbind'     	=> 'user::user/userbind', //手机注册
	'user/snsbind'          => 'user::user/snsbind', //第三方绑定
    'user/bonus'            => 'user::user/bonus',
    'user/bind'             => 'user::user/bind',//1.5新增
    
    //comments
    'comment/create'        => 'comment::goods/create', //1.4新增
    'orders/comment'		=> 'orders::order/comment',   //1.4新增
    
    'goods/comments'        => 'comment::goods/comments',   //1.4新增
    'store/comments'        => 'comment::store/comments',//1.4新增
    
    'orders/comment/detail' => 'orders::order/comment/detail',//1.4新增

    
    'cart/checked'              => 'cart::cart/checked', //购物车选中状态切换
    
    //1.5
    'shop/captcha/sms'        => 'captcha::captcha/sms', //1.5新增
    'shop/captcha/mail'        => 'captcha::captcha/mail', //1.5新增
    
    
    /******************************************************************
     * 商家后台接口
     ******************************************************************/

	//商家后台订单
	'admin/orders/list'			=> 'orders::admin/orders/list',
	'admin/orders/detail'		=> 'orders::admin/orders/detail',
	'admin/orders/cancel'		=> 'orders::admin/orders/cancel',
    'admin/order/split'			=> 'orders::admin/orders/split',
    'admin/order/receive'		=> 'orders::admin/orders/receive',
    'admin/order/update'		=> 'orders::admin/orders/update',
    'admin/order/express'		=> 'orders::admin/orders/express',               //1.5新增
    'admin/order/consignee/list' => 'orders::admin/orders/consignee/list',          //1.5新增
    'admin/order/operate/consignee' => 'orders::admin/orders/operate/consignee',//1.5新增
    'admin/order/operate/money' => 'orders::admin/orders/operate/money',//1.5新增
    'admin/order/operate/shipping'	=> 'orders::admin/orders/operate/shipping',//1.5新增
    'admin/order/operate/shipping/detail' => 'orders::admin/orders/operate/shipping_detail',//1.5新增
    'admin/order/operate/pay' 	=> 'orders::admin/orders/operate/pay',//1.5新增
    'admin/order/operate/cancel'	=> 'orders::admin/orders/operate/cancel',//1.5新增
    'admin/order/operate/delivery'	=> 'orders::admin/orders/operate/delivery',//1.5新增
    'admin/order/operate/setgrab'	=> 'orders::admin/orders/operate/setgrab',//1.5新增
    'admin/order/operate/cancelgrab'	=> 'orders::admin/orders/operate/cancelgrab',//1.5新增
    'admin/order/shipping/list'	=> 'orders::admin/orders/shipping/list',//1.5新增
    'admin/orders/delivery'		    => 'orders::admin/orders/delivery',
    
    //商家收银台相关
    'admin/order/payConfirm'	=> 'orders::admin/orders/payConfirm',	//收银台支付验证
    'admin/order/refundConfirm'	=> 'orders::admin/orders/refundConfirm',	//收银台退款验证
    'admin/order/check'			=> 'orders::admin/orders/check',	//收银台验单
    'admin/order/quickpay'		=> 'orders::admin/orders/quickpay', //收银台快速收款

    //商家后台商品
	'admin/goods/list'			=> 'goods::admin/goods/list',
	'admin/goods/detail'		=> 'goods::admin/goods/detail',
	'admin/goods/togglesale'	=> 'goods::admin/goods/togglesale',
	'admin/goods/trash'			=> 'goods::admin/goods/trash',
	'admin/goods/desc'			=> 'goods::admin/goods/desc',
	'admin/goods/product_search' => 'goods::admin/goods/product_search',
    'admin/goods/brand'			=> 'goods::admin/goods/brand',
    'admin/goods/category'		=> 'goods::admin/goods/category',
    'admin/goods/updatePrice'	=> 'goods::admin/goods/updateprice',
    'admin/goods/add'			=> 'goods::admin/goods/add',//1.5新增
    'admin/goods/restore'		=> 'goods::admin/goods/restore',//1.5新增
    'admin/goods/update'		=> 'goods::admin/goods/update',//1.5新增
    'admin/goods/update/desc'	=> 'goods::admin/goods/updatedesc',//1.5新增
    'admin/goods/trash/list'				=> 'goods::admin/goods/trash/list',//1.5新增
    
    'admin/goods/promote/add'				=> 'goods::admin/goods/promote/add',//1.5新增
    'admin/goods/promote/update'			=> 'goods::admin/goods/promote/update',//1.5新增
    'admin/goods/promote/delete'			=> 'goods::admin/goods/promote/delete',//1.5新增
    
    'admin/goods/toggle/free_shipping'		=> 'goods::admin/goods/toggle/free_shipping',//1.5新增
    'admin/goods/toggle/suggest'			=> 'goods::admin/goods/toggle/suggest',//1.5新增
    'admin/goods/toggle/sale'				=> 'goods::admin/goods/toggle/sale',//1.5新增
    'admin/goods/toggle/gifts'				=> 'goods::admin/goods/toggle/gifts',//1.5新增
    
    'admin/goods/gallery/add'				=> 'goods::admin/goods/gallery/add',//1.5新增
    'admin/goods/gallery/sort'				=> 'goods::admin/goods/gallery/sort',//1.5新增
    'admin/goods/gallery/delete'			=> 'goods::admin/goods/gallery/delete',//1.5新增
    'admin/goods/gallery/delete/batch'      => 'goods::admin/goods/gallery/delete_batch',//1.5新增
    'admin/goods/move/category'				=> 'goods::admin/goods/move/category',//1.5新增
    
    'admin/goods/merchant/category/list'	=> 'goods::admin/goods/merchant/category/list',//1.5新增，1.5废弃
    'admin/goods/merchant/category/add'		=> 'goods::admin/goods/merchant/category/add',//1.5新增，1.5废弃
    'admin/goods/merchant/category/detail'	=> 'goods::admin/goods/merchant/category/detail',//1.5新增，1.5废弃
    'admin/goods/merchant/category/update'	=> 'goods::admin/goods/merchant/category/update',//1.5新增，1.5废弃
    'admin/goods/merchant/category/show'	=> 'goods::admin/goods/merchant/category/show',//1.5新增，1.5废弃
    'admin/goods/merchant/category/delete'	=> 'goods::admin/goods/merchant/category/delete',//1.5新增，1.5废弃
    
    'admin/merchant/goods/category/list'	=> 'goods::admin/goods/merchant/category/list',//1.5新增
    'admin/merchant/goods/category/add'		=> 'goods::admin/goods/merchant/category/add',//1.5新增
    'admin/merchant/goods/category/detail'	=> 'goods::admin/goods/merchant/category/detail',//1.5新增
    'admin/merchant/goods/category/update'	=> 'goods::admin/goods/merchant/category/update',//1.5新增
    'admin/merchant/goods/category/show'	=> 'goods::admin/goods/merchant/category/show',//1.5新增
    'admin/merchant/goods/category/delete'	=> 'goods::admin/goods/merchant/category/delete',//1.5新增

    //商家后台用户
	'admin/user/signin'			=> 'user::v2/admin/user/signin',
    'admin/user/signout'		=> 'user::admin/user/signout',
    'admin/user/search' 		=> 'user::admin/user/search',
    'admin/user/rank'           => 'user::admin/user/rank',
	'admin/user/userinfo'		=> 'user::v2/admin/user/userinfo',
    'admin/user/info'			=> 'user::admin/user/info',//1.5新增
	'admin/user/forget_request'	=> 'user::v2/admin/user/forget_request',
	'admin/user/forget_validate' => 'user::v2/admin/user/forget_validate',
	'admin/user/password' 		=> 'user::admin/user/password',
    'admin/user/bind'           => 'user::admin/user/bind', //1.5新增
    'admin/user/update'			=> 'user::v2/admin/user/update',
    
    'admin/user/account/validate'	=> 'user::admin/user/account/validate', //1.5废弃，换用admin/shop/captcha/sms/
    'admin/user/account/update'	    => 'user::admin/user/account/update', //1.5废弃，换用admin/user/update
    
    //后台验证码
    'admin/shop/captcha/sms'        => 'captcha::captcha/admin/sms',   //1.5新增
    'admin/shop/captcha/mail'       => 'captcha::captcha/admin/mail',  //1.5新增
    

	'admin/home/data'			=> 'mobile::admin/home/data',
    
	'admin/shop/config'			=> 'setting::admin/shop/config',
    'admin/shop/attach/add'	    => 'mobile::admin/shop/attach/add',//1.5新增
	
	'admin/merchant/info'		=> 'store::admin/merchant/info',
	'admin/merchant/update'		=> 'store::admin/merchant/update',
	


	'admin/connect/validate'	=> 'connect::admin/connect/validate',
	'admin/connect/signin'		=> 'connect::admin/connect/signin',

	'admin/flow/checkOrder'		=> 'cart::admin/flow/checkOrder',
	'admin/flow/done'			=> 'cart::admin/flow/done',
	
    /* 消息*/
    'admin/message'				=> 'mobile::admin/message',

    //商家订单统计
	'admin/stats/orders'		=> 'orders::admin/stats/orders',
	'admin/stats/sales'			=> 'orders::admin/stats/sales',
	'admin/stats/sales_details'	=> 'orders::admin/stats/salesdetails',
	'admin/stats/visitor'		=> 'user::admin/stats/visitor',
	'admin/stats/order_sales'	=> 'orders::admin/stats/order_sales',

	/* 入驻申请*/
	'admin/merchant/signup'			=> 'store::admin/merchant/signup',
	'admin/merchant/process'		=> 'store::admin/merchant/process',
	'admin/merchant/account/info' 	=> 'store::admin/account/info',
	'admin/merchant/account/validate'=>'store::admin/account/validate',
	'admin/merchant/validate'		=> 'store::admin/merchant/validate',
    'admin/merchant/cancel'     => 'store::admin/merchant/cancel', //入驻撤销
    'admin/merchant/resignup'   => 'store::admin/merchant/resignup', //入驻修改信息提交
    'admin/merchant/preaudit'	=> 'store::admin/merchant/preaudit', //入驻修改获取信息
    
    /*商家通知*/
    'admin/merchant/notification'	=> 'notification::admin/merchant/notification',
    'admin/merchant/notification/read'	=> 'notification::admin/merchant/read',
    'admin/merchant/notification/unread_count'	=> 'notification::admin/merchant/unread_count',

	/*商家满折满减满送活动*/
	'admin/favourable/list'		=> 'favourable::admin/favourable/list',
	'admin/favourable/add'		=> 'favourable::admin/favourable/manage',
	'admin/favourable/update'	=> 'favourable::admin/favourable/manage',
	'admin/favourable/info'		=> 'favourable::admin/favourable/info',
	'admin/favourable/delete'	=> 'favourable::admin/favourable/delete',
	
    /*商家促销活动*/
	'admin/promotion/list'		=> 'promotion::admin/promotion/list',
	'admin/promotion/detail'	=> 'promotion::admin/promotion/detail',
	'admin/promotion/delete'	=> 'promotion::admin/promotion/delete',
	'admin/promotion/add'	    => 'promotion::admin/promotion/manage',
	'admin/promotion/update'	=> 'promotion::admin/promotion/manage',

    //配送员
	'express/grab_list'			=> 'express::express/grab_list',     //1.5废弃
	'express/list'				=> 'express::express/list',          //1.5废弃
	'express/detail'			=> 'express::express/detail',        //1.5废弃
	'express/user/location'		=> 'express::express/user/location', //1.5废弃
	'express/user/info'			=> 'express::express/user/info',     //1.5废弃
	'express/user/checkin'      => 'express::express/user/checkin',  //1.5废弃
	'express/pickup'			=> 'express::express/pickup',        //1.5废弃
	'express/grab'				=> 'express::express/grab',	         //1.5废弃
	'express/basicinfo'			=> 'express::express/basicinfo',     //1.5废弃
    
    'admin/express/grab_list'		=> 'express::express/grab_list',         //1.5新增
    'admin/express/list'			=> 'express::express/list',              //1.5新增
    'admin/express/detail'			=> 'express::express/detail',            //1.5新增
    'admin/express/pickup'			=> 'express::express/pickup',            //1.5新增
    'admin/express/grab'			=> 'express::express/grab',              //1.5新增
    'admin/express/basicinfo'	    => 'express::express/basicinfo',         //1.5新增
    'admin/express/user/location'	=> 'express::express/user/location',     //1.5新增
    'admin/express/user/info'		=> 'express::express/user/info',         //1.5新增
    'admin/express/user/checkin'    => 'express::express/user/checkin',      //1.5新增
    
	'article/category'				=> 'article::article/category',			 //1.6
	'article/list'					=> 'article::article/list',				 //1.6
	'article/suggestlist'			=> 'article::article/suggestlist',		 //1.6
	'article/comment/create'		=> 'article::article/comment/create',	 //1.6
	'article/comments'				=> 'article::article/comment/comments',	 //1.6
	'article/like/add'				=> 'article::article/like/like_manage',  //1.6
	'article/like/cancel'			=> 'article::article/like/like_manage',  //1.6
	'article/detail'				=> 'article::article/detail',  			 //1.6
	'article/home/cycleimage'		=> 'article::article/home/cycleimage',   //1.6
	
	'weapp/wxlogin'					=> 'weapp::weapp/wxlogin',	//小程序登录
	'weapp/wxbind'					=> 'weapp::weapp/wxbind',	//小程序绑定用户
	'weapp/wxpay'					=> 'weapp::weapp/wxpay',	//小程序微信支付
	
	'admin/merchant/refreshQrcode'	=> 'store::admin/merchant/refreshQrcode',	//1.7 掌柜店铺刷新二维码
	
	'market/shake'				=> 'market::activity/shake',   		//1.6增加 摇一摇
	'admin/orders/today'		=> 'orders::admin/orders/today',	//1.6增加 商家今日订单
    
	
    /** 1.0 已经废弃
     * article 
     * 'article'				=> 'article::article/detail',
     * 
     * goods
     * 'brand'					=> 'goods::goods/brand',
     * 'category'               => 'goods::goods/category',
     * 'comments'				=> 'comment::goods/comments',
     * 'goods'					=> 'goods::goods/detail',
     * 'price_range'			=> 'goods::goods/price_range',
     */

    
		
		
		
    
    
);

// end
