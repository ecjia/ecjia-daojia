<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\View\Compilers\BladeCompiler
 */
class Blade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return static::$royalcms['view']->getEngineResolver()->resolve('blade')->getCompiler();
    }
}
