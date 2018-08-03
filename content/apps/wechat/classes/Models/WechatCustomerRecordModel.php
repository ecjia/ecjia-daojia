<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatCustomMessage
 */
class WechatCustomerRecordModel extends Model
{
    protected $table = 'wechat_customer_record';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'kf_account',
        'openid',
        'opercode',
        'text',
        'time',
    ];

    protected $guarded = [];

    

}