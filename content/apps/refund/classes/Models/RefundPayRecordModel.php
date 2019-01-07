<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/24
 * Time: 17:15
 */
namespace Ecjia\App\Refund\Models;

use Royalcms\Component\Database\Eloquent\Model;

class RefundPayRecordModel extends Model
{
    protected $table = 'refund_payrecord';

    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'order_id',
        'order_sn',
        'refund_id',
        'refund_sn',
        'refund_type',
        'goods_amount',
        'order_money_paid',
        'payment_record_id',
        'back_pay_code',
        'back_pay_name',
        'back_pay_fee',
        'back_shipping_fee',
        'back_insure_fee',
        'back_pack_id',
        'back_pack_fee',
        'back_card_id',
        'back_card_fee',
        'back_bonus_id',
        'back_bonus',
        'back_surplus',
        'back_integral',
        'back_integral_money',
        'back_inv_tax',
        'back_money_total',
        'add_time',
        'action_back_content',
        'action_back_type',
        'action_back_time',
        'action_user_type',
        'action_user_id',
        'action_user_name',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * 获取与此打款记录关联的退款订单
     */
    public function refundOrder()
    {
        return $this->belongsTo('Ecjia\App\Refund\Models\RefundOrderModel', 'refund_id', 'refund_id');
    }

    /**
     * 更新打款表
     * @param $back_type
     * @param $back_content
     * @param $user_id
     * @param $user_name
     * @param string $user_type
     */
    public function updateRefundPayrecord($id, $back_type, $back_content, $user_id, $user_name, $user_type = 'admin')
    {
        //更新打款表
        $data = array(
            'action_back_type'			=>	$back_type,
            'action_back_time'			=>	\RC_Time::gmtime(),
            'action_back_content'		=>	$back_content,
            'action_user_id'	        =>	$user_id,
            'action_user_name'	        =>	$user_name,
            'action_user_type'	        =>	$user_type
        );
        $this->where('id', $id)->update($data);
    }

}