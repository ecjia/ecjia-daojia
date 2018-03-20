<?php

namespace Royalcms\Component\Map;

use Royalcms\Component\Support\ServiceProvider;

class MapServicesProvider extends ServiceProvider
{
    public function boot()
    {
        $this->package('royalcms/map');
    }

    public function register()
    {
        //注册地图api服务
        $this->royalcms->bind('map', function ($royalcms) {
            return new MapManager($royalcms);
        });
    }
    
}

