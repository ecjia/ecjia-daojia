<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodsReviewLogModel extends Model
{

    protected $table = 'goods_review_log';

    protected $primaryKey = 'action_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'goods_id',
        'action_user_type',
        'action_user_id',
        'action_user_name',
        'status',
        'action_note',
        'add_time'
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
}