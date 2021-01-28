<?php

namespace Royalcms\Component\Cookie;


class CookieServiceProvider extends \Illuminate\Cookie\CookieServiceProvider
{
    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        parent::register();
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {

        return [
            'Royalcms\Component\Cookie\Middleware\AddQueuedCookiesToResponse' => 'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
            'Royalcms\Component\Cookie\Middleware\EncryptCookies'             => 'Illuminate\Cookie\Middleware\EncryptCookies',
            'Royalcms\Component\Cookie\CookieJar'                             => 'Illuminate\Cookie\CookieJar',
        ];
    }

}
