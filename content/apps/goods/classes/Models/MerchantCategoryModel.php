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

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
	
	
	/**
	 * 一对一
	 * 商家商品分类绑定的规格模板模型信息
	 */
	public function goods_type_specification_model()
	{
		return $this->belongsTo('Ecjia\App\Goods\Models\GoodsTypeModel', 'specification_id', 'cat_id');
	}
	
	/**
	 * 一对一
	 * 商家商品分类绑定的参数模板模型信息
	 */
	public function goods_type_parameter_model()
	{
		return $this->belongsTo('Ecjia\App\Goods\Models\GoodsTypeModel', 'parameter_id', 'cat_id');
	}
	
}