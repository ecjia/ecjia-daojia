<?php

namespace Royalcms\Component\Console\Scheduling;

use Royalcms\Component\Console\Command;

class ScheduleListCommand extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'schedule:list';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List when scheduled commands are executed.';
    
    /**
	 * The schedule instance.
	 *
	 * @var \Royalcms\Component\Console\Scheduling\Schedule
	 */
    protected $schedule;
    
    /**
	 * Create a new command instance.
	 *
	 * @param  \Royalcms\Component\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
    public function __construct(Schedule $schedule)
    {
        parent::__construct();
    
        $this->schedule = $schedule;
    }
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {        
        $events = array_map(function ($event) {
            return array(
                'cron' => $event->expression,
                'command' => static::fixupCommand($event->command),
            );
        }, $this->schedule->events());

        $this->table(
            array('Cron', 'Command'),
            $events
        );
    }
    
    /**
     * If it's an artisan command, strip off the PHP
     *
     * @param $command
     * @return string
     */
    protected static function fixupCommand($command)
    {
        $parts = explode(' ', $command);
        if (count($parts) > 2 && $parts[1] === "'royalcms'") {
            array_shift($parts);
        }
    
        return implode(' ', $parts);
    }
}

