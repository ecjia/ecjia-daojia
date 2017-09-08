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
 * 管理中心商店设置语言文件
 */

return array(
	'cfg_name' => array(
		'basic' 			=> '基本设置',
		'display' 			=> '显示设置',
		'shop_info' 		=> '网店信息',
		'shopping_flow' 	=> '购物流程',
		'smtp' 				=> '邮件服务器设置',
		'goods' 			=> '商品显示设置',
		'lang' 				=> '系统语言',
		'shop_closed' 		=> '暂时关闭网站',
		'icp_file' 			=> 'ICP 备案证书文件',
		'watermark' 		=> '水印文件',
		'watermark_place' 	=> '水印位置',
		'use_storage' 		=> '是否启用库存管理',
		'market_price_rate' => '市场价格比例',
		'rewrite' 			=> 'URL重写',
		'integral_name' 	=> '消费积分名称',
		'integral_scale' 	=> '积分换算比例',
		'integral_percent' 	=> '积分支付比例',
		'enable_order_check' => '是否开启新订单提醒',
		'default_storage' 	=> '默认库存',
		'date_format' 		=> '日期格式',
		'time_format' 		=> '时间格式',
		'currency_format' 	=> '货币格式',
		'thumb_width' 		=> '缩略图宽度',
		'thumb_height' 		=> '缩略图高度',
		'image_width' 		=> '商品图片宽度',
		'image_height' 		=> '商品图片高度',
		'best_number' 		=> '精品推荐数量',
		'new_number' 		=> '新品推荐数量',
		'hot_number' 		=> '热销商品数量',
		'promote_number' 	=> '特价商品的数量',
		'group_goods_number' => '团购商品的数量',
		'top_number' 		=> '销量排行数量',
		'history_number' 	=> '浏览历史数量',
		'comments_number' 	=> '评论数量',
		'bought_goods' 		=> '相关商品数量',
		'article_number' 	=> '最新文章显示数量',
		'order_number' 		=> '订单显示数量',
		'shop_name' 		=> '商店名称',
		'shop_title' 		=> '商店标题',
		'shop_website' 		=> '商店网址',
		'shop_desc' 		=> '商店描述',
		'shop_keywords' 	=> '商店关键字',
		'shop_country' 		=> '所在国家',
		'shop_province' 	=> '所在省份',
		'shop_city' 		=> '所在城市',
		'shop_address' 		=> '详细地址',
		'licensed' 			=> '是否显示 Licensed',
		'qq' 				=> '客服QQ号码',
		'ww' 				=> '淘宝旺旺',
		'skype' 			=> 'Skype',
		'ym' 				=> '微信号码',
		'msn' 				=> '微博号码',
		'service_email' 	=> '客服邮件地址',
		'service_phone' 	=> '客服电话',
		'can_invoice' 		=> '能否开发票',
		'user_notice' 		=> '用户中心公告',
		'shop_notice' 		=> '商店公告',
		'shop_reg_closed'	=> '是否关闭注册',
		'send_mail_on' 		=> '是否开启自动发送邮件',
		'auto_generate_gallery' => '上传商品是否自动生成相册图',
		'retain_original_img' 	=> '上传商品时是否保留原图',
		'member_email_validate' => '是否开启会员邮件验证',
		'send_verify_email' 	=> '用户注册时自动发送验证邮件',
		'message_board' 		=> '是否启用留言板功能',
		'message_check' 		=> '用户留言是否需要审核',
		'review_goods'          => '审核商家商品',
		'store_identity_certification' => '商家强制认证',
		//'use_package' 		=> '是否使用包装',
		//'use_card' 			=> '是否使用贺卡',
		'use_integral' 			=> '是否使用积分',
		'use_bonus' 			=> '是否使用红包',
		'use_surplus' 			=> '是否使用余额',
		'use_how_oos' 			=> '是否使用缺货处理',
		'send_confirm_email' 	=> '确认订单时',
		'order_pay_note'		=> '设置订单为“已付款”时',
		'order_unpay_note' 		=> '设置订单为“未付款”时',
		'order_ship_note' 		=> '设置订单为“已发货”时',
		'order_unship_note' 	=> '设置订单为“未发货”时',
		'when_dec_storage' 		=> '什么时候减少库存',
		'send_ship_email' 		=> '发货时',
		'order_receive_note' 	=> '设置订单为“收货确认”时',
		'order_cancel_note' 	=> '取消订单时',
		'send_cancel_email' 	=> '取消订单时',
		'order_return_note' 	=> '退货时',
		'order_invalid_note' 	=> '把订单设为无效时',
		'send_invalid_email' 	=> '把订单设为无效时',
		'sn_prefix' 			=> '商品货号前缀',
		'close_comment' 		=> '关闭网店的原因',
		'watermark_alpha' 		=> '水印透明度',
		'icp_number' 			=> 'ICP证书或ICP备案证书号',
		'invoice_content' 		=> '发票内容',
		'invoice_type' 			=> '发票类型及税率',
		'stock_dec_time' 		=> '减库存的时机',
		'comment_check' 		=> '用户评论是否需要审核',
		'comment_factor' 		=> '商品评论的条件',
		'no_picture' 			=> '商品的默认图片',
		'stats_code' 			=> '统计代码',
		'cache_time'			=> '缓存存活时间（秒）',
		'page_size' 			=> '商品分类页列表的数量',
		'article_page_size' 	=> '文章分类页列表的数量',
		'page_style' 			=> '分页样式',
		'sort_order_type' 		=> '商品分类页默认排序类型',
		'sort_order_method' 	=> '商品分类页默认排序方式',
		'show_order_type' 		=> '商品分类页默认显示方式',
		'goods_name_length' 	=> '商品名称的长度',
		'price_format' 			=> '商品价格显示规则',
		'register_points' 		=> '会员注册赠送积分',
		'shop_logo' 			=> '商店 Logo',
		'enable_gzip'     		=> '是否启用Gzip模式',
		'anonymous_buy' 		=> '是否允许未登录用户购物',
		'min_goods_amount' 		=> '最小购物金额',
		'one_step_buy' 			=> '是否一步购物',
		'show_goodssn' 			=> '是否显示货号',
		'show_brand' 			=> '是否显示品牌',
		'show_goodsweight'		=> '是否显示重量',
		'show_goodsnumber'		=> '是否显示库存',
		'show_addtime'			=> '是否显示上架时间',
		'show_marketprice' 		=> '是否显示市场价格',
		'goodsattr_style' 		=> '商品属性显示样式',
		'test_mail_address'		=> '邮件地址',
		'send' 					=> '发送测试邮件',
		'send_service_email' 	=> '下订单时是否给客服发邮件',
		'show_goods_in_cart' 	=> '购物车里显示商品方式',
		'show_attr_in_cart' 	=> '购物车里是否显示商品属性',
		'email_content'  		=> '您好！这是一封检测邮件服务器设置的测试邮件。收到此邮件，意味着您的邮件服务器设置正确！您可以进行其它邮件发送的操作了！',
		'sms' 					=> '短信通知',
		'sms_shop_mobile' 		=> '商家的手机号码',
		'sms_order_placed' 		=> '客户下订单时是否给商家发短信',
		'sms_order_payed' 		=> '客户付款时是否给商家发短信',
		'sms_order_shipped' 	=> '商家发货时是否给客户发短信',
		'attr_related_number' 	=> '属性关联的商品数量',
		'top10_time' 			=> '排行统计的时间',
		'goods_gallery_number' 	=> '商品详情页相册图片数量',
		'article_title_length' 	=> '文章标题的长度',
		'cron_method' 			=> '是否开启命令行调用计划任务',
		'timezone' 				=> '默认时区',
		'upload_size_limit' 	=> '附件上传大小',
		'search_keywords' 		=> '首页搜索的关键字',
		'cart_confirm' 			=> '购物车确定提示',
		'bgcolor' 				=> '缩略图背景色',
		'name_of_region_1' 		=> '一级配送区域名称',
		'name_of_region_2' 		=> '二级配送区域名称',
		'name_of_region_3' 		=> '三级配送区域名称',
		'name_of_region_4' 		=> '四级配送区域名称',
		'related_goods_number' 	=> '关联商品显示数量',
		'visit_stats' 			=> '站点访问统计',
		'help_open' 			=> '用户帮助是否打开',
		
		'company_name'          => '公司名称',
		'shop_weibo_url'        => '微博地址',
		'shop_wechat_qrcode'    => '微信二维码',
		
		//与底部语言合并
		'mail_service'	=> '邮件服务',
		'smtp_host' 	=> '发送邮件服务器地址(SMTP)',
		'smtp_port' 	=> '服务器端口',
		'smtp_user' 	=> '邮件发送帐号',
		'smtp_pass' 	=> '帐号密码',
		'smtp_mail' 	=> '邮件回复地址',
		'mail_charset' 	=> '邮件编码',
		'smtp_ssl' 		=> '邮件服务器是否要求加密连接(SSL)',
		
		'recommend_order' => '推荐商品排序',
		'wap' 			=> 'WAP设置',
		'wap_config' 	=> '是否使用WAP功能',
		'wap_logo' 		=> 'WAP LOGO上传',
	),
	
	
	'test_mail_title' => '测试邮件',
	
	'cfg_desc' =>array(
		'smtp' 				=> '设置邮件服务器基本参数',
		'market_price_rate' => '输入商品售价时将自动根据该比例计算市场价格',
		'rewrite' 			=> 'URL重写是一种搜索引擎优化技术，可以将动态的地址模拟成静态的HTML文件。需要Apache的支持。',
		'integral_name' 	=> '您可以将消费积分重新命名。例如：烧币',
		'integral_scale' 	=> '每100积分可抵多少元现金',
		'integral_percent' 	=> '每100元商品最多可以使用多少元积分',
		'comments_number' 	=> '显示在商品详情页的用户评论数量。',
		'shop_title' 		=> '商店的标题将显示在浏览器的标题栏',
		'smtp_host' 		=> '邮件服务器主机地址。如果本机可以发送邮件则设置为localhost',
		'smtp_user' 		=> '发送邮件所需的认证帐号，如果没有就为空着',
		'bought_goods' 		=> '显示多少个购买此商品的人还买过哪些商品',
		'currency_format' 	=> '显示商品价格的格式，%s将被替换为相应的价格数字。',
		'image_height' 		=> '如果您的服务器支持GD，在您上传商品图片的时候将自动将图片缩小到指定的尺寸。',
		'watermark' 		=> '水印文件须为gif格式才可支持透明度设置。',
		'watermark_alpha' 	=> '水印的透明度，可选值为0-100。当设置为100时则为不透明。',
		'invoice_content' 	=> '客户要求开发票时可以选择的内容。例如：办公用品。每一行代表一个选项。',
		'stats_code' 		=> '您可以将其他访问统计服务商提供的代码添加到每一个页面。',
		'cache_time' 		=> '前台页面缓存的存活时间，以秒为单位。',
		'qq' 				=> '如果您有多个客服的QQ号码，请在每个号码之间使用半角逗号（,）分隔。',
		'msn' 				=> '如果您有多个客服的微博号码，请在每个号码之间使用半角逗号（,）分隔。',
		'ym' 				=> '如果您有多个客服的微信码，请在每个号码之间使用半角逗号（,）分隔。',
		'ww' 				=> '如果您有多个客服的淘宝旺旺号码，请在每个号码之间使用半角逗号（,）分隔。',
		'shop_logo' 		=> '请在上传前将图片的文件名命名为logo.gif',
		'enable_gzip' 		=> '启用Gzip模式可压缩发送页面大小，加快网页传输。需要php支持Gzip。如果已经用Apache等对页面进行Gzip压缩，请禁止该功能。',
		'skype' 			=> '如果您有多个客服的Skype号码，请在每个号码之间使用半角逗号（,）分隔。提示：你需要在你的Skype隐私设置中启用状态显示功能',
		'attr_related_number'	=> '在商品详情页面显示多少个属性关联的商品。',
		'user_notice' 			=> '该信息将在用户中心欢迎页面显示',
		'comment_factor' 		=> '选取较高的评论条件可以有效的减少垃圾评论的产生。只有用户订单完成后才认为该用户有购买行为',
		'min_goods_amount' 		=> '达到此购物金额，才能提交订单。',
		'search_keywords' 		=> '首页显示的搜索关键字,请用半角逗号(,)分隔多个关键字',
		'shop_notice' 			=> '以上内容将显示在首页商店公告中,注意控制公告内容长度不要超过公告显示区域大小。',
		'bgcolor' 				=> '颜色请以#FFFFFF格式填写',
		'cart_confirm' 			=> '允许您设置用户点击“加入购物车”后是否提示以及随后的动作。',
		'use_how_oos' 			=> '使用缺货处理时前台订单确认页面允许用户选择缺货时处理方法。',
		'send_service_email' 	=> '网店信息中的客服邮件地址不为空时，该选项有效。',
		'send_mail_on' 			=> '启用该选项登录后台时，会自动发送邮件队列中尚未发送的邮件',
		'sms_shop_mobile' 		=> '请先注册手机短信服务再填写手机号码',
		'send_verify_email' 	=> '“是否开启会员邮件验证”设为开启时才可使用此功能',
		'review_goods'          => '设置是否需要审核商家添加的商品，如果开启则所有商家添加的商品都需要审核之后才能显示',
		'store_identity_certification' => '设置是否需要认证商家资质，如果开启则认证通过后的商家才能开店和显示',
		
		//与底部语言合并
		'wap_config'     	=> '此功能只支持简体中文且只在中国大陆区有效',
		'recommend_order'	=> '推荐排序适合少量推荐，随机显示大量推荐',
		'wap_logo'			=> '为了更好地兼容各种手机类型，LOGO 最好为png图片',//追加
		'mail_service'		=> '如果您选择了采用服务器内置的 Mail 服务，您不需要填写下面的内容。',
		
	),
	
	'cfg_range' =>array(
		'cart_confirm' => array(
			1 => '提示用户，点击“确定”进购物车',
			2 => '提示用户，点击“取消”进购物车',
			3 => '直接进入购物车',
			4 => '不提示并停留在当前页面',
		),
		'shop_closed' => array(
			'0' => '否',
			'1' => '是',
		),
		'licensed' => array(
			'0' => '否',
			'1' => '是',
		),
		'send_mail_on' => array(
			'0' => '关闭',
			'1' => '开启',
		),
		'member_email_validate' => array(
			'0' => '关闭',
			'1' => '开启',
		),
		'send_verify_email' => array(
			'0' => '关闭',
			'1' => '开启',
		),
		'message_board' => array(
			'0' => '关闭',
			'1' => '开启',
		),
		'auto_generate_gallery' => array(
			'0' => '否',
			'1' => '是',
		),
		'retain_original_img' => array(
			'0' => '否',
			'1' => '是',
		),
		'watermark_place' => array(
			'0' => '无',
			'1' => '左上',
			'2' => '右上',
			'3' => '居中',
			'4' => '左下',
			'5' => '右下',
		),
		'use_storage' => array(
			'0' => '否',
			'1' => '是',
		),
		'rewrite' => array(
			'0' => '禁用',
			'1' => '简单重写',
			'2' => '复杂重写',
		),
		'can_invoice' => array(
			'0' => '不能',
			'1' => '能',
		),
		'top10_time' => array(
			'0' => '所有',
			'1' => '一年',
			'2' => '半年',
			'3' => '三个月',
			'4' => '一个月',
		),
		'use_integral' => array(
			'0' => '不使用',
			'1' => '使用',
		),
		'use_bonus' => array(
			'0' => '不使用',
			'1' => '使用',
		),
		'use_surplus' => array(
			'0' => '不使用',
			'1' => '使用',
		),
		'use_how_oos' => array(
			'0' => '不使用',
			'1' => '使用',
		),
		'send_confirm_email' => array(
			'0' => '不发送邮件',
			'1' => '发送邮件',
		),
		'order_pay_note' => array(
			'0' => '无需填写备注',
			'1' => '必须填写备注',
		),
		'order_unpay_note' => array(
			'0' => '无需填写备注',
			'1' => '必须填写备注',
		),
		'order_ship_note' => array(
			'0' => '无需填写备注',
			'1' => '必须填写备注',
		),
		'order_unship_note' => array(
			'0' => '无需填写备注',
			'1' => '必须填写备注',
		),
		'order_receive_note' => array(
			'0' => '无需填写备注',
			'1' => '必须填写备注',
		),
		'order_cancel_note' => array(
			'0' => '无需填写备注',
			'1' => '必须填写备注',
		),
		'order_return_note' => array(
			'0' => '无需填写备注',
			'1' => '必须填写备注',
		),
		'order_invalid_note' => array(
			'0' => '无需填写备注',
			'1' => '必须填写备注',
		),
		'when_dec_storage' => array(
			'0' => '下定单时',
			'1' => '发货时',
		),
		'send_ship_email' => array(
			'0' => '不发送邮件',
			'1' => '发送邮件',
		),
		'send_cancel_email' => array(
			'0' => '不发送邮件',
			'1' => '发送邮件',
		),
		'send_invalid_email' => array(
			'0' => '不发送邮件',
			'1' => '发送邮件',
		),
		'mail_charset' => array(
			'UTF8' => '国际化编码（utf8）',
			'GB2312' => '简体中文',
			'BIG5' => '繁体中文',
		),
		'comment_check' => array(
			'0' => '不需要',
			'1' => '需要',
		),
		'message_check' => array(
			'0' => '不需要',
			'1' => '需要',
		),
		'comment_factor' => array(
			'0' => '所有用户',
			'1' => '仅登录用户',
			'2' => '有过一次以上购买行为用户',
			'3' => '仅购买过该商品用户',
		),
		'enable_gzip' => array(
			'0' => '禁用',
			'1' => '启用',
		),
		'price_format' => array(
			'0' => '不处理',
			'1' => '保留不为 0 的尾数',
			'2' => '不四舍五入，保留一位小数',
			'3' => '不四舍五入，不保留小数',
			'4' => '先四舍五入，保留一位小数',
			'5' => '先四舍五入，不保留小数 ',
		),
		'sort_order_type' => array(
			'0' => '按上架时间',
			'1' => '按商品价格',
			'2' => '按最后更新时间',
		),
		'sort_order_method' => array(
			'0' => '降序排列',
			'1' => '升序排列',
		),
		'show_order_type' => array(
			0 => '列表显示',
			1 => '表格显示',
			2 => '文本显示',
		),
		'help_open' => array(
			0 => '关闭',
			1 => '打开',
		),
		'page_style' => array(
			0 => '默认经典',
			1 => '流行页码',
		),
		'anonymous_buy' => array(
			'0' => '不允许',
			'1' => '允许',
		),
		'one_step_buy' => array(
			'0' => '否',
			'1' => '是',
		),
		'show_goodssn' => array(
			'0' => '不显示',
			'1' => '显示',
		),
		'show_brand' => array(
			'0' => '不显示',
			'1' => '显示',
		),
		'show_goodsweight' => array(
			'0' => '不显示',
			'1' => '显示',
		),
		'show_goodsnumber' => array(
			'0' => '不显示',
			'1' => '显示',
		),
		'show_addtime' => array(
			'0' => '不显示',
			'1' => '显示',
		),
		'goodsattr_style' => array(
			'0' => '下拉列表',
			'1' => '单选按钮',
		),
		'show_marketprice' => array(
			'0' => '不显示',
			'1' => '显示',
		),
		'sms_order_placed' => array(
			'0' => '不发短信',
			'1' => '发短信',
		),
		'sms_order_payed' => array(
			'0' => '不发短信',
			'1' => '发短信',
		),
		'sms_order_shipped' => array(
			'0' => '不发短信',
			'1' => '发短信',
		),
		'cron_method' => array(
			'0' => '否',
			'1' => '是',
		),
		'enable_order_check' => array(
			'0' => '否',
			'1' => '是',
		),
		'stock_dec_time' => array(
			'0' => '发货时',
			'1' => '下订单时',
		),
		'send_service_email' => array(
			'0' => '否',
			'1' => '是',
		),
		'show_goods_in_cart' => array(
			'1' => '只显示文字',
			'2' => '只显示图片',
			'3' => '显示文字与图片',
		),
		'show_attr_in_cart' => array(
			'0' => '否',
			'1' => '是',
		),
		'shop_reg_closed' => array(
			'0' => '否',
			'1' => '是',
		),
		'timezone' => array(
			'-12' 	=> '(GMT -12:00) Eniwetok, Kwajalein',
			'-11' 	=> '(GMT -11:00) Midway Island, Samoa',
			'-10' 	=> '(GMT -10:00) Hawaii',
			'-9'	=> '(GMT -09:00) Alaska',
			'-8' 	=> '(GMT -08:00) Pacific Time (US &amp, Canada), Tijuana',
			'-7' 	=> '(GMT -07:00) Mountain Time (US &amp, Canada), Arizona',
			'-6' 	=> '(GMT -06:00) Central Time (US &amp, Canada), Mexico City',
			'-5' 	=> '(GMT -05:00) Eastern Time (US &amp, Canada), Bogota, Lima, Quito',
			'-4' 	=> '(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz',
			'-3.5' 	=> '(GMT -03:30) Newfoundland',
			'-3' 	=> '(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is',
			'-2' 	=> '(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena',
			'-1' 	=> '(GMT -01:00) Azores, Cape Verde Islands',
			'0' 	=> '(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia',
			'1' 	=> '(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome',
			'2' 	=> '(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa',
			'3' 	=> '(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi',
			'3.5' 	=> '(GMT +03:30) Tehran',
			'4' 	=> '(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi',
			'4.5' 	=> '(GMT +04:30) Kabul',
			'5' 	=> '(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent',
			'5.5' 	=> '(GMT +05:30) Bombay, Calcutta, Madras, New Delhi',
			'5.75' 	=> '(GMT +05:45) Katmandu',
			'6' 	=> '(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk',
			'6.5' 	=> '(GMT +06:30) Rangoon',
			'7' 	=> '(GMT +07:00) Bangkok, Hanoi, Jakarta',
			'8' 	=> '(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei',
			'9' 	=> '(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk',
			'9.5' 	=> '(GMT +09:30) Adelaide, Darwin',
			'10' 	=> '(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok',
			'11' 	=> '(GMT +11:00) Magadan, New Caledonia, Solomon Islands',
			'12' 	=> '(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island',
		),
		'upload_size_limit' => array(
			'-1' 	=> '服务默认设置',
			'0' 	=> '0KB',
			'64' 	=> '64KB',
			'128' 	=> '128KB',
			'256' 	=> '256KB',
			'512' 	=> '512KB',
			'1024' 	=> '1MB',
			'2048' 	=> '2MB',
			'4096' 	=> '4MB',
		),
		'visit_stats' => array(
			'0' => '关闭',
			'1' => '开启',
		),
		'review_goods' => array(
		    '0' => '否',
		    '1' => '是',
		),
		'store_identity_certification' => array(
		    '0' => '否',
		    '1' => '是',
		),
		
		//与底部语言合并
		'mail_service' => array(
			0 => '采用服务器内置的 Mail 服务',
			1 => '采用其他的 SMTP 服务',
		),
		'wap_config' => array(
			0 => '关闭',
			1 => '开启',
		),
		'smtp_ssl' => array(
			0 => '否',
			1 => '是',
		),
		'recommend_order' => array(
			0 => '推荐排序',
			1 => '随机显示',
		),
	),
	
	'rewrite_confirm_apache' 	=> "URL Rewrite 功能要求您的 Web Server 必须是 Apache，\\n并且起用了 rewrite 模块。\\n同时请您确认是否已经将htaccess.txt文件重命名为.htaccess。\\n如果服务器上还有其他的重写规则请去掉注释,请将RewriteBase行的注释去掉,并将路径设置为服务器请求的绝对路径",
	'rewrite_confirm_iis' 		=> "URL Rewrite 功能要求您的 Web Server 必须安装IIS，\\n并且起用了 ISAPI Rewrite 模块。\\n如果您使用的是ISAPI Rewrite商业版，请您确认是否已经将httpd.txt文件重命名为httpd.ini。如果您使用的是ISAPI Rewrite免费版，请您确认是否已经将httpd.txt文件内的内容复制到ISAPI Rewrite安装目录中httpd.ini里。",
	'gzip_confirm' 				=> "GZip 功能需要您的服务器支持 zlib 扩展库。\\n如果您发现开启Gzip后页面出现乱码，可能是您的服务器已经开启了Gzip，您不需要在 ECJia 中再次开启。",
	'retain_original_confirm' 	=> "如果您不保留商品原图，在“图片批量处理”的时候，\\n将不会重新生成不包含原图的商品图片。请慎重使用该功能！",
	'msg_invalid_file' 			=> '您上传了一个非法的文件类型。该文件名为：%s',
	'msg_upload_failed' 		=> '上传文件 %s 失败，请检查 %s 目录是否可写。',
	'smtp_ssl_confirm' 			=> '此功能要求您的php必须支持OpenSSL模块, 如果您要使用此功能，请联系您的空间商确认支持此模块',

	'mail_settings_note' 		=> '如果您的服务器支持 Mail 函数（具体信息请咨询您的空间提供商）。我们建议您使用系统的 Mail 函数。<br />当您的服务器不支持 Mail 函数的时候您也可以选用 SMTP 作为邮件服务器。',
	
	'save_success'				=> '保存商店设置成功。',
	'mail_save_success'			=> '邮件服务器设置成功。',
	'sendemail_success'			=> '恭喜！测试邮件已成功发送到 ',
	'sendemail_false'			=> '邮件发送失败，请检查您的邮件服务器设置！',
	
	'js_languages' => array(
		'smtp_host_empty'=> '您没有填写邮件服务器地址!',
		'smtp_port_empty'=> '您没有填写服务器端口!',
		'reply_email_empty'=> '您没有填写邮件回复地址!',
		'test_email_empty'=> '您没有填写发送测试邮件的地址!',
		'email_address_same'=> '邮件回复地址与发送测试邮件的地址不能相同!',
	),
	
	'invoice_type'		=> '类型',
	'invoice_rate'		=> '税率（％）',
	'back_shop_config'	=> '返回商店设置',
	'back_mail_settings'=> '返回邮件服务器设置',
	'mail_settings'		=> '邮件服务器设置',
	// 'sms_url'		=> '<a href="'.$url.'" target="_blank">点此注册手机短信服务</a>',
);

// end
