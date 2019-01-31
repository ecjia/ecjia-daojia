<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/26
 * Time: 14:13
 */

namespace Ecjia\App\Withdraw\Repositories;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use Ecjia\App\Withdraw\WithdrawConstant;
use RC_Time;

class WithdrawRecordRepository extends AbstractRepository
{
    protected $model = 'Ecjia\App\Withdraw\Models\WithdrawRecordModel';

    protected $orderBy = ['id' => 'desc'];


    /**
     * 创建提现支付流水记录
     *
     * @param array $data
     * @return static
     */
    public function createWithdrawRecord(array $data)
    {
        $model = $this->findWithdrawOrderSn(array_get($data, 'order_sn'));
        if (empty($model)) {
            $insertData['order_sn']           = array_get($data, 'order_sn');
            $insertData['withdraw_code']      = array_get($data, 'withdraw_code');
            $insertData['withdraw_name']      = array_get($data, 'withdraw_name');
            $insertData['withdraw_amount']    = array_get($data, 'withdraw_amount');
            $insertData['withdraw_status']    = WithdrawConstant::WITHDRAW_RECORD_STATUS_WAIT;
            $insertData['create_time']        = RC_Time::gmtime();
            $insertData['transfer_bank_no']   = array_get($data, 'transfer_bank_no');
            $insertData['transfer_true_name'] = array_get($data, 'transfer_true_name');

            $model = $this->getModel()->create($insertData);
        }

        return $model;
    }

    /**
     * 提现成功记录
     * @param string $order_sn 提现商户号
     * @param string $withdraw_trade_no 提现流水号
     * @param array $return_info 提现成功信息，序列化存储
     */
    public function withdrawSuccessfulRecord($order_sn, $withdraw_trade_no, $account = null, $partner_id = null, array $return_info = [])
    {
        $model = $this->findUnSuccessfulWithdrawOrderSn($order_sn);
        if (!empty($model)) {

            //处理refund_info是否有数据，如果有数据，合并后存入
            $return_info_data = unserialize($model->success_result);
            if (!empty($return_info_data)) {
                $return_info = array_merge($return_info_data, $return_info);
            }

            $model->trade_no           = $withdraw_trade_no;
            $model->withdraw_status    = WithdrawConstant::WITHDRAW_RECORD_STATUS_PAYED;
            $model->transfer_time      = RC_Time::gmtime();
            $model->payment_time       = RC_Time::gmtime();
            $model->account            = $account;
            $model->partner_id         = $partner_id;
            $model->success_result     = serialize($return_info);
            $model->last_error_message = null;
            $model->last_error_time    = null;
            $model->save();
        }

    }

    /**
     * 退款失败记录
     *
     * @param string $order_sn 提现商户号
     * @param string $error_message
     */
    public function withdrawErrorRecord($order_sn, $error_message)
    {
        $model = $this->findUnSuccessfulWithdrawOrderSn($order_sn);
        if (!empty($model)) {
            $model->transfer_time      = RC_Time::gmtime();
            $model->withdraw_status    = WithdrawConstant::WITHDRAW_RECORD_STATUS_FAILED;
            $model->last_error_message = $error_message;
            $model->last_error_time    = RC_Time::gmtime();
            $model->save();
        }
    }

    /**
     * 提现失败记录
     *
     * @param string $order_sn 提现商户号
     * @param string $error_message
     */
    public function withdrawFailedRecord($order_sn, $error_message, $account = null, $partner_id = null)
    {
        $model = $this->findUnSuccessfulWithdrawOrderSn($order_sn);
        if (!empty($model)) {
            $model->account            = $account;
            $model->partner_id         = $partner_id;
            $model->transfer_time      = RC_Time::gmtime();
            $model->last_error_message = $error_message;
            $model->last_error_time    = RC_Time::gmtime();
            $model->withdraw_status    = WithdrawConstant::WITHDRAW_RECORD_STATUS_FAILED;
            $model->save();
        }
    }

    /**
     * 查找提现记录
     * @param string $partner_trade_no 退款商户号
     */
    public function findWithdrawOrderSn($partner_trade_no)
    {
        $model = $this->findBy('order_sn', $partner_trade_no);
        return $model;
    }

    /**
     * 查找未成功提现记录
     * @param string $partner_trade_no 退款商户号
     */
    public function findUnSuccessfulWithdrawOrderSn($partner_trade_no)
    {
        $model = $this->findWhere(['order_sn' => $partner_trade_no, 'withdraw_status' => ['withdraw_status', '<>', WithdrawConstant::WITHDRAW_RECORD_STATUS_PAYED]])->first();
        return $model;
    }

}