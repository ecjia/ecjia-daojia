<?php

namespace Royalcms\Component\Pay;

use Royalcms\Component\Pay\Contracts\GatewayApplicationInterface;
use Royalcms\Component\Pay\Exceptions\InvalidGatewayException;
use Royalcms\Component\Pay\PayVendor\Alipay\Alipay;
use Royalcms\Component\Pay\PayVendor\Wechat\Wechat;
use Royalcms\Component\Pay\Support\Config;
use Royalcms\Component\Support\Facades\Log;
use Royalcms\Component\Support\Str;
use Closure;

/**
 * @method static Alipay alipay(array $config) 支付宝
 * @method static Wechat wechat(array $config) 微信
 */
class Pay
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * Bootstrap.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }


    /**
     * Create a instance.
     *
     * @param string $method
     *
     * @throws InvalidGatewayException
     * @throws \Exception
     *
     * @return GatewayApplicationInterface
     */
    protected function create($method)
    {
        !$this->config->has('log.file') ?: $this->registerLog();

        if (isset($this->customCreators[$method])) {

            return $this->callCustomCreator($method, $this->config);

        } else {

            $gateway = __NAMESPACE__.'\\PayVendor\\'.Str::studly($method).'\\'.Str::studly($method);

            if (class_exists($gateway)) {
                return self::make($gateway);
            }

            throw new InvalidGatewayException("Gateway [{$method}] Not Exists");

        }
    }

    /**
     * Make a gateway.
     *
     * @param string $gateway
     *
     * @throws InvalidGatewayException
     *
     * @return GatewayApplicationInterface
     */
    public function make($gateway)
    {
        $app = new $gateway($this->config);

        if ($app instanceof GatewayApplicationInterface) {
            return $app;
        }

        throw new InvalidGatewayException("Gateway [$gateway] Must Be An Instance Of GatewayApplicationInterface");
    }

    /**
     * Register log service.
     *
     * @throws \Exception
     */
    protected function registerLog()
    {
        $logger = Log::createLogger(
            $this->config->get('log.file'),
            'royalcms.pay',
            $this->config->get('log.level', 'warning'),
            $this->config->get('log.type', 'daily'),
            $this->config->get('log.max_file', 30)
        );

        Log::setLogger($logger);
    }

    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return mixed
     */
    protected function callCustomCreator($driver, Config $config)
    {
        return $this->customCreators[$driver]($config);
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param  string    $driver
     * @param  \Closure  $callback
     * @return $this
     */
    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     * Magic static call.
     *
     * @param string $method
     * @param array  $params
     *
     * @throws InvalidGatewayException
     *
     * @return GatewayApplicationInterface
     */
    public function __call($method, $params)
    {
        if (is_array($params[0])) {
            $config = $params[0];
        }
        $this->config = new Config($config);

        return $this->create($method);
    }

}
