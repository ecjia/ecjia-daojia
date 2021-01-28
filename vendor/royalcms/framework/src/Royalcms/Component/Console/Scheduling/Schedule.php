<?php

namespace Royalcms\Component\Console\Scheduling;

use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Illuminate\Support\ProcessUtils;
use Royalcms\Component\Contracts\Foundation\Royalcms;
use Symfony\Component\Process\PhpExecutableFinder;
use Illuminate\Console\Scheduling\Schedule as LaravelSchedule;

class Schedule extends LaravelSchedule
{
//    /**
//     * All of the events on the schedule.
//     *
//     * @var array
//     */
//    protected $events = [];

//    /**
//     * Add a new callback event to the schedule.
//     *
//     * @param  string  $callback
//     * @param  array   $parameters
//     * @return \Royalcms\Component\Console\Scheduling\Event
//     */
//    public function call($callback, array $parameters = [])
//    {
//        $this->events[] = $event = new CallbackEvent($callback, $parameters);
//
//        return $event;
//    }

    /**
     * Add a new Artisan command event to the schedule.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return \Royalcms\Component\Console\Scheduling\Event
     */
    public function command($command, array $parameters = [])
    {
        if (class_exists($command)) {
            $command = Container::getInstance()->make($command)->getName();
        }

        return $this->exec(
            \Royalcms\Component\Console\Royalcms::formatCommandString($command), $parameters
        );
    }

//    /**
//     * Add a new command event to the schedule.
//     *
//     * @param  string  $command
//     * @param  array  $parameters
//     * @return \Royalcms\Component\Console\Scheduling\Event
//     */
//    public function exec($command, array $parameters = [])
//    {
//        if (count($parameters)) {
//            $command .= ' '.$this->compileParameters($parameters);
//        }
//
//        $this->events[] = $event = new Event($command);
//
//        return $event;
//    }

//    /**
//     * Compile parameters for a command.
//     *
//     * @param  array  $parameters
//     * @return string
//     */
//    protected function compileParameters(array $parameters)
//    {
//        return collect($parameters)->map(function ($value, $key) {
//            return is_numeric($key) ? $value : $key.'='.(is_numeric($value) ? $value : ProcessUtils::escapeArgument($value));
//        })->implode(' ');
//    }

//    /**
//     * Get all of the events on the schedule.
//     *
//     * @return array
//     */
//    public function events()
//    {
//        return $this->events;
//    }

//    /**
//     * Get all of the events on the schedule that are due.
//     *
//     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
//     * @return array
//     */
//    public function dueEvents(Royalcms $royalcms)
//    {
//        return array_filter($this->events, function ($event) use ($royalcms) {
//            return $event->isDue($royalcms);
//        });
//    }
}
