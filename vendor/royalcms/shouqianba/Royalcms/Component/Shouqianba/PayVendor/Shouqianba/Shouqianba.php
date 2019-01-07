<?php

namespace Royalcms\Component\Shouqianba\PayVendor\Shouqianba;

use Royalcms\Component\Pay\Contracts\GatewayApplicationInterface;
use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Pay\Exceptions\InvalidGatewayException;
use Royalcms\Component\Pay\Contracts\GatewayInterface;
use Royalcms\Component\Pay\Contracts\PayloadInterface;
use Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Orders\PayOrder;
use Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Orders\TerminalActivate;
use Royalcms\Component\Support\Collection;
use Royalcms\Component\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Shouqianba
 * @package Royalcms\Component\Shouqianba\PayVendor
 *
 * @method Collection scan(PayOrder $params) 扫码支付
 * @method Collection activate(TerminalActivate $params) 激活终端
 *
 */
class Shouqianba implements GatewayApplicationInterface
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Shouqianba payload.
     *
     * @var PayloadInterface
     */
    protected $payload;

    /**
     * Shouqianba gateway.
     *
     * @var string
     */
    protected $gateway;

    /**
     * Bootstrap.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->gateway = Support::baseUri($this->config->get('mode', 'normal'));
    }

    /**
     * To pay.
     *
     * @param string $gateway
     * @param PayOrder  $params
     *
     * @return \Royalcms\Component\Support\Collection|\Symfony\Component\HttpFoundation\Response
     */
    public function pay($gateway, PayloadInterface $order)
    {
        $this->payload = $order;

        $gateway = '\Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Gateways\\'.Str::studly($gateway).'Gateway';

        if (class_exists($gateway)) {
            return $this->makePay($gateway);
        }

        throw new InvalidGatewayException("Pay Gateway [{$gateway}] not exists");
    }

    /**
     * Query an order.
     *
     * @param string|array $order
     * @param bool         $refund
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function find($trade_no, $order_sn = null)
    {
        $api = '/upay/v2/query';

        $params['terminal_sn'] = $this->config->get('terminal_sn'); //收钱吧终端ID
        $params['sn'] = $trade_no; //收钱吧系统内部唯一订单号
        $params['client_sn'] = $order_sn;//商户系统订单号,必须在商户系统内唯一；且长度不超过64字节

        $result = Support::sendRequest($api, $params, $this->config->get('terminal_sn'), $this->config->get('terminal_key'));

        return collect($result);
    }

    /**
     * Refund an order.
     *
     * @param array $order
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function refund($order)
    {
        $this->payload = $order;

        $gateway = get_class($this).'\\'.Str::studly('refund').'Gateway';

        if (class_exists($gateway)) {
            return $this->makePay($gateway);
        }

        throw new InvalidGatewayException("Pay Gateway [{$gateway}] not exists");
    }

    /**
     * Cancel an order.
     *
     * @param string|array $order
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function cancel($trade_no, $order_sn = null)
    {
        $api = '/upay/v2/cancel';

        $params['terminal_sn'] = $this->config->get('terminal_sn'); //收钱吧终端ID
        $params['sn'] = $trade_no; //收钱吧系统内部唯一订单号
        $params['client_sn'] = $order_sn;//商户系统订单号,必须在商户系统内唯一；且长度不超过64字节

        $result = Support::sendRequest($api, $params, $this->config->get('terminal_sn'), $this->config->get('terminal_key'));

        return collect($result);
    }

    public function revoke($trade_no, $order_sn = null)
    {
        $api = '/upay/v2/revoke';

        $params['terminal_sn'] = $this->config->get('terminal_sn'); //收钱吧终端ID
        $params['sn'] = $trade_no; //收钱吧系统内部唯一订单号
        $params['client_sn'] = $order_sn;//商户系统订单号,必须在商户系统内唯一；且长度不超过64字节

        $result = Support::sendRequest($api, $params, $this->config->get('terminal_sn'), $this->config->get('terminal_key'));

        return collect($result);
    }


    /**
     * Close an order.
     *
     * @param string|array $order
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function close($order)
    {

    }

    /**
     * Verify a request.
     *
     * @param string|null $content
     * @param bool        $refund
     *
     * @return \Royalcms\Component\Support\Collection
     */
    public function verify($content, $refund)
    {

    }

    /**
     * Echo success to server.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function success()
    {

    }



    public function precreate($terminal_sn, $terminal_key)
    {
        $api_domain = 'https://api.shouqianba.com';
        $url = $api_domain . '/upay/v2/precreate';

        $params['terminal_sn'] = $terminal_sn;           //收钱吧终端ID
//        $params['sn']='7895253130995555';              //收钱吧系统内部唯一订单号
        $params['client_sn'] = '6521100263201711163297047555';//商户系统订单号,必须在商户系统内唯一；且长度不超过64字节
        $params['total_amount'] = '1';                   //金额
        $params['payway'] = '1';                 //内容为数字的字符串 支付方式
        $params['subject'] = 'pizza';                //本次交易的概述
        $params['operator'] = 'Obama';              //发起本次交易的操作员


//        $params['sub_payway']='3';               //内容为数字的字符串，如果要使用WAP支付，则必须传 "3", 使用小程序支付请传"4"
//        $params['payer_uid']='kay';                    //消费者在支付通道的唯一id,微信WAP支付必须传open_id,支付宝WAP支付必传用户授权的userId
//        $params['description']='';            //对商品或本次交易的描述
//        $params['longitude']='';             //经纬度必须同时出现
//        $params['latitude']='';              //经纬度必须同时出现
//        $params['extended']='';              //收钱吧与特定第三方单独约定的参数集合,json格式，最多支持24个字段，每个字段key长度不超过64字节，value长度不超过256字节
//        $params['goods_details']='';        //
//        $params['reflect']='';              //任何调用者希望原样返回的信息
//        $params['notify_url']='';            //支付回调的地址
        $ret = pre_do_execute($params, $url, $terminal_sn, $terminal_key);
        /*
         * string(44) "https://api.shouqianba.com/upay/v2/precreate"
        string(724) "{"result_code":"200","error_code":"","error_message":"","biz_response":{"result_code":"PRECREATE_SUCCESS","error_code":"","error_message":"","data":{"sn":"7895253189084906","client_sn":"6521100263201711163297047920",
        "client_tsn":"6521100263201711163297047920","trade_no":"","finish_time":"","channel_finish_time":"","status":"CREATED","order_status":"CREATED","payway":"1","payway_name":"支付宝","sub_payway":"2","payer_uid":"","payer_login":"","total_amount":"1","net_amount":"1",
        "qr_code":"https://qr.alipay.com/bax06545wtwccfvlsmxj0076","qr_code_image_url":"https://api.shouqianba.com/upay/qrcode?content=https%3A%2F%2Fqr.alipay.com%2Fbax06545wtwccfvlsmxj0076","subject":"pizza","operator":"Obama","payment_list":[]}}}"
         *
         *
         * */
        return $ret;

    }

    public function wap_api_pro($terminal_sn, $terminal_key)
    {
        $params['terminal_sn'] = $terminal_sn;           //收钱吧终端ID
        $params['client_sn'] = '005';//商户系统订单号,必须在商户系统内唯一；且长度不超过64字节
        $params['total_amount'] = '1';//以分为单位,不超过10位纯数字字符串,超过1亿元的收款请使用银行转账
        $params['subject'] = 'pizza';//本次交易的概述
        $params['notify_url'] = 'http://10.0.0.157/dashboard/test.php';
        $params['operator'] = 'Obama';//发起本次交易的操作员
        $params['return_url'] = 'http://www.baidu.com';

        ksort($params);

        $param_str = "";
        foreach ($params as $k => $v) {
            $param_str .= $k . '=' . $v . '&';
        }

        $sign = strtoupper(md5($param_str . 'key=' . $terminal_key));
        $paramsStr = $param_str . "sign=" . $sign;


        $res = "https://m.wosai.cn/qr/gateway?" . $paramsStr;
        //将这个url生成二维码扫码或在微信链接中打开可以完成测试
        file_put_contents('logs/wap_api_pro_' . date('Y-m-d') . '.txt', $res, FILE_APPEND);

        /*
         * https://m.wosai.cn/qr/gateway?client_sn=0007&notify_url=https://www.shouqianba.com/&operator=Obama&
         * return_url=http://www.baidu.com&subject=pizza&terminal_sn=100114020002444498&
         * total_amount=1&sign=40CF32733C5A8AF3FE1D175196762458
         * */
//        var_dump($res);exit;
//    header($res);

    }


    /**
     * Make pay gateway.
     *
     * @param string $gateway
     *
     * @throws InvalidGatewayException
     *
     * @return Response|Collection
     */
    protected function makePay($gateway)
    {
        $app = new $gateway($this->config);

        if ($app instanceof GatewayInterface) {
            return $app->pay($this->gateway, $this->payload);
        }

        throw new InvalidGatewayException("Pay Gateway [{$gateway}] Must Be An Instance Of GatewayInterface");
    }


    /**
     * Magic pay.
     *
     * @param string $method
     * @param array  $params
     *
     * @throws InvalidGatewayException
     *
     * @return Collection
     */
    public function __call($method, array $params)
    {
        array_unshift($params, $method);

        return call_user_func_array([$this, 'pay'], $params);
    }

}
