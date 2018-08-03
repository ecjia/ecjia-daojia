<?php

namespace Ecjia\App\Market\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatCustomMessage
 */
class MarketActivityLogModel extends Model
{
    protected $table = 'market_activity_log';

    public $timestamps = false;

    protected $fillable = [
        'activity_id',
        'user_id',
        'user_type',
        'user_name',
        'prize_id',
        'prize_name',
        'issue_status',
        'issue_time',
        'issue_extend',
        'add_time',
        'source',
    ];

    protected $guarded = [];

    

}