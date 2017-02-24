<?php namespace Royalcms\Component\Script;

use Royalcms\Component\Support\ServiceProvider;

class ScriptServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	    
		$this->registerScripts();

		$this->registerStyles();
		
		// Load the alias
		$this->loadAlias();
	}
	
	/**
	 * Register the session manager instance.
	 *
	 * @return void
	 */
	protected function registerScripts()
	{
	    $this->royalcms->bindShared('script', function($royalcms)
	    {
	        return new HandleScripts();
	    });
	}
	
	/**
	 * Register the session manager instance.
	 *
	 * @return void
	 */
	protected function registerStyles()
	{
	    $this->royalcms->bindShared('style', function($royalcms)
	    {
	        return new HandleStyles();
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
	        $loader->alias('RC_Script', 'Royalcms\Component\Script\Script');
	        $loader->alias('RC_Style', 'Royalcms\Component\Script\Style');
	    });
	}

}
