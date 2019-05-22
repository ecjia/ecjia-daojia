<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;

class FavourableActivityModel extends Model
{

    protected $table = 'favourable_activity';

    protected $primaryKey = 'act_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'act_name',
        'start_time',
        'end_time',
        'user_rank',
        'act_range',
        'act_range_ext',
        'min_amount',
        'max_amount',
        'act_type',
        'act_type_ext',
        'gift',
        'sort_order'
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
   
}