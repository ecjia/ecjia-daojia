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
 * 订单快递查询
 * @author royalwang
 */
class order_express_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        $user_id = $_SESSION['user_id'];
        if ($user_id < 1) {
            return new ecjia_error(100, __('Invalid session', 'orders'));
        }

        define('INIT_NO_USERS', true);
        RC_Loader::load_app_func('admin_order', 'orders');

        $AppKey   = $this->requestData('app_key', '');
        $order_id = $this->requestData('order_id', 0);

        if (empty($order_id)) {
            return new ecjia_error(101, sprintf(__('请求接口%s参数无效', 'orders'), __CLASS__));
        }

        $order_info = order_info($order_id);
        if (!$order_info || empty($order_info['shipping_name']) || empty($order_info['invoice_no'])) {
            return new ecjia_error(10009, __('订单无发货信息', 'orders'));
        }

        $delivery_result = RC_Model::model('orders/delivery_order_model')->where(array('order_id' => $order_id))->select();
        // 		RC_Logger::getlogger('info')->info($order_id);
        // 		RC_Logger::getlogger('info')->info($delivery_result);

        $delivery_list = array();
        if (!empty($delivery_result)) {
            $delivery_goods_db       = RC_Model::model('orders/delivery_viewmodel');
            $delivery_goods_db->view = array(
                'goods' => array(
                    'type'  => Component_Model_View::TYPE_LEFT_JOIN,
                    'alias' => 'g',
                    'on'    => 'dg.goods_id = g.goods_id',
                ),
            );
            $ship_code               = RC_Loader::load_app_config('shipping_code', 'shipping');
            foreach ($delivery_result as $val) {
                $shipping_info = RC_DB::table('shipping')->where('shipping_id', $val['shipping_id'])
                    ->first();
                if ($shipping_info['shipping_code'] == 'ship_o2o_express' || $shipping_info['shipping_code'] == 'ship_ecjia_express') {
                    $delivery_list1 = array();
                    if (!empty($val['invoice_no'])) {
                        $delivery_list1 = RC_DB::table('express_track_record as etr')
                            ->leftJoin('shipping as s', RC_DB::raw('s.shipping_code'), '=', RC_DB::raw('etr.express_code'))
                            ->where(RC_DB::raw('express_code'), $shipping_info['shipping_code'])
                            ->where(RC_DB::raw('track_number'), $val['invoice_no'])
                            ->select(RC_DB::raw('etr.track_number'), RC_DB::raw('etr.time'), RC_DB::raw('etr.context'), RC_DB::raw('s.shipping_code'), RC_DB::raw('s.shipping_name'))->get();
                        /*商品*/
                        $delivery_goods = $delivery_goods_db->where(array('delivery_id' => $val['delivery_id']))->select();

                        $goods_lists = array();
                        foreach ($delivery_goods as $v) {
                            $goods_lists[] = array(
                                'id'       => $v['goods_id'],
                                'name'     => $v['goods_name'],
                                'goods_sn' => $v['goods_sn'],
                                'number'   => $v['send_number'],
                                'img'      => array(
                                    'thumb' => (isset($v['goods_img']) && !empty($v['goods_img'])) ? RC_Upload::upload_url($v['goods_img']) : RC_Uri::admin_url('statics/images/nopic.png'),
                                    'url'   => (isset($v['original_img']) && !empty($v['original_img'])) ? RC_Upload::upload_url($v['original_img']) : RC_Uri::admin_url('statics/images/nopic.png'),
                                    'small' => (isset($v['goods_thumb']) && !empty($v['goods_thumb'])) ? RC_Upload::upload_url($v['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png')
                                ),
                            );
                        }

                        foreach ($delivery_list1 as $k1 => $v1) {
                            $delivery_list[] = array(
                                'shipping_name'         => $v1['shipping_name'],
                                'shipping_code'         => $v1['shipping_code'],
                                'shipping_number'       => $v1['track_number'],
                                'shipping_status'       => '',
                                'label_shipping_status' => '',
                                'sign_time_formated'    => $v1['time'],
                                'content'               => array('time' => $v1['time'], 'context' => $v1['context']),
                                'goods_items'           => $goods_lists
                            );
                        }
                    }
                } else {
                    $data = array();
                    // 					$typeCom = getComType($val['shipping_name']);//快递公司类型
                    $typeCom = $ship_code[$shipping_info['shipping_code']];

                    if (!empty($typeCom) && !empty($val['invoice_no'])) {
                        $cloud_express_key    = ecjia::config('cloud_express_key');
                        $cloud_express_secret = ecjia::config('cloud_express_secret');
                        if (!empty($cloud_express_key) && !empty($cloud_express_secret)) {
                        	$customer_name = '';
                        	if (!empty($order_info['mobile'])) {
                        		$CustomerName = substr($order_info['mobile'], -4);
                        	}
                        	
                        	$params = array(
                                'app_key'    => $cloud_express_key,
                                'app_secret' => $cloud_express_secret,
                                'company'    => $typeCom,
                                'number'     => $val['invoice_no'],
                                'order'      => 'desc',
                        		'customer_name' => $customer_name
                            );
                            $cloud  = ecjia_cloud::instance()->api('express/track')->data($params)->run();

                            if (is_ecjia_error($cloud->getError())) {
                                $data = array('content' => array('time' => 'error', 'context' => $cloud->getError()->get_error_message()));
                            } else {
                                $data = $cloud->getReturnData();
                            }
                        } else {
                            $data = array('content' => array('time' => 'error', 'context' => __('物流跟踪未配置', 'orders')));
                        }
                    }

                    $delivery_goods = $delivery_goods_db->where(array('delivery_id' => $val['delivery_id']))->select();

                    $goods_lists = array();
                    foreach ($delivery_goods as $v) {
                        $goods_lists[] = array(
                            'id'       => $v['goods_id'],
                            'name'     => $v['goods_name'],
                            'goods_sn' => $v['goods_sn'],
                            'number'   => $v['send_number'],
                            'img'      => array(
                                'thumb' => (isset($v['goods_img']) && !empty($v['goods_img'])) ? RC_Upload::upload_url($v['goods_img']) : RC_Uri::admin_url('statics/images/nopic.png'),
                                'url'   => (isset($v['original_img']) && !empty($v['original_img'])) ? RC_Upload::upload_url($v['original_img']) : RC_Uri::admin_url('statics/images/nopic.png'),
                                'small' => (isset($v['goods_thumb']) && !empty($v['goods_thumb'])) ? RC_Upload::upload_url($v['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png')
                            ),
                        );
                    }

                    $delivery_list[] = array(
                        'shipping_name'         => $val['shipping_name'],
                        'shipping_code'         => $shipping_info['shipping_code'],
                        'shipping_number'       => $val['invoice_no'],
                        'shipping_status'       => !empty($data['state']) ? $data['state'] : '',
                        'label_shipping_status' => $shipping_info['shipping_code'] == 'ship_no_express' ? __('您当前选择的物流为【无需物流】，因此该订单暂无运单编号和物流状态', 'orders') : (!empty($data['state_label']) ? $data['state_label'] : ''),
                        'sign_time_formated'    => !empty($data['sign_time_formated']) ? $data['sign_time_formated'] : '',
                        'content'               => !empty($data['content']) ? $data['content'] : array('time' => 'error', 'context' => __('暂无物流信息', 'orders')),
                        'goods_items'           => $goods_lists,
                    );
                }


            }
        }
        return $delivery_list;
    }
}


// end