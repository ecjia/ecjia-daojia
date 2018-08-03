<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatTemplateLog
 */
class WechatTemplateLogModel extends Model
{
    protected $table = 'wechat_template_log';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'msgid',
        'code',
        'openid',
        'data',
        'url',
        'status'
    ];

    protected $guarded = [];

    

}