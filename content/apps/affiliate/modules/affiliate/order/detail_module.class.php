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
 * 分成记录详情
 * @author zrl
 */
class affiliate_order_detail_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        //如果用户登录获取其session
        $user_id = $_SESSION['user_id'];
        if ($user_id <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        /* 获取订单id*/
        $order_id = $this->requestData('order_id', 0);

        if (empty($order_id)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'affiliate'), __CLASS__));
        }
        //分成订单信息
        $order_info = RC_Api::api('orders', 'order_info', ['order_id' => $order_id]);
        if (is_ecjia_error($order_info)) {
            return $order_info;
        }

        //分成订单不存在
        if (empty($order_info)) {
            return new ecjia_error('affiliate_order_error', __('分成订单不存在', 'affiliate'));
        }

        //订单已参与分成
        //获取分成记录信息
        $affiliate_log = RC_DB::table('affiliate_log')->where('order_id', $order_id)->where('user_id', $user_id)->first();
        if(empty($affiliate_log)) {
            return new ecjia_error('affiliate_order_error', __('分成记录不存在', 'affiliate'));
        }

        //订单商品
        $order_goods_list = $this->_get_order_goods($order_id);

        //下单用户信息
//        $user_info = RC_Api::api('user', 'user_info', ['user_id' => $order_info['user_id']]);
//        if (is_ecjia_error($user_info)) {
//            return $user_info;
//        }

        $data = [
            'order_id'                    => intval($order_info['order_id']),
            'order_sn'                    => trim($order_info['order_sn']),
            'formatted_order_time'        => RC_Time::local_date(ecjia::config('time_format'), $order_info['add_time']),
            'buyer'                       => mb_substr($order_info['consignee'], 0, 1) . '*' . mb_substr($order_info['consignee'], -1),
            'total_amount'                => $order_info['total_fee'],
            'formatted_total_amount'      => $order_info['formated_total_fee'],
            'store_id'                    => $order_info['store_id'],
            'store_name'                  => Ecjia\App\Store\StoreFranchisee::StoreName($order_info['store_id']),
            'affiliated_amount'           => $affiliate_log['separate_type'] == \Ecjia\App\Affiliate\Enums\AffiliateOrderEnum::SEPARATED ? $affiliate_log['money'] : 0,
            'formatted_affiliated_amount' => $affiliate_log['separate_type'] == \Ecjia\App\Affiliate\Enums\AffiliateOrderEnum::SEPARATED ? ecjia_price_format($affiliate_log['money'], false) : '',
            'separate_status'             => self::get_status_code($affiliate_log['separate_type']),
            'label_separate_status'       => self::get_status_label($affiliate_log['separate_type']),
            'goods_list'                  => $order_goods_list,
        ];
        return $data;
    }

    private function get_status_code($status) {
        $code = [
            0 => 'await_separate',
            1 => 'separated',
            2 => 'cancel_separated',
        ];

        return array_get($code, $status);
    }

    private function get_status_label($status) {
        $code = [
            0 => '待分成',
            1 => '已分成',
            2 => '已取消',
        ];

        return array_get($code, $status);
    }

    /**
     * 订单商品
     */
    private function _get_order_goods($order_id)
    {
        $goods_list = [];

        $order_goods_list = RC_DB::table('order_goods as og')
            ->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->select(RC_DB::raw('og.*, g.goods_thumb, g.goods_img, g.original_img'))
            ->where(RC_DB::raw('og.order_id'), $order_id)->get();

        if (!empty($order_goods_list)) {
            $goods_list = [];
            foreach ($order_goods_list as $v) {
                $goods_list[] = array(
                    'goods_id'              => intval($v['goods_id']),
                    'goods_name'            => !empty($v['goods_name']) ? trim($v['goods_name']) : '',
                    'goods_sn'              => !empty($v['goods_sn']) ? trim($v['goods_sn']) : '',
                    'goods_number'          => intval($v['goods_number']),
                    'goods_price'           => $v['goods_price'] > 0 ? $v['goods_price'] : 0,
                    'formatted_goods_price' => $v['goods_price'] > 0 ? price_format($v['goods_price'], false) : '',
                    'img'                   => array(
                        'small' => !empty($v['goods_img']) ? RC_Upload::upload_url($v['goods_img']) : '',
                        'thumb' => !empty($v['goods_thumb']) ? RC_Upload::upload_url($v['goods_thumb']) : '',
                        'url'   => !empty($v['original_img']) ? RC_Upload::upload_url($v['original_img']) : '',
                    )
                );
            }
        }

        return $goods_list;
    }
}

// end