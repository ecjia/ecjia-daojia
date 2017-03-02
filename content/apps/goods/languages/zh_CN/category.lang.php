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
 * ECJIA 商品分类管理语言文件
 */
return array(
	/* 商品分类字段信息 */
	'goods_category'=> '商品分类',
	'cat_id' 		=> '编号',
	'cat_name' 		=> '分类名称',
	'isleaf' 		=> '不允许',
	'noleaf' 		=> '允许',
	'keywords' 		=> '关键字',
	'cat_desc' 		=> '分类描述',
	'parent_id' 	=> '上级分类',
	'sort_order' 	=> '排序',
	'measure_unit' 	=> '数量单位',
	'delete_info' 	=> '删除选中',
	'category_edit' => '编辑商品分类',
	'move_goods' 	=> '转移商品',
	'cat_top' 		=> '顶级分类',
	'show_in_nav' 	=> '是否显示在导航栏',
	'cat_style' 	=> '分类的样式表文件',
	'is_show' 		=> '是否显示',
	'show_in_index' => '设置为首页推荐',
	'notice_show_in_index' => '该设置可以在首页的最新、热门、推荐处显示该分类下的推荐商品',
	'goods_number' 	=> '商品数量',
	'grade' 		=> '价格区间个数',
	'notice_grade' 	=> '该选项表示该分类下商品最低价与最高价之间的划分的等级个数，填0表示不做分级，最多不能超过10个。',
	'short_grade' 	=> '价格分级',
	
	'nav' 			=> '导航栏',
	'index_new' 	=> '最新',
	'index_best'	=> '精品',
	'index_hot' 	=> '热门',
		
	'back_list' 	=> '返回分类列表',
	'continue_add' 	=> '继续添加分类',
	'notice_style' 	=> '您可以为每一个商品分类指定一个样式表文件。例如文件存放在 themes 目录下则输入：themes/style.css',
		
	/* 操作提示信息 */
	'catname_empty' => '分类名称不能为空！',
	'catname_exist' => '已存在相同的分类名称！',
	"parent_isleaf" => '所选分类不能是末级分类！',
	"cat_isleaf" 	=> '不是末级分类或者此分类下还存在有商品,您不能删除！',
	"cat_noleaf" 	=> '底下还有其它子分类,不能修改为末级分类！',
	"is_leaf_error" => '所选择的上级分类不能是当前分类或者当前分类的下级分类！',
	'grade_error' 	=> '价格分级数量只能是0-10之内的整数',
	
	'catadd_succed' 	=> '新商品分类添加成功！',
	'catedit_succed' 	=> '商品分类编辑成功！',
	'catdrop_succed' 	=> '商品分类删除成功！',
	'catremove_succed' 	=> '商品分类转移成功！',
	'move_cat_success' 	=> '转移商品分类已成功完成！',
	
	'cat_move_desc' 	=> '什么是转移商品分类？',
	'select_source_cat' => '选择要转移的分类',
	'select_target_cat' => '选择目标分类',
	'source_cat' 		=> '从此分类',
	'target_cat' 		=> '转移到',
	'start_move_cat' 	=> '开始转移',
	'cat_move_notic' 	=> '在添加商品或者在商品管理中，如果需要对商品的分类进行变更，那么你可以通过此功能，正确管理你的商品分类。',
	'cat_move_empty' 	=> '你没有正确选择商品分类！',
	
	'sel_goods_type' 	=> '请选择商品类型',
	'sel_filter_attr' 	=> '请选择筛选属性',
	'filter_attr' 		=> '筛选属性',
	'filter_attr_notic' => '筛选属性可在前分类页面筛选商品',
	'filter_attr_not_repeated' => '筛选属性不可重复',
	
	/*JS 语言项*/
	'js_languages' => array(
		'catname_empty' => '分类名称不能为空！',
		'unit_empyt' 	=> '数量单位不能为空！',
		'is_leafcat' 	=> '您选定的分类是一个末级分类。\r\n新分类的上级分类不能是一个末级分类',
		'not_leafcat' 	=> '您选定的分类不是一个末级分类。\r\n商品的分类转移只能在末级分类之间才可以操作。',
		'filter_attr_not_repeated' => '筛选属性不可重复',
		'filter_attr_not_selected' => '请选择筛选属性'
	),
	
	//追加
	'add_goods_cat'			=> '添加商品分类',
	'add_custom_success'	=> '添加自定义栏目成功',
	'update_fail'			=> '缺少关键参数，更新失败',
	'update_custom_success'	=> '更新自定义栏目成功',
	'drop_custom_success'	=> '删除自定义栏目成功',
	'sort_edit_ok'			=> '排序序号编辑成功',
	'sort_edit_fail'		=> '排序序号编辑失败',
	'number_edit_ok'		=> '数量单位编辑成功',
	'number_edit_fail'		=> '数量单位编辑失败',
	'grade_edit_ok'			=> '价格分级编辑成功',
	'grade_edit_fail'		=> '价格分级编辑失败',
	'drop_cat_img_ok'		=> '删除分类图片成功',
	'use_commas_separate'	=> '用英文逗号分隔',
	'term_meta'				=> '自定义栏目',
	'edit_term_mate'		=> '编辑自定义栏目',
	'name'					=> '名称',
	'value'					=> '值',
	'update'				=> '更新',
	'remove_custom_confirm'	=> '您确定要删除该自定义栏目吗？',
	'add_term_mate'			=> '添加自定义栏目',
	'add_new_mate'			=> '添加新栏目',
	'promotion_info'		=> '促销信息',
	'recommend_index'		=> '首页推荐',
	'cat_img'				=> '分类图片',
	'select_cat_img'		=> '选择分类图片',
	'edit_cat_img'			=> '修改分类图片',
	'drop_cat_img_confirm'	=> '您确定要删除该分类图片吗？',
	'tv_cat_img'			=> 'TV-分类图片',
	'seo'					=> 'SEO优化',
	'enter_number'			=> '请输入数量单位',
	'enter_grade'			=> '请输入价格分级',
	'enter_order'			=> '请输入排序序号',
	'drop_cat_confirm'		=> '您确定要删除该分类吗？',
	'notice'				=> '提示：',
	
	'label_cat_name'		=> '分类名称：',
	'label_parent_cat'		=> '上级分类：',
	'label_measure_unit'	=> '数量单位：',
	'label_grade'			=> '价格区间个数：',
	'label_filter_attr'		=> '筛选属性：',
	'label_keywords'		=> '关键字：',
	'label_cat_desc'		=> '分类描述：',
	'label_edit_term_mate'	=> '编辑自定义栏目：',
	'label_add_term_mate'	=> '添加自定义栏目：',
	'label_sort_order'		=> '排序：',
	'label_is_show'			=> '是否显示：',
	'label_recommend_index'	=> '首页推荐：',
	'lab_upload_picture'	=> '上传分类图片：',
	'label_source_cat' 		=> '从此分类：',
	'label_target_cat' 		=> '转移到：',
	
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	
	'goods_category_help'	=> '欢迎访问ECJia智能后台商品分类列表页面，系统中所有的商品分类都会显示在此列表中，列表中切换分类是否显示可切换前台商品分类的显示与隐藏。',
	'about_goods_category'	=> '关于商品分类列表帮助文档',
	
	'add_category_help'		=> '欢迎访问ECJia智能后台添加商品分类页面，可以在此页面添加商品分类信息。',
	'about_add_category'	=> '关于添加商品分类帮助文档',
	
	'edit_category_help'	=> '欢迎访问ECJia智能后台编辑商品分类页面，可以在此页面编辑商品分类信息。',
	'about_edit_category'	=> '关于编辑商品分类帮助文档',
	
	'move_category_help'	=> '欢迎访问ECJia智能后台转移商品分类页面，可以在此页面进行转移商品分类操作。',
	'about_move_category'	=> '关于转移商品分类帮助文档',
);	

// end
