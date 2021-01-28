<?php

namespace Royalcms\Component\Support\Facades;

use Royalcms\Component\Translation\CompatibleTrait;

/**
 * @method static mixed get(string $key, array $replace = [], string $locale = null, bool $fallback = true)
 * @method static string choice(string $key, \Countable|int|array $number, array $replace = [], string $locale = null)
 * @method static string getLocale()
 * @method static void setLocale(string $locale)
 * 
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
