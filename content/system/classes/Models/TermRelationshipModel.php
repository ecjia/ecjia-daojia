<?php


namespace Ecjia\System\Models;


use Royalcms\Component\Database\Eloquent\Model;

class TermRelationshipModel extends Model
{

    protected $table = 'term_relationship';

    protected $primaryKey = 'relation_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'object_type',
        'object_group',
        'object_id',
        'item_key1',
        'item_value1',
        'item_key2',
        'item_value2',
        'item_key3',
        'item_value3',
        'item_key4',
        'item_value4',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

}