<?php namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Log\FileStore
 */
class Logger extends Facade 
{
    /**
     * All LOG are required to register here
     * 
     * @var string
     */
    const LOG_ERROR = 'error';
    const LOG_SQL = 'sql';
    const LOG_WARNING = 'warning';
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'log.store';
    }

}