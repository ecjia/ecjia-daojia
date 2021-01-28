<?php

namespace Royalcms\Component\Uploader\Contracts;

use Closure;

interface Uploader
{
    /**
     * Specify the file storage where the file will be uploaded.
     *
     * @param  string  $disk
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function uploadTo($disk);

    /**
     * Specify the folder where the file will be stored.
     *
     * @param  string  $folder
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function toFolder($folder);

    /**
     * Rename the uploaded file to given new name.
     *
     * @param  string  $newName
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function renameTo($newName);

    /**
     * Set the visibility of the file.
     *
     * @param  string  $visibility
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function setVisibility($visibility);

    /**
     * Upload the file on a file storage.
     *
     * @param  string  $file
     * @param  \Closure|null $callback
     * @return bool
     */
    public function upload($file, Closure $callback = null);
}
