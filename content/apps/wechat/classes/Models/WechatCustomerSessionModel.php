<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatCustomMessage
 */
class WechatCustomerSessionModel extends Model
{
    protected $table = 'wechat_customer_session';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'kf_account',
        'openid',
        'create_time',
        'latest_time',
        'status',
    ];

    protected $guarded = [];

    

}