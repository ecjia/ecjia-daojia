<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:34
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;

class MerchantCategoryModel extends Model
{
	
	protected $table = 'merchants_category';
	
	protected $primaryKey = 'cat_id';
	
	/**
	 * 可以被批量赋值的属性。
	 *
	 * @var array
	 */
	protected $fillable = [
		'store_id',
		'cat_name',
		'cat_image',
		'cat_desc',
		'parent_id',
		'sort_order',
		'is_show',
	];
	
	
	
}