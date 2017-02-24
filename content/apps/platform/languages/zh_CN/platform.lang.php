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
 * ECJIA 应用语言包
 */
return array(
    /*API*/
    'platform_num_manage'    => '公众号管理',
    'function_extension'     => '功能扩展',
    'about_oracle'           => '命令速查',
    
    'platform_list'          => '公众号列表',
    'platform_add'           => '添加公众号',
    'platform_edit'          => '编辑公众号',
    'platform_del'           => '删除公众号',
    'platform_extend_manage' => '公众号扩展管理',
    'platform_extend_add'    => '公众号扩展添加',
    'platform_extend_edit'   => '公众号扩展编辑',
    'platform_extend_del'    => '公众号扩展删除',
    'function_extension_edit'=> '功能扩展编辑',
    'command_manage'         => '命令管理',
    'command_add'            => '添加命令',
    'command_edit'           => '编辑命令',
    'command_del'            => '删除命令',

    'platform_plug_null_name'=> '公众平台插件名称不能为空',
    'plug_exist'             => '安装的插件已存在',
    
    /*Class*/
    'unidentification_uuid'  => '未识别的UUID',
    'must_root_operation'    => '必须为管理员才可操作',
    
    /*Configs*/
    'platform_weixin'        => '微信公众平台',
    
    /*functions*/
    'platform_num'           => '公众号',
    'platform_num_log'       => '公众号logo',
    'function_extension_command'=> '功能扩展命令',
    'platform_extension'     => '公众号扩展',
    'bulk_add'               => '批量添加',
    'platform_plug'          => '公众平台插件',
    
    /*模板*/
    'lable_command_key'      => '请输入命令关键字：',
    'lable_name'             => '名称：',
    'lable_describe'         => '描述：',
    'lable_external_address' => '外部访问地址：',
    'lable_terrace'          => '平台：',
    'lable_platform_num_type'=> '公众号类型：',
    'platform_num_type'      => '公众号类型',
    'lable_platform_name'    => '公众号名称：',
    'lable_logo'             => 'Logo：',
    'logo'                   => 'Logo',
    'lable_appid'            => 'AppID：',
    'lable_warm_prompt'      => '温馨提示：',
    'click_plug_add'         => '请先点击下方扩展信息框中搜索按钮选择扩展进行添加。',
    'command_key'            => '请输入命令关键字',
    'select_terrace'         => '请选择平台',
    'describe'               => '描述',
    'plug_message'           => '扩展信息',
    'find'                   => '查询',
    'all_platform'           => '所有平台',
    'weixin'                 => '微信',
    'filtrate'               => '筛选',
    'platform_name'          => '公众号名称',
    'plug_name'              => '扩展名称',
    'lable_plug_name'        => '扩展名称：',
    'terrace'                => '平台',
    'keyword'                => '关键词',
    'subcommand'             => '子命令',
    'operation'              => '操作',
    'examine'                => '查看',
    'no_find_record'         => '没有找到任何记录',
    'search'                 => '搜索',
    'update'                 => '更新',
    'plug_num'               => '插件代号',
    'help_command'           => '查看命令',
    'edit'                   => '编辑',
    'edit_deploy'            => '编辑配置',
    'forbidden'              => '禁用',
    'start_using'            => '启用',
    'un_platform_num'        => '未认证的公众号',
    'subscription_num'       => '订阅号',
    'server_num'             => '服务号',
    'test_account'           => '测试账号',
    'weixin_three_hundred'   => '认证服务号是指向微信官方交过300元认证费的服务号',
    'look_picture'           => '图片预览',
    'browse'                 => '浏览',
    'modification'           => '修改',
    'sure_del'               => '您确定要删除吗？',
    'sure_del_command'       => '您确定要该删除命令吗？',
    'delete'                 => '删除',
    'custom_token'           => '自定义的Token值',
    'lable_status'           => '状态：',
    'status'                 => '状态',
    'lable_sort'             => '排序：',
    'sort'                   => '排序',
    'open'                   => '开启',
    'close'                  => '取消',
    'confirm'                => '确定',
    'update'                 => '更新',
    'remove'                 => '移除',
    'add_again'              => '再添加一项',
    'addition'               => '添加',
    'input_plugname_keywords'=> '请输入扩展名称或插件代号关键词',
    'search_plug_message'    => '筛选搜索到的扩展信息',
    'null_content'           => '暂无内容',
    'bulk_operation'         => '批量操作',
    'sure_want_do'           => '您确定要这么做吗？',
    'delete_selected_plat'   => '请先选中要删除的公众号！',
    'input_plat_name_key'    => '请输入公众号名称关键字',
    'add_time'               => '添加时间',
    'edit_plat_sort'         => '编辑公众号排序',
    
    /*控制器*/
    'command_search'	=> '命令速查',
    'summarize'         => '概述',
    'welcome'           => '欢迎访问ECJia智能后台命令速查页面，在此页面可以进行命令快速查询操作。',
    'more_info'         => '更多信息：',
    'public_extend'     => '公众号扩展',
    'command_list'      => '命令列表',
    'welcome_extend'    => '欢迎访问ECJia智能后台公众号扩展命令页面，有关该公众号下该扩展的命令都会显示在此列表中。',
    'keyword_empty'     => '关键词不能为空！',
    'clickmore'         => '请点击再添加一项进行添加！',
    'keyword_notrepeat' => '关键词不能重复！',
    'add_succeed'       => '添加成功',
    
    'keywords_exist'    => '关键词[%s]已存在',
    'public_name_is'    => '公众号名称为 ',
    'extend_name_is'    => '扩展名称为 ',
    'keyword_is'       	=> '关键词为 ',
    
    'edit_succeed'      => '编辑成功',
    'remove_succeed'    => '删除成功',
    'remove_failed'     => '删除失败',
    'function_extend'   => '功能扩展',
    'welcome_command'   => '欢迎访问ECJia智能后台功能扩展命令页面，有关该扩展的命令都会显示在此列表中。',
    'welcome_fun_ext'   => '欢迎访问ECJia智能后台功能扩展页面，系统中所有的功能扩展都会显示在此列表中。',
    
    'edit_function'     => '编辑功能扩展',
    'welcome_fun_edit'  => '欢迎访问ECJia智能后台编辑功能扩展页面，在此页面可以进行编辑功能扩展操作。',
    'edit_fun_succeed'  => '编辑功能扩展成功',
    'plugin'            => '插件',
    'disabled'          => '已停用',
    'enabled'           => '已启用',
    
    'welcome_pub_list'  	=> '欢迎访问ECJia智能后台公众号列表页面，系统中所有的公众号都会显示在此列表中。',
    'welcome_pub_add'   	=> '欢迎访问ECJia智能后台添加公众号页面，在此页面可以进行添加公众号操作。',
    'add_pub_succeed'   	=> '添加公众号成功！',
    'welcome_pub_edit'  	=> '欢迎访问ECJia智能后台编辑公众号页面，在此页面可以进行编辑公众号操作。',
    'edit_pub_succeed'  	=> '编辑公众号成功！',
    'remove_pub_succeed' 	=> '删除公众号成功！',
    'remove_pub_failed' 	=> '删除公众号失败！',
    'switch_succeed'    	=> '切换状态成功！',
    'import_num'        	=> '请输入数值！',
    'editsort_succeed'  	=> '编辑排序成功！',
    'editsort_failed'  	 	=> '编辑排序失败！',
    'pubsort_empty'     	=> '公众号排序不能为空！',
    'welcome_pub_extend' 	=> '欢迎访问ECJia智能后台公众号扩展页面，有关该公众号的扩展都会显示在此列表中。',
    'chosen_extend'     	=> '请先选择扩展！',
    'add_pubext_succeed' 	=> '添加公众号扩展成功！',
    'add_pubext_failed' 	=> '添加公众号扩展失败！',
    
    'edit_pub_extend'   		=> '编辑公众号扩展',
    'welcome_pub_extend_edit' 	=> '欢迎访问ECJia智能后台编辑公共号扩展页面，在此页面可以进行编辑公众号扩展操作。',
    'edit_pub_extend_succeed' 	=> '编辑公众号扩展成功',
    'edit_pub_extend_failed' 	=> '编辑公众号扩展失败',
    'remove_pub_extend_succeed' => '删除公众号扩展成功！',
    'remove_pub_extend_failed'  => '删除公众号扩展失败！',
    'deleted'          	 		=> '本次删除了',
    'record_account'    		=> '条记录！',

    'command_search_help'       => '关于命令速查帮助文档',
    'pub_commandlist_help'      => '关于公众号扩展命令列表帮助文档',
    'extend_commandlist_help'   => '关于功能扩展命令列表帮助文档',
    'function_extend_help'      => '关于功能扩展帮助文档',
    'edit_extend_help'          => '关于编辑功能扩展帮助文档',
    'pub_list_help'             => '关于公众号列表帮助文档',
    'add_pub_help'              => '关于添加公众号帮助文档',
    'edit_pub_help'             => '关于编辑公众号帮助文档',
    'pub_extend_help'           => '关于公众号扩展帮助文档',
    'pub_editext_help'          => '关于公众号编辑扩展帮助文档',
    'exists_public'             => '当前已在【%s】公众号中！',
    'switch_public'             => '正在切换【%s】公众号中，请稍等……',
    
    
    /*JS*/
    'js_lang' => array(
        'platform_name'      => '请输入公众号名称',
        'token'              => '请输入Token',
        'appid'              => '请输入AppID',
        'appsecret'          => '请输入AppSecret',
        'fun_plug_name'      => '请输入功能扩展名称',
        'fun_plug_info'      => '请输入功能扩展描述',
        'search_no_plugin'	 => '未搜索到扩展信息',
    )
);

// end