<?php namespace Royalcms\Component\Sentry;

use Log;
use Royalcms\Component\Support\ServiceProvider;

class SentryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $royalcms = $this->royalcms;
        
        $royalcms->error(function (\Exception $e) use ($royalcms) {
            $royalcms['sentry']->captureException($e);
        });

        $royalcms->fatal(function ($e) use ($royalcms) {
            $royalcms['sentry']->captureException($e);
        });

        $this->bindEvents($royalcms);
    }

    protected function bindEvents($royalcms)
    {
        $handler = new SentryEventHandler($royalcms['sentry'], $royalcms['sentry.config']);
        $handler->subscribe($royalcms->events);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms['config']->package('royalcms/sentry', __DIR__ . '/Config');
        
        $this->bindSentryConfig();

        $this->bindSentry();
        
        $this->loadAlias();
    }
    
    
    protected function bindSentryConfig()
    {
        $this->royalcms->singleton('sentry.config', function ($royalcms) {
            // sentry::config is Laravel 4.x
            $user_config = $royalcms['config']->get('sentry::config');
            // Make sure we don't crash when we did not publish the config file
            if (is_null($user_config)) {
                $user_config = array();
            }
        
            return $user_config;
        });
    }
    
    protected function bindSentry()
    {
        $this->royalcms->singleton('sentry', function ($royalcms) {
            $user_config = $royalcms['sentry.config'];
        
            $client = Sentry::getClient(array_merge(array(
                'environment' => $royalcms->environment(),
                'prefixes' => array(base_path()),
                'app_path' => app_path(),
            ), $user_config));
        
            return $client;
        });
    }
    
    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $this->royalcms->booting(function()
        {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('RC_Sentry', 'Royalcms\Component\Sentry\Facades\Sentry');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('sentry');
    }
}
