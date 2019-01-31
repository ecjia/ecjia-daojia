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
 * js语言包设置
 */

defined('IN_ECJIA') or exit('No permission resources.');

return array(

    [
      'cfg_code' => 'basic',
      'cfg_name' => __('基本设置', 'setting'),
      'cfg_desc' => '',
      'cfg_range' => '',
    ],

    [
        'cfg_code' => 'display',
        'cfg_name' => __('显示设置', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_info',
        'cfg_name' => __('网店信息', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shopping_flow',
        'cfg_name' => __('购物流程', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'smtp',
        'cfg_name' => __('邮件服务器设置', 'setting'),
        'cfg_desc' => __('设置邮件服务器基本参数', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'goods',
        'cfg_name' => __('商品显示设置', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'lang',
        'cfg_name' => __('系统语言', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_closed',
        'cfg_name' => __('暂时关闭网站', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'icp_file',
        'cfg_name' => __('ICP 备案证书文件', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'watermark',
        'cfg_name' => __('水印文件', 'setting'),
        'cfg_desc' => __('水印文件须为gif格式才可支持透明度设置。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'watermark_place',
        'cfg_name' => __('水印位置', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无', 'setting'),
            '1' => __('左上', 'setting'),
            '2' => __('右上', 'setting'),
            '3' => __('居中', 'setting'),
            '4' => __('左下', 'setting'),
            '5' => __('右下', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'use_storage',
        'cfg_name' => __('是否启用库存管理', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'market_price_rate',
        'cfg_name' => __('市场价格比例', 'setting'),
        'cfg_desc' => __('输入商品售价时将自动根据该比例计算市场价格', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'rewrite',
        'cfg_name' => __('URL重写', 'setting'),
        'cfg_desc' => __('URL重写是一种搜索引擎优化技术，可以将动态的地址模拟成静态的HTML文件。需要Apache的支持。', 'setting'),
        'cfg_range' => array(
            '0' => __('禁用', 'setting'),
            '1' => __('简单重写', 'setting'),
            '2' => __('复杂重写', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'integral_name',
        'cfg_name' => __('消费积分名称', 'setting'),
        'cfg_desc' => __('您可以将消费积分重新命名。例如：烧币', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'integral_scale',
        'cfg_name' => __('积分换算比例', 'setting'),
        'cfg_desc' => __('每100积分可抵多少元现金', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'integral_percent',
        'cfg_name' => __('积分支付比例', 'setting'),
        'cfg_desc' => __('每100元商品最多可以使用多少元积分', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'enable_order_check',
        'cfg_name' => __('是否开启新订单提醒', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'default_storage',
        'cfg_name' => __('默认库存', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'date_format',
        'cfg_name' => __('日期格式', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'time_format',
        'cfg_name' => __('时间格式', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'currency_format',
        'cfg_name' => __('货币格式', 'setting'),
        'cfg_desc' => __('显示商品价格的格式，%s将被替换为相应的价格数字。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'thumb_width',
        'cfg_name' => __('缩略图宽度', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'thumb_height',
        'cfg_name' => __('缩略图高度', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'image_width',
        'cfg_name' => __('商品图片宽度', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'image_height',
        'cfg_name' => __('商品图片高度', 'setting'),
        'cfg_desc' => __('如果您的服务器支持GD，在您上传商品图片的时候将自动将图片缩小到指定的尺寸。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'best_number',
        'cfg_name' => __('精品推荐数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'new_number',
        'cfg_name' => __('新品推荐数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'hot_number',
        'cfg_name' => __('热销商品数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'promote_number',
        'cfg_name' => __('特价商品的数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'group_goods_number',
        'cfg_name' => __('团购商品的数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'top_number',
        'cfg_name' => __('销量排行数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'history_number',
        'cfg_name' => __('浏览历史数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'comments_number',
        'cfg_name' => __('评论数量', 'setting'),
        'cfg_desc' => __('显示在商品详情页的用户评论数量。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'bought_goods',
        'cfg_name' => __('相关商品数量', 'setting'),
        'cfg_desc' => __('显示多少个购买此商品的人还买过哪些商品', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'article_number',
        'cfg_name' => __('最新文章显示数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'order_number',
        'cfg_name' => __('订单显示数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_name',
        'cfg_name' => __('商店名称', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_title',
        'cfg_name' => __('商店标题', 'setting'),
        'cfg_desc' => __('商店的标题将显示在浏览器的标题栏', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_website',
        'cfg_name' => __('商店网址', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_desc',
        'cfg_name' => __('商店描述', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_keywords',
        'cfg_name' => __('商店关键字', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_country',
        'cfg_name' => __('指定运营国家', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_province',
        'cfg_name' => __('所在省份', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_city',
        'cfg_name' => __('所在城市', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_address',
        'cfg_name' => __('详细地址', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'licensed',
        'cfg_name' => __('是否显示 Licensed', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'qq',
        'cfg_name' => __('客服QQ号码', 'setting'),
        'cfg_desc' => __('如果您有多个客服的QQ号码，请在每个号码之间使用半角逗号（,）分隔。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'ww',
        'cfg_name' => __('淘宝旺旺', 'setting'),
        'cfg_desc' => __('如果您有多个客服的淘宝旺旺号码，请在每个号码之间使用半角逗号（,）分隔。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'skype',
        'cfg_name' => __('Skype', 'setting'),
        'cfg_desc' => __('如果您有多个客服的Skype号码，请在每个号码之间使用半角逗号（,）分隔。提示：你需要在你的Skype隐私设置中启用状态显示功能', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'ym',
        'cfg_name' => __('微信号码', 'setting'),
        'cfg_desc' => __('如果您有多个客服的微信码，请在每个号码之间使用半角逗号（,）分隔。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'msn',
        'cfg_name' => __('微博号码', 'setting'),
        'cfg_desc' => __('如果您有多个客服的微博号码，请在每个号码之间使用半角逗号（,）分隔。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'service_email',
        'cfg_name' => __('客服邮件地址', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'service_phone',
        'cfg_name' => __('客服电话', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'can_invoice',
        'cfg_name' => __('能否开发票', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不能', 'setting'),
            '1' => __('能', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'user_notice',
        'cfg_name' => __('用户中心公告', 'setting'),
        'cfg_desc' => __('该信息将在用户中心欢迎页面显示', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_notice',
        'cfg_name' => __('商店公告', 'setting'),
        'cfg_desc' => __('以上内容将显示在首页商店公告中,注意控制公告内容长度不要超过公告显示区域大小。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_reg_closed',
        'cfg_name' => __('是否关闭注册', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'send_mail_on',
        'cfg_name' => __('是否开启自动发送邮件', 'setting'),
        'cfg_desc' => __('启用该选项登录后台时，会自动发送邮件队列中尚未发送的邮件', 'setting'),
        'cfg_range' => array(
            '0' => __('关闭', 'setting'),
            '1' => __('开启', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'auto_generate_gallery',
        'cfg_name' => __('上传商品是否自动生成相册图', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'retain_original_img',
        'cfg_name' => __('上传商品时是否保留原图', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'member_email_validate',
        'cfg_name' => __('是否开启会员邮件验证', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('关闭', 'setting'),
            '1' => __('开启', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'send_verify_email',
        'cfg_name' => __('用户注册时自动发送验证邮件', 'setting'),
        'cfg_desc' => __('“是否开启会员邮件验证”设为开启时才可使用此功能', 'setting'),
        'cfg_range' => array(
            '0' => __('关闭', 'setting'),
            '1' => __('开启', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'message_board',
        'cfg_name' => __('是否启用留言板功能', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('关闭', 'setting'),
            '1' => __('开启', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'message_check',
        'cfg_name' => __('用户留言是否需要审核', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不需要', 'setting'),
            '1' => __('需要', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'review_goods',
        'cfg_name' => __('审核商家商品', 'setting'),
        'cfg_desc' => __('设置是否需要审核商家添加的商品，如果开启则所有商家添加的商品都需要审核之后才能显示', 'setting'),
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'store_identity_certification',
        'cfg_name' => __('商家强制认证', 'setting'),
        'cfg_desc' => __('设置是否需要认证商家资质，如果开启则认证通过后的商家才能开店和显示', 'setting'),
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

//    [
//        'cfg_code' => 'use_package',
//        'cfg_name' => __('是否使用包装', 'setting'),
//        'cfg_desc' => '',
//        'cfg_range' => '',
//    ],

//    [
//        'cfg_code' => 'use_card',
//        'cfg_name' => __('是否使用贺卡', 'setting'),
//        'cfg_desc' => '',
//        'cfg_range' => '',
//    ],

    [
        'cfg_code' => 'use_integral',
        'cfg_name' => __('是否使用积分', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不使用', 'setting'),
            '1' => __('使用', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'use_bonus',
        'cfg_name' => __('是否使用红包', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不使用', 'setting'),
            '1' => __('使用', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'use_surplus',
        'cfg_name' => __('是否使用余额', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不使用', 'setting'),
            '1' => __('使用', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'use_how_oos',
        'cfg_name' => __('是否使用缺货处理', 'setting'),
        'cfg_desc' => __('使用缺货处理时前台订单确认页面允许用户选择缺货时处理方法。', 'setting'),
        'cfg_range' => array(
            '0' => __('不使用', 'setting'),
            '1' => __('使用', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'send_confirm_email',
        'cfg_name' => __('确认订单时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不发送邮件', 'setting'),
            '1' => __('发送邮件', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'order_pay_note',
        'cfg_name' => __('设置订单为“已付款”时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无需填写备注', 'setting'),
            '1' => __('必须填写备注', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'order_unpay_note',
        'cfg_name' => __('设置订单为“未付款”时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无需填写备注', 'setting'),
            '1' => __('必须填写备注', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'order_ship_note',
        'cfg_name' => __('设置订单为“已发货”时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无需填写备注', 'setting'),
            '1' => __('必须填写备注', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'order_unship_note',
        'cfg_name' => __('设置订单为“未发货”时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无需填写备注', 'setting'),
            '1' => __('必须填写备注', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'when_dec_storage',
        'cfg_name' => __('什么时候减少库存', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('下定单时', 'setting'),
            '1' => __('发货时', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'send_ship_email',
        'cfg_name' => __('发货时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不发送邮件', 'setting'),
            '1' => __('发送邮件', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'order_receive_note',
        'cfg_name' => __('设置订单为“收货确认”时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无需填写备注', 'setting'),
            '1' => __('必须填写备注', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'order_cancel_note',
        'cfg_name' => __('取消订单时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无需填写备注', 'setting'),
            '1' => __('必须填写备注', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'send_cancel_email',
        'cfg_name' => __('取消订单时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不发送邮件', 'setting'),
            '1' => __('发送邮件', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'order_return_note',
        'cfg_name' => __('退货时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无需填写备注', 'setting'),
            '1' => __('必须填写备注', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'order_invalid_note',
        'cfg_name' => __('把订单设为无效时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('无需填写备注', 'setting'),
            '1' => __('必须填写备注', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'send_invalid_email',
        'cfg_name' => __('把订单设为无效时', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不发送邮件', 'setting'),
            '1' => __('发送邮件', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'sn_prefix',
        'cfg_name' => __('商品货号前缀', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'close_comment',
        'cfg_name' => __('关闭网店的原因', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'watermark_alpha',
        'cfg_name' => __('水印透明度', 'setting'),
        'cfg_desc' => __('水印的透明度，可选值为0-100。当设置为100时则为不透明。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'icp_number',
        'cfg_name' => __('ICP证书或ICP备案证书号', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'invoice_content',
        'cfg_name' => __('发票内容', 'setting'),
        'cfg_desc' => __('客户要求开发票时可以选择的内容。例如：办公用品。每一行代表一个选项。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'invoice_type',
        'cfg_name' => __('发票类型及税率', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'stock_dec_time',
        'cfg_name' => __('减库存的时机', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('发货时', 'setting'),
            '1' => __('下订单时', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'comment_check',
        'cfg_name' => __('用户评论是否需要审核', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不需要', 'setting'),
            '1' => __('需要', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'comment_factor',
        'cfg_name' => __('商品评论的条件', 'setting'),
        'cfg_desc' => __('选取较高的评论条件可以有效的减少垃圾评论的产生。只有用户订单完成后才认为该用户有购买行为', 'setting'),
        'cfg_range' => array(
            '0' => __('所有用户', 'setting'),
            '1' => __('仅登录用户', 'setting'),
            '2' => __('有过一次以上购买行为用户', 'setting'),
            '3' => __('仅购买过该商品用户', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'no_picture',
        'cfg_name' => __('商品的默认图片', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'stats_code',
        'cfg_name' => __('统计代码', 'setting'),
        'cfg_desc' => __('您可以将其他访问统计服务商提供的代码添加到每一个页面。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'cache_time',
        'cfg_name' => __('缓存存活时间（秒）', 'setting'),
        'cfg_desc' => __('前台页面缓存的存活时间，以秒为单位。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'page_size',
        'cfg_name' => __('商品分类页列表的数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'article_page_size',
        'cfg_name' => __('文章分类页列表的数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'page_style',
        'cfg_name' => __('分页样式', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('默认经典', 'setting'),
            '1' => __('流行页码', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'sort_order_type',
        'cfg_name' => __('商品分类页默认排序类型', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('按上架时间', 'setting'),
            '1' => __('按商品价格', 'setting'),
            '2' => __('按最后更新时间', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'sort_order_method',
        'cfg_name' => __('商品分类页默认排序方式', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('降序排列', 'setting'),
            '1' => __('升序排列', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_order_type',
        'cfg_name' => __('商品分类页默认显示方式', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('列表显示', 'setting'),
            '1' => __('表格显示', 'setting'),
            '2' => __('文本显示', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'goods_name_length',
        'cfg_name' => __('商品名称的长度', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'price_format',
        'cfg_name' => __('商品价格显示规则', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不处理', 'setting'),
            '1' => __('保留不为 0 的尾数', 'setting'),
            '2' => __('不四舍五入，保留一位小数', 'setting'),
            '3' => __('不四舍五入，不保留小数', 'setting'),
            '4' => __('先四舍五入，保留一位小数', 'setting'),
            '5' => __('先四舍五入，不保留小数 ', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'register_points',
        'cfg_name' => __('会员注册赠送积分', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_logo',
        'cfg_name' => __('商店 Logo', 'setting'),
        'cfg_desc' => __('请在上传前将图片的文件名命名为logo.gif', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'enable_gzip',
        'cfg_name' => __('是否启用Gzip模式', 'setting'),
        'cfg_desc' => __('启用Gzip模式可压缩发送页面大小，加快网页传输。需要php支持Gzip。如果已经用Apache等对页面进行Gzip压缩，请禁止该功能。', 'setting'),
        'cfg_range' => array(
            '0' => __('禁用', 'setting'),
            '1' => __('启用', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'anonymous_buy',
        'cfg_name' => __('是否允许未登录用户购物', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不允许', 'setting'),
            '1' => __('允许', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'min_goods_amount',
        'cfg_name' => __('最小购物金额', 'setting'),
        'cfg_desc' => __('达到此购物金额，才能提交订单。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'one_step_buy',
        'cfg_name' => __('是否一步购物', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_goodssn',
        'cfg_name' => __('是否显示货号', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不显示', 'setting'),
            '1' => __('显示', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_brand',
        'cfg_name' => __('是否显示品牌', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不显示', 'setting'),
            '1' => __('显示', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_goodsweight',
        'cfg_name' => __('是否显示重量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不显示', 'setting'),
            '1' => __('显示', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_goodsnumber',
        'cfg_name' => __('是否显示库存', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不显示', 'setting'),
            '1' => __('显示', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_addtime',
        'cfg_name' => __('是否显示上架时间', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不显示', 'setting'),
            '1' => __('显示', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_marketprice',
        'cfg_name' => __('是否显示市场价格', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不显示', 'setting'),
            '1' => __('显示', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'goodsattr_style',
        'cfg_name' => __('商品属性显示样式', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('下拉列表', 'setting'),
            '1' => __('单选按钮', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'test_mail_address',
        'cfg_name' => __('邮件地址', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'send',
        'cfg_name' => __('发送测试邮件', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'send_service_email',
        'cfg_name' => __('下订单时是否给客服发邮件', 'setting'),
        'cfg_desc' => __('网店信息中的客服邮件地址不为空时，该选项有效。', 'setting'),
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_goods_in_cart',
        'cfg_name' => __('购物车里显示商品方式', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '1' => __('只显示文字', 'setting'),
            '2' => __('只显示图片', 'setting'),
            '3' => __('显示文字与图片', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'show_attr_in_cart',
        'cfg_name' => __('购物车里是否显示商品属性', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'email_content',
        'cfg_name' => __('您好！这是一封检测邮件服务器设置的测试邮件。收到此邮件，意味着您的邮件服务器设置正确！您可以进行其它邮件发送的操作了！', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'sms',
        'cfg_name' => __('短信通知', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'sms_shop_mobile',
        'cfg_name' => __('商家的手机号码', 'setting'),
        'cfg_desc' => __('请先注册手机短信服务再填写手机号码', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'sms_order_placed',
        'cfg_name' => __('客户下订单时是否给商家发短信', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不发短信', 'setting'),
            '1' => __('发短信', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'sms_order_payed',
        'cfg_name' => __('客户付款时是否给商家发短信', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不发短信', 'setting'),
            '1' => __('发短信', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'sms_order_shipped',
        'cfg_name' => __('商家发货时是否给客户发短信', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('不发短信', 'setting'),
            '1' => __('发短信', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'attr_related_number',
        'cfg_name' => __('属性关联的商品数量', 'setting'),
        'cfg_desc' => __('在商品详情页面显示多少个属性关联的商品。', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'top10_time',
        'cfg_name' => __('排行统计的时间', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('所有', 'setting'),
            '1' => __('一年', 'setting'),
            '2' => __('半年', 'setting'),
            '3' => __('三个月', 'setting'),
            '4' => __('一个月', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'goods_gallery_number',
        'cfg_name' => __('商品详情页相册图片数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'article_title_length',
        'cfg_name' => __('文章标题的长度', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'cron_method',
        'cfg_name' => __('是否开启命令行调用计划任务', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'timezone',
        'cfg_name' => __('默认时区', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '-12' 	=> __('(GMT -12:00) Eniwetok, Kwajalein', 'setting'),
            '-11' 	=> __('(GMT -11:00) Midway Island, Samoa', 'setting'),
            '-10' 	=> __('(GMT -10:00) Hawaii', 'setting'),
            '-9'	=> __('(GMT -09:00) Alaska', 'setting'),
            '-8' 	=> __('(GMT -08:00) Pacific Time (US &amp, Canada), Tijuana', 'setting'),
            '-7' 	=> __('(GMT -07:00) Mountain Time (US &amp, Canada), Arizona', 'setting'),
            '-6' 	=> __('(GMT -06:00) Central Time (US &amp, Canada), Mexico City', 'setting'),
            '-5' 	=> __('(GMT -05:00) Eastern Time (US &amp, Canada), Bogota, Lima, Quito', 'setting'),
            '-4' 	=> __('(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz', 'setting'),
            '-3.5' 	=> __('(GMT -03:30) Newfoundland', 'setting'),
            '-3' 	=> __('(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is', 'setting'),
            '-2' 	=> __('(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena', 'setting'),
            '-1' 	=> __('(GMT -01:00) Azores, Cape Verde Islands', 'setting'),
            '0' 	=> __('(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia', 'setting'),
            '1' 	=> __('(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome', 'setting'),
            '2' 	=> __('(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa', 'setting'),
            '3' 	=> __('(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi', 'setting'),
            '3.5' 	=> __('(GMT +03:30) Tehran', 'setting'),
            '4' 	=> __('(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi', 'setting'),
            '4.5' 	=> __('(GMT +04:30) Kabul', 'setting'),
            '5' 	=> __('(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent', 'setting'),
            '5.5' 	=> __('(GMT +05:30) Bombay, Calcutta, Madras, New Delhi', 'setting'),
            '5.75' 	=> __('(GMT +05:45) Katmandu', 'setting'),
            '6' 	=> __('(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk', 'setting'),
            '6.5' 	=> __('(GMT +06:30) Rangoon', 'setting'),
            '7' 	=> __('(GMT +07:00) Bangkok, Hanoi, Jakarta', 'setting'),
            '8' 	=> __('(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei', 'setting'),
            '9' 	=> __('(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk', 'setting'),
            '9.5' 	=> __('(GMT +09:30) Adelaide, Darwin', 'setting'),
            '10' 	=> __('(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok', 'setting'),
            '11' 	=> __('(GMT +11:00) Magadan, New Caledonia, Solomon Islands', 'setting'),
            '12' 	=> __('(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'upload_size_limit',
        'cfg_name' => __('附件上传大小', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '-1' 	=> __('服务默认设置', 'setting'),
            '0' 	=> __('0KB', 'setting'),
            '64' 	=> __('64KB', 'setting'),
            '128' 	=> __('128KB', 'setting'),
            '256' 	=> __('256KB', 'setting'),
            '512' 	=> __('512KB', 'setting'),
            '1024' 	=> __('1MB', 'setting'),
            '2048' 	=> __('2MB', 'setting'),
            '4096' 	=> __('4MB', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'search_keywords',
        'cfg_name' => __('首页搜索的关键字', 'setting'),
        'cfg_desc' => __('首页显示的搜索关键字,请用半角逗号(,)分隔多个关键字', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'cart_confirm',
        'cfg_name' => __('购物车确定提示', 'setting'),
        'cfg_desc' => __('允许您设置用户点击“加入购物车”后是否提示以及随后的动作。', 'setting'),
        'cfg_range' => array(
            '1' => __('提示用户，点击“确定”进购物车', 'setting'),
            '2' => __('提示用户，点击“取消”进购物车', 'setting'),
            '3' => __('直接进入购物车', 'setting'),
            '4' => __('不提示并停留在当前页面', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'bgcolor',
        'cfg_name' => __('缩略图背景色', 'setting'),
        'cfg_desc' => __('颜色请以#FFFFFF格式填写', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'name_of_region_1',
        'cfg_name' => __('一级配送区域名称', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'name_of_region_2',
        'cfg_name' => __('二级配送区域名称', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'name_of_region_3',
        'cfg_name' => __('三级配送区域名称', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'name_of_region_4',
        'cfg_name' => __('四级配送区域名称', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'related_goods_number',
        'cfg_name' => __('关联商品显示数量', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'visit_stats',
        'cfg_name' => __('站点访问统计', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('关闭', 'setting'),
            '1' => __('开启', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'help_open',
        'cfg_name' => __('用户帮助是否打开', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('关闭', 'setting'),
            '1' => __('打开', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'company_name',
        'cfg_name' => __('公司名称', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_weibo_url',
        'cfg_name' => __('微博地址', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_wechat_qrcode',
        'cfg_name' => __('微信二维码', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    //与底部语言合并

    [
        'cfg_code' => 'mail_service',
        'cfg_name' => __('邮件服务', 'setting'),
        'cfg_desc' => __('如果您选择了采用服务器内置的 Mail 服务，您不需要填写下面的内容。', 'setting'),
        'cfg_range' => array(
            '0' => __('采用服务器内置的 Mail 服务', 'setting'),
            '1' => __('采用其他的 SMTP 服务', 'setting'),
        ),    ],

    [
        'cfg_code' => 'smtp_host',
        'cfg_name' => __('发送邮件服务器地址(SMTP)', 'setting'),
        'cfg_desc' => __('邮件服务器主机地址。如果本机可以发送邮件则设置为localhost', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'smtp_port',
        'cfg_name' => __('服务器端口', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'smtp_user',
        'cfg_name' => __('邮件发送帐号', 'setting'),
        'cfg_desc' => __('发送邮件所需的认证帐号，如果没有就为空着', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'smtp_pass',
        'cfg_name' => __('帐号密码', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'smtp_mail',
        'cfg_name' => __('邮件回复地址', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'mail_charset',
        'cfg_name' => __('邮件编码', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            'UTF8' => __('国际化编码（utf8）', 'setting'),
            'GB2312' => __('简体中文', 'setting'),
            'BIG5' => __('繁体中文', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'smtp_ssl',
        'cfg_name' => __('邮件服务器是否要求加密连接(SSL)', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => array(
            '0' => __('否', 'setting'),
            '1' => __('是', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'recommend_order',
        'cfg_name' => __('推荐商品排序', 'setting'),
        'cfg_desc' => __('推荐排序适合少量推荐，随机显示大量推荐', 'setting'),
        'cfg_range' => array(
            '0' => __('推荐排序', 'setting'),
            '1' => __('随机显示', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'wap',
        'cfg_name' => __('WAP设置', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'wap_config',
        'cfg_name' => __('是否使用WAP功能', 'setting'),
        'cfg_desc' => __('此功能只支持简体中文且只在中国大陆区有效', 'setting'),
        'cfg_range' => array(
            '0' => __('关闭', 'setting'),
            '1' => __('开启', 'setting'),
        ),
    ],

    [
        'cfg_code' => 'wap_logo',
        'cfg_name' => __('WAP LOGO上传', 'setting'),
        'cfg_desc' => __('为了更好地兼容各种手机类型，LOGO 最好为png图片', 'setting'),
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'mobile_touch_qrcode',
        'cfg_name' => __('H5 访问二维码', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'mobile_touch_url',
        'cfg_name' => __('H5 商城URL', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'wap_app_download_show',
        'cfg_name' => __('是否推广APP下载', 'setting'),
        'cfg_desc' => __('在H5首页底部推广您的APP，增加下载量。', 'setting'),
        'cfg_range' => array(
            '0' => '关闭',
            '1' => '开启',
        ),
    ],

    [
        'cfg_code' => 'wap_app_download_img',
        'cfg_name' => __('推广APP下载图片', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'mobile_iphone_download',
        'cfg_name' => __('iPhone下载地址', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'mobile_android_download',
        'cfg_name' => __('Android下载地址', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'shop_app_icon',
        'cfg_name' => __('APP图标', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'mobile_app_description',
        'cfg_name' => __('移动应用简介', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

    [
        'cfg_code' => 'comment',
        'cfg_name' => __('评论设置', 'setting'),
        'cfg_desc' => '',
        'cfg_range' => '',
    ],

);
//end
