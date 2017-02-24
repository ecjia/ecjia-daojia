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

/**
 * ECJia 常量
 */

/* 图片处理相关常数 */
define('ERR_INVALID_IMAGE',         1);
define('ERR_NO_GD',                 2);
define('ERR_IMAGE_NOT_EXISTS',      3);
define('ERR_DIRECTORY_READONLY',    4);
define('ERR_UPLOAD_FAILURE',        5);
define('ERR_INVALID_PARAM',         6);
define('ERR_INVALID_IMAGE_TYPE',    7);

/* 插件相关常数 */
define('ERR_COPYFILE_FAILED',       1);
define('ERR_CREATETABLE_FAILED',    2);
define('ERR_DELETEFILE_FAILED',     3);

/* 商品属性类型常数 */
define('ATTR_TEXT',                 0);
define('ATTR_OPTIONAL',             1);
define('ATTR_TEXTAREA',             2);
define('ATTR_URL',                  3);

/* 加入购物车失败的错误代码 */
define('ERR_NOT_EXISTS',            1); // 商品不存在
define('ERR_OUT_OF_STOCK',          2); // 商品缺货
define('ERR_NOT_ON_SALE',           3); // 商品已下架
define('ERR_CANNT_ALONE_SALE',      4); // 商品不能单独销售
define('ERR_NO_BASIC_GOODS',        5); // 没有基本件
define('ERR_NEED_SELECT_ATTR',      6); // 需要用户选择属性

/* 购物车商品类型 */
define('CART_GENERAL_GOODS',        0); // 普通商品
define('CART_GROUP_BUY_GOODS',      1); // 团购商品
define('CART_AUCTION_GOODS',        2); // 拍卖商品
define('CART_SNATCH_GOODS',         3); // 夺宝奇兵
define('CART_EXCHANGE_GOODS',       4); // 积分商城
define('CART_MOBILE_BUY_GOODS',        100);     //移动专享


/* 订单状态 */
define('OS_UNCONFIRMED',            0); // 未确认
define('OS_CONFIRMED',              1); // 已确认
define('OS_CANCELED',               2); // 已取消
define('OS_INVALID',                3); // 无效
define('OS_RETURNED',               4); // 退货
define('OS_SPLITED',                5); // 已分单
define('OS_SPLITING_PART',          6); // 部分分单

/* 支付类型 */
define('PAY_ORDER',                 0); // 订单支付
define('PAY_SURPLUS',               1); // 会员预付款

/* 配送状态 */
define('SS_UNSHIPPED',              0); // 未发货
define('SS_SHIPPED',                1); // 已发货
define('SS_RECEIVED',               2); // 已收货
define('SS_PREPARING',              3); // 备货中
define('SS_SHIPPED_PART',           4); // 已发货(部分商品)
define('SS_SHIPPED_ING',            5); // 发货中(处理分单)
define('OS_SHIPPED_PART',           6); // 已发货(部分商品)

/* 支付状态 */
define('PS_UNPAYED',                0); // 未付款
define('PS_PAYING',                 1); // 付款中
define('PS_PAYED',                  2); // 已付款

/* 综合状态 */
define('CS_AWAIT_PAY',              100); // 待付款：货到付款且已发货且未付款，非货到付款且未付款
define('CS_AWAIT_SHIP',             101); // 待发货：货到付款且未发货，非货到付款且已付款且未发货
define('CS_FINISHED',               102); // 已完成：已确认、已付款、已发货
define('CS_RECEIVED',               103); // 收货确认：已确认、已付款、已收货
define('CS_SHIPPED',                104); // 已发货：全部发货的订单状态

/* 缺货处理 */
define('OOS_WAIT',                  0); // 等待货物备齐后再发
define('OOS_CANCEL',                1); // 取消订单
define('OOS_CONSULT',               2); // 与店主协商

/* 帐户明细类型 */
define('SURPLUS_SAVE',              0); // 为帐户冲值
define('SURPLUS_RETURN',            1); // 从帐户提款

/* 评论状态 */
define('COMMENT_UNCHECKED',         0); // 未审核
define('COMMENT_CHECKED',           1); // 已审核或已回复(允许显示)
define('COMMENT_REPLYED',           2); // 该评论的内容属于回复

/* 红包发放的方式 */
define('SEND_BY_USER',              0); // 按用户发放
define('SEND_BY_GOODS',             1); // 按商品发放
define('SEND_BY_ORDER',             2); // 按订单发放
define('SEND_BY_PRINT',             3); // 线下发放
define('SEND_BY_REGISTER',          4); // 注册送红包
define('SEND_COUPON',          		5); // 优惠券

/* 广告的类型 */
define('IMG_AD',                    0); // 图片广告
define('FALSH_AD',                  1); // flash广告
define('CODE_AD',                   2); // 代码广告
define('TEXT_AD',                   3); // 文字广告

/* 是否需要用户选择属性 */
define('ATTR_NOT_NEED_SELECT',      0); // 不需要选择
define('ATTR_NEED_SELECT',          1); // 需要选择

