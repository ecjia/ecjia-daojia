<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/6
 * Time: 11:24 AM
 */

namespace Ecjia\App\Market\Models;

use Royalcms\Component\Database\Eloquent\Model;

class BonusTypeModel extends Model
{
    protected $table = 'bonus_type';

    protected $primaryKey = 'type_id';

    public $timestamps = false;

    protected $fillable = [
        'store_id',
        'type_name',
        'type_money',
        'send_type',
        'usebonus_type',
        'min_amount',
        'max_amount',
        'send_start_date',
        'send_end_date',
        'use_start_date',
        'use_end_date',
        'min_goods_amount',
    ];

    protected $guarded = [];


}