<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodsActivityModel extends Model
{

    protected $table = 'goods_activity';

    protected $primaryKey = 'act_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'act_name',
        'act_desc',
        'act_type',
        'goods_id',
        'product_id',
        'goods_name',
        'start_time',
        'end_time',
        'is_finished',
        'ext_info'
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
   
}