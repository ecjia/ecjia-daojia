<?php

namespace Royalcms\Component\Pay\PayVendor\Wechat\Gateways;

use Royalcms\Component\Pay\Contracts\GatewayInterface;
use Royalcms\Component\Pay\PayVendor\Wechat\Wechat;
use Royalcms\Component\Pay\Log;
use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Support\Collection;

abstract class Gateway implements GatewayInterface
{
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
     * Bootstrap.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->mode = $this->config->get('mode', Wechat::MODE_NORMAL);
    }

    /**
     * Pay an order.
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return Collection
     */
    abstract public function pay($endpoint, $payload);

    /**
     * Get trade type config.
     *
     * @return string
     */
    abstract protected function getTradeType();

    /**
     * Preorder an order.
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws \Royalcms\Component\Pay\Exceptions\GatewayException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidArgumentException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidSignException
     *
     * @return Collection
     */
    protected function preOrder($endpoint, $payload)
    {
        $payload['sign'] = Support::generateSign($payload, $this->config->get('key'));

        Log::debug('Pre Order:', [$endpoint, $payload]);

        return Support::requestApi($endpoint, $payload, $this->config->get('key'));
    }
}
