<?php

namespace Ecjia\App\Market\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatCustomMessage
 */
class MarketActivityModel extends Model
{
    protected $table = 'market_activity';

    public $timestamps = false;

    protected $fillable = [
        'store_id',
        'wechat_id',
        'activity_name',
        'activity_group',
        'activity_desc',
        'activity_object',
        'limit_num',
        'limit_time',
        'start_time',
        'end_time',
        'add_time',
        'enabled',
    ];

    protected $guarded = [];

    

}