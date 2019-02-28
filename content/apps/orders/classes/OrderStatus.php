<?php

namespace Ecjia\App\Orders;

use RC_DB;
use RC_Loader;

class OrderStatus
{
    /* 已完成订单 */
    const FINISHED = 'finished';

    /* 待付款订单 */
    const AWAIT_PAY = 'await_pay';

    /* 待发货订单 */
    const AWAIT_SHIP = 'await_ship';

    /* 后台待发货订单 */
    const ADMIN_AWAIT_SHIP = 'admin_await_ship';

    /* 未确认订单 */
    const UNCONFIRMED = 'unconfirmed';

    /* 待接单 */
    const ADMIN_UNCONFIRMED = 'admin_unconfirmed';

    /* 未处理订单：用户可操作 */
    const UNPROCESSED = 'unprocessed';

    /* 未付款未发货订单：管理员可操作 */
    const UNPAY_UNSHIP = 'unpay_unship';

    /* 已发货订单：不论是否付款 */
    const SHIPPED = 'shipped';

    /* 退货 */
    const REFUND = 'refund';

    /* 无效 */
    const INVALID = 'invalid';

    /* 取消 */
    const CANCELED = 'canceled';

    /* 待评论 */
    const ALLOW_COMMENT = 'allow_comment';

    /* 备货中订单 */
    const PREPARING = 'preparing';

    /* 发货中订单 */
    const SHIPPED_ING = 'shipped_ing';

    /* 已发货（部分商品） */
    const SHIPPED_PART = 'shipped_part';

    /**
     * 订单状态映射
     *
     * @var array
     */
    protected static $orderTypes = [
        self::FINISHED          => 'queryOrderFinished',
        self::AWAIT_PAY         => 'queryOrderAwaitPay',
        self::AWAIT_SHIP        => 'queryOrderAwaitShip',
        self::ADMIN_AWAIT_SHIP  => 'queryAdminOrderAwaitShip',
        self::UNCONFIRMED       => 'queryOrderUnconfirmed',
        self::ADMIN_UNCONFIRMED => 'queryAdminOrderUnconfirmed',
        self::UNPROCESSED       => 'queryOrderUnprocessed',
        self::UNPAY_UNSHIP      => 'queryOrderUnpayUnship',
        self::SHIPPED           => 'queryOrderShipped',
        self::REFUND            => 'queryOrderRefund',
        self::INVALID           => 'queryOrderInvalid',
        self::CANCELED          => 'queryOrderCanceled',
        self::ALLOW_COMMENT     => 'queryOrderAllowComment',
        self::PREPARING         => 'queryOrderPreparing',
        self::SHIPPED_ING       => 'queryOrderShippedIng',
        self::SHIPPED_PART      => 'queryOrderShippedPart',
    ];

