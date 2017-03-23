<?php namespace Royalcms\Component\Agent;

use Royalcms\Component\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->royalcms['agent'] = $this->royalcms->share(function ($royalcms)
        {
            return new Agent($royalcms['request']->server->all());
        });
        
        // Load the alias
        $this->loadAlias();
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $this->royalcms->booting(function()
        {
            $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
            $loader->alias('RC_Agent', 'Royalcms\Component\Agent\Facades\Agent');
        });
    }
    
}
