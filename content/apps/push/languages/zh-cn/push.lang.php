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
 * ECJIA 短信模块语言文件
 */
/* 导航条 */
$LANG['register_sms'] = '注册或启用短信账号';


$LANG['sms_deliver']  = '商家发货通知模板';
$LANG['sms_order']    = '客户下单通知模板';
$LANG['sms_money']    = '客户付款通知模板';

/* 注册和启用短信功能 */
$LANG['email']          = '电子邮箱';
$LANG['password']       = '登录密码';
$LANG['domain']         = '网店域名';
$LANG['register_new']   = '注册新账号';
$LANG['error_tips']     = '请在商店设置->短信设置，先注册短信服务并正确配置短信服务！';
$LANG['enable_old']     = '启用已有账号';

/* 短信特服信息 */
$LANG['sms_user_name']      = '用户名：';
$LANG['sms_password']       = '密码：';
$LANG['sms_domain']         = '域名：';
$LANG['sms_num']            = '短信特服号：';
$LANG['sms_count']          = '发送短信条数：';
$LANG['sms_total_money']    = '总共冲值金额：';
$LANG['sms_balance']        = '余额：';
$LANG['sms_last_request']   = '最后一次请求时间：';
$LANG['disable']            = '注销短信服务';

/* 发送短信 */
$LANG['phone']               = '接收手机号码';
$LANG['user_rand']           = '按用户等级发送短消息';
$LANG['phone_notice']        = '多个手机号码用半角逗号分开';
$LANG['msg']                 = '消息内容';
$LANG['msg_notice']          = '最长70字符';
$LANG['send_date']           = '定时发送时间';
$LANG['send_date_notice']    = '格式为YYYY-MM-DD HH:II。为空表示立即发送。';
$LANG['back_send_history']   = '返回发送历史列表';
$LANG['back_charge_history'] = '返回充值历史列表';

/* 记录查询界面 */
$LANG['start_date']       = '开始日期';
$LANG['date_notice']      = '格式为YYYY-MM-DD。可为空。';
$LANG['end_date']         = '结束日期';
$LANG['page_size']        = '每页显示数量';
$LANG['page_size_notice'] = '可为空，表示每页显示20条记录';
$LANG['page']             = '页数';
$LANG['page_notice']      = '可为空，表示显示1页';
$LANG['charge']           = '请输入您想要充值的金额';

/* 动作确认信息 */
$LANG['history_query_error'] = '对不起，在查询过程中发生错误。';
$LANG['enable_ok']           = '恭喜，您已成功启用短信服务！';
$LANG['enable_error']        = '对不起，您启用短信服务失败。';
$LANG['disable_ok']          = '您已经成功注销短信服务。';
$LANG['disable_error']       = '注销短信服务失败。';
$LANG['register_ok']         = '恭喜，您已成功注册短信服务！';
$LANG['register_error']      = '对不起，您注册短信服务失败。';
$LANG['send_ok']             = '恭喜，您的短信已经成功发送！';
$LANG['send_error']          = '对不起，在发送短信过程中发生错误。';
$LANG['error_no']            = '错误标识';
$LANG['error_msg']           = '错误描述';
$LANG['empty_info']          = '您的短信特服信息为空。';

/* 充值记录 */
$LANG['order_id']   = '订单号';
$LANG['money']      = '充值金额';
$LANG['log_date']   = '充值日期';

/* 发送记录 */
$LANG['sent_phones'] = '发送手机号码';
$LANG['content']     = '发送内容';
$LANG['charge_num']  = '计费条数';
$LANG['sent_date']   = '发送日期';
$LANG['send_status'] = '发送状态';
$LANG['status'][0]   = '失败';
$LANG['status'][1]   = '成功';
$LANG['user_list']   = '全体会员';
$LANG['please_select'] = '请选择会员等级';

/* 提示 */
$LANG['test_now']  = '<span style="color:red;"></span>';
$LANG['msg_price'] = '<span style="color:green;">短信每条0.1元(RMB)</span>';

