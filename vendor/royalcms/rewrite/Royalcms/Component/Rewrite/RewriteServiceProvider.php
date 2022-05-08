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
<<<<<<< HEAD
		$this->royalcms->bindShared('rewrite', function($royalcms)
=======
		$this->royalcms->singleton('rewrite', function($royalcms)
>>>>>>> v2-test
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

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/rewrite');

        return [
            $dir . "/Facades/Rewrite.php",
            $dir . "/RewriteQuery.php",
            $dir . "/Rewrite.php",
            $dir . "/MatchesMapRegex.php",
<<<<<<< HEAD
=======
            $dir . "/EndpointMaskEnum.php",
>>>>>>> v2-test
            $dir . "/RewriteServiceProvider.php",
        ];
    }

}
