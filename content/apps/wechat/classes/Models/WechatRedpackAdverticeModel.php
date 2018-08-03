<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatRedpackAdvertice
 */
class WechatRedpackAdverticeModel extends Model
{
    protected $table = 'wechat_redpack_advertice';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'market_id',
        'icon',
        'content',
        'url'
    ];

    protected $guarded = [];

    

}