    public static function getOrderStatusLabel($order_status, $shipping_status, $pay_status, $is_cod)
    {
        if (in_array($order_status, array(OS_UNCONFIRMED, OS_SPLITED)) &&
            (in_array($pay_status, array(PS_UNPAYED)) && !$is_cod)) {
            $label_order_status = __(__('未付款', 'orders'), 'orders');
            $status_code        = 'await_pay';
        } elseif (in_array($order_status, array(OS_UNCONFIRMED)) &&
            in_array($shipping_status, array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) &&
            in_array($pay_status, array(PS_PAYED))) {
            $label_order_status = __(__('已付款', 'orders'), 'orders');
            $status_code        = 'payed';
        } elseif (in_array($order_status, array(OS_UNCONFIRMED)) &&
            in_array($shipping_status, array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) &&
            (in_array($pay_status, array(PS_PAYED, PS_PAYING)) || $is_cod)) {
            $label_order_status = __(__('未接单', 'orders'), 'orders');
            $status_code        = 'unconfirmed';
        } elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
            in_array($shipping_status, array(SS_UNSHIPPED)) &&
            (in_array($pay_status, array(PS_PAYED, PS_PAYING)) || $is_cod)) {
            $label_order_status = __(__('已接单', 'orders'), 'orders');
            $status_code        = 'confirmed';
        } elseif (in_array($shipping_status, array(SS_PREPARING)) && $order_status != OS_RETURNED) {
            $label_order_status = __('备货中', 'orders');
            $status_code        = 'shipping';
        } elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
            in_array($shipping_status, array(SS_SHIPPED_ING)) &&
            (in_array($pay_status, array(PS_PAYED)) || $is_cod)) {
            $label_order_status = __(__('发货中', 'orders'), 'orders');
            $status_code        = 'shipped_ing';
        } elseif (in_array($shipping_status, array(SS_SHIPPED)) && ($order_status != OS_RETURNED)) {
            $label_order_status = __(__('已发货', 'orders'), 'orders');
            $status_code        = 'shipped';
        } elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
            in_array($shipping_status, array(SS_SHIPPED_PART))) {
            $label_order_status = __('已发货（部分商品）', 'orders');
            $status_code        = 'shipped_part';
        } elseif (in_array($order_status, array(OS_CANCELED, OS_INVALID))) {
            $label_order_status = __('已取消', 'orders');
            $status_code        = 'canceled';
        } elseif (in_array($order_status, array(OS_RETURNED)) && $pay_status == PS_PAYED) {
            $label_order_status = __('已申请退货', 'orders');
            $status_code        = 'refund';
        } elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED)) &&
            in_array($shipping_status, array(SS_RECEIVED)) &&
            in_array($pay_status, array(PS_PAYED, PS_PAYING))) {
            $label_order_status = __('交易完成', 'orders');
            $status_code        = 'finished';
        }
        return array($label_order_status, $status_code);
    }

    public static function getQueryOrder($type)
    {
        $method = array_get(self::$orderTypes, $type);
        if ($method) {
            return self::$method();
        }
        return null;
    }

    /* 已完成订单 */
    public static function queryOrderFinished()
    {
        return function ($query) {
            $query->whereIn('order_info.order_status', array(OS_CONFIRMED, OS_SPLITED))
                ->whereIn('order_info.shipping_status', array(SS_RECEIVED))
                ->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING));
        };

    }

    /* 待付款订单 */
    public static function queryOrderAwaitPay()
    {
        /*货到付款订单不在待付款里显示*/
        $pay_cod_id = RC_DB::table('payment')->where('pay_code', 'pay_cod')->pluck('pay_id');
        if (!empty($pay_cod_id)) {
            return function ($query) use ($pay_cod_id) {
                $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED))
                    ->where('order_info.pay_status', PS_UNPAYED)
                    ->where('order_info.pay_id', '<>', $pay_cod_id);
            };
        } else {
            return function ($query) {
                $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED))
                    ->where('order_info.pay_status', PS_UNPAYED);
            };
        }
    }

    /* 待发货订单 */
    public static function queryOrderAwaitShip()
    {
        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        $payment_ids    = $payment_method->payment_id_list(true);

        if (!empty($payment_ids)) {
            return function ($query) use ($payment_ids) {
                $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
                    ->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING))
                    ->where(function ($query) use ($payment_ids) {
                        $query->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING))
                            ->orWhere(function ($query) use ($payment_ids) {
                                $query->whereIn('pay_id', $payment_ids);
                            });
                    });

            };
        } else {
            return function ($query) {
                $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
                    ->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING))
                    ->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING));
            };
        }
    }

    /* 后台待发货订单 */
    public static function queryAdminOrderAwaitShip()
    {
        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        $payment_ids    = $payment_method->payment_id_list(true);

        if (!empty($payment_ids)) {
            return function ($query) use ($payment_ids) {
                $query->whereIn('order_info.order_status', array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
                    ->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING))
                    ->where(function ($query) use ($payment_ids) {
                        $query->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING))
                            ->orWhere(function ($query) use ($payment_ids) {
                                $query->whereIn('pay_id', $payment_ids);
                            });
                    });

            };
        } else {
            return function ($query) {
                $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
                    ->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING))
                    ->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING));
            };
        }
    }

    /* 未确认订单 */
    public static function queryOrderUnconfirmed()
    {
        return function ($query) {
            $query->where('order_info.order_status', OS_UNCONFIRMED);
        };
    }

    /* 未处理订单：用户可操作 */
    public static function queryOrderUnprocessed()
    {
        return function ($query) {
            $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED))
                ->where('order_info.shipping_status', SS_UNSHIPPED)
                ->where('order_info.pay_status', PS_UNPAYED);
        };
    }

    /* 未付款未发货订单：管理员可操作 */
    public static function queryOrderUnpayUnship()
    {
        return function ($query) {
            $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED))
                ->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING))
                ->where('order_info.pay_status', PS_UNPAYED);
        };
    }

    /* 已发货订单：不论是否付款 */
    public static function queryOrderShipped()
    {
        return function ($query) {
            $query->where('order_info.shipping_status', SS_SHIPPED)
                ->where('order_info.order_status', '<>', OS_RETURNED);
        };
    }

    /* 退款 */
    public static function queryOrderRefund()
    {
        return function ($query) {
            $query->where('order_info.order_status', OS_RETURNED);
        };
    }

    /* 无效 */
    public static function queryOrderInvalid()
    {
        return function ($query) {
            $query->where('order_info.order_status', OS_INVALID);
        };
    }

    /* 取消 */
    public static function queryOrderCanceled()
    {
        return function ($query) {
            $query->where('order_info.order_status', OS_CANCELED);
        };
    }

    /* 待评论 */
    public static function queryOrderAllowComment()
    {
        return function ($query) {
            $query->leftJoin('order_goods', function ($join) {
                $join->on('order_info.order_id', '=', 'order_goods.order_id');
            })->leftJoin('comment', function ($join) {
                $join->on('order_goods.rec_id', '=', 'comment.rec_id')
                    ->on('comment.id_value', '=', 'order_goods.goods_id')
                    ->on('comment.order_id', '=', 'order_goods.order_id')
                    ->where('comment.comment_type', '=', 0)
                    ->where('comment.parent_id', '=', 0);
            });

            $query->whereIn('order_info.order_status', [OS_CONFIRMED, OS_SPLITED])
                ->whereIn('order_info.pay_status', [PS_PAYED, PS_PAYING])
                ->where('order_info.shipping_status', SS_RECEIVED);

            $fields = array('comment.comment_id', 'comment.has_image');
            $query->addSelect($fields);
            $query->whereNull('comment.comment_id');
        };
    }

    /* 待接单 */
    public static function queryAdminOrderUnconfirmed()
    {
        return function ($query) {
            $query->where('order_info.order_status', OS_UNCONFIRMED)
                ->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING))
                ->where('order_info.pay_status', PS_PAYED);
        };
    }

    /* 备货中订单 */
    public static function queryOrderPreparing()
    {
        return function ($query) {
            $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
                ->where('order_info.shipping_status', SS_PREPARING);
        };
    }

    /* 发货中订单 */
    public static function queryOrderShippedIng()
    {
        return function ($query) {
            $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
                ->where('order_info.shipping_status', SS_SHIPPED_ING);
        };
    }

    /* 已发货（部分商品） */
    public static function queryOrderShippedPart()
    {
        return function ($query) {
            $query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
                ->where('order_info.shipping_status', SS_SHIPPED_PART);
        };
    }

    public static function getAdminOrderStatusLabel($order_status, $shipping_status, $pay_status, $is_cod)
    {
        if (in_array($order_status, array(OS_SPLITED, OS_UNCONFIRMED)) &&
            in_array($pay_status, array(PS_UNPAYED))) {
            $label_order_status = __(__('未付款', 'orders'), 'orders');
            $status_code        = 'await_pay';
        } elseif (in_array($order_status, array(OS_UNCONFIRMED)) &&
            in_array($shipping_status, array(SS_UNSHIPPED)) &&
            (in_array($pay_status, array(PS_PAYED, PS_PAYING)) || $is_cod)) {
            $label_order_status = __(__('未接单', 'orders'), 'orders');
            $status_code        = 'unconfirmed';
        } elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
            in_array($shipping_status, array(SS_UNSHIPPED)) &&
            (in_array($pay_status, array(PS_PAYED, PS_PAYING)) || $is_cod)) {
            $label_order_status = __(__('已接单', 'orders'), 'orders');
            $status_code        = 'confirmed';
        } elseif (in_array($shipping_status, array(SS_PREPARING)) && $order_status != OS_RETURNED) {
            $label_order_status = __('备货中', 'orders');
            $status_code        = 'shipping';
        } elseif (in_array($order_status, array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
            in_array($shipping_status, array(SS_SHIPPED_ING))) {
            $label_order_status = __(__('发货中', 'orders'), 'orders');
            $status_code        = 'shipped_ing';
        } elseif (in_array($shipping_status, array(SS_SHIPPED)) && $order_status != OS_RETURNED) {
            $label_order_status = __(__('已发货', 'orders'), 'orders');
            $status_code        = 'shipped';
        } elseif (in_array($order_status, array(OS_SPLITING_PART)) &&
            in_array($shipping_status, array(SS_SHIPPED_PART))) {
            $label_order_status = __('已发货（部分商品）', 'orders');
            $status_code        = 'shipped_part';
        } elseif (in_array($order_status, array(OS_CANCELED, OS_INVALID))) {
            $label_order_status = __('已取消', 'orders');
            $status_code        = 'canceled';
        } elseif (in_array($order_status, array(OS_RETURNED)) && $pay_status == PS_PAYED) {
            $label_order_status = __('已申请退货', 'orders');
            $status_code        = 'refund';
        } elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED)) &&
            in_array($shipping_status, array(SS_RECEIVED)) &&
            in_array($pay_status, array(PS_PAYED, PS_PAYING))) {
            $label_order_status = __('交易完成', 'orders');
            $status_code        = 'finished';
        }
        return array($label_order_status, $status_code);
    }

    public static function getOrderFlowLabel($order = [])
    {
        $time_key       = 1;
        $label_pay      = __('买家未付款', 'orders');
        $label_confirm  = __('商家未接单', 'orders');
        $label_shipping = __('商家未发货', 'orders');

        if ($order['pay_time'] > 0 || $order['is_cod'] == 1) {
            if ($order['shipping_status'] == SS_UNSHIPPED) {
                if ($order['pay_status'] == PS_UNPAYED) {
                    $label_pay = __('买家未付款', 'orders');
                }
                if ($order['is_cod'] == 1) {
                    $time_key  = 2;
                    $label_pay = __('货到付款', 'orders');
                }
                if ($order['pay_status'] == PS_PAYED) {
                    $time_key  = 2;
                    $label_pay = __('买家已付款', 'orders');
                }

                if ($order['order_status'] == OS_CANCELED) {
                    $time_key      = 3;
                    $label_confirm = __('订单已取消', 'orders');
                } elseif (in_array($order['order_status'], array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))) {
                    $time_key      = 3;
                    $label_confirm = __('商家已接单', 'orders');
                }
            } else {
                if ($order['is_cod'] == 1) {
                    $label_pay = __('货到付款', 'orders');
                } else {
                    $label_pay = __('买家已付款', 'orders');
                }
                $time_key      = 3;
                $label_confirm = __('商家已接单', 'orders');
            }
            if ($order['shipping_status'] == SS_SHIPPED) {
                $time_key       = 4;
                $label_shipping = __('商家已发货', 'orders');
            }
            if ($order['shipping_status'] == SS_SHIPPED_PART) {
                $time_key       = 4;
                $label_shipping = __('商家已发货（部分商品）', 'orders');
            }
            if ($order['shipping_status'] == SS_SHIPPED_ING) {
                $time_key       = 4;
                $label_shipping = __('发货中(处理分单)', 'orders');
            }
            if ($order['shipping_status'] == SS_RECEIVED) {
                $time_key       = 5;
                $label_shipping = __('商家已发货', 'orders');
            }
        }
        return array(
            'pay'      => $label_pay,
            'confirm'  => $label_confirm,
            'shipping' => $label_shipping,
            'key'      => $time_key,
        );
    }

    public static function getOrderCsStatusList()
    {
        return array(
            CS_AWAIT_PAY    => __('待付款', 'orders'),
            CS_UNCONFIRMED  => __('待接单', 'orders'),
            CS_AWAIT_SHIP   => __('待发货', 'orders'),
            CS_SHIPPED      => __(__('已发货', 'orders'), 'orders'),
            CS_FINISHED     => __('已完成', 'orders'),
            CS_CANCELED     => __('取消', 'orders'),
            CS_REFUND       => __('退货', 'orders'),
            CS_SHIPPED_PART => __('部分发货', 'orders'),
        );
    }

    public static function getOrderSsStatusLabel($shipping_status = '')
    {
        $ss = array(
            SS_UNSHIPPED    => __(__('未发货', 'orders'), 'orders'),
            SS_PREPARING    => __(__('配货中', 'orders'), 'orders'),
            SS_SHIPPED      => __(__('已发货', 'orders'), 'orders'),
            SS_RECEIVED     => __(__('收货确认', 'orders'), 'orders'),
            SS_SHIPPED_PART => __(__('已发货(部分商品)', 'orders'), 'orders'),
            SS_SHIPPED_ING  => __(__('发货中', 'orders'), 'orders'),
        );

        if (!array_key_exists($ss, $shipping_status)) {
            return __(__('未发货', 'orders'), 'orders');
        }

        return array_get($shipping_status, $ss);
    }

    public static function getOrderPsStatusLabel($pay_status = '')
    {
        $ps = array(
            PS_UNPAYED => __(__('未付款', 'orders'), 'orders'),
            PS_PAYING  => __(__('付款中', 'orders'), 'orders'),
            PS_PAYED   => __(__('已付款', 'orders'), 'orders'),
        );

        if (!array_key_exists($ps, $pay_status)) {
            return __(__('未付款', 'orders'), 'orders');
        }

        return array_get($pay_status, $ps);
    }

    public static function getOrderOsStatusLabel($order_status = '')
    {
        $os = array(
            OS_UNCONFIRMED   => __(__('未接单', 'orders'), 'orders'),
            OS_CONFIRMED     => __(__('已接单', 'orders'), 'orders'),
            OS_CANCELED      => __(__('<font color="red">取消</font>', 'orders'), 'orders'),
            OS_INVALID       => __(__('<font color="red">无效</font>', 'orders'), 'orders'),
            OS_RETURNED      => __(__('<font color="red">退货</font>', 'orders'), 'orders'),
            OS_SPLITED       => __(__('已分单', 'orders'), 'orders'),
            OS_SPLITING_PART => __(__('部分分单', 'orders'), 'orders'),
        );
        if (!array_key_exists($os, $order_status)) {
            return __(__('未发货', 'orders'), 'orders');
        }

        return array_get($order_status, $os);
    }

}
