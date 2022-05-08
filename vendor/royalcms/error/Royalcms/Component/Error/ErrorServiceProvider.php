<?php namespace Royalcms\Component\Error;

use Royalcms\Component\Support\ServiceProvider;

class ErrorServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
<<<<<<< HEAD
	    $this->royalcms->bindShared('error', function($royalcms)
=======
	    $this->royalcms->singleton('error', function($royalcms)
>>>>>>> v2-test
	    {
	        return new Error();
	    });
	}

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/error');

        return [
            $dir . '/Error.php',
            $dir . '/ErrorDisplay.php',
            $dir . '/ErrorServiceProvider.php',
            $dir . '/Facades/Error.php',
        ];
    }

}
