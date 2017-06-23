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

class ecjia_touch_api 
{
   
	//==============================================
	// 商店配置
	//==============================================
    const SHOP_CONFIG      = 'shop/config';//商店配置
	const SHOP_TOKEN       = 'shop/token';//获取token信息
	const SHOP_PAYMENT     = 'shop/payment'; //支付方式
	const SHOP_REGION      = 'shop/region';//地区
	const SHOP_HELP	       = 'shop/help';//商店帮助分类列表
	const SHOP_INFO	       = 'shop/info';//网店信息
	const SHOP_HELP_DETAIL = 'shop/help/detail';//商店帮助内容
	const SHOP_INFO_DETAIL = 'shop/info/detail';//网店信息内容
	const SHOP_SERVER      = 'shop/server';//服务器环境信息
	const SHOP_REGION_DETAIL = 'shop/region/detail';//根据城市名称查找城市id
    
    //==============================================
    // 首页
    //==============================================
    const HOME_CATEGORY    = 'home/category';//HOME分类
    const HOME_DATA 	   = 'home/data';//HOME数据
    const HOME_ADSENSE     = 'home/adsense';//HOME广告
    const HOME_DISCOVER    = 'home/discover';//discover数据
    const HOME_NEWS 	   = 'home/news';//今日热点数据
    
    //==============================================
    // 收货地址
    //==============================================
    const ADDRESS_ADD        = 'address/add'; // 添加地址
    const ADDRESS_DELETE     = 'address/delete'; // 删除地址
    const ADDRESS_INFO       = 'address/info'; // 单条地址信息
    const ADDRESS_LIST       = 'address/list'; // 所有地址列表
    const ADDRESS_UPDATE     = 'address/update'; // 更新单条地址信息
    const ADDRESS_SETDEFAULT = 'address/setDefault'; // 设置默认地址
    
    //==============================================
    // 红包模块
    //==============================================
 	const BONUS_VALIDATE 	= 'bonus/validate';//红包获取验证
 	const BONUS_BIDN		= 'bonus/bind';//红包兑换
 	const BONUS_COUPON 		= 'bonus/coupon';//获取优惠红包列表信息O2O
 	const RECEIVE_COUPON 	= 'receive/coupon';//领取商品或店铺优惠券
 	const SEND_COUPON 		= 'send/coupon';//获取优惠券
 	
 	//==============================================
 	// 购物车
 	//==============================================
 	const CART_CREATE 		= 'cart/create'; //添加到购物车	
 	const CART_DELETE		= 'cart/delete'; //从购物车中删除商品
 	const CART_LIST			= 'cart/list';//购物车列表
 	const CART_UPDATE		= 'cart/update';//购物车更新商品数目
 	const CART_CHECKED		= 'cart/checked';//购物车更新选中状态
 	const FLOW_CHECKORDER 	= 'flow/checkOrder';//购物流检查订单
 	const FLOW_DONE			= 'flow/done';//购物流完成
 	
 	//==============================================
 	// 商品
 	//==============================================
 	const GOODS_CATEGORY 	= 'goods/category';//所有分类
 	const GOODS_COMMENTS 	= 'goods/comments';//某商品的所有评论
 	const GOODS_SELLER_LIST	= 'goods/seller/list';//店铺分类列表
 	const GOODS_SUGGESTLIST	= 'goods/suggestlist';//商品推荐列表
 	const GOODS_DETAIL		= 'goods/detail';//单个商品的信息
 	const GOODS_DESC		= 'goods/desc';//单个商品的详情
 	const GOODS_FILTER		= 'goods/filter';//某一分类的属性列表
 	
 	//==============================================
 	// 订单
 	//==============================================
 	const ORDER_AFFIRMRECEIVED = 'order/affirmReceived';//订单确认收货
 	const ORDER_CANCEL	       = 'order/cancel';//订单取消
 	const ORDER_LIST	       = 'order/list';//订单列表
 	const ORDER_PAY		       = 'order/pay';//订单支付
 	const ORDER_DETAIL	       = 'order/detail';//订单详情
 	const ORDER_REMINDER       = 'order/reminder'; //提醒卖家发货
 	const ORDER_UPDATE	       = 'order/update';//订单更新
 	const ORDER_EXPRESS        = 'order/express';//订单快递
 	
 	//==============================================
 	// 用户
 	//==============================================
 	const USER_COLLECT_CREATE = 'user/collect/create';//用户收藏商品
 	const USER_COLLECT_DELETE = 'user/collect/delete';//用户删除收藏商品
 	const USER_COLLECT_LIST   = 'user/collect/list';//用户收藏列表
 	
 	const USER_INFO		= 'user/info';//用户信息
 	const USER_UPDATE   = 'user/update';//用户图片上传或修改
 	const USER_ACCOUNT_RECORD = 'user/account/record';//用户充值提现记录
 	const USER_ACCOUNT_LOG    = 'user/account/log';//用户账户资金变更日志/测试
 	const USER_ACCOUNT_DEPOSIT= 'user/account/deposit';//用户充值申请
 	const USER_ACCOUNT_PAY    = 'user/account/pay';//用户充值付款
 	const USER_ACCOUNT_RAPLY  = 'user/account/raply';//用户提现申请
 	const USER_ACCOUNT_CANCEL = 'user/account/cancel';//用户申请取消
 	const USER_ACCOUNT_UPDATE = 'user/account/update';//修改会员账户信息
 	const USER_BONUS          = 'user/bonus';//会员红包列表
 	const VALIDATE_BIND       = 'validate/bind';//验证用户绑定注册
 	const VALIDATE_BONUS      = 'validate/bonus';//验证红包
 	const VALIDATE_INTEGRAL   = 'validate/integral';//验证积分
 	const VALIDATE_ACCOUNT    = 'validate/account';//验证用户账户信息
 	const VALIDATE_SIGNIN     = 'validate/signin'; //用户手机验证码登录
 	const VALIDATE_FORGET_PASSWORD = 'validate/forget_password';//用户找回密码验证
 	
