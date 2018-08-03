<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatCustomMessage
 */
class WechatCustomerModel extends Model
{
    protected $table = 'wechat_customer';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'kf_id',
        'kf_account',
        'kf_nick',
        'kf_headimgurl',
        'status',
        'online_status',
        'accepted_case',
        'kf_wx',
        'invite_wx',
        'invite_expire_time',
        'invite_status',
        'file_url',
    ];

    protected $guarded = [];

    

}