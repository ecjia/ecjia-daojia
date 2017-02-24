<?php namespace Royalcms\Component\Rewrite;

use Royalcms\Component\Support\ServiceProvider;

class RewriteServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->royalcms->bindShared('rewrite', function($royalcms)
		{
			return new RewriteQuery();
		});
		
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
	        $loader->alias('RC_Rewrite', 'Royalcms\Component\Rewrite\Facades\Rewrite');
	    });
	}

}
