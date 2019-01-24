<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/14
 * Time: 15:09
 */

namespace Ecjia\App\Quickpay\PaidOrder;

use Ecjia\System\Frameworks\Contracts\PaidOrderProcessInterface;
use Ecjia\App\Payment\Models\PaymentRecordModel;
use RC_Api;
use RC_Time;
use RC_DB;
use ecjia;

class PaidOrderProcess implements PaidOrderProcessInterface
{

    protected $order_sn;

    protected $record_model;

    /**
     * PaidOrderProcess constructor.
     * @param PaymentRecordModel $record_model
     */
    public function __construct(PaymentRecordModel $record_model)
    {
        $this->order_sn = $record_model->order_sn;
        $this->record_model = $record_model;
    }

    /**
     *
     * @return PaymentRecordModel
     */
    public function getPaymentRecordModel()
    {
        return $this->record_model;
    }

    /**
     * 获取订单信息
     *
     * @return array
     */
    public function getOrderInfo()
    {
        $order_info = RC_Api::api('quickpay', 'quickpay_order_info', array('order_sn' => $this->order_sn));

        return $order_info;
    }


    /**
     * 获取支付数据
     */
    public function getPaymentData()
    {
        $order_info = $this->getOrderInfo();

        $pay_data = array(
            'order_id' 					=> intval($order_info['order_id']),
            'money_paid'				=> $order_info['order_amount'] + $order_info['surplus'],
            'formatted_money_paid'		=> ecjia_price_format(($order_info['order_amount'] + $order_info['surplus']), false),
            'order_amount'				=> 0.00,
            'formatted_order_amount'	=> ecjia_price_format(0, false),
            'pay_code'					=> $this->record_model->pay_code,
            'pay_name'					=> $this->record_model->pay_name,
            'pay_status'				=> 'success',
            'desc'						=> '订单支付成功！'
        );

        return $pay_data;
    }

    /**
     * 获取打印数据
     */
    public function getPrintData()
    {
        $order_info = $this->getOrderInfo();

        $quickpay_print_data = [];

        if ($order_info) {
            $total_discount 		= $order_info['discount'] + $order_info['integral_money'] + $order_info['bonus'];
            $money_paid 			= $order_info['order_amount'] + $order_info['surplus'];

            //下单收银员
            $cashier_name = RC_DB::table('cashier_record as cr')
                ->leftJoin('staff_user as su', RC_DB::raw('cr.staff_id'), '=', RC_DB::raw('su.user_id'))
                ->where(RC_DB::raw('cr.order_id'), $order_info['order_id'])
                ->where('action', 'receipt')
                ->pluck('name');

            $user_info = [];
            //有没用户
            if ($order_info['user_id'] > 0) {
                $userinfo = $this->getUserInfo($order_info['user_id']);
                if (!empty($userinfo)) {
                    $user_info = array(
                        'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
                        'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
                        'user_points'			=> $userinfo['pay_points'],
                        'user_money'			=> $userinfo['user_money'],
                        'formatted_user_money'	=> ecjia_price_format($userinfo['user_money'], false),
                    );
                }
            }

            $payment_account = $this->record_model->payer_login;

            $quickpay_print_data = array(
                'order_sn' 						=> $order_info['order_sn'],
                'trade_no'						=> $this->record_model->trade_no ? $this->record_model->trade_no : '',
                'order_trade_no'				=> $this->record_model->order_trade_no ? $this->record_model->order_trade_no : '',
                'trade_type'					=> 'quickpay',
                'pay_time'						=> empty($order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']),
                'goods_list'					=> [],
                'total_goods_number' 			=> 0,
                'total_goods_amount'			=> $order_info['goods_amount'],
                'formatted_total_goods_amount'	=> ecjia_price_format($order_info['goods_amount'], false),
                'total_discount'				=> $total_discount,
                'formatted_total_discount'		=> ecjia_price_format($total_discount, false),
                'money_paid'					=> $money_paid,
                'formatted_money_paid'			=> ecjia_price_format($money_paid, false),
                'integral'						=> intval($order_info['integral']),
                'integral_money'				=> $order_info['integral_money'],
                'formatted_integral_money'		=> ecjia_price_format($order_info['integral_money'], false),
                'pay_code'						=> !empty($this->record_model->pay_code) ? $this->record_model->pay_code : '',
                'pay_name'						=> !empty($this->record_model->pay_name) ? $this->record_model->pay_name : '',
                'payment_account'				=> $payment_account,
                'user_info'						=> $user_info,
                'refund_sn'						=> '',
                'refund_total_amount'			=> 0,
                'formatted_refund_total_amount' => '',
                'cashier_name'					=> empty($cashier_name) ? '' : $cashier_name,
            	'pay_fee'						=> '', //买单订单增加支付手续费返回
            	'formatted_pay_fee'				=> '',
            );
        }

        return $quickpay_print_data;
    }


    /**
     * 用户信息
     *
     * @param integer $user_id
     * @return array
     */
    protected function getUserInfo ($user_id)
    {
        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
        return $user_info;
    }

}