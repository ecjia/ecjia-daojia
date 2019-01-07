<?php

namespace Ecjia\App\Payment\Models;

use Royalcms\Component\Database\Eloquent\Model;

class PaymentRefundModel extends Model
{
    protected $table = 'payment_refund';
    
    protected $primaryKey = 'id';
    
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'refund_out_no',
        'refund_trade_no',
        'refund_fee',
        'refund_status',
        'refund_create_time',
        'refund_confirm_time',
        'refund_info',
        'order_sn',
        'order_type',
        'order_trade_no',
        'order_total_fee',
        'pay_trade_no',
        'pay_code',
        'pay_name',
        'last_error_message',
        'last_error_time',
    ];
    
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
}