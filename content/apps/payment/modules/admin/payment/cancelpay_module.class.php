<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/31
 * Time: 5:34 PM
 */

class admin_payment_cancelpay_module extends api_admin implements api_interface
{

    /**
     * @param string $order_sn 支付流水记录
     * @param string $trade_no 支付平台交易流水号
     *
     * @param \Royalcms\Component\Http\Request $request
     */
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }

        $trade_no = $this->requestData('trade_no');

        if (empty($trade_no)) {
            return new ecjia_error('payment_cancelpay_content_not_empty', '撤销订单的流水号不能为空');
        }

        $paymentRecordRepository = new Ecjia\App\Payment\Repositories\PaymentRecordRepository();

        $record_model = $paymentRecordRepository->findBy('trade_no', $trade_no);
        if (empty($record_model)) {
            return new ecjia_error('payment_record_not_found', '此笔交易记录未找到');
        }

        $payment_plugin	= new Ecjia\App\Payment\PaymentPlugin();
        $plugin_handler = $payment_plugin->channel($record_model->pay_code);
        $plugin_handler->setPaymentRecord($paymentRecordRepository);

        $plugin_config = $plugin_handler->getConfig();

        $config = config('shouqianba::pay.shouqianba');
        $config['terminal_sn'] = $plugin_config['shouqianba_terminal_sn'];
        $config['terminal_key'] = $plugin_config['shouqianba_terminal_key'];
        $shouqianba = RC_Pay::shouqianba($config);
        $result = $shouqianba->cancel($trade_no);


        return $result;
    }


}