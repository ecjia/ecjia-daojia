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
 * 管理中心模板管理语言文件
 */

return array(
	'template_manage'		=> '模板管理',
	'current_template'		=> '当前模板',
	'available_templates'	=> '可用模板',
	'select_template'		=> '请选择一个模板：',
	'select_library'		=> '请选择一个库项目：',
	'library_name'			=> '库项目',
	'region_name'			=> '区域',
	'sort_order'			=> '序号',
	'contents'				=> '内容',
	'number'				=> '数量',
	'display'				=> '显示',
	'select_plz'			=> '请选择...',
	'button_restore'		=> '还原到上一修改',
	
	'template_author'		=> '作者',
	'template_info'			=> '模板描述',
	
	/* 提示信息 */
	'library_not_written'		=> '库文件 %s 没有修改权限，该库文件将无法修改',
	'install_template_success'	=> '启用模板成功。',
	'setup_success'				=> '设置模板内容成功。',
	'modify_dwt_failed'			=> '模板文件 %s 无法修改',
	'update_lib_success'		=> '库项目内容已经更新成功。',
	'update_lib_failed'			=> '编辑库项目内容失败。请检查 %s 目录是否可以写入。',
	'backup_success'			=> "所有模板文件已备份到templates/backup目录下。\n您现在要下载备份文件吗？。",
	'backup_failed'				=> '备份模板文件失败，请检查templates/backup 目录是否可以写入。',
	'not_editable'				=> '非可编辑区库文件无选择项',
	
	/* 每一个模板文件对应的语言 */
	'template_files'	=> array(
		'article'			=> '文章内容模板',
		'article_cat'		=> '文章分类模板',
		'brand'				=> '品牌专区',
		//'catalog'			=> '所有分类页',
		'category'			=> '商品分类页模板',
		'flow'				=> '购物流程模板',
		'goods'				=> '商品详情模板',
		'group_buy_goods'	=> '团购商品详情模板',
		'group_buy_list'	=> '团购商品列表模板',
		'index'				=> '首页模板',
		'search'			=> '商品搜索模板',
		'compare'			=> '商品比较模板',
		'snatch'			=> '夺宝奇兵',
		'tag_cloud'			=> '标签云模板',
		'brand'				=> '商品品牌页',
		'auction_list'		=> '拍卖活动列表',
		'auction'			=> '拍卖活动详情',
		'message_board'		=> '留言板',
		//'quotation'		=> '报价单',
		'exchange_list'		=> '积分商城列表',
	),
	
	/* 每一个库项目的描述 */
	'template_libs' => array(
		'ad_position'		=> '广告位',
		'index_ad'			=> '首页主广告位',
		'cat_articles'		=> '文章列表',
		'articles'			=> '文章列表',
		'goods_attrlinked'	=> '属性关联的商品',
		'recommend_best'	=> '精品推荐',
		'recommend_promotion'=> '促销商品',
		'recommend_hot'		=> '热卖商品',
		'recommend_new'		=> '新品上架',
		'bought_goods'		=> '购买过此商品的人还买过的商品',
		'bought_note_guide'	=> '购买记录',
		'brand_goods'		=> '品牌的商品',
		'brands'			=> '品牌专区',
		'cart'				=> '购物车',
		'cat_goods'			=> '分类下的商品',
		'category_tree'		=> '商品分类树',
		'comments'			=> '用户评论列表',
		'consignee'			=> '收货地址表单',
		'goods_fittings'	=> '相关配件',
		'page_footer'		=> '页脚',
		'goods_gallery'		=> '商品相册',
		'goods_article'		=> '相关文章',
		'goods_list'		=> '商品列表',
		'goods_tags'		=> '商品标记',
		'group_buy'			=> '团购商品',
		'group_buy_fee'		=> '团购商品费用总计',
		'help'				=> '帮助内容',
		'history'			=> '商品浏览历史',
		'comments_list'		=> '评论内容',
		'invoice_query'		=> '发货单查询',
		'member'			=> '会员区',
		'member_info'		=> '会员信息',
		'new_articles'		=> '最新文章',
		'order_total'		=> '订单费用总计',
		'page_header'		=> '页面顶部',
		'pages'				=> '列表分页',
		'goods_related'		=> '相关商品',
		'search_form'		=> '搜索表单',
		'signin'			=> '登录表单',
		'snatch'			=> '夺宝奇兵出价',
		'snatch_price'		=> '夺宝奇兵最新出价',
		'top10'				=> '销售排行',
		'ur_here'			=> '当前位置',
		'user_menu'			=> '用户中心菜单',
		'vote'				=> '调查',
		'auction'			=> '拍卖商品',
		'article_category_tree'=> '文章分类树',
		'order_query'		=> '前台订单状态查询',
		'email_list'		=> '前台邮件订阅',
		'vote_list'			=> '在线调查',
		'price_grade'		=> '价格范围',
		'filter_attr'		=> '属性筛选',
		'promotion_info'	=> '促销信息',
		'categorys'			=> '商品分类',
		'myship'			=> '配送方式',
		'online'			=> '统计在线人数',
		'relatetag'			=> '其他应用关联标签数据',
		'message_list'		=> '留言列表',
		'exchange_hot'		=> '积分商城热卖商品',
		'exchange_list'		=> '积分商城列表商品',
	),

	/* 模板布局备份 */
	'backup_setting'		=> '备份模板设置',
	'cur_setting_template'	=> '当前可备份的模板设置',
	'no_setting_template'	=> '没有可备份的模板设置',
	'cur_backup'			=> '可使用的模板设置备份',
	'no_backup'				=> '没有模板设置备份',
	'remarks'				=> '备份注释',
	'backup_setting'		=> '备份模板设置',
	'select_all'			=> '全选',
	'remarks_exist'			=> '备份注释 %s 已经用过，请换个注释名称',
	'backup_template_ok'	=> '备份设置成功',
	'del_backup_ok'			=> '备份删除成功',
	'restore_backup_ok'		=> '恢复备份成功',
	
	/* JS 语言项 */
	'js_languages'	=> array(
		'setupConfirm'	=> '启用新的模板将覆盖原来的模板。\n您确定要启用选定的模板吗？',
		'reinstall'		=> '重新安装当前模板',
		'selectPlease'	=> '请选择...',
		'removeConfirm'	=> '您确定要删除选定的内容吗？',
		'empty_content'	=> '对不起，库项目的内容不能为空。',
		'save_confirm'	=> '您已经修改了模板内容，您确定不保存么？',
	),
	'backup'	=> '备份当前模板',
);

// end