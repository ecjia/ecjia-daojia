<?php

namespace Ecjia\App\Orders;

use Ecjia\App\Orders\GoodsAttr;
use ecjia_page;
use ecjia_merchant_page;
use Royalcms\Component\Database\Eloquent\Collection;
use RC_Loader;

class CustomizeOrderList
{

    public static function exportOrderListApi(Collection $orders, $count)
    {
        $orderlist = $orders->map(function ($item) {
            //计算订单总价格
            $total_fee    = $item->goods_amount + $item->shipping_fee + $item->insure_fee + $item->pay_fee + $item->pack_fee + $item->card_fee + $item->tax - $item->integral_money - $item->bonus - $item->discount;
            $goods_number = 0;
            list($label_order_status, $status_code) = OrderStatus::getOrderStatusLabel($item->order_status, $item->shipping_status, $item->pay_status, $item->payment_model->is_cod);

            $data = [
                'seller_id'   => $item->store_franchisee_model->store_id,
                'seller_name' => $item->store_franchisee_model->merchants_name,
                'manage_mode' => $item->store_franchisee_model->manage_mode,

                'order_id'                => $item->order_id,
                'order_sn'                => $item->order_sn,
//                'order_mode'              => in_array($item->extension_code, array('storebuy', 'cashdesk')) ? 'storebuy' : 'default',
                'extension_code'          => empty($item->extension_code) ? null : $item->extension_code,
                'extension_id'            => empty($item->extension_id) ? 0 : $item->extension_id,
                'order_amount'            => $item->order_amount,
                'order_status'            => $item->order_status,
                'shipping_status'         => $item->shipping_status,
                'pay_status'              => $item->pay_status,
                'pay_code'                => $item->payment_model->pay_code,
                'is_cod'                  => $item->payment_model->is_cod,
                'label_order_status'      => $label_order_status,
                'order_status_code'       => $status_code,
                'order_time'              => ecjia_time_format($item->add_time),
                'total_fee'               => number_format($total_fee, 2, '.', ''),
                'discount'                => $item->discount,
                'goods_number'            => &$goods_number,
                'formated_total_fee'      => ecjia_price_format($total_fee, false),
                'formated_integral_money' => ecjia_price_format($item->integral_money, false),
                'formated_bonus'          => ecjia_price_format($item->bonus, false),
                'formated_shipping_fee'   => ecjia_price_format($item->shipping_fee, false),
                'formated_discount'       => ecjia_price_format($item->discount, false),

                'order_info' => [
                    'pay_code'     => $item->payment_model->pay_code,
                    'order_amount' => $item->order_amount,
                    'order_id'     => $item->order_id,
                    'order_sn'     => $item->order_sn,
                ],
                'goods_list' => [],
            ];
            if (in_array($item->extension_code, array('storebuy', 'cashdesk'))) {
                $data['order_mode']       = 'storebuy';
                $data['label_order_mode'] = __('扫码购', 'orders');
            } elseif ($item->extension_code == 'storepickup') {
                $data['order_mode']       = 'storepickup';
                $data['label_order_mode'] = __('自提', 'orders');
            } elseif ($item->extension_code == 'group_buy') {
                $data['order_mode']       = 'groupbuy';
                $data['label_order_mode'] = __('团购', 'orders');
            } else {
                $data['order_mode']       = 'default';
                $data['label_order_mode'] = __('配送', 'orders');
            }

            $data['goods_list'] = $item->order_goods_collection->map(function ($item) use (&$goods_number) {
                $attr         = GoodsAttr::decodeGoodsAttr($item->goods_attr);
                $subtotal     = $item->goods_price * $item->goods_number;
                $goods_number += $item->goods_number;
                
                if ($item->product_id > 0) {
                	if (!empty($item->products_model->product_thumb)) {
                		$goods_thumb = $item->products_model->product_thumb;
                	}
                	if (!empty($item->products_model->product_img)) {
                		$goods_img = $item->products_model->product_img;
                	}
                	if (!empty($item->products_model->product_original_img)) {
                		$original_img = $item->products_model->product_original_img;
                	}
                }
                
                $data = [
                    'goods_id'            => $item->goods_id,
                    'name'                => $item->goods_name,
                    'goods_attr_id'       => $item->goods_attr_id,
                    'goods_attr'          => $attr,
                    'goods_number'        => $item->goods_number,
                    'subtotal'            => ecjia_price_format($subtotal, false),
                    'formated_shop_price' => ecjia_price_format($item->goods_price, false),
                    'img'                 => [
						                        'small' => !empty($goods_thumb) ? ecjia_upload_url($goods_thumb) : ecjia_upload_url($item->goods_model->goods_img),
						                        'thumb' => !empty($goods_img) ? ecjia_upload_url($goods_img) : ecjia_upload_url($item->goods_model->goods_thumb),
						                        'url'   => !empty($original_img) ?  ecjia_upload_url($original_img) : ecjia_upload_url($item->goods_model->original_img),
						                    ],
                    'is_commented'        => empty($item->comment_model->comment_id) ? 0 : 1,
                    'is_showorder'        => empty($item->comment_model->has_image) ? 0 : 1,
                ];

                return $data;
            })->toArray();

            return $data;
        });

        return array('order_list' => $orderlist->toArray(), 'count' => $count);
    }

