<?php

namespace Royalcms\Component\Sms;

use InvalidArgumentException;

class Manager
{
    protected $royalcms;
    protected $factories;

    public function __construct($royalcms)
    {
        $this->royalcms = $royalcms;
        $this->factories = new Factory($royalcms);
    }

    public function driver($name = null)
    {
        $factories = $this->factories->getFactories();
        
        if ($name == 'fallback') {
            $name = $this->getFallbackDriver();
        } else {
            $name = $name ?: $this->getDefaultDriver();
        }
        
        if (!array_key_exists($name, $factories)) {
            throw new InvalidArgumentException("Driver '$name' is not supported.");
        }

        $className = $factories[$name];
        $config = $this->getConfig($name);

        return new $className($config);
    }

    protected function getConfig($name)
    {
        return $this->royalcms['config']["sms::sms.agents.{$name}"];
    }

    protected function getDefaultDriver()
    {
        return $this->royalcms['config']['sms::sms.default'];
    }

    protected function getFallbackDriver()
    {
        return $this->royalcms['config']['sms::sms.fallback'];
    }
}
