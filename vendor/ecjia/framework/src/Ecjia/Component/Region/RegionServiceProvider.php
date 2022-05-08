<?php 

namespace Ecjia\Component\Region;

use RC_Service;
use Royalcms\Component\Support\ServiceProvider;

class RegionServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->registerRegion();
	    
	    $this->loadAlias();
	}
	
	/**
	 * Register the region
	 * @return \Ecjia\App\Setting\Region
	 */
	public function registerRegion() 
	{
	    $this->royalcms->singleton('ecjia.region', function($royalcms){
	    	return new Region();
	    });
	}
	
	/**
	 * Load the alias = One less install step for the user
	 */
	protected function loadAlias()
	{
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
	}

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {
        return [
            'ecjia_region' => 'Ecjia\Component\Region\Facades\Region'
        ];
    }
	
}
