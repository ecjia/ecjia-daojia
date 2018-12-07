<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 15:46
 */

namespace Ecjia\App\Payment;

use Ecjia\App\Payment\Repositories\PaymentRecordRepository;
use ecjia_error;

abstract class PaymentManagerAbstract
{

    protected $payCode;

    /**
     * @var \Ecjia\App\Payment\PaymentAbstract
     * @var \Ecjia\App\Payment\Contracts\CancelPayment
     */
    protected $pluginHandler;

    protected $paymentRecord;

    /**
     * @var PaymentRecordRepository
     */
    protected $paymentRecordRepository;

    public function __construct($order_sn, $order_trade_no = null, $trade_no = null)
    {
        $this->paymentRecordRepository = new PaymentRecordRepository();

        if (! is_null($trade_no)) {
            $this->paymentRecord = $this->paymentRecordRepository->findBy('trade_no', $trade_no);
        }
        elseif (! is_null($order_trade_no)) {
            $this->paymentRecord = $this->paymentRecordRepository->findBy('order_trade_no', $order_trade_no);
        } else {
            $this->paymentRecord = $this->paymentRecordRepository->findBy('order_sn', $order_sn);
        }
    }

    public function initPaymentRecord()
    {
        if (empty($this->paymentRecord)) {
            return new ecjia_error('payment_record_not_found', __('此笔交易记录未找到', 'app-payment'));
        }

        $this->payCode = $this->paymentRecord->pay_code;

        $payment_plugin	= new PaymentPlugin();
        $this->pluginHandler = $payment_plugin->channel($this->payCode);
        if (is_ecjia_error($this->pluginHandler))
        {
            return $this->pluginHandler;
        }

        $this->pluginHandler->setPaymentRecord($this->paymentRecordRepository);

        return $this->doPluginHandler();
    }

    /**
     * 转让插件处理
     *
     * @return mixed
     */
    abstract protected function doPluginHandler();

}