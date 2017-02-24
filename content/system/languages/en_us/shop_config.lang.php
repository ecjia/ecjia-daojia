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
	'cfg_name' => array(
		'basic'			=> 'Basic',
		'display'		=> 'Display',
		'shop_info'		=> 'Shop information',
		'shopping_flow'	=> 'Shopping flow',
		'smtp'			=> 'SMTP',
		'goods'			=> 'Product display',
		'lang'			=> 'System language',
		'shop_closed'	=> 'Close shop temporarily',
		'icp_file'		=> 'ICP certificate file of record',
		'watermark'		=> 'Watermark file',
		'watermark_place'	=> 'Watermark place',
		'use_storage'		=> 'Use storage management',
		'market_price_rate'	=> 'Market price rate',
		'rewrite'			=> 'URL rewrite',
		'integral_name'		=> 'Consume points name',
		'integral_scale'	=> 'Points convert rate',
		'integral_percent'	=> 'Points payout ratio',
		'enable_order_check'=> 'Whether the opening of the new orders to remind',
		'default_storage'	=> 'Default Stock',
		
		'date_format'		=> 'Date format',
		'time_format'		=> 'Time format',
		'currency_format'	=> 'Currency format',
		'thumb_width'		=> 'Thumbuail width',
		'thumb_height'		=> 'Thumbuail height',
		'image_width'		=> 'Product image width',
		'image_height'		=> 'Product image height',
		'best_number'		=> 'Competitive products quantity',
		'new_number'		=> 'New product quantity',
		'hot_number'		=> 'Active stock quantity',
		'promote_number'	=> 'Promotion product quantity',
		'group_goods_number'=> 'Associates quantity',
		'top_number'		=> 'Active stock ranking quantity',
		'history_number'	=> 'Browse history quantity',
		'comments_number'	=> 'Comment quantity',
		'bought_goods'		=> 'Relative product quantity',
		'article_number'	=> 'New article display quantity',
		'order_number'		=> 'Order display quantity',
		'shop_name'			=> 'Name',
		'shop_title'		=> 'Title',
		'shop_website'		=> 'Website',
		'shop_desc'			=> 'Description',
		'shop_keywords'		=> 'Keywords',
		'shop_country'		=> 'Country',
		'shop_province'		=> 'Province',
		'shop_city'			=> 'City',
		'shop_address'		=> 'Address',
		'licensed'			=> 'Display Licensed?',
		'qq'				=> 'Customer service QQ',
		'ww'				=> 'Taobao WangWang',
		'skype'				=> 'Skype',
		'ym'				=> 'Yahoo Messenger',
		'msn'				=> 'MSN Messenger',
			
		'service_email'		=> 'Customer service email',
		'service_phone'		=> 'Customer service phone',
		'can_invoice'		=> 'Invoice',
		'user_notice'		=> 'Member center notice',
		'shop_notice'		=> 'Notice stores',
		'shop_reg_closed'	=> 'Registration is closed',
		'send_mail_on'		=> 'Whether or not to open automatically send e-mail',
		'auto_generate_gallery'	=> 'Merchandise is automatically upload album chart',
		'retain_original_img'	=> 'Upload goods whether to retain image',
		'member_email_validate'	=> 'E-mail to verify whether or not to open membership',
		'send_verify_email'		=> 'Send registration verification email automatically',
		'message_board'			=> 'Whether the opening of the message board function',
		'message_check'			=> 'Users need to examine whether the message',
		//'use_package'=> 'Whether use packing',
		//'use_card'=> 'Whether use card',
		
		'use_integral'	=> 'Use points',
		'use_bonus'		=> 'Use bonus',
		'use_surplus'	=> 'Use balance',
		'use_how_oos'	=> 'Use booking process',
		'send_confirm_email'	=> 'When confirm order',
		'order_pay_note'		=> 'When config order as "paid"',
		'order_unpay_note'		=> 'When config order as "unpaid"',
		'order_ship_note'		=> 'When config as "shipping"',
		'order_unship_note'		=> 'When config order as "not shipping"',
		'when_dec_storage'		=> 'When decrease storage',
		'send_ship_email'		=> 'When shipping',
		'order_receive_note'	=> 'When config order as "receive"',
		'order_cancel_note'		=> 'When cancel order',
		'send_cancel_email'		=> 'When cancel order',
		'order_return_note'		=> 'When returned purchase',
		'order_invalid_note'	=> 'When config order as invalid',
		'send_invalid_email'	=> 'When config order as invalid',
		'sn_prefix'				=> 'Product\'s NO. prefixion',
		'close_comment'			=> 'Close shop reason',
		'watermark_alpha'		=> 'Watermark transparency',
		'icp_number'			=> 'ICP certificate or ICP certificate number of record',
		'invoice_content'		=> 'Invoice contents',
		'invoice_type'			=> 'Invoice types and rates',
		'stock_dec_time'		=> 'Stock minus the time',
		'comment_check'			=> 'Check user comment',
		'comment_factor'		=> 'Comments merchandise conditions',
		'no_picture'			=> 'Default image of product',
		'stats_code'			=> 'Statistics coding',
		'cache_time'			=> 'Cache time(second)',
		'page_size'				=> 'Category page list quantity',
		'article_page_size'		=> 'Article category page list quantity',
		'page_style'			=> 'Page Style',
		'sort_order_type'		=> 'Category page default sort type',
		'sort_order_method'		=> 'Category page default sort method',
		'show_order_type'		=> 'Category page default show type',
		'goods_name_length'		=> 'Product name length',
		'price_format'			=> 'Product price display regulation',
		'register_points'		=> 'Register points',
		'shop_logo'				=> 'Shop Logo',
		'enable_gzip'			=> 'Enable Gzip mode',
		'anonymous_buy'			=> 'Allow to shop without login',
		'min_goods_amount'		=> 'The smallest to the amount of',
		'one_step_buy'			=> 'Whether the step to',
		'show_goodssn'			=> 'NO.',
		'show_brand'			=> 'Brand',
		'show_goodsweight'		=> 'Weight',
		'show_goodsnumber'		=> 'Stock',
		'show_addtime'			=> 'Addtion time',
		'show_marketprice'		=> 'Show market price?',
		'goodsattr_style'		=> 'Attribute',
		'test_mail_address'		=> 'Email',
		'send'					=> 'Test',
		'send_service_email'	=> 'Send email to shop owner when a new order generate.',
		'show_goods_in_cart'	=> 'Display Type In Cart',
		'show_attr_in_cart'		=> 'Shows attributes of goods?',
	
		'email_content'			=> 'How are you! Tupload_size_limithis is the test mail of an examination mail server setting. Receive this mail, and your mail server config exactitude! You can carry on other mails to send out of operate!',
		'sms'					=> 'SMS',
		'sms_shop_mobile'		=> 'Shop mobile',
		'sms_order_placed'		=> 'Send message to shop when customer order.',
		'sms_order_payed'		=> 'Sent message to shop when customer payment.',
		'sms_order_shipped'		=> 'Send message to customer when shipping.',
		'attr_related_number'	=> 'Product quantity of relational attribute',
		'top10_time'			=> 'Ranking time',
		'goods_gallery_number'	=> 'Details page gallery image quantity',
		'article_title_length'	=> 'Article title length',
		'cron_method'			=> 'Whether it plans to open a command line call mission',
			
		'upload_size_limit'		=> 'From the size of attachment',
		'timezone'				=> 'The default time zone',
		'search_keywords'		=> 'Search Keywords',
		'cart_confirm'			=> 'Cart Confirm Prompt',
		'bgcolor'				=> 'Thumbnail background color',
		'name_of_region_1'		=> 'The name of a regional distribution',
		'name_of_region_2'		=> '2 Distribution of regional Name',
		'name_of_region_3'		=> 'Name three regional distribution',
		'name_of_region_4'		=> '4 Distribution of regional Name',
		'related_goods_number'	=> 'Associated merchandise display quantity',
		'visit_stats'			=> 'Visit stats',
		'help_open'				=> 'Open the user help',
		
		//与底部语言合并
		'mail_service'	=> 'E-mail Service',
		'smtp_host'		=> 'SMTP server',
		'smtp_port'		=> 'SMTP port',
		'smtp_user'		=> 'Email send account number',
		'smtp_pass'		=> 'Account number password',
		'smtp_mail'		=> 'Email reply address',
		'mail_charset'	=> 'Email charset',
		'smtp_ssl'		=> 'Mail servers require encrypted connections(SSL)',
			
		'recommend_order'	=> 'Recommended products sort',
		'wap'			=> 'WAP Config',
		'wap_config'	=> 'Use WAP',
		'wap_logo'		=> 'Upload WAP LOGO',
	),	
		
	'test_mail_title'	=> 'Test email',
		
	'cfg_desc' => array(
		'smtp'				=> 'Config SMTP basic parameter',
		'market_price_rate'	=> 'While you enter product price, the system will calculate market price by proportion automatically.',
		'rewrite'			=> 'The URL rewrite is a technique for optimize search engine, can become dynamic address to static HTML file. Need the Apache support.',
		'integral_name'		=> 'You can rename consume points. For example: Burn currency.',
		'integral_scale'	=> 'How much cash equal to 100 points.',
		'integral_percent'	=> 'How many points can be used every 100 yuan.',
		'comments_number'	=> 'Display customer reviews quantity at product details page.',
		'shop_title'		=> 'The shop title will be showed at the headline column of browser.',
		'smtp_host'			=> 'SMTP address. If the computer can send out mails then set as \'localhost\'.',
		'smtp_user'			=> 'Send out attestation number for mails, it is blank while have no the number.',
		'bought_goods'		=> 'How many records are displayed, that customers who bought this item also bought products?',
		'currency_format'	=> 'Display product price format, the %s will be replaced corresponding price figure.',
		'image_height'		=> 'If your server support GD, the system will auto appointed picture size when you upload the picture.',
		'watermark'			=> 'Gif format, watermark documents should be support for the transparency settings.',
		'watermark_alpha'	=> 'Diaphaneity of watermark, choice value range is 0 to 100. It is opacity when the value is 100.',
		'invoice_content'	=> 'Customer can choose contents in invoice. For example:Office equipment. Every line represent an options.',
		'stats_code'		=> 'You can add the code that other interviews statistics service company to provide to each page.',
		'cache_time'		=> 'Foreground page buffer survival time, take second as unit.',
		'qq'				=> 'If you have several QQ numbers, please divided each number by DBC case comma(, ). ',
		'msn'				=> 'If you have several MSN numbers, please divided each number by DBC case comma(, ). ',
		'ym'				=> 'If you have several of Yahoo Messenger numbers, please divided each number by DBC case comma(, ). ',
		'ww'				=> 'If you have several TaoBao WangWang numbers, please divided each number by DBC case comma(, ). ',
		'shop_logo'			=> 'Please set the picture name as logo.gif before upload.',
		'enable_gzip'		=> 'Size of send page may be compressed if the Gzip mode is enabled , speed a web page to shipping. Need php support Gzip. If yoou have already used Apache etc. to carry on the Gzip compression to the page, please forbid that function.',
		'skype'				=> 'If you have several Skype number, please divided each number by DBC case comma(, ).    Hint: You need enable display function in your Skype privacy setting.',
		'attr_related_number'	=> 'How many relational products are displaied in the product details page.',
		'user_notice'			=> 'The information will be showed in welcome page of member center.',
		'comment_factor'		=> 'Select higher comments condition can effectively reduce the garbage generated comment. Orders after the completion of only the user that the user purchase behavior has',
		'min_goods_amount'		=> 'To achieve this amount in order to submit orders.',
		'search_keywords'		=> 'Keywords displayed on index, please divided each keyword by comma(, ).',
		'shop_notice'			=> 'Above will appear in the home store announcement, attention to controlling the content of the length of notice should not exceed the size of bulletin display area.',
		'bgcolor'				=> 'Color Please fill in the format # FFFFFF',
		'use_how_oos'			=> 'Out of stock when the deal with the future use order confirmation page allows the user to choose when out-of-stock approach.',
		'cart_confirm'			=> 'Allows users click on the "Add to Cart" after the prompt and the subsequent action.',
		'send_service_email'	=> 'If service email is empty,the option is invalid.',
		'send_mail_on'			=> 'Enable this option, it will automatically send mail in the maillist',
		'sms_shop_mobile'		=> 'Please register your mobile SMS or mobile phone number and then',
		'send_verify_email'		=> 'If you want to use "Send registration verification email automatically","E-mail to verify whether or not to open membership" must be open.',
			
		//与底部语言合并
		'wap_logo'			=> 'The LOGO better to be png type for all kinds of phones',
		'mail_service'		=> 'If you choose the server using the built-in Mail Services, you do not need to fill the following form.',
		'wap_config'		=> 'This feature only supports Simplified Chinese and only in China Effective',
		'recommend_order'	=> 'Recommended sort is adequate for a small number of goods，Random show s adequate for a large number of goods',
	),	
	'cfg_range' => array(
		'cart_confirm' => array(
			1	=> 'Prompts the user, click "OK" into the Shopping Cart',
			2	=> 'Prompts the user, click "Cancel" into the Shopping Cart',
			3	=> 'Go directly to Cart',
			4	=> 'Do not prompt and remain in the current page',
		),
		'shop_closed' => array(
			'0'	=> 'No',
			'1'	=> 'yes',
		),
		'licensed' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'send_mail_on' => array(
			'on' => 'Open',
			'off'=> 'Off',
		),
		'member_email_validate' => array(
			'1'	=> 'Open',
			'0'	=> 'Off',
		),
		'send_verify_email' => array(
			'1'	=> 'Open',
			'0'	=> 'Off',
		),
		'message_board' => array(
			'1'	=> 'Open',
			'0'	=> 'Off',
		),
		'auto_generate_gallery' => array(
			'1'	=> 'Yes',
			'0'	=> 'No',
		),
		'retain_original_img' => array(
			'1'	=> 'Yes',
			'0'	=> 'No',
		),
		'watermark_place' => array(
			'0'	=> 'No',
			'1'	=> 'Top-left',
			'2'	=> 'Top-right',
			'3'	=> 'Center',
			'4'	=> 'Bottom-left',
			'5'	=> 'Bottom-right',
		),
		'use_storage' => array(
			'1'	=> 'Yes',
			'0'	=> 'No',
		),
		'rewrite' => array(
			'0'	=> 'Disable',
			'1'	=> 'Simple rewrite',
			'2'	=> 'Complex rewrite',
		),
		'can_invoice' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'top10_time' => array(
			'0'	=> 'All',
			'1'	=> 'A year',
			'2'	=> 'Six months',
			'3'	=> 'Three months',
			'4'	=> 'One month',
		),
		'use_integral' => array(
			'1'	=> 'Enable',
			'0'	=> 'Disable',
		),
		'use_bonus' => array(
			'1'	=> 'Enable',
			'0'	=> 'Disable',
		),
		'use_surplus' => array(
			'1'	=> 'Enable',
			'0'	=> 'Disable',
		),
		'use_how_oos' => array(
			'1'	=> 'Enable',
			'0'	=> 'Disable',
		),
		'send_confirm_email' => array(
			'1'	=> 'Send mail',
			'0'	=> 'Not send mail',
		),
		'order_pay_note' => array(
			'1'	=> 'Must enter remarks',
			'0'	=> 'Needn\'t enter remarks',
		),
		'order_unpay_note' => array(
			'1'	=> 'Must enter remarks',
			'0'	=> 'Needn\'t enter remarks',
		),
		'order_ship_note' => array(
			'1'	=> 'Must enter remarks',
			'0'	=> 'Needn\'t enter remarks',
		),
		'order_unship_note' => array(
			'1'	=> 'Must enter remarks',
			'0'	=> 'Needn\'t enter remarks',
		),
		'order_receive_note' => array(
			'1'	=> 'Must enter remarks',
			'0'	=> 'Needn\'t enter remarks',
		),
		'order_cancel_note' => array(
			'1'	=> 'Must enter remarks',
			'0'	=> 'Needn\'t enter remarks',
		),
		'order_return_note' => array(
			'1'	=> 'Must enter remarks',
			'0'	=> 'Needn\'t enter remarks',
		),
		'order_invalid_note' => array(
			'1'	=> 'Must enter remarks',
			'0'	=> 'Needn\'t enter remarks',
		),
		'when_dec_storage' => array(
			'0'	=> 'When order',
			'1'	=> 'When shipping',
		),
		'send_ship_email' => array(
			'1'	=> 'Send email',
			'0'	=> 'Not send email',
		),
		'send_cancel_email' => array(
			'1'	=> 'Send email',
			'0'	=> 'Not send email',
		),
		'send_invalid_email' => array(
			'1'	=> 'Send email',
			'0'	=> 'Not send email',
		),
		'mail_charset' => array(
			'UTF8'	=> 'The internationalization code(utf8)',
			'GB2312'=> 'Simplified Chinese character',
			'BIG5'	=> 'Traditional Chinese character',
		),
		'comment_check' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'message_check' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'comment_factor' => array(
			'0'	=> 'All users',
			'1'	=> 'Logged-on user only',
			'2'	=> 'Has more than once a user purchase behavior',
			'3'	=> 'Only have the merchandise customers buy',
		),
		'enable_gzip' => array(
			'1'	=> 'Enable',
			'0'	=> 'Disable',
		),
		'price_format' => array(
			'0'	=> 'Don\'t operate.',
			'1'	=> 'If the tail count isn\'t 0, reserve it.',
			'2'	=> 'Don\'t round off, reserve 1 bit decimal.',
			'3'	=> 'Don\'t round off, don\'t reserve decimal.',
			'4'	=> 'Round off first, reserve 1 bit decimal.',
			'5'	=> 'Round off first, don\'t reserve decimal.',
		),
		'sort_order_type' => array(
			'0'	=> 'By addtion time',
			'1'	=> 'By product price',
			'2'	=> 'By lastest update time',
		),
		'sort_order_method' => array(
			'0'=> 'Descending sort',
			'1'=> 'Ascending sort',
		),
		'show_order_type' => array(
			0	=> 'List shows',
			1	=> 'Table shows',
			2	=> 'Text shows',
		),
		'help_open' => array(
			0	=> 'Off',
			1	=> 'Open',
		),
		'page_style' => array(
			0	=> 'Classical',
			1	=> 'Popular',
		),
		'anonymous_buy' => array(
			'0'	=> 'Disallow',
			'1'	=> 'Allow',
		),
		'one_step_buy' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'show_goodssn' => array(
			'1'	=> 'Display',
			'0'	=> 'Conceal',
		),
		'show_brand' => array(
			'1'	=> 'Display',
			'0'	=> 'Conceal',
		),
		'show_goodsweight' => array(
			'1'	=> 'Display',
			'0'	=> 'Conceal',
		),
		'show_goodsnumber' => array(
			'1'	=> 'Display',
			'0'	=> 'Conceal',
		),
		'show_addtime' => array(
			'1'	=> 'Display',
			'0'	=> 'Conceal',
		),
		'goodsattr_style' => array(
			'1'	=> 'Radio button',
			'0'	=> 'Drop-down list',
		),
		'show_marketprice' => array(
			'1'	=> 'Display',
			'0'	=> 'Conceal',
		),
		'sms_order_placed' => array(
			'1'	=> 'Send sms',
			'0'	=> 'Not send sms',
		),
		'sms_order_payed' => array(
			'1'	=> 'Send sms',
			'0'	=> 'Not send sms',
		),
		'sms_order_shipped' => array(
			'1'	=> 'Send sms',
			'0'	=> 'Not send sms',
		),
		'cron_method' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'enable_order_check' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'stock_dec_time' => array(
			'0'	=> 'Shipped',
			'1'	=> 'Under orders',
		),
		'send_service_email' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'show_goods_in_cart' => array(
			'1'	=> 'Only Text',
			'2'	=> 'Only Images',
			'3'	=> 'Text and Images',
		),
		'show_attr_in_cart' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'shop_reg_closed' => array(
			'0'	=> 'No',
			'1'	=> 'Yes',
		),
		'timezone' => array(
			'-12'	=> '(GMT -12:00) Eniwetok, Kwajalein',
			'-11'	=> '(GMT -11:00) Midway Island, Samoa',
			'-10'	=> '(GMT -10:00) Hawaii',
			'-9'	=> '(GMT -09:00) Alaska',
			'-8'	=> '(GMT -08:00) Pacific Time (US &amp, Canada), Tijuana',
			'-7'	=> '(GMT -07:00) Mountain Time (US &amp, Canada), Arizona',
			'-6'	=> '(GMT -06:00) Central Time (US &amp, Canada), Mexico City',
			'-5'	=> '(GMT -05:00) Eastern Time (US &amp, Canada), Bogota, Lima, Quito',
			'-4'	=> '(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz',
			'-3.5'	=> '(GMT -03:30) Newfoundland',
			'-3'	=> '(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is',
			'-2'	=> '(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena',
			'-1'	=> '(GMT -01:00) Azores, Cape Verde Islands',
			'0'		=> '(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia',
			'1'		=> '(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome',
			'2'		=> '(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa',
			'3'		=> '(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi',
			'3.5'	=> '(GMT +03:30) Tehran',
			'4'		=> '(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi',
			'4.5'	=> '(GMT +04:30) Kabul',
			'5'		=> '(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent',
			'5.5'	=> '(GMT +05:30) Bombay, Calcutta, Madras, New Delhi',
			'5.75'	=> '(GMT +05:45) Katmandu',
			'6'		=> '(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk',
			'6.5'	=> '(GMT +06:30) Rangoon',
			'7'		=> '(GMT +07:00) Bangkok, Hanoi, Jakarta',
			'8'		=> '(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei',
			'9'		=> '(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk',
			'9.5'	=> '(GMT +09:30) Adelaide, Darwin',
			'10'	=> '(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok',
			'11'	=> '(GMT +11:00) Magadan, New Caledonia, Solomon Islands',
			'12'	=> '(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island',
		),
		'upload_size_limit' => array(
			'-1'	=> 'Default',
			'0'		=> '0KB',
			'64'	=> '64KB',
			'128'	=> '128KB',
			'256'	=> '256KB',
			'512'	=> '512KB',
			'1024'	=> '1MB',
			'2048'	=> '2MB',
			'4096'	=> '4MB',
		),
		'visit_stats' => array(
			'on'	=> 'Open',
			'off'	=> 'Off',
		),
		//与底部语言合并（数组）
		'mail_service' => array(
			0	=> 'Using the server built-in Mail Services',
			1	=> 'Using other SMTP Service',
		),
		'wap_config' => array(
			0	=> 'Disable',
			1	=> 'Enable',
		),
		'smtp_ssl' => array(
			0	=> 'No',
			1	=> 'Yes',
		),
		'recommend_order' => array(
			0	=> 'Recommended sort',
			1	=> 'Random show',
		),
			
	),
		
	'rewrite_confirm_apache'	=>"The function of URL rewrite request your Web Server to must be Apache, and enable rewrite module. \\nPlease confirm the htaccess.txt file has already named .htaccess.",
	'rewrite_confirm_iis'		=>"The function of URL rewrite request your Web Server to must be installed IIS, and enable ISAPI Rewrite module. \\nIf you are using a commercial version of ISAPI Rewrite, please confirm whether you have httpd.txt rename the file to httpd.ini.If you are using a free version of ISAPI Rewrite, please confirm whether you have httpd.txt and copy the contents of the document to the ISAPI Rewrite installation directory httpd.ini.",
	'gzip_confirm'				=>"The GZip function needs your server support zlib expand database. \\nIf your found junk after open the Gzip page, may be your server has already openned Gzip, you needn\'t open again in the ECSHOP.",
	'retain_original_confirm'	=> 'If you do not retain the image of goods, in the "image batch processing"\\n will not be re-generated image of the product does not contain a picture.\\n Please use this feature carefully!',
	'msg_invalid_file'			=> 'You upload an illegal file type. That file name is: %s.',
	'msg_upload_failed'			=> 'Upload a file the %s failure, please check the %s directory can be wrote or not.',
	'smtp_ssl_confirm'			=> 'This feature requires that you must support the php module OpenSSL, if you want to use this feature, please contact your provider to confirm the space to support the module',
		
	/* 邮件设置语言项 */
	'mail_settings_note'=> 'If your server to support the Mail function (specific information please consult your space provider). We recommend that you use the Mail function system. <br /> When your server does not support Mail function when you can choose to use SMTP as a mail server.',
	
	'save_success'=> 'Save shop setting successfully.',
	'mail_save_success'=> 'Save mail setting successfully.',
	'sendemail_success'=> 'Congratulations! Test mail has sent succeefully.',
	'sendemail_false'=> 'The mail sends out failure, please check your mail server setting!',
	
	'js_languages' => array(
		'smtp_host_empty'	=> 'You didn\'t fill in a mail server address!',
		'smtp_port_empty'	=> 'You didn\'t fill in a server port!',
		'reply_email_empty'	=> 'You didn\'t fill in a mail reply address!',
		'test_email_empty'	=> 'You didn\'t fill in an address of send out the test mail!',
		'email_address_same'=> 'The mail reply address must be different with sending out an address of test the mail!',
	),	
	
	'invoice_type'=> 'Type',
	'invoice_rate'=> 'Rate(%)',
	'back_shop_config'=> 'Back to shop config',
	'back_mail_settings'=> 'Return e-mail server settings',
	'mail_settings'=> 'E-mail server settings',
// 	'sms_url'=> '<a href="'.$url.'" target="_blank">Click here to register mobile phone short message service</a>',
);