    public static function exportOrderListAdmin(Collection $orders, $count, $pagesize, $filter_count)
    {
        RC_Loader::load_app_func('admin_goods', 'goods');
        $order_deposit = price_format(0);

        $orderlist = $orders->map(function ($item) {
            //计算订单总价格
            $total_fee = $item->goods_amount + $item->shipping_fee + $item->insure_fee + $item->pay_fee + $item->pack_fee + $item->card_fee + $item->tax - $item->integral_money - $item->bonus - $item->discount;

            list($label_order_status, $status_code) = OrderStatus::getAdminOrderStatusLabel($item->order_status, $item->shipping_status, $item->pay_status, $item->payment_model->is_cod);

            $goods_number = 0;
            $goods_number = $item->order_goods_collection->map(function ($item) use (&$goods_number) {
                $goods_number += $item->goods_number;
                return $goods_number;
            })->toArray();
            $goods_number = $goods_number[0];

            $group_buy = group_buy_info($item->extension_id);
            if ($group_buy['deposit'] > 0) {
                $order_deposit = price_format($goods_number * $group_buy['deposit']);
            }

            $data = [
                'seller_id'   => $item->store_franchisee_model->store_id,
                'seller_name' => $item->store_franchisee_model->merchants_name,
                'manage_mode' => $item->store_franchisee_model->manage_mode,

                'order_id'                => $item->order_id,
                'order_sn'                => $item->order_sn,
                //'order_mode'        => in_array($item->extension_code, array('storebuy', 'cashdesk')) ? 'storebuy' : 'default',
                'extension_code'          => empty($item->extension_code) ? null : $item->extension_code,
                'extension_id'            => empty($item->extension_id) ? 0 : $item->extension_id,
                'order_amount'            => $item->order_amount,
                'order_status'            => $item->order_status,
                'shipping_status'         => $item->shipping_status,
                'pay_status'              => $item->pay_status,
                'pay_code'                => $item->payment_model->pay_code,
                'is_cod'                  => $item->payment_model->is_cod,
                'label_order_status'      => $label_order_status,
                'order_status_code'       => $status_code,
                'order_time'              => ecjia_time_format($item->add_time),
                'total_fee'               => sprintf("%.2f", $total_fee),
                'discount'                => $item->discount,
                'goods_number'            => &$goods_number,
                'formated_total_fee'      => ecjia_price_format($total_fee, false),
                'formated_integral_money' => ecjia_price_format($item->integral_money, false),
                'formated_bonus'          => ecjia_price_format($item->bonus, false),
                'formated_shipping_fee'   => ecjia_price_format($item->shipping_fee, false),
                'formated_discount'       => ecjia_price_format($item->discount, false),
                'formated_order_amount'   => ecjia_price_format($item->order_amount, false),

                'order_info' => [
                    'pay_code'     => $item->payment_model->pay_code,
                    'order_amount' => $item->order_amount,
                    'order_id'     => $item->order_id,
                    'order_sn'     => $item->order_sn,
                ],
                'goods_list' => [],
                'consignee'  => $item->consignee,

                'formated_bond'        => $order_deposit,
                'groupbuy_valid_goods' => $group_buy['valid_goods'],
                'groupbuy_status_desc' => $group_buy['status_desc'],
                'groupbuy_status'      => $group_buy['status']
            ];
            if ($item->extension_code == 'storebuy') {
                $data['order_mode']       = 'storebuy';
                $data['label_order_mode'] = __('扫码购', 'orders');
            } elseif ($item->extension_code == 'cashdesk') {
                $data['order_mode']       = 'cashdesk';
                $data['label_order_mode'] = __('收银台', 'orders');
            } elseif ($item->extension_code == 'storepickup') {
                $data['order_mode']       = 'storepickup';
                $data['label_order_mode'] = __('自提', 'orders');
            } elseif ($item->extension_code == 'group_buy') {
                $data['order_mode']       = 'groupbuy';
                $data['label_order_mode'] = __('团购', 'orders');
            } else {
                $data['order_mode']       = 'default';
                $data['label_order_mode'] = __('配送', 'orders');
            }
            return $data;
        });
        $page      = new ecjia_page($count, $pagesize, 6);

        return array('order_list' => $orderlist->toArray(), 'count' => $count, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'filter_count' => $filter_count);
    }

