<?php

namespace Royalcms\Component\Pay\PayVendor\Wechat\Gateways;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Royalcms\Component\Pay\PayVendor\Wechat\Wechat;
use Royalcms\Component\Pay\Log;
use Royalcms\Component\Support\Str;

class AppGateway extends Gateway
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
     * @return Response
     */
    public function pay($endpoint, $payload)
    {
        $payload['appid'] = $this->config->get('appid');
        $payload['trade_type'] = $this->getTradeType();

        $this->mode !== Wechat::MODE_SERVICE ?: $payload['sub_appid'] = $this->config->get('sub_appid');

        $payRequest = [
            'appid'     => $this->mode === Wechat::MODE_SERVICE ? $payload['sub_appid'] : $payload['appid'],
            'partnerid' => $this->mode === Wechat::MODE_SERVICE ? $payload['sub_mch_id'] : $payload['mch_id'],
            'prepayid'  => $this->preOrder('pay/unifiedorder', $payload)->prepay_id,
            'timestamp' => strval(time()),
            'noncestr'  => Str::random(),
            'package'   => 'Sign=WXPay',
        ];
        $payRequest['sign'] = Support::generateSign($payRequest, $this->config->get('key'));

        Log::debug('Paying An App Order:', [$endpoint, $payRequest]);

        return JsonResponse::create($payRequest);
    }

    /**
     * Get trade type config.
     *
     * @return string
     */
    protected function getTradeType()
    {
        return 'APP';
    }
}
