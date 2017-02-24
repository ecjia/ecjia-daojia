<?php namespace Royalcms\Component\Debugbar;

use Royalcms\Component\Support\ServiceProvider;

class DebugbarServiceProvider extends ServiceProvider
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

        if ($royalcms->runningInConsole()) 
        {
            if ($this->royalcms['config']->get('debugbar.capture_console') && method_exists($royalcms, 'shutdown')) {
                $royalcms->shutdown(
                    function ($royalcms) {
                        /** 
                         * @var \Royalcms\Component\Debugbar\RoyalcmsDebugbar $debugbar 
                         */
                        $debugbar = $royalcms['debugbar'];
                        $debugbar->collectConsole();
                    }
                );
            } else {
                $this->royalcms['config']->set('debugbar.enabled', false);
            }
        } 
        elseif (!$this->shouldUseMiddleware()) 
        {
            $royalcms['router']->after(
                function ($request, $response) use ($royalcms) {
                    /** 
                     * @var \Royalcms\Component\Debugbar\RoyalcmsDebugbar $debugbar 
                     */
                    $debugbar = $royalcms['debugbar'];
                    $debugbar->modifyResponse($request, $response);
                }
            );
        }

        $this->royalcms['router']->get(
            '_debugbar/open',
            array(
                'uses' => 'Royalcms\Component\Debugbar\Controllers\OpenHandlerController@handle',
                'as' => 'debugbar.openhandler',
            )
        );

        $this->royalcms['router']->get(
            '_debugbar/assets/stylesheets',
            array(
                'uses' => 'Royalcms\Component\Debugbar\Controllers\AssetController@css',
                'as' => 'debugbar.assets.css',
            )
        );

        $this->royalcms['router']->get(
            '_debugbar/assets/javascript',
            array(
                'uses' => 'Royalcms\Component\Debugbar\Controllers\AssetController@js',
                'as' => 'debugbar.assets.js',
            )
        );

        if ($this->royalcms['config']->get('debugbar.enabled')) {
            /** 
             * @var \Royalcms\Component\Debugbar\RoyalcmsDebugbar $debugbar 
             */
            $debugbar = $this->royalcms['debugbar'];
            $debugbar->boot();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->alias(
            'DebugBar\DataFormatter\DataFormatter',
            'DebugBar\DataFormatter\DataFormatterInterface'
        );
        
        $this->royalcms['debugbar'] = $this->royalcms->share(
            function ($royalcms) {
                $debugbar = new RoyalcmsDebugbar($royalcms);

                $sessionManager = $royalcms['session'];
                $httpDriver = new SymfonyHttpDriver($sessionManager);
                $debugbar->setHttpDriver($httpDriver);

                return $debugbar;
            }
        );

        $this->royalcms['command.debugbar.clear'] = $this->royalcms->share(
            function ($royalcms) {
                return new Console\ClearCommand($royalcms['debugbar']);
            }
        );

        $this->commands(array('command.debugbar.clear'));

        if ($this->shouldUseMiddleware()) {
            $this->royalcms->middleware('Royalcms\Component\Debugbar\Middleware\Stack', array($this->royalcms));
        }
    }

    /**
     * Detect if the Middelware should be used.
     * 
     * @return bool
     */
    protected function shouldUseMiddleware()
    {
        $royalcms = $this->royalcms;
        $version = $royalcms::VERSION;
        return !$royalcms->runningInConsole();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('debugbar', 'command.debugbar.clear');
    }
}
