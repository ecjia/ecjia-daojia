<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:34
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodsCatModel extends Model
{
	
	protected $table = 'goods_cat';
	
// 	protected $primaryKey = 'cat_id';
	
	/**
	 * 可以被批量赋值的属性。
	 *
	 * @var array
	 */
	protected $fillable = [
		'goods_id',
		'cat_id',
	];
	
	
	
}