<?php

namespace Royalcms\Component\View\Engines;

use Royalcms\Component\Contracts\View\Engine as EngineContract;

class FileEngine implements EngineContract
{
    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        return file_get_contents($path);
    }
}
