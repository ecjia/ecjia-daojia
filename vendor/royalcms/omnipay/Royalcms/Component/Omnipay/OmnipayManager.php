<?php 

namespace Royalcms\Component\Omnipay;

use Closure;
use Omnipay\Common\Helper;
use Omnipay\Common\CreditCard;

class OmnipayManager {
    /**
     * The royalcms instance.
     *
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Omnipay Factory Instance
     * @var \Omnipay\Common\GatewayFactory
     */
    protected $factory;

    /**
     * The current gateway to use
     * @var string
     */
    protected $gateway;

    /**
     * The array of resolved queue connections.
     *
     * @var array
     */
    protected $gateways = [];

    /**
     * Create a new omnipay manager instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms $royalcms
     * @param $factory
     */
    public function __construct($royalcms, $factory)
    {
        $this->royalcms = $royalcms;
        $this->factory = $factory;
    }

    /** 
     * Get an instance of the specified gateway
     * @param  index of config array to use
     * @return Omnipay\Common\AbstractGateway
     */
    public function gateway($name = null)
    {
        $name = $name ?: $this->getGateway();

        if ( ! isset($this->gateways[$name]))
        {
            $this->gateways[$name] = $this->resolve($name);
        }

        return $this->gateways[$name];
    }

    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if(is_null($config))
        {
            throw new \UnexpectedValueException("Gateway [$name] is not defined.");
        }

        $gateway = $this->factory->create($config['driver']);

        $class = trim(Helper::getGatewayClassName($config['driver']), "\\");

        $reflection = new \ReflectionClass($class);

        foreach($config['options'] as $optionName=>$value)
        {
            $method = 'set' . ucfirst($optionName);

            if ($reflection->hasMethod($method)) {
                $gateway->{$method}($value);
            }
        }

        return $gateway;
    }

    public function creditCard($cardInput)
    {
        return new CreditCard($cardInput);
    }

    protected function getDefault()
    {
        return $this->royalcms['config']['omnipay::config.default'];
    }

    protected function getConfig($name)
    {
        return $this->royalcms['config']["omnipay::config.gateways.{$name}"];
    }

    public function getGateway()
    {
        if(!isset($this->gateway))
        {
            $this->gateway = $this->getDefault();
        }
        return $this->gateway;
    }

    public function setGateway($name)
    {
        $this->gateway = $name;
    }

    public function __call($method, $parameters)
    {
        $callable = [$this->gateway(), $method];

        if (method_exists($this->gateway(), $method))
        {
            return call_user_func_array($callable, $parameters);
        }

        throw new \BadMethodCallException("Method [$method] is not supported by the gateway [$this->gateway].");
    }
}