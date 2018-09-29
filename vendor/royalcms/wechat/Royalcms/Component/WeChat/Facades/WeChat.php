<?php

namespace Royalcms\Component\WeChat\Facades;

use Royalcms\Component\Support\Facades\Facade;

class WeChat extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'wechat';
    }
    
}