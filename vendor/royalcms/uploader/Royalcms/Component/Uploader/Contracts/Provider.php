<?php

namespace Royalcms\Component\Uploader\Contracts;

interface Provider
{
    /**
     * Returns whether the file is valid.
     *
     * @return bool
     */
    public function isValid();

    /**
     * Get the file's contents.
     *
     * @return resource|string
     */
    public function getContents();

    /**
     * Returns the extension of the file.
     *
     * @return string
     */
    public function getExtension();

    /**
     * Set where the file is located.
     *
     * @param  string  $file
     * @return void
     */
    public function setFile($file);
}
