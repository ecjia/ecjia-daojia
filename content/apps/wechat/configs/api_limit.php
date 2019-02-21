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
 * 公众号调用接口每日限制
 */
return array(
	/*获取接口调用凭据*/
	'token' => array(
		'title' => __('获取access_token', 'wechat'),
	    'times' => '2000',
	    'api'   => 'https://api.weixin.qq.com/cgi-bin/token'
	),
	'getcallbackip' => array(
		'title' => __('获取微信服务器IP地址', 'wechat'),
		'times' => null,
		'api'   => 'https://api.weixin.qq.com/cgi-bin/getcallbackip'
	),

	/*自定义菜单*/
    'menu/create' => array(
    	'title' => __('自定义菜单创建', 'wechat'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/create'
    ),
    'menu/get' => array(
    	'title' => __('自定义菜单查询', 'wechat'),
        'times' => '10000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/get'
    ),
    'menu/delete' => array(
    	'title' => __('自定义菜单删除', 'wechat'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/delete'
    ),
	'menu/addconditional' => array(
		'title' => __('创建个性化菜单', 'wechat'),
		'times' => '2000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/addconditional'
	),
	'menu/delconditional' => array(
		'title' => __('删除个性化菜单', 'wechat'),
		'times' => '2000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/delconditional'
	),
	'menu/trymatch' => array(
		'title' => __('测试个性化菜单匹配结果', 'wechat'),
		'times' => '20000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/trymatch'
	),
	'get_current_selfmenu_info' => array(
		'title' => __('获取自定义菜单配置', 'wechat'),
		'times' => null,
		'api'   => 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info'
	),

	/*粉丝管理*/
    'groups/create' => array(
    	'title' => __('创建用户分组', 'wechat'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/create'
    ),
    'groups/get' => array(
        'title' => __('获取用户分组', 'wechat'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/get'
    ),
	'groups/getid' => array(
		'title' => __('查询用户所在分组', 'wechat'),
		'times' => null,
		'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/getid'
	),
    'groups/update' => array(
        'title' => __('修改用户分组名', 'wechat'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/update'
    ),
    'groups/members/update' => array(
        'title' => __('移动用户分组', 'wechat'),
        'times' => '100000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/members/update'
    ),
    'groups/members/batchupdate' => array(
    	'title' => __('批量移动用户分组', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate'
    ),
    'groups/delete' => array(
    	'title' => __('删除用户分组', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/delete'
    ),
    'user/info/updateremark' => array(
    	'title' => __('设置用户备注名', 'wechat'),
    	'times' => '10000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark'
    ),
    'user/info' => array(
    	'title' => __('获取用户信息', 'wechat'),
    	'times' => '5000000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info'
    ),
    'user/info/batchget' => array(
    	'title' => __('批量获取用户基本信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info/batchget'
    ),
    'user/get' => array(
    	'title' => __('获取关注者列表', 'wechat'),
    	'times' => '500',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/get'
    ),
    'tags/create' => array(
    	'title' => __('创建标签', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/create'
    ),
    'tags/get' => array(
	    'title' => __('获取公众号已创建的标签', 'wechat'),
	    'times' => null,
	    'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/get'
    ),
    'tags/update' => array(
    	'title' => __('编辑标签', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/update'
    ),
    'tags/delete' => array(
    	'title' => __('删除标签', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/delete'
    ),
    'tags/getidlist' => array(
    	'title' => __('获取用户身上的标签列表', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/getidlist'
    ),
    'tags/members/batchtagging' => array(
    	'title' => __('批量为用户打标签', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging'
    ),
    'tags/members/batchuntagging' => array(
    	'title' => __('批量为用户取消标签', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging'
    ),

    /*发送消息*/
    'customservice/kfaccount/add' => array(
    	'title' => __('添加客服帐号', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/customservice/kfaccount/add'
    ),
    'customservice/kfaccount/update' => array(
    	'title' => __('修改客服帐号', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/customservice/kfaccount/update'
    ),
    'customservice/kfaccount/del' => array(
    	'title' => __('删除客服帐号', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/customservice/kfaccount/del'
    ),
    'customservice/kfaccount/uploadheadimg' => array(
    	'title' => __('设置客服帐号的头像', 'wechat'),
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg'
    ),
    'customservice/getkflist' => array(
    	'title' => __('获取所有客服账号', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist'
    ),
    'customservice/getonlinekflist' => array(
    	'title' => __('获取在线客服接待信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist'
    ),
    'customservice/kfaccount/inviteworker' => array(
    	'title' => __('邀请绑定客服帐号', 'wechat'),
    	'times' => null,
    	'api' 	=> 'https://api.weixin.qq.com/cgi-bin/customservice/kfaccount/inviteworker'
    ),
    'message/custom/send' => array(
        'title' => __('发送客服消息', 'wechat'),
        'times' => '500000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/message/custom/send'
    ),
    'message/mass/sendall' => array(
    	'title' => __('根据分组进行群发', 'wechat'),
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall'
    ),
    'message/mass/send' => array(
    	'title' => __('根据OpenID列表群发', 'wechat'),
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/send'
    ),
    'message/mass/delete' => array(
    	'title' => __('删除群发', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/delete'
    ),
    'message/mass/preview' => array(
    	'title' => __('预览消息样式和排版', 'wechat'),
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/preview'
    ),
    'message/mass/get' => array(
    	'title' => __('查询群发消息发送状态', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/get'
    ),
    'template/api_set_industry' => array(
    	'title' => __('设置所属行业', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry'
    ),
    'template/api_add_template' => array(
    	'title' => __('获得模板ID', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/template/api_add_template'
    ),
    'message/template/send' => array(
    	'title' => __('发送模板消息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/template/send'
    ),
    'get_current_autoreply_info' => array(
    	'title' => __('获取自动回复规则', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info'
    ),

    /*素材管理*/
    'material/add_news' => array(
    	'title' => __('新增永久图文素材', 'wechat'),
    	'times' => '5000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/add_news'
    ),
    'material/add_material' => array(
    	'title' => __('新增其他类型永久素材', 'wechat'),
    	'times' => '1000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/add_material'
    ),
    'material/get_material' => array(
    	'title' => __('获取永久素材', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/get_material'
    ),
    'material/del_material' => array(
    	'title' => __('删除永久素材', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/del_material'
    ),
    'material/update_news' => array(
    	'title' => __('修改永久图文素材', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/update_news'
    ),
    'material/get_materialcount' => array(
    	'title' => __('获取素材总数', 'wechat'),
    	'times' => null, //图片和图文消息素材（包括单图文和多图文）的总数上限为5000，其他素材的总数上限为1000
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount'
    ),
    'material/batchget_material' => array(
    	'title' => __('获取素材列表', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/batchget_material'
    ),

    /*账号管理*/
    'qrcode/create' => array(
        'title' => __('创建二维码ticket', 'wechat'),
        'times' => '100000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/qrcode/create'
    ),
    'showqrcode' => array(
    	'title' => __('通过ticket换取二维码', 'wechat'),
    	'times' => null,
    	'api'   => 'https://mp.weixin.qq.com/cgi-bin/showqrcode'
    ),
    'shorturl' => array(
    	'title' => __('长链接转短链接', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/shorturl'
    ),

    /*数据统计*/
    'datacube/getusersummary' => array(
    	'title' => __('获取用户增减数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusersummary'
    ),
    'datacube/getusercumulate' => array(
    	'title' => __('获取累计用户数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusercumulate'
    ),
    'datacube/getarticlesummary' => array(
    	'title' => __('获取图文群发每日数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getarticlesummary'
    ),
    'datacube/getarticletotal' => array(
    	'title' => __('获取图文群发总数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getarticletotal'
    ),
    'datacube/getuserread' => array(
    	'title' => __('获取图文统计数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getuserread'
    ),
    'datacube/getuserreadhour' => array(
    	'title' => __('获取图文统计分时数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getuserreadhour'
    ),
    'datacube/getusershare' => array(
    	'title' => __('获取图文分享转发数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusershare'
    ),
    'datacube/getusersharehour' => array(
    	'title' => __('获取图文分享转发分时数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusersharehour'
    ),

    /*微信JS-SDK*/
    'ticket/getticket' => array(
    	'title' => __('获取api_ticket', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/ticket/getticket'
    ),

    /*微信门店*/
    'media/uploadimg' => array(
    	'title' => __('上传门店图片', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/media/uploadimg'
    ),
    'poi/addpoi' => array(
    	'title' => __('创建门店', 'wechat'),
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/addpoi'
    ),
    'poi/getpoi' => array(
    	'title' => __('查询门店信息', 'wechat'),
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/getpoi'
    ),
    'poi/getpoilist' => array(
   		'title' => __('查询门店列表', 'wechat'),
   		'times' => null,
   		'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/getpoilist'
    ),
    'poi/updatepoi' => array(
   		'title' => __('修改门店服务信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/updatepoi'
    ),
    'poi/delpoi' => array(
   		'title' => __('删除门店', 'wechat'),
   		'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/delpoi'
    ),
    'poi/getwxcategory' => array(
    	'title' => __('门店类目表', 'wechat'),
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/getwxcategory'
    ),

    /*微信智能接口*/
    'semantic/semproxy/search' => array(
    	'title' => __('发送语义理解请求', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/semantic/semproxy/search'
    ),

  	/*微信摇一摇周边*/
    'account/register' => array(
    	'title' => __('申请开通摇一摇周边', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/account/register'
    ),
    'device/applyid' => array(
    	'title' => __('申请设备ID', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/applyid'
    ),
    'device/applystatus' => array(
    	'title' => __('查询设备ID申请审核状态', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/applystatus'
    ),
    'device/update' => array(
    	'title' => __('编辑设备信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/update'
    ),
    'device/bindlocation' => array(
    	'title' => __('配置设备与门店的关联关系', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/bindlocation'
    ),
    'device/search' => array(
    	'title' => __('查询设备列表', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/search'
    ),
    'page/add' => array(
    	'title' => __('新增页面', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/add'
    ),
    'page/update' => array(
    	'title' => __('编辑页面信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/update'
    ),
    'page/search' => array(
    	'title' => __('查询页面列表', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/search'
    ),
    'page/delete' => array(
    	'title' => __('删除页面', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/delete'
    ),
    'material/add' => array(
    	'title' => __('上传图片素材', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/material/add'
    ),
    'device/bindpage' => array(
    	'title' => __('配置设备与页面的关联关系', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/bindpage'
    ),
    'relation/search' => array(
    	'title' => __('查询设备与页面的关联关系', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/relation/search'
    ),
    'user/getshakeinfo' => array(
    	'title' => __('获取摇周边的设备及用户信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/user/getshakeinfo'
    ),
    'statistics/device' => array(
    	'title' => __('以设备为维度的数据统计', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/device'
    ),
    'statistics/devicelist' => array(
    	'title' => __('批量查询设备统计数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/devicelist'
    ),
    'statistics/page' => array(
    	'title' => __('以页面为维度的数据统计', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/page'
    ),
    'statistics/pagelist' => array(
    	'title' => __('批量查询页面统计数据', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/pagelist'
    ),
    'lottery/addlotteryinfo' => array(
    	'title' => __('创建红包活动', 'wechat'),
    	'times' => null,
    	'api'   => ' https://api.weixin.qq.com/shakearound/lottery/addlotteryinfo'
    ),
    'lottery/setprizebucket' => array(
    	'title' => __('录入红包信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/setprizebucket'
    ),
    'lottery/setlotteryswitch' => array(
    	'title' => __('设置红包活动抽奖开关', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/setlotteryswitch'
    ),
    'lottery/querylottery' => array(
    	'title' => __('红包查询', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/querylottery'
    ),
    'device/group/add' => array(
    	'title' => __('新增设备分组', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/add'
    ),
    'device/group/update' => array(
    	'title' => __('编辑设备分组信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/update'
    ),
    'device/group/delete' => array(
    	'title' => __('删除设备分组', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/delete'
    ),
    'device/group/getlist' => array(
    	'title' => __('查询设备分组列表', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/getlist'
    ),
    'device/group/getdetail' => array(
    	'title' => __('查询设备分组详情', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/getdetail'
    ),
    'device/group/adddevice' => array(
    	'title' => __('添加设备到设备分组', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/adddevice'
    ),
    'device/group/deletedevice' => array(
    	'title' => __('从设备分组中移除设备', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/deletedevice'
    ),
    'openplugin/token' => array(
    	'title' => __('第三方平台获取开插件wifi_token', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/openplugin/token'
    ),

    /*微信连Wi-Fi*/
    'shop/list' => array(
    	'title' => __('获取WiFi门店列表', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/list'
    ),
    'shop/get' => array(
    	'title' => __('查询门店的WiFi信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/get'
    ),
    'shop/update' => array(
    	'title' => __('修改门店网络信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/update'
    ),
    'shop/clean' => array(
    	'title' => __('清空门店网络及设备', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/clean'
    ),
    'device/add' => array(
    	'title' => __('添加密码型Wi-Fi设备', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/add'
    ),
    'device/list' => array(
    	'title' => __('查询Wi-Fi设备', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/list'
    ),
    'device/delete' => array(
    	'title' => __('删除Wi-Fi设备', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/delete'
    ),
    'qrcode/get' => array(
    	'title' => __('获取物料二维码', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/qrcode/get'
    ),
    'account/get_connecturl' => array(
    	'title' => __('获取公众号连网URL', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/account/get_connecturl'
    ),
    'homepage/set' => array(
    	'title' => __('设置商家主页', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/homepage/set'
    ),
    'homepage/get' => array(
    	'title' => __('查询商家主页', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/homepage/get'
    ),
    'bar/set' => array(
    	'title' => __('设置顶部常驻入口文案', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/bar/set'
    ),
    'statistics/list' => array(
    	'title' => __('Wi-Fi数据统计', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/statistics/list'
    ),

    /*微信扫一扫*/
    'merchantinfo/get' => array(
    	'title' => __('获取商户信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/merchantinfo/get'
    ),
    'product/create' => array(
    	'title' => __('创建商品', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/create'
    ),
    'product/modstatus' => array(
    	'title' => __('提交审核/取消发布商品', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/modstatus'
    ),
    'testwhitelist/set' => array(
    	'title' => __('设置测试人员白名单', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/testwhitelist/set'
    ),
    'product/getqrcode' => array(
    	'title' => __('获取商品二维码', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/getqrcode'
    ),
    'product/get' => array(
    	'title' => __('查询商品信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/get'
    ),
    'product/getlist' => array(
    	'title' => __('批量查询商品信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/getlist'
    ),
    'product/update' => array(
    	'title' => __('更新商品信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/update'
    ),
    'product/clear' => array(
    	'title' => __('清除商品信息', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/clear'
    ),
    'scanticket/check' => array(
    	'title' => __('检查wxticket参数', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/scanticket/check'
    ),
    'sns/oauth2/access_token' => array(
        'title' => __('获取网页授权access_token', 'wechat'),
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/oauth2/access_token'
    ),
    'sns/oauth2/refresh_token' => array(
        'title' => __('刷新网页授权access_token', 'wechat'),
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/oauth2/refresh_token'
    ),
    'sns/userinfo' => array(
        'title' => __('网页授权获取用户信息', 'wechat'),
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/userinfo'
    ),
    'sns/auth' => array(
    	'title' => __('检验授权凭证（access_token）是否有效', 'wechat'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/sns/auth'
    ),
);

//end