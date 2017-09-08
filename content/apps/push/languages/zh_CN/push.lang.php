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
 * 推送消息语言包
 */
return array(
	//消息配置
	'msg_config'				=> '消息配置',
	'update_config_success'		=> '更新消息配置成功',
	'platform_config'			=> '平台配置',
	'label_app_name'			=> '应用名称：',
	'app_name_help'				=> '仅限于Android应用接收消息通知时提示',
	'label_push_development'	=> '推送环境：',
	'push_development_help'		=> 'App上线运行请务必切换置生产环境',
	'dev_environment'			=> '开发环境',
	'produce_environment'		=> '生产环境',
		
	'label_android_app_key'		=> 'Android App Key：',
	'label_android_app_secret'	=> 'Android App Secret：',
	'label_iphone_app_key'		=> 'iPhone App Key：',
	'label_iphone_app_secret'	=> 'iPhone App Secret：',
	'label_ipad_app_key'		=> 'iPad App Key：',
	'label_ipad_app_secret'		=> 'iPad App Secret：',
	'label_client_order'		=> '客户下单：',
	'client_order_help'			=> '客户下订单时是否给商家推送消息',
	'label_client_pay'			=> '客户付款：',
	'client_pay_help'			=> '客户付款时是否给商家推送消息',
	'label_seller_shipping'		=> '商家发货：',
	'seller_shipping_help'		=> '商家发货时是否给客户推送消息',
	'label_user_register'		=> '用户注册：',
	'user_register_help'		=> '用户注册时是否给客户推送消息',
		
	'push'		=> '推送',
	'not_push'	=> '不推送',
	'resend'	=> '再次推送',
	'push_copy' => '消息复用 ',
	
	//消息事件
	'msg_event'		    => '消息事件',	
	'add_msg_event'     => '添加消息事件',
	'push_event_update'	=> '编辑消息事件',
	'push_event_delete' => '删除消息事件',
	'push_event_code_exists'	    => '消息事件code已存在！',
	'add_push_event_code_success'	=> '添加消息事件code成功！',
	'add_push_event_success'	    => '添加消息事件成功！',
	'edit_msg_event'	            => '编辑消息事件',
	'edit_msg_event_success'	=> '编辑消息事件成功！',
	'remove_msg_event_success'	=> '删除消息事件成功！',
	'msg_event_bind_app_exists'	=> '绑定客户端应用重复！',
	'pls_select_push_event'		=> '请选择推送消息事件',
		
		
	//消息模板
	'msg_template'				=> '消息模板',
	'add_msg_template'			=> '添加消息模板',
	'msg_template_list'			=> '消息模板列表',
	'template_name_exist'		=> '该消息模板的名称已经存在',
	'continue_add_template'		=> '继续添加消息模板',
	'back_template_list'		=> '返回消息模板列表',
	'add_template_success'		=> '添加消息模板成功',
	'edit_msg_template'			=> '编辑消息模板',
	'update_template_success'	=> '更新消息模板成功',
	'remove_template_success'	=> '删除消息模板成功',
		
	'label_msg_template'		=> '消息模板：',
	'label_msg_subject'			=> '消息主题：',
	'label_msg_content'			=> '消息内容：',
	'update'					=> '更新',
		
	'msg_template_name'			=> '消息模板名称',
	'msg_subject'				=> '消息主题',
	'msg_content'				=> '消息内容',
	'remove_template_confirm'	=> '您确定要删除该消息模板吗？',
		
	//消息记录
	'all'		=> '全部',
	'android'	=> 'Android',
	'iphone'	=> 'iPhone',
	'ipad'		=> 'iPad',
	
	'batch'		=> '批量操作',
	
	//删除推送消息
	'remove_msg'			=> '删除消息',
	'remove_msg_confirm'	=> '您确定要删除该条推送消息吗？',
	'empty_select_msg'		=> '请先选中要删除的推送消息',
		
	//再次推送消息
	'resend_msg'			=> '再次推送消息',
	'resend_confirm'		=> '您确定要再次推送该条消息吗？',
	'emtpy_resend_msg' 		=> '请先选中要再次推送的消息',
	'message_not_exists'	=> '此消息不存在！',
		
	//推送消息
	'push_confirm'			=> '您确定要推送该条这条消息吗？',
		
	'select_push_status'	=> '选择推送状态',
	'push_fail'				=> '推送失败',
	'push_success'			=> '推送完成',
	'filter'				=> '筛选',
	'msg_keywords'			=> '请输入消息主题关键字',
	'search'				=> '搜索',
			
	'device_type'			=> '设备类型',
	'push_status'			=> '推送状态',
	'add_time'				=> '添加时间',
	'has_pushed'			=> '该消息已经被推送了',
	'time'					=> '次',
	'label_push_on' 		=> '推送于：',
		
	//发送消息
	'pls_push_app'			=> '请选择推送App！',
	'msg_subject_help'		=> '用于标识消息，方便查找和管理',
	'msg_content_help'		=> '这里是要推送的消息内容',
	'push_behavior'			=> '推送行为',
	'label_open_action'		=> '打开动作：',
		
	'nothing'		=> '无',
	'main_page'		=> '主页',
	'singin'		=> '登录',
	'signup'		=> '注册',
	'forget_password' => '忘记密码',
	'discover'		=> '发现',
	'qrcode'		=> '二维码扫描',
	'qrshare'		=> '二维码分享',
	'history'		=> '浏览记录',
	'feedback'		=> '咨询',
	'map'			=> '地图',
	'message_center'=> '消息中心',
	'webview'		=> '内置浏览器',
	'setting'		=> '设置',
	'language'		=> '语言选择',
	'cart'			=> '购物车',
	'help'			=> '帮助中心',
	'goods_list'	=> '商品列表',
	'goods_comment'	=> '商品评论',
	'goods_detail'	=> '商品详情',
	'orders_list'	=> '我的订单',
	'orders_detail'	=> '订单详情',
	'user_center'	=> '用户中心',
	'user_wallet'	=> '我的钱包',
	'user_collect'	=> '我的关注',
	'user_address'	=> '地址管理',
	'user_account'	=> '账户余额',
	'user_password'	=> '修改密码',
		
	'seller'		=> '店铺街',
	'seller_list'	=> '店铺街列表',
	'merchant'		=> '店铺首页',
	'merchant_goods_list'	=> '店铺内分类商品',
	'merchant_suggest_list'	=> '店铺内活动商品',
	'merchant_detail'	=> '店铺详情',
		
	'label_url'			=> 'URL：',
	'label_keywords'	=> '关键字：',
	'lable_category_id' => '商品分类ID：',
	'label_goods_id'	=> '商品ID：',
	'label_order_id'	=> '订单ID：',
	'label_seller_category' => '店铺街分类ID：',
	'label_merchant_id' => '店铺ID：',
	'label_suggest_type' => '活动类型：',
	'suggest_type_help'	=> '（best：精品推荐，hot：热销商品，new：新品推荐）',
		
	'push_object'		=> '推送对象',
	'label_device_type' => '设备类型：',	
	'pleast_select'		=> '请选择...',
	'device_type_help'	=> '当推送给 “用户” 或者 “管理员” 时，不需要选择设备类型',
	'label_push_to'		=> '推送给：',
	'all_people'		=> '所有人',
	'unicast'			=> '单播',
	'user'				=> '用户',
	'administrator'		=> '管理员',
	'label_device_token'=> 'Device Token：',
	'label_user_id'		=> '用户ID：',
	'label_admin_id'	=> '管理员ID：',
	'push_time'			=> '推送时机',
	'label_send_time'	=> '发送时间：',
	'send_now'			=> '立即发送',
	'send_later'		=> '稍后发送',
		
	'msg_record'		=> '消息记录',
	'add_msg_push'		=> '添加消息推送',
	'msg_record_list'	=> '消息记录列表',
	'msg_push'			=> '消息推送',
		
	'url_required'			=> '请输入网址',
	'keywords_required'		=> '请输入关键字',
	'category_id_required'	=> '请输入商品分类ID',
	'goods_id_required'		=> '请输入商品ID',
	'order_id_required'		=> '请输入订单ID',
	'merchant_id_required'	=> '请输入商家ID',
	'admin_id_required'		=> '请输入管理员ID',
	'suggest_type_error'	=> '活动类型错误',
	'device_info_required'	=> '未找到该用户的Device Token',
	'user_id_required'		=> '请输入用户ID',
	'device_client_required'=> '该用户未绑定移动端设备',
	'device_token_required'	=> '请输入Device Token',
	'device_token_error'	=> '输入Device Token的长度不合法',
	
	'msg_push_success'		=> '消息推送成功',
	'remove_msg_success'	=> '删除消息成功',
	'batch_push_success'	=> '已批量推送完毕',
	'batch_drop_success'	=> '批量删除成功',	
	'invalid_parameter'		=> '参数无效',
		
	//菜单
	'push_msg'				=> '推送消息',
	'send_msg'				=> '发送消息',
		
	'push_history_manage'	=> '消息记录管理',
	'push_event_manage'		=> '消息事件管理',
	'push_template_manage'	=> '消息模板管理',
	'push_template_update'	=> '消息模板更新',
	'push_template_delete'	=> '消息模板删除',
	'push_config_manage'	=> '消息配置管理',
		
	'js_lang' => array(
		'title_required'	=> '请输入消息主题！',
		'content_required'	=> '请输入消息内容！',
		'app_name_required'	=> '请填写应用名称！',
		'sFirst'			=> '首页',
		'sLast' 			=> '尾页',
		'sPrevious'			=> '上一页',
		'sNext'				=> '下一页',
		'sInfo'				=> '共_TOTAL_条记录 第_START_条到第_END_条',
		'sZeroRecords' 		=> '没有找到任何记录',
		'sEmptyTable' 		=> '没有找到任何记录',
		'sInfoEmpty'		=> '共0条记录',
		'sInfoFiltered'		=> '（从_MAX_条数据中检索）',
		'template_required'	=> '消息模板名称不能为空！',
		'subject_required'	=> '消息主题不能为空！',
		'msg_content_required' => '消息内容不能为空！'	,		
	)
);

// end