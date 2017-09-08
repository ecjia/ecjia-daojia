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
 * ECJIA 管理中心起始页语言文件
 */
return array(
	'edit_goods' 			=> '编辑商品',
	'copy_goods'		 	=> '复制商品',
	'continue_add_goods' 	=> '继续添加新商品',
	'back_goods_list' 		=> '返回商品列表',
	'add_goods_ok' 			=> '添加商品成功',
	'edit_goods_ok' 		=> '编辑商品成功',
	'trash_goods_ok' 		=> '放入回收站成功',
	'restore_goods_ok' 		=> '还原商品成功',
	'drop_goods_ok' 		=> '删除商品成功',
	'batch_handle_ok' 		=> '批量操作成功',
	'drop_goods_confirm' 	=> '您确定要删除该商品吗？',
	'batch_drop_confirm' 	=> "彻底删除商品将删除与该商品有关的所有信息，\n您确定要删除选中的商品吗？",
	'trash_goods_confirm' 	=> '您确定要把该商品放入回收站吗？',
	'trash_product_confirm' => '您确定要把该货品删除吗？',
	'batch_trash_confirm' 	=> '您确定要把选中的商品放入回收站吗？',
	'restore_goods_confirm' => '您确定要把该商品还原吗？',
	'batch_restore_confirm' => '您确定要把选中的商品还原吗？',
	'batch_on_sale_confirm' => '您确定要把选中的商品上架吗？',
	'batch_not_on_sale_confirm' => '您确定要把选中的商品下架吗？',
	'batch_best_confirm' 	=> '您确定要把选中的商品设为精品吗？',
	'batch_not_best_confirm'=> '您确定要把选中的商品取消精品吗？',
	'batch_new_confirm' 	=> '您确定要把选中的商品设为新品吗？',
	'batch_not_new_confirm' => '您确定要把选中的商品取消新品吗？',
	'batch_hot_confirm' 	=> '您确定要把选中的商品设为热销吗？',
	'batch_not_hot_confirm' => '您确定要把选中的商品取消热销吗？',
	'cannot_found_goods' 	=> '找不到指定的商品',
	'sel_goods_type' 		=> '请选择商品类型',
	'sel_goods_suppliers' 	=> '请选择供货商',
	
	/*------------------------------------------------------ */
	//-- 图片处理相关提示信息
	/*------------------------------------------------------ */
	'no_gd' 				=> '您的服务器不支持 GD 或者没有安装处理该图片类型的扩展库。',
	'img_not_exists' 		=> '没有找到原始图片，创建缩略图失败。',
	'img_invalid' 			=> '创建缩略图失败，因为您上传了一个无效的图片文件。',
	'create_dir_failed' 	=> 'images 文件夹不可写，创建缩略图失败。',
	'safe_mode_warning' 	=> '您的服务器运行在安全模式下，而且 %s 目录不存在。您可能需要先行创建该目录才能上传图片。',
	'not_writable_warning' 	=> '目录 %s 不可写，您需要把该目录设为可写才能上传图片。',
		
	/*------------------------------------------------------ */
	//-- 商品列表
	/*------------------------------------------------------ */
	'goods_cat' 	=> '所有分类',
	'goods_brand' 	=> '所有品牌',
	'intro_type' 	=> '全部',
	'keyword' 		=> '关键字',
	'is_best' 		=> '精品',
	'is_new' 		=> '新品',
	'is_hot' 		=> '热销',
	'is_promote' 	=> '特价',
	'all_type' 		=> '全部推荐',
	'sort_order' 	=> '推荐排序',
	
	'goods_name' 	=> '商品名称',
	'goods_sn' 		=> '货号',
	'shop_price' 	=> '价格',
	'is_on_sale' 	=> '上架',
	'goods_number' 	=> '库存',
	
	'copy' 			=> '复制',
	'product_list' 	=> '货品列表',
	
	'integral' 		=> '积分额度',
	'on_sale' 		=> '上架',
	'not_on_sale' 	=> '下架',
	'best' 			=> '精品',
	'not_best' 		=> '取消精品',
	'new' 			=> '新品',
	'not_new' 		=> '取消新品',
	'hot' 			=> '热销',
	'not_hot' 		=> '取消热销',
	'move_to'	 	=> '转移到分类',
	
	// ajax
	'goods_name_null' 		=> '请输入商品名称',
	'goods_sn_null' 		=> '请输入货号',
	'shop_price_not_number' => '价格不是数字',
	'shop_price_invalid' 	=> '您输入了一个非法的市场价格。',
	'goods_sn_exists' 		=> '您输入的货号已存在，请换一个',
	
	/*------------------------------------------------------ */
	//-- 添加/编辑商品信息
	/*------------------------------------------------------ */
	'tab_general' 		=> '通用信息',
	'tab_detail' 		=> '商品描述',
	'tab_mix' 			=> '其他信息',
	'tab_properties' 	=> '商品属性',
	'tab_gallery' 		=> '商品相册',
	'tab_linkgoods' 	=> '关联商品',
	'tab_groupgoods' 	=> '关联配件',
	'tab_article' 		=> '关联文章',
	
	'lab_goods_name' 	=> '商品名称：',
	'lab_goods_sn' 		=> '商品货号：',
	'lab_goods_cat' 	=> '商品分类：',
	'lab_other_cat' 	=> '扩展分类：',
	'lab_goods_brand' 	=> '商品品牌：',
	'lab_shop_price' 	=> '本店售价：',
	'lab_market_price' 	=> '市场售价：',
	'lab_user_price' 	=> '会员价格：',
	'lab_promote_price' => '促销价：',
	'lab_promote_date' 	=> '促销日期：',
	'lab_picture' 		=> '上传商品图片：',
	'lab_thumb' 		=> '上传商品缩略图：',
	'auto_thumb' 		=> '自动生成商品缩略图',
	'lab_keywords' 		=> '商品关键词：',
	'lab_goods_brief' 	=> '简单描述：',
	'lab_seller_note' 	=> '商家备注：',
	'lab_goods_type' 	=> '商品类型：',
	'lab_picture_url' 	=> '商品图片外部URL',
	'lab_thumb_url' 	=> '商品缩略图外部URL',
	
	'lab_goods_weight' 		=> '商品重量：',
	'unit_g' 				=> '克',
	'unit_kg' 				=> '千克',
	'lab_goods_number' 		=> '库存数量：',
	'lab_warn_number' 		=> '警告数量：',
	'lab_integral' 			=> '积分购买金额：',
	'lab_give_integral' 	=> '赠送消费积分数：',
	'lab_rank_integral' 	=> '赠送等级积分数：',
	'lab_intro' 			=> '加入推荐：',
	'lab_is_on_sale' 		=> '上架：',
	'lab_is_alone_sale' 	=> '能作为普通商品销售：',
	'lab_is_free_shipping' 	=> '是否包邮：',
	
	'compute_by_mp' 		=> '按市场价计算',
	'notice_goods_sn' 		=> '如果您不输入商品货号，系统将自动生成一个唯一的货号。',
	'notice_integral'		=> '(此处需填写金额)购买该商品时最多可以使用积分的金额',
	'notice_give_integral' 	=> '购买该商品时赠送消费积分数,-1表示按商品价格赠送',
	'notice_rank_integral' 	=> '购买该商品时赠送等级积分数,-1表示按商品价格赠送',
	'notice_seller_note'	=> '仅供商家自己看的信息',
	'notice_storage' 		=> '库存在商品为虚货或商品存在货品时为不可编辑状态，库存数值取决于其虚货数量或货品数量',
	'notice_keywords' 		=> '用英文逗号分隔',
	'notice_user_price' 	=> '会员价格为-1时表示会员价格按会员等级折扣率计算。你也可以为每个等级指定一个固定价格',
	'notice_goods_type' 	=> '请选择商品的所属类型，进而完善此商品的属性',
	
	'on_sale_desc' 			=> '打勾表示允许销售，否则不允许销售。',
	'alone_sale' 			=> '打勾表示能作为普通商品销售，否则只能作为配件或赠品销售。',
	'free_shipping' 		=> '打勾表示此商品不会产生运费花销，否则按照正常运费计算。',
	
	'invalid_goods_img' 	=> '商品图片格式不正确！',
	'invalid_goods_thumb' 	=> '商品缩略图格式不正确！',
	'invalid_img_url'	 	=> '商品相册中第%s个图片格式不正确！',
	
	'goods_img_too_big' 	=> '商品图片文件太大了（最大值：%s），无法上传。',
	'goods_thumb_too_big' 	=> '商品缩略图文件太大了（最大值：%s），无法上传。',
	'img_url_too_big' 		=> '商品相册中第%s个图片文件太大了（最大值：%s），无法上传。',
	
	'integral_market_price' => '取整数',
	'upload_images' 		=> '上传图片',
	'spec_price' 			=> '属性价格',
	'drop_img_confirm' 		=> '您确定要删除该图片吗？',
	
	'select_font' => '字体样式',
	'font_styles' => array('strong' => '加粗', 'em' => '斜体', 'u' => '下划线', 'strike' => '删除线'),
	
	'rapid_add_cat' 	=> '添加分类',
	'rapid_add_brand' 	=> '添加品牌',
	'category_manage' 	=> '分类管理',
	'brand_manage' 		=> '品牌管理',
	'hide' 				=> '隐藏',
		
	'lab_volume_price' 			=> '商品优惠价格：',
	'volume_number'				=> '优惠数量',
	'volume_price'				=> '优惠价格',
	'notice_volume_price'		=> '购买数量达到优惠数量时享受的优惠价格',
	'volume_number_continuous' 	=> '优惠数量重复！',
		
	'label_suppliers' 	=> '选择供货商：',
	'suppliers_no' 		=> '不指定供货商属于本店商品',
	'suppliers_move_to' => '转移到供货商',
	'lab_to_shopex' 	=> '转移到网店',
		
	/*------------------------------------------------------ */
	//-- 关联商品
	/*------------------------------------------------------ */
	
	'all_goods' 	=> '可选商品',
	'link_goods' 	=> '跟该商品关联的商品',
	'single' 		=> '单向关联',
	'double' 		=> '双向关联',
	'all_article' 	=> '可选文章',
	'goods_article' => '跟该商品关联的文章',
	'top_cat' 		=> '顶级分类',
	
	/*------------------------------------------------------ */
	//-- 组合商品
	/*------------------------------------------------------ */
	
	'group_goods' 	=> '该商品的配件',
	'price' 		=> '价格',
	
	/*------------------------------------------------------ */
	//-- 商品相册
	/*------------------------------------------------------ */
	
	'img_desc' 	=> '图片描述',
	'img_url' 	=> '上传文件',
	'img_file' 	=> '或者输入外部图片链接地址',
	
	/*------------------------------------------------------ */
	//-- 关联文章
	/*------------------------------------------------------ */
	'article_title' 			=> '文章标题',
	'goods_not_exist' 			=> '该商品不存在',
	'goods_not_in_recycle_bin' 	=> '该商品尚未放入回收站，不能删除',
		
	'js_lang' => array(
		'cat_name_required'		=> '请输入类型名称',
		'attr_name_required'	=> '请输入属性名称',
		'cat_id_select'			=> '请选择所属商品类型',
		'old_key_required'		=> '请输入原加密串！',
		'new_key_required'		=> '请输入新加密串！',
		'separator_required'	=> '分隔符不能为空！',
		'brand_name_required'	=> '请输入品牌名称',
		'select_goods_attr'		=> '请选择筛选属性',
		'category_name_required'=> '请输入分类名称',
		'add_new_mate'			=> '添加新栏目',
		'back_select_mate'		=> '返回选择栏目',
		'transfer_confirm'		=> '您确定转移分类下的商品吗？',
		'ok'					=> '确定',
		'cancel'				=> '取消',
		'choose_select_goods'	=> '请选择需要转移的商品',
		'give_up_confirm'		=> '您确定放弃当前页面编辑的内容吗？',
		'not_calculate'			=> '未计算',
		'goods_name_required'	=> '请输入商品名称！',
		'shop_price_required'	=> '请输入商品价格！',
		'shop_price_limit'		=> '请输入正确价格格式！',
		'goods_number_required'	=> '请输入商品库存！',
		'goods_number_limit'	=> '商品库存最小只能为0！',
		'category_id_select'	=> '请选择商品分类！',
		'product_sn_required'	=> '请输入货号',
		'product_number_required' => '请输入库存',
		'select_goods_empty'	=> '未搜索到商品信息',
		'change_connect'		=> '切换关联',
		'single' 				=> '单向关联',
		'double' 				=> '双向关联',
		'modify_price'			=> '修改价格',
		'save'					=> '保存',
		'price'					=> '价格',
		'select_article_empty'	=> '未搜索到文章信息',
		'drag_here_upload'		=> '将图片拖动至此处上传',
		'select_operate_info'	=> '请先选择需要操作的选项',
		'card_sn_required'		=> '请输入卡片序号',
		'card_password_required'=> '请输入卡片密码',
		'pls_upload_file'		=> '请上传文件',
		'pls_select'			=> '请选择...',
		'brand_name_empty'		=> '品牌名称不能为空',
		'cat_name_empty'		=> '分类名称不能为空',
		'add_goods_ok' 			=> '添加商品成功',
		'spec_name_required'	=> '请输入规格名称'
	),
		
	/* 虚拟卡 */
	'card' 				=> '查看虚拟卡信息',
	'replenish' 		=> '补货',
	'batch_card_add'	=> '批量补货',
	'add_replenish' 	=> '添加虚拟卡卡密',
	'goods_number_error'=> '商品库存数量错误',
		
	/*------------------------------------------------------ */
	//-- 货品
	/*------------------------------------------------------ */
	'product' 					=> '货品',
	'product_info' 				=> '货品信息',
	'specifications' 			=> '规格',
	'total' 					=> '合计：',
	'add_product' 				=> '添加货品',
	'save_products' 			=> '保存货品成功',
	'product_id_null' 			=> '货品id为空',
	'cannot_found_products' 	=> '未找到指定货品',
	'product_batch_del_success' => '货品批量删除成功',
	'product_batch_del_failure' => '货品批量删除失败',
	'batch_product_add' 	=> '批量添加',
	'batch_product_edit' 	=> '批量编辑',
	'products_title' 		=> '商品名称：%s',
	'products_title_2' 		=> '货号：%s',
	'good_shop_price' 		=> '（商品价格：%d）',
	'good_goods_sn' 		=> '（商品货号：%s）',
	'exist_same_goods_sn' 	=> '货品货号不允许与产品货号重复',
	'exist_same_product_sn' => '货品货号重复',
	'cannot_add_products' 	=> '货品添加失败',
	'exist_same_goods_attr' => '货品规格属性重复',
	'cannot_goods_number' 	=> '此商品存在货品，不能修改商品库存',
	'not_exist_goods_attr' 	=> '此商品不存在规格，请为其添加规格',
	'goods_sn_exists' 		=> '您输入的货号已存在，请换一个',
	'edit_product'			=> '编辑货品',
	'edit_product_sn'		=> '编辑货品货号',
	'edit_product_number'	=> '编辑货品库存',
	
	//追加
	'same_attrbiute_goods' 	=> '相同%s的商品',
	'promotion_time' 		=> '活动时间：%s ～ %s',
	'goods_attr' 			=> '商品属性',
	'drop_success'			=> '删除成功',
	'goods_list'			=> '商品列表',
	'edit_goods_photo'		=> '编辑商品相册',
	'add_goods_photo'		=> '添加商品相册',
	'tab_product'			=> '货品管理',
	'parameter_missing'		=> '参数丢失',
	'upload_success'		=> '上传成功',
	'edit_success'			=> '编辑成功',
	'edit_fail'				=> '编辑失败',
	'save_sort_ok'			=> '保存排序成功',
	'goods_photo_notice'	=> '（编辑、排序、删除）',
	'goods_photo_help'		=> '排序后请点击“保存排序”',
	'ok'					=> '确定',
	'cancel'				=> '取消',
	'save'					=> '保存',
	'move'					=> '移动',
	'no_title'				=> '无标题',
	'save_sort'				=> '保存排序',
	'drop_photo_confirm'	=> '您确定要删除这张相册图片吗？',
	'no_goods'				=> '未检测到此商品',
	'return_last_page'		=> '返回上一页',
	'goods_preview'			=> '商品预览',
	'goods_edit'			=> '商品编辑',
	'goods_recycle'			=> '商品回收站',
	'edit_virtual_goods'	=> '编辑虚拟商品',
	'copy_virtual_goods'	=> '复制虚拟商品',
	'pls_choose_operate'	=> '请选择操作',
	'edit_ok'				=> '修改成功',
	'toggle_on_sale'		=> '已成功切换上架状态',
	'toggle_best'			=> '已成功切换精品推荐状态',
	'toggle_new'			=> '已成功切换新品推荐状态',
	'toggle_hot'			=> '已成功切换热销推荐状态',
	'lost_parameter'		=> '缺少参数，请重试',
	'add_attr_first'		=> '请先添加库存属性，再到货品管理中设置货品库存',
	'product_sn_exsits'		=> '商品货号重复',
	'property_not_empty'	=> '属性不能为空',
	'goods_name_is'			=> '商品名称为 ',
	'product_sn_is'			=> '货品货号为 ',
	'edit_goods_desc'		=> '编辑商品描述',
	'add_goods_desc'		=> '添加商品描述',
	'canot_find_goods'		=> '找不到ID为 %s 的商品！',
	'edit_goods_attr'		=> '编辑商品属性',
	'add_goods_attr'		=> '添加商品属性',
	'edit_attr_success'		=> '编辑属性成功',
	'edit_link_goods'		=> '编辑关联商品',
	'add_link_goods'		=> '添加关联商品',
	'edit_link_parts'		=> '编辑关联配件',
	'add_link_parts'		=> '添加关联配件',
	'edit_link_article'		=> '编辑关联文章',
	'add_link_article'		=> '添加关联文章',
	
	'goods_count_info'		=> '商品统计信息',
	'goods_total'			=> '商品总数',
	'warn_goods_number'		=> '库存警告商品数',
	'new_goods_number'		=> '新品推荐数',
	'best_goods_number'		=> '精品推荐数',
	'hot_goods_number'		=> '热销商品数',
	'promote_goods_numeber'	=> '促销商品数',
	
	'discard_changes'		=> '是否放弃本页面修改？',
	'as_goods'				=> '作为商品',
	'seo'					=> 'SEO优化',
	'remark_info'			=> '备注信息',
	'update'				=> '更新',
	'issue'					=> '发布',
	'choose_goods_cat'		=> '选择商品分类',
	'select_cat_first'		=> '请先选择商品类型',
	'select_extend_cat'		=> '选择扩展分类',
	'add_cat'				=> '添加商品分类',
	'select_goods_brand'	=> '选择商品品牌',
	'add_brand'				=> '添加商品品牌',
	'goods_image'			=> '商品图片',
	'goods_thumb'			=> '商品缩略图：',
	'thumb_img_notice'		=> '点击更换商品图片或商品缩略图。',
	'promote_price'			=> '折扣、促销价格',
	'add_promote_price'		=> '添加优惠价格',
	'promotion_info'		=> '促销信息',
	'integral_about'		=> '积分相关',
	'id_or_sn'				=> '请输入商品ID或货号',
	'search'				=> '搜索',
	'product_information'	=> '产品信息',
	
	'add_time'				=> '添加时间：',
	'last_update'			=> '最后更新：',
	'link_parts_notice'		=> '搜索要关联的配件，搜到配件会展示在左侧列表框中。点击左侧列表中选项，配件即可进入右侧已关联列表。保存后生效。您还可以在右侧编辑关联配件的价格。',
	'filter_goods_info'		=> '筛选搜索到的商品信息',
	'no_content'			=> '暂无内容',
	'edit_price'			=> '修改价格',
	
	'link_goods_notice'		=> '搜索要关联的商品，搜到商品会展示在左侧列表框中。点击左侧列表中选项，关联商品即可进入右侧已关联列表。保存后生效。您还可以在右侧编辑关联模式。',
	'switch_relation'		=> '切换关联',
	
	'link_article_notice'	=> '搜索要关联的文章，搜到的文章会展示在左侧列表框中。点击左侧列表中选项，关联文章即可进入右侧已关联列表。保存后生效。',
	'filter_article_info'	=> '筛选搜索到的文章信息',
	
	'batch_handle'			=> '批量操作',
	'restore_confirm'		=> '您确定要把商品从回收站还原吗？',
	
	'select_goods_msg'		=> '请选择需要操作的商品',
	'enter_keywords'		=> '请输入关键字',
	'restore'				=> '还原',
	'move_to_cat'			=> '转移商品至分类',
	'move_confirm'			=> '是否将选中商品转移至分类？',
	'select_move_goods'		=> '请选择要转移的商品',
	'start_move'			=> '开始转移',
	'is_on_saled'			=> '已上架',
	'not_on_saled'			=> '未上架',
	'move_to_trash'			=> '移至回收站',
	
	'select_trash_goods'	=> '请选择要移至回收站的商品',
	'select_sale_goods'		=> '请选择要上架的商品',
	'select_not_sale_goods'	=> '请选择要下架的商品',
	'select_best_goods'		=> '请选择设为精品的商品',
	'select_not_best_goods'	=> '请选择取消精品的商品',
	'select_new_goods'		=> '请选择要设为新品的商品',
	'select_not_news_goods' => '请选择要取消新品的商品',
	'select_hot_goods'		=> '请选择要设为热销的商品',
	'select_not_hot_goods'	=> '请选择要取消热销的商品',
	
	'filter'				=> '筛选',
	'thumb'					=> '缩略图',
	'preview'				=> '预览',
	'card_info'				=> '虚拟卡信息',
	'enter_goods_sn'		=> '请输入商品货号',
	'enter_goods_price'		=> '请输入商品价格',
	'enter_sort_order'		=> '请输入排序序号',
	'enter_goods_number'	=> '请输入库存数量',
	'enter_goods_keywords'	=> '请输入商品关键字',
    'product_attr_repeat'   => '货品属性不能重复',
    'product_sn_error'      => '货号不能重复',
	
	'upload_goods_image_error'	=> '商品图片路径无效',
	'copy_gallery_image_fail'	=> '商品相册复制失败',
	'upload_thumb_error'		=> '商品缩略图路径无效',
	'free'						=> '免费',
	'label_as_goods'			=> '作为商品：',
	'label_keywords'			=> '关键字：',
	'category'					=> '商品分类',
	'brand'						=> '商品品牌',
	
	'goods_manage'			=> '商品管理',
	'add_new_goods'			=> '添加新商品',
	'goods_type'			=> '商品类型',
	'goods_booking'			=> '缺货登记',
	'virtual_goods_list'	=> '虚拟商品列表',
	'add_virtual_goods'		=> '添加虚拟商品',
	'encrypted_string'		=> '加密串',
	'virtual_card_change' 	=> '更改加密串',
	'goods_auto'			=> '商品自动上下架',
	'goods_add_update'		=> '商品添加/编辑',
	'remove_back'			=> '商品回收/恢复',
	'drop_goods'			=> '商品彻底删除',
	'cat_manage'			=> '分类添加/编辑',
	'cat_drop'				=> '分类转移/删除',
	'attr_manage'			=> '商品属性管理',
	'goods_brand_manage'	=> '商品品牌管理',
	'goods_auto_update'		=> '商品自动上下架更新',
	'goods_auto_delete'		=> '商品自动上下架删除',
	'virualcard_manage'		=> '虚拟卡管理',
	'picture_batch'			=> '图片批量处理',
	'goods_export'			=> '商品批量导出',
	'goods_batch'			=> '商品批量上传/修改',
	'gen_goods_script'		=> '生成商品代码',
	'invalid_parameter'		=> '参数无效',
	'batch_start'			=> '批量上架',
	'batch_end'				=> '批量下架',
	'quick_add_cat'			=> '快速添加分类',
	'quick_add_cat_help'	=> '如已选择商品分类则添加该分类子类，否则为顶级分类',
	'quick_add_brand'		=> '快速添加品牌',
	'next_step'				=> '下一步',
	'complete'				=> '完成',
	
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	
	'goods_gallery_help'	=> '欢迎访问ECJia智能后台商品相册页面，系统中所有的商品图片都会显示在此页面。',
	'about_goods_gallery'	=> '关于商品相册帮助文档',
	
	'goods_list_help'		=> '欢迎访问ECJia智能后台商品列表页面，系统中所有的商品都会显示在此列表中。',
	'about_goods_list'		=> '关于商品列表帮助文档',
	
	'goods_preview_help'	=> '欢迎访问ECJia智能后台商品预览页面，在此页面可以预览有关该商品的所有详细信息。',
	'about_goods_preview'	=> '关于商品预览帮助文档',
	
	'goods_trash_help'		=> '欢迎访问ECJia智能后台商品回收站页面，在商品列表中进行删除的商品会放入此回收站中，在该页面可以对商品进行彻底删除或者还原操作。',
	'about_goods_trash'		=> '关于商品回收站帮助文档',
	
	'add_goods_help'		=> '欢迎访问ECJia智能后台添加商品页面，可以在此页面添加商品信息。',
	'about_add_goods'		=> '关于添加商品帮助文档',
	
	'edit_goods_help'		=> '欢迎访问ECJia智能后台编辑商品页面，可以在此对相应的商品进行编辑。',
	'about_edit_goods'		=> '关于编辑商品帮助文档',
	
	'copy_goods_help'		=> '欢迎访问ECJia智能后台复制商品页面，通过该页面可以对已经复制的商品修改任何信息。',
	'about_copy_goods'		=> '关于复制商品帮助文档',
	
	'edit_attr_help'		=> '欢迎访问ECJia智能后台商品属性页面，可以在此对商品的有关属性进行编辑。',
	'about_edit_attr'		=> '关于编辑商品属性帮助文档',
	
	'edit_link_goods_help'	=> '欢迎访问ECJia智能后台关联商品页面，可以在此对相应的商品进行关联操作。',
	'about_edit_link_goods'	=> '关于关联商品帮助文档',
	
	'edit_link_parts_help'	=> '欢迎访问ECJia智能后台商品关联配件页面，可以在此对相应的商品进行关联配件操作。',
	'about_edit_link_parts'	=> '关于商品关联配件帮助文档',
	
	'edit_link_article_help'	=> '欢迎访问ECJia智能后台商品关联文章页面，可以在此对相应的商品进行关联文章操作。',
	'about_edit_link_article'	=> '关于商品关联文章帮助文档',
	
	//追加
	'goods_update' 				=> '更新商品',
	'goods_delete' 				=> '删除商品',
	'remove_back'				=> '商品回收/恢复',
	'category_update'			=> '更新分类',
	'category_move'				=> '分类转移',
	'category_delete'			=> '分类删除',
	'goods_type_update'			=> '更新商品类型',
	'goods_type_delete'			=> '删除商品类型',
	'brand_update' 				=> '更新品牌',
	'brand_delete' 				=> '删除品牌',
	'attr_update'				=> '商品属性更新',
	'attr_delete'				=> '商品属性删除',
	'business_name'				=> '商家名称',
	'check_goods'				=> '审核',
	'enter_merchant_keywords' 	=> '请输入商家关键字',
	'merchant'					=> '商家',
	'label_best'				=> '精品：',
	'label_new'					=> '新品：',
	'label_hot'					=> '热销：',
	'basic_info'				=> '基本信息',
	'gram'						=> '克',
	'kilogram'					=> '千克',
	
	'gbs' => array(
		GBS_PRE_START 	=> '未开始',
		GBS_UNDER_WAY 	=> '进行中',
		GBS_FINISHED 	=> '结束未处理',
		GBS_SUCCEED 	=> '成功结束',
		GBS_FAIL 		=> '失败结束',
	),
	'select_please'		=> '请选择...',
	'all_category'		=> '所有分类',
	'self'				=> '自营',
	'select_platform_cat' 		=> '选择平台分类',
	'pls_select_platform_cat'	=> '请选择平台分类',
	'goods_spec'				=> '商品规格',
	'label_goods_spec'			=> '商品规格：',
	'sel_goods_spec'			=> '请选择商品规格',
	'notice_goods_spec'			=> '请选择商品的所属规格，进而完善此商品的属性'
);

// end