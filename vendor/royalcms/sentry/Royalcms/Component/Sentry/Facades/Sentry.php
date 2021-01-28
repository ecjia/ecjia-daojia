<?php

namespace Royalcms\Component\Sentry\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Sentry extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sentry';
    }
}
