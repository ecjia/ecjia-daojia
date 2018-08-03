<?php

namespace Ecjia\App\Market\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatCustomMessage
 */
class MarketActivityLotteryModel extends Model
{
    protected $table = 'market_activity_lottery';

    public $timestamps = false;

    protected $fillable = [
        'activity_id',
        'user_id',
        'user_type',
        'lottery_num',
        'add_time',
        'update_time',
    ];

    protected $guarded = [];

    

}