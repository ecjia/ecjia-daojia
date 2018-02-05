<?php

namespace Royalcms\Component\Uploader\Providers;

use Royalcms\Component\Uploader\Contracts\Provider;
use Royalcms\Component\Uploader\Support\FileSetter;

class LocalProvider implements Provider
{
    use FileSetter;

    /**
     * Returns whether the file is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return file_exists($this->file);
    }

    /**
     * Get the file's contents.
     *
     * @return resource|string
     */
    public function getContents()
    {
        return fopen($this->file, 'r');
    }

    /**
     * Returns the extension of the file.
     *
     * @return string
     */
    public function getExtension()
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }
}
