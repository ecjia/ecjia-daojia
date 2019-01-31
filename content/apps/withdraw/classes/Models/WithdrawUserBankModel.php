<?php

namespace Ecjia\App\Withdraw\Models;

use Royalcms\Component\Database\Eloquent\Model;

class WithdrawUserBankModel extends Model
{
    protected $table = 'withdraw_user_bank';

    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'bank_name',
        'bank_card',
        'bank_branch_name',
        'cardholder',
        'bank_en_short',
        'user_id',
        'user_type',
        'bank_type',
        'add_time',
        'update_time',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

}