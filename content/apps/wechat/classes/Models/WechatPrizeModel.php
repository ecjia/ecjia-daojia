<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatPrize
 */
class WechatPrizeModel extends Model
{
    protected $table = 'wechat_prize';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'openid',
        'prize_name',
        'issue_status',
        'winner',
        'dateline',
        'prize_type',
        'activity_type',
        'market_id'
    ];

    protected $guarded = [];

    

}