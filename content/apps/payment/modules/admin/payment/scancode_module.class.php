<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/29
 * Time: 3:38 PM
 */

defined('IN_ECJIA') or exit('No permission resources.');

use Royalcms\Component\Shouqianba\Gateways\Shouqianba\Orders\PayOrder;

/**
 * 订单支付
 * @author royalwang
 * 16-12-09 增加支付状态
 */
class admin_payment_scancode_module extends api_admin implements api_interface
{

    /**
     * @param int $record_id 支付流水记录
     * @param string $dynamic_code 二维码或条码内容
     *
     * @param \Royalcms\Component\Http\Request $request
     */
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }

        $record_id = $this->requestData('record_id');
        $dynamic_code = $this->requestData('dynamic_code');

        if (empty($dynamic_code)) {
            return new ecjia_error('payment_scancode_content_not_empty', '扫码支付的二维码内容不能为空');
        }

        $paymentRecordRepository = new Ecjia\App\Payment\Repositories\PaymentRecordRepository();

        $record_model = $paymentRecordRepository->find($record_id);
        if (empty($record_model)) {
            return new ecjia_error('payment_record_not_found', '此笔交易记录未找到');
        }

        if ($record_model->pay_code != 'pay_shouqianba') {
            return new ecjia_error('payment_order_not_match', '此笔订单支付方式不匹配');
        }

        $payment_plugin	= new Ecjia\App\Payment\PaymentPlugin();
        $plugin_handler = $payment_plugin->channel($record_model->pay_code);
        $plugin_handler->setPaymentRecord($paymentRecordRepository);

        if ($record_model->trade_type == 'buy') {

            $orderinfo = $this->buyOrderProcessHandler($record_model);

        } elseif ($record_model->trade_type == 'quickpay') {

            $orderinfo = $this->quickpayOrderProcessHandler($record_model);

        } elseif ($record_model->trade_type == 'surplus') {

            $orderinfo = $this->surplusOrderProcessHandler($record_model);

        }

        if (empty($orderinfo)) {
            return new ecjia_error('order_dose_not_exist', $record_model->order_sn . '未找到该订单信息');
        }

        $plugin_config = $plugin_handler->getConfig();

        $order = new PayOrder();
        $order->setClientSn($record_model->order_trade_no);
        $order->setTotalAmount($record_model->total_fee * 100);
        $order->setDynamicId($dynamic_code);
        $order->setSubject($_SESSION['store_name'] . '商户的订单：' . $orderinfo['order_sn']);
        $order->setOperator($_SESSION['staff_name']);

        try {
            $config = config('shouqianba::pay.shouqianba');
            $config['terminal_sn'] = $plugin_config['shouqianba_terminal_sn'];
            $config['terminal_key'] = $plugin_config['shouqianba_terminal_key'];
            $shouqianba = RC_Pay::shouqianba($config);
            $result = $shouqianba->scan($order);

            if ($result['result_code'] == 'PAY_SUCCESS') {
                //支付成功逻辑处理
                if ($result['data']['status'] = 'SUCCESS' && $result['data']['order_status'] == 'PAID') {
                    $this->paySuccess($plugin_handler, $result);

                    return $result;
                }
            } else {
                return $this->payFail($plugin_handler, $result);
            }

        } catch (\Royalcms\Component\Pay\Exceptions\GatewayException $e) {
            return new ecjia_error('shouqianba_api_request_error', $e->getMessage());
        }
    }

    /**
     * 会员充值订单处理
     *
     * @param $record_model
     */
    protected function surplusOrderProcessHandler($record_model)
    {
        /* 查询订单信息 */
        $orderinfo = RC_Api::api('finance', 'user_account_order_info', array('order_sn' => $record_model->order_sn));

        return $orderinfo;
    }

    /**
     * 买单订单支付处理
     *
     * @param $record_model
     */
    protected function quickpayOrderProcessHandler($record_model)
    {
        /* 查询订单信息 */
        $orderinfo = RC_Api::api('quickpay', 'quickpay_order_info', array('order_sn' => $record_model->order_sn));

        return $orderinfo;
    }

    /**
     * 普通订单支付处理
     *
     * @param $record_model
     * @return array
     */
    protected function buyOrderProcessHandler($record_model)
    {
        /* 查询订单信息 */
        $orderinfo = RC_Api::api('orders', 'order_info', array('order_sn' => $record_model->order_sn));

        return $orderinfo;
    }

    /**
     * 支付成功处理
     *
     * @param $handler
     * @param $result
     */
    protected function paySuccess($handler, $result)
    {
        $data = array_get($result, 'data');

        $handler->updateOrderPaid($data['client_sn'], $data['total_amount']/100, $data['sn']);

        $paymentRecord = $handler->getPaymentRecord();
        $paymentRecord->updateChannelPayment($data['client_sn'], [
            'payer_uid'             => $data['payer_uid'],
            'payer_login'           => $data['payer_login'],
            'subject'               => $data['subject'],
            'operator'              => $data['operator'],
            'channel_payway'        => $data['payway'],
            'channel_payway_name'   => $data['payway_name'],
            'channel_sub_payway'    => $data['sub_payway'],
            'channel_trade_no'      => $data['trade_no'],
            'channel_payment_list'  => $data['payment_list'],
        ]);
    }

    /**
     * 支付失败处理
     *
     * @param $handler
     * @param $result
     */
    protected function payFail($handler, $result)
    {
        $paymentRecord = $handler->getPaymentRecord();

        $error = array_get($result, 'error_message');
        $data = array_get($result, 'data');

        if ($result['status'] = 'IN_PROG' && $data['order_status'] == 'CREATED') {
            $paymentRecord->updateOrderPayFail($data['client_sn'], [
                'trade_no'              => $data['sn'],
                'channel_trade_no'      => $data['trade_no'],
                'last_error_message'    => $error,
                'last_error_time'       => RC_Time::gmtime(),
                'pay_status'            => \Ecjia\App\Payment\PayConstant::PAYMENT_RECORD_STATUS_PROGRESS,
            ]);

            return new ecjia_error('shouqianba_pay_progress', '扫码支付交易进行中');
        }
        elseif ($data['status'] = 'FAIL_CANCELED' && $data['order_status'] == 'PAY_CANCELED') {
            $paymentRecord->updateOrderPayFail($data['client_sn'], [
                'trade_no'              => $data['sn'],
                'channel_payway'        => $data['payway'],
                'channel_payway_name'   => \Ecjia\App\Payment\PayConstant::getPayway($data['payway']),
                'channel_sub_payway'    => $data['sub_payway'],
                'last_error_message'    => $error,
                'last_error_time'       => RC_Time::gmtime(),
                'pay_status'            => \Ecjia\App\Payment\PayConstant::PAYMENT_RECORD_STATUS_FAIL,
            ]);

            return new ecjia_error('shouqianba_pay_fail', $error);
        } else {

            return new ecjia_error('shouqianba_pay_fail', $error);
        }
    }

}