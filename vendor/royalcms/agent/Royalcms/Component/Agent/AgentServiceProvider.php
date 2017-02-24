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
    }

}