/* 用户中心留言类型 */
define('M_MESSAGE',                 0); // 留言
define('M_COMPLAINT',               1); // 投诉
define('M_ENQUIRY',                 2); // 询问
define('M_CUSTOME',                 3); // 售后
define('M_BUY',                     4); // 求购
define('M_BUSINESS',                5); // 商家
define('M_COMMENT',                 6); // 评论

/* 团购活动状态 */
define('GBS_PRE_START',             0); // 未开始
define('GBS_UNDER_WAY',             1); // 进行中
define('GBS_FINISHED',              2); // 已结束
define('GBS_SUCCEED',               3); // 团购成功（可以发货了）
define('GBS_FAIL',                  4); // 团购失败

/* 红包是否发送邮件 */
define('BONUS_NOT_MAIL',            0);//未发：对于一些不需要发送邮件的红包
define('BONUS_INSERT_MAILLIST_SUCCEED',        1);//插入邮件队列成功
define('BONUS_INSERT_MAILLIST_FAIL',           2);//插入邮件队列失败
//红包插入邮件队列与邮件发送队列应产生交互，目前由于队列表记录无法标识是红包邮件类型的，暂未实现
define('BONUS_MAIL_SUCCEED',        3);//发送邮件通知成功
define('BONUS_MAIL_FAIL',           4);//发送邮件通知失败
define('BONUS_MAIL_NO_EFFECT',      5);//无效的邮件队列

/* 商品活动类型 */
define('GAT_SNATCH',                0);
define('GAT_GROUP_BUY',             1);
define('GAT_AUCTION',               2);
define('GAT_POINT_BUY',             3);
define('GAT_PACKAGE',               4); // 超值礼包
define('GAT_MOBILE_BUY',			100); 	//移动专享

/* 帐号变动类型 */
define('ACT_SAVING',                0);     // 帐户冲值
define('ACT_DRAWING',               1);     // 帐户提款
define('ACT_ADJUSTING',             2);     // 调节帐户
define('ACT_OTHER',                99);     // 其他类型

/* 密码加密方法 */
define('PWD_MD5',                   1);  //md5加密方式
define('PWD_PRE_SALT',              2);  //前置验证串的加密方式
define('PWD_SUF_SALT',              3);  //后置验证串的加密方式

/* 文章分类类型 */
define('COMMON_CAT',                1); //普通分类
define('SYSTEM_CAT',                2); //系统默认分类
define('INFO_CAT',                  3); //网店信息分类
define('UPHELP_CAT',                4); //网店帮助分类分类
define('HELP_CAT',                  5); //网店帮助分类

/* 活动状态 */
define('PRE_START',                 0); // 未开始
define('UNDER_WAY',                 1); // 进行中
define('FINISHED',                  2); // 已结束
define('SETTLED',                   3); // 已处理



/* 优惠活动的优惠范围 */
define('FAR_ALL',                   0); // 全部商品
define('FAR_CATEGORY',              1); // 按分类选择
define('FAR_BRAND',                 2); // 按品牌选择
define('FAR_GOODS',                 3); // 按商品选择

/* 优惠活动的优惠方式 */
define('FAT_GOODS',                 0); // 送赠品或优惠购买
define('FAT_PRICE',                 1); // 现金减免
define('FAT_DISCOUNT',              2); // 价格打折优惠

/* 评论条件 */
define('COMMENT_LOGIN',             1); //只有登录用户可以评论
define('COMMENT_CUSTOM',            2); //只有有过一次以上购买行为的用户可以评论
define('COMMENT_BOUGHT',            3); //只有购买够该商品的人可以评论

/* 减库存时机 */
define('SDT_SHIP',                  0); // 发货时
define('SDT_PLACE',                 1); // 下订单时

/* 加密方式 */
define('ENCRYPT_ZC',                1); //zc加密方式
define('ENCRYPT_UC',                2); //uc加密方式

/* 商品类别 */
define('G_REAL',                    1); //实体商品
define('G_CARD',                    0); //虚拟卡

/* 积分兑换 */
define('TO_P',                      0); //兑换到商城消费积分
define('FROM_P',                    1); //用商城消费积分兑换
define('TO_R',                      2); //兑换到商城等级积分
define('FROM_R',                    3); //用商城等级积分兑换

/* 支付宝商家账户 */
define('ALIPAY_AUTH', 				'gh0bis45h89m5mwcoe85us4qrwispes0');
define('ALIPAY_ID', 				'2088002052150939');

/* 添加feed事件到UC的TYPE*/
define('BUY_GOODS',                 1); //购买商品
define('COMMENT_GOODS',             2); //添加商品评论

/* 邮件发送用户 */
define('SEND_LIST', 				0);
define('SEND_USER', 				1);
define('SEND_RANK', 				2);

/* license接口 */
define('LICENSE_VERSION', 			'1.0');

/* 配送方式 */
define('SHIP_LIST', 				'cac|city_express|ems|flat|fpd|post_express|post_mail|presswork|sf_express|sto_express|yto|zto');

// end