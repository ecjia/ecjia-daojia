<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/24
 * Time: 17:33
 */

namespace Ecjia\App\Affiliate\Models;

use Royalcms\Component\Database\Eloquent\Model;

class QuickpayOrdersModel extends Model
{

    protected $table = 'quickpay_orders';

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
     * 一对一
     * 获取订单对应下单用户信息
     */
    public function users_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\UsersModel', 'user_id', 'user_id');
    }
}