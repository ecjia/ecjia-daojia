<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 取得某订单应该赠送的积分数
 * @author wutifang
 *
 */
class orders_order_integral_api extends Component_Event_Api
{

    /**
     * @param  $options ['order_id'] 订单ID
     *         $options['order_sn'] 订单号
     *
     * @return array|ecjia_error
     */
    public function call(&$options)
    {
        if (!is_array($options)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'orders'), __CLASS__));
        }
        return $this->integral_to_give($options);
    }

    /**
     * 取得某订单应该赠送的积分数
     * @param   array $order 订单
     * @return  int     积分数
     */
    private function integral_to_give($order)
    {
        /* 判断是否团购 */
        // TODO:团购暂时注释给的固定参数
        $order['extension_code'] = '';
        if ($order['extension_code'] == 'group_buy') {
            RC_Loader::load_app_func('admin_goods', 'goods');
            $group_buy = group_buy_info(intval($order['extension_id']));
            return array('custom_points' => $group_buy['gift_integral'], 'rank_points' => $order['goods_amount']);
        } else {
            return RC_DB::table('order_goods as o')
                ->leftJoin('goods as g', RC_DB::raw('o.goods_id'), '=', RC_DB::raw('g.goods_id'))
                ->select(RC_DB::raw('SUM(o.goods_number * IF(g.give_integral > -1, g.give_integral, o.goods_price)) AS custom_points,
        			SUM(o.goods_number * IF(g.rank_integral > -1, g.rank_integral, o.goods_price)) AS rank_points'))
                ->where(RC_DB::raw('o.order_id'), $order['order_id'])
                ->where(RC_DB::raw('o.goods_id'), '>', 0)
                ->where(RC_DB::raw('o.parent_id'), '=', 0)
                ->where(RC_DB::raw('o.is_gift'), '=', 0)
                ->first();
        }
    }
}


// end