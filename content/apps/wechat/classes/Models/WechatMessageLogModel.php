<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatMessageLog
 */
class WechatMessageLogModel extends Model
{
    protected $table = 'wechat_message_log';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'fromusername',
        'createtime',
        'keywords',
        'msgtype',
        'msgid',
        'is_send'
    ];

    protected $guarded = [];

    

}