/* API返回的错误信息 */
//--注册
$LANG['api_errors']['register'][1] = '域名不能为空。';
$LANG['api_errors']['register'][2] = '邮箱填写不正确。';
$LANG['api_errors']['register'][3] = '用户名已存在。';
$LANG['api_errors']['register'][4] = '未知错误。';
$LANG['api_errors']['register'][5] = '接口错误。';
//--获取余额
$LANG['api_errors']['get_balance'][1] = '用户名密码不正确。';
$LANG['api_errors']['get_balance'][2] = '用户被禁用。';
//--发送短信
$LANG['api_errors']['send'][1] = '用户名密码不正确。';
$LANG['api_errors']['send'][2] = '短信内容过长。';
$LANG['api_errors']['send'][3] = '发送日期应大于当前时间。';
$LANG['api_errors']['send'][4] = '错误的号码。';
$LANG['api_errors']['send'][5] = '账户余额不足。';
$LANG['api_errors']['send'][6] = '账户已被停用。';
$LANG['api_errors']['send'][7] = '接口错误。';
//--历史记录
$LANG['api_errors']['get_history'][1] = '用户名密码不正确。';
$LANG['api_errors']['get_history'][2] = '查无记录。';
//--用户验证
$LANG['api_errors']['auth'][1] = '密码错误。';
$LANG['api_errors']['auth'][2] = '用户不存在。';

/* 用户服务器检测到的错误信息 */
$LANG['server_errors'][1] = '注册信息无效。';//ERROR_INVALID_REGISTER_INFO
$LANG['server_errors'][2] = '启用信息无效。';//ERROR_INVALID_ENABLE_INFO
$LANG['server_errors'][3] = '发送的信息有误。';//ERROR_INVALID_SEND_INFO
$LANG['server_errors'][4] = '填写的查询信息有误。';//ERROR_INVALID_HISTORY_QUERY
$LANG['server_errors'][5] = '无效的身份信息。';//ERROR_INVALID_PASSPORT
$LANG['server_errors'][6] = 'URL不对。';//ERROR_INVALID_URL
$LANG['server_errors'][7] = 'HTTP响应体为空。';//ERROR_EMPTY_RESPONSE
$LANG['server_errors'][8] = '无效的XML文件。';//ERROR_INVALID_XML_FILE
$LANG['server_errors'][9] = '无效的节点名字。';//ERROR_INVALID_NODE_NAME
$LANG['server_errors'][10] = '存储失败。';//ERROR_CANT_STORE
$LANG['server_errors'][11] = '短信功能尚未激活。';//ERROR_INVALID_PASSPORT

/* 客户端JS语言项 */
//--注册或启用
$LANG['js_languages']['password_empty_error']   = '密码不能为空。';
$LANG['js_languages']['username_empty_error']   = '用户名不能为空。';
$LANG['js_languages']['username_format_error']  = '用户名格式不对。';
$LANG['js_languages']['domain_empty_error']     = '域名不能为空。';
$LANG['js_languages']['domain_format_error']    = '域名格式不对。';
$LANG['js_languages']['send_empty_error']       = '发送手机号与发送等级至少填写一项！';
//--发送
$LANG['js_languages']['phone_empty_error']      = '请填写手机号。';
$LANG['js_languages']['phone_format_error']     = '手机号码格式不对。';
$LANG['js_languages']['msg_empty_error']        = '请填写消息内容。';
$LANG['js_languages']['send_date_format_error'] = '定时发送时间格式不对。';
//--历史记录
$LANG['js_languages']['start_date_format_error'] = '开始日期格式不对。';
$LANG['js_languages']['end_date_format_error']   = '结束日期格式不对。';
//--充值
$LANG['js_languages']['money_empty_error']  = '请输入您要充值的金额。';
$LANG['js_languages']['money_format_error'] = '金额格式不对。';

//end