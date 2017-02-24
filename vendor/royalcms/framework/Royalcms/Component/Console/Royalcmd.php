<?php namespace Royalcms\Component\Console;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Royalcms\Component\Console\Scheduling\Schedule;
use Royalcms\Component\Console\ClosureCommand;
use Closure;

class Royalcmd extends \Symfony\Component\Console\Application {

	/**
	 * The exception handler instance.
	 *
	 * @var \Royalcms\Component\Exception\Handler
	 */
	protected $exceptionHandler;

	/**
	 * The Royalcms application instance.
	 *
	 * @var \Royalcms\Component\Foundation\Royalcms 
	 */
	protected $royalcms;
	
	/**
	 * The Royalcmd commands provided by the application.
	 *
	 * @var array
	 */
	protected $commands = array();

	/**
	 * Create and boot a new Console application.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @return \Royalcms\Component\Console\Royalcmd
	 */
	public static function start($royalcms)
	{
		return static::make($royalcms)->boot();
	}

	/**
	 * Create a new Console application.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @return \Royalcms\Component\Console\Royalcmd
	 */
	public static function make($royalcms)
	{
		$royalcms->boot();

		$console = with($console = new static('Royalcms Framework', $royalcms::VERSION))
								->setRoyalcms($royalcms)
								->setExceptionHandler($royalcms['exception'])
								->setAutoExit(false);

		$royalcms->instance('royalcmd', $console);

		return $console;
	}

	/**
	 * Boot the Console application.
	 *
	 * @return \Royalcms\Component\Console\Royalcmd
	 */
	public function boot()
	{
		if (file_exists($this->royalcms['path.system'].'/start/command.php')) {
			require $this->royalcms['path.system'].'/start/command.php';
		}

		// If the event dispatcher is set on the application, we will fire an event
		// with the Artisan instance to provide each listener the opportunity to
		// register their commands on this application before it gets started.
		if (isset($this->royalcms['events']))
		{
			$this->royalcms['events']
					->fire('royalcmd.start', array($this));
		}
		
		$royalcmd = $this;
		$this->royalcms->booted(function () use ($royalcmd) {
		    $royalcmd->defineConsoleSchedule();
		});

		return $this;
	}
	
	/**
	 * Define the application's command schedule.
	 *
	 * @return void
	 */
	public function defineConsoleSchedule()
	{
	    $schedule = $this->royalcms['schedule'];
	    $this->schedule($schedule);
	}
	
	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Royalcms\Component\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
	    //
	}
	
	/**
	* Register the Closure based commands for the application.
	*
	* @return void
	*/
	protected function commands()
	{
	   //
	}
	
	/**
	 * Register a Closure based command with the application.
	 *
	 * @param  string  $signature
	 * @param  Closure  $callback
	 * @return \Royalcms\Component\Console\ClosureCommand
	 */
	public function command($signature, Closure $callback)
	{
	    $command = new ClosureCommand($signature, $callback);
	
	    $this->royalcms['events']->listen('royalcmd.start', function ($royalcmd) use ($command) {
	        $royalcmd->add($command);
	    });
	
        return $command;
	}
	
	/**
	 * Register the given command with the console application.
	 *
	 * @param  \Symfony\Component\Console\Command\Command  $command
	 * @return void
	 */
	public function registerCommand($command)
	{
	    $this->add($command);
	}

	/**
	 * Run an Royalcmd console command by name.
	 *
	 * @param  string  $command
	 * @param  array   $parameters
	 * @param  \Symfony\Component\Console\Output\OutputInterface  $output
	 * @return void
	 */
	public function call($command, array $parameters = array(), OutputInterface $output = null)
	{
		$parameters['command'] = $command;

		// Unless an output interface implementation was specifically passed to us we
		// will use the "NullOutput" implementation by default to keep any writing
		// suppressed so it doesn't leak out to the browser or any other source.
		$output = $output ?: new NullOutput;

		$input = new ArrayInput($parameters);

		return $this->find($command)->run($input, $output);
	}

	/**
	 * Add a command to the console.
	 *
	 * @param  \Symfony\Component\Console\Command\Command  $command
	 * @return \Symfony\Component\Console\Command\Command
	 */
	public function add(SymfonyCommand $command)
	{
		if ($command instanceof Command)
		{
			$command->setRoyalcms($this->royalcms);
		}

		return $this->addToParent($command);
	}

	/**
	 * Add the command to the parent instance.
	 *
	 * @param  \Symfony\Component\Console\Command\Command  $command
	 * @return \Symfony\Component\Console\Command\Command
	 */
	protected function addToParent(SymfonyCommand $command)
	{
		return parent::add($command);
	}

	/**
	 * Add a command, resolving through the application.
	 *
	 * @param  string  $command
	 * @return \Symfony\Component\Console\Command\Command
	 */
	public function resolve($command)
	{
		return $this->add($this->royalcms[$command]);
	}

	/**
	 * Resolve an array of commands through the royalcmd.
	 *
	 * @param  array|dynamic  $commands
	 * @return void
	 */
	public function resolveCommands($commands)
	{
		$commands = is_array($commands) ? $commands : func_get_args();

		foreach ($commands as $command)
		{
			$this->resolve($command);
		}
	}

	/**
	 * Get the default input definitions for the royalcmd.
	 *
	 * @return \Symfony\Component\Console\Input\InputDefinition
	 */
	protected function getDefaultInputDefinition()
	{
		$definition = parent::getDefaultInputDefinition();

		$definition->addOption($this->getEnvironmentOption());

		return $definition;
	}

	/**
	 * Get the global environment option for the definition.
	 *
	 * @return \Symfony\Component\Console\Input\InputOption
	 */
	protected function getEnvironmentOption()
	{
		$message = 'The environment the command should run under.';

		return new InputOption('--env', null, InputOption::VALUE_OPTIONAL, $message);
	}

	/**
	 * Render the given exception.
	 *
	 * @param  \Exception  $e
	 * @param  \Symfony\Component\Console\Output\OutputInterface  $output
	 * @return void
	 */
	public function renderException($e, $output)
	{
		// If we have an exception handler instance, we will call that first in case
		// it has some handlers that need to be run first. We will pass "true" as
		// the second parameter to indicate that it's handling a console error.
		if (isset($this->exceptionHandler))
		{
			$this->exceptionHandler->handleConsole($e);
		}

		parent::renderException($e, $output);
	}

	/**
	 * Set the exception handler instance.
	 *
	 * @param  \Royalcms\Component\Exception\Handler  $handler
	 * @return \Royalcms\Component\Console\Royalcmd
	 */
	public function setExceptionHandler($handler)
	{
		$this->exceptionHandler = $handler;

		return $this;
	}

	/**
	 * Set the Laravel application instance.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @return \Royalcms\Component\Console\Royalcmd
	 */
	public function setRoyalcms($royalcms)
	{
		$this->royalcms = $royalcms;

		return $this;
	}

	/**
	 * Set whether the Console app should auto-exit when done.
	 *
	 * @param  bool  $boolean
	 * @return \Royalcms\Component\Console\Royalcmd
	 */
	public function setAutoExit($boolean)
	{
		parent::setAutoExit($boolean);

		return $this;
	}

}
