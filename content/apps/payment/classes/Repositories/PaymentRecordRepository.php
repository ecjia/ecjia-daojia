<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//

namespace Ecjia\App\Payment\Repositories;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use RC_Time;
use Ecjia\App\Payment\PayConstant;

class PaymentRecordRepository extends AbstractRepository
{
    protected $model = 'Ecjia\App\Payment\Models\PaymentRecordModel';
    
    protected $orderBy = ['id' => 'desc'];
   
    
    /**
     * 添加订单支付日志记录
     * @param number $orderSn   订单编号
     * @param float $amount     订单金额
     * @param number $isPaid    是否已支付
     * @return int
     */
    public function addOrUpdatePaymentRecord($orderSn, $amount, $type = PayConstant::PAY_ORDER, $callback = null)
    {
        $where = array(
        	'order_sn' => $orderSn,
            'trade_type' => $type,
            'pay_status' => 0
        );
        $result = $this->findWhere($where);

        if (count($result) > 0) {
            /* 未付款，更新支付金额 */
            $model = $result->shift();
            $model->total_fee = $amount;

            if (! $model->order_trade_no) {
                if (is_callable($callback)) {
                    $model->order_trade_no = $callback($model);
                } else {
                    $model->order_trade_no = $this->customizeOrderTradeNoRule($model);
                }
            }

            $model->save();
            
            return $model->id;
        }
        else {
            return $this->addPaymentRecord($orderSn, $amount, $type, $callback);
        }
    }
    
    /**
     * 添加订单支付日志记录
     * @param number $orderSn   订单编号
     * @param float $amount     订单金额
     * @param number $isPaid    是否已支付
     * @return int
     */
    public function addPaymentRecord($orderSn, $amount, $type = PayConstant::PAY_ORDER, $callback = null)
    {
        $attributes = array(
            'order_sn' => $orderSn,
            'total_fee' => $amount,
            'trade_type' => $type,
            'create_time' => RC_Time::gmtime(),
        );
        $model = $this->create($attributes);

        if (is_callable($callback)) {
            $model->order_trade_no = $callback($model);
        } else {
            $model->order_trade_no = $this->customizeOrderTradeNoRule($model);
        }
        $model->save();

        return $model->id;
    }
    
    /**
     * 自定义生成外部订单号规则
     * @param \Ecjia\App\Payment\Models\PaymentRecordModel $model
     * @return string
     */
    protected function customizeOrderTradeNoRule($model)
    {
        return $model->order_sn . $model->id;
    }
    
    /**
     * 获取交易流水记录
     * @param string $orderTradeNo
     * @return \Royalcms\Component\Database\Eloquent\Collection
     */
    public function getPaymentRecord($orderTradeNo)
    {
        return $this->findBy('order_trade_no', $orderTradeNo);
    }
    
    
    /**
     * 获取上次未支付的pay_log_id
     * @param number $orderSn   余额记录的ID
     * @return int
     */
    public function getUnPaidRecordId($orderSn)
    {
        
    }
    
    /**
     * 更新支付日志   
     * @param number $orderTradeNo   订单编号
     * @param float  $amount         订单金额
     * @param number $isPaid         是否已支付
     * @return int
     */
    public function updatePayment($orderTradeNo, $payCode, $payName)
    {
        $attributes = array(
            'pay_code' => $payCode,
            'pay_name' => $payName,
            'update_time' => RC_Time::gmtime(),
        );
        
        return $this->getModel()->where('order_trade_no', $orderTradeNo)->where('pay_status', 0)->update($attributes);
    }
    
    /**
     * 更新商户号
     * @param number $orderTradeNo  订单编号
     * @param string $partner       商户号
     * @param string $account       商户帐号
     */
    public function updatePartner($orderTradeNo, $partner, $account)
    {
        $attributes = array(
            'partner_id' => $partner,
            'account' => $account,
            'update_time' => RC_Time::gmtime(),
        );
        
        return $this->getModel()->where('order_trade_no', $orderTradeNo)->update($attributes);
    }
    
    
    /**
     * 更新订单的支付成功
     * @param   string  $orderTradeNo     订单流水编号
     * @param   float   $amount           订单金额
     * @param   integer $tradeNo          支付平台交易号
     * @return  boolean
     */
    public function updateOrderPaid($orderTradeNo, $amount, $tradeNo = null)
    {
        $attributes = array(
            'pay_status' => 1,
            'pay_time' => RC_Time::gmtime(),
        );
        
        if (! is_null($tradeNo)) {
            $attributes['trade_no'] = $tradeNo;
        }
        
        /* 修改此次支付操作的状态为已付款 */
        return $this->getModel()->where('order_trade_no', $orderTradeNo)
                                ->where('pay_status', 0)
                                ->where('total_fee', $amount)
                                ->update($attributes);
    }
    
    /**
     * 检查支付的金额是否与订单相符
     *
     * @access  public
     * @param   string   $orderTradeNo 商户支付流水编号
     * @param   float    $money        支付接口返回的金额
     * @return  boolean
     */
    public function checkMoney($orderTradeNo, $money)
    {
        $amount = $this->getModel()->where('order_trade_no', $orderTradeNo)->pluck('total_fee');

        if ($amount == $money) {
            return true;
        }
        else {
            return false;
        }
    }
    
   
    public function findWhereLimit(array $where, $columns = ['*'], $limit = null)
    {
        $this->newQuery();
    
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->query->where($field, $condition, $val);
            }
            else {
                $this->query->where($field, '=', $value);
            }
        }
        
        if ($limit) {
            $this->query->take($limit);
        }
        
        return $this->query->get($columns);
    }
    
}