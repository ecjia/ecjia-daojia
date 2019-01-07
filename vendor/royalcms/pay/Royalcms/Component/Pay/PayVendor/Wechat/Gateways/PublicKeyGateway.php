<?php

namespace Royalcms\Component\Pay\PayVendor\Wechat\Gateways;

use Royalcms\Component\Pay\Log;
use Royalcms\Component\Support\Collection;
use Royalcms\Component\Pay\Exceptions\GatewayException;
use Royalcms\Component\Support\Str;
use Royalcms\Component\Pay\PayVendor\Wechat\Support;
use \Royalcms\Component\Pay\PayVendor\Wechat\Orders\PublicKeyOrder;

class PublicKeyGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @param string $endpoint
     * @param \Royalcms\Component\Pay\PayVendor\Wechat\Orders\PublicKeyOrder $payload
     *
     * @throws \Royalcms\Component\Pay\Exceptions\GatewayException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidArgumentException
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidSignException
     *
     * @return Collection
     */
    public function pay($endpoint, $payload)
    {
        if (! ($payload instanceof PublicKeyOrder)) {
            throw new GatewayException('The payload must is "\Royalcms\Component\Pay\PayVendor\Wechat\Orders\PublicKeyOrder" instance!');
        }

        $api = $this->getMethod();

        /*
        if ($this->mode === Wechat::MODE_SERVICE) {
        }*/

        $payload->setMchId($this->config->get('mch_id')); //商户号
        $payload->setNonceStr(Str::random()); //随机字符串
        $payload->setSignType('MD5'); //签名类型

        $sign = Support::generateSign($payload->toArray(), $this->config->get('key'));

        $payload->setSign($sign); //签名

        $params = $payload->toArray();

        Log::debug('Paying A Transfer Order:', [$endpoint, $params]);

        return Support::requestApi(
            $api,
            $params,
            $this->config->get('key'),
            ['cert' => $this->config->get('cert_client'), 'ssl_key' => $this->config->get('cert_key')],
            'https://fraud.mch.weixin.qq.com/'
        );
    }

    /**
     * Get method config.
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'risk/getpublickey';
    }

    /**
     * Get trade type config.
     *
     * @return string
     */
    protected function getTradeType()
    {
        return '';
    }
}
