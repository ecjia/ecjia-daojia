<?php

namespace Ecjia\App\Payment\Models;

use Royalcms\Component\Database\Eloquent\Model;

class PaymentRecordModel extends Model
{
    protected $table = 'payment_record';
    
    protected $primaryKey = 'id';
    
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'order_sn',
        'order_trade_no',
        'trade_type',
        'trade_no',
        'pay_code',
        'pay_name',
        'total_fee',
        'pay_status',
        'create_time',
        'update_time',
        'pay_time',
        ];
    
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
    
}