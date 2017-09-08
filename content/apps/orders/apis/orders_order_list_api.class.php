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
 * 订单列表接口
 * @author
 */
class orders_order_list_api extends Component_Event_Api {
    /**
     * 查看订单列表
     * @param array $options
     * @return  array
     */
    public function call (&$options) {
        if (!is_array($options) ) {
            return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
        }

        $user_id = $_SESSION['user_id'];
        $type = !empty($options['type']) ? $options['type'] : '';

        $size = $options['size'];
        $page = $options['page'];
        $keywords = $options['keywords'];
        $store_id = $options['store_id'];
        
        $orders = $this->user_orders_list($user_id, $type, $page, $size, $keywords, $store_id);

        return $orders;
    }

    /**
     *  获取用户指定范围的订单列表
     *
     * @access  public
     * @param   int         $user_id        用户ID号
     * @param   int         $num            列表最大数量
     * @param   int         $start          列表起始位置
     * @return  array       $order_list     订单列表
     */
    private function user_orders_list($user_id, $type = '', $page = 1, $size = 15, $keywords = '', $store_id) {
        /**
         * await_pay 待付款
         * await_ship 待发货
         * shipped 待收货
         * finished 已完成
         */
        $dbview_order_info = RC_Model::model('orders/order_info_viewmodel');
        $dbview_order_info->view = array(
            'order_goods' => array(
                'type'      => Component_Model_View::TYPE_LEFT_JOIN,
                'alias'     => 'og',
                'on'        => 'oi.order_id = og.order_id ',
            ),
            'goods' => array(
                'type'      => Component_Model_View::TYPE_LEFT_JOIN,
                'alias'     => 'g',
                'on'        => 'og.goods_id = g.goods_id'
            ),
            'store_franchisee' => array(
                'type'      => Component_Model_View::TYPE_LEFT_JOIN,
                'alias'     => 'ssi',
                'on'        => 'oi.store_id = ssi.store_id'
            ),
            'comment' => array(
                'type'      => Component_Model_View::TYPE_LEFT_JOIN,
                'alias'     => 'c',
                'on'        => 'c.id_value = og.goods_id and c.rec_id = og.rec_id and c.order_id = oi.order_id and c.comment_type = 0 and c.parent_id = 0'
            ),
        );

        RC_Loader::load_app_class('order_list', 'orders', false);
        $where = array();
        $where['oi.user_id'] = $user_id;
        $where['oi.is_delete'] = 0;
        if ($store_id > 0) {
        	$where['oi.store_id'] = $store_id;
        }
               
        if (!empty($keywords)) {
            $where[] = "((og.goods_name LIKE '%" . $keywords ."%') or (oi.order_sn LIKE '%" . $keywords ."%'))";
        }

        if (!empty($type)) {
            if ($type == 'allow_comment') {
                $where[] = 'comment_id is null';
//                 $order_type = 'order_finished';
//                 $where = array_merge($where, order_list::$order_type('oi.'));
                $where['oi.order_status'] = array(OS_CONFIRMED, OS_SPLITED);
                $where['oi.shipping_status'] = array(SS_RECEIVED);
                $where['oi.pay_status'] = array(PS_PAYED, PS_PAYING);
            } else {
                $order_type = 'order_'.$type;
                $where = array_merge($where, order_list::$order_type('oi.'));
            }
        }

        $record_count = $dbview_order_info->join(array('order_goods', 'goods','store_franchisee', 'comment'))->where($where)->count('DISTINCT oi.order_id');
        //实例化分页
        $page_row = new ecjia_page($record_count, $size, 6, '', $page);

//         $order_group = $dbview_order_info->join(array('order_goods', 'goods', 'comment'))->field('oi.order_id')->where($where)->order(array('oi.add_time' => 'desc'))->limit($page_row->limit())->select();
//         if (empty($order_group)) {
//             return array('order_list' => array(), 'page' => $page_row);
//         } else {
//             foreach ($order_group as $val) {
//                 $where['oi.order_id'][] = $val['order_id'];
//             }
//         }

        $field = 'oi.order_id, oi.order_sn, oi.order_status, oi.shipping_status, oi.pay_status, oi.add_time, (oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee + oi.tax - oi.integral_money - oi.bonus - oi.discount) AS total_fee, oi.discount, oi.integral_money, oi.bonus, oi.shipping_fee, oi.pay_id, oi.order_amount'.
        ', og.goods_id, og.goods_name, og.goods_attr, og.goods_attr_id, og.goods_price, og.goods_number, og.goods_price * og.goods_number AS subtotal, g.goods_thumb, g.original_img, g.goods_img, ssi.store_id, ssi.merchants_name, ssi.manage_mode, c.comment_id, c.has_image';
        $res = $dbview_order_info->join(array('order_goods', 'goods', 'store_franchisee', 'comment'))->field($field)->where($where)->group('oi.order_id')->order(array('oi.order_id' => 'desc'))->limit($page_row->limit())->select();
        RC_Lang::load('orders/order');

//         _dump($dbview_order_info->last_sql());
//         _dump($res,1);
        /* 取得订单列表 */
        $orders = array();
        if (!empty($res)) {
            $order_id = $goods_number = $goods_type_number = 0;
//             $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
            RC_Loader::load_app_func('global', 'orders');
            foreach ($res as $row) {
                $attr = array();
                if (isset($row['goods_attr']) && !empty($row['goods_attr'])) {
                    $goods_attr = explode("\n", $row['goods_attr']);
                    $goods_attr = array_filter($goods_attr);
                    foreach ($goods_attr as  $val) {
                        $a = explode(':',$val);
                        if (!empty($a[0]) && !empty($a[1])) {
                            $attr[] = array('name' => $a[0], 'value' => $a[1]);
                        }
                    }
                }
                if ($order_id == 0 || $row['order_id'] != $order_id ) {
                    $goods_number = $goods_type_number = 0;
                    if ($row['pay_id'] > 0) {
                        $payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($row['pay_id']);
                    }
                    $goods_type_number ++;
                    $subject = $row['goods_name'].RC_Lang::get('orders::order.etc').$goods_type_number.RC_Lang::get('orders::order.kind_of_goods');
                    $goods_number += isset($row['goods_number']) ? $row['goods_number'] : 0;


                    if (in_array($row['order_status'], array(OS_CONFIRMED, OS_SPLITED)) &&
                        in_array($row['shipping_status'], array(SS_RECEIVED)) &&
                        in_array($row['pay_status'], array(PS_PAYED, PS_PAYING)))
                    {
                        $label_order_status = RC_Lang::get('orders::order.cs.'.CS_FINISHED);
                        $status_code = 'finished';
                    }
                    elseif (in_array($row['shipping_status'], array(SS_SHIPPED)))
                    {
                        $label_order_status = RC_Lang::get('orders::order.label_await_confirm');
                        $status_code = 'shipped';
                    }
                    elseif (in_array($row['order_status'], array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) &&
                            in_array($row['pay_status'], array(PS_UNPAYED)) &&
                            (in_array($row['shipping_status'], array(SS_SHIPPED, SS_RECEIVED)) || !$payment['is_cod']))
                    {
                        $label_order_status = RC_Lang::get('orders::order.label_await_pay');
                        $status_code = 'await_pay';
                    }
                    elseif (in_array($row['order_status'], array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
                        in_array($row['shipping_status'], array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) &&
                        (in_array($row['pay_status'], array(PS_PAYED, PS_PAYING)) || $payment['is_cod']))
                    {
                        $label_order_status = RC_Lang::get('orders::order.label_await_ship');
                        $status_code = 'await_ship';
                    }
               		elseif (in_array($row['order_status'], array(OS_SPLITING_PART)) &&
                        in_array($row['shipping_status'], array(SS_SHIPPED_PART)))
                    {
                        $label_order_status = RC_Lang::get('orders::order.label_shipped_part');
                        $status_code = 'shipped_part';
                    }
                    elseif (in_array($row['order_status'], array(OS_CANCELED))) {
                        $label_order_status = RC_Lang::get('orders::order.label_canceled');
                        $status_code = 'canceled';
                    }

                    $orders[$row['order_id']] = array(
                        'seller_id'             => !empty($row['store_id']) ? intval($row['store_id']) : 0,
                        'seller_name'           => !empty($row['merchants_name']) ? $row['merchants_name'] : RC_Lang::get('orders::order.self_support'),
                        'manage_mode'           => $row['manage_mode'],
                        'order_id'              => $row['order_id'],
                        'order_sn'              => $row['order_sn'],
                        'order_status'          => $row['order_status'],
                        'shipping_status'       => $row['shipping_status'],
                        'pay_status'            => $row['pay_status'],
                        'label_order_status'    => $label_order_status,
                        'order_status_code'     => $status_code,
                        'order_time'            => RC_Time::local_date(ecjia::config('time_format'), $row['add_time']),
                        'total_fee'             => $row['total_fee'],
                        'discount'              => $row['discount'],
                        'goods_number'          => $goods_number,
                        'is_cod'                => $payment['is_cod'],
                        'formated_total_fee'    => price_format($row['total_fee'], false),
                        'formated_integral_money'=> price_format($row['integral_money'], false),
                        'formated_bonus'        => price_format($row['bonus'], false),
                        'formated_shipping_fee' => price_format($row['shipping_fee'], false),
                        'formated_discount'     => price_format($row['discount'], false),
                        'order_info'            => array(
                            'pay_code'          => isset($payment['pay_code']) ? $payment['pay_code'] : '',
                            'order_amount'      => $row['order_amount'],
                            'order_id'          => $row['order_id'],
                            'subject'           => $subject,
                            'desc'              => $subject,
                            'order_sn'          => $row['order_sn'],
                        ),
                        'goods_list' => array()
                    );

                    if (!empty($row['goods_id'])) {
                        $orders[$row['order_id']]['goods_list']    = array(
                            array(
                                'goods_id'              => isset($row['goods_id'])? $row['goods_id'] : 0,
                                'name'                  => isset($row['goods_name'])? $row['goods_name']: '',
                                'goods_attr_id'         => $row['goods_attr_id'],
                                'goods_attr'            => $attr,
                                'goods_number'          => isset($row['goods_number'])? $row['goods_number']: 0,
                                'subtotal'              => isset($row['subtotal'])? price_format($row['subtotal'], false): 0,
                                'formated_shop_price'   => isset($row['goods_price']) ? price_format($row['goods_price'], false) : 0,
                                'img' => array(
                                    'small' => (isset($row['goods_thumb']) && !empty($row['goods_thumb']))       ? RC_Upload::upload_url($row['goods_thumb'])     : '',
                                    'thumb' => (isset($row['goods_img']) && !empty($row['goods_img']))           ? RC_Upload::upload_url($row['goods_img'])         : '',
                                    'url'   => (isset($row['original_img']) && !empty($row['original_img']))     ? RC_Upload::upload_url($row['original_img'])     : '',
                                ),
                                'is_commented'   => empty($row['comment_id']) ? 0 : 1,
                                'is_showorder'	 => empty($row['has_image']) ? 0 : 1,
                            )
                        );
                    }
                    
                    $goods_list = get_order_goods_base($row['order_id']);
                    if (!empty($goods_list)) {
                        foreach ($goods_list as $k =>$v) {
                            $attr = array();
                            if (!empty($v['goods_attr'])) {
                                $goods_attr = explode("\n", $v['goods_attr']);
                                $goods_attr = array_filter($goods_attr);
                                foreach ($goods_attr as  $val) {
                                    $a = explode(':',$val);
                                    if (!empty($a[0]) && !empty($a[1])) {
                                        $attr[] = array('name'=>$a[0], 'value'=>$a[1]);
                                    }
                                }
                            }
                            $goods_list[$k] = array(
                                'goods_id'				=> $v['goods_id'],
                                'name'					=> $v['goods_name'],
                                'goods_attr_id'         => $v['goods_attr_id'],
                                'goods_attr'            => $attr,
                                'goods_number'			=> $v['goods_number'],
                                'subtotal'				=> price_format($v['subtotal'], false),
                                'formated_shop_price' 	=> price_format($v['goods_price'], false),
                                'is_commented'   => $v['is_commented'],
                                'is_showorder'	 => $v['has_image'],
                                'img' => array(
                                    'thumb'	=> !empty($v['goods_img']) ? RC_Upload::upload_url($v['goods_img']) : '',
                                    'url'	=> !empty($v['original_img']) ? RC_Upload::upload_url($v['original_img']) : '',
                                    'small'	=> !empty($v['goods_thumb']) ? RC_Upload::upload_url($v['goods_thumb']) : '',
                                ),
                            );
                        }
                    }
                    $orders[$row['order_id']]['goods_list'] = $goods_list;

                    $order_id = $row['order_id'];
                } else {
                    $goods_number += isset($row['goods_number']) ? $row['goods_number'] : 0;
                    $orders[$row['order_id']]['goods_number'] = $goods_number;
                    $goods_type_number ++;
                    $subject = $row['goods_name'].RC_Lang::get('orders::order.etc').$goods_type_number.RC_Lang::get('orders::order.kind_of_goods');
                    $orders[$row['order_id']]['order_info']['subject']    = $subject;
                    $orders[$row['order_id']]['order_info']['desc']        = $subject;
                    $orders[$row['order_id']]['goods_list'][] = array(
                        'goods_id'          => isset($row['goods_id'])? $row['goods_id'] : 0,
                        'name'              => isset($row['goods_name'])? $row['goods_name'] : '',
                        'goods_attr_id'     => isset($row['goods_attr_id'])? $row['goods_attr_id'] : '',
                        'goods_attr'        => empty($attr) ? '' : $attr,
                        'goods_number'      => isset($row['goods_number']) ? $row['goods_number'] : 0,
                        'subtotal'          => isset($row['subtotal'])? price_format($row['subtotal'], false) : 0,
                        'formated_shop_price' => isset($row['goods_price']) ? price_format($row['goods_price'], false)     : 0,
                        'img' => array(
                            'small'         => (isset($row['goods_thumb']) && !empty($row['goods_thumb']))       ? RC_Upload::upload_url($row['goods_thumb'])     : '',
                            'thumb'         => (isset($row['goods_img']) && !empty($row['goods_img']))           ? RC_Upload::upload_url($row['goods_img'])         : '',
                            'url'           => (isset($row['original_img']) && !empty($row['original_img']))     ? RC_Upload::upload_url($row['original_img'])     : '',
                        ),
                        'is_commented'    => empty($row['relation_id']) ? 0 : 1,
                    );

                }
            }
        }
        $orders = array_merge($orders);

        return array('order_list' => $orders, 'page' => $page_row);
    }
}

// end