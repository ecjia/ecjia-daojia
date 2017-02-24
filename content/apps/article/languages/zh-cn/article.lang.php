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
 * 文章管理语言项
 */

/**
 * ECJIA 文章列表字段信息 
 */
$LANG['title'] ='文章标题';
$LANG['cat'] ='文章分类';
$LANG['reserve'] = '保留';
$LANG['article_type'] ='文章重要性';
$LANG['author'] ='文章作者';
$LANG['email'] ='作者email';
$LANG['keywords'] ='关键字：';
$LANG['lable_description'] ='网页描述：';
$LANG['content'] ='文章内容：';
$LANG['is_open'] ='是否显示';
$LANG['article_id'] ='编号';
$LANG['add_time'] ='添加日期';
$LANG['upload_file'] ='上传文件：';
$LANG['file_url'] ='或输入文件地址';
$LANG['invalid_file'] = '上传文件格式不正确';
$LANG['article_name_exist'] = '有相同的文章名称存在!';
$LANG['select_plz'] = '请选择...';
$LANG['external_links'] = '外部链接：';

$LANG['top'] ='置顶';
$LANG['common'] ='普通';
$LANG['isopen'] ='显示';
$LANG['isclose'] ='不显示';
$LANG['no_article'] = '您现在还没有任何文章';
$LANG['no_select_article'] = '您没有选择任何文章';
$LANG['no_select_act'] = '请选择文章分类！';

$LANG['display'] = '显示文章内容';
$LANG['download'] = '下载文件';
$LANG['both'] = '既显示文章内容又下载文件';

$LANG['batch'] = '批量操作' ;
$LANG['button_remove'] ='批量删除';
$LANG['button_hide'] ='批量隐藏';
$LANG['button_show'] ='批量显示';
$LANG['move_to'] = '转移到分类';

$LANG['article_edit'] = '编辑文章内容';
$LANG['preview_article'] = '文章预览';
$LANG['article_editbtn'] = '编辑文章';
$LANG['view'] = '预览';
$LANG['tab_general'] = '通用信息';
$LANG['tab_content'] = '文章内容';
$LANG['tab_goods'] = '关联商品';

$LANG['link_goods'] = '跟该文章关联的商品';
$LANG['keyword'] = '关键字';

/* 提示信息 */
$LANG['title_exist'] ='文章 %s 已经存在';
$LANG['back_article_list'] ='返回文章列表';
$LANG['continue_article_add'] ='继续添加新文章';
$LANG['articleadd_succeed'] ='文章已经添加成功';
$LANG['articleedit_succeed'] ='文章 %s 成功编辑';
$LANG['articleedit_fail'] ='文章编辑失败';
$LANG['no_title'] ='没有输入文章标题';
$LANG['drop_confirm'] = '您确认要删除这篇文章吗？';
$LANG['batch_handle_ok'] = '批量操作成功';
$LANG['batch_handle_ok_del'] = '批量删除操作成功';
$LANG['batch_handle_ok_hide'] = '批量隐藏操作成功';
$LANG['batch_handle_ok_show'] = '批量显示操作成功';
$LANG['batch_handle_ok_move'] = '批量转移操作成功';

/*JS 语言项*/
$LANG['js_languages']['no_title'] = '没有文章标题';
$LANG['js_languages']['no_cat'] = '没有选择文章分类';
$LANG['js_languages']['not_allow_add'] = '系统保留分类，不允许在该分类添加文章';
$LANG['js_languages']['drop_confirm'] = '您确定要删除文章吗？';

$LANG['all_cat'] = '全部分类';
$LANG['search_article'] = '搜索文章';


/**
 * ECJIA 文章分类字段信息
 */

$LANG['cat_name'] = '文章分类名称';
$LANG['type'] = '分类类型';
$LANG['type_name'][COMMON_CAT] = '普通分类';
$LANG['type_name'][SYSTEM_CAT] = '系统分类';
$LANG['type_name'][INFO_CAT]   = '网店信息';
$LANG['type_name'][UPHELP_CAT] = '帮助分类';
$LANG['type_name'][HELP_CAT]   = '网店帮助';

$LANG['cat_keywords'] = '关键字：';
$LANG['cat_desc'] = '描述';
$LANG['parent_cat'] = '上级分类：';
$LANG['cat_top'] = '顶级分类';
$LANG['not_allow_add'] = '你所选分类不允许添加子分类';
$LANG['not_allow_remove'] = '系统保留分类，不允许删除';
$LANG['is_fullcat'] = '该分类下还有子分类，请先删除其子分类';
$LANG['show_in_nav'] = '是否显示在导航栏';

$LANG['isopen'] = '显示';
$LANG['isclose'] = '不显示';
$LANG['add_article'] = '添加文章';

$LANG['articlecat_edit'] = '编辑文章分类';


/* 提示信息 */
$LANG['catname_exist'] = '分类名 %s 已经存在';
$LANG['parent_id_err'] = '分类名 %s 的父分类不能设置成本身或本身的子分类';
$LANG['back_cat_list'] = '返回分类列表';
$LANG['continue_add'] = '继续添加新分类';
$LANG['catadd_succed'] = '已成功添加';
$LANG['catedit_succed'] = '分类 %s 编辑成功';
$LANG['edit_title_success'] = '文章标题 %s 编辑成功';
$LANG['no_catname'] = '请填入分类名';
$LANG['edit_fail'] = '编辑失败';
$LANG['enter_int'] = '请输入一个整数';
$LANG['not_emptycat'] = '分类下还有文章，不允许删除非空分类';

/*帮助信息*/
$LANG['notice_keywords'] ='关键字为选填项，其目的在于方便外部搜索引擎搜索';
$LANG['notice_isopen'] ='该文章分类是否显示在前台的主导航栏中。';

/*JS 语言项*/
$LANG['js_languages']['no_catname'] = '没有输入分类的名称';
$LANG['js_languages']['sys_hold'] = '系统保留分类，不允许添加子分类';
$LANG['js_languages']['remove_confirm'] = '您确定要删除选定的分类吗？';




/**
 * ECJIA 文章自动发布字段信息
 */
$LANG['id'] = '编号';

$LANG['starttime'] = '发布时间';
$LANG['endtime'] = '取消时间';
$LANG['article_name'] = '文章名称：';
$LANG['articleatolist_name'] = '文章名称';
$LANG['ok'] = '确定';
$LANG['edit_ok'] = '操作成功';
$LANG['edit_error'] = '操作失败';
$LANG['delete'] = '撤销';
$LANG['deleteck'] = '确定删除此文章的自动发布/取消发布处理么?此操作不会影响文章本身';
$LANG['enable_notice'] = '您需要到工具->计划任务中开启该功能后才能使用。';
$LANG['button_start'] = '批量发布';
$LANG['button_end'] = '批量取消发布';

$LANG['no_select_goods'] = '没有选定文章';

$LANG['batch_start_succeed'] = '批量发布成功';
$LANG['batch_end_succeed'] = '批量取消成功';

$LANG['back_list'] = '返回文章自动发布';
$LANG['select_time'] = '请选定时间';

// end