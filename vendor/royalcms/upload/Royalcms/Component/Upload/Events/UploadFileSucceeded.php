<?php

namespace Royalcms\Component\Upload\Events;

use Royalcms\Component\Upload\UploadResult;

class UploadFileSucceeded
{
    /**
     * @var UploadResult
     *
     */
    public $fileinfo;

    /**
     * UploadFileSucceeded constructor.
     * @param UploadResult $fileinfo
     */
    public function __construct(UploadResult $fileinfo)
    {
        $this->fileinfo = $fileinfo;
    }
}
