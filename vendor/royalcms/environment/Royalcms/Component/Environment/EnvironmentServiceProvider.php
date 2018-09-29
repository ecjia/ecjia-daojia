<?php

namespace Royalcms\Component\Environment;

use Royalcms\Component\Support\ServiceProvider;

class EnvironmentServiceProvider extends ServiceProvider
{
    
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->royalcms->bindShared('phpinfo', function($royalcms)
		{
			return new Phpinfo();
		});
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
	    return array('phpinfo');
	}

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/environment');

        return [
            $dir . "/Facades/Environment.php",
            $dir . "/EnvironmentServiceProvider.php",
        ];
    }

}
