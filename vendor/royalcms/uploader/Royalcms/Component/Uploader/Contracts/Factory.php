<?php

namespace Royalcms\Component\Uploader\Contracts;

interface Factory
{
    /**
     * Specify where the file is provided.
     *
     * @param  string|null  $provider
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function from($provider = null);
}
