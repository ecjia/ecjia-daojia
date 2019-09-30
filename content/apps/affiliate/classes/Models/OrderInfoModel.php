<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/24
 * Time: 17:33
 */

namespace Ecjia\App\Affiliate\Models;

use Royalcms\Component\Database\Eloquent\Model;

class OrderInfoModel extends Model
{

    protected $table = 'order_info';

    protected $primaryKey = 'order_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
    	
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
	
    /**
     * 一对多
     * 订单商品集合
     */
    public function order_goods_collection()
    {
    	return $this->hasMany('Ecjia\App\Affiliate\Models\OrderGoodsModel', 'order_id', 'order_id');
    }

    /**
     * 一对一
     * 获取订单对应下单用户信息
     */
    public function users_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\UsersModel', 'user_id', 'user_id');
    }
}