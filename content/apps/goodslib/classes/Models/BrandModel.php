<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:34
 */

namespace Ecjia\App\Goodslib\Models;

use Royalcms\Component\Database\Eloquent\Model;

class BrandModel extends Model
{

    protected $table = 'brand';

    protected $primaryKey = 'brand_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'brand_name',
        'brand_logo',
        'brand_desc',
        'site_url',
        'sort_order',
        'is_show',
        'is_delete',
    ];


}