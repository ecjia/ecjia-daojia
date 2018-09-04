<?php namespace Royalcms\Component\Hook;

use Royalcms\Component\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider {
    
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerHookService();
	}

	/**
	 * Register the session manager instance.
	 *
	 * @return void
	 */
	protected function registerHookService()
	{
		$this->royalcms->singleton('hook', function($royalcms)
		{
			return new Hooks();
		});
	}

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/hook');

        return [
            $dir . '/Hooks.php',
            $dir . '/HookServiceProvider.php',
            $dir . '/Facades/Hook.php',
        ];
    }
	
}
