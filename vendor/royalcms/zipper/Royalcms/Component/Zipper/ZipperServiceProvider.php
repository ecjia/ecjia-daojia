<?php namespace Royalcms\Component\Zipper;

use Royalcms\Component\Foundation\AliasLoader;
use Royalcms\Component\Support\ServiceProvider;

class ZipperServiceProvider extends ServiceProvider {

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
        $this->package('royalcms/zipper');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms['zipper'] = $this->royalcms->share(function($app)
        {
            $return = $app->make('Royalcms\Component\Zipper\Zipper');
            return $return;
        });

        $this->royalcms->booting(function()
        {
            $loader = AliasLoader::getInstance();
            $loader->alias('Zipper', 'Royalcms\Component\Zipper\Facades\Zipper');
        });
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('zipper');
	}

}