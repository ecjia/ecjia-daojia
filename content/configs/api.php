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
    'address/add'                   => 'user::address/add',
    'address/delete'                => 'user::address/delete',
    'address/info'                  => 'user::address/info',
    'address/list'                  => 'user::address/list',
    'address/setDefault'            => 'user::address/setDefault',
    'address/update'                => 'user::address/update',

    //cart
    'cart/create'                   => 'cart::cart/create',
    'cart/delete'                   => 'cart::cart/delete',
    'cart/list'                     => 'cart::cart/list',
    'cart/update'                   => 'cart::cart/update',
    'cart/buyagain'                 => 'cart::cart/buyagain',
    'flow/checkOrder'               => 'cart::flow/checkOrder',
    'flow/done'                     => 'cart::flow/done',

    //goods
    'goods/category'                => 'goods::goods/category',
	'goods/list'        	        => 'goods::goods/list',
	'goods/suggestlist'             => 'goods::goods/suggestlist',
    'goods/detail'                  => 'goods::goods/detail',
    'goods/desc'                    => 'goods::goods/desc',
    'goods/brand'                   => 'goods::goods/brand',
    'goods/price_range'             => 'goods::goods/price_range',
	'goods/search'		            => 'goods::goods/search', //商品店铺搜索
    'goods/filter'                  => 'goods::goods/filter',
    'goods/seller/list'	            => 'goods::seller/list',
    
    //home
    'home/category'                 => 'goods::home/category',
    'home/data'                     => 'mobile::home/data',
	'home/adsense'                  => 'adsense::home/adsense',
	'home/discover'                 => 'mobile::home/discover',
	'home/news'         	        => 'mobile::home/news',

    //order
    'order/affirmReceived'          => 'orders::order/affirmReceived',
    'order/cancel'                  => 'orders::order/cancel',
    'order/list'                    => 'orders::order/list',
    'order/pay'                     => 'payment::order/pay',
    'order/detail'                  => 'orders::order/detail',
    'order/update'                  => 'orders::order/update',
    'order/express'                 => 'orders::order/express',

    //shop
    'shop/config'                   => 'setting::shop/config',
    'shop/server'                   => 'setting::shop/server',
    'shop/region'                   => 'setting::shop/region',
	'shop/region/detail'	        => 'setting::shop/region/detail',
    'shop/payment'                  => 'payment::shop/payment',
    'shop/help'                     => 'article::shop/help',
    'shop/help/detail'              => 'article::shop/help/detail',
    'shop/info'                     => 'article::shop/info',
    'shop/info/detail'		        => 'article::shop/info/detail',
    'shop/token'           	        => 'setting::shop/token',

    //user
    'user/info'                     => 'user::user/info',
    'user/signin'                   => 'user::user/signin',
	'user/signout'                  => 'user::user/signout',
    'user/signup'                   => 'user::user/signup',
	'user/update'                   => 'user::user/update',
    'user/password'                 => 'user::user/password',
    'user/signupFields'             => 'user::user/signupFields',
    'user/forget_password'          => 'user::user/forget_password',
    'user/reset_password'           => 'user::user/reset_password',
    'user/account/record'           => 'user::user/account/record',
    'user/account/log'              => 'user::user/account/log',
    'user/account/deposit'          => 'user::user/account/deposit',
    'user/account/pay'              => 'user::user/account/pay',
    'user/account/raply'            => 'user::user/account/raply',
    'user/account/cancel'           => 'user::user/account/cancel',
    'user/collect/create'           => 'user::user/collect/create',
    'user/collect/delete'           => 'user::user/collect/delete',
    'user/collect/list'             => 'user::user/collect/list',
    
    'validate/bonus'                => 'user::validate/bonus',
    'validate/integral'             => 'user::validate/integral',
    'validate/forget_password'      => 'user::validate/forget_password',

    //coupon
    'bonus/coupon'                  => 'bonus::bonus/coupon',
    'receive/coupon'                => 'bonus::bonus/receive_coupon',

	//商家
	'seller/category'               => 'merchant::seller/category',
	'seller/list'                   => 'merchant::seller/list',
	'seller/search'                 => 'merchant::seller/search',
	'seller/collect/list'           => 'merchant::seller/collect/list',
	'seller/collect/create'         => 'merchant::seller/collect/create',
	'seller/collect/delete'	        => 'merchant::seller/collect/delete',
	'merchant/config'               => 'merchant::merchant/config',
    'seller/home/data'			    => 'merchant::merchant/home/data',
	'merchant/home/data'            => 'merchant::merchant/home/data',//1.6内容修改，1.5内容转移到merchant/config
    'merchant/home/category'        => 'merchant::merchant/home/category',//1.6新增
    'merchant/nearby'               => 'merchant::merchant/nearby',//1.6新增
	'merchant/goods/category'       => 'merchant::merchant/goods/category',
	'merchant/goods/list'           => 'merchant::merchant/goods/list',
	'merchant/goods/suggestlist'    => 'merchant::merchant/goods/suggestlist',
    
    //扫码登录
    'mobile/qrcode/create'		    => 'mobile::qrcode/create',
    'mobile/qrcode/bind'		    => 'mobile::qrcode/bind',
    'mobile/qrcode/validate'	    => 'mobile::qrcode/validate',
    
    //mobile device
    'device/setDeviceinfo' 	        => 'mobile::device/setDeviceinfo',
    'device/setDeviceToken'         => 'mobile::device/setDeviceToken',
    

    
    /* 邀请推广 */
    'invite/user'				    => 'affiliate::invite/user',
    'invite/reward'				    => 'affiliate::invite/reward',
    'invite/record'				    => 'affiliate::invite/record',
    'invite/validate'			    => 'affiliate::invite/validate',
    
    /* 第三方登录 */
    'connect/signin'			    => 'connect::connect/signin',
    'connect/signup'			    => 'connect::connect/signup',
    'connect/bind'				    => 'connect::connect/bind',

	
	
	'validate/bind'                 => 'user::validate/bind',
    'user/userbind'     	        => 'user::user/userbind', //手机注册
	'user/snsbind'                  => 'user::user/snsbind', //第三方绑定
    'user/bonus'                    => 'user::user/bonus',
    'user/bind'                     => 'user::user/bind',//1.5新增
    
    //comments
    'comment/create'                => 'comment::goods/create', //1.4新增
    'orders/comment'		        => 'orders::order/comment',   //1.4新增
    
    'goods/comments'                => 'comment::goods/comments',   //1.4新增
    'store/comments'                => 'comment::store/comments',//1.4新增
    
    'orders/comment/detail'         => 'orders::order/comment/detail',//1.4新增

    
    'cart/checked'                  => 'cart::cart/checked', //购物车选中状态切换
    
    //1.5
    'shop/captcha/sms'              => 'captcha::shop/captcha/sms', //1.5新增
    'shop/captcha/mail'             => 'captcha::shop/captcha/mail', //1.5新增
    
    
    /******************************************************************
     * 商家后台接口
     ******************************************************************/

	//商家后台订单
    'admin/orders/list'			    => 'orders::admin/orders/list',
	'admin/orders/detail'		    => 'orders::admin/orders/detail',
	'admin/orders/cancel'		    => 'orders::admin/orders/cancel',
    'admin/order/split'			    => 'orders::admin/orders/split',
    'admin/order/receive'		    => 'orders::admin/orders/receive',
    'admin/order/update'		    => 'orders::admin/orders/update',
    'admin/order/express'		    => 'orders::admin/orders/express',               //1.5新增
    'admin/order/consignee/list'    => 'orders::admin/orders/consignee/list',          //1.5新增
    'admin/order/operate/consignee' => 'orders::admin/orders/operate/consignee',//1.5新增
    'admin/order/operate/money'     => 'orders::admin/orders/operate/money',//1.5新增
    'admin/order/operate/shipping'	=> 'orders::admin/orders/operate/shipping',//1.5新增
    'admin/order/operate/shipping/detail'   => 'orders::admin/orders/operate/shipping_detail',//1.5新增
    'admin/order/operate/pay' 	    => 'orders::admin/orders/operate/pay',//1.5新增
    'admin/order/operate/cancel'	=> 'orders::admin/orders/operate/cancel',//1.5新增
    'admin/order/operate/delivery'	=> 'orders::admin/orders/operate/delivery',//1.5新增
    'admin/order/operate/setgrab'	=> 'orders::admin/orders/operate/setgrab',//1.5新增
    'admin/order/operate/cancelgrab'	    => 'orders::admin/orders/operate/cancelgrab',//1.5新增
    'admin/order/shipping/list'	    => 'orders::admin/orders/shipping/list',//1.5新增
    'admin/orders/delivery'		    => 'orders::admin/orders/delivery',
    
    //商家收银台相关
    'admin/order/payConfirm'	    => 'orders::admin/orders/payConfirm',	//收银台支付验证
    'admin/order/refundConfirm'	    => 'orders::admin/orders/refundConfirm',	//收银台退款验证
    'admin/order/check'			    => 'orders::admin/orders/check',	//收银台验单
    'admin/order/quickpay'		    => 'orders::admin/orders/quickpay', //收银台快速收款
	'admin/stats/payment' 		    => 'orders::admin/stats/payment',   //收银台收银统计
	'admin/order/pay'               => 'orders::admin/orders/pay',//收银台付款

    //商家后台商品
	'admin/goods/list'			    => 'goods::admin/goods/list',
	'admin/goods/detail'		    => 'goods::admin/goods/detail',
	'admin/goods/togglesale'	    => 'goods::admin/goods/togglesale',
	'admin/goods/trash'			    => 'goods::admin/goods/trash',
	'admin/goods/desc'			    => 'goods::admin/goods/desc',
	'admin/goods/product_search'    => 'goods::admin/goods/product_search',
    'admin/goods/brand'			    => 'goods::admin/goods/brand',
    'admin/goods/category'		    => 'goods::admin/goods/category',
    'admin/goods/updatePrice'	    => 'goods::admin/goods/updateprice',
    'admin/goods/add'			    => 'goods::admin/goods/add',//1.5新增
    'admin/goods/restore'		    => 'goods::admin/goods/restore',//1.5新增
    'admin/goods/update'		    => 'goods::admin/goods/update',//1.5新增
    'admin/goods/update/desc'	    => 'goods::admin/goods/updatedesc',//1.5新增
    'admin/goods/trash/list'		=> 'goods::admin/goods/trash/list',//1.5新增
    
    'admin/goods/promote/add'		=> 'goods::admin/goods/promote/add',//1.5新增
    'admin/goods/promote/update'	=> 'goods::admin/goods/promote/update',//1.5新增
    'admin/goods/promote/delete'	=> 'goods::admin/goods/promote/delete',//1.5新增
    
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
	'admin/user/signin'			    => 'staff::v2/admin/user/signin',
    'admin/user/signout'		    => 'staff::admin/user/signout',
    'admin/user/search' 		    => 'staff::admin/user/search',
    'admin/user/rank'               => 'staff::admin/user/rank',
	'admin/user/userinfo'		    => 'staff::v2/admin/user/userinfo',
    'admin/user/info'			    => 'staff::admin/user/info',//1.5新增
    'admin/user/bind'               => 'staff::admin/user/bind', //1.5新增
    'admin/user/update'			    => 'staff::v2/admin/user/update',
    
    'admin/user/account/validate'	=> 'staff::admin/user/account/validate', //1.5废弃，换用admin/shop/captcha/sms/
    'admin/user/account/update'	    => 'staff::admin/user/account/update', //1.5废弃，换用admin/user/update
    
    //后台验证码
    'admin/shop/captcha/sms'        => 'captcha::admin/shop/captcha/sms',   //1.5新增
    'admin/shop/captcha/mail'       => 'captcha::admin/shop/captcha/mail',  //1.5新增
    

	'admin/home/data'			    => 'mobile::admin/home/data',
    
	'admin/shop/config'			    => 'setting::admin/shop/config',
    'admin/shop/attach/add'	        => 'mobile::admin/shop/attach/add',//1.5新增
    'admin/shop/token'              => 'setting::admin/shop/token', //1.10新增
	
	'admin/merchant/info'		    => 'merchant::admin/merchant/info',
	'admin/merchant/update'		    => 'merchant::admin/merchant/update',

	'admin/flow/checkOrder'		    => 'cart::admin/flow/checkOrder',
	'admin/flow/done'			    => 'cart::admin/flow/done',
	
    /* 消息*/
    'admin/message'				    => 'mobile::admin/message',

    //商家订单统计
	'admin/stats/orders'		    => 'orders::admin/stats/orders',
	'admin/stats/sales'			    => 'orders::admin/stats/sales',
	'admin/stats/sales_details'	    => 'orders::admin/stats/salesdetails',
	'admin/stats/visitor'		    => 'user::admin/stats/visitor',
	'admin/stats/order_sales'	    => 'orders::admin/stats/order_sales',

	/* 入驻申请*/
	'admin/merchant/signup'			        => 'merchant::admin/merchant/signup',
	'admin/merchant/process'		        => 'merchant::admin/merchant/process',
	'admin/merchant/account/info' 	        => 'merchant::admin/merchant/account/info',
	'admin/merchant/account/validate'       => 'merchant::admin/merchant/account/validate',
	'admin/merchant/validate'		        => 'merchant::admin/merchant/validate',
    'admin/merchant/cancel'                 => 'merchant::admin/merchant/cancel', //入驻撤销
    'admin/merchant/resignup'               => 'merchant::admin/merchant/resignup', //入驻修改信息提交
    'admin/merchant/preaudit'	            => 'merchant::admin/merchant/preaudit', //入驻修改获取信息
    
    /*商家通知*/
    'admin/merchant/notification'	        => 'notification::admin/merchant/notification',
    'admin/merchant/notification/read'	    => 'notification::admin/merchant/notification/read',
    'admin/merchant/notification/unread_count'	    => 'notification::admin/merchant/notification/unread_count',

	/*商家满折满减满送活动*/
	'admin/favourable/list'		    => 'favourable::admin/favourable/list',
	'admin/favourable/add'		    => 'favourable::admin/favourable/manage',
	'admin/favourable/update'	    => 'favourable::admin/favourable/manage',
	'admin/favourable/info'		    => 'favourable::admin/favourable/info',
	'admin/favourable/delete'	    => 'favourable::admin/favourable/delete',
	
    /*商家促销活动*/
	'admin/promotion/list'		    => 'promotion::admin/promotion/list',
	'admin/promotion/detail'	    => 'promotion::admin/promotion/detail',
	'admin/promotion/delete'	    => 'promotion::admin/promotion/delete',
	'admin/promotion/add'	        => 'promotion::admin/promotion/manage',
	'admin/promotion/update'	    => 'promotion::admin/promotion/manage',

    //配送员
	'express/grab_list'			    => 'express::express/grab_list',     //1.5废弃
	'express/detail'			    => 'express::express/detail',        //1.5废弃
	'express/user/info'			    => 'express::express/user/info',     //1.5废弃
	'express/user/checkin'          => 'express::express/user/checkin',  //1.5废弃
	'express/pickup'			    => 'express::express/pickup',        //1.5废弃
	'express/grab'				    => 'express::express/grab',	         //1.5废弃
	'express/basicinfo'			    => 'express::express/basicinfo',     //1.5废弃
    
    'admin/express/grab_list'		=> 'express::express/grab_list',         //1.5新增
    'admin/express/detail'			=> 'express::express/detail',            //1.5新增
    'admin/express/pickup'			=> 'express::express/pickup',            //1.5新增
    'admin/express/grab'			=> 'express::express/grab',              //1.5新增
    'admin/express/basicinfo'	    => 'express::express/basicinfo',         //1.5新增
    'admin/express/user/location'	=> 'express::admin/express/user/location',//1.5新增
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
    'weapp/wxmobile'				=> 'weapp::weapp/wxmobile',	//小程序解析手机号
	'weapp/wxauthorize'				=> 'weapp::weapp/wxauthorize',	//小程序授权用户
	'weapp/wxbind'					=> 'weapp::weapp/wxbind',	//小程序绑定用户
	'weapp/wxpay'					=> 'weapp::weapp/wxpay',	//小程序微信支付
	'weapp/mobilebind'				=> 'weapp::weapp/mobilebind',	//小程序微信绑定手机号
	'weapp/store'					=> 'weapp::weapp/store',	//通过小程序获取店铺基本信息

	'admin/merchant/refreshQrcode'	=> 'merchant::admin/merchant/refreshQrcode',	//1.7 掌柜店铺刷新二维码
	'market/shake'                  => 'market::market/shake',        //1.6增加 摇一摇
    'admin/orders/today'            => 'orders::admin/orders/today',    //1.6增加 商家今日订单

	'quickpay/activity/list'		=> 'quickpay::quickpay/activity/list',  			//1.9 商家闪惠活动列表
	'quickpay/flow/checkOrder'		=> 'quickpay::quickpay/flow/checkOrder',			//1.9 闪惠购物流检查订单
	'quickpay/flow/done'			=> 'quickpay::quickpay/flow/done',	   			//1.9 闪惠购物流检查订单
	'quickpay/order/list'			=> 'quickpay::quickpay/order/list',	   			//1.9 闪惠订单列表
	'quickpay/order/detail'			=> 'quickpay::quickpay/order/detail',   			//1.9 闪惠订单详情
	'quickpay/order/pay'			=> 'quickpay::quickpay/order/pay',      			//1.9 闪惠订单支付

	'express/user/location'			=> 'express::express/location',			//1.9查看配送员位置
	'merchant/shop/payment'			=> 'quickpay::quickpay/merchant/shop/payment',   //1.9 商家支付方式列表
	
    
    /* 收银台*/
    'admin/bonus/validate'		    => 'cart::admin/bonus/validate',
    
    /* 到店购物 小程序1.3.0新增 */
    'storebuy/cart/create'          => 'cart::storebuy/cart/create',//（加购物车）
    'storebuy/cart/update'          => 'cart::storebuy/cart/update',//（更新购物车）
    'storebuy/cart/checked'         => 'cart::storebuy/cart/checked',//（购物车选中状态切换）
    'storebuy/cart/list'            => 'cart::storebuy/cart/list',//（购物车商品列表）
	'storebuy/cart/delete'          => 'cart::storebuy/cart/delete',//（从购物车中删除商品）
    'storebuy/flow/checkOrder'      => 'cart::storebuy/flow/checkOrder',//（购物流检查订单）
    'storebuy/flow/done'            => 'cart::storebuy/flow/done',//（购物流结算）
    'storebuy/merchant/goods/list'  => 'merchant::merchant/goods/storebuy/list',//（商品列表）
    'storebuy/merchant/goods/suggestlist'       => 'merchant::merchant/goods/storebuy/suggestlist',
    
	'quickpay/order/cancel'		    => 'quickpay::quickpay/order/operate/cancel',    //1.12用户取消买单订单
	'quickpay/order/delete'		    => 'quickpay::quickpay/order/operate/delete',    //1.12用户删除买单订单
	
    'captcha/image' 			    => 'captcha::captcha/image', //1.13 增加验证码图片
	'user/account/switchPayment'    => 'user::user/account/switchPayment',   //1.13 用户更新充值订单支付方式

    'refund/reasons'                => 'refund::refund/reasons',             //1.14售后原因
    'refund/cancel'                 => 'refund::refund/cancel',              //1.14撤销售后申请
    'refund/apply'                  => 'refund::refund/apply',               //1.14申请售后
	'refund/list'                   => 'refund::refund/list',                //1.14售后列表
	'refund/detail'                 => 'refund::refund/detail',              //1.14售后详情
	'refund/returnway/home'         => 'refund::refund/returnway/home',      //1.14选择上门取件返还方式
	'refund/returnway/express'      => 'refund::refund/returnway/express',   //1.14选择自选快递返还方式
	'refund/returnway/shop'         => 'refund::refund/returnway/shop',      //1.14选择到店退货返还方式
	'refund/payrecord'     		    => 'refund::refund/payrecord',      	 //1.14查看退款进度
	'affiliate/user/invite'         => 'affiliate::affiliate/user/invite',   //1.14推荐邀请用户
	
    'admin/shop/captcha/sms/checkcode'                  => 'captcha::admin/shop/captcha/sms/checkcode',    //1.14掌柜验证图形验证码并发送短信

    /**
     * 1.17废弃，兼容接口，请勿继续使用
     */
	'admin/express/task'             	                => 'express::admin/shopkeeper/express/task',           		//掌柜配送任务列表
	'admin/express/staff/location'   	                => 'express::admin/shopkeeper/express/location',       		//掌柜查看配送订单配送员位置
	'admin/express/finished'         	                => 'express::express/finished',             				//配送员app中配送员完成配送单
	'admin/express/staff/detail'     	                => 'express::admin/shopkeeper/express/staff/detail',   		//掌柜查看配送员详情
	'admin/express/staff/list'       	                => 'express::admin/shopkeeper/express/staff/list',     		//掌柜查看配送员列表
	'admin/express/staff/add/validate'	                => 'express::admin/shopkeeper/express/staff/validate',		//掌柜添加配送员验证
	'admin/express/staff/add'			                => 'express::admin/shopkeeper/express/staff/add',	    	//掌柜添加配送员
	'admin/express/staff/update'		                => 'express::admin/shopkeeper/express/staff/update',		//掌柜编辑配送员
	'admin/express/assignOrder'			                => 'express::admin/shopkeeper/express/staff/assignOrder',	//掌柜指派订单给配送员
	'admin/express/staff/online'		                => 'express::admin/shopkeeper/express/staff/online',		//掌柜指派订单获取在线配送员
	
	'storepickup/flow/checkOrder'  		                => 'cart::storepickup/flow/checkOrder',			//门店提货购物流检查订单
	'storepickup/flow/done'        		                => 'cart::storepickup/flow/done',				//门店提货购物流结算
	'store/business/city'        		                => 'store::store/business/city',						//经营城市列表
	
		
	'admin/express/list'			                    => 'express::admin/express/express/list',              //1.17废弃
	'admin/express/express/list'	                    => 'express::admin/express/express/list',              //1.17新增
		
	'admin/shopkeeper/crowdsource/express/task'         => 'express::admin/shopkeeper/crowdsource/express/task',		//掌柜查看平台配送任务列表
	'admin/shopkeeper/crowdsource/express/pickup'       => 'express::admin/shopkeeper/crowdsource/express/pickup',	//掌柜操作平台配送单为已取货
	'admin/shopkeeper/crowdsource/express/remind'	    => 'express::admin/shopkeeper/crowdsource/express/remind',	//商家提醒平台派单
	'admin/shopkeeper/express/pickup'	   			    => 'express::admin/shopkeeper/express/pickup',				//掌柜操作商家配送单为已取货
	'admin/shopkeeper/shop/boss/sms'		   		    => 'merchant::admin/shopkeeper/shop/boss/sms',				//掌柜切换店铺上下线给店长发送短信验证码
	'admin/shopkeeper/merchant/online'		   		    => 'merchant::admin/shopkeeper/merchant/online',				//掌柜设置店铺上线
	'admin/shopkeeper/merchant/offline'		   		    => 'merchant::admin/shopkeeper/merchant/offline',			//掌柜设置店铺下线
	'admin/shopkeeper/order/checking/detail'		    => 'orders::admin/shopkeeper/order/checking/detail',			//掌柜查看验单详情
	'admin/shopkeeper/order/checking/record'		    => 'orders::admin/shopkeeper/order/checking/record',			//掌柜查看验单记录
	'admin/shopkeeper/order/checking/confirm'		    => 'orders::admin/shopkeeper/order/checking/confirm',		//掌柜确认验单操作
	
	//1.18
	'merchant/groupbuy/goods/list'                      => 'merchant::merchant/groupbuy/goods/list',					//店铺团购商品列表
	'groupbuy/goods/list'                          	    => 'groupbuy::groupbuy/goods/list',							//团购商品列表
	'groupbuy/order/list'                               => 'groupbuy::groupbuy/order/list',							//用户团购订单列表
	'groupbuy/order/detail'                             => 'groupbuy::groupbuy/order/detail',						//团购订单详情
	'groupbuy/order/pay'                                => 'groupbuy::groupbuy/order/pay',							//团购订单支付
		
	'express/list'									    => 'express::admin/express/express/list',              		//接口升级兼容
	'shop/token/validate'           				    => 'setting::shop/token/validate',							//用户端验证token
	'admin/shop/token/validate'           			    => 'setting::admin/shop/token/validate',						//后台验证token
	
	//收银台接口20180717
	'admin/cashier/pendorder/list'                      => 'cashier::admin/cashier/pendorder/list',             //收银台挂单列表
	'admin/cashier/pendorder/create'                    => 'cashier::admin/cashier/pendorder/create',           //收银台创建挂单
	'admin/cashier/pendorder/delete'                    => 'cashier::admin/cashier/pendorder/delete',           //删除收银台挂单
	'admin/cashier/flow/checkOrder'                     => 'cashier::admin/cashier/flow/checkOrder',            //收银台购物流结算页
	'admin/cashier/flow/done'             		        => 'cashier::admin/cashier/flow/done',            		//收银台购物流结算
	'admin/merchant/user/list'               	        => 'user::admin/merchant/user/list',               		//后台管理员查看店铺会员列表
	'admin/user/add'               				        => 'user::admin/user/add',               				//后台管理员添加会员
	'admin/user/merchant/order/list'                    => 'orders::admin/user/merchant/order/list',            //获取某个会员在某个店铺的订单列表
	'admin/user/account/deposit'				        => 'user::admin/user/account/deposit',					//后台管理员给会员进行充值申请
	'admin/user/account/pay'					        => 'user::admin/user/account/pay',						//后台管理员给会员充值支付
	'admin/user/account/payConfirm'					    => 'user::admin/user/account/payConfirm',				//后台管理员给会员充值，充值订单确认支付
	'admin/cashier/orders/summary'				        => 'cashier::admin/cashier/orders/summary',				//收银台订单统计
	'admin/merchant/quickpay/activity/list'	        	=> 'quickpay::admin/merchant/quickpay/activity/list',	//收银台收款检查购物流订单
	'admin/cashier/quickpay/flow/checkOrder'	        => 'cashier::admin/cashier/quickpay/flow/checkOrder',	//收银台收款检查购物流订单
	'admin/cashier/quickpay/flow/done'			        => 'cashier::admin/cashier/quickpay/flow/done',			//收银台收款结算
	'admin/cashier/quickpay/order/pay'			        => 'cashier::admin/cashier/quickpay/order/pay',			//收银台收款支付
	'admin/cashier/quickpay/order/payConfirm'			=> 'cashier::admin/cashier/quickpay/order/payConfirm',	//收银台收款确认支付
	'admin/cashier/quickpay/order/list'					=> 'cashier::admin/cashier/quickpay/order/list',		//收银台收款订单记录
	'admin/cashier/merchant/goods/list'			        => 'cashier::admin/cashier/merchant/goods/list',		//商家商品列表
	'admin/orders/payment/history'						=> 'orders::admin/orders/payment/history',				//交易流水列表
		
	//1.19
	'bonus/validate'		                            => 'bonus::bonus/validate',		//验证线下红包
	'bonus/bind'			                            => 'bonus::bonus/bind',			//兑换红包需要登录
	
	//1.20
	'user/notifications'	                            => 'notification::user/notifications',     //用户消息中心消息列表
    'user/notification/read'                            => 'notification::user/notification/read', //用户标记消息为已读
    'user/notification/count'                           => 'notification::user/notification/count',//用户消息数量统计
    
	//1.21
	'invite/invitee/rule'								=> 'affiliate::invite/invitee/rule',  //被邀请说明

    //1.23
    'admin/payment/scancode'                            => 'payment::admin/payment/scancode', //收银台专用
    'admin/payment/cancelpay'                           => 'payment::admin/payment/cancelpay', //收银台专用

	'store/collect/list'	                            => 'user::store/collect/list', 					//用户收藏的店铺列表
	'store/collect/create'								=> 'user::store/collect/create', 				//用户收藏店铺
	'store/collect/cancel'								=> 'user::store/collect/cancel', 				//用户取消收藏店铺
	'user/mobile/toutiao'								=> 'toutiao::user/mobile/toutiao', 				//用户收藏店铺的今日热点列表
	'mobile/toutiao'									=> 'toutiao::mobile/toutiao', 					//所有店铺今日热点列表
	'merchant/mobile/toutiao'							=> 'toutiao::merchant/mobile/toutiao', 			//获取某个商家今日热点列表
	'merchant/menu'										=> 'store::merchant/menu', 						//商家自定义菜单
	'user/orders/express/message'						=> 'track::user/orders/express/message', 		//用户订单物流消息中心
	'user/orders/express/message/detail'				=> 'track::user/orders/express/message/detail', //物流消息详情

	//收银台退款20181114；1.24
	'admin/cashier/orders/refund/apply'					=> 'cashier::admin/cashier/orders/refund/apply', 	//收银台订单退款申请
	'admin/cashier/orders/refund/record'				=> 'cashier::admin/cashier/orders/refund/record',	//收银台订单退款记录
	'admin/cashier/orders/refund/detail'				=> 'cashier::admin/cashier/orders/refund/detail',	//收银台订单退款详情
	'admin/cashier/secondscreen/adsense'				=> 'cashier::admin/cashier/secondscreen/adsense',	//收银台副屏广告位
	'admin/cashier/orders/refund/summary'				=> 'cashier::admin/cashier/orders/refund/summary',  //收银台退款统计（已退款完成的）
	'admin/cashier/orders/search'						=> 'cashier::admin/cashier/orders/search',			//收银台订单搜索（已支付的）
	'admin/cashier/quickpay/order/detail'				=> 'cashier::admin/cashier/quickpay/order/detail',	//收银台收款订单详情
		
	//1.25
	'user/paypassword/modify'                         => 'user::user/paypassword/modify',                   //用户设置修改支付密码	
	'user/account/record/detail'					  => 'user::user/account/record/detail',				//用户充值提现记录详情
	'goods/collect/create'							  => 'user::goods/collect/create',						//用户收藏商品
	'goods/collect/cancel'							  => 'user::goods/collect/cancel',						//用户取消收藏商品
	'goods/collect/list'							  => 'user::goods/collect/list',						//用户收藏商品列表
	'payment/pay/balance'							  => 'payment::payment/pay/balance',					//余额支付
	'shop/special/readme/userdelete'				  => 'article::shop/special/readme/userdelete',			//用户注销须知
	'user/account/delete/apply'						  => 'user::user/account/delete/apply',					//用户账号注销申请
	'user/account/activate/apply'					  => 'user::user/account/activate/apply',				//用户账号激活申请
	'topic/list'									  => 'topic::topic/list',								//专题列表
	'topic/info'									  => 'topic::topic/info',								//专题详情
    'withdraw/banks'                                  => 'withdraw::withdraw/banks',						//用户绑定银行卡所支持的银行
    'withdraw/bankcard/bind'                          => 'withdraw::withdraw/bankcard/bind',				//会员绑定/更新银行卡
    'withdraw/wechat/wallet/bind'					  => 'withdraw::withdraw/wechat/wallet/bind',			//会员绑定/更新微信钱包提现信息
    'withdraw/bankcard/delete'						  => 'withdraw::withdraw/bankcard/delete',				//会员删除已绑定的提现方式
    'user/info/bankcard'                              => 'user::user/info/bankcard',                        //获取用户绑定的银行卡信息
    'user/account/withdraw'                           => 'user::user/account/withdraw',                     //用户提现申请-替换user/account/raply
    'shop/captcha/sms/checkcode'                      => 'captcha::shop/captcha/sms/checkcode',             //用户登录后，通用验证关联手机号验证码
    'connect/unbind'					  			  => 'connect::connect/unbind',							//用户解绑关联的第三方账号
		
	'admin/payment/notify/cancel'					  => 'payment::admin/payment/notify/cancel',			//收银台撤销支付
	'admin/payment/notify/pay'					  	  => 'payment::admin/payment/notify/pay',				//收银台支付
	'admin/payment/notify/refund'					  => 'payment::admin/payment/notify/refund',			//收银台退款
	'admin/payment/pay/balance'						  => 'payment::admin/payment/pay/balance',				//收银台余额支付
	'admin/payment/pay/cash'						  => 'payment::admin/payment/pay/cash',					//收银台现金支付
	
	//1.26收银通
	'admin/cashier/notify/printmachine/print'		  => 'cashier::admin/cashier/notify/printmachine/print',//收银通通知小票打印机打印小票
	
	//1.27
	'affiliate/user/invitee'						  => 'affiliate::affiliate/user/invitee',				//团队列表，当前用户推荐的直属用户
	
    //1.28到家商城
	'bbc/cart/create'						  		  => 'cart::bbc/cart/create',							//添加商品到购物车（到家商城专用）
	'bbc/cart/list'						  		  	  => 'cart::bbc/cart/list',								//用户购物车列表（到家商城专用）
	'bbc/flow/checkOrder'							  => 'cart::bbc/flow/checkOrder',						//购物流订单检查（到家商城专用）
	'bbc/flow/done'							  		  => 'cart::bbc/flow/done',								//购物流订单结算提交（到家商城专用）
	
    //1.29
    'affiliate/order/records'                         => 'affiliate::affiliate/order/records',               //推荐用户订单分成记录
    'affiliate/order/detail'                          => 'affiliate::affiliate/order/detail',               //推荐用户订单分成记录详情
    
	//收银台2.2.0
	'admin/cashier/orders/summary/records'			  => 'orders::admin/cashier/orders/summary/records',    	//资金流水开单/验单列表（支付完成的）
	'admin/cashier/quickpay/summary/records'		  => 'quickpay::admin/cashier/quickpay/summary/records',    //资金流水买单列表（买单支付完成的）
	'admin/cashier/refund/summary/records'		  	  => 'refund::admin/cashier/refund/summary/records',    	//资金流水退款列表（退款完成的）
	'admin/cashier/user/account/deposit/records'	  => 'user::admin/cashier/user/account/deposit/records',	//收银员查看会员充值记录
	'admin/cashier/validate/integral'             	  => 'user::admin/cashier/validate/integral',               //收银台验证积分

	//1.30小程序
	'medialibrary/image/temp/upload'                  => 'setting::medialibrary/image/temp/upload',             //图片临时上传，通用接口
	'connect/user/bind'								  => 'connect::connect/user/bind',             				//用户绑定第三方账号
	'user/connect/binded/status'					  => 'user::user/connect/binded/status',             		//用户绑定的第三方账号
	'user/orders/summary'					  		  => 'user::user/orders/summary',             				//用户订单数量统计概况


	'bbc/test/flow/done'							  => 'cart::bbc/test/flow/done',							//到家商城，购物流订单结算提交测试接口

	'goods/product/specification'					  => 'goods::goods/product/specification',					//获取商品的货品和规格信息

    'admin/cashier/goods/product/specification'       => 'goods::admin/cashier/goods/product/specification',    //收银台获取商品的货品和规格信息


    /* 代理商1.32 1.33 */
    'invite/store/agent/user'     => 'affiliate::invite/store/agent/user',                                      //代理商招募信息（邀请链接，二维码，邀请码）
    'invite/store/agent/inviter'  => 'affiliate::invite/store/agent/inviter',                                   //代理商信息
    'invite/store/agent/join'     => 'affiliate::invite/store/agent/join',                                      //代理商招募校验
    'invite/store'                => 'affiliate::invite/store',                                                 //推广店铺信息（邀请链接，二维码，邀请码）
    //admin/merchant/signup 1.32新增 推广邀请码
    'user/agent/info'             => 'user::user/agent/info',                                                   //用户代理商信息（是否代理商，代理商等级）
	
    //1.33掌柜商品管理
    //规格管理
    'admin/merchant/goods/specification/template'     			=> 'goods::admin/merchant/goods/specification/template', 				//商品规格模板列表（包含平台的，均为已启用的）
	'admin/merchant/goods/parameter/template'         			=> 'goods::admin/merchant/goods/parameter/template', 					//商品参数模板列表（包含平台的，均为已启用的）
	'admin/merchant/goods/specification'			  			=> 'goods::admin/merchant/goods/specification',							//商品规格列表
	'admin/merchant/goods/specification/add'		  			=> 'goods::admin/merchant/goods/specification/add',						//商品规格添加
	'admin/merchant/goods/specification/detail'       			=> 'goods::admin/merchant/goods/specification/detail',    				//商品规格详情
	'admin/merchant/goods/specification/update'       			=> 'goods::admin/merchant/goods/specification/update',    				//商品规格编辑
    'admin/merchant/goods/specification/delete'		  			=> 'goods::admin/merchant/goods/specification/delete',					//商品规格删除
	//规格属性管理
	'admin/merchant/goods/specification/attribute'	  			=> 'goods::admin/merchant/goods/specification/attribute',				//某一规格的属性列表
	'admin/merchant/goods/specification/attribute/colorsetting'	=> 'goods::admin/merchant/goods/specification/attribute/colorsetting', 	//规格属性色值设置
	'admin/merchant/goods/specification/attribute/add'			=> 'goods::admin/merchant/goods/specification/attribute/add', 			//添加普通规格属性
	'admin/merchant/goods/specification/attribute/add/color'	=> 'goods::admin/merchant/goods/specification/attribute/add/color', 	//添加颜色规格属性
	'admin/merchant/goods/specification/attribute/detail'		=> 'goods::admin/merchant/goods/specification/attribute/detail',		//获取规格属性详情	
	'admin/merchant/goods/specification/attribute/update'		=> 'goods::admin/merchant/goods/specification/attribute/update',		//编辑规格属性
	//参数模板管理
	'admin/merchant/goods/parameter'							=> 'goods::admin/merchant/goods/parameter',								//商品参数列表	
	'admin/merchant/goods/parameter/add'						=> 'goods::admin/merchant/goods/parameter/add',							//商品参数模板添加								
	'admin/merchant/goods/parameter/detail'						=> 'goods::admin/merchant/goods/parameter/detail',						//商品参数模板详情
	'admin/merchant/goods/parameter/update'						=> 'goods::admin/merchant/goods/parameter/update',						//编辑商品参数模板
	'admin/merchant/goods/parameter/delete'						=> 'goods::admin/merchant/goods/parameter/delete',						//参数模板删除	
	//参数属性管理
	'admin/merchant/goods/parameter/attribute'					=> 'goods::admin/merchant/goods/parameter/attribute',					//某一参数模板的参数列表
	'admin/merchant/goods/parameter/attribute/add'				=> 'goods::admin/merchant/goods/parameter/attribute/add',				//添加参数模板参数属性	
	'admin/merchant/goods/parameter/attribute/detail'			=> 'goods::admin/merchant/goods/parameter/attribute/detail',			//获取参数模板参数属性详情	
	'admin/merchant/goods/parameter/attribute/update'			=> 'goods::admin/merchant/goods/parameter/attribute/update',			//编辑参数模板参数属性
	'admin/merchant/goods/attribute/delete'						=> 'goods::admin/merchant/goods/attribute/delete',						//删除规格或参数属性	
	//商品添加/编辑	
	'admin/merchant/goods/updatePrice'	    					=> 'goods::admin/merchant/goods/updateprice',							//掌柜修改商品相关的价格
	'admin/merchant/goods/expirydate/update'					=> 'goods::admin/merchant/goods/expirydate/update',						//掌柜修改商品保质期信息
	'admin/merchant/goods/list'			    					=> 'goods::admin/merchant/goods/list',									//掌柜商品列表；原来admin/goods/list升级
	'admin/merchant/goods/add'									=> 'goods::admin/merchant/goods/add',									//掌柜添加商品；原来admin/goods/add升级
	'admin/merchant/goods/detail'								=> 'goods::admin/merchant/goods/detail',								//掌柜获取商品详情；原来admin/goods/detail升级
	'admin/merchant/goods/update'								=> 'goods::admin/merchant/goods/update',								//掌柜更新商品；原来admin/goods/update升级
	'admin/merchant/goods/toggle/suggest'						=> 'goods::admin/merchant/goods/toggle/suggest',						//掌柜切换商品为推荐商品；原来接口admin/goods/toggle/suggest升级
	'admin/merchant/goods/review/log'							=> 'goods::admin/merchant/goods/review/log',							//掌柜获取商品审核日志	
	'admin/merchant/goods/linkgoods'							=> 'goods::admin/merchant/goods/linkgoods',								//掌柜获取商品的关联商品
	'admin/merchant/goods/linkgoods/add'						=> 'goods::admin/merchant/goods/linkgoods/add',							//掌柜给某一商品添加关联商品
	'admin/merchant/goods/price/update'							=> 'goods::admin/merchant/goods/price/update',							//快速修改商品价格（单独修改商品shop_price）
	'admin/merchant/goods/stock/update'                         => 'goods::admin/merchant/goods/stock/update',                          //快速修改商品库存（单独修改商品goods_number）
	'admin/merchant/goods/parameter/binded/template'			=> 'goods::admin/merchant/goods/parameter/binded/template',				//商品绑定的参数模板信息	
	'admin/merchant/goods/goodsattr/parameter/update'			=> 'goods::admin/merchant/goods/goodsattr/parameter/update',			//编辑商品的参数属性	
	'admin/merchant/goods/goodsattr/parameter/clear'			=> 'goods::admin/merchant/goods/goodsattr/parameter/clear',				//清除商品参数属性
	'admin/merchant/goods/specification/binded/template'		=> 'goods::admin/merchant/goods/specification/binded/template',			//商品绑定的规格模板的规格信息
	'admin/merchant/goods/goodsattr/specification/update'		=> 'goods::admin/merchant/goods/goodsattr/specification/update',		//编辑商品的规格属性
	'admin/merchant/goods/goodsattr/specification/clear'		=> 'goods::admin/merchant/goods/goodsattr/specification/clear',			//清除商品规格属性	
	'admin/merchant/goods/goodsattr/specification/binded'		=> 'goods::admin/merchant/goods/goodsattr/specification/binded',		//获取商品已设置的规格属性	
	'admin/merchant/goods/product/add'							=> 'goods::admin/merchant/goods/product/add',							//添加商品货品	
	'admin/merchant/goods/product/delete'						=> 'goods::admin/merchant/goods/product/delete',						//删除商品货品
	'admin/merchant/goods/product/detail'						=> 'goods::admin/merchant/goods/product/detail',						//商品货品详情	
	'admin/merchant/goods/product/update'						=> 'goods::admin/merchant/goods/product/update',						//编辑商品货品	
	'admin/merchant/goods/product/list'							=> 'goods::admin/merchant/goods/product/list',							//商品货品列表	
	'admin/merchant/goods/product/desc'							=> 'goods::admin/merchant/goods/product/desc',							//货品描述信息	
	'admin/merchant/goods/product/desc/update'					=> 'goods::admin/merchant/goods/product/desc/update',					//编辑货品描述
	'admin/merchant/goods/product/gallery/add'					=> 'goods::admin/merchant/goods/product/gallery/add',					//货品相册上传
	'admin/merchant/goods/product/gallery/delete'				=> 'goods::admin/merchant/goods/product/gallery/delete',				//货品相册删除	
	'admin/merchant/goods/product/gallery/sort'					=> 'goods::admin/merchant/goods/product/gallery/sort',					//货品相册排序	
	'admin/merchant/goods/product/price/update'					=> 'goods::admin/merchant/goods/product/price/update',					//快速修改货品价格（支持批量修改）
	'admin/merchant/goods/product/stock/update'					=> 'goods::admin/merchant/goods/product/stock/update',					//快速修改货品库存（支持批量修改）

    //邀请店铺
    'invite/store/agent/affiliate/account/log'					=> 'affiliate::invite/store/agent/affiliate/account/log',				//代理商推广分佣资金变动明细记录
    'invite/store/agent/affiliate/account/logdetail'			=> 'affiliate::invite/store/agent/affiliate/account/logdetail',			//代理商推广分佣资金变动明细记录详情
    
);

// end
