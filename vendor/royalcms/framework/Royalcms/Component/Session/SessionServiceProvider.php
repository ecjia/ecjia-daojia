<?php

namespace Royalcms\Component\Session;

use Royalcms\Component\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setupDefaultDriver();

        $this->registerSessionManager();

        $this->registerSessionDriver();

        $this->royalcms->singleton('Royalcms\Component\Session\Middleware\StartSession');
    }

    /**
     * Setup the default session driver for the application.
     *
     * @return void
     */
    protected function setupDefaultDriver()
    {
        if ($this->royalcms->runningInConsole())
        {
            $this->royalcms['config']['session.driver'] = 'array';
        }
    }

    /**
     * Register the session manager instance.
     *
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
     *
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
}
