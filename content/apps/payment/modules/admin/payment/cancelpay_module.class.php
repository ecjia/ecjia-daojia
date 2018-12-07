<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/31
 * Time: 5:34 PM
 */

class admin_payment_cancelpay_module extends api_admin implements api_interface
{

    /**
     * @param string $order_sn 支付流水记录
     * @param string $trade_no 支付交易流水号
     *
     * @param \Royalcms\Component\Http\Request $request
     */
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }

        $trade_no = $this->requestData('trade_no');

        if (empty($trade_no)) {
            return new ecjia_error('payment_cancelpay_content_not_empty', '撤销订单的流水号不能为空');
        }

        $result = (new Ecjia\App\Payment\Refund\CancelManager(null, null, $trade_no))->cancel();

        return $result;
    }


}