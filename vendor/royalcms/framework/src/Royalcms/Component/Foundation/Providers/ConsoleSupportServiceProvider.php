<?php

namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\AggregateServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider as LaravelConsoleSupportServiceProvider;

class ConsoleSupportServiceProvider extends LaravelConsoleSupportServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        'Royalcms\Component\Foundation\Providers\ComposerServiceProvider',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $providers = config('console.providers', []);

        foreach ($providers as $provider) {
            $this->providers[] = $provider;
        }

        parent::register();
    }

}
