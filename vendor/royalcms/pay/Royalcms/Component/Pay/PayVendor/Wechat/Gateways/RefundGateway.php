<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/30
 * Time: 9:26 AM
 */

namespace Royalcms\Component\Pay\PayVendor\Wechat\Gateways;

use Royalcms\Component\Support\Collection;
use Royalcms\Component\Pay\Contracts\GatewayInterface;
use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Pay\PayVendor\Wechat\Support;
use Royalcms\Component\Pay\Exceptions\GatewayException;
use Royalcms\Component\Support\Str;
use Royalcms\Component\Pay\Log;

class RefundGateway implements GatewayInterface
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
     * @param \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder $payload
     *
     * @throws \Royalcms\Component\Pay\Exceptions\GatewayException
     *
     * @return Collection
     */
    public function pay($endpoint, $payload)
    {
        if (! ($payload instanceof \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder)) {
            throw new GatewayException('The payload must is "\Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder" instance!');
        }

        $api = $this->getMethod();

        $payload->setAppid($this->config->get('mpapp_id')); //公众账号ID
        $payload->setMchId($this->config->get('mch_id')); //商户号
        $payload->setNonceStr(Str::random()); //随机字符串
        $payload->setSignType('MD5'); //签名类型

        $sign = Support::generateSign($payload->toArray(), $this->config->get('key'));

        $payload->setSign($sign); //签名

        $params = $payload->toArray();

        Log::debug('Wechat Refund An Order:', [$api, $params]);

        $result = Support::requestApi(
            $api,
            $params,
            $this->config->get('key'),
            ['cert' => $this->config->get('cert_client'), 'ssl_key' => $this->config->get('cert_key')]
        );

        if (is_array($result)) {
            return collect($result);
        }

        return $result;
    }

    /**
     * Get method config.
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'secapi/pay/refund';
    }

    /**
     * Get productCode config.
     *
     * @return string
     */
    protected function getProductCode()
    {
        return '';
    }

}