<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/24
 * Time: 17:33
 */

namespace Ecjia\App\Refund\Models;

use Royalcms\Component\Database\Eloquent\Model;

class RefundOrderModel extends Model
{

    protected $table = 'refund_order';

    protected $primaryKey = 'refund_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'user_id',
        'user_name',
        'refund_type',
        'refund_sn',
        'order_type',
        'order_id',
        'order_sn',
        'shipping_code',
        'shipping_name',
        'shipping_fee',
        'shipping_whether',
        'insure_fee',
        'pay_code',
        'pay_name',
        'goods_amount',
        'pay_fee',
        'pack_id',
        'pack_fee',
        'card_id',
        'card_fee',
        'bonus_id',
        'bonus',
        'surplus',
        'integral',
        'integral_money',
        'discount',
        'inv_tax',
        'order_amount',
        'money_paid',
        'status',
        'refund_status',
        'refund_content',
        'refund_reason',
        'refund_time',
        'return_status',
        'return_time',
        'return_shipping_range',
        'return_shipping_type',
        'return_shipping_value',
        'add_time',
        'last_submit_time',
        'referer',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * 获取与退款订单关联的打款记录
     */
    public function refundPayRecord()
    {
        return $this->hasOne('Ecjia\App\Refund\Models\RefundPayRecordModel', 'refund_id', 'refund_id');
    }

}