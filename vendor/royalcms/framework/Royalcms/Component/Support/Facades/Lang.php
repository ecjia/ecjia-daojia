<?php

namespace Royalcms\Component\Support\Facades;

use Royalcms\Component\Translation\CompatibleTrait;

/**
 * @see \Royalcms\Component\Translation\Translator
 */
class Lang extends Facade
{
    use CompatibleTrait;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'translator';
    }
}
