<?php namespace Royalcms\Component\View;

use Royalcms\Component\Support\MessageBag;
use Royalcms\Component\View\Engines\PhpEngine;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\View\Engines\EngineResolver;

class ViewServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerEngineResolver();

		$this->registerViewFinder();

		// Once the other components have been registered we're ready to include the
		// view environment and session binder. The session binder will bind onto
		// the "before" application event and add errors into shared view data.
		$this->registerEnvironment();

		$this->registerSessionBinder();
	}

	/**
	 * Register the engine resolver instance.
	 *
	 * @return void
	 */
	public function registerEngineResolver()
	{
		$me = $this;

		$this->royalcms->bindShared('view.engine.resolver', function($royalcms) use ($me)
		{
			$resolver = new EngineResolver;

			// Next we will register the various engines with the resolver so that the
			// environment can resolve the engines it needs for various views based
			// on the extension of view files. We call a method for each engines.
			foreach (array('php') as $engine)
			{
				$me->{'register'.ucfirst($engine).'Engine'}($resolver);
			}

			return $resolver;
		});
	}

	/**
	 * Register the PHP engine implementation.
	 *
	 * @param  \Royalcms\Component\View\Engines\EngineResolver  $resolver
	 * @return void
	 */
	public function registerPhpEngine($resolver)
	{
		$resolver->register('php', function() { return new PhpEngine; });
	}

	/**
	 * Register the view finder implementation.
	 *
	 * @return void
	 */
	public function registerViewFinder()
	{
		$this->royalcms->bindShared('view.finder', function($royalcms)
		{
			$paths = $royalcms['config']['view.paths'];

			return new FileViewFinder($royalcms['files'], $paths);
		});
	}

	/**
	 * Register the view environment.
	 *
	 * @return void
	 */
	public function registerEnvironment()
	{
		$this->royalcms->bindShared('view', function($royalcms)
		{
			// Next we need to grab the engine resolver instance that will be used by the
			// environment. The resolver will be used by an environment to get each of
			// the various engine implementations such as plain PHP or Blade engine.
			$resolver = $royalcms['view.engine.resolver'];

			$finder = $royalcms['view.finder'];

			$env = new Environment($resolver, $finder, $royalcms['events']);

			// We will also set the container instance on this view environment since the
			// view composers may be classes registered in the container, which allows
			// for great testable, flexible composers for the application developer.
			$env->setContainer($royalcms);

			$env->share('royalcms', $royalcms);

			return $env;
		});
	}

	/**
	 * Register the session binder for the view environment.
	 *
	 * @return void
	 */
	protected function registerSessionBinder()
	{
		list($royalcms, $me) = array($this->royalcms, $this);

		$royalcms->booted(function() use ($royalcms, $me)
		{
			// If the current session has an "errors" variable bound to it, we will share
			// its value with all view instances so the views can easily access errors
			// without having to bind. An empty bag is set when there aren't errors.
			if ($me->sessionHasErrors($royalcms))
			{
				$errors = $royalcms['session.store']->get('errors');

				$royalcms['view']->share('errors', $errors);
			}

			// Putting the errors in the view for every view allows the developer to just
			// assume that some errors are always available, which is convenient since
			// they don't have to continually run checks for the presence of errors.
			else
			{
				$royalcms['view']->share('errors', new MessageBag);
			}
		});
	}

	/**
	 * Determine if the application session has errors.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @return bool
	 */
	public function sessionHasErrors($royalcms)
	{
		$config = $royalcms['config']['session'];

		if (isset($royalcms['session.store']) && ! is_null($config['driver']))
		{
			return $royalcms['session.store']->has('errors');
		}
	}

}
