<?php namespace Royalcms\Component\Variable;

use Royalcms\Component\Support\ServiceProvider;

class VariableServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('variable', function($royalcms)
		{
			return new Variable;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('variable');
	}

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/variable');

        return [
            $dir . '/Variable.php',
            $dir . '/VariableServiceProvider.php',
            $dir . '/Facades/Variable.php',
        ];
    }

}
