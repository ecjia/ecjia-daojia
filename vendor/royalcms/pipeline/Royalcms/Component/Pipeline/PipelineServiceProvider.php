<?php

namespace Royalcms\Component\Pipeline;

use Royalcms\Component\Support\ServiceProvider;

class PipelineServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton(
            'Royalcms\Component\Contracts\Pipeline\Hub', 'Royalcms\Component\Pipeline\Hub'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Royalcms\Component\Contracts\Pipeline\Hub',
        ];
    }
}
