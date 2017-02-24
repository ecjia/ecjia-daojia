<?php namespace Royalcms\Component\Session;

use Royalcms\Component\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->setupDefaultDriver();

		$this->registerSessionManager();

		$this->registerSessionDriver();
		
		$this->registerStartSession();
		
// 		$this->registerSessionMiddleware();
	}

	/**
	 * Setup the default session driver for the application.
	 *
	 * @return void
	 */
	protected function setupDefaultDriver()
	{
		if ($this->royalcms->runningInConsole())
		{
			$this->royalcms['config']['session.driver'] = 'array';
		}
	}

	/**
	 * Register the session manager instance.
	 *
	 * @return void
	 */
	protected function registerSessionManager()
	{
		$this->royalcms->bindShared('session', function($royalcms)
		{
			return new SessionManager($royalcms);
		});
	}

	/**
	 * Register the session driver instance.
	 *
	 * @return void
	 */
	protected function registerSessionDriver()
	{
		$this->royalcms->bindShared('session.store', function($royalcms)
		{
			// First, we will create the session manager which is responsible for the
			// creation of the various session drivers when they are needed by the
			// application instance, and will resolve them on a lazy load basis.
			$manager = $royalcms['session'];

			return $manager->driver();
		});
	}
	
	/**
	 * Register the session middleware instance.
	 *
	 * @return void
	 */
	protected function registerStartSession()
	{
	    $this->royalcms->bindShared('session.start', function($royalcms)
		{
			// First, we will create the session manager which is responsible for the
			// creation of the various session drivers when they are needed by the
			// application instance, and will resolve them on a lazy load basis.
			$manager = $royalcms['session'];

			return new StartSession($manager);
		});
	}
	
	/**
	 * Register the session middleware instance.
	 *
	 * @return void
	 */
	protected function registerSessionMiddleware()
	{
	    $royalcms = $this->royalcms;
	    $sessionReject = $royalcms->bound('session.reject') ? $royalcms['session.reject'] : null;
	    $royalcms->middleware('Royalcms\Component\Session\Middleware', array($royalcms['session'], $sessionReject));
	}

	/**
	 * Get the session driver name.
	 *
	 * @return string
	 */
	protected function getDriver()
	{
		return $this->royalcms['config']['session.driver'];
	}

}
