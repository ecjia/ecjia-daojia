<?php

namespace Ecjia\App\Maintain\Commands;

use Ecjia\App\Maintain\AbstractCommand;
use RC_DB;
use RC_Loader;

class SyncOrderDataToBillDetail extends AbstractCommand
{
    
    
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'sync_order_data_to_bill_detail';
    
    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/setting_shop.png';

    public function __construct()
    {
        $this->name = __('同步订单数据到账单详情', 'maintain');
        $this->description = __('v1.15结算升级同步数据', 'maintain');
    }

    // 更新shop_config数据表主键ID顺序
    public function run() {
        //更新类型
        RC_DB::table('store_bill_detail')->where('order_type', '1')->update(array('order_type' => 'buy'));
        RC_DB::table('store_bill_detail')->where('order_type', '11')->update(array('order_type' => 'quickpay'));
        RC_DB::table('store_bill_detail')->where('order_type', '2')->update(array('order_type' => 'refund'));
        
        $list = RC_DB::table('store_bill_detail')->where('order_sn', '')->get();
        if($list) {
            foreach ($list as $row) {
                $data = $this->getBillOrderData($row['order_type'], $row['order_id']);
                if ($data) {
                    RC_DB::table('store_bill_detail')->where('order_id', $row['order_id'])->where('order_type', $row['order_type'])->update($data);
                }
            }
        }
        
        return true;
    }
    
    protected function getBillOrderData($order_type, $order_id)
    {
        $data = array();
        if($order_type == 'quickpay') {
            $order_info = RC_DB::table('quickpay_orders')->where('order_id', $order_id)->first();
            $data['order_sn'] = $order_info['order_sn'];
        } else if($order_type == 'refund') {
            $order_info = RC_DB::table('refund_order')->where('refund_id', $order_id)->first();
            $data['order_sn'] = $order_info['refund_sn'];//退款单号
        } else {
            RC_Loader::load_app_func('admin_order', 'orders');
            $order_info = order_info($order_id);
            $data['order_sn'] = $order_info['order_sn'];
        }
        
        if (empty($order_info)) {
            return false;
        }
             
        $data['goods_amount'] = $order_info['goods_amount'];
        $data['shipping_fee'] = $order_info['shipping_fee'] ? $order_info['shipping_fee'] : 0;
        $data['insure_fee'] = $order_info['insure_fee'] ? $order_info['insure_fee'] : 0;
        $data['pay_fee'] = $order_info['pay_fee'] ? $order_info['pay_fee'] : 0;
        $data['pack_fee'] = $order_info['pack_fee'] ? $order_info['pack_fee'] : 0;
        $data['card_fee'] = $order_info['card_fee'] ? $order_info['card_fee'] : 0;
        $data['surplus'] = $order_info['surplus'];
        $data['integral'] = $order_info['integral'];
        $data['integral_money'] = $order_info['integral_money'];
        $data['bonus'] = $order_info['bonus'];
        $data['discount'] = $order_info['discount'];
        $data['inv_tax'] = $order_info['tax'] ? $order_info['tax'] : 0;
        $data['money_paid'] = $order_info['money_paid'] ? $order_info['money_paid'] : 0;
        $data['pay_code'] = $order_info['pay_code'] ? $order_info['pay_code'] : '';
        $data['pay_name'] = $order_info['pay_name'] ? $order_info['pay_name'] : '';
        //订单金额 付款+余额消耗+积分抵钱
        if($order_type == 'quickpay') {
            $data['order_amount'] = $order_info['order_amount'];
        } else {
            $data['order_amount'] = $order_info['money_paid'] + $order_info['surplus'] + $order_info['integral_money'];
        }
        
        return $data;
    }
    
}

// end