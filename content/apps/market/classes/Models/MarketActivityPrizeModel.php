<?php

namespace Ecjia\App\Market\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatCustomMessage
 */
class MarketActivityPrizeModel extends Model
{
    protected $table = 'market_activity_prize';

    public $timestamps = false;

    protected $fillable = [
        'activity_id',
        'prize_level',
        'prize_name',
        'prize_type',
        'prize_value',
        'prize_number',
        'prize_prob',
    ];

    protected $guarded = [];

    

}