<?php

namespace Royalcms\Component\Sentry;

use Royalcms\Component\Support\ServiceProvider;
use Exception;

class SentryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Abstract type to bind Sentry as in the Service Container.
     *
     * @var string
     */
    public static $abstract = 'sentry';

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

        if ($royalcms->runningInConsole()) {
            $this->registerArtisanCommands();
        }
    }

    /**
     * Register the artisan commands.
     */
    protected function registerArtisanCommands()
    {
        $this->commands(array(
            'Royalcms\Component\Sentry\SentryTestCommand',
        ));
    }

    /**
     * Bind to the Royalcms event dispatcher to log events.
     *
     * @param $app
     */
    protected function bindEvents($royalcms)
    {
        $user_config = $royalcms[static::$abstract . '.config'];

        $handler = new SentryEventHandler($royalcms[static::$abstract], $user_config);

        $handler->subscribe($royalcms->events);

        // In Royalcms >=5.3 we can get the user context from the auth events
        if (isset($user_config['user_context']) && $user_config['user_context'] !== false && version_compare($royalcms::VERSION, '5.3') >= 0) {
            $handler->subscribeAuthEvents($royalcms->events);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('royalcms/sentry');
        
        $this->bindSentryConfig();

        $this->bindSentry();

        $this->bindSentryLogChannel();
        
        $this->loadAlias();
    }
    
    
    protected function bindSentryConfig()
    {
        $this->royalcms->singleton(static::$abstract . '.config', function ($royalcms) {
            // sentry::config is Royalcms 4.x
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
        $this->royalcms->singleton(static::$abstract, function ($royalcms) {
            $user_config = $royalcms['sentry.config'];

            $base_path = base_path();
            $client = Sentry::getClient(array_merge(array(
                'environment' => $royalcms->environment(),
                'prefixes' => array($base_path),
                'app_path' => $base_path,
                'excluded_app_paths' => array($base_path . '/vendor'),
            ), $user_config));

            // In Royalcms <5.3 we can get the user context from here
            if (isset($user_config['user_context']) && $user_config['user_context'] !== false && version_compare($royalcms::VERSION, '5.3') < 0) {
                try {
                    // Bind user context if available
                    if ($royalcms['auth']->check()) {
                        $client->user_context(array(
                            'id' => $royalcms['auth']->user()->getAuthIdentifier(),
                        ));
                    }
                } catch (Exception $e) {
                    error_log(sprintf('sentry.breadcrumbs error=%s', $e->getMessage()));
                }
            }
        
            return $client;
        });
    }

    protected function bindSentryLogChannel()
    {
        $royalcms = $this->royalcms;

        // Add a sentry log channel for Laravel 5.6+
        if (version_compare($royalcms::VERSION, '5.6') >= 0) {
            $this->royalcms->make('log')->extend('sentry', function ($royalcms, array $config) {
                $channel = new SentryLogChannel($royalcms);
                return $channel($config);
            });
        }
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
        return array(static::$abstract);
    }
}
