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
 * ECJIA Statistics language file
 */
return array(
	/* Count of visitor statistics */
	'stats_off'		=> 'Web site traffic statistics have been closed. <BR>If necessary go to: System Setup -> Configuration -> Basic to open the site traffic statistics service.',
	'last_update'	=> 'Latest update',
	'now_update'	=> 'Update log',
	'update_success'=> 'Update successfully!',
	'view_log'		=> 'View log',
		
	'select_year_month'	=> 'Year/month',
	'general_statement' => 'Comprehensive views Report',
	'area_statement'	=> 'Distribution Report Region',
	'from_statement' 	=> 'Source Site Report',
		
	'pv_stats'			=> 'General visit data',
	'integration_visit'	=> 'Integration visit',
	'seo_analyse'		=> 'Search engine analyse',
	'area_analyse'		=> 'Area analyse',
	'visit_site'		=> 'Visit site analyse',
	'key_analyse'		=> 'Key word analyse',
	
	'start_date'	=> 'Start date',
	'end_date'		=> 'End date',
	'query'			=> 'Query',
	'result_filter'	=> 'Filter results',
	'compare_query'	=> 'Compare query',
	'year_status'	=> 'Year status',
	'month_status'	=> 'Mouth status',
	
	'year'	=> 'year',
	'month'	=> 'mouth',
	'day'	=> 'day',
	'times'	=> 'times',
	
	'year_format'	=> '%Y',
	'month_format'	=> '%c',
	
	'from'	=> 'from',
	'to'	=> 'to',
	'view'	=> 'View',
	
	/* Sales general situation */
	'overall_sell_circs'	=> 'Current overall sell circs',
	'order_count_trend'		=> 'Order quantity',
	'sell_out_amount'		=> 'Sell out quantity',
	'period'				=> 'period',
	'order_amount_trend'	=> 'Turnover(monetary unit:yuan)',
	'order_status'			=> 'Order status',
	'turnover_status'		=> 'Turnover status',
	'sales_statistics'		=> 'Sales statistics',
	'down_sales_stats'		=> 'Download sales status report',
	'report_sell' 			=> 'Sales Overview',
	
	/* Orders\' statistics */
	'overall_sum'		=> 'Total',
	'overall_choose'	=> ', Clicks sum',
	'kilo_buy_amount'	=> ', Orders quantity every 1000 clicks.',
	'kilo_buy_sum'		=> ', Shopping quantum every 1000 clicks.',
	"pay_type"			=> "Payment mode",
	"succeed"			=> "Succeed",
	"confirmed"			=> "Confirmed",
	"unconfirmed"		=> "Unconfirmed",
	"invalid"			=> "Invalid",
	'order_circs'		=> 'Order profile',
	'shipping_method'	=> 'Shipping method',
	'pay_method'		=> 'Payment method',
	'down_order_statistics'	=> 'Download order status report',
	
	/* Sales ranking */
	'order_by'		=> 'Ranking',
	'goods_name'	=> 'Name',
	'sell_amount'	=> 'Sales',
	'sell_sum'		=> 'Saleroom',
	'percent_count'	=> 'Average price',
	"to"			=> 'to',
		
	'order_by_goodsnum'		=> 'Sort by sales quantity',
	"order_by_money"		=> 'Sort by sales money',
	"download_sale_sort"	=> "Download sale sort report",
	
	/* Clients\' statistics */
	'guest_order_sum'		=>'Anonymous member average order sum.',
	'member_count'			=>'Members quantity',
		
	'member_order_count'	=>'Member orders quantity',
	'guest_member_ordercount'	=>'Anonymous member order total quantity.',
	'guest_member_orderamount'	=>'Anonymous member shopping total quantity.',
		
	'percent_buy_member'	=>'Purchase rate',
	'buy_member_formula'	=>'(Member purchase rate = Members with orders ÷ Total members)',
	'member_order_amount'	=>'(Orders every member = Total member order ÷ Total members)',
	'member_buy_amount'		=>'(Shopping sum every member = Total members shopping sum ÷ Total members)',
	"order_turnover_peruser"	=>"Average orders and shopping sum every member",
	"order_turnover_percus"		=>"Anonymous member average order sum and total shopping sum",
	'guest_all_ordercount'		=>'(Anonymous member average order sum = Total anonymous member shopping sum ÷ Total anonymous member orders)',
	
	'average_member_order'	=> 'Orders quantity every member',
	'member_order_sum'		=> 'Shopping quantum every member',
	'order_member_count'	=> 'Count of members with orders',
	'member_sum'			=> 'Total shopping quantum of members',
	'order_all_amount'		=> 'Oreders quantity',
	'order_all_turnover'	=> 'Total turnover',
	
	'down_guest_stats'		=> 'Customers download statistics',
	'guest_statistics'		=> 'Client statistics',
	
	/* Member ranking */
	'show_num'		=> 'Display',
	'member_name'	=> 'Username',
	'order_amount'	=> 'Order quantity(unit:unit)',
	'buy_sum'		=> 'Money of shopping',
	
	'order_amount_sort'		=> 'Sort by quantity',
	'buy_sum_sort'			=> 'Sort by money',
	'download_amount_sort'	=> 'Download to rate statements',
	
	/* Sales details */
	'goods_name'	=> 'Name',
	'goods_sn'		=> 'Product NO.',
	'order_sn'		=> 'Order NO.',
	'amount'		=> 'Quantity',
	'to'			=> 'to',
	'sell_price'	=> 'Price',
	'sell_date'		=> 'Date',
	'down_sales'	=> 'Download sales list',
	'sales_list'	=> 'Sales list',
	
	/* Visit and purchase proportion */
	'fav_exponential'	=> 'Favorite exponential',
	'buy_times'			=> 'Time',
	'visit_buy'			=> 'Purchase rate',
	'download_visit_buy'=> 'Download visit purchase rate statements',
	'goods_cat'			=> 'Category',
	'goods_brand'		=> 'Brand',
	
	/* 搜索引擎 */
	'down_search_stats'	=> 'Download Search Keyword Statements',
	'tab_keywords'		=> 'Keyword Statistics',
	'keywords'			=> 'Keyword',
	'date'				=> 'Date',
	'hits'				=> 'Search views',
		
	/*站外投放JS*/
	'searchengine' 		=> 'Search Engine',
	'list_searchengine' => 'Search engine',
	'adsense_name' 		=> 'Trafficking name',
	'cleck_referer' 	=> 'Click Source',
	'click_count' 		=> 'click count',
	'confirm_order' 	=> 'Number of active orders',
	'gen_order_amount' 	=> 'Generating total number of orders',

	//追加
	'adsense_js_goods' 		=>  'Stations outside the JS call goods',
	'search_keywords'		=>	'Search Keywords',	
	'start_date_msg' 		=>	'Start Date',
	'end_date_msg' 			=>	'End Date',
	'keywords' 				=>	'Keywords',
	'down_searchengine' 	=> 	'Download Search Keyword Report',
	'tips'					=>	'Tips:',
	'searchengine_stats'	=>	'Search engine statistics major statistical number of daily search engine spiders to crawl pages',
	'today'					=>	'Today',
	'yesterday'				=>	'Yesterday',
	'this_week'				=>	'This Week',
	'this_month'			=>	'This Year',
	'month'					=>	'month',
	'loading'				=>	'Loading in...',

	'overview'             	=> 'Overview',
	'more_info'             => 'More information:',
	
	'keywords_stats_help'	=> 'Welcome to ECJia intelligent background search engine page, the system on all the search engine information will be displayed on this page.',
	'about_keywords_help'	=> 'About search keywords help document',
	'search_engine_report'	=> 'Search engine statistics',
	'day_list'				=> array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
	'month_list' 			=> array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
	
	'js_lang' => array(
		'start_date_required'	=> 'The start time of the query cannot be empty!',
		'end_date_required'		=> 'The end time of the query cannot be empty!',
		'start_lt_end_date'		=> 'The start time of the query cannot exceed the end time!',
		'no_records'			=> 'Did not find any record',
		'day_list'				=> array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
		'times'					=> 'times',
	),
);

//end