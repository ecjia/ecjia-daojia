<?php namespace Royalcms\Component\Console;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Console\Scheduling\ScheduleRunCommand;
use Royalcms\Component\Console\Scheduling\ScheduleListCommand;
use Royalcms\Component\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider {

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
	    $this->registerSchedule();
		
	    $this->registerScheduleRunCommand();
		
		$this->registerScheduleListCommand();
	}
	
	public function registerSchedule() {
	    $this->royalcms->bindShared('schedule', function($royalcms)
	    {
	        return new Schedule();
	    });
	}
	
	public function registerScheduleRunCommand() 
	{
	    $this->royalcms->bindShared('command.schedule.run', function($royalcms)
	    {
	        return new ScheduleRunCommand($royalcms['schedule']);
	    });
	    $this->commands('command.schedule.run');
	}
	
	public function registerScheduleListCommand()
	{
	    $this->royalcms->bindShared('command.schedule.list', function($royalcms)
	    {
	        return new ScheduleListCommand($royalcms['schedule']);
	    });
	    $this->commands('command.schedule.list');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
		    'schedule',
			'command.schedule.run',
		    'command.schedule.list',
		);
	}

}
