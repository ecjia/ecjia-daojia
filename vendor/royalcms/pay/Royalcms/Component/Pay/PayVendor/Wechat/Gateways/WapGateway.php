<?php

namespace Royalcms\Component\Pay\PayVendor\Wechat\Gateways;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class WapGateway extends Gateway
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
        $payload['trade_type'] = $this->getTradeType();

        $data = $this->preOrder('pay/unifiedorder', $payload);

        $url = is_null($this->config->get('return_url')) ? $data->mweb_url : $data->mweb_url.
                        '&redirect_url='.urlencode($this->config->get('return_url'));

        return RedirectResponse::create($url);
    }

    /**
     * Get trade type config.
     *
     * @return string
     */
    protected function getTradeType()
    {
        return 'MWEB';
    }
}
