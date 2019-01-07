<?php

namespace Royalcms\Component\Pay\PayVendor\Wechat\Gateways;

use Royalcms\Component\Pay\PayVendor\Wechat\Wechat;
use Royalcms\Component\Support\Collection;

class MiniappGateway extends MpGateway
{
    /**
     * Pay an order.
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
    public function pay($endpoint, $payload)
    {
        $payload['appid'] = $this->config->get('miniapp_id');

        $this->mode !== Wechat::MODE_SERVICE ?: $payload['sub_appid'] = $this->config->get('sub_miniapp_id');

        return parent::pay($endpoint, $payload);
    }
}
