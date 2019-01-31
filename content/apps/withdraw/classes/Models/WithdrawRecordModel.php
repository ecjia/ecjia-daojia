<?php

namespace Ecjia\App\Withdraw\Models;

use Royalcms\Component\Database\Eloquent\Model;

class WithdrawRecordModel extends Model
{
    protected $table = 'withdraw_record';

    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'order_sn',
        'trade_no',
        'withdraw_code',
        'withdraw_name',
        'withdraw_amount',
        'withdraw_status',
        'create_time',
        'transfer_bank_no',
        'transfer_true_name',
        'transfer_time',
        'payment_time',
        'partner_id',
        'account',
        'success_result',
        'last_error_message',
        'last_error_time',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * 获取与此提现记录关联的提现订单
     */
    public function withdrawOrder()
    {
        return $this->belongsTo('Ecjia\App\Withdraw\Models\UserAccountModel', 'order_sn', 'order_sn');
    }

}