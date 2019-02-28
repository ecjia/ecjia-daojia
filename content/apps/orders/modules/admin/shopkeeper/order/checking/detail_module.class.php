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
 * 掌柜查看验单详情
 * @author zrl
 */
class admin_shopkeeper_order_checking_detail_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        $this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'orders'));
        }

        $pickup_code = $this->requestData('pickup_code');

        if (empty($pickup_code)) {
            return new ecjia_error('invalid_parameter', __('参数无效', 'orders'));
        }
        $order = array();

        if (!empty($pickup_code)) {
            /*检查提货验证码*/
            $db_term_meta = RC_DB::table('term_meta');
            $db_term_meta->where('object_type', 'ecjia.order')->where('object_group', 'order')->where('meta_key', 'receipt_verification')->where('meta_value', $pickup_code);
            $order_count = $db_term_meta->count();
            if ($order_count > 1) {
                return new ecjia_error('pickup_code_repeat', __('验证码重复，请与管理员联系！', 'orders'));
            }

            $pickup_code_info = $db_term_meta->first();

            if (empty($pickup_code_info['object_id']) || empty($pickup_code_info['meta_value'])) {
                return new ecjia_error('pickup_code_error', __('验证码错误！', 'orders'));
            }

            /* 查询订单信息 */
            $order_info = RC_Api::api('orders', 'order_info', array('order_id' => $pickup_code_info['object_id'], 'order_sn' => ''));

            if (empty($order_info)) {
                return new ecjia_error('order_not_exist', __('该验证码对应的订单信息不存在！', 'orders'));
            }
            if (is_ecjia_error($order_info)) {
                return $order_info;
            }
            if ($order_info['store_id'] != $_SESSION['store_id']) {
                return new ecjia_error('order_info_error', __('该验证码对应的订单不属于当前商家！', 'orders'));
            }

            /* 判断发货情况*/
            //if ($order_info['shipping_status'] > SS_UNSHIPPED) {
            //	return new ecjia_error('order_already_checked', '该验证码对应的订单已验证提货了！');
            //}

            if ($order_info['order_status'] == OS_CANCELED || $order_info['order_status'] == OS_INVALID) {
                return new ecjia_error('vinvalid_order', __('验证码对应的订单已取消或是无效订单！', 'orders'));
            }

            $user_info = RC_DB::table('users')->where('user_id', $order_info['user_id'])->select('user_name', 'mobile_phone')->first();
            $total_fee = $order_info['goods_amount']
                + $order_info['tax']
                + $order_info['shipping_fee']
                + $order_info['insure_fee']
                + $order_info['pay_fee']
                + $order_info['pack_fee']
                + $order_info['card_fee']
                - $order_info['integral_money']
                - $order_info['bonus']
                - $order_info['discount'];

            $pickup_status = $order_info['shipping_status'] > SS_UNSHIPPED ? 1 : 0;
            $goods_list    = array();
            $goods_item    = RC_DB::table('order_goods as og')->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
                ->where(RC_DB::raw('og.order_id'), $order_info['order_id'])
                ->select(RC_DB::raw('og.*'), RC_DB::raw('g.goods_thumb'), RC_DB::raw('g.goods_img'), RC_DB::raw('g.original_img'))->get();


            if (!empty($goods_item)) {
                foreach ($goods_item as $row) {
                    $subtotal     = $row['goods_number'] * $row['goods_price'];
                    $goods_list[] = array(
                        'goods_id'          => $row['goods_id'],
                        'goods_name'        => $row['goods_name'],
                        'goods_attr_id'     => empty($row['goods_attr_id']) ? '' : $row['goods_attr_id'],
                        'goods_attr'        => empty($row['goods_attr']) ? '' : $row['goods_attr'],
                        'goods_number'      => $row['goods_number'],
                        'subtotal'          => $subtotal,
                        'formated_subtotal' => price_format($subtotal),
                        'img'               => array(
                            'small' => !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : '',
                            'thumb' => !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : '',
                            'url'   => !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : '',
                        )
                    );
                }
            }

            $order = array(
                'order_id'                => $order_info['order_id'],
                'store_id'                => $order_info['store_id'],
                'order_sn'                => $order_info['order_sn'],
                'user_name'               => empty($user_info['user_name']) ? '' : $user_info['user_name'],
                'mobile'                  => empty($user_info['mobile_phone']) ? '' : $user_info['mobile_phone'],
                'goods_amount'            => $order_info['goods_amount'],
                'formated_goods_amount'   => price_format($order_info['goods_amount']),
                'money_paid'              => $order_info['money_paid'],
                'formated_money_paid'     => price_format($order_info['money_paid']),
                'total_fee'               => $total_fee,
                'formated_total_fee'      => price_format($total_fee),
                'integral_money'          => $order_info['integral_money'],
                'formated_integral_money' => price_format($order_info['integral_money']),
                'bonus'                   => $order_info['bonus'],
                'formated_bonus'          => price_format($order_info['bonus']),
                'tax'                     => $order_info['tax'],
                'formated_tax'            => price_format($order_info['tax']),
                'discount'                => $order_info['discount'],
                'formated_discount'       => price_format($order_info['discount']),
                'formated_add_time'       => RC_Time::local_date(ecjia::config('time_format'), $order_info['add_time']),
                'pickup_code'             => $pickup_code_info['meta_value'],
                'pickup_status'           => $pickup_status,
                'label_pickup_status'     => $pickup_status == 1 ? __('已提取', 'orders') : __('未提取', 'orders'),
                'goods_list'              => $goods_list,
            );
        }


        return $order;
    }
}

// end