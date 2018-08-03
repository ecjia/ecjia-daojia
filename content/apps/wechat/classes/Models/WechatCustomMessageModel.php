<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatCustomMessage
 */
class WechatCustomMessageModel extends Model
{
    protected $table = 'wechat_custom_message';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'uid',
        'msg',
        'send_time',
        'is_wechat_admin'
    ];

    protected $guarded = [];

    

}