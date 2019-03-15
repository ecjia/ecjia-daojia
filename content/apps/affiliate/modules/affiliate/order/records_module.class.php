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
 * 订单分成记录
 * @author zrl
 */
class affiliate_order_records_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        //如果用户登录获取其session
        $user_id = $_SESSION['user_id'];
        if ($user_id <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        /* 获取数量 */
        $size   = $this->requestData('pagination.count', '15');
        $page   = $this->requestData('pagination.page', '1');
        $status = $this->requestData('status', '');

        $status_arr = array('await_separate', 'separated');
        if (empty($status) || !in_array($status, $status_arr)) {
            return new ecjia_error('invalid_parameter', __('参数无效', 'affiliate'));
        }

        if ($status == 'await_separate') {
            $log_list = $this->get_await_separate($user_id, $page, $size);
        } else {
            $log_list = $this->get_separated($user_id, $page, $size);
        }

        $list  = $log_list['list'];
        $pager = $log_list['page'];

        return array('data' => $list, 'pager' => $pager);
    }


    /**
     * 待分佣订单记录
     */
    private function get_await_separate($user_id, $page, $size)
    {

        $db = RC_DB::table('order_info as oi')->leftJoin('users as u', RC_DB::raw('oi.user_id'), '=', RC_DB::raw('u.user_id'));

        $db->where(RC_DB::raw('u.parent_id'), $user_id)->where(RC_DB::raw('oi.is_separate'), \Ecjia\App\Affiliate\Enums\AffiliateOrderEnum::UNSEPARATE);

        $count    = $db->count(RC_DB::raw('oi.order_id'));
        $page_row = new ecjia_page($count, $size, 6, '', $page);
        $log_list = $db->take($size)->skip($page_row->start_id - 1)->orderBy(RC_DB::raw('add_time'), 'desc')->select(RC_DB::raw('oi.*'))->get();

        //没有待分成订单
        if (empty($count)) {
            return array('list' => [], 'page' => array('total' => 0, 'count' => 0, 'more' => 0));
        }
        $list = [];
        if (!empty($log_list)) {
            foreach ($log_list as $val) {
                $status           = 'await_separate';
                $label_status     = '待分成';
                $order_goods_list = $this->_get_order_goods($val['order_id']);
                $list[]           = array(
                    'order_id'                    => intval($val['order_id']),
                    'order_sn'                    => trim($val['order_sn']),
                    'formatted_order_time'        => RC_Time::local_date(ecjia::config('time_format'), $val['add_time']),
                    'affiliated_amount'           => 0,
                    'formatted_affiliated_amount' => '',
                    'separate_status'             => $status,
                    'label_separate_status'       => $label_status,
                    'goods_list'                  => $order_goods_list
                );
            }
        }
        $pager = array(
            'total' => $page_row->total_records,
            'count' => $page_row->total_records,
            'more'  => $page_row->total_pages <= $page ? 0 : 1,
        );

        return ['list' => $list, 'page' => $pager];
    }

    /**
     * 已分佣订单记录
     */
    private function get_separated($user_id, $page, $size)
    {
        $db = RC_DB::table('order_info as oi')
            ->leftJoin('users as u', RC_DB::raw('oi.user_id'), '=', RC_DB::raw('u.user_id'))
            ->leftJoin('affiliate_log as ag', RC_DB::raw('ag.order_id'), '=', RC_DB::raw('oi.order_id'));

        $db->where(RC_DB::raw('ag.user_id'), $user_id)//分成记录是自己的
        ->whereNotIn(RC_DB::raw('ag.separate_type'), [\Ecjia\App\Affiliate\Enums\AffiliateLogEnum::AFFILIATE_REGISTER_CANCELED, \Ecjia\App\Affiliate\Enums\AffiliateLogEnum::AFFILIATE_ORDER_CANCELED])
            ->where(RC_DB::raw('oi.is_separate'), \Ecjia\App\Affiliate\Enums\AffiliateOrderEnum::SEPARATED);

        $count    = $db->count(RC_DB::raw('ag.log_id'));
        $page_row = new ecjia_page($count, $size, 6, '', $page);
        $log_list = $db->take($size)->skip($page_row->start_id - 1)->orderBy(RC_DB::raw('oi.add_time'), 'desc')->select(RC_DB::raw('oi.*, u.user_name as buyer, ag.money'))->get();

        //没有待分成订单
        if (empty($count)) {
            return array('list' => [], 'page' => array('total' => 0, 'count' => 0, 'more' => 0));
        }

        $list = [];
        if (!empty($log_list)) {
            foreach ($log_list as $val) {
                $status           = 'separated';
                $label_status     = '已分成';
                $order_goods_list = $this->_get_order_goods($val['order_id']);
                $list[]           = array(
                    'order_id'                    => intval($val['order_id']),
                    'order_sn'                    => trim($val['order_sn']),
                    'formatted_order_time'        => RC_Time::local_date(ecjia::config('time_format'), $val['add_time']),
                    'affiliated_amount'           => $val['money'],
                    'formatted_affiliated_amount' => ecjia_price_format($val['money'], false),
                    'separate_status'             => $status,
                    'label_separate_status'       => $label_status,
                    'goods_list'                  => $order_goods_list
                );
            }
        }
        $pager = array(
            'total' => $page_row->total_records,
            'count' => $page_row->total_records,
            'more'  => $page_row->total_pages <= $page ? 0 : 1,
        );

        return ['list' => $list, 'page' => $pager];
    }


    /**
     * 订单商品
     */
    private function _get_order_goods($order_id)
    {
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