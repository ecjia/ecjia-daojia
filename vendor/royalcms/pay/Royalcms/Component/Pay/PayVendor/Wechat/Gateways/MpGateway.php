<?php

namespace Royalcms\Component\Pay\PayVendor\Wechat\Gateways;

use Royalcms\Component\Pay\Log;
use Royalcms\Component\Support\Collection;
use Royalcms\Component\Support\Str;

class MpGateway extends Gateway
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
        $payload['trade_type'] = $this->getTradeType();

        $payRequest = [
            'appId'     => $payload['appid'],
            'timeStamp' => strval(time()),
            'nonceStr'  => Str::random(),
            'package'   => 'prepay_id='.$this->preOrder('pay/unifiedorder', $payload)->prepay_id,
            'signType'  => 'MD5',
        ];
        $payRequest['paySign'] = Support::generateSign($payRequest, $this->config->get('key'));

        Log::debug('Paying A JSAPI Order:', [$endpoint, $payRequest]);

        return new Collection($payRequest);
    }

    /**
     * Get trade type config.
     *
     * @return string
     */
    protected function getTradeType()
    {
        return 'JSAPI';
    }
}
