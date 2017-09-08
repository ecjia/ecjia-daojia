<?php namespace Royalcms\Component\Foundation;

use Closure;
use Royalcms\Component\HttpKernel\Request;
use Royalcms\Component\HttpKernel\Response;
use Royalcms\Component\Config\FileLoader;
use Royalcms\Component\Container\Container;
use Royalcms\Component\Filesystem\Filesystem;
use Royalcms\Component\Support\Facades\Facade;
use Royalcms\Component\Event\EventServiceProvider;
use Royalcms\Component\Routing\RoutingServiceProvider;
use Royalcms\Component\Exception\ExceptionServiceProvider;
use Royalcms\Component\Config\FileEnvironmentVariablesLoader;
use Royalcms\Component\Stack\Builder;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Royalcms\Component\Support\Contracts\ResponsePreparerInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Royalcms extends Container implements HttpKernelInterface, TerminableInterface, ResponsePreparerInterface {

	/**
	 * The Royalcms framework version.
	 *
	 * @var string
	 */
	const VERSION = '4.3.0';
	
	/**
	 * The Royalcms framework release.
	 *
	 * @var string
	 */
	const RELEASE = '2017-08-31';
	
	/**
	 * The Royalcms framework minimum PHP version requirements.
	 *
	 * @var string
	 */
	const PHP_REQUIRED = '5.4.0';

	/**
	 * Indicates if the application has "booted".
	 *
	 * @var bool
	 */
	protected $booted = false;

	/**
	 * The array of booting callbacks.
	 *
	 * @var array
	 */
	protected $bootingCallbacks = array();

	/**
	 * The array of booted callbacks.
	 *
	 * @var array
	 */
	protected $bootedCallbacks = array();

	/**
	 * The array of finish callbacks.
	 *
	 * @var array
	 */
	protected $finishCallbacks = array();

	/**
	 * The array of shutdown callbacks.
	 *
	 * @var array
	 */
	protected $shutdownCallbacks = array();

	/**
	 * All of the developer defined middlewares.
	 *
	 * @var array
	 */
	protected $middlewares = array();

	/**
	 * All of the registered service providers.
	 *
	 * @var array
	 */
	protected $serviceProviders = array();

	/**
	 * The names of the loaded service providers.
	 *
	 * @var array
	 */
	protected $loadedProviders = array();

	/**
	 * The deferred services and their providers.
	 *
	 * @var array
	 */
	protected $deferredServices = array();

	/**
	 * The request class used by the application.
	 *
	 * @var string
	 */
	protected static $requestClass = 'Royalcms\Component\HttpKernel\Request';
	
	/**
	 * The environment file to load during bootstrapping.
	 *
	 * @var string
	 */
	protected $environmentFile = '.env';

	/**
	 * Create a new Royalcms application instance.
	 *
	 * @param  \Royalcms\Component\HttpKernel\Request
	 * @return void
	 */
	public function __construct(Request $request = null)
	{	    
		$this->registerBaseBindings($request ?: $this->createNewRequest());

		$this->registerBaseServiceProviders();

		$this->registerBaseMiddlewares();
	}

	/**
	 * Create a new request instance from the request class.
	 *
	 * @return \Royalcms\Component\HttpKernel\Request
	 */
	protected function createNewRequest()
	{
		return forward_static_call(array(static::$requestClass, 'createFromGlobals'));
	}

	/**
	 * Register the basic bindings into the container.
	 *
	 * @param  \Royalcms\Component\HttpKernel\Request  $request
	 * @return void
	 */
	protected function registerBaseBindings($request)
	{
		$this->instance('request', $request);

		$this->instance('Royalcms\Component\Container\Container', $this);
	}

	/**
	 * Register all of the base service providers.
	 * 
	 * @return void
	 */
	protected function registerBaseServiceProviders()
	{
		foreach (array('Event', 'Exception', 'Routing') as $name)
		{
			$this->{"register{$name}Provider"}();
		}
	}

	/**
	 * Register the exception service provider.
	 *
	 * @return void
	 */
	protected function registerExceptionProvider()
	{
		$this->register(new ExceptionServiceProvider($this));
	}

	/**
	 * Register the routing service provider.
	 *
	 * @return void
	 */
	protected function registerRoutingProvider()
	{
		$this->register(new RoutingServiceProvider($this));
	}

	/**
	 * Register the event service provider.
	 *
	 * @return void
	 */
	protected function registerEventProvider()
	{
		$this->register(new EventServiceProvider($this));
	}

	/**
	 * Bind the installation paths to the application.
	 *
	 * @param  array  $paths
	 * @return void
	 */
	public function bindInstallPaths(array $paths)
	{
		$this->instance('path', realpath($paths['sitecontent']));

		// Here we will bind the install paths into the container as strings that can be
		// accessed from any point in the system. Each path key is prefixed with path
		// so that they have the consistent naming convention inside the container.
		foreach (array_except($paths, array('sitecontent')) as $key => $value)
		{
			$this->instance("path.{$key}", realpath($value));
		}
	}

	/**
	 * Get the application bootstrap file.
	 *
	 * @return string
	 */
	public static function getBootstrapFile()
	{
		return __DIR__.'/Start.php';
	}

	/**
	 * Start the exception handling for the request.
	 *
	 * @return void
	 */
	public function startExceptionHandling()
	{
		$this['exception']->register($this->environment());

		$this['exception']->setDebug($this['config']['system.debug']);
	}
	
	/**
	 * Set the environment file to be loaded during bootstrapping.
	 *
	 * @param  string  $file
	 * @return $this
	 */
	public function loadEnvironmentFrom($file)
	{
	    $this->environmentFile = $file;
	
	    return $this;
	}
	
	/**
	 * Get the environment file the application is using.
	 *
	 * @return string
	 */
	public function environmentFile()
	{
	    return $this->environmentFile ?: '.env';
	}

	/**
	 * Get or check the current application environment.
	 *
	 * @param  dynamic
	 * @return string
	 */
	public function environment()
	{
		if (func_num_args() > 0)
		{
			$patterns = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

			foreach ($patterns as $pattern)
			{
				if (str_is($pattern, $this['env']))
				{
					return true;
				}
			}

			return false;
		}

		return $this['env'];
	}

	/**
	 * Determine if royalcms is in local environment.
	 *
	 * @return bool
	 */
	public function isLocal()
	{
		return $this['env'] == 'local';
	}

	/**
	 * Detect the royalcms's current environment.
	 *
	 * @param  array|string  $envs
	 * @return string
	 */
	public function detectEnvironment($envs)
	{
		$args = isset($_SERVER['argv']) ? $_SERVER['argv'] : null;

		return $this['env'] = with(new EnvironmentDetector())->detect($envs, $args);
	}

	/**
	 * Determine if we are running in the console.
	 *
	 * @return bool
	 */
	public function runningInConsole()
	{
		return php_sapi_name() == 'cli';
	}

	/**
	 * Determine if we are running unit tests.
	 *
	 * @return bool
	 */
	public function runningUnitTests()
	{
		return $this['env'] == 'testing';
	}

	/**
	 * Force register a service provider with the application.
	 *
	 * @param  \Royalcms\Component\Support\ServiceProvider|string  $provider
	 * @param  array  $options
	 * @return \Royalcms\Component\Support\ServiceProvider
	 */
	public function forgeRegister($provider, $options = array())
	{
		return $this->register($provider, $options, true);
	}

	/**
	 * Register a service provider with the application.
	 *
	 * @param  \Royalcms\Component\Support\ServiceProvider|string  $provider
	 * @param  array  $options
	 * @param  bool   $force
	 * @return \Royalcms\Component\Support\ServiceProvider
	 */
	public function register($provider, $options = array(), $force = false)
	{
	    $registered = $this->getRegistered($provider);
		if ($registered && ! $force) 
		{
            return $registered;
		}

		// If the given "provider" is a string, we will resolve it, passing in the
		// application instance automatically for the developer. This is simply
		// a more convenient way of specifying your service provider classes.
		if (is_string($provider))
		{
			$provider = $this->resolveProviderClass($provider);
		}

		$provider->register();

		// Once we have registered the service we will iterate through the options
		// and set each of them on the application so they will be available on
		// the actual loading of the service objects and for developer usage.
		foreach ($options as $key => $value)
		{
			$this[$key] = $value;
		}

		$this->markAsRegistered($provider);

		// If the application has already booted, we will call this boot method on
		// the provider class so it has an opportunity to do its boot logic and
		// will be ready for any usage by the developer's application logics.
		if ($this->booted) $provider->boot();

		return $provider;
	}

	/**
	 * Get the registered service provider instance if it exists.
	 *
	 * @param  \Royalcms\Component\Support\ServiceProvider|string  $provider
	 * @return \Royalcms\Component\Support\ServiceProvider|null
	 */
	public function getRegistered($provider)
	{
		$name = is_string($provider) ? $provider : get_class($provider);

		if (array_key_exists($name, $this->loadedProviders))
		{
			return array_first($this->serviceProviders, function($key, $value) use ($name)
			{
				return get_class($value) == $name;
			});
		}
	}

	/**
	 * Resolve a service provider instance from the class name.
	 *
	 * @param  string  $provider
	 * @return \Royalcms\Component\Support\ServiceProvider
	 */
	public function resolveProviderClass($provider)
	{
		return new $provider($this);
	}

	/**
	 * Mark the given provider as registered.
	 *
	 * @param  \Royalcms\Component\Support\ServiceProvider
	 * @return void
	 */
	protected function markAsRegistered($provider)
	{
		$this['events']->fire($class = get_class($provider), array($provider));

		$this->serviceProviders[] = $provider;

		$this->loadedProviders[$class] = true;
	}

	/**
	 * Load and boot all of the remaining deferred providers.
	 *
	 * @return void
	 */
	public function loadDeferredProviders()
	{
		// We will simply spin through each of the deferred providers and register each
		// one and boot them if the application has booted. This should make each of
		// the remaining services available to this application for immediate use.
		foreach ($this->deferredServices as $service => $provider)
		{
			$this->loadDeferredProvider($service);
		}

		$this->deferredServices = array();
	}

	/**
	 * Load the provider for a deferred service.
	 *
	 * @param  string  $service
	 * @return void
	 */
	protected function loadDeferredProvider($service)
	{
		$provider = $this->deferredServices[$service];

		// If the service provider has not already been loaded and registered we can
		// register it with the application and remove the service from this list
		// of deferred services, since it will already be loaded on subsequent.
		if ( ! isset($this->loadedProviders[$provider]))
		{
			$this->registerDeferredProvider($provider, $service);
		}
	}

	/**
	 * Register a deferred provider and service.
	 *
	 * @param  string  $provider
	 * @param  string  $service
	 * @return void
	 */
	public function registerDeferredProvider($provider, $service = null)
	{
		// Once the provider that provides the deferred service has been registered we
		// will remove it from our local list of the deferred services with related
		// providers so that this container does not try to resolve it out again.
		if ($service) unset($this->deferredServices[$service]);

		$this->register($instance = new $provider($this));

		if ( ! $this->booted)
		{
			$this->booting(function() use ($instance)
			{
				$instance->boot();
			});
		}
	}

	/**
	 * Resolve the given type from the container.
	 *
	 * (Overriding Container::make)
	 *
	 * @param  string  $abstract
	 * @param  array   $parameters
	 * @return mixed
	 */
	public function make($abstract, $parameters = array())
	{
		$abstract = $this->getAlias($abstract);

		if (isset($this->deferredServices[$abstract]))
		{
			$this->loadDeferredProvider($abstract);
		}

		return parent::make($abstract, $parameters);
	}

	/**
	 * Register a "before" application filter.
	 *
	 * @param  Closure|string  $callback
	 * @return void
	 */
	public function before($callback)
	{
		return $this['router']->before($callback);
	}

	/**
	 * Register an "after" application filter.
	 *
	 * @param  Closure|string  $callback
	 * @return void
	 */
	public function after($callback)
	{
		return $this['router']->after($callback);
	}

	/**
	 * Register a "finish" application filter.
	 *
	 * @param  Closure|string  $callback
	 * @return void
	 */
	public function finish($callback)
	{
		$this->finishCallbacks[] = $callback;
	}

	/**
	 * Register a "shutdown" callback.
	 *
	 * @param  callable  $callback
	 * @return void
	 */
	public function shutdown($callback = null)
	{
		if (is_null($callback))
		{
			$this->fireAppCallbacks($this->shutdownCallbacks);
		}
		else
		{
			$this->shutdownCallbacks[] = $callback;
		}
	}

	/**
	 * Register a function for determining when to use array sessions.
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function useArraySessions(Closure $callback)
	{
		$this->bind('session.reject', function() use ($callback)
		{
			return $callback;
		});
	}

	/**
	 * Determine if the application has booted.
	 *
	 * @return bool
	 */
	public function isBooted()
	{
		return $this->booted;
	}

	/**
	 * Boot the application's service providers.
	 *
	 * @return void
	 */
	public function boot()
	{
		if ($this->booted) return;

		array_walk($this->serviceProviders, function($p) { $p->boot(); });

		$this->bootApplication();
	}

	/**
	 * Boot the application and fire app callbacks.
	 *
	 * @return void
	 */
	protected function bootApplication()
	{
		// Once the application has booted we will also fire some "booted" callbacks
		// for any listeners that need to do work after this initial booting gets
		// finished. This is useful when ordering the boot-up processes we run.
		$this->fireAppCallbacks($this->bootingCallbacks);

		$this->booted = true;
		
		$this->fireAppCallbacks($this->bootedCallbacks);
	}

	/**
	 * Register a new boot listener.
	 *
	 * @param  mixed  $callback
	 * @return void
	 */
	public function booting($callback)
	{
		$this->bootingCallbacks[] = $callback;
	}

	/**
	 * Register a new "booted" listener.
	 *
	 * @param  mixed  $callback
	 * @return void
	 */
	public function booted($callback)
	{
		$this->bootedCallbacks[] = $callback;

		if ($this->isBooted()) $this->fireAppCallbacks(array($callback));
	}

	/**
	 * Run the application and send the response.
	 *
	 * @param  \Symfony\Component\HttpFoundation\Request  $request
	 * @return void
	 */
	public function run(SymfonyRequest $request = null)
	{
		$request = $request ?: $this['request'];

		$response = with($stack = $this->getStackedClient())->handle($request);

		$response->send();

		$stack->terminate($request, $response);
	}

	/**
	 * Get the stacked HTTP kernel for the application.
	 *
	 * @return  \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	protected function getStackedClient()
	{
		$sessionReject = $this->bound('session.reject') ? $this['session.reject'] : null;

		$client = with(new Builder)
						->push('Royalcms\Component\Cookie\Guard', $this['encrypter'])
						->push('Royalcms\Component\Cookie\Queue', $this['cookie']);
// 						->push('Royalcms\Component\Session\Middleware', $this['session'], $sessionReject);

		$this->mergeCustomMiddlewares($client);

		return $client->resolve($this);
	}

	/**
	 * Merge the developer defined middlewares onto the stack.
	 *
	 * @param  \Stack\Builder
	 * @return void
	 */
	protected function mergeCustomMiddlewares(Builder $stack)
	{
		foreach ($this->middlewares as $middleware)
		{
			list($class, $parameters) = array_values($middleware);

			array_unshift($parameters, $class);

			call_user_func_array(array($stack, 'push'), $parameters);
		}
	}

	/**
	 * Register the default, but optional middlewares.
	 *
	 * @return void
	 */
	protected function registerBaseMiddlewares()
	{
		$this->middleware('Royalcms\Component\HttpKernel\FrameGuard');
	}

	/**
	 * Add a HttpKernel middleware onto the stack.
	 *
	 * @param  string  $class
	 * @param  array  $parameters
	 * @return \Royalcms\Component\Foundation\Royalcms
	 */
	public function middleware($class, array $parameters = array())
	{
		$this->middlewares[] = compact('class', 'parameters');

		return $this;
	}

	/**
	 * Remove a custom middleware from the application.
	 *
	 * @param  string  $class
	 * @return void
	 */
	public function forgetMiddleware($class)
	{
		$this->middlewares = array_filter($this->middlewares, function($m) use ($class)
		{
			return $m['class'] != $class;
		});
	}

	/**
	 * Handle the given request and get the response.
	 *
	 * Provides compatibility with BrowserKit functional testing.
	 *
	 * @implements HttpKernelInterface::handle
	 *
	 * @param  \Symfony\Component\HttpFoundation\Request  $request
	 * @param  int   $type
	 * @param  bool  $catch
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handle(SymfonyRequest $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
	{
		try
		{
			$this->refreshRequest($request = Request::createFromBase($request));

			$this->boot();

			return $this->dispatch($request);
		}
		catch (\Exception $e)
		{
			if ($this->runningUnitTests()) throw $e;

			return $this['exception']->handleException($e);
		}
	}

	/**
	 * Handle the given request and get the response.
	 *
	 * @param  \Royalcms\Component\HttpKernel\Request  $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function dispatch(Request $request)
	{
		if ($this->isDownForMaintenance())
		{
			$response = $this['events']->until('royalcms.app.down');

			if ( ! is_null($response)) return $this->prepareResponse($response, $request);
		}

		if ($this->runningUnitTests() && ! $this['session']->isStarted())
		{
			$this['session']->start();
		}

		return $this['router']->dispatch($this->prepareRequest($request));
	}

	/**
	 * Terminate the request and send the response to the browser.
	 *
	 * @param  \Symfony\Component\HttpFoundation\Request  $request
	 * @param  \Symfony\Component\HttpFoundation\Response  $response
	 * @return void
	 */
	public function terminate(SymfonyRequest $request, SymfonyResponse $response)
	{
		$this->callFinishCallbacks($request, $response);

		$this->shutdown();
	}

	/**
	 * Refresh the bound request instance in the container.
	 *
	 * @param  \Royalcms\Component\HttpKernel\Request  $request
	 * @return void
	 */
	protected function refreshRequest(Request $request)
	{
		$this->instance('request', $request);

		Facade::clearResolvedInstance('request');
	}

	/**
	 * Call the "finish" callbacks assigned to the application.
	 *
	 * @param  \Symfony\Component\HttpFoundation\Request  $request
	 * @param  \Symfony\Component\HttpFoundation\Response  $response
	 * @return void
	 */
	public function callFinishCallbacks(SymfonyRequest $request, SymfonyResponse $response)
	{
		foreach ($this->finishCallbacks as $callback)
		{
			call_user_func($callback, $request, $response);
		}
	}

	/**
	 * Call the booting callbacks for the application.
	 *
	 * @return void
	 */
	protected function fireAppCallbacks(array $callbacks)
	{
		foreach ($callbacks as $callback)
		{
			call_user_func($callback, $this);
		}
	}

	/**
	 * Prepare the request by injecting any services.
	 *
	 * @param  \Royalcms\Component\HttpKernel\Request  $request
	 * @return \Royalcms\Component\HttpKernel\Request
	 */
	public function prepareRequest(Request $request)
	{
	    /*
	     * session驱动延加载
		if ( ! is_null($this['config']['session.driver']) && ! $request->hasSession())
		{
			$request->setSession($this['session']->driver());
		}
        */
		return $request;
	}

	/**
	 * Prepare the given value as a Response object.
	 *
	 * @param  mixed  $value
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function prepareResponse($value)
	{
		if ( ! $value instanceof SymfonyResponse) $value = new Response($value);

		return $value->prepare($this['request']);
	}

	/**
	 * Determine if the application is ready for responses.
	 *
	 * @return bool
	 */
	public function readyForResponses()
	{
		return $this->booted;
	}

	/**
	 * Determine if the application is currently down for maintenance.
	 *
	 * @return bool
	 */
	public function isDownForMaintenance()
	{
	    //@todo meta 目录创建
		return file_exists($this['path.storage'].'/meta/down');
	}

	/**
	 * Register a maintenance mode event listener.
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function down(Closure $callback)
	{
	    //@TODO
		$this['events']->listen('royalcms.app.down', $callback);
	}

	/**
	 * Throw an HttpException with the given data.
	 *
	 * @param  int     $code
	 * @param  string  $message
	 * @param  array   $headers
	 * @return void
	 *
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function abort($code, $message = '', array $headers = array())
	{
		if ($code == 404)
		{
			throw new NotFoundHttpException($message);
		}
		else
		{
			throw new HttpException($code, $message, null, $headers);
		}
	}

	/**
	 * Register a 404 error handler.
	 *
	 * @param  Closure  $callback
	 * @return void
	 */
	public function missing(Closure $callback)
	{
		$this->error(function(NotFoundHttpException $e) use ($callback)
		{
			return call_user_func($callback, $e);
		});
	}

	/**
	 * Register an application error handler.
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function error(Closure $callback)
	{
		$this['exception']->error($callback);
	}

	/**
	 * Register an error handler at the bottom of the stack.
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function pushError(Closure $callback)
	{
		$this['exception']->pushError($callback);
	}

	/**
	 * Register an error handler for fatal errors.
	 *
	 * @param  Closure  $callback
	 * @return void
	 */
	public function fatal(Closure $callback)
	{
		$this->error(function(FatalErrorException $e) use ($callback)
		{
			return call_user_func($callback, $e);
		});
	}

	/**
	 * Get the configuration loader instance.
	 *
	 * @return \Royalcms\Component\Config\LoaderInterface
	 */
	public function getConfigLoader()
	{
	    //@TODO
		return new FileLoader(new Filesystem, $this['path'].'/configs', $this['path.content'].'/configs');
	}

	/**
	 * Get the environment variables loader instance.
	 *
	 * @return \Royalcms\Component\Config\EnvironmentVariablesLoaderInterface
	 */
	public function getEnvironmentVariablesLoader()
	{
		return new FileEnvironmentVariablesLoader(new Filesystem, $this['path.base']);
	}

	/**
	 * Get the service provider repository instance.
	 *
	 * @return \Royalcms\Component\Foundation\ProviderRepository
	 */
	public function getProviderRepository()
	{
	    //@TODO
		$manifest = $this['config']['system.manifest'];
 
		return new ProviderRepository(new Filesystem, $manifest);
	}

	/**
	 * Get the service providers that have been loaded.
	 *
	 * @return array
	 */
	public function getLoadedProviders()
	{
		return $this->loadedProviders;
	}

	/**
	 * Set the application's deferred services.
	 *
	 * @param  array  $services
	 * @return void
	 */
	public function setDeferredServices(array $services)
	{
		$this->deferredServices = $services;
	}

	/**
	 * Determine if the given service is a deferred service.
	 *
	 * @param  string  $service
	 * @return bool
	 */
	public function isDeferredService($service)
	{
		return isset($this->deferredServices[$service]);
	}

	/**
	 * Get or set the request class for the application.
	 *
	 * @param  string  $class
	 * @return string
	 */
	public static function requestClass($class = null)
	{
		if ( ! is_null($class)) static::$requestClass = $class;

		return static::$requestClass;
	}

	/**
	 * Set the application request for the console environment.
	 *
	 * @return void
	 */
	public function setRequestForConsoleEnvironment()
	{
	    //@TODO
		$url = $this['config']->get('system.url', 'http://localhost');

		$parameters = array($url, 'GET', array(), array(), array(), $_SERVER);

		$this->refreshRequest(static::onRequest('create', $parameters));
	}

	/**
	 * Call a method on the default request class.
	 *
	 * @param  string  $method
	 * @param  array  $parameters
	 * @return mixed
	 */
	public static function onRequest($method, $parameters = array())
	{
		return forward_static_call_array(array(static::requestClass(), $method), $parameters);
	}

	/**
	 * Get the current application locale.
	 *
	 * @return string
	 */
	public function getLocale()
	{
		return $this['config']->get('system.locale');
	}

	/**
	 * Set the current application locale.
	 *
	 * @param  string  $locale
	 * @return void
	 */
	public function setLocale($locale)
	{
		$this['config']->set('system.locale', $locale);

		$this['translator']->setLocale($locale);

		$this['events']->fire('locale.changed', array($locale));
	}

	/**
	 * Register the core class aliases in the container.
	 *
	 * @return void
	 */
	public function registerCoreContainerAliases()
	{
	    //@TODO
		$aliases = array(
			'royalcms'       => 'Royalcms\Component\Foundation\Royalcms',
			'royalcmd'       => 'Royalcms\Component\Console\Royalcmd',
		    'config'         => 'Royalcms\Component\Config\Repository',
		    'files'          => 'Royalcms\Component\Filesystem\Filesystem',
		    'filesystem'     => 'Royalcms\Component\Filesystem\FilesystemManager',
		    'filesystem.disk'        => 'Royalcms\Component\Support\Contracts\Filesystem\Filesystem',
		    'filesystem.cloud'       => 'Royalcms\Component\Support\Contracts\Filesystem\Cloud',
		    'filesystemkernel'       => 'Royalcms\Component\FilesystemKernel\FilesystemManager',
		    'filesystemkernel.disk'  => 'Royalcms\Component\FilesystemKernel\FilesystemBase',
		    'filesystemkernel.cloud' => 'Royalcms\Component\FilesystemKernel\FilesystemBase',
		    'cache'          => 'Royalcms\Component\Cache\CacheManager',
		    'cache.store'    => 'Royalcms\Component\Cache\Repository',
		    'log'            => 'Royalcms\Component\Log\Writer',
		    'log.store'      => 'Royalcms\Component\Log\FileStore',
		    'error'          => 'Royalcms\Component\Error\Error',
		    'cookie'         => 'Royalcms\Component\Cookie\CookieJar',
			'session'        => 'Royalcms\Component\Session\SessionManager',
			'session.store'  => 'Royalcms\Component\Session\Store',
			'request'        => 'Royalcms\Component\HttpKernel\Request',
			'response'       => 'Royalcms\Component\HttpKernel\Response',
			'view'           => 'Royalcms\Component\View\Environment',
			'events'         => 'Royalcms\Component\Events\Dispatcher',
			'hook'           => 'Royalcms\Component\Hook\Hooks',
			'phpinfo'        => 'Royalcms\Component\Foundation\Phpinfo',
			'router'         => 'Royalcms\Component\Routing\Router',
			'redirect'       => 'Royalcms\Component\Routing\Redirector',
			'url'            => 'Royalcms\Component\Routing\UrlGenerator',
			'translator'     => 'Royalcms\Component\Translation\Translator',
			'package'        => 'Royalcms\Component\Package\PackageManager',
			
			
			'encrypter'      => 'Royalcms\Component\Encryption\Encrypter',
			'db'             => 'Royalcms\Component\Database\DatabaseManager',
			'hash'           => 'Royalcms\Component\Hashing\HasherInterface',
			'mailer'         => 'Royalcms\Component\Mail\Mailer',
			'paginator'      => 'Royalcms\Component\Pagination\Environment',
			'queue'          => 'Royalcms\Component\Queue\QueueManager',
			'redis'          => 'Royalcms\Component\Redis\Database',
			'remote'         => 'Royalcms\Component\Remote\RemoteManager',
			'validator'      => 'Royalcms\Component\Validation\Factory',
		    
		    
// 			'auth'           => 'Royalcms\Component\Auth\AuthManager',
// 			'auth.reminder'  => 'Royalcms\Component\Auth\Reminders\PasswordBroker',
// 			'auth.reminder.repository' => 'Royalcms\Component\Auth\Reminders\ReminderRepositoryInterface',
// 			'blade.compiler' => 'Royalcms\Component\View\Compilers\BladeCompiler',

// 			'form'           => 'Royalcms\Component\Html\FormBuilder',
			
// 			'html'           => 'Royalcms\Component\Html\HtmlBuilder',
			
			
		);

		foreach ($aliases as $key => $alias)
		{
			$this->alias($key, $alias);
		}
	}

	/**
	 * Dynamically access application services.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this[$key];
	}

	/**
	 * Dynamically set application services.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this[$key] = $value;
	}
	
	/**
	 * 框架启动
	 */
    public function start()
    {        
        $this->run();
    }

}
