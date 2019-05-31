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
 * 去发货显示页面
 * @author will
 *
 */
class admin_orders_operate_shipping_detail_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $this->authadminSession();

        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'orders'));
        }

        $result = $this->admin_priv('order_view');

        if (is_ecjia_error($result)) {
            return $result;
        }
        $order_id = $this->requestData('order_id', 0);
        if ($order_id <= 0) {
            return new ecjia_error(101, __('参数错误', 'orders'));
        }

        /*验证订单是否属于此入驻商*/
        if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
            $ru_id_group = RC_Model::model('orders/order_info_model')->where(array('order_id' => $order_id))->group('store_id')->get_field('store_id', true);
            if (count($ru_id_group) > 1 || $ru_id_group[0] != $_SESSION['store_id']) {
                return new ecjia_error('no_authority', __('对不起，您没权限对此订单进行操作！', 'orders'));
            }
        }

        /* 获取订单信息*/
        $order_dbview       = RC_Model::model('orders/order_order_infogoods_viewmodel');
        $order_dbview->view = array(
            'order_goods' => array(
                'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'og',
                'on'    => 'oi.order_id = og.order_id ',
            ),
            'goods'       => array(
                'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'g',
                'on'    => 'og.goods_id = g.goods_id ',
            ),
        );
        $field              = 'oi.order_id, oi.expect_shipping_time, order_sn, consignee, country, province, city, district, street, address, mobile, pay_id, shipping_id, shipping_name, oi.add_time, pay_time, og.rec_id, og.goods_id, og.product_id, og.goods_name, og.goods_price, og.goods_number, og.goods_attr, goods_thumb, goods_img, original_img';
        $order_list         = $order_dbview->join(array('order_goods', 'goods'))->field($field)->where(array('oi.order_id' => $order_id))->select();
        if (empty($order_list)) {
            return new ecjia_error('orders_empty', __('订单信息不存在！', 'orders'));
        }

        /* 获取发货单信息*/
        $delivery_order_dbview = RC_Model::model('orders/delivery_order_viewmodel');
        $delivery_list         = $delivery_order_dbview->join(array('delivery_goods'))->where(array('do.order_id' => $order_id))->select();

        $delivery_info = array();
        foreach ($order_list as $key => $val) {
            /* 首次设置订单信息*/
            if ($key == 0) {
                //收货人地址
                $order['country_id']  = $val['country'];
                $order['province_id'] = $val['province'];
                $order['city_id']     = $val['city'];
                $order['district_id'] = $val['district'];
                $order['street_id']   = $val['street'];

                $order['country']       = ecjia_region::getCountryName($val['country']);
                $order['province']      = ecjia_region::getRegionName($val['province']);
                $order['city']          = ecjia_region::getRegionName($val['city']);
                $order['district']      = ecjia_region::getRegionName($val['district']);
                $order['street']        = ecjia_region::getRegionName($val['street']);
                $order['shipping_code'] = RC_DB::table('shipping')->where('shipping_id', $val['shipping_id'])->pluck('shipping_code');

                $order['pay_code'] = RC_DB::table('payment')->where('pay_id', $val['pay_id'])->pluck('pay_code');


                //期望送达时间
                $expect_shipping_time = trim($val['expect_shipping_time']);
                $expect_shipping_time = explode(" ", $expect_shipping_time);

                $delivery_info = array(
                    'order_id'          => $val['order_id'],
                    'order_sn'          => $val['order_sn'],
                    'consignee'         => $val['consignee'],
                    'country_id'        => $order['country_id'],
                    'province_id'       => $order['province_id'],
                    'city_id'           => $order['city_id'],
                    'district_id'       => $order['district_id'],
                    'street_id'         => $order['street_id'],
                    'country'           => $order['country'],
                    'province'          => $order['province'],
                    'city'              => $order['city'],
                    'district'          => $order['district'],
                    'street'            => $order['street'],
                    'address'           => $val['address'],
                    'mobile'            => $val['mobile'],
                    'shipping_id'       => $val['shipping_id'],
                    'shipping_name'     => $val['shipping_name'],
                    'shipping_code'     => $order['shipping_code'],
                    'pay_code'          => $order['pay_code'],
                    'add_time'          => RC_Time::local_date(ecjia::config('time_format'), $val['add_time']),
                    'pay_time'          => empty($val['pay_time']) ? null : RC_Time::local_date(ecjia::config('time_format'), $val['pay_time']),
                    'deliveryed_number' => 0,
                );

                if ($order['shipping_code'] == 'ship_o2o_express' || $order['shipping_code'] == 'ship_ecjia_express') {

                    $delivery_info['expect_shipping_time'] = array('date' => $expect_shipping_time['0'], 'time' => $expect_shipping_time['1']);
                    $shipping_area_info                    = RC_DB::table('shipping_area')
                        ->where('store_id', $_SESSION['store_id'])
                        ->where('shipping_id', $val['shipping_id'])->first();
                    $shipping_cfg                          = ecjia_shipping::unserializeConfig($shipping_area_info['configure']);

                    /* 获取最后可送的时间（当前时间+需提前下单时间）*/
                    $time = RC_Time::local_date('H:i', RC_Time::gmtime() + $shipping_cfg['last_order_time'] * 60);

                    $ship_date = 0;

                    if (empty($shipping_cfg['ship_days'])) {
                        $shipping_cfg['ship_days'] = 7;
                    }

                    while ($shipping_cfg['ship_days']) {
                        foreach ($shipping_cfg['ship_time'] as $k => $v) {

                            if ($v['end'] > $time || $ship_date > 0) {
                                $delivery_info['shipping_date'][$ship_date]['date']   = RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('+' . $ship_date . ' day'));
                                $delivery_info['shipping_date'][$ship_date]['time'][] = array(
                                    'start_time' => $v['start'],
                                    'end_time'   => $v['end'],
                                );
                            }
                        }

                        $ship_date++;

                        if (count($delivery_info['shipping_date']) >= $shipping_cfg['ship_days']) {
                            break;
                        }
                    }
                    $delivery_info['shipping_date'] = array_merge($delivery_info['shipping_date']);

                }

                /* 判断订单商品的发货情况*/
                if (!empty($delivery_list)) {
                    foreach ($delivery_list as $v) {
                        $delivery_info['deliveryed_number'] += $v['send_number'];
                    }
                }
            }
            /* 设置订单商品信息*/
            $delivery_info['order_goods'][$key] = array(
                'rec_id'       => $val['rec_id'],
                'goods_id'     => $val['goods_id'],
                'goods_name'   => $val['goods_name'],
                'product_id'   => $val['product_id'],
                'goods_price'  => $val['goods_price'],
                'goods_number' => $val['goods_number'],
                'goods_attr'   => trim($val['goods_attr']),
                'img'          => array(
                    'small' => !empty($val['goods_thumb']) ? RC_Upload::upload_url($val['goods_thumb']) : '',
                    'thumb' => !empty($val['goods_img']) ? RC_Upload::upload_url($val['goods_img']) : '',
                    'url'   => !empty($val['original_img']) ? RC_Upload::upload_url($val['original_img']) : '',
                )
            );

            /* 判断订单商品的发货情况*/
            if (!empty($delivery_list)) {
                //发货数量
                $send_number = 0;
                foreach ($delivery_list as $v) {
                    /* 判断是否是同一件货品*/
                    if ($v['goods_id'] == $val['goods_id'] && $v['product_id'] == $val['product_id']) {
                        $send_number += $v['send_number'];
                        /* 如果发货数量等于订单数量，去除已发货的商品*/
                        if ($val['goods_number'] == $send_number) {
                            unset($delivery_info['order_goods'][$key]);
                        } else {
                            $delivery_info['order_goods'][$key]['goods_number'] = $delivery_info['order_goods'][$key]['goods_number'] - $v['send_number'];
                        }
                    }
                }
            }

        }
        $delivery_info['order_goods'] = array_merge($delivery_info['order_goods']);

        return $delivery_info;
    }
}


// end