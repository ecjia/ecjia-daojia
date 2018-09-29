<?php

namespace Royalcms\Component\Pay\Gateways;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Royalcms\Component\Pay\Contracts\GatewayApplicationInterface;
use Royalcms\Component\Pay\Contracts\GatewayInterface;
use Royalcms\Component\Pay\Exceptions\GatewayException;
use Royalcms\Component\Pay\Exceptions\InvalidGatewayException;
use Royalcms\Component\Pay\Exceptions\InvalidSignException;
use Royalcms\Component\Pay\Gateways\Wechat\Support;
use Royalcms\Component\Pay\Log;
use Royalcms\Component\Support\Collection;
use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Support\Str;

/**
 * @method Response app(array $config) APP 支付
 * @method Collection groupRedpack(array $config) 分裂红包
 * @method Collection miniapp(array $config) 小程序支付
 * @method Collection mp(array $config) 公众号支付
 * @method Collection pos(array $config) 刷卡支付
 * @method Collection redpack(array $config) 普通红包
 * @method Collection scan(array $config) 扫码支付
 * @method Collection transfer(array $config) 企业付款
 * @method Response wap(array $config) H5 支付
 */
class Wechat implements GatewayApplicationInterface
{
    // 普通模式
    const MODE_NORMAL = 'normal';

    // 沙箱模式
    const MODE_DEV = 'dev';

    // 香港钱包
    const MODE_HK = 'hk';

    // 服务商
    const MODE_SERVICE = 'service';

    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Mode.
     *
     * @var string
     */
    protected $mode;

    /**
     * Wechat payload.
     *
     * @var array
     */
    protected $payload;

    /**
     * Wechat gateway.
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
        $this->mode = $this->config->get('mode', self::MODE_NORMAL);
        $this->gateway = Support::baseUri($this->mode);
        $this->payload = [
            'appid'            => $this->config->get('app_id', ''),
            'mch_id'           => $this->config->get('mch_id', ''),
            'nonce_str'        => Str::random(),
            'notify_url'       => $this->config->get('notify_url', ''),
            'sign'             => '',
            'trade_type'       => '',
            'spbill_create_ip' => Request::createFromGlobals()->getClientIp(),
        ];

        if ($this->mode === static::MODE_SERVICE) {
            $this->payload = array_merge($this->payload, [
                'sub_mch_id' => $this->config->get('sub_mch_id'),
                'sub_appid'  => $this->config->get('sub_app_id', ''),
            ]);
        }
    }

    /**
     * Magic pay.
     *
     * @param string $method
     * @param string $params
     *
     * @throws InvalidGatewayException
     *
     * @return Response|Collection
     */
    public function __call($method, $params)
    {
        return self::pay($method, ...$params);
    }

    /**
     * Pay an order.
     *
     * @param string $gateway
     * @param array  $params
     *
     * @throws InvalidGatewayException
     *
     * @return Response|Collection
     */
    public function pay($gateway, $params = [])
    {
        $this->payload = array_merge($this->payload, $params);

        $gateway = get_class($this).'\\'.Str::studly($gateway).'Gateway';

        if (class_exists($gateway)) {
            return $this->makePay($gateway);
        }

        throw new InvalidGatewayException("Pay Gateway [{$gateway}] Not Exists");
    }

    /**
     * Verify data.
     *
     * @param string|null $content
     * @param bool        $refund
     *
     * @throws InvalidSignException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidArgumentException
     *
     * @return Collection
     */
    public function verify($content = null, $refund = false)
    {
        $data = Support::fromXml(isset($content) ? $content : Request::createFromGlobals()->getContent());
        if ($refund) {
            $decrypt_data = Support::decryptRefundContents($data['req_info'], $this->config->get('key'));
            $data = array_merge(Support::fromXml($decrypt_data), $data);
        }

        Log::debug('Receive Wechat Request:', $data);

        if ($refund || Support::generateSign($data, $this->config->get('key')) === $data['sign']) {
            return new Collection($data);
        }

        Log::warning('Wechat Sign Verify FAILED', $data);

        throw new InvalidSignException('Wechat Sign Verify FAILED', $data);
    }

    /**
     * Query an order.
     *
     * @param string|array $order
     * @param bool         $refund
     *
     * @throws GatewayException
     * @throws InvalidSignException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidArgumentException
     *
     * @return Collection
     */
    public function find($order, $refund = false)
    {
        $this->payload = Support::filterPayload($this->payload, $order, $this->config);

        Log::debug('Wechat Find An Order:', [$this->gateway, $this->payload]);

        return Support::requestApi(
            $refund ? 'pay/refundquery' : 'pay/orderquery',
            $this->payload,
            $this->config->get('key')
        );
    }

    /**
     * Refund an order.
     *
     * @param array $order
     *
     * @throws GatewayException
     * @throws InvalidSignException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidArgumentException
     *
     * @return Collection
     */
    public function refund($order)
    {
        $this->payload = Support::filterPayload($this->payload, $order, $this->config, true);

        Log::debug('Wechat Refund An Order:', [$this->gateway, $this->payload]);

        return Support::requestApi(
            'secapi/pay/refund',
            $this->payload,
            $this->config->get('key'),
            ['cert' => $this->config->get('cert_client'), 'ssl_key' => $this->config->get('cert_key')]
        );
    }

    /**
     * Cancel an order.
     *
     * @param array $order
     *
     * @throws GatewayException
     *
     * @return Collection
     */
    public function cancel($order)
    {
        throw new GatewayException('Wechat Do Not Have Cancel API! Plase use Close API!');
    }

    /**
     * Close an order.
     *
     * @param string|array $order
     *
     * @throws GatewayException
     * @throws InvalidSignException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidArgumentException
     *
     * @return Collection
     */
    public function close($order)
    {
        unset($this->payload['spbill_create_ip']);

        $this->payload = Support::filterPayload($this->payload, $order, $this->config);

        Log::debug('Wechat Close An Order:', [$this->gateway, $this->payload]);

        return Support::requestApi('pay/closeorder', $this->payload, $this->config->get('key'));
    }

    /**
     * Echo success to server.
     *
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidArgumentException
     *
     * @return Response
     */
    public function success()
    {
        return Response::create(
            Support::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']),
            200,
            ['Content-Type' => 'application/xml']
        );
    }

    /**
     * Make pay gateway.
     *
     * @param string $gateway
     *
     * @throws InvalidGatewayException
     *
     * @return Response
     */
    protected function makePay($gateway)
    {
        $app = new $gateway($this->config);

        if ($app instanceof GatewayInterface) {
            return $app->pay($this->gateway, $this->payload);
        }

        throw new InvalidGatewayException("Pay Gateway [{$gateway}] Must Be An Instance Of GatewayInterface");
    }
}
