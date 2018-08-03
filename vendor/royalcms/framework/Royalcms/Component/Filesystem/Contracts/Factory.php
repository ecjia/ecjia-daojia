<?php

namespace Royalcms\Component\Filesystem\Contracts;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Filesystem\Contracts\Filesystem
     */
    public function disk($name = null);
}
