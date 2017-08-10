<?php 

namespace Royalcms\Component\Pinyin;

use Royalcms\Component\Support\ServiceProvider;

class PinyinServiceProvider extends ServiceProvider
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
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms['pinyin'] = $this->royalcms->share(
            function ($royalcms) {
                return new Pinyin;
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('pinyin');
    }
}
