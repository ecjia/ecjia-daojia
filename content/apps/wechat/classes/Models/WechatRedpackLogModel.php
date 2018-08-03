<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatRedpackLog
 */
class WechatRedpackLogModel extends Model
{
    protected $table = 'wechat_redpack_log';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'market_id',
        'hb_type',
        'openid',
        'hassub',
        'money',
        'time',
        'mch_billno',
        'mch_id',
        'wxappid',
        'bill_type',
        'notify_data'
    ];

    protected $guarded = [];

    

}