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
/**
 * H5路由配置文件
 */
return [
	
    'touch/index/init'                  => 'touch_controller@init',
    'touch/index/ajax_goods'            => 'touch_controller@ajax_goods',
    'touch/index/ajax_suggest_store'    => 'touch_controller@ajax_suggest_store',
    'touch/index/search'                => 'touch_controller@search',
    'touch/index/del_search'            => 'touch_controller@del_search',
    'touch/index/cache_set'				=> 'touch_controller@cache_set', //缓存设置
    'touch/index/clear_cache'			=> 'touch_controller@clear_cache', //清除缓存
    
    //定位
    'location/index/select_location'    => 'location_controller@select_location',
    'location/index/search_list'        => 'location_controller@search_list',
    'location/index/select_city'        => 'location_controller@select_city',
    'location/index/get_location_msg'   => 'location_controller@get_location_msg',
    
    //商品
    'goods/category/init'               => 'goods_controller@init',
    'goods/category/store_list'         => 'goods_controller@store_list', //店铺分类列表
    'goods/index/show'                  => 'goods_controller@show',    //商品详情页
    'goods/index/promotion'             => 'goods_controller@promotion',
    'goods/index/ajax_goods'            => 'goods_controller@ajax_goods',
    'goods/index/new'                   => 'goods_controller@goods_new',
    'goods/index/ajax_goods_comment'    => 'goods_controller@ajax_goods_comment', //获取商品评论
    
    //店铺
    'merchant/index/init'               => 'merchant_controller@init',
    'merchant/index/ajax_goods'         => 'merchant_controller@ajax_goods',
    'merchant/index/position'           => 'merchant_controller@position',
    'merchant/index/ajax_store_comment' => 'merchant_controller@ajax_store_comment',
    'merchant/quickpay/collectmoney'    => 'merchant_controller@collectmoney',
    'seller/category/list'              => 'merchant_controller@seller_list',
    
    //文章
    'article/help/init'                 => 'article_controller@init',
    'article/help/detail'               => 'article_controller@detail',
    'article/shop/detail'               => 'article_controller@shop_detail',
    'article/index/init'                => 'article_controller@article_index',  //发现首页
    'article/index/detail'              => 'article_controller@article_detail', //发现文章详情
    'article/index/ajax_article_list'   => 'article_controller@ajax_article_list', //获取分类下的文章
    'article/index/add_comment'         => 'article_controller@add_comment', //获取分类下的文章
    'article/index/ajax_comment_list'   => 'article_controller@ajax_comment_list', //获取文章评论列表
    'article/index/like_article'        => 'article_controller@like_article', //文章点赞/取消点赞
    
    //购物车
    'cart/index/init'                   => 'cart_controller@init',
    'cart/index/update_cart'            => 'cart_controller@update_cart', //更新购物车中商品
    'cart/index/check_spec'             => 'cart_controller@check_spec', //检查购物车中商品规格
    'cart/flow/checkout'                => 'cart_controller@checkout',
    'cart/flow/pay'                     => 'cart_controller@pay',
    'cart/flow/shipping'                => 'cart_controller@shipping',
    'cart/flow/pay_shipping'            => 'cart_controller@pay_shipping',
    'cart/flow/shipping_date'           => 'cart_controller@shipping_date',
    'cart/flow/invoice'                 => 'cart_controller@invoice',
    'cart/flow/bonus'                   => 'cart_controller@bonus',
    'cart/flow/integral'                => 'cart_controller@integral',
    'cart/flow/note'                    => 'cart_controller@note',
    'cart/flow/goods_list'              => 'cart_controller@goods_list',
    'cart/flow/done'                    => 'cart_controller@done',
    
    'cart/flow/storepickup_checkout'    => 'cart_controller@storepickup_checkout',
    'cart/flow/storepickup_done'        => 'cart_controller@storepickup_done',
    'cart/flow/pay_pickup'            	=> 'cart_controller@pay_pickup',
    
    //支付
    'pay/index/init'                    => 'pay_controller@init',
    'pay/index/notify'                  => 'pay_controller@notify',
    
    //会员
    'touch/my/init'                     => 'user_controller@init',
    'user/index/spread'                 => 'user_controller@spread',
    'user/index/wxconfig'               => 'user_controller@wxconfig',
    
    //推荐
    'affiliate/index/init'              => 'affiliate_controller@init', //邀请注册
    'affiliate/index/check'             => 'affiliate_controller@check',
    'affiliate/index/refresh'           => 'affiliate_controller@refresh',
    'affiliate/index/invite'            => 'affiliate_controller@invite',
    
    //商家入驻申请
    'franchisee/index/first'            => 'franchisee_controller@first', //入驻申请加载页面
    'franchisee/index/first_check'      => 'franchisee_controller@first_check', //入驻申请第一步验证
    'franchisee/index/validate'         => 'franchisee_controller@validate', //入驻验证码
    'franchisee/index/enter_code'       => 'franchisee_controller@enter_code', 
    'franchisee/index/resend_sms'       => 'franchisee_controller@resend_sms',
    'franchisee/index/validate_code'    => 'franchisee_controller@validate_code',
    'franchisee/index/second'           => 'franchisee_controller@second', //入驻申请第二步
    'franchisee/index/finish'           => 'franchisee_controller@finish', //处理入驻申请
    'franchisee/index/search'           => 'franchisee_controller@search', //处理入驻申请
    'franchisee/index/process'          => 'franchisee_controller@process', //查询进度
    'franchisee/index/process_search'   => 'franchisee_controller@process_search', //查询进度处理
    'franchisee/index/process_captcha_check' => 'franchisee_controller@process_captcha_check',
    'franchisee/index/process_enter_code'    => 'franchisee_controller@process_enter_code',
    'franchisee/index/process_validate_code' => 'franchisee_controller@process_validate_code',
    'franchisee/index/location'         => 'franchisee_controller@location', //获取店铺精确位置
    'franchisee/index/location_finish'  => 'franchisee_controller@location_finish', //提交店铺精确位置
    'franchisee/index/get_region'       => 'franchisee_controller@get_region', //提交店铺精确位置
    'franchisee/index/captcha_refresh'  => 'franchisee_controller@captcha_refresh',
    
    //登录注册
    'user/privilege/login'              => 'user_privilege_controller@login',
    'user/privilege/mobile_login'       => 'user_privilege_controller@mobile_login',
    'user/privilege/pass_login'         => 'user_privilege_controller@pass_login',
    'user/privilege/signin'             => 'user_privilege_controller@signin',
    'user/privilege/signup'             => 'user_privilege_controller@signup',
    'user/privilege/register'           => 'user_privilege_controller@register',
    'user/privilege/validate_code'      => 'user_privilege_controller@validate_code',
    'user/privilege/set_password'       => 'user_privilege_controller@set_password',
    'user/privilege/logout'             => 'user_privilege_controller@logout',
    'user/privilege/captcha_validate'   => 'user_privilege_controller@captcha_validate',
    'user/privilege/captcha_refresh'    => 'user_privilege_controller@captcha_refresh',
    'user/privilege/captcha_check'      => 'user_privilege_controller@captcha_check',
    'user/privilege/enter_code'         => 'user_privilege_controller@enter_code',
    'user/privilege/mobile_signin'      => 'user_privilege_controller@mobile_signin',
    'user/privilege/wechat_login'       => 'user_privilege_controller@wechat_login',
    
    //找回密码
    'user/get_password/init'            => 'user_get_password_controller@init',
    'user/get_password/mobile_check'    => 'user_get_password_controller@mobile_check',
    'user/get_password/captcha_validate'=> 'user_get_password_controller@captcha_validate',
    'user/get_password/enter_code'      => 'user_get_password_controller@enter_code',
    'user/get_password/captcha_check'   => 'user_get_password_controller@captcha_check',
    'user/get_password/validate_forget_password' => 'user_get_password_controller@validate_forget_password',
    'user/get_password/mobile_register_account'  => 'user_get_password_controller@mobile_register_account',
    'user/get_password/reset_password'  => 'user_get_password_controller@reset_password',
    
    //用户帐户
    'user/account/init'                 => 'user_account_controller@init',  //我的钱包
    'user/account/recharge'             => 'user_account_controller@recharge',
    'user/account/recharge_account'     => 'user_account_controller@recharge_account',
    'user/account/withdraw'             => 'user_account_controller@withdraw',
    'user/account/withdraw_account'     => 'user_account_controller@withdraw_account',
    'user/account/balance'              => 'user_account_controller@balance', //余额
    'user/account/record'               => 'user_account_controller@record',
    'user/account/ajax_record'          => 'user_account_controller@ajax_record',
    'user/account/ajax_record_raply'    => 'user_account_controller@ajax_record_raply',
    'user/account/ajax_record_deposit'  => 'user_account_controller@ajax_record_deposit',
    'user/account/record_info'          => 'user_account_controller@record_info',
    'user/account/record_cancel'        => 'user_account_controller@record_cancel',
    'user/account/recharge_again'       => 'user_account_controller@recharge_again', //继续充值
    'user/account/recharge_again_account' => 'user_account_controller@recharge_again_account', //继续充值
    
    //用户收货地址
    'user/address/address_list'         => 'user_address_controller@address_list',
    'user/address/add_address'          => 'user_address_controller@add_address',
    'user/address/insert_address'       => 'user_address_controller@insert_address',
    'user/address/edit_address'         => 'user_address_controller@edit_address',
    'user/address/update_address'       => 'user_address_controller@update_address',
    'user/address/del_address'          => 'user_address_controller@del_address',
    'user/address/save_temp_data'       => 'user_address_controller@save_temp_data',
    'user/address/near_location'        => 'user_address_controller@near_location',
    'user/address/set_default'          => 'user_address_controller@set_default',
    'user/address/choose_address'       => 'user_address_controller@choose_address',
    'user/address/get_region'           => 'user_address_controller@get_region',
    'user/address/save_address_temp'    => 'user_address_controller@save_address_temp',
    
    //用户红包
    'user/bonus/init'                   => 'user_bonus_controller@init',
    'user/bonus/async_allow_use'        => 'user_bonus_controller@async_allow_use',
    'user/bonus/async_is_used'          => 'user_bonus_controller@async_is_used',
    'user/bonus/async_expired'          => 'user_bonus_controller@async_expired',
    'user/bonus/my_reward'              => 'user_bonus_controller@my_reward',
    'user/bonus/reward_detail'          => 'user_bonus_controller@reward_detail',
    'user/bonus/get_integral'           => 'user_bonus_controller@get_integral',
    'user/bonus/async_reward_detail'    => 'user_bonus_controller@async_reward_detail',
    
    //订单
    'user/order/order_list'             => 'user_order_controller@order_list',
    'user/order/order_cancel'           => 'user_order_controller@order_cancel',
    'user/order/async_order_list'       => 'user_order_controller@async_order_list',
    'user/order/async_return_order_list'=> 'user_order_controller@async_return_order_list',
    'user/order/order_detail'           => 'user_order_controller@order_detail',
    'user/order/affirm_received'        => 'user_order_controller@affirm_received',
    'user/order/comment_list'           => 'user_order_controller@comment_list',
    'user/order/goods_comment'          => 'user_order_controller@goods_comment',
    'user/order/make_comment'           => 'user_order_controller@make_comment',
    'user/order/buy_again'              => 'user_order_controller@buy_again',
    'user/order/express_position'       => 'user_order_controller@express_position',
    'user/order/return_list'            => 'user_order_controller@return_list',
    'user/order/return_order'           => 'user_order_controller@return_order',
    'user/order/add_return'             => 'user_order_controller@add_return',
    'user/order/return_detail'          => 'user_order_controller@return_detail',
    'user/order/undo_reply'             => 'user_order_controller@undo_reply',
    'user/order/return_way_list'        => 'user_order_controller@return_way_list',
    'user/order/return_way'             => 'user_order_controller@return_way',
    'user/order/add_return_way'         => 'user_order_controller@add_return_way',
    
    //用户资料
    'user/profile/init'                 => 'user_profile_controller@init',
    'user/profile/modify_username'      => 'user_profile_controller@modify_username',
    'user/profile/modify_username_account' => 'user_profile_controller@modify_username_account',
    'user/profile/edit_password'        => 'user_profile_controller@edit_password',
    'user/profile/account_bind'         => 'user_profile_controller@account_bind',
    'user/profile/get_code'             => 'user_profile_controller@get_code',
    'user/profile/check_code'           => 'user_profile_controller@check_code',
    'user/profile/bind_info'            => 'user_profile_controller@bind_info',
    'user/profile/get_sms_code'			=> 'user_profile_controller@get_sms_code',
    'user/profile/modify_password'		=> 'user_profile_controller@modify_password',
    
    //授权登录
    'connect/index/dump_user_info'      => 'connect_controller@dump_user_info',
    'connect/index/bind_signup'         => 'connect_controller@bind_signup',
    'connect/index/bind_signup_do'      => 'connect_controller@bind_signup_do',
    'connect/index/bind_signin'         => 'connect_controller@bind_signin',
    'connect/index/bind_signin_do'      => 'connect_controller@bind_signin_do',
    'connect/index/mobile_login'        => 'connect_controller@mobile_login',
    'connect/index/captcha_validate'    => 'connect_controller@captcha_validate',
    'connect/index/captcha_refresh'     => 'connect_controller@captcha_refresh',
    'connect/index/captcha_check'       => 'connect_controller@captcha_check',
    'connect/index/enter_code'          => 'connect_controller@enter_code',
    'connect/index/mobile_signin'       => 'connect_controller@mobile_signin',
    'connect/index/set_password'        => 'connect_controller@set_password',
    
    //发现
    'mobile/discover/init'              => 'mobile_controller@init',  //百宝箱
    
    //闪惠
    'user/quickpay/quickpay_list'       => 'quickpay_controller@quickpay_list',
    'user/quickpay/init'                => 'quickpay_controller@init',
    'user/quickpay/explain'             => 'quickpay_controller@explain',
    'user/quickpay/bonus'               => 'quickpay_controller@bonus',
    'user/quickpay/integral'            => 'quickpay_controller@integral',
    'user/quickpay/notify'              => 'quickpay_controller@notify',
    'user/quickpay/async_quickpay_list' => 'quickpay_controller@async_quickpay_list',
    'user/quickpay/quickpay_detail'     => 'quickpay_controller@quickpay_detail',
    'user/quickpay/pay'                 => 'quickpay_controller@pay',
    'user/quickpay/dopay'               => 'quickpay_controller@dopay',
    'user/quickpay/notify'              => 'quickpay_controller@notify',
    'user/quickpay/cancel'              => 'quickpay_controller@cancel',
    'user/quickpay/delete'              => 'quickpay_controller@delete',
    
    'quickpay/flow/flow_checkorder'     => 'quickpay_controller@flow_checkorder',
    'quickpay/flow/done'                => 'quickpay_controller@done',
];
