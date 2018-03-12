<?php

namespace Ecjia\App\Orders;

use Royalcms\Component\Database\Eloquent\Collection;
use Ecjia\App\Orders\GoodsAttr;

class CustomizeOrderList
{
    
    public static function exportOrderListApi(Collection $orders, $count) {
        $orderlist = $orders->map(function ($item) {
            //计算订单总价格
            $total_fee = $item->goods_amount + $item->shipping_fee + $item->insure_fee + $item->pay_fee + $item->pack_fee + $item->card_fee + $item->tax - $item->integral_money - $item->bonus - $item->discount;
            $goods_number = 0;
            list($label_order_status, $status_code) = OrderStatus::getOrderStatusLabel($item->order_status, $item->shipping_status, $item->pay_status, $item->payment->is_cod);
    
            $data = [
                'seller_id'        => $item->store->store_id,
                'seller_name'      => $item->store->merchants_name,
                'manage_mode'      => $item->store->manage_mode,
    
                'order_id'          => $item->order_id,
                'order_sn'          => $item->order_sn,
                'order_mode'        => in_array($item->extension_code, array('storebuy', 'cashdesk')) ? 'storebuy' : 'default',
                'order_amount'      => $item->order_amount,
                'order_status'      => $item->order_status,
                'shipping_status'   => $item->shipping_status,
                'pay_status'        => $item->pay_status,
                'pay_code'          => $item->payment->pay_code,
                'is_cod'            => $item->payment->is_cod,
                'label_order_status'    => $label_order_status,
                'order_status_code'     => $status_code,
                'order_time'        => ecjia_time_format($item->add_time),
                'total_fee'         => $total_fee,
                'discount'          => $item->discount,
                'goods_number'      => & $goods_number,
                'formated_total_fee'        => ecjia_price_format($total_fee, false),
                'formated_integral_money'   => ecjia_price_format($item->integral_money, false),
                'formated_bonus'            => ecjia_price_format($item->bonus, false),
                'formated_shipping_fee'     => ecjia_price_format($item->shipping_fee, false),
                'formated_discount'         => ecjia_price_format($item->discount, false),
    
                'order_info' => [
                    'pay_code'      => $item->payment->pay_code,
                    'order_amount'  => $item->order_amount,
                    'order_id'      => $item->order_id,
                    'order_sn'      => $item->order_sn,
                    ],
    			
                'refund_info'=> [],
                'goods_list' => [],
            ];
            if (!empty($item->refund_sn)) {
            	list($label_refund_status, $refund_status_code) = OrderStatus::getRefundStatusLabel($item->order_status, $item->rfo_status, $item->rfd_status);
            	$data['refund_info'] = array('refund_sn' => $item->refund_sn, 'refund_status_code' => $refund_status_code, 'label_refund_status' => $label_refund_status);
            }
            $data['goods_list'] = $item->orderGoods->map(function ($item) use (& $goods_number) {
                $attr = GoodsAttr::decodeGoodsAttr($item->goods_attr);
                $subtotal = $item->goods_price * $item->goods_number;
                $goods_number += $item->goods_number;

                $data = [
                    'goods_id'         => $item->goods_id,
                    'name'             => $item->goods_name,
                    'goods_attr_id'    => $item->goods_attr_id,
                    'goods_attr'       => $attr,
                    'goods_number'     => $item->goods_number,
                    'subtotal'         => ecjia_price_format($subtotal, false),
                    'formated_shop_price' => ecjia_price_format($item->goods_price, false),
                    'img' => [
                        'small'    => ecjia_upload_url($item->goods->goods_thumb),
                        'thumb'    => ecjia_upload_url($item->goods->goods_img),
                        'url'      => ecjia_upload_url($item->goods->original_img),
                        ],
                    'is_commented' => empty($item->orderGoods->comment->comment_id) ? 0 : 1,
                    'is_showorder' => empty($item->orderGoods->comment->has_image) ? 0 : 1,
                    ];

                    return $data;
            })->toArray();
            
            
			
            return $data;
        });
        
        return array('order_list' => $orderlist->toArray(), 'count' => $count);
    }
}

// end