    public static function exportOrderListMerchant(Collection $orders, $count, $pagesize, $filter_count)
    {
        RC_Loader::load_app_func('admin_goods', 'goods');
        $order_deposit = price_format(0);

        $orderlist = $orders->map(function ($item) {
            //计算订单总价格
            $total_fee = $item->goods_amount + $item->shipping_fee + $item->insure_fee + $item->pay_fee + $item->pack_fee + $item->card_fee + $item->tax - $item->integral_money - $item->bonus - $item->discount;

            list($label_order_status, $status_code) = OrderStatus::getAdminOrderStatusLabel($item->order_status, $item->shipping_status, $item->pay_status, $item->payment_model->is_cod);

            $goods_number = 0;
            $goods_number = $item->order_goods_collection->map(function ($item) use (&$goods_number) {
                $goods_number += $item->goods_number;
                return $goods_number;
            })->toArray();
            $goods_number = $goods_number[0];

            $group_buy = group_buy_info($item->extension_id);
            if ($group_buy['deposit'] > 0) {
                $order_deposit = price_format($goods_number * $group_buy['deposit']);
            }

            $data = [
                'seller_id'   => $item->store_franchisee_model->store_id,
                'seller_name' => $item->store_franchisee_model->merchants_name,
                'manage_mode' => $item->store_franchisee_model->manage_mode,

                'order_id'                => $item->order_id,
                'order_sn'                => $item->order_sn,
                //'order_mode'        => in_array($item->extension_code, array('storebuy', 'cashdesk')) ? 'storebuy' : 'default',
                'extension_code'          => empty($item->extension_code) ? null : $item->extension_code,
                'extension_id'            => empty($item->extension_id) ? 0 : $item->extension_id,
                'order_amount'            => $item->order_amount,
                'order_status'            => $item->order_status,
                'shipping_status'         => $item->shipping_status,
                'pay_status'              => $item->pay_status,
                'pay_code'                => $item->payment_model->pay_code,
                'is_cod'                  => $item->payment_model->is_cod,
                'label_order_status'      => $label_order_status,
                'order_status_code'       => $status_code,
                'order_time'              => ecjia_time_format($item->add_time),
                'total_fee'               => sprintf("%.2f", $total_fee),
                'discount'                => $item->discount,
                'goods_number'            => &$goods_number,
                'formated_total_fee'      => ecjia_price_format($total_fee, false),
                'formated_integral_money' => ecjia_price_format($item->integral_money, false),
                'formated_bonus'          => ecjia_price_format($item->bonus, false),
                'formated_shipping_fee'   => ecjia_price_format($item->shipping_fee, false),
                'formated_discount'       => ecjia_price_format($item->discount, false),
                'formated_order_amount'   => ecjia_price_format($item->order_amount, false),

                'order_info' => [
                    'pay_code'     => $item->payment_model->pay_code,
                    'order_amount' => $item->order_amount,
                    'order_id'     => $item->order_id,
                    'order_sn'     => $item->order_sn,
                ],
                'goods_list' => [],
                'consignee'  => $item->consignee,

                'formated_bond'        => $order_deposit,
                'groupbuy_valid_goods' => $group_buy['valid_goods'],
                'groupbuy_status_desc' => $group_buy['status_desc'],
                'groupbuy_status'      => $group_buy['status']
            ];
            if ($item->extension_code == 'storebuy') {
                $data['order_mode']       = 'storebuy';
                $data['label_order_mode'] = __('扫码购', 'orders');
            } elseif ($item->extension_code == 'cashdesk') {
                $data['order_mode']       = 'cashdesk';
                $data['label_order_mode'] = __('收银台', 'orders');
            } elseif ($item->extension_code == 'storepickup') {
                $data['order_mode']       = 'storepickup';
                $data['label_order_mode'] = __('自提', 'orders');
            } elseif ($item->extension_code == 'group_buy') {
                $data['order_mode']       = 'groupbuy';
                $data['label_order_mode'] = __('团购', 'orders');
            } else {
                $data['order_mode']       = 'default';
                $data['label_order_mode'] = __('配送', 'orders');
            }
            return $data;
        });
        $page      = new ecjia_merchant_page($count, $pagesize, 6);

        return array('order_list' => $orderlist->toArray(), 'count' => $count, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'filter_count' => $filter_count);
    }

