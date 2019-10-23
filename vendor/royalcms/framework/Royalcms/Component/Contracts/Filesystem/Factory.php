<?php

namespace Royalcms\Component\Contracts\Filesystem;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
     */
    public function disk($name = null);
}
