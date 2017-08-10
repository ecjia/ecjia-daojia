<?php

namespace Ecjia\App\Maintain;

use RC_Hook;
use RC_Cache;
use InvalidArgumentException;

class Factory
{
    
    protected static $factories;
    
    public function __construct()
    {
        self::$factories = $this->getFactories();
    }
    
    public function getFactories()
    {
        $cache_key = 'maintain_command_factories';
    
        $factories = RC_Cache::app_cache_get($cache_key, 'maintain');
        if (empty($factories)) {
    
            $dir = __DIR__ . '/Commands';
    
            $platforms = royalcms('files')->files($dir);

            $factories = [];
    
            foreach ($platforms as $key => $value) {
                $value = str_replace($dir . '/', '', $value);
                $value = str_replace('.php', '', $value);
                $className = __NAMESPACE__ . '\Commands\\' . $value;
                
                $key = with(new $className)->getCode();
                $factories[$key] = $className;
            }
    
            RC_Cache::app_cache_set($cache_key, $factories, 'maintain', 10080);
        }
    
        return RC_Hook::apply_filters('ecjia_maintain_command_filter', $factories);
    }
    
    
    public function getCommands()
    {
        $events = [];
    
        foreach (self::$factories as $key => $value) {
            $events[$key] = new $value;
        }
    
        return $events;
    }
    
    
    public function command($code)
    {
        if (!array_key_exists($code, self::$factories)) {
            throw new InvalidArgumentException("Command '$code' is not supported.");
        }
    
        $className = self::$factories[$code];
    
        return new $className();
    }
    
    
}
