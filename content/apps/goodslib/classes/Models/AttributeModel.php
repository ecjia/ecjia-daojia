<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goodslib\Models;

use Royalcms\Component\Database\Eloquent\Model;

class AttributeModel extends Model
{

    protected $table = 'attribute';

    protected $primaryKey = 'attr_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'cat_id',
        'attr_name',
        'attr_cat_type',
        'attr_input_type',
        'attr_type',
        'attr_values',
        'color_values',
        'attr_index',
        'sort_order',
        'is_linked',
        'attr_group',
        'attr_input_category',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 一对一
     * 获取属性分类信息
     */
    public function goods_type_model()
    {
        return $this->belongsTo('Ecjia\App\Goodslib\Models\GoodsTypeModel', 'cat_id', 'cat_id');
    }
    
}