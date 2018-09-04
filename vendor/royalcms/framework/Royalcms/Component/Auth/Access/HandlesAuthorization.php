<?php

namespace Royalcms\Component\Auth\Access;

trait HandlesAuthorization
{
    /**
     * Create a new access response.
     *
     * @param  string|null  $message
     * @return \Royalcms\Component\Auth\Access\Response
     */
    protected function allow($message = null)
    {
        return new Response($message);
    }

    /**
     * Throws an unauthorized exception.
     *
     * @param  string  $message
     * @return void
     *
     * @throws \Royalcms\Component\Auth\Access\UnauthorizedException
     */
    protected function deny($message = 'This action is unauthorized.')
    {
        throw new UnauthorizedException($message);
    }
}
