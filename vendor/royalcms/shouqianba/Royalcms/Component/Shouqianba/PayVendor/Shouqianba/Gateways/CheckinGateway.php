<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/30
 * Time: 9:26 AM
 */

namespace Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Gateways;

use Royalcms\Component\Support\Collection;
use Royalcms\Component\Pay\Contracts\GatewayInterface;
use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Support;

class ActivateGateway implements GatewayInterface
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
     * @param \Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Orders\TerminalCheckin  $payload
     *
     * @throws \Royalcms\Component\Pay\Exceptions\GatewayException
     *
     * @return Collection
     */
    public function pay($endpoint, $payload)
    {
        $api = $this->getMethod();

        $payload->setTerminalSn($this->config->get('terminal_sn')); //终端号

        $params = $payload->toArray();

        $result = Support::activateTerminal($api, $params, $this->config->get('vendor_sn'), $this->config->get('vendor_key'));

        return collect($result);
    }

    /**
     * Get method config.
     *
     * @return string
     */
    protected function getMethod()
    {
        return '/terminal/checkin';
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