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
 * ECJia 管理中心配送方式管理语言文件
 */
$LANG['shipping_area_name']      = '配送区域名称';
$LANG['shipping_area_districts'] = '地区列表';
$LANG['shipping_area_regions']   = '所辖地区';
$LANG['shipping_area_assign']    = '配送方式';
$LANG['area_region']             = '地区';
$LANG['removed_region']          = '该区域已被移除';
$LANG['area_shipping']           = '配送方式';
$LANG['fee_compute_mode']        = '费用计算方式';
$LANG['fee_by_weight']           = '按重量计算';
$LANG['fee_by_number']           = '按商品件数计算';
$LANG['new_area']                = '新建配送区域';
$LANG['label_country']           = '国家：';
$LANG['label_province']          = '省份：';
$LANG['label_city']              = '城市：';
$LANG['label_district']          = '区/县：';

$LANG['batch']                  = '批量操作';
$LANG['batch_delete']           = '批量删除操作';
$LANG['batch_no_select_falid']  = '未选中元素，批量删除操作失败';
$LANG['delete_selected']        = '移除选定的配送区域';
$LANG['btn_add_region']         = '添加选定地区';
$LANG['free_money']             = '免费额度：';
$LANG['pay_fee']                = '货到付款支付费用：';
$LANG['edit_area']              = '编辑配送区域';

$LANG['add_continue']           = '继续添加配送区域';
$LANG['back_list']              = '返回列表页';
$LANG['empty_regions']          = '当前区域下没有任何关联地区';

/* 提示信息 */
$LANG['repeat_area_name']       = '已经存在一个同名的配送区域。';
$LANG['not_find_plugin']        = '没有找到指定的配送方式的插件。';
$LANG['remove_confirm']         = '您确定要删除选定的配送区域吗？';
$LANG['remove_success']         = '指定的配送区域已经删除成功！';
$LANG['no_shippings']           = '没有找到任何可用的配送方式。';
$LANG['add_area_success']       = '添加配送区域成功。';
$LANG['edit_area_success']      = '编辑配送区域成功。';
$LANG['disable_shipping_success'] = '指定的配送方式已经从该配送区域中移除。';

/* 需要用到的JS语言项 */
$LANG['js_languages']['no_area_name']        = '配送区域名称不能为空。';
$LANG['js_languages']['del_shipping_area']   = '请先删除该配送区域，然后重新添加。';
$LANG['js_languages']['invalid_free_mondy']  = '免费额度不能为空且必须是一个整数。';
$LANG['js_languages']['blank_shipping_area'] = '配送区域的所辖区域不能为空。';
$LANG['js_languages']['lang_remove']         = '移除';
$LANG['js_languages']['lang_remove_confirm'] = '您确定要移除该地区吗？';
$LANG['js_languages']['lang_disabled']       = '禁用';
$LANG['js_languages']['lang_enabled']        = '启用';
$LANG['js_languages']['lang_setup']          = '设置';
$LANG['js_languages']['lang_region']         = '地区';
$LANG['js_languages']['lang_shipping']       = '配送方式';
$LANG['js_languages']['region_exists']       = '选定的地区已经存在。';

// end