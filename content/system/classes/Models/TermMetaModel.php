<?php


namespace Ecjia\System\Models;


use Royalcms\Component\Database\Eloquent\Model;

class TermMetaModel extends Model
{

    protected $table = 'term_meta';

    protected $primaryKey = 'meta_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'object_type',
        'object_group',
        'object_id',
        'meta_key',
        'meta_value',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

}