<?php

namespace Royalcms\Component\WeChat\Foundation;

use Royalcms\Component\WeChat\Core\AccessToken;
use Royalcms\Component\WeChat\Core\Http;
use Royalcms\Component\WeChat\Support\Log;
use Royalcms\Component\Container\Container;

class WeChat extends Container
{

    /**
     * WeChat constructor.
     *
     * @param array $config
     */
    public function init($config = array())
    {
        $this->registerConfig();
        
        if (!empty($config)) {
            $this['config'] = $this['config']->merge($config);
        }

        $this->registerAccessToken();
        
        $options = $this['config']->get('guzzle', array('timeout' => 5.0));
        $options['verify'] = realpath(__DIR__ . '/../../../../certificates/cacert.pem');

        Http::setDefaultOptions($options);
        
        foreach (array('app_id', 'app_secret') as $key) {
            !isset($config[$key]) || $config[$key] = '***'.substr($config[$key], -5);
        }

        Log::debug('Current config:', $config);

        $this->registerProvider();
    }


    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    
    private function registerConfig()
    {
        $config = royalcms('config')->get('wechat::config', array());
        $this['config'] = function () use ($config) {
            return new Config($config);
        };
    }
    
    private function registerAccessToken()
    {
        $this['access_token'] = function () {
            return new AccessToken(
                $this['config']['app_id'],
                $this['config']['app_secret'],
                $this['cache']
            );
        };
    }

    private function registerProvider()
    {
        $royalcms = royalcms();
        collect(config('wechat::provider', []))->map(function($provider) use ($royalcms) {
            if (class_exists($provider)) $royalcms->register($provider);
        });
    }

    public function log()
    {
        return Log::getLogger();
    }

}
