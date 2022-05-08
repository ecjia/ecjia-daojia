<?php

namespace Royalcms\Component\Script;

use Royalcms\Component\Support\ServiceProvider;

class ScriptServiceProvider extends ServiceProvider
{

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
<<<<<<< HEAD
	    $this->royalcms->bindShared('script', function($royalcms)
=======
	    $this->royalcms->singleton('script', function($royalcms)
>>>>>>> v2-test
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
<<<<<<< HEAD
	    $this->royalcms->bindShared('style', function($royalcms)
=======
	    $this->royalcms->singleton('style', function($royalcms)
>>>>>>> v2-test
	    {
	        return new HandleStyles();
	    });
	}
	
	/**
	 * Load the alias = One less install step for the user
	 */
	protected function loadAlias()
	{
<<<<<<< HEAD
	    $this->royalcms->booting(function()
	    {
	        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
	        $loader->alias('RC_Script', 'Royalcms\Component\Script\Script');
	        $loader->alias('RC_Style', 'Royalcms\Component\Script\Style');
	    });
=======
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
        $loader->alias('RC_Script', 'Royalcms\Component\Script\Facades\Script');
        $loader->alias('RC_Style', 'Royalcms\Component\Script\Facades\Style');
>>>>>>> v2-test
	}

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/script');

        return [
            $dir . '/Script.php',
            $dir . '/HandleScripts.php',
            $dir . '/Dependency.php',
            $dir . '/Dependencies.php',
            $dir . '/Style.php',
            $dir . '/HandleStyles.php',
            $dir . '/ScriptServiceProvider.php',
        ];
    }

}
