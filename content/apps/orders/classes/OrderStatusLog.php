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
namespace Ecjia\App\Orders;

use RC_Time;
use RC_DB;

/**
 * 订单状态日志记录
 */
class OrderStatusLog
{
    
    protected $order_id;
    
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }
    
    public static function make($order_id)
    {
        return new self($order_id);
    }
    
    /**
     * 生成订单时状态日志
     * @param string $order_sn 订单编号
     * @return bool
     */
    public function generateOrder($order_sn)
    {
        $order_status = '订单提交成功';
        $message = '下单成功，订单号：'.$order_sn;
        return $this->execute($order_status, $message);
    }
    
    /**
     * 生成订单同时提醒付款
     * @return bool
     */
    public function remindPay()
    {
        $order_status = '待付款';
        $message = '请尽快支付该订单，超时将会自动取消订单';
        return $this->execute($order_status, $message);
    }
    
    /**
     * 订单付款成功时
     * @return bool
     */
    public function orderPaid()
    {
        $order_status = '已付款';
        $message = '已通知商家处理，请耐心等待';
        return $this->execute($order_status, $message);
    }
    
    /**
     * 订单付款成功时同时通知商家
     * @return bool
     */
    public function notifyMerchant()
    {
        $order_status = '等待商家接单';
        $message = '订单已通知商家，等待商家处理';
        return $this->execute($order_status, $message);
    }
    
    /**
     * 发货单入库
     * @param string $order_sn 订单编号
     * @return bool
     */
    public function generateDeliveryOrderInvoice($order_sn)
    {
        $order_status = '配货中';
        $message = sprintf("订单号为 %s 的商品正在备货中，请您耐心等待", $order_sn);
        return $this->execute($order_status, $message);
    }
    
    /**
     * 完成发货
     * @param string $order_sn 订单编号
     * @return bool
     */
    public function deliveryShipFinished($order_sn)
    {
        $order_status = '已发货';
        $message = sprintf("订单号为 %s 的商品已发货，请您耐心等待", $order_sn);
        return $this->execute($order_status, $message);
    }
    
    /**
     * 订单确认收货
     * @return bool
     */
    public function affirmReceived()
    {
        $order_status = '已确认收货';
        $message = '宝贝已签收，购物愉快！';
        $this->execute($order_status, $message);
        
        $order_status = '订单已完成';
        $message = '感谢您在'.\ecjia::config('shop_name').'购物，欢迎您再次光临！';
        return $this->execute($order_status, $message);
    }
    
    /**
     * 取消订单
     * @return bool
     */
    public function cancel()
    {
        $order_status = '订单已取消';
        $message = '您的订单已取消成功！';
        return $this->execute($order_status, $message);
    }
    
    /**
     * 仅退款订单已处理
     * @param integer $status
     * @return bool
     */
    public function refundOrderProcess($status)
    {
        if ($status == 1) {
            $message = '申请审核已通过';
        } else {
            $message ='申请审核未通过';
        }
        
        $order_status = '订单退款申请已处理';
        return $this->execute($order_status, $message);
    }
    
    /**
     * 退货退款订单已处理
     * @param integer $status
     * @return bool
     */
    public function returnOrderProcess($status)
    {
        $order_status = '订单退货退款申请已处理';
        if ($status == 1) {
    		$message = '申请审核已通过，请选择返回方式';
    	} else {
    		$message = '申请审核未通过';
    	}
        return $this->execute($order_status, $message);
    }
    
    /**
     * 订单确认收货处理
     * @param integer $status
     * @return bool
     */
    public function returnConfirmReceive($status)
    {
        $order_status = '确认收货处理';
        if ( $status == 3) {
    		$message = '商家已确认收货，等价商家退款';
    	} else {
    		$message = '商家拒绝确认收货，理由：商品没有问题';
    	}
        return $this->execute($order_status, $message);
    }
    
    /**
     * 订单退款到账处理
     * @param array $options
     * @return bool
     */
    public function refundPayRecord($back_money)
    {
        $order_status = '退款到账';
        $message = '您的退款'.$back_money.'元，已退回至您的余额，请查收';
        return $this->execute($order_status, $message);
    }
    
    
    
    /**
     * Database writes
     * @param string $order_status
     * @param string $message
     */
    protected function execute($order_status, $message)
    {
        $data = [
        	'order_status'  => $order_status,
            'order_id'      => $this->order_id,
            'message'       => $message,
            'add_time'      => RC_Time::gmtime(),
        ];
        
        return RC_DB::table('order_status_log')->insert($data);
    }
    
    
}

// end