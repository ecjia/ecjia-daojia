<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:34
 */

namespace Ecjia\App\Goods\Models;

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
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
	
	/**
	 * 一对多
	 * 规格/参数的属性集合
	 */
	public function attribute_collection()
	{
		return $this->hasMany('Ecjia\App\Goods\Models\AttributeModel', 'cat_id', 'cat_id');
	}
	
}