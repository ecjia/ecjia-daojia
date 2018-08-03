<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatShareCount
 */
class WechatShareCountModel extends Model
{
    protected $table = 'wechat_share_count';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'openid',
        'share_type',
        'link',
        'share_time'
    ];

    protected $guarded = [];

    

}