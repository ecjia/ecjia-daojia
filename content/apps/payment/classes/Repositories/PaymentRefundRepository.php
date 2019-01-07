<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/26
 * Time: 14:13
 */

namespace Ecjia\App\Payment\Repositories;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use Ecjia\App\Payment\PayConstant;

class PaymentRefundRepository extends AbstractRepository
{
    protected $model = 'Ecjia\App\Payment\Models\PaymentRefundModel';

    protected $orderBy = ['id' => 'desc'];


    /**
     * 创建退款支付流水记录
     *
     * @param array $data
     * @return static
     */
    public function createRefundRecord(array $data)
    {
        $model = $this->findRefundOutNo(array_get($data, 'refund_out_no'));
        if (empty($model)) {
            $insertData['refund_out_no']        = array_get($data, 'refund_out_no');
            $insertData['refund_fee']           = array_get($data, 'refund_fee');
            $insertData['refund_status']        = PayConstant::PAYMENT_REFUND_STATUS_CREATE;
            $insertData['refund_create_time']   = array_get($data, 'refund_create_time');
            $insertData['order_sn']             = array_get($data, 'order_sn');
            $insertData['order_type']           = array_get($data, 'order_type');
            $insertData['order_trade_no']       = array_get($data, 'order_trade_no');
            $insertData['order_total_fee']      = array_get($data, 'order_total_fee');
            $insertData['pay_trade_no']         = array_get($data, 'pay_trade_no');
            $insertData['pay_code']             = array_get($data, 'pay_code');
            $insertData['pay_name']             = array_get($data, 'pay_name');

            $model = $this->getModel()->create($insertData);
        }

        return $model;
    }

    /**
     * 退款成功记录
     * @param string $refund_out_no 退款商户号
     * @param string $refund_trade_no 退款流水号
     * @param array $refund_info 退款信息，序列化存储
     */
    public function refundProcessRecord($refund_out_no, $refund_trade_no, array $refund_info)
    {
        $model = $this->findUnSuccessfulRefundOutNo($refund_out_no);
        if (!empty($model)) {
            $model->refund_trade_no = $refund_trade_no;
            $model->refund_status = PayConstant::PAYMENT_REFUND_STATUS_PROGRESS;
            $model->refund_info = serialize($refund_info);
            $model->last_error_message = null;
            $model->last_error_time = null;
            $model->save();
        }
    }

    /**
     * 退款成功记录
     * @param string $refund_out_no 退款商户号
     * @param string $refund_trade_no 退款流水号
     * @param array $refund_info 退款信息，序列化存储
     */
    public function refundSuccessfulRecord($refund_out_no, $refund_trade_no, array $refund_info)
    {
        $model = $this->findUnSuccessfulRefundOutNo($refund_out_no);
        if (!empty($model)) {
            $model->refund_trade_no = $refund_trade_no;
            $model->refund_status = PayConstant::PAYMENT_REFUND_STATUS_REFUND;
            $model->refund_info = serialize($refund_info);
            $model->last_error_message = null;
            $model->last_error_time = null;
            $model->save();

            //消费订单退款成功后续处理
            (new \Ecjia\App\Refund\RefundProcess\BuyOrderRefundProcess(null, $refund_out_no))->run();
        }

    }

    /**
     * 退款失败记录
     *
     * @param string $refund_out_no 退款商户号
     * @param string $error_message
     */
    public function refundErrorRecord($refund_out_no, $error_message)
    {
        $model = $this->findUnSuccessfulRefundOutNo($refund_out_no);
        if (!empty($model)) {
            $model->refund_status = PayConstant::PAYMENT_REFUND_STATUS_FAIL;
            $model->last_error_message = $error_message;
            $model->last_error_time = \RC_Time::gmtime();
            $model->save();
        }
    }

    /**
     * 退款失败记录
     *
     * @param string $refund_out_no 退款商户号
     * @param string $error_message
     */
    public function refundFailedRecord($refund_out_no, $refund_trade_no, array $refund_info)
    {
        $model = $this->findUnSuccessfulRefundOutNo($refund_out_no);
        if (!empty($model)) {
            //处理refund_info是否有数据，如果有数据，合并后存入
            $refund_info_data = unserialize($model->refund_info);
            if (! empty($refund_info_data)) {
                $refund_info = array_merge($refund_info_data, $refund_info);
            }

            $model->refund_trade_no = $refund_trade_no;
            $model->refund_status = PayConstant::PAYMENT_REFUND_STATUS_FAIL;
            $model->refund_info = serialize($refund_info);
            $model->save();
        }
    }

    /**
     * 退款关闭记录
     *
     * @param string $refund_out_no 退款商户号
     * @param string $error_message
     */
    public function refundClosedRecord($refund_out_no, $refund_trade_no, array $refund_info)
    {
        $model = $this->findUnSuccessfulRefundOutNo($refund_out_no);
        if (!empty($model)) {
            //处理refund_info是否有数据，如果有数据，合并后存入
            $refund_info_data = unserialize($model->refund_info);
            if (! empty($refund_info_data)) {
                $refund_info = array_merge($refund_info_data, $refund_info);
            }

            $model->refund_trade_no = $refund_trade_no;
            $model->refund_status = PayConstant::PAYMENT_REFUND_STATUS_REFUND;
            $model->refund_info = serialize($refund_info);
            $model->last_error_message = null;
            $model->last_error_time = null;
            $model->save();
        }
    }

    /**
     * 查找退款记录
     * @param string $refund_out_no 退款流水号ID
     */
    public function findPaymentRefundId($refund_id)
    {
        $model = $this->findBy('id', $refund_id);
        return $model;
    }

    /**
     * 查找退款记录
     * @param string $refund_out_no 退款商户号
     */
    public function findRefundOutNo($refund_out_no)
    {
        $model = $this->findBy('refund_out_no', $refund_out_no);
        return $model;
    }

    /**
     * 查找未成功退款记录
     * @param string $refund_out_no 退款商户号
     */
    public function findUnSuccessfulRefundOutNo($refund_out_no)
    {
        $model = $this->findWhere(['refund_out_no' => $refund_out_no, 'refund_status' => ['refund_status', '<>', PayConstant::PAYMENT_REFUND_STATUS_REFUND]])->first();
        return $model;
    }

}