    public static function exportAllOrderListAdmin(Collection $orders)
    {
        $orderlist = $orders->map(function ($item) {
            //计算订单总价格
            $total_fee = $item->goods_amount + $item->shipping_fee + $item->insure_fee + $item->pay_fee + $item->pack_fee + $item->card_fee + $item->tax - $item->integral_money - $item->bonus - $item->discount;

            list($label_order_status, $status_code) = OrderStatus::getAdminOrderStatusLabel($item->order_status, $item->shipping_status, $item->pay_status, $item->payment_model->is_cod);
            $data = [
                'order_sn'              => $item->order_sn,
                'seller_name'           => $item->store_franchisee_model->merchants_name,
                'order_time'            => ecjia_time_format($item->add_time),
                'consignee'             => $item->consignee,
                'formated_total_fee'    => ecjia_price_format($total_fee, false),
                'formated_order_amount' => ecjia_price_format($item->order_amount, false),
                'label_order_status'    => $label_order_status,
            ];

            return $data;
        });

        return $orderlist->toArray();
    }

    public static function exportAllOrderListMerchant(Collection $orders)
    {
        $orderlist = $orders->map(function ($item) {
            //计算订单总价格
            $total_fee = $item->goods_amount + $item->shipping_fee + $item->insure_fee + $item->pay_fee + $item->pack_fee + $item->card_fee + $item->tax - $item->integral_money - $item->bonus - $item->discount;

            list($label_order_status, $status_code) = OrderStatus::getAdminOrderStatusLabel($item->order_status, $item->shipping_status, $item->pay_status, $item->payment_model->is_cod);
            $data = [
                'order_sn'              => $item->order_sn,
                'order_time'            => ecjia_time_format($item->add_time),
                'consignee'             => $item->consignee,
                'formated_total_fee'    => ecjia_price_format($total_fee, false),
                'formated_order_amount' => ecjia_price_format($item->order_amount, false),
                'label_order_status'    => $label_order_status,
            ];
            return $data;
        });

        return $orderlist->toArray();
    }
}

// end
