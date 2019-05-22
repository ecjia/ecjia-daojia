<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:34
 */

namespace Ecjia\App\Goodslib\Models;

use Royalcms\Component\Database\Eloquent\Model;

class CategoryModel extends Model
{

    protected $table = 'category';

 	protected $primaryKey = 'cat_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'cat_name',
        'category_img',
        'keywords',
        'cat_desc',
        'parent_id',
        'sort_order',
        'template_file',
        'measure_unit',
        'show_in_nav',
        'style',
        'is_show',
        'grade',
        'filter_attr',
    ];
}