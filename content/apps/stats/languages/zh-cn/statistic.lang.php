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
 * ECJIA 统计信息语言文件
 */
/* 流量统计 */
$LANG['stats_off']          = '网站流量统计已被关闭。<BR>如有需要请到: 系统设置->商店设置->基本设置 开启站点流量统计服务。';
$LANG['last_update']        = '最后更新日期';
$LANG['now_update']         = '更新记录';
$LANG['update_success']     = '分析记录已成功更新!';
$LANG['view_log']           = '查看分析记录';
$LANG['select_year_month']  = '查询年月';
$LANG['general_statement']  = '综合访问量报表';
$LANG['area_statement']     = '地区分布报表';
$LANG['from_statement']     = '来源网站报表';

$LANG['pv_stats']           = '综合访问数据';
$LANG['integration_visit']  = '综合访问量';
$LANG['seo_analyse']    = '搜索引擎分析';
$LANG['area_analyse']   = '地域分布';
$LANG['visit_site']     = '来访网站分析';
$LANG['key_analyse']    = '关键字分析';

$LANG['start_date']     = '开始日期';
$LANG['end_date']       = '结束日期';
$LANG['query']          = '查询';
$LANG['result_filter']  = '过滤结果';
$LANG['compare_query']  = '比较查询';
$LANG['year_status']    = '年走势';
$LANG['month_status']   = '月走势';

$LANG['year']           = '年';
$LANG['month']          = '月';
$LANG['day']            = '日';
$LANG['year_format']    = '%Y';
$LANG['month_format']   = '%c';

$LANG['from']   = '从';
$LANG['to']     = '到';
$LANG['view']   = '查看';

/* 销售概况 */
$LANG['overall_sell_circs'] = '当前总体销售情况';
$LANG['order_count_trend']  = '订单数(单位:个)';
$LANG['sell_out_amount']    = '销出产品数量';
$LANG['period']             = '时间段';
$LANG['order_amount_trend'] = '营业额(单位:元)';
$LANG['order_status']       = '订单走势';
$LANG['turnover_status']    = '销售额走势';
$LANG['sales_statistics']   = '销售统计';
$LANG['down_sales_stats']   = '销售概况报表下载';
$LANG['report_sell']        = '销售概况';

/* 订单统计 */
$LANG['overall_sum']        = '有效订单总金额';
$LANG['overall_choose']     = '总点击数';
$LANG['kilo_buy_amount']    = '每千点击订单数';
$LANG['kilo_buy_sum']       = '每千点击购物额';
$LANG["pay_type"]           = "支付方式";
$LANG["succeed"]            = "已成交";
$LANG["confirmed"]          = "已确认";
$LANG["unconfirmed"]        = "未确认";
$LANG["invalid"]            = "无效或已取消";
$LANG['order_circs']        = '订单概况';
$LANG['shipping_method']    = '配送方式';
$LANG['pay_method']         = '支付方式 ';
$LANG['down_order_statistics'] = '订单统计报表下载';

/* 销售排行 */
$LANG['order_by']           = '排行';
$LANG['goods_name']         = '商品名称';
$LANG['sell_amount']        = '销售量';
$LANG['sell_sum']           = '销售额';
$LANG['percent_count']      = '均价';
$LANG["to"]                 = '至';
$LANG['order_by_goodsnum']  = '按销售量排序';
$LANG["order_by_money"]     = '按销售额排序';
$LANG["download_sale_sort"] = "销售排行报表下载";

/* 客户统计 */
$LANG['guest_order_sum']            = '匿名会员平均订单额';
$LANG['member_count']               = '会员总数';
$LANG['member_order_count']         = '会员订单总数';
$LANG['guest_member_ordercount']    = '匿名会员订单总数';
$LANG['guest_member_orderamount']   = '匿名会员购物总额';
$LANG['percent_buy_member']         = '会员购买率 ';
$LANG['buy_member_formula']         = '（会员购买率 = 有订单会员数 ÷ 会员总数）';
$LANG['member_order_amount']        = '（每会员订单数 = 会员订单总数 ÷ 会员总数）';
$LANG['member_buy_amount']          = '（每会员购物额 = 会员购物总额 ÷ 会员总数）';
$LANG["order_turnover_peruser"]     = "每会员平均订单数及购物额";
$LANG["order_turnover_percus"]      = "匿名会员平均订单额及购物总额";
$LANG['guest_all_ordercount']       = '（匿名会员平均订单额 =  匿名会员购物总额 ÷ 匿名会员订单总数）';

$LANG['average_member_order']   = '每会员订单数';
$LANG['member_order_sum']       = '每会员购物额';
$LANG['order_member_count']     = '有订单会员数';
$LANG['member_sum']             = '会员购物总额';

$LANG['order_all_amount']   = '订单总数';
$LANG['order_all_turnover'] = '总购物额';

$LANG['down_guest_stats']= '客户统计报表下载';
$LANG['guest_statistics']= '客户统计报表';

/* 会员排行 */
$LANG['show_num']       = '显示数量';
$LANG['member_name']    = '会员名';
$LANG['order_amount']   = '订单数(单位:个)';
$LANG['buy_sum']        = '购物金额';

$LANG['order_amount_sort']      = '按订单数量排序';
$LANG['buy_sum_sort']           = '按购物金额排序';
$LANG['download_amount_sort']   = '下载购物金额报表';

/* 销售名细 */
$LANG['goods_name'] = '商品名称';
$LANG['goods_sn']   = '货号';
$LANG['order_sn']   = '订单号';
$LANG['amount']     = '数量';
$LANG['to']         = '至';
$LANG['sell_price'] = '售价';
$LANG['sell_date']  = '售出日期';
$LANG['down_sales'] = '下载销售明细';
$LANG['sales_list'] = '销售明细';

/* 访问购买比例 */
$LANG['fav_exponential']    = '人气指数';
$LANG['buy_times']          = '购买次数';
$LANG['visit_buy']          = '访问购买率';
$LANG['download_visit_buy'] = '下载访问购买率报表';

$LANG['goods_cat']          = '商品分类';
$LANG['goods_brand']        = '商品品牌';

/* 搜索引擎 */
$LANG['down_search_stats']  = '下载搜索关键字报表';
$LANG['tab_keywords']       = '关键字统计';
$LANG['keywords']           = '关键字';
$LANG['date']               = '日期';
$LANG['hits']               = '搜索次数';
$LANG['searchengine']       = '搜索引擎';

/*站外投放JS*/
$LANG['adsense_name']       = '投放的名称';
$LANG['cleck_referer']      = '点击来源';
$LANG['click_count']        = '点击次数';
$LANG['confirm_order']      = '有效订单数';
$LANG['gen_order_amount']   = '产生订单总数';

//end