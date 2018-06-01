<?php 

namespace Royalcms\Component\Websocket;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Websocket\Console\Commands\StartServer;
use Royalcms\Component\Websocket\Console\Commands\WebsocketWorker;

class WebsocketServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    
    protected $commands = [
		'StartServer' => 'command.websocket.startserver',
        'WebsocketWorker' => 'command.websocket.websocketworker'
	];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('royalcms/websocket');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register commands.
        $this->registerCommands();

        require __DIR__ . '/helper.php';
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
	protected function registerStartServerCommand()
	{
	    $this->royalcms->singleton('command.websocket.startserver', function ($royalcms) {
	        return new StartServer();
	    });
	}
	
	protected function registerWebSocketWorkerCommand()
	{
	    $this->royalcms->singleton('command.websocket.websocketworker', function ($royalcms) {
	        return new WebsocketWorker();
	    });
	}

	
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.websocket.startserver', 'command.websocket.websocketworker'];
    }

}

// end