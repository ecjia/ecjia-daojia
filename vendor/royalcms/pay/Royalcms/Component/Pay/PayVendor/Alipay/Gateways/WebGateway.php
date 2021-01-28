<?php

namespace Royalcms\Component\Pay\PayVendor\Alipay\Gateways;

use Symfony\Component\HttpFoundation\Response;
use Royalcms\Component\Pay\Contracts\GatewayInterface;
use Royalcms\Component\Pay\Log;
use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Pay\PayVendor\Alipay\Support;

class WebGateway implements GatewayInterface
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
     * @throws \Royalcms\Component\Pay\Exceptions\InvalidConfigException
     *
     * @return Response
     */
    public function pay($endpoint, $payload)
    {
        $payload['method'] = $this->getMethod();
        $payload['biz_content'] = json_encode(array_merge(
            json_decode($payload['biz_content'], true),
            ['product_code' => $this->getProductCode()]
        ));
        $payload['sign'] = Support::generateSign($payload, $this->config->get('private_key'));

        Log::debug('Paying A Web/Wap Order:', [$endpoint, $payload]);

        return $this->buildPayHtml($endpoint, $payload);
    }

    /**
     * Build Html response.
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return Response
     */
    protected function buildPayHtml($endpoint, $payload)
    {
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$endpoint."' method='POST'>";
        foreach ($payload as $key => $val) {
            $val = str_replace("'", '&apos;', $val);
            $sHtml .= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }
        $sHtml .= "<input type='submit' value='ok' style='display:none;''></form>";
        $sHtml .= "<script>document.forms['alipaysubmit'].submit();</script>";

        return Response::create($sHtml);
    }

    /**
     * Get method config.
     *
     * @return string
     */
    protected function getMethod()
    {
        return 'alipay.trade.page.pay';
    }

    /**
     * Get productCode config.
     *
     * @return string
     */
    protected function getProductCode()
    {
        return 'FAST_INSTANT_TRADE_PAY';
    }
}
