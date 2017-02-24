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
 * ECJIA 管理中心优惠活动语言文件
 */
/* menu */
$LANG['favourable_list']            = '优惠活动列表';
$LANG['add_favourable']             = '添加优惠活动';
$LANG['edit_favourable']            = '编辑优惠活动';
$LANG['favourable_log']             = '优惠活动出价记录';
$LANG['continue_add_favourable']    = '继续添加优惠活动';
$LANG['back_favourable_list']       = '返回优惠活动列表';
$LANG['add_favourable_ok']          = '添加优惠活动成功';
$LANG['edit_favourable_ok']         = '编辑优惠活动成功';

/* list */
$LANG['act_is_going']               = '仅显示进行中的活动';
$LANG['act_name']                   = '优惠活动名称';
$LANG['goods_name']                 = '商品名称';
$LANG['start_time']                 = '开始时间';
$LANG['end_time']                   = '结束时间';
$LANG['min_amount']                 = '金额下限';
$LANG['max_amount']                 = '金额上限';
$LANG['favourable_not_exist']       = '您要操作的优惠活动不存在';
$LANG['js_languages']['batch_drop_confirm'] = '您确实要删除选中的优惠活动吗？';
$LANG['batch_drop_ok']              = '批量删除成功';
$LANG['no_record_selected']         = '没有选择记录';

/* info */
$LANG['label_act_name']             = '优惠活动名称：';
$LANG['label_start_time']           = '优惠开始时间：';
$LANG['label_end_time']             = '优惠结束时间：';
$LANG['label_user_rank']            = '享受优惠的会员等级：';
$LANG['not_user']                   = '非会员';
$LANG['label_act_range']            = '优惠范围：';
$LANG['far_all']                    = '全部商品';
$LANG['far_category']               = '以下分类';
$LANG['far_brand']                  = '以下品牌';
$LANG['far_goods']                  = '以下商品';
$LANG['label_search_and_add']       = '搜索并加入优惠范围';
$LANG['js_languages']['all_need_not_search'] = '优惠范围是全部商品，不需要此操作';
$LANG['js_languages']['range_exists']        = '该选项已存在';
$LANG['label_min_amount']       = '金额下限：';
$LANG['label_max_amount']       = '金额上限：';
$LANG['notice_max_amount']      = '0表示没有上限';
$LANG['label_act_type']         = '优惠方式：';
$LANG['notice_act_type']        = '当优惠方式为“享受赠品（特惠品）”时，请输入允许买家选择赠品（特惠品）的最大数量，数量为0表示不限数量；' .
                                  '当优惠方式为“享受现金减免”时，请输入现金减免的金额；' .
                                  '当优惠方式为“享受价格折扣”时，请输入折扣（1－99），如：打9折，就输入90。';
$LANG['fat_goods']              = '享受赠品（特惠品）';
$LANG['fat_price']              = '享受现金减免';
$LANG['fat_discount']           = '享受价格折扣';
$LANG['js_languages']['pls_search'] = '请先搜索';
$LANG['search_result_empty']        = '没有找到相应记录，请重新搜索';
$LANG['label_search_and_add_gift']  = '搜索并加入赠品（特惠品）';
$LANG['js_languages']['price_need_not_search'] = '优惠方式是享受价格折扣，不需要此操作';
$LANG['js_languages']['gift']       = '赠品（特惠品）';
$LANG['js_languages']['price']      = '价格';

$LANG['js_languages']['act_name_not_null']       = '请输入优惠活动名称';
$LANG['js_languages']['min_amount_not_number']   = '金额下限格式不正确（数字）';
$LANG['js_languages']['max_amount_not_number']   = '金额上限格式不正确（数字）';
$LANG['js_languages']['act_type_ext_not_number'] = '优惠方式后面的值不正确（数字）';
$LANG['js_languages']['amount_invalid']          = '金额上限小于金额下限。';
$LANG['js_languages']['start_lt_end']            = '优惠开始时间不能大于结束时间';

/* post */
$LANG['pls_set_user_rank'] = '请设置享受优惠的会员等级';
$LANG['pls_set_act_range'] = '请设置优惠范围';
$LANG['amount_error']      = '金额下限不能大于金额上限';
$LANG['act_name_exists']   = '该优惠活动名称已存在，请您换一个';

$LANG['nolimit']           = '没有限制';

//end