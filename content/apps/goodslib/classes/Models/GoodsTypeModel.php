<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:34
 */

namespace Ecjia\App\Goodslib\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodsTypeModel extends Model
{
	
	protected $table = 'goods_type';
	
	protected $primaryKey = 'cat_id';
	
	/**
	 * 可以被批量赋值的属性。
	 *
	 * @var array
	 */
	protected $fillable = [
		'store_id',
		'cat_name',
		'enabled',
		'attr_group',
	];
	
	/**
	 * 一对多
	 * 规格/参数的属性集合
	 */
	public function attribute_collection()
	{
		return $this->hasMany('Ecjia\App\Goodslib\Models\AttributeModel', 'cat_id', 'cat_id');
	}
	
}