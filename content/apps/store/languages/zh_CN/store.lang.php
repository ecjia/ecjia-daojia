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
 * ECJIA应用语言包
 * @author songqian
 */
return array(

	//主菜单
	'store_manage'	=> '商家管理',

	//子菜单
	'store_affiliate'=> '入驻商家',
	'preaudit' 		=> '待审核商家',
	'category' 		=> '商家分类',
	'commission' 	=> '佣金结算',
	'percent' 		=> '佣金比例',
	'config' 		=> '后台设置',
	'mobileconfig' 	=> '移动应用设置',

	//商家入驻列列表
	'store'			=>	'入驻商',
	'store_list'	=>	'入驻商列表',
	'id'			=>	'编号',
	'store_update'	=>	'编辑入驻商',
	'store_title'	=>	'店铺名称',
	'store_cat'		=>	'商家分类',
	'sort_order'	=>	'排序',
	'view'			=>	'查看详情',
	'lock'			=>	'锁定',
	'unlock'		=> '解锁',
	'pls_name'		=>	'请输入店铺名称或手机号',
	'serach'		=>	'搜索',


	//待审核商家入驻列表
	'store_preaudit'		=>	'待审核入驻商',
	'store_preaudit_list'	=>	'待审核入驻商列表',
	'check'					=>	'审核',
	'check_view'		    =>	'审核商家',

	//通用
	'sub_update' =>'更新',
	'sub_check'	 =>'处理',
	'store_title_lable' 	=>	'店铺名称：',
	'store_cat_lable' 		=>	'商家分类：',
	'store_keywords_lable' 	=>	'店铺关键词：',
	'lock_lable' 			=>	'是否锁定店铺：',
	'check_lable' 			=>	'审核：',
	'check_no' 				=>	'未通过',
	'check_yes' 			=>	'通过',
	'select_plz'			=>	'请选择……',
	'companyname_lable'		=>	'公司名称：',
	'person_lable'			=>	'法定代表人：',
	'email_lable'			=>	'电子邮箱：',
	'contact_lable'			=>	'联系方式：',
	'lable_contact_lable'	=>	'联系方式',
	'label_province'		=>	'所在省份： ',
	'label_city'			=>	'所在城市： ',
	'label_district'		=>	'所在市区： ',

	'address_lable'			        =>	'通讯地址：',
	'identity_type_lable'			=>	'证件类型：',
	'identity_number_lable'			=>	'证件号码：',
	'identity_pic_front_lable'		=>	'证件正面：',
	'identity_pic_back_lable'		=>	'证件反面：',
	'personhand_identity_pic_lable'	=>	'手持证件：',
	'business_licence_lable'		=>	'营业执照注册号：',
	'business_licence_pic_lable'	=>	'营业执照电子版：',
	'bank_branch_name_lable'		=>	'开户银行支行名称：',
	'bank_name_lable'				=>	'收款银行：',
	'bank_account_number_lable'		=>	'银行账号：',
	'bank_account_name_label'		=>	'账户名称： ',
	'bank_address_lable'			=>	'开户银行支行地址：',
	'remark_lable'		=>	'备注信息：',
	'longitude_lable'	=>	'经度：',
	'latitude_lable'	=>	'纬度：',
	'sort_order_lable'	=>	'排序：',
	'apply_time_lable'	=>	'申请时间：',
	'browse'			=> '浏览',
	'modify'			=> '修改',
	'change_image'		=> '更换图片',
	'file_address'		=> '文件地址：',
	'edit_success' 		=> 	'编辑成功',
	'deal_success'	 	=>	'处理成功',
	'check_success'	 	=>	'审核成功',
	'open'	 	        =>	'开启',
	'close'	 	        =>	'关闭',
	'personal'	        =>	'个人',
	'personal_name'	    =>	'个人名称：',
	'company'	        =>	'企业',
	'no_upload'         =>  '还未上传',
	'apply_time'        =>	'申请时间',
	'person'            =>	'法定代表人',
	'companyname'	    =>	'公司名称',
	'confirm_time'      =>'审核通过时间',
	'del_store_cat_img_ok' =>'删除商家分类图片成功！',
	'anonymous'	        => '匿名用户',
	'set_commission' 	=> '设置佣金',

    'preaudit_list'     => '全部',
	'validate_type'		=>	'入驻类型：',

	'view_staff'		=>	'查看员工',
	'user_ident'		=>	'编号：',
	'employee_number'	=>	'员工编号',
	'main_name'			=>	'姓名：',
	'employee_name'		=>	'员工姓名',
	'nick_name'			=>	'昵称',
	'main_email'		=>	'邮箱：',
	'email'				=>	'邮箱',
	'main_add_time'		=>	'加入时间：',
	'add_time'			=>	'加入时间',
	'main_introduction'	=>	'介绍：',
	'introduction'		=>	'描述',
	'shopowner'			=>	'店长：',
	'mobile'			=>	'联系方式：',

	'people_id'			=>	'身份证',
	'passport'			=>	'护照',
	'hong_kong_and_macao_pass'			=>	'港澳身份证',

    'edit_store'		=>	'编辑商家信息',
	'order_refund' 		=> '订单退款：%s',
    'shipping_not_need' =>	'无需使用配送方式',
    'shipping_time' 	=> '发货时间：',
    'pay_time' 	        => '付款时间：',
    // 日志
    'log_list'	=>'员工日志记录',
	'log_id'	=>'编号',
	'log_name'	=>'操作者',
	'log_time'	=>'操作日期',
    'log_ip'	=>'IP地址',
	'log_info'	=>'操作记录',
    'js_lang'   => array(
			'choose_delet_time' => '请先选择删除日志的时间！',
			'delet_ok_1' 		=> '确定删除',
			'delet_ok_2' 		=> '的日志吗？',
			'ok' 				=> '确定',
			'cancel' 			=> '取消',
	),
	
	'store_lock'   =>'锁定商家',
	'store_check'  =>'审核入驻商'
);

//end
