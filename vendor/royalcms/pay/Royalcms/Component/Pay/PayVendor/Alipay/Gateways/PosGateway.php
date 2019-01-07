<?php

namespace Royalcms\Component\Pay\PayVendor\Alipay\Gateways;

use Royalcms\Component\Pay\Contracts\GatewayInterface;
use Royalcms\Component\Pay\Log;
use Royalcms\Component\Support\Collection;
use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Pay\PayVendor\Alipay\Support;

class PosGateway implements GatewayInterface
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Bootstrap.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Pay an order.
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws \Royalcms\Component\Pay\Exceptions\GatewayException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidConfigException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidSignException
     *
     * @return Collection
     */
    public function pay($endpoint, $payload)
    {
        $payload['method'] = $this->getMethod();
        $payload['biz_content'] = json_encode(array_merge(
            json_decode($payload['biz_content'], true),
            [
                'product_code' => $this->getProductCode(),
                'scene'        => 'bar_code',
            ]
        ));
        $payload['sign'] = Support::generateSign($payload, $this->config->get('private_key'));

        Log::debug('Paying A Pos Order:', [$endpoint, $payload]);

        return Support::requestApi($payload, $this->config->get('ali_public_key'));
    }

    /**
     * Get method config.
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'alipay.trade.pay';
    }

    /**
     * Get productCode config.
     *
     * @return string
     */
    protected function getProductCode()
    {
        return 'FACE_TO_FACE_PAYMENT';
    }
}
