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
 * 订单列表
 * @author will
 */
class admin_orders_list_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        $this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'orders'));
        }

        $device        = $this->device;
        $device_code   = isset($device['code']) ? $device['code'] : '';
        $device_udid   = isset($device['udid']) ? $device['udid'] : '';
        $device_client = isset($device['client']) ? $device['client'] : '';
        $codes         = config('app-cashier::cashier_device_code');

        if (!in_array($device_code, $codes)) {
            $result = $this->admin_priv('order_view');
            if (is_ecjia_error($result)) {
                return $result;
            }
        }

        $type     = $this->requestData('type', 'whole');
        $keywords = $this->requestData('keywords');
        $user_id  = $this->requestData('user_id', 0);
        $size     = $this->requestData('pagination.count', 15);
        $page     = $this->requestData('pagination.page', 1);

        $start_date = $this->requestData('start_date');
        $end_date   = $this->requestData('end_date');
        $pay_id     = $this->requestData('pay_id', 0);

        if (!empty($start_date) && !empty($end_date)) {
            $start_date = RC_Time::local_strtotime($start_date);
            $end_date   = RC_Time::local_strtotime($end_date) + 86399;
        }

        $order_query = RC_Loader::load_app_class('order_query', 'orders');
        $db          = RC_Model::model('orders/order_info_model');
        $db_view     = RC_Model::model('orders/order_info_viewmodel');

        $where = array();
        if (!empty($keywords)) {
            $where[] = "( oi.order_sn like '%" . $keywords . "%' or oi.consignee like '%" . $keywords . "%' or oi.mobile like '%" . $keywords . "%' )";
        }

        $order_list = [];
        if (!in_array($device_code, $codes) || $user_id > 0) {
            if ($user_id > 0) {
                $where['oi.user_id'] = $user_id;
            }
            switch ($type) {
                case 'await_pay':
                    $where_query = $order_query->order_await_pay('oi.');
                    break;
                case 'payed' :
                    $where_query = $order_query->order_await_ship('oi.');
                    break;
                case 'await_ship':
                    $where_query = $order_query->order_await_ship('oi.');
                    break;
                case 'shipped':
                    $where_query = $order_query->order_shipped('oi.');
                    break;
                case 'finished':
                    $where_query = $order_query->order_finished('oi.');
                    break;
                case 'refund':
                    $where_query = $order_query->order_refund('oi.');
                    break;
                case 'closed' :
                    $where_query = array_merge($order_query->order_invalid('oi.'), $order_query->order_canceled('oi.'));
                    break;
                case 'whole':
                    break;
            }
            if (is_array($where_query)) {
                $where = array_merge($where, $where_query);
            }

            $total_fee = "(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) as total_fee";
            $field     = 'oi.order_id, oi.store_id, oi.order_sn, oi.consignee, oi.mobile, oi.tel, oi.order_status, oi.pay_status, oi.shipping_status, oi.pay_id, oi.pay_name, ' . $total_fee . ', oi.integral_money, oi.bonus, oi.shipping_fee, oi.discount, oi.add_time, oi.integral, oi.money_paid, oi.surplus, oi.order_amount';

            $db_orderinfo_view = RC_Model::model('orders/order_info_viewmodel');
            $result            = ecjia_app::validate_application('store');
            if (!is_ecjia_error($result)) {
                $db_orderinfo_view->view = array(
                    'order_goods' => array(
                        'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                        'alias' => 'og',
                        'on'    => 'oi.order_id = og.order_id'
                    ),
                    'goods'       => array(
                        'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                        'alias' => 'g',
                        'on'    => 'g.goods_id = og.goods_id'
                    ),
                );

                if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
                    $where['oi.store_id'] = $_SESSION['store_id'];
                }

                /*获取记录条数*/
                $record_count = $db_orderinfo_view->join(array('order_goods'))->where($where)->count('DISTINCT oi.order_id');

                //实例化分页
                $page_row   = new ecjia_page($record_count, $size, 6, '', $page);
                $data       = $db_orderinfo_view->field($field)->where($where)->join(null)->limit($page_row->limit())->order(array('oi.add_time' => 'desc'))->select();
                $data       = $this->formated_admin_order_list($data, $device_code, $type);
                $order_list = $data;
            } else {
                $db_orderinfo_view->view = array(
                    'order_goods' => array(
                        'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                        'alias' => 'og',
                        'on'    => 'oi.order_id = og.order_id'
                    ),
                    'goods'       => array(
                        'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                        'alias' => 'g',
                        'on'    => 'g.goods_id = og.goods_id'
                    ),
                );
                /*获取记录条数*/
                $record_count = $db_orderinfo_view->join(null)->where($where)->count('oi.order_id');
                //实例化分页
                $page_row   = new ecjia_page($record_count, $size, 6, '', $page);
                $data       = $db_orderinfo_view->field($field)->join(null)->where($where)->order(array('oi.add_time' => 'desc'))->select();
                $data       = $this->formated_admin_order_list($data, $device_code, $type);
                $order_list = $data;
            }
        } else {

            $db_cashier_record_view       = RC_Model::model('orders/cashier_record_viewmodel');
            $where['cr.mobile_device_id'] = $_SESSION['device_id'];
            //$where['cr.mobile_device_id'] = 5558;

            if (!empty($start_date) && !empty($end_date)) {
                $where['cr.create_at'] = array('egt' => $start_date, 'elt' => $end_date);
            }
            if (!empty($pay_id)) {
                $where['oi.pay_id'] = $pay_id;
            }
            if (!empty($_SESSION['store_id'])) {
                $where['cr.store_id'] = $_SESSION['store_id'];
            }
            $where['cr.action'] = array('billing', 'check_order');
            $join               = array('order_info');

            switch ($type) {
                case 'await_pay':
                    $where_query = $order_query->order_await_pay('oi.');
                    break;
                case 'payed' :
                    $where_query = $order_query->order_await_ship('oi.');
                    break;
                case 'await_ship':
                    $where_query = $order_query->order_await_ship('oi.');
                    break;
                case 'shipped':
                    $where_query = $order_query->order_shipped('oi.');
                    break;
                case 'finished':
                    $where_query = $order_query->order_finished('oi.');
                    break;
                case 'refund':
                    $where_query = $order_query->order_refund('oi.');
                    break;
                case 'closed' :
                    $where_query = array_merge($order_query->order_invalid('oi.'), $order_query->order_canceled('oi.'));
                    break;
                case 'whole':
                    break;
            }

            if ($type == 'verify') {
                $where['cr.action'] = 'check_order'; //验单
                $join               = array('order_info');
            } elseif ($type == 'billing') {
                $where['cr.action'] = 'billing'; //开单
                $join               = array('order_info');
            }

            if ($type != 'verify') {
                if (is_array($where_query)) {
                    $where = array_merge($where, $where_query);
                }
            }

            $record_count = $db_cashier_record_view->join(array('order_info'))->where($where)->count('DISTINCT oi.order_id');

            $page_row       = new ecjia_page($record_count, $size, 6, '', $page);
            $order_id_group = $db_cashier_record_view->join(array('order_info'))->where($where)->limit($page_row->limit())->order(array('create_at' => 'desc'))->field('oi.order_id')->group('oi.order_id')->select();
            $total_fee      = "(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) as total_fee";
            $field          = 'cr.staff_id, oi.order_id, oi.surplus, oi.money_paid, oi.order_amount, oi.store_id, oi.integral, oi.order_sn, oi.consignee, oi.mobile, oi.tel, oi.order_status, oi.pay_status, oi.shipping_status, oi.pay_id, oi.pay_name, ' . $total_fee . ', oi.integral_money, oi.bonus, oi.shipping_fee, oi.discount, oi.add_time';
            $data           = $db_cashier_record_view->field($field)->join($join)->where($where)->limit($page_row->limit())->order(array('cr.create_at' => 'desc'))->group('oi.order_id')->select();
            $data           = $this->formated_admin_order_list($data, $device_code, $type);
            $order_list     = $data;
        }
        $pager = array(
            'total' => $page_row->total_records,
            'count' => $page_row->total_records,
            'more'  => $page_row->total_pages <= $page ? 0 : 1,
        );
        return array('data' => $order_list, 'pager' => $pager);
    }

    /**
     * 订单列表数据处理
     * @param array $data
     * return array
     */
    private function formated_admin_order_list($data = array(), $device_code = '', $type = '')
    {
        $codes = array('8001', '8011');
        if (!empty($data)) {
            $os = array(
                OS_UNCONFIRMED   => __('未接单', 'orders'),
                OS_CONFIRMED     => __('已接单', 'orders'),
                OS_CANCELED      => __('<font color="red">取消</font>', 'orders'),
                OS_INVALID       => __('<font color="red">无效</font>', 'orders'),
                OS_RETURNED      => __('<font color="red">退货</font>', 'orders'),
                OS_SPLITED       => __('已分单', 'orders'),
                OS_SPLITING_PART => __('部分分单', 'orders'),
            );
            $ps = array(
                PS_UNPAYED => __('未付款', 'orders'),
                PS_PAYING  => __('付款中', 'orders'),
                PS_PAYED   => __('已付款', 'orders'),
            );
            $ss = array(
                SS_UNSHIPPED    => __('未发货', 'orders'),
                SS_PREPARING    => __('配货中', 'orders'),
                SS_SHIPPED      => __('已发货', 'orders'),
                SS_RECEIVED     => __('收货确认', 'orders'),
                SS_SHIPPED_PART => __('已发货(部分商品)', 'orders'),
                SS_SHIPPED_ING  => __('发货中', 'orders'),
            );
            foreach ($data as $key => $val) {
                $order_status = ($val['order_status'] != '2' || $val['order_status'] != '3') ? $os[$val['order_status']] : '';
                $order_status = $val['order_status'] == '2' ? __('已取消', 'orders') : $order_status;
                $order_status = $val['order_status'] == '3' ? __('无效', 'orders') : $order_status;

                if ($val['pay_id'] > 0) {
                    $payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($val['pay_id']);
                }

                list($label_order_status, $status_code) = $this->get_label_order_status($val['order_status'], $val['pay_status'], $val['shipping_status'], $payment, $device_code, $codes, $type);

                $data[$key]['cashier_name']            = $this->get_cashier_name($val['staff_id']);
                $data[$key]['mobile']                  = empty($val['mobile']) ? $val['tel'] : $val['mobile'];
                $data[$key]['formated_total_fee']      = price_format($val['total_fee'], false);
                $data[$key]['formated_order_amount']   = price_format($val['order_amount'], false);
                $data[$key]['formated_surplus']        = price_format($val['surplus'], false);
                $data[$key]['formated_money_paid']     = price_format($val['money_paid'], false);
                $data[$key]['formated_integral_money'] = price_format($val['integral_money'], false);
                $data[$key]['integral']                = intval($val['integral']);
                $data[$key]['formated_bonus']          = price_format($val['bonus'], false);
                $data[$key]['formated_shipping_fee']   = price_format($val['shipping_fee'], false);
                $data[$key]['formated_discount']       = price_format($val['discount'], false);
                $data[$key]['create_time']             = RC_Time::local_date(ecjia::config('date_format'), $val['add_time']);
                $data[$key]['status']                  = $order_status . ',' . $ps[$val['pay_status']] . ',' . $ss[$val['shipping_status']];
                $data[$key]['label_order_status']      = $label_order_status;
                $data[$key]['order_status_code']       = $status_code;
                $data[$key]['verify_code']             = $this->get_verify_code($val['order_id']);
                $data[$key]['store_name']              = $val['store_id'] > 0 ? $this->get_store_name($val['store_id']) : '';
                $order_goods_list                      = $this->get_order_goods($val['order_id']);
                $data[$key]['goods_items']             = [];
                $data[$key]['goods_number']            = 0;

                if (!empty($order_goods_list)) {
                    foreach ($order_goods_list as $k => $v) {
                        $data[$key]['goods_number']  += $v['goods_number'];
                        $data[$key]['goods_items'][] = array(
                            'goods_id'                   => $v['goods_id'],
                            'name'                       => $v['goods_name'],
                            'goods_number'               => intval($v['goods_number']),
                            'goods_price'                => $v['goods_price'],
                            'formated_goods_price'       => price_format($v['goods_price'], false),
                            'total_goods_price'          => sprintf('%.2f', $v['goods_number'] * $v['goods_price']),
                            'formated_total_goods_price' => price_format($v['goods_number'] * $v['goods_price'], false),
                            'is_bulk'                    => $v['extension_code'] == 'bulk' ? 1 : 0,
                            'goods_buy_weight'           => $v['goods_buy_weight'] > 0 ? $v['goods_buy_weight'] : '',
                            'img'                        => array(
                                'thumb' => (!empty($v['goods_img'])) ? RC_Upload::upload_url($v['goods_img']) : '',
                                'url'   => (!empty($v['original_img'])) ? RC_Upload::upload_url($v['original_img']) : '',
                                'small' => (!empty($v['goods_thumb'])) ? RC_Upload::upload_url($v['goods_thumb']) : ''
                            )
                        );
                    }
                }

            }
        }
        return $data;
    }

    /**
     * 获取格式化订单状态
     */
    private function get_label_order_status($order_status, $pay_status, $shipping_status, $payment = array(), $device_code = '', $codes, $type = '')
    {
        $label_order_status = '';
        $status_code        = '';
        if (in_array($device_code, $codes)) {
            if (in_array($order_status, array(OS_CANCELED, OS_INVALID, OS_RETURNED))) {
                $label_order_status = __('已撤销', 'orders');
                $status_code        = 'canceled';
            } elseif ($pay_status == PS_PAYED) {
                $label_order_status = __('已支付', 'orders');
                $status_code        = 'payed';
            } elseif ($pay_status == PS_UNPAYED) {
                $label_order_status = __('未支付', 'orders');
                $status_code        = 'unpay';
            }
        } else {
            if (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED)) && in_array($shipping_status, array(SS_RECEIVED)) &&
                in_array($pay_status, array(PS_PAYED, PS_PAYING))) {
                $label_order_status = __('已完成', 'orders');
                $status_code        = 'finished';
            } elseif (in_array($shipping_status, array(SS_SHIPPED))) {
                $label_order_status = __(__('已发货', 'orders'), 'orders');
                $status_code        = 'shipped';
            } elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) &&
                in_array($pay_status, array(PS_UNPAYED)) &&
                (in_array($shipping_status, array(SS_SHIPPED, SS_RECEIVED)) || !$payment['is_cod'])) {
                $label_order_status = __('待付款', 'orders');
                $status_code        = 'await_pay';
            } elseif (in_array($order_status, array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
                in_array($shipping_status, array(SS_UNSHIPPED, SS_SHIPPED_PART, SS_PREPARING, SS_SHIPPED_ING, OS_SHIPPED_PART)) &&
                (in_array($pay_status, array(PS_PAYED, PS_PAYING)) || $payment['is_cod'])) {
// 				if (!in_array($pay_status, array(PS_PAYED)) && $type == 'payed') {
// 					continue;
// 				}
                $label_order_status = __('待发货', 'orders');
                $status_code        = 'await_ship';
            } elseif (in_array($order_status, array(OS_CANCELED))) {
                $label_order_status = __('已关闭', 'orders');
                $status_code        = 'canceled';
            }
        }

        return array($label_order_status, $status_code);
    }

    /**
     * 订单提货码
     */
    private function get_verify_code($order_id = 0)
    {
        $verify_code = '';
        if (!empty($order_id)) {
            $verify_code = RC_DB::table('term_meta')->where('object_id', $order_id)->where('object_type', 'ecjia.order')->where('object_group', 'order')->where('meta_key', 'receipt_verification')->pluck('meta_value');
            $verify_code = empty($verify_code) ? '' : $verify_code;
        }
        return $verify_code;
    }

    private function get_order_goods($order_id = 0)
    {
        //og.goods_number, og.goods_id, og.goods_name, og.goods_price, og.extension_code, og.goods_buy_weight,g.goods_thumb, g.goods_img, g.original_img,
        $result = [];
        if (!empty($order_id)) {
            $field  = 'og.goods_number, og.goods_id, og.goods_name, og.goods_price, og.extension_code, og.goods_buy_weight,g.goods_thumb, g.goods_img, g.original_img';
            $dbview = RC_DB::table('order_goods as og')->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'));
            $result = $dbview->where(RC_DB::raw('og.order_id'), $order_id)->select(RC_DB::raw($field))->get();
            if (!empty($result)) {
                foreach ($result as $key => $val) {
                    if ($val['extension_code'] == 'bulk') {
                        if ($val['goods_buy_weight'] > 0) {
                            $goods_price                 = $val['goods_price'] / $val['goods_buy_weight'];
                            $goods_price                 = sprintf('%.2f', $goods_price);
                            $result[$key]['goods_price'] = $goods_price;
                        }
                    }
                }
            }
        }
        return $result;
    }

    private function get_store_name($store_id = 0)
    {
        $store_name = '';
        if (!empty($store_id)) {
            $store_name = RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');
        }
        return $store_name;
    }

    private function get_cashier_name($staff_id = 0)
    {
        $cashier_name = '';
        if (!empty($staff_id)) {
            $cashier_name = RC_DB::table('staff_user')->where('user_id', $staff_id)->pluck('name');
        }
        return $cashier_name;
    }
}

// end