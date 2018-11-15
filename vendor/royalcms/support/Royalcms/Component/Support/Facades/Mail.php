<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Mail\Mailer
 */
class Mail extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mailer';
    }
}
