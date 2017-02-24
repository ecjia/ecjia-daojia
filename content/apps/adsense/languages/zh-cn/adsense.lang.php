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
/* 广告位置字段信息 */
$LANG['position_name'] = '广告位名称';
$LANG['ad_width'] = '广告位宽度';
$LANG['ad_height'] = '广告位高度';
$LANG['position_desc'] = '广告位描述';
$LANG['posit_width'] = '位置宽度';
$LANG['posit_height'] = '位置高度';
$LANG['posit_style'] = '广告位模板';
$LANG['outside_posit'] = '站外广告';
$LANG['outside_address'] = '投放广告的站点名称：';
$LANG['copy_js_code'] = '复制JS代码';
$LANG['adsense_code'] = '站外投放的JS代码';
$LANG['label_charset'] = '选择编码：';

$LANG['no_position'] = '您还没有设置广告位置';
$LANG['no_ads'] = '您还没有添加广告';
$LANG['unit_px'] = '像素';
$LANG['ad_content'] = '广告内容';
$LANG['width_and_height'] = '(宽*高)';

$LANG['position_name_empty'] = '广告位名称不能为空！';
$LANG['ad_width_empty'] = '广告位宽度不能为空！';
$LANG['ad_height_empty'] = '广告位高度不能为空！';
$LANG['position_desc_empty'] = '广告位描述不能为空！';

$LANG['view_static'] = '查看统计信息';
$LANG['add_js_code'] = '生成并复制JS代码';
$LANG['position_add'] = '添加广告位';
$LANG['position_edit'] = '编辑广告位';
$LANG['posit_name_exist'] = '此广告位已经存在了!';
$LANG['download_ad_statistics'] = '下载广告统计报表';

/* JS语言提示 */
$LANG['js_languages']['posit_name_empty'] = '广告位名称不能为空!';
$LANG['js_languages']['ad_width_empty'] = '请输入广告位的宽度!';
$LANG['js_languages']['ad_height_empty'] = '请输入广告位的高度!';
$LANG['js_languages']['ad_width_number'] = '广告位的宽度必须是一个数字!';
$LANG['js_languages']['ad_height_number'] = '广告位的高度必须是一个数字!';
$LANG['js_languages']['no_outside_address'] = '建议您指定该广告所要投放的站点的名称，方便于该广告的来源统计!';

$LANG['js_languages']['width_value'] = '广告位的宽度值必须在1到1024之间!';
$LANG['js_languages']['height_value'] = '广告位的高度值必须在1到1024之间!';
$LANG['width_number'] = '广告位的宽度必须是一个数字!';
$LANG['height_number'] = '广告位的高度必须是一个数字!';
$LANG['width_value'] = '广告位的宽度值必须在1到1024之间!';
$LANG['height_value'] = '广告位的宽度值必须在1到1024之间!';
$LANG['not_del_adposit'] = '该广告位已经有广告存在,不能删除!';

/* 帮助语言项 */
$LANG['position_name_notic'] = '填写广告位置的名称，如：页脚广告，LOGO广告，右侧广告,通栏二_左边部分等等';
$LANG['ad_width_notic'] = '广告位置的宽度,此高度将是广告显示时的宽度,单位为像素';

$LANG['howto_js'] = '如何调用JS代码显示广告';
$LANG['ja_adcode_notic'] = '调用JS广告代码的描述';

/* 广告字段信息 */
$LANG['ad_id'] = '编号';
$LANG['position_id'] = '广告位置';
$LANG['media_type'] = '媒介类型';
$LANG['ad_name'] = '广告名称';
$LANG['ad_link'] = '广告链接';
$LANG['ad_code'] = '广告内容';
$LANG['start_date'] = '开始日期';
$LANG['end_date'] = '结束日期';
$LANG['link_man'] = '广告联系人';
$LANG['link_email'] = '联系人Email';
$LANG['link_phone'] = '联系电话';
$LANG['click_count'] = '点击次数';
$LANG['ads_stats'] = '生成订单';
$LANG['cleck_referer'] = '点击来源';
$LANG['adsense_name'] = '投放的名称';
$LANG['adsense_js_stats'] = '站外投放JS统计';
$LANG['gen_order_amount'] = '产生订单总数';
$LANG['confirm_order'] = '有效订单数';
$LANG['adsense_js_goods'] = '站外JS调用商品';

$LANG['ad_name_empty'] = '广告名称不能为空！';
$LANG['ads_stats_info'] = '广告统计信息';

$LANG['flag'] = '状态';
$LANG['enabled'] = '是否开启';
$LANG['is_enabled'] = '开启';
$LANG['no_enabled'] = '关闭';

$LANG['ads_add'] = '添加广告';
$LANG['ads_edit'] = '编辑广告';
$LANG['edit_success'] = '编辑成功';
$LANG['drop_success'] = '删除成功';
$LANG['back_ads_list'] = '返回广告列表';
$LANG['back_position_list'] = '返回广告位列表';
$LANG['continue_add_ad'] = '继续添加广告';
$LANG['continue_add_position'] = '继续添加广告位';
$LANG['show_ads_template'] = '设置在模板中显示该广告位';

/* 描述信息 */
$LANG['ad_img'] = '图片';
$LANG['ad_flash'] = 'Flash';
$LANG['ad_html'] = '代码';
$LANG['ad_text'] = '文字';

$LANG['upfile_flash'] = 'Flash文件';
$LANG['flash_url'] = 'Flash地址：';
$LANG['upfile_img'] = '广告图片';
$LANG['local_upfile_img'] = '本地上传';
$LANG['img_url'] = '图片地址';
$LANG['enter_code'] = '输入广告代码';

/* JS语言提示 */
$LANG['js_languages']['ad_name_empty'] = '请输入广告名称!';
$LANG['js_languages']['ad_link_empty'] = '请输入广告的链接URL!';
$LANG['js_languages']['ad_text_empty'] = '广告的内容不能为空!';
$LANG['js_languages']['ad_photo_empty'] = '广告的图片不能为空!';
$LANG['js_languages']['ad_flash_empty'] = '广告的flash不能为空!';
$LANG['js_languages']['ad_code_empty'] = '广告的代码不能为空!';
$LANG['js_languages']['empty_position_style'] = '广告位的模版不能为空!';

/* 提示语言项 */
$LANG['upfile_flash_type'] = '上传的Flash文件类型不正确!';
$LANG['ad_code_repeat'] = '广告图片只能是上传的图片文件或者是指定远程的图片';
$LANG['ad_flash_repeat'] = 'Flash广告只能是上传的Flash文件或者是指定远程的Flash文件';
$LANG['ad_name_exist'] = '该广告名称已经存在!';
$LANG['ad_name_notic'] = '广告名称只是作为辨别多个广告条目之用，并不显示在广告中';
$LANG['ad_code_img'] = '上传该广告的图片文件,或者你也可以指定一个远程URL地址为广告的图片';
$LANG['ad_code_flash'] = '上传该广告的Flash文件,或者你也可以指定一个远程的Flash文件';

// end