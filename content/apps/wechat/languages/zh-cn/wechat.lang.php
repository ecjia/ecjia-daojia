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

$LANG['num_order']      = '编号';
$LANG['wechat']         = '公众平台';
$LANG['wechat_number']  = '微信号';
$LANG['errcode']        = '错误代码：';
$LANG['errmsg']         = '错误信息：';

//公众平台
$LANG['wechat_num']         = '公众平台帐号';
$LANG['wechat_name']        = '公众号名称';
$LANG['wechat_type']        = '公众号类型';
$LANG['wechat_add_time']    = '添加时间';
$LANG['wechat_status']      = '状态';
$LANG['wechat_manage']      = '功能管理';
$LANG['wechat_type0']       = '未认证的公众号';
$LANG['wechat_type1']       = '订阅号';
$LANG['wechat_type2']       = '服务号';
// $LANG['wechat_type3'] = '认证服务号';
// $LANG['wechat_type4'] = '企业号';
$LANG['wechat_type3']       = '测试帐号';
$LANG['wechat_open']        = '开启';
$LANG['wechat_close']       = '关闭';
$LANG['wechat_register']    = '暂时还没有公众号，模板堂邀您尝试%s添加一个公众号</a>。';
$LANG['wechat_id']          = '公众号原始id';
$LANG['token']              = 'Token';
$LANG['appid']              = 'AppID';
$LANG['appsecret']          = 'AppSecret';
$LANG['wechat_add']         = '新增';
$LANG['wechat_help1']       = '如：ecmoban';
$LANG['wechat_help2']       = '请认真填写，如：gh_845581623321';
$LANG['wechat_help3']       = '自定义的Token值';
$LANG['wechat_help4']       = '用于自定义菜单等高级功能（订阅号不需要填写）';
$LANG['wechat_help5']       = '认证服务号是指向微信官方交过300元认证费的服务号';
$LANG['must_name']          = '请填写公众号名称';
$LANG['must_id']            = '请填写公众号原始ID';
$LANG['must_token']         = '请填写公众号Token';
$LANG['wechat_empty']       = '公众号不存在';
$LANG['open_wechat']        = '请开启公众号';

//关注用户
$LANG['sub_title']          = '关注用户列表';
$LANG['sub_search']         = '请输入昵称、省、市搜索';
$LANG['sub_headimg']        = '头像';
$LANG['sub_openid']         = '微信用户唯一标识(openid)';
$LANG['sub_nickname']       = '昵称';
$LANG['sub_sex']            = '性别';
$LANG['sub_province']       = '省(直辖市)';
$LANG['sub_city']           = '城市';
$LANG['sub_time']           = '关注时间';
$LANG['sub_move']           = '转移';
$LANG['sub_move_sucess']    = '转移成功';
$LANG['sub_group']          = '所在分组';
$LANG['sub_update_user']    = '更新用户信息';
$LANG['send_custom_message'] = '发送客服消息';
$LANG['custom_message_list'] = '客服消息列表';
$LANG['message_content']    = '消息内容';
$LANG['message_time']       = '发送时间';
$LANG['button_send']        = '发送';
$LANG['select_openid']      = '请选择微信用户';
$LANG['sub_help1']          = '只有48小时内给公众号发送过信息的粉丝才能接收到信息';
$LANG['sub_binduser']       = '绑定用户';

//分组
$LANG['group_sys']          = '同步分组信息';
$LANG['group_title']        = '分组管理';
$LANG['group_num']          = '公众平台中的编号';
$LANG['group_name']         = '分组名称';
$LANG['group_fans']         = '粉丝量';
$LANG['group_add']          = '添加分组';
$LANG['group_edit']         = '编辑分组';
$LANG['group_update']       = '更新';
$LANG['group_move']         = '将选中粉丝转移到分组中';

//菜单
$LANG['menu']               = '微信菜单';
$LANG['menu_add']           = '菜单添加';
$LANG['menu_edit']          = '菜单编辑';
$LANG['menu_name']          = '菜单名称';
$LANG['menu_type']          = '菜单类型';
$LANG['menu_parent']        = '父级菜单';
$LANG['menu_select']        = '请选择菜单';
$LANG['menu_click']         = 'click';
$LANG['menu_view']          = 'view';
$LANG['menu_keyword']       = '菜单关键词';
$LANG['menu_url']           = '外链URL';
$LANG['menu_create']        = '生成自定义菜单';
$LANG['menu_show']          = '显示';
$LANG['menu_select_del']    = '请选择需要删除的菜单';
$LANG['menu_help1']         = '如无特殊需要，这里请不要填写 (如果要实现一键拨号，请填写"tel:您的电话号码")';

//二维码
$LANG['qrcode']             = '二维码';
$LANG['qrcode_scene']       = '应用场景';
$LANG['qrcode_scene_value'] = '应用场景值';
$LANG['qrcode_scene_limit'] = '场景值已存在，请重新填写';
$LANG['qrcode_type']        = '二维码类型';
$LANG['qrcode_function']    = '功能';
$LANG['qrcode_short']       = '临时二维码';
$LANG['qrcode_forever']     = '永久二维码';
$LANG['qrcode_get']         = '获取二维码';
$LANG['qrcode_valid_time']  = '有效时间';
$LANG['qrcode_help1']       = '以秒为单位，最大不超过1800，默认1800（永久二维码无效）';
$LANG['qrcode_help2']       = '临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）';

//图文回复
$LANG['article']            = '图文回复';
$LANG['title']              = '标题';
$LANG['please_upload']      = '请上传图片';
$LANG['content']            = '正文';
$LANG['link_err']           = '链接格式不正确';

//扫码引荐
$LANG['share']              = '扫码引荐';
$LANG['share_name']         = '推荐人';
$LANG['share_userid']       = '推荐人ID';
$LANG['share_account']      = '现金分成';
$LANG['scan_num']           = '扫描量';
$LANG['expire_seconds']     = '有效时间';
$LANG['share_help']         = '不填则为无限制';
$LANG['no_limit']           = '无限制';

//end