 	const USER_SIGNIN	           = 'user/signin';//用户登录
 	const USER_SIGNOUT	           = 'user/signout';//用户退出
 	const USER_SIGNUP 	           = 'user/signup';//用户注册
 	const USER_FORGET_PASSWORD     = 'user/forget_password'; //用户找回密码
 	const USER_RESET_PASSWORD      = 'user/reset_password';//用户找回密码重置密码
 	const USER_PASSWORD       = 'user/password';//修改登录密码
 	const USER_SNSBIND        = 'user/snsbind';//第三方登录
 	const USER_SEND_PWDMAIL   = 'user/send_pwdmail';//邮箱找回密码/测试
 	const USER_SIGNUPFIELDS   = 'user/signupFields';//用户注册字段
 	const USER_USERBIND       = 'user/userbind';//手机快速注册
 	
 	//==============================================
 	// 推广
 	//==============================================
 	const INVITE_USER         = 'invite/user';//推荐用户信息
 	const INVITE_REWARD       = 'invite/reward';//获取我所推荐的统计
 	const INVITE_RECORD       = 'invite/record';//奖励记录
 	const INVITE_VALIDATE     = 'invite/validate';//邀请码

 	//==============================================
 	// 关联
 	//==============================================
 	const CONNECT_SIGNIN = 'connect/signin';//第三方关联登录
 	const CONNECT_SIGNUP = 'connect/signup';//第三方关联注册
 	const CONNECT_BIND   = 'connect/bind';//第三方关联绑定
 	
 	
 	//==============================================
 	// 店铺街
 	//==============================================
 	const SELLER_CATEGORY = 'seller/category'; //店铺分类
 	const SELLER_LIST     = 'seller/list';//店铺列表
 	const SELLER_SEARCH   = 'seller/search';//店铺搜索
 	const SELLER_COLLECT_LIST   = 'seller/collect/list';//收藏店铺列表
 	const SELLER_COLLECT_CREATE = 'seller/collect/create';//收藏店铺
 	const SELLER_COLLECT_DELETE = 'seller/collect/delete';//删除店铺收藏
 	const MERCHANT_HOME_DATA         = 'merchant/home/data';//商店基本信息
 	const MERCHANT_GOODS_CATEGORY    = 'merchant/goods/category';//商店分类
 	const MERCHANT_GOODS_LIST 		 = 'merchant/goods/list';//商店商品
 	const MERCHANT_GOODS_SUGGESTLIST = 'merchant/goods/suggestlist';//商店推荐商品
 	
 	//商家入驻
 	const ADMIN_MERCHANT_SIGNUP     = 'admin/merchant/signup';//提交入驻信息
 	const ADMIN_MERCHANT_PROCESS    = 'admin/merchant/process';//查看进度
 	const ADMIN_MERCHANT_VALIDATE 	= 'admin/merchant/validate';//验证码
 	const ADMIN_MERCHANT_CANCEL 	= 'admin/merchant/cancel';//撤销申请
 	const ADMIN_MERCHANT_PREAUDIT 	= 'admin/merchant/preaudit';//获取入驻基本信息
 	const ADMIN_MERCHANT_RESIGNUP 	= 'admin/merchant/resignup';//入驻申请信息修改
 	
 	//==============================================
 	// 评论
 	//==============================================
 	const COMMENT_CREATE            = 'comment/create';//发布商品评论
 	const ORDERS_COMMENT            = 'orders/comment';//获取用户邀请信息
 	const ORDERS_COMMENT_DETAIL     = 'orders/comment/detail';//获取单个订单的评论详情
 	
 	const STORE_COMMENTS			= 'store/comments';//店铺评论
 	
 	//==============================================
 	// 绑定手机号或邮箱
 	//==============================================
 	const VALIDATA_GET   = 'validate/get';//发送验证码
 	const USER_BIND      = 'user/bind';//发送验证码
 	
 	const SHOP_CAPTCHA_SMS	= 'shop/captcha/sms';//修改绑定手机
 	const SHOP_CAPTCHA_MAIL	= 'shop/captcha/mail';//修改绑定邮箱
 	
 	const ARTICLE_LIST     = 'article/list';//某一分类下的文章
 	const ARTICLE_DETAIL   = 'article/detail';//文章详情
 	CONST ARTICLE_COMMENT_CREATE = 'article/comment/create';//添加文章评论
 	CONST ARTICLE_COMMENTS = 'article/comments';//文章评论列表
 	CONST ARTICLE_LIKE_ADD = 'article/like/add';//文章点赞
 	CONST ARTICLE_LIKE_CANCEL = 'article/like/cancel';//文章取消点赞
 	CONST ARTICLE_SUGGESTLIST = 'article/suggestlist';//精选文章
 	CONST ARTICLE_HOME_CYCLEIMAGE = 'article/home/cycleimage';//发现页文章分类及轮播图
}

// end