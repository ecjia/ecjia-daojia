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
namespace Ecjia\App\Payment;

use Ecjia\System\Plugin\AbstractPlugin;
use Ecjia\App\Payment\Repositories\PaymentRecordRepository;
use ecjia_error;
use RC_Lang;
use RC_Api;
use RC_Hook;
use GuzzleHttp\json_encode;

/**
 * 短信插件抽象类
 * @author royalwang
 */
abstract class PaymentAbstract extends AbstractPlugin 
{

    use CompatibleTrait;
    
    /**
     * 支付方式信息
     * @var \Ecjia\App\Payment\PaymentPlugin
     */
    protected $payment;
    
    /**
     * 支付流水记录
     * @var \Ecjia\App\Payment\Repositories\PaymentRecordRepository
     */
    protected $paymentRecord;
    
    /**
     * 订单类型，标识订单号来源于哪张表的
     * PAY_ORDER = buy 消费订单
     * PAY_SURPLUS = surplus 会员预付费订单
     * @var string
     */
    protected $orderType = PayConstant::PAY_ORDER;
    
    public function setOrderType($orderType)
    {
        $this->orderType = $orderType;
        
        return $this;
    }
    
    public function getOrderType()
    {
        return $this->orderType;
    }
    
    /**
     * 设置配置方式
     * @param \Ecjia\App\Payment\PaymentPlugin $payment
     */
    public function setPayment(PaymentPlugin $payment)
    {
        $this->payment = $payment;
        
        return $this;
    }
    
    /**
     * 获取支付方式数据对象
     * @return \Ecjia\App\Payment\PaymentPlugin $payment
     */
    public function getPayment()
    {
        return $this->payment;
    }
    
    /**
     * 设置支付流水记录对象
     * @param PaymentRecordRepository $paymentRecord
     * @return \Ecjia\App\Payment\PaymentAbstract
     */
    public function setPaymentRecord(PaymentRecordRepository $paymentRecord)
    {
        $this->paymentRecord = $paymentRecord;
        
        return $this;
    }
    
    /**
     * 获取支付流水记录操作对象
     * @return \Ecjia\App\Payment\Repositories\PaymentRecordRepository
     */
    public function getPaymentRecord()
    {
        return $this->paymentRecord;
    }
    
    public function getPaymentRecordId()
    {
        $order_sn = $this->order_info['order_sn'];
        $amount = $this->order_info['order_amount'];
        
        $id = $this->paymentRecord->addOrUpdatePaymentRecord($order_sn, $amount, $this->orderType, array($this, 'customizeOrderTradeNoRule'));
        
        return $id;
    }
    
    public function getPaymentNewRecordId()
    {
        $order_sn = $this->order_info['order_sn'];
        $amount = $this->order_info['order_amount'];
    
        $id = $this->paymentRecord->addPaymentRecord($order_sn, $amount, $this->orderType, array($this, 'customizeOrderTradeNoRule'));
    
        return $id;
    }
    
    /**
     * 获取外部支付使用的订单交易号
     */
    public function getOrderTradeNo($recordId = null)
    {
        if (is_null($recordId)) {
            $recordId = $this->getPaymentRecordId();
        }

        $model = $this->paymentRecord->find($recordId);
        $this->paymentRecord->updatePayment($model->order_trade_no, $this->getCode(), $this->getName());
        
        return $model->order_trade_no;
    }
    
    /**
     * 更新外部支付使用的订单交易号
     */
    public function updateOrderTradeNo($recordId = null)
    {
        if (is_null($recordId)) {
            $recordId = $this->getPaymentRecordId();
        }
        $model = $this->paymentRecord->find($recordId);
        $model->order_trade_no = $this->customizeOrderTradeNoRule($model);
        return $model->save();
    }
    
    /**
     * 自定义生成外部订单号规则
     * @param \Ecjia\App\Payment\Models\PaymentRecordModel $model
     * @return string
     */
    public function customizeOrderTradeNoRule($model)
    {
        return $model->order_sn . $model->id;
    }
    
    /**
     * 解析支付使用的外部订单号
     */
    public function parseOrderTradeNo($orderTradeNo)
    {
        $item = $this->paymentRecord->getPaymentRecord($orderTradeNo);

        if ($item) {
            $this->setOrderType($item['trade_type']);
            
            return array(
                'order_sn' => $item['order_sn'], 
                'record_id' => $item['id'], 
                'order_type' => $item['trade_type']
            );
        }
        
        return false;
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
        /* 检查支付的金额是否相符 */
        if (!$this->paymentRecord->checkMoney($orderTradeNo, $amount)) {
            return new ecjia_error('check_money_fail', __('支付的金额有误'));
        }

        $this->paymentRecord->updateOrderPaid($orderTradeNo, $amount, $tradeNo);
        
        $item = $this->parseOrderTradeNo($orderTradeNo);
        if (!$item) {
            return new ecjia_error('parse_order_trade_no_error', __('解析订单号时失败'));
        }
 
        if ($this->orderType == PayConstant::PAY_ORDER) {
            $result = RC_Api::api('orders', 'buy_order_paid', array('order_sn' => $item['order_sn'], 'money' => $amount));
        } elseif ($this->orderType == PayConstant::PAY_SURPLUS) {
            $result = RC_Api::api('finance', 'surplus_order_paid', array('order_sn' => $item['order_sn'], 'money' => $amount));
        }
        
        if (! is_ecjia_error($result)) {
            RC_Hook::do_action('order_payed_do_something', $item['order_sn']); 
        }
        
        return $result;
    }
    
    /**
     * 获取支付插件的ID
     * @return integer
     */
    public function getId()
    {
        return $this->payment->pay_id;
    }
    
    /**
     * 获取支付插件的名称
     * @return string
     */
    public function getName()
    {
        return strip_tags($this->payment->pay_name);
    }
    
    /**
     * 获取支付方式显示名称
     * @return string
     */
    public function getDisplayName()
    {
        if (array_get($this->config, 'display_name')) {
            return array_get($this->config, 'display_name');
        }
        
        return $this->getName();
    }
    
    /**
     * 支付服务器异步回调通知地址
     */
    abstract public function notifyUrl();
    
    /**
     * 支付服务器同步回调响应地址
     */
    abstract public function callbackUrl();
    
    
    /**
     * 支付服务器异步回调通知 POST方式
     */
    abstract public function notify();
    
    /**
     * 支付服务器同步回调响应 GET方式
    */
    abstract public function response();
   
}

// end