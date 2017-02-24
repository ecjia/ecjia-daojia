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
return array(
	/* Count of visitor statistics */
	'stats_off'			=> 'Web site traffic statistics have been closed. <BR>If necessary go to: System Setup -> Configuration -> Basic to open the site traffic statistics service.',
	'last_update'		=> 'Latest update',
	'now_update'		=> 'Update log',
	'update_success'	=> 'Update successfully!',
	'view_log'			=> 'View log',
	'select_year_month'	=> 'Year/month',
	'pv_stats'			=> 'General visit data',
	'integration_visit'	=> 'Integration visit',
	'seo_analyse'		=> 'Search engine analyse',
	'area_analyse'		=> 'Area analyse',
	'visit_site'		=> 'Visit site analyse',
	'key_analyse'		=> 'Key word analyse',
		
	'general_statement' => 'Comprehensive views Report',
	'area_statement'	=> 'Distribution Report Region',
	'from_statement' 	=> 'Source Site Report',
	
	'start_date'	=> 'Start date',
	'end_date'		=> 'End date',
	'query'			=> 'Query',
	'result_filter'	=> 'Filter results',
	'compare_query'	=> 'Compare query',
	'year_status'	=> 'Year status',
	'month_status'	=> 'Mouth status',
	'year'			=> 'year',
	'month'			=> 'mouth',
	'day'			=> 'day',
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
	'down_sales_stats'		=> 'Download Sales Status Report',
	'sale_general_statement'=> 'Sales profile report',
	'report_sell' 			=> 'Sales Overview',
	
	/* Orders\' statistics */
	'overall_sum'		=> 'Total',
	'overall_choose'	=> 'Clicks sum:',
	'kilo_buy_amount'	=> 'Orders quantity every 1000 clicks:',
	'kilo_buy_sum'		=> 'Shopping quantum every 1000 clicks:',
	"pay_type"			=> "Payment mode",
	"succeed"			=> "Succeed",
	"confirmed"			=> "Confirmed",
	"unconfirmed"		=> "Unconfirmed",
	"invalid"			=> "Invalid",
	'order_circs'		=> 'Order profile',
	'shipping_method'	=> 'Shipping method',
	'pay_method'		=> 'Payment method',
	'down_order_statistics'	=> 'Download Order Status Report',
	'order_statement'	=> 'Order Statistics Report',
	
	/* Sales ranking */
	'order_by'		=> 'Ranking',
	'goods_name'	=> 'Name',
	'sell_amount'	=> 'Sales',
	'sell_sum'		=> 'Saleroom',
	'percent_count'	=> 'Average price',
	"to"			=> 'to',
		
	'order_by_goodsnum'		=> 'Sort by sales quantity',
	"order_by_money"		=> 'Sort by sales money',
	"download_sale_sort"	=> "Download Sale Sort Report",
	'sale_order_statement' 	=> 'Sales Report',
	
	/* Clients\' statistics */
	'guest_order_sum'		=> 'Anonymous member average order sum:',
	'member_count'			=> 'Members quantity:',
	'member_order_count'	=> 'Member orders quantity:',
	
	'guest_member_ordercount'	=>'Anonymous member order total quantity:',
	'guest_member_orderamount'	=>'Anonymous member shopping total quantity:',
		
	'percent_buy_member'		=> 'Purchase rate:',
	'buy_member_formula'		=> '(Member purchase rate = Members with orders ÷ Total members)',
	'member_order_amount'		=> '(Orders every member = Total member order ÷ Total members)',
	'member_buy_amount'			=> '(Shopping sum every member = Total members shopping sum ÷ Total members)',
	
	"order_turnover_peruser"	=> "Average orders and shopping sum every member",
	"order_turnover_percus"		=> "Anonymous member average order sum and total shopping sum",
	'guest_all_ordercount'		=> '(Anonymous member average order sum = Total anonymous member shopping sum ÷ Total anonymous member orders)',
	
	'average_member_order'	=> 'Orders quantity every member:',
	'member_order_sum'		=> 'Shopping quantum every member:',
	'order_member_count'	=> 'Count of members with orders:',
	'member_sum'			=> 'Total shopping quantum of members:',
	'order_all_amount'		=> 'Oreders quantity',
	'order_all_turnover'	=> 'Total turnover',
	'down_guest_stats'		=> 'Customers Download Statistics',
	'guest_statistics'		=> 'Customer Statistics',
	
	/* Member ranking */
	'show_num'		=> 'Display',
	'member_name'	=> 'Username',
	'order_amount'	=> 'Order quantity(Unit:Yuan)',
	'buy_sum'		=> 'Money of shopping',
	
	'order_amount_sort'		=> 'Sort by quantity',
	'buy_sum_sort'			=> 'Sort by money',
	'download_amount_sort'	=> 'Download Rate Statements',
	'users_order_statement' => 'Shopping amount Report',
	
	/* Sales details */
	'goods_name'	=> 'Name',
	'goods_sn'		=> 'Product No.',
	'order_sn'		=> 'Order No.',
	'amount'		=> 'Quantity',
	'to'			=> 'to',
	'sell_price'	=> 'Price',
	'sell_date'		=> 'Date',
	'down_sales'	=> 'Download sales list',
	'sales_list'	=> 'Sales List',
	'sales_list_statement' => 'Sales detail report',
	
	/* Visit and purchase proportion */
	'fav_exponential'	=> 'Favorite exponential',
	'buy_times'			=> 'Time',
	'visit_buy'			=> 'Purchase Rate',
	'list_visit_buy'	=> 'Purchase rate',
	
	'download_visit_buy'	=> 'Download Visit Purchase Rate Statements',
	'visit_buy_statement' 	=> 'Access purchase rate report',
	
	'goods_cat'		=> 'Category',
	'goods_brand'	=> 'Brand',
	
	/* 搜索引擎 */
	'down_search_stats'		=> 'Download search keyword statements',
	'tab_keywords'			=> 'Keyword Statistics',
	'searchengine' 			=> 'search engine',
	
	'keywords'				=> 'Keyword',
	'date'					=> 'Date',
	'hits'					=> 'Search Views',
		
	/*站外投放JS*/
	'adsense_name' 		=> 'Name',
	'cleck_referer' 	=> 'Click source',
	'click_count' 		=> 'Click count',
	'confirm_order' 	=> 'Valid orders',
	'gen_order_amount' 	=> 'Total orders quantity',
	'adsense_statement' => 'Ad Conversion Rate Report',
		
	//追加
	'adsense_js_goods' 		=>  'Stations outside the JS call goods',
	'search_keywords'		=>	'search for the keyword',	
	'start_date_msg' 		=>	'Start Date',
	'end_date_msg' 			=>	'End Date',
	'keywords' 				=>	'Keywords',
	'down_searchengine' 	=> 	'Download Search Keyword Report',
	'tips'					=>	'Tips:',
	'searchengine_stats'	=>	'Search engine statistics major statistical number of daily search engine spiders to crawl pages',
	'today'					=>	'Nowadays',
	'yesterday'				=>	'yesterday',
	'this_week'				=>	'This week',
	'this_month'			=>	'this month',
	'month'					=>	'month',
	'loading'				=>	'Loading in ......',
	'guest_stats' 			=>	'Customer Statistics',
		
	'adsense'				=>	'Conversion Rate',
	'adsense_list'			=>	'AD List',
	'down_adsense'			=>	'Download Advertisement Statistics',
	'no_stats_data' 		=>	'No statistical data',
	'order_stats'			=>	'Order Statistics',
	'order_stats_date'		=>	'Order charts displayed by default by the time query.',
	'order_stats_info'		=>	'Order statistics information',
	'overall_sum_lable' 	=>	'The total amount of active orders:',
	'overall_choose_lable' 	=>	'Total number of hits:',
	'select_date_lable'		=>	'Query by time period:',
	'select_month_lable'	=>	'Query by month:',
	
	'no_order_default'		=>	'Have not complete the sales before orders are not included in the default trend for the month',
	'year_status_lable' 	=>	'Year trend:',
	'month_status_lable' 	=>	'Month trend:',
	'no_sales_details'		=>	'No completed orders not included in the sales details.',
	'search'				=>	'Search',
	'no_sale_sort'			=>	'No completed orders not included in the sales ranking.',
	'no_included_member'	=>	'Have not completed a transaction order is not included in Member Ranking Member.',
	
	'no_orders_visit_buy'	=>	'did not complete the purchase orders are not included in the rate of access.',
	'pls_select_category'	=>	'Please select category',
	'pls_select_brand'		=>	'Please select brand',
		
	'unconfirmed_order'		=> 'Unconfirmed order',
	'confirmed_order'		=> 'Confirmed order',
	'succeed_order'			=> 'Completed order',
	'invalid_order'			=> 'Invalid order',
	
	'overview'              => 'Overview',
	'more_info'             => 'More information:',
	'adsense_help'			=> 'Welcome to ECJia intelligent background advertising conversion page, the system in all the advertising conversion rate will be displayed in this list.',
	'about_adsense'			=> 'About Ad conversion rate help document',
	
	'guest_stats_help'		=> 'Welcome to ECJia intelligent background customer statistics page, the system of all customer statistics will be displayed on this page.',
	'about_guest_stats'		=> 'About customer statistics help document',
	
	'order_stats_help'		=> 'Welcome to ECJia intelligent background order statistics page, all the order statistics in the system will be displayed on this page.',
	'about_order_stats'		=> 'About order statistics to help document',
	
	'sale_general_help'		=> 'Welcome to ECJia intelligent background sales profile page, the system of all the sales profile information will be displayed on this page.',
	'about_sale_general'	=> 'About sales profiles help document',
	
	'sale_list_help'		=> 'Welcome to ECJia intelligent background sales details page, the details of all sales information will be displayed in this list.',
	'about_sale_list'		=> 'About sales details help document',
	
	'sale_order_help'		=> 'Welcome to ECJia intelligent background sales ranking page, ranking system in all sales information will be displayed on this page.',
	'about_sale_order'		=> 'About sales ranking help document',
	
	'users_order_help'		=> 'Welcome to ECJia intelligent background members page, ranking system in all Member ranking information is displayed in this list.',
	'about_users_order'		=> 'About ranking member help document',
	
	'visit_sold_help'		=> 'Welcome to ECJia intelligent background purchase rate access page, the system of all access to rate information will be displayed later in this list.',
	'about_visit_sold'		=> 'About purchase rate help document ',
	
	'js_lang' => array(
		'start_time_required'	=> 'The start time of the query cannot be empty!',
		'end_time_required'		=> 'The end time of the query cannot be empty!',
		'time_exceed'			=> 'The start time of the query cannot exceed the end time!',
		'time_required'			=> 'Query time cannot be empty!',
		'no_stats_data' 		=>	'No statistical data',
		'unconfirmed_order'		=> 'Unconfirmed order',
		'confirmed_order'		=> 'Confirmed order',
		'succeed_order'			=> 'Completed order',
		'invalid_order'			=> 'Invalid order',
		'number'				=> 'Number',
		'start_year_required'	=> 'The beginning of the query cannot be empty!',
		'end_year_required'		=> 'The end year of the query cannot be empty!',
		'order_number'			=> 'Order quantity',
		'sales_volume'			=> 'Sales volume',
		'show_num_min'			=> 'Display the number of values must be greater than zero!',
	)
);

//end