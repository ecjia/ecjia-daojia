<?php namespace Royalcms\Component\Memcache;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Memcache\Repository;

class MemcacheServiceProvider extends ServiceProvider {

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
	    $this->package('royalcms/memcache');
	    
		$this->bindMemcache();
		
		// Load the alias
		$this->loadAlias();
	}
	
	/**
	 * Bind Memcahce classes
	 * @return void
	 */
	protected function bindMemcache()
	{
	    $this->royalcms->bindShared('memcache', function($royalcms)
	    {
	        $config = $royalcms['config']->get('memcache::config');
	        $server = array_head($config['servers']);
	        return new Repository($server['hostname'], $server['port'], $config['driver']);
	    });
	}
	
	/**
	 * Load the alias = One less install step for the user
	 */
	protected function loadAlias()
	{
	    $this->royalcms->booting(function()
	    {
	        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
	        $loader->alias('RC_Memcache', 'Royalcms\Component\Memcache\Facades\Memcache');
	    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('memcache');
	}

}
