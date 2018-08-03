<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatPoint
 */
class WechatPointModel extends Model
{
    protected $table = 'wechat_point';

    public $timestamps = false;

    protected $fillable = [
        'log_id',
        'wechat_id',
        'openid',
        'keywords',
        'createtime'
    ];

    protected $guarded = [];

    

}