<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/2
 * Time: 13:53
 */

namespace Ecjia\App\Withdraw\Models;

use Royalcms\Component\Database\Eloquent\Model;

class UserAccountModel extends Model
{

    protected $table = 'user_account';

    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_sn',
        'admin_user',
        'amount',
        'pay_fee',
        'real_amount',
        'review_time',
        'add_time',
        'paid_time',
        'admin_note',
        'user_note',
        'from_type',
        'from_value',
        'process_type',
        'payment',
        'payment_name',
        'is_paid',
        'bank_name',
        'bank_branch_name',
        'bank_card',
        'cardholder',
        'bank_en_short',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * 获取与提现订单关联的流水记录
     */
    public function withdrawRecord()
    {
        return $this->hasOne('Ecjia\App\Withdraw\Models\WithdrawRecordModel', 'order_sn', 'order_sn');
    }

}