<?php

namespace Ecjia\App\Market;

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
        $cache_key = 'market_activity_factories';
    
        $factories = ecjia_cache('market')->get($cache_key);
        if (empty($factories)) {
    
            $dir = __DIR__ . '/Activities';
    
            $platforms = royalcms('files')->files($dir);

            $factories = [];
    
            foreach ($platforms as $key => $value) {
                $value = str_replace($dir . '/', '', $value);
                $value = str_replace('.php', '', $value);
                $className = __NAMESPACE__ . '\Activities\\' . $value;
                
                $key = with(new $className)->getCode();
                $factories[$key] = $className;
            }
    
            ecjia_cache('market')->put($cache_key, $factories, 10080);
        }
    
        return RC_Hook::apply_filters('ecjia_market_activity_filter', $factories);
    }
    
    
    public function getDrivers($supportType = MarketAbstract::DISPLAY_ADMIN | MarketAbstract::ACCOUNT_ADMIN)
    {
        $events = [];
    
        foreach (self::$factories as $key => $value) {
            $inst = new $value;
            if ($inst->hasSupport($supportType)) {
                $events[$key] = $inst;
            }
        }
    
        return $events;
    }
    
    
    public function driver($code)
    {
        if (!array_key_exists($code, self::$factories)) {
            throw new InvalidArgumentException("Activity '$code' is not supported.");
        }
    
        $className = self::$factories[$code];
    
        return new $className();
    }
    
    
}
