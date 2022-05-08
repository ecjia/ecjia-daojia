<?php

namespace Ecjia\System\Listeners;


use Illuminate\Database\Events\QueryExecuted;
use RC_Logger;

class DatabaseQueryListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        if (config('system.debug')) {

            $query = $event->sql;
            $bindings = $event->bindings;
            $time = $event->time;

            $bindings = collect($bindings)->map(function ($item) {
                if ($item instanceof \DateTime) {
                    return $item->format('Y-m-d H:i:s');
                }
                return $item;
            })->toArray();

            if (empty($bindings)) {
                $sql = $query;
                RC_Logger::getLogger('sql')->info('sql:'.$sql);
            }
            else {
                $query = str_replace('?', '"'.'%s'.'"', $query);
                $sql = vsprintf($query, $bindings);
                RC_Logger::getLogger('sql')->info('sql:'.$sql);
            }
        }

    }

}