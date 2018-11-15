<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/30
 * Time: 9:26 AM
 */

namespace Royalcms\Component\Shouqianba\Gateways\Shouqianba;

use Royalcms\Component\Pay\Contracts\GatewayInterface;
use Royalcms\Component\Pay\Contracts\PayloadInterface;
use Royalcms\Component\Pay\Log;
use Royalcms\Component\Shouqianba\Gateways\Shouqianba\Orders\PayOrder;
use Royalcms\Component\Support\Collection;
use Royalcms\Component\Pay\Support\Config;
use RC_Error;

class ScanGateway implements GatewayInterface
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
     *
     * @return Collection
     */
    public function pay($endpoint, PayloadInterface $payload)
    {
        $api = $this->getMethod();

        $payload->setTerminalSn($this->config->get('terminal_sn')); //终端号

        $params = $payload->toArray();
        
        $result = Support::sendRequest($api, $params, $this->config->get('terminal_sn'), $this->config->get('terminal_key'));

        return collect($result);
    }

    /**
     * Get method config.
     *
     * @return string
     */
    protected function getMethod()
    {
        return '/upay/v2/pay';
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