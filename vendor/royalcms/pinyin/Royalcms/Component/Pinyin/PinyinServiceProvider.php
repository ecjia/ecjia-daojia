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
            $loader->alias('RC_Pinyin', 'Royalcms\Component\Pinyin\Facades\Pinyin');
        });
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
