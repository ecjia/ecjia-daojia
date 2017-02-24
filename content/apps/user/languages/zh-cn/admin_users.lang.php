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
 * ECJIA 会员管理语言文件
 */
/* 列表页面 */
$LANG['label_user_name'] 						= '会员名称';
$LANG['label_pay_points_gt'] 					= '会员积分大于';
$LANG['label_pay_points_lt'] 					= '会员积分小于';
$LANG['label_rank_name'] 						= '会员等级';
$LANG['all_option'] 							= '所有等级';

$LANG['view_order'] 							= '查看订单';
$LANG['view_deposit'] 							= '查看账目明细';
$LANG['username'] 								= '会员名称';
$LANG['email'] 									= '邮件地址';
$LANG['is_validated'] 							= '是否已验证';
$LANG['reg_date'] 								= '注册日期';
$LANG['button_remove'] 							= '删除会员';
$LANG['users_edit'] 							= '编辑会员账号';
$LANG['goto_list'] 								= '返回会员账号列表';
$LANG['username_empty'] 						= '会员名称不能为空！';

/* 表单相关语言项 */
$LANG['password'] 								= '登录密码';
$LANG['confirm_password'] 						= '确认密码';
$LANG['newpass'] 								= '新密码';
$LANG['question'] 								= '密码提示问题';
$LANG['answer'] 								= '密码提示问题答案';
$LANG['gender'] 								= '性别';
$LANG['birthday'] 								= '出生日期';
$LANG['sex'][0] 								= '保密';
$LANG['sex'][1] 								= '男';
$LANG['sex'][2] 								= '女';
$LANG['pay_points'] 							= '消费积分';
$LANG['rank_points'] 							= '等级积分';
$LANG['user_money'] 							= '可用资金';
$LANG['frozen_money'] 							= '冻结资金';
$LANG['credit_line'] 							= '信用额度';
$LANG['user_rank'] 								= '会员等级';
$LANG['not_special_rank'] 						= '非特殊等级';
$LANG['view_detail_account'] 					= '查看明细';
$LANG['parent_user'] 							= '推荐人';
$LANG['parent_remove'] 							= '脱离推荐关系';
$LANG['affiliate_user'] 						= '推荐会员';
$LANG['show_affiliate_users'] 					= '查看推荐详细名单';
$LANG['show_affiliate_orders'] 					= '查看推荐订单详情';
$LANG['affiliate_lever'] 						= '等级';
$LANG['affiliate_num'] 							= '人数';
$LANG['page_note'] 								= '此列表显示用户推荐的全部会员信息，';
$LANG['how_many_user'] 							= '个会员。';
$LANG['back_note'] 								= '返回会员编辑页面';
$LANG['affiliate_level'] 						= '推荐等级';

$LANG['msn'] 									= 'MSN';
$LANG['qq'] 									= 'QQ';
$LANG['home_phone'] 							= '家庭电话';
$LANG['office_phone'] 							= '办公电话';
$LANG['mobile_phone'] 							= '手机';

$LANG['notice_pay_points'] 						= '消费积分是一种站内货币，允许用户在购物时支付一定比例的积分。';
$LANG['notice_rank_points'] 					= '等级积分是一种累计的积分，系统根据该积分来判定用户的会员等级。';
$LANG['notice_user_money'] 						= '用户在站内预留下的金额';


/* 提示信息 */
$LANG['keep_add'] 								= '继续添加会员！';
$LANG['edit_success'] 							= '编辑成功！';
$LANG['not_empty'] 								= '会员名不为空！';
$LANG['username_exists'] 						= '已经存在一个相同的用户名。';
$LANG['email_exists'] 							= '该邮件地址已经存在。';
$LANG['edit_user_failed'] 						= '修改会员资料失败。';
$LANG['invalid_email'] 							= '输入了非法的邮件地址。';
$LANG['update_success'] 						= '编辑用户信息已经成功。';
$LANG['still_accounts'] 						= '该会员有余额或欠款\n';
$LANG['remove_confirm'] 						= '您确定要删除该会员账号吗？';
$LANG['list_still_accounts'] 					= '选中的会员账户中仍有余额或欠款\n';
$LANG['list_remove_confirm'] 					= '您确定要删除所有选中的会员账号吗？';
$LANG['remove_order_confirm'] 					= '该会员账号已经有订单存在，删除该会员账号的同时将清除订单数据。<br />您确定要删除吗？';
$LANG['remove_order'] 							= '是，我确定要删除会员账号及其订单数据';
$LANG['remove_cancel'] 							= '不，我不想删除该会员账号了。';
$LANG['remove_success'] 						= '会员账号 %s 已经删除成功。';
$LANG['add_success'] 							= '会员账号 %s 已经添加成功。';
$LANG['batch_remove_success'] 					= '已经成功删除了 %d 个会员账号。';
$LANG['no_select_user'] 						= '您现在没有需要删除的会员！';
$LANG['register_points'] 						= '注册送积分';
$LANG['username_not_allow'] 					= '用户名不允许注册';
$LANG['username_invalid'] 						= '无效的用户名';
$LANG['email_invalid'] 							= '无效的email地址';
$LANG['email_not_allow'] 						= '邮件不允许';

/* 地址列表 */
$LANG['address_list'] 							= '收货地址';
$LANG['consignee'] 								= '收货人';
$LANG['address'] 								= '地址';
$LANG['link'] 									= '联系方式';
$LANG['other'] 									= '其他';
$LANG['tel'] 									= '电话';
$LANG['mobile'] 								= '手机';
$LANG['best_time'] 								= '最佳送货时间';
$LANG['sign_building'] 							= '标志建筑';


/* JS 语言项 */
$LANG['js_languages']['no_username'] 			= '没有输入用户名。';
$LANG['js_languages']['invalid_email'] 			= '没有输入邮件地址或者输入了一个无效的邮件地址。';
$LANG['js_languages']['chinese_password'] 		= '密码不能有中文或非法字符。';
$LANG['js_languages']['no_password'] 			= '没有输入密码。';
$LANG['js_languages']['less_password'] 			= '输入的密码不能少于六位。';
$LANG['js_languages']['passwd_balnk'] 			= '密码中不能包含空格 。';
$LANG['js_languages']['no_confirm_password'] 	= '没有输入确认密码。';
$LANG['js_languages']['password_not_same'] 		= '确认密码和输入的密码不一致。';
$LANG['js_languages']['invalid_pay_points'] 	= '消费积分数不是一个整数。';
$LANG['js_languages']['invalid_rank_points'] 	= '等级积分数不是一个整数。';
$LANG['js_languages']['password_len_err'] 		= '密码和确认密码的长度不能小于6 。';
$LANG['js_languages']['credit_line'] 			= '信用额度不为空且为数值类型 。';

// end