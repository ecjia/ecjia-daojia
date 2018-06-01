<?php 

namespace Royalcms\Component\Remote;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Remote\Console\TailCommand;

class RemoteServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;
	
	/**
	 * The commands to be registered.
	 *
	 * @var array
	 */
	protected $commands = [
	    'Tail' => 'command.tail',
	];
	
	
	public function boot()
	{
	    $this->package('royalcms/remote');
	    
	    $this->registerCommands();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->royalcms->singleton('remote', function($royalcms)
		{
			return new RemoteManager($royalcms);
		});
	}
	
	/**
	 * Register the commands.
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
	    foreach (array_keys($this->commands) as $command) {
	        $method = "register{$command}Command";
	        call_user_func_array([$this, $method], []);
	    }
	    $this->commands(array_values($this->commands));
	}
	
	/**
	 * Register the command.
	 *
	 * @return void
	 */
	protected function registerTailCommand()
	{
	    $this->royalcms->singleton('command.tail', function ($royalcms) {
	        return new TailCommand();
	    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('remote');
	}

}
