<?php 

namespace Royalcms\Component\Hashids;

use Hashids\Hashids;
use Royalcms\Component\Support\ServiceProvider;

class HashidsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('royalcms/hashids');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->bind('hashids', function ($royalcms) {
            $config = $royalcms->config->get('hashids::hashids');

            return new Hashids(
                array_get($config, 'salt'),
                array_get($config, 'length', 0),
                array_get($config, 'alphabet')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hashids'];
    }
}
