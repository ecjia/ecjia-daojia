<?php namespace Royalcms\Component\Console\Scheduling;

use Royalcms\Component\Foundation\Royalcms;
use Royalcms\Component\Support\Facades\Config;

class Schedule {

	/**
	 * All of the events on the schedule.
	 *
	 * @var array
	 */
	protected $events = array();

	/**
	 * Add a new callback event to the schedule.
	 *
	 * @param  string  $callback
	 * @param  array   $parameters
	 * @return \Royalcms\Component\Console\Scheduling\Event
	 */
	public function call($callback, array $parameters = array())
	{
		$this->events[] = $event = new CallbackEvent($callback, $parameters);

		return $event;
	}

	/**
	 * Add a new Artisan command event to the schedule.
	 *
	 * @param  string  $command
	 * @return \Royalcms\Component\Console\Scheduling\Event
	 */
	public function command($command)
	{
	    // $this->exec(PHP_BINARY.' royalcmd '.$command);
	    $shell_bin = Config::get('system.binary', 'royalcmd');
		return $this->exec(PHP_BINARY.' '.$shell_bin.' '.$command);
	}

	/**
	 * Add a new command event to the schedule.
	 *
	 * @param  string  $command
	 * @return \Royalcms\Component\Console\Scheduling\Event
	 */
	public function exec($command)
	{
		$this->events[] = $event = new Event($command);
		
		return $event;
	}

	/**
	 * Get all of the events on the schedule.
	 *
	 * @return array
	 */
	public function events()
	{
		return $this->events;
	}

	/**
	 * Get all of the events on the schedule that are due.
	 *
	 * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
	 * @return array
	 */
	public function dueEvents(Royalcms $royalcms)
	{
		return array_filter($this->events, function($event) use ($royalcms)
		{
			return $event->isDue($royalcms);
		});
	}

}
