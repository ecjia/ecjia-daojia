<?php namespace Royalcms\Component\Timer;

use Royalcms\Component\Support\ServiceProvider;

class TimerServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->royalcms->singleton('timer', function()
		{
			// Let's use the Royalcms start time if it is defined.
			$startTime = defined('ROYALCMS_START') ? ROYALCMS_START : null;
			
			return new Timer($startTime);
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
	        $loader->alias('RC_Timer', 'Royalcms\Component\Timer\Facades\Timer');
	    });
	}

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/timer');

        return [
            $dir . '/Timer.php',
            $dir . '/Facades/Timer.php',
            $dir . '/TimerServiceProvider.php',
        ];
    }
	
}
