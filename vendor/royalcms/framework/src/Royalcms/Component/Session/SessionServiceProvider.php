<?php

namespace Royalcms\Component\Session;

use Royalcms\Component\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        $this->setupDefaultDriver();

        $this->registerSessionManager();

        $this->registerSessionDriver();

        $this->royalcms->singleton('Royalcms\Component\Session\Middleware\StartSession');
    }

    /**
     * Setup the default session driver for the application.
     * @return void
     */
    protected function setupDefaultDriver()
    {
        if ($this->royalcms->runningInConsole()) {
            $this->royalcms['config']['session.driver'] = 'array';
        }
    }

    /**
     * Register the session manager instance.
     * @return void
     */
    protected function registerSessionManager()
    {
        $this->royalcms->singleton('session', function ($royalcms) {
            return new SessionManager($royalcms);
        });
    }

    /**
     * Register the session driver instance.
     * @return void
     */
    protected function registerSessionDriver()
    {
        $this->royalcms->singleton('session.store', function ($royalcms) {
            // First, we will create the session manager which is responsible for the
            // creation of the various session drivers when they are needed by the
            // application instance, and will resolve them on a lazy load basis.
            $manager = $royalcms['session'];

            return $manager->driver();
        });
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
            'Royalcms\Component\Session\CacheBasedSessionHandler'    => 'Illuminate\Session\CacheBasedSessionHandler',
            'Royalcms\Component\Session\Console\SessionTableCommand' => 'Illuminate\Session\Console\SessionTableCommand',
            'Royalcms\Component\Session\CookieSessionHandler'        => 'Illuminate\Session\CookieSessionHandler',
            'Royalcms\Component\Session\DatabaseSessionHandler'      => 'Illuminate\Session\DatabaseSessionHandler',
            'Royalcms\Component\Session\EncryptedStore'              => 'Illuminate\Session\EncryptedStore',
            'Royalcms\Component\Session\ExistenceAwareInterface'     => 'Illuminate\Session\ExistenceAwareInterface',
            'Royalcms\Component\Session\FileSessionHandler'          => 'Illuminate\Session\FileSessionHandler',
            'Royalcms\Component\Session\Middleware\StartSession'     => 'Illuminate\Session\Middleware\StartSession',
            'Royalcms\Component\Session\TokenMismatchException'      => 'Illuminate\Session\TokenMismatchException'
        ];
